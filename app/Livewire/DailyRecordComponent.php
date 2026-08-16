<?php

namespace App\Livewire;


use App\Models\Area;
use App\Models\Bed;
use App\Models\DailyRecord;
use App\Models\Diet;
use App\Models\Patient;

use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;


class DailyRecordComponent extends Component
{
    use WithPagination;

    public $bed_id, $patient_id, $fecha_registro, $desayuno,$am10,$pm4, $almuerzo, $cena, $indicaciones, $diagnostico;
    public $isOpen = false;
    public $record_id;
    public $search = '';
    public $selectedDate, $selectedArea;

    public $editingRow = null;
    public $editedData = [];

    public $diets;
    public $searchPatient = '';
    public $filteredPatients = [];
    public $patients = [];
//dietas variables
    public int|null $registro_id = null; // Asegúrate de que está definido
    public bool $showDietModal = false;
    public string $currentMeal = '';
    public ?int $registroId = null;
    public $selectedDiets = []; // Array para almacenar los IDs de las dietas seleccionadas
    public $mealDiets = [];
    public ?int $dietModalRecordId = null; // Array asociativo para guardar las dietas por comida

    public $dietPresets = [];
//--Variables para mover pacientes
    public bool $isMovePatientModalOpen = false;
    public int $recordIdToMove = 0;
    public $destinationBeds = [];
    public $selectedDestinationBedId = null;
    public $selectedBedCode = null;
    public $selectedAreaName = null;
    public bool $applyToOtherMeals = false;
    // modal dieta nueva
    public bool $showAllDietsModal = false;

    protected $rules = [
        'bed_id' => 'required|exists:beds,id',
        'patient_id' => 'nullable|exists:patients,id',
        'fecha_registro' => 'required|date',
        'desayuno' => 'nullable',
        'am10' => 'nullable',
        'almuerzo' => 'nullable',
        'pm4' => 'nullable',
        'cena' => 'nullable',
        'indicaciones' => 'nullable|string',
        'diagnostico' => 'nullable|string',
    ];



    //mount
    public function mount($registroId = null)
    {
        $this->showDietModal = false;
        $this->diets = Diet::all();
        $this->patients = Patient::all();
        $this->selectedDate = now()->toDateString(); // Fecha actual por defecto
        $this->selectedArea = ''; // Ninguna área seleccionada por defecto
        $this->generateDailyRecords();
        $this->selectedArea = request()->query('area', '');

        $this->registroId = $registroId;
        if ($this->registroId) {
            $record = DailyRecord::find($this->registroId);
            $this->mealDiets['desayuno'] = $record->desayuno ?? [];
            $this->mealDiets['am10'] = $record->am10 ?? [];
            $this->mealDiets['almuerzo'] = $record->almuerzo ?? [];
            $this->mealDiets['pm4'] = $record->pm4 ?? [];
            $this->mealDiets['cena'] = $record->cena ?? [];
        }

        // Define tus presets aquí. Cada preset tiene un nombre para el botón y un array de IDs de dietas.
        $this->dietPresets = [
            [
                'name' => 'Básica (IDs: 1, 5, 17)', // Nombre descriptivo para el botón
                'diet_ids' => [1, 5, 17]          // Los IDs de las dietas que componen este preset
            ],
            [
                'name' => 'Post-Operatorio Ligero',
                'diet_ids' => [3, 7] // Ejemplo con otros IDs
            ],
        ];
    }

//--------------------------------- seleccionar Dietas- I-------------------------------------------------------
    public function openDietModal($recordId, $meal)
    {
        $this->dietModalRecordId = $recordId;
        $this->currentMeal = $meal;
        $this->selectedDiets = []; // Resetea antes de cargar

        $record = DailyRecord::find($this->dietModalRecordId);

        if ($record) {
            $mealDietData = $record->{$this->currentMeal}; // Ej: $record->desayuno (que es un string "Dieta A+ Dieta B")

            if (!empty($mealDietData) && is_string($mealDietData)) {
                $dietNamesArray = explode(' ', $mealDietData);
                $trimmedDietNamesArray = array_map('trim', $dietNamesArray);
                // Filtrar nombres vacíos que podrían surgir de múltiples espacios o un delimitador al final
                $actualDietNames = array_filter($trimmedDietNamesArray, function ($value) {
                    return !is_null($value) && $value !== '';
                });

                if (!empty($actualDietNames)) {
                    // Convertir nombres de dietas a IDs para preseleccionar en el modal
                    $this->selectedDiets = Diet::whereIn('name', $actualDietNames)->pluck('id')->toArray();
                }
            }
        }
        $this->showDietModal = true;
    }



    public function saveDietSelection()
    {
        if (is_null($this->dietModalRecordId) || empty($this->currentMeal)) {
            session()->flash('error', 'Error: No se ha especificado el registro o la comida para guardar la dieta.');
            $this->showDietModal = false;
            return;
        }

        $selectedDietObjects = Diet::whereIn('id', $this->selectedDiets)->get();
        $selectedDietNames = $selectedDietObjects->pluck('name')->toArray();
        $dietString = implode(' ', $selectedDietNames);

        $record = DailyRecord::find($this->dietModalRecordId);
        if ($record) {
            $record->update([
                $this->currentMeal => $dietString ?: null,
            ]);

            // Actualizar editedData para reflejar el cambio en el textarea
            if ($this->editingRow == $this->dietModalRecordId) {
                $this->editedData[$this->currentMeal] = $dietString ?: null;
            }

            if ($this->applyToOtherMeals) {
                $mealsToUpdate = ['desayuno', 'almuerzo', 'cena'];
                foreach ($mealsToUpdate as $meal) {
                    if ($meal !== $this->currentMeal) {
                        $record->update([
                            $meal => $dietString ?: null,
                        ]);
                        // Actualizar también editedData para los otros horarios si la fila está en edición
                        if ($this->editingRow == $this->dietModalRecordId) {
                            $this->editedData[$meal] = $dietString ?: null;
                        }
                    }
                }
                session()->flash('message', 'Dietas guardadas y aplicadas a otros horarios.');
            } else {
                session()->flash('message', 'Dieta actualizada para ' . ucfirst($this->currentMeal));
            }

            $this->showDietModal = false;
            $this->applyToOtherMeals = false; // Resetear la propiedad después de guardar
        } else {
            session()->flash('error', 'Registro no encontrado para actualizar dietas.');
        }
    }

//--------------------------------- seleccionar Dietas--END------------------------------------------------------

    public function updatedSearchPatient()
    {
        $query = Patient::query();
        // Verifica que haya más de dos caracteres antes de filtrar
        if (strlen($this->searchPatient) > 2) {
            $this->patients = Patient::where('nombre', 'like', '%' . $this->searchPatient . '%')
                ->orWhere('apellido', 'like', '%' . $this->searchPatient . '%')
                ->limit()
                ->get();

        } else {
            $this->patients = [];
            $patients = $query->orderBy('id', 'desc')->paginate(5); // Limpia la lista si la búsqueda tiene menos de tres caracteres
        }
    }

    public function selectPatient($patientId)
    {
        $selectedPatient = Patient::find($patientId);
        if ($selectedPatient) {
            // Asigna el nombre completo al campo de búsqueda
            $this->searchPatient = $selectedPatient->nombre . ' ' . $selectedPatient->apellido;
            // Asigna el ID del paciente al campo que lo necesita
            $this->editedData['patient_id'] = $patientId;
            $this->patients = []; // Limpia la lista de sugerencias después de seleccionar
        }
    }



//-------------------------------------------funcion de edicion--------------------------------------------------
    public function editRow($id)
    {
        $this->editingRow = $id;
        $record = DailyRecord::findOrFail($id);
        $this->editedData = $record->toArray();
    }

    public function saveRow()
    {
        // Verifica que haya una fila en edición
        if (!$this->editingRow|| empty($this->editedData)) {
            session()->flash('error', 'No hay fila en edición.');
            return;
        }

        // Validamos los datos antes de guardar
        $this->validate([
            'editedData.bed_id' => 'required|exists:beds,id',
            'editedData.patient_id' => 'nullable|exists:patients,id',
            'editedData.fecha_registro' => 'required|date',
            'editedData.desayuno' => 'nullable',
            'editedData.am10' => 'nullable',
            'editedData.almuerzo' => 'nullable',
            'editedData.pm4' => 'nullable',
            'editedData.cena' => 'nullable',
            'editedData.indicaciones' => 'nullable|string',
            'editedData.diagnostico' => 'nullable|string',
        ]);


        // Obtenemos el registro de la base de datos
        $record = DailyRecord::find($this->editingRow);

        if ($record) {
            // Actualizamos solo los campos que se han editado
            $record->update([
                'bed_id' => $this->editedData['bed_id'] ?? $record->bed_id,
                'patient_id' => $this->editedData['patient_id'] ?? $record->patient_id,
                'fecha_registro' => $this->editedData['fecha_registro'] ?? $record->fecha_registro,
                'desayuno' => $this->editedData['desayuno'] ?? $record->desayuno,
                'am10' => $this->editedData['am10'] ?? $record->am10,
                'almuerzo' => $this->editedData['almuerzo'] ?? $record->almuerzo,
                'pm4' => $this->editedData['pm4'] ?? $record->pm4,
                'cena' => $this->editedData['cena'] ?? $record->cena,
                'indicaciones' => $this->editedData['indicaciones'] ?? $record->indicaciones,
                'diagnostico' => $this->editedData['diagnostico'] ?? $record->diagnostico,
            ]);

            // Reseteamos la fila en edición
            $this->editingRow = null;
            $this->editedData = [];

            // Mensaje de éxito
            session()->flash('message', 'Registro actualizado correctamente.');
        }
    }


    public function cancelEdit()
    {
        $this->editingRow = null;
    }
//-------------------------------------------funcion de edicion--------------------------------------------------
//-------------------------------------limpiarfilas I------------------------------------------------------------
    public function clearRowFields(int $recordId)
    {
        $record = DailyRecord::find($recordId);

        if ($record) {
            // Actualizar directamente en la base de datos solo los campos que queremos limpiar
            $record->update([
                'patient_id' => null,
                'desayuno' => null,
                'am10' => null,
                'almuerzo' => null,
                'pm4' => null,
                'cena' => null,
                'indicaciones' => null,
                'diagnostico' => null,
            ]);

            // Opcional: Mensaje de confirmación (puedes descomentarlo si quieres un mensaje rápido)
            // session()->flash('message', 'Campos limpiados correctamente.');

            // Recargar los registros para reflejar los cambios en la tabla (opcional, pero útil para asegurar la UI se actualiza)
            $this->generateDailyRecords(); // O podrías recargar solo el registro específico si es más eficiente
        }
    }
//-------------------------------------limpiarfilas F-----------------------------------------------------------
    public function render()
    {
        $query = DailyRecord::query();

        if ($this->search) {
            $query->whereHas('bed', function ($q) {
                $q->where('codigo', 'like', "%{$this->search}%");
            })
            ->orWhereHas('patient', function ($q) {
                $q->where('nombre', 'like', "%{$this->search}%")
                  ->orWhere('apellido', 'like', "%{$this->search}%");
            });
        }

        if ($this->selectedDate) {
            $query->whereDate('fecha_registro', $this->selectedDate);
        }

        if ($this->selectedArea) {
            $query->whereHas('bed.area', function ($q) {
                $q->where('id', $this->selectedArea);
            });
        }

        $records = $query->orderBy('id', 'asc')->paginate(21);

        $areas = Area::all(); // Para el select de áreas

        return view('livewire.daily-record-component', compact('records', 'areas'))
            ->layout('layouts.app');
    }


    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();
        DailyRecord::create([
            'bed_id' => $this->bed_id,
            'patient_id' => $this->patient_id,
            'fecha_registro' => $this->fecha_registro,
            'desayuno' => $this->desayuno,
            'am10' => $this->am10,
            'almuerzo' => $this->almuerzo,
            'pm4' => $this->pm4,
            'cena' => $this->cena,
            'indicaciones' => $this->indicaciones,
            'diagnostico' => $this->diagnostico,
        ]);

        $this->resetInputFields();
        session()->flash('message', 'Registro diario creado correctamente.');
        $this->isOpen = false;
    }

    public function edit($id)
    {
        $record = DailyRecord::findOrFail($id);
        $this->record_id = $record->id;
        $this->bed_id = $record->bed_id;
        $this->patient_id = $record->patient_id;
        $this->fecha_registro = $record->fecha_registro;
        $this->desayuno = $record->desayuno;
        $this->am10 = $record->am10;
        $this->almuerzo = $record->almuerzo;
        $this->pm4 = $record->pm4;
        $this->cena = $record->cena;
        $this->indicaciones = $record->indicaciones;
        $this->diagnostico = $record->diagnostico;
        $this->isOpen = true;
    }

    public function update()
    {
        $this->validate();
        DailyRecord::find($this->record_id)->update([
            'bed_id' => $this->bed_id,
            'patient_id' => $this->patient_id,
            'fecha_registro' => $this->fecha_registro,
            'desayuno' => $this->desayuno,
            'am10' => $this->am10,
            'almuerzo' => $this->almuerzo,
            'pm4' => $this->pm4,
            'cena' => $this->cena,
            'indicaciones' => $this->indicaciones,
            'diagnostico' => $this->diagnostico,
        ]);

        session()->flash('message', 'Registro actualizado correctamente.');
        $this->resetInputFields();
        $this->isOpen = false;
    }

    public function delete($id)
    {
        DailyRecord::findOrFail($id)->delete();
        session()->flash('message', 'Registro eliminado correctamente.');
    }

    private function resetInputFields()
    {
        $this->bed_id = '';
        $this->patient_id = '';
        $this->fecha_registro = now();
        $this->desayuno = [];
        $this->am10 = [];
        $this->almuerzo = [];
        $this->pm4 = [];
        $this->cena = [];
        $this->indicaciones = '';
        $this->diagnostico = '';
    }
//generar los datos de todas las camas
    public function generateDailyRecords()
    {

        $beds = Bed::all();
        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();


        // Traer todos los registros de ayer, indexados por cama
        $yesterdayRecords = DailyRecord::whereDate('fecha_registro', $yesterday)
                                        ->get()
                                        ->keyBy('bed_id');

        foreach ($beds as $bed) {
            $exists = DailyRecord::where('bed_id', $bed->id)
                                ->whereDate('fecha_registro', $today)
                                ->exists();

            if (!$exists) {
                $recordYesterday = $yesterdayRecords[$bed->id] ?? null;

                DailyRecord::create([
                    'bed_id' => $bed->id,
                    'patient_id' => $recordYesterday->patient_id ?? null,
                    'fecha_registro' => $today,
                    'desayuno' => $recordYesterday->desayuno ?? null,
                    'am10' => $recordYesterday->am10 ?? null,
                    'almuerzo' => $recordYesterday->almuerzo ?? null,
                    'pm4' => $recordYesterday->pm4 ?? null,
                    'cena' => $recordYesterday->cena ?? null,
                    'indicaciones' => $recordYesterday->indicaciones ?? '',
                    'diagnostico' => $recordYesterday->diagnostico ?? '',
                ]);
            }
        }
    }

    //---------------------------- Mover Paciente - INICIO ---------------------------------------
    public function openMovePatientModal(int $recordId)
    {
        $this->recordIdToMove = $recordId;
        $this->destinationBeds = Bed::with('area')->get(); // Cargar TODAS las camas disponibles Y eager load la relación 'area' // Cargar TODAS las camas disponibles
        $this->isMovePatientModalOpen = true;
        $this->selectedBedCode = null; // Resetear al abrir el modal
        $this->selectedAreaName = null;
    }

    public function movePatient()
    {
        $this->validate([
            'selectedDestinationBedId' => 'required|exists:beds,id',
        ], [
            'selectedDestinationBedId.required' => 'Debes seleccionar una cama de destino.',
            'selectedDestinationBedId.exists' => 'La cama de destino seleccionada no es válida.',
        ]);

        $recordToMove = DailyRecord::find($this->recordIdToMove);
        $destinationBed = Bed::find($this->selectedDestinationBedId);

        if (!$recordToMove || !$destinationBed) {
            session()->flash('error', 'Error al mover el paciente. Registro de origen o cama de destino no encontrados.');
            return;
        }

        // --- VERIFICACIÓN DE OCUPACIÓN DE LA CAMA DE DESTINO ---
        $destinationBedDailyRecord = DailyRecord::where('bed_id', $this->selectedDestinationBedId)
            ->whereDate('fecha_registro', now()->toDateString())
            ->first();

        if ($destinationBedDailyRecord && $destinationBedDailyRecord->patient_id !== null) {
            session()->flash('error', 'La cama de destino está ocupada. Selecciona otra cama.');
            $this->isMovePatientModalOpen = true; // Reabrir el modal para que el usuario elija otra cama
            return; // Detener el proceso de movimiento si la cama está ocupada
        }
        // --- FIN DE VERIFICACIÓN DE OCUPACIÓN ---


        if ($destinationBedDailyRecord) {
            // --- ACTUALIZAR EL REGISTRO EXISTENTE DE LA CAMA DE DESTINO ---
            $destinationBedDailyRecord->update([
                'patient_id' => $recordToMove->patient_id,
                'desayuno' => $recordToMove->desayuno,
                'am10' => $recordToMove->am10,
                'almuerzo' => $recordToMove->almuerzo,
                'pm4' => $recordToMove->pm4,
                'cena' => $recordToMove->cena,
                'indicaciones' => $recordToMove->indicaciones,
                'diagnostico' => $recordToMove->diagnostico,
            ]);
        } else {
            // --- CASO EXCEPCIONAL: No existe registro diario para la cama de destino en este día ---
            // --- En teoría, esto NO debería ocurrir porque generateDailyRecords() debería crear registros para todas las camas diariamente ---
            // --- Pero por si acaso, podrías crear un nuevo registro aquí (opcional, dependiendo de tu lógica) ---
            DailyRecord::create([ // Opcional: Crear un nuevo registro si no existe
                'bed_id' => $this->selectedDestinationBedId,
                'patient_id' => $recordToMove->patient_id,
                'fecha_registro' => now()->toDateString(),
                'desayuno' => $recordToMove->desayuno,
                'am10' => $recordToMove->am10,
                'almuerzo' => $recordToMove->almuerzo,
                'pm4' => $recordToMove->pm4,
                'cena' => $recordToMove->cena,
                'indicaciones' => $recordToMove->indicaciones,
                'diagnostico' => $recordToMove->diagnostico,
            ]);
        }


        // --- LIMPIAR LOS CAMPOS DEL PACIENTE EN EL REGISTRO ORIGINAL (CAMA DE ORIGEN) ---
        $recordToMove->update([
            'patient_id' => null,
            'desayuno' => null,
            'am10' => null,
            'almuerzo' => null,
            'pm4' => null,
            'cena' => null,
            'indicaciones' => null,
            'diagnostico' => null,
        ]);

        $this->isMovePatientModalOpen = false;
        $this->selectedDestinationBedId = null;
        session()->flash('message', 'Paciente movido correctamente.');

        $this->generateDailyRecords(); // Recargar registros para actualizar la tabla
    }

    public function updatedSelectedDestinationBedId()
    {
        $this->resetErrorBag('selectedDestinationBedId'); // Limpiar errores de validación al cambiar la selección
    }
//---------------------------------------------------Mover Pacientes Fin---------------------------------------------
//---------------------------- Imprimir Dietas - INICIO ---------------------------------------


    public function imprimirDietas($horario, Request $request)
    {
        $query = DailyRecord::query()->with(['bed.area', 'patient']);

        // --- FILTRO DE FECHA DESDE URL --- (Sigue igual)
        $selectedDate = $request->query('selectedDate');
        if ($selectedDate) {
            $query->whereDate('fecha_registro', $selectedDate);
        }

        // --- FILTRO DE ÁREA DESDE URL --- (Sigue igual)
        $areaId = $request->query('areaId');
        if ($areaId) {
            $query->whereHas('bed.area', function ($q) use ($areaId) {
                $q->where('areas.id', $areaId);
            });
        }

        // --- FILTROS DE BÚSQUEDA (opcional) --- (Sigue igual si lo tienes descomentado)
        $search = $request->query('search');
        if ($search) { /* ... (tu código de filtro de búsqueda) ... */ }
        // ------------------------------------------------------


        // --- FILTRO POR HORARIO Y EXCLUIR REGISTROS VACÍOS ---  (MODIFICACIÓN IMPORTANTE)
        switch ($horario) {
            case 'desayuno':
                $query->whereNotNull('desayuno'); // <-- Añadido: Solo registros con desayuno NO nulo
                break;
            case 'am10':
                $query->whereNotNull('am10');     // <-- Añadido: Solo registros con am10 NO nulo
                break;
            case 'almuerzo':
                $query->whereNotNull('almuerzo');  // <-- Añadido: Solo registros con almuerzo NO nulo
                break;
            case 'cena':
                $query->whereNotNull('cena');      // <-- Añadido: Solo registros con cena NO nulo
                break;
            case 'pm4':
                $query->whereNotNull('pm4');       // <-- Añadido: Solo registros con pm4 NO nulo
                break;
        }
        // -------------------------------------------------------------------


        $registrosDiariosSinPaginacion = $query->get();

        // --- AGRUPAR POR ÁREA y PAGINAR --- (Sigue igual)
        $registrosAgrupadosPorArea = $registrosDiariosSinPaginacion->groupBy('bed.area.nombre');
        $registrosPorAreaPaginados = [];
        $perPage = 20;
        $currentPage = 1;
        foreach ($registrosAgrupadosPorArea as $areaNombre => $registrosDeArea) {
            $currentPageItems = $registrosDeArea->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $registrosPaginados = new LengthAwarePaginator(
                $currentPageItems,
                $registrosDeArea->count(),
                $perPage,
                $currentPage,
                ['path' => route('imprimir.dietas', ['horario' => $horario])]
            );
            $registrosPorAreaPaginados[$areaNombre] = $registrosPaginados;
        }


        return view('livewire.imprimir-dietas', [
            'registrosPorAreaPaginados' => $registrosPorAreaPaginados,
            'horario' => $horario,
            'nombreDietaHorario' => $this->getNombreDietaHorario($horario),
        ]);
    }

    private function getNombreDietaHorario($horario)
    {
        $nombreDietaHorario = '';
        switch ($horario) {
            case 'desayuno':
                $nombreDietaHorario = 'Desayuno';
                break;
            case 'am10':
                $nombreDietaHorario = 'Media Mañana (10 AM)';
                break;
            case 'almuerzo':
                $nombreDietaHorario = 'Almuerzo';
                break;
            case 'cena':
                $nombreDietaHorario = 'Cena';
                break;
            case 'pm4': // Asumiendo que "4 PM" lo tienes como 'pm4' en tu código
                $nombreDietaHorario = 'Media Tarde (4 PM)';
                break;
            default:
                $nombreDietaHorario = 'Dieta'; // Genérico si no coincide con ningún horario conocido
                break;
        }
        return $nombreDietaHorario;
    }
//---------------------------- Imprimir Dietas - FIN ------------------------------------------


    public function filterRecords()
    {
        $this->resetPage(); // Para evitar problemas con la paginación
    }
//-----------------------------DIETAS PRESETS
    public function applyDietPreset($presetIndex)
    {
        // Verifica que el índice del preset exista en nuestro array de presets
        if (isset($this->dietPresets[$presetIndex])) {
            $presetDietIds = $this->dietPresets[$presetIndex]['diet_ids'];

            // Opcional: Validar que los IDs del preset realmente existen en la tabla de dietas
            // Esto es una buena práctica para evitar errores si los presets se desactualizan.
            $validDietIds = \App\Models\Diet::whereIn('id', $presetDietIds)->pluck('id')->toArray();

            // Asigna los IDs de dietas del preset a la propiedad $selectedDiets.
            // Como los checkboxes están vinculados con wire:model="selectedDiets",
            // Livewire automáticamente marcará/desmarcará los checkboxes correspondientes.
            $this->selectedDiets = $validDietIds;

            // Si quisieras que el preset AÑADA a la selección actual en lugar de SOBRESCRIBIRLA:
            // $currentSelection = is_array($this->selectedDiets) ? $this->selectedDiets : [];
            // $this->selectedDiets = array_values(array_unique(array_merge($currentSelection, $validDietIds)));

        } else {
            // Opcional: Manejar el caso de un índice de preset inválido, aunque no debería ocurrir
            // session()->flash('error', 'El preset seleccionado no es válido.');
        }
    }
     public function openAllDietsModal()
    {
        $this->showAllDietsModal = true;
    }

    public function closeAllDietsModal()
    {
        $this->showAllDietsModal = false;
    }

}
