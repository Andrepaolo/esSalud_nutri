<?php

namespace App\Livewire;

use App\Models\Patient;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class CrudPatient extends Component
{
    use WithPagination;

    public $search = '';
    public $sortDirection = 'asc';
    public $isOpen = false;
    public $patient = [ // Inicializar $patient como un array
        'id' => null,
        'nombre' => '',
        'apellido' => '',
        'fecha_nacimiento' => '',
        'dni' => '',
        'peso' => null,
        'talla' => null,
        'imc' => null, // Añadir 'imc' a la inicialización
    ];

    protected $listeners = ['render', 'deletePatient' => 'deletePatient'];

    protected function rules()
    {
        return [
            'patient.nombre' => 'required|string',
            'patient.apellido' => 'required|string',
            'patient.fecha_nacimiento' => 'nullable|date',
            'patient.dni' => [
                'required',
                'digits:8',
                Rule::unique('patients', 'dni')->ignore($this->patient['id'] ?? 0),
            ],
            'patient.peso' => 'nullable|numeric|min:0',
            'patient.talla' => 'nullable|numeric|min:0',
            'patient.imc' => 'nullable|numeric', // Añadir validación para imc (opcional)
        ];
    }

    public function render()
    {
        $query = Patient::query();

        if ($this->search) {
            $query->where('dni', 'like', '%' . $this->search . '%')
                ->orWhere('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('apellido', 'like', '%' . $this->search . '%');
        }

        $patients = $query->orderBy('id', $this->sortDirection)
            ->paginate(21);

        return view('livewire.crud-patient', compact('patients'));
    }

    public function create()
    {
        $this->isOpen = true;
        $this->resetPatientArray(); // Usar método para resetear $patient array
        $this->resetErrorBag();
    }


    public function store()
    {
        $this->validate($this->rules());

        // Calcular IMC ANTES de guardar
        $peso = $this->patient['peso'];
        $talla = $this->patient['talla'];
        $imc = null; // Inicializar IMC a null por defecto
        if ($peso && $talla) {
            $tallaEnMetros = $talla / 100;
            if ($tallaEnMetros > 0) {
                $imc = $peso / ($tallaEnMetros * $tallaEnMetros);
                $imc = round($imc, 2); // Redondear a 2 decimales
            }
        }
        $this->patient['imc'] = $imc; // Asignar el IMC calculado al array $this->patient

        if (!empty($this->patient['id'])) {
            $patient = Patient::find($this->patient['id']);
            if ($patient) {
                $patient->update($this->patient);
                $message = 'Paciente actualizado correctamente';
            } else {
                return;
            }
        } else {
            Patient::create($this->patient);
            $message = 'Paciente creado correctamente';
        }

        $this->resetComponent();

        $this->dispatch(
            'alert',
            type: 'success',
            title: $message,
            position: 'center'
        );
        $this->dispatch('close-modal');
    }

    public function edit($patientId)
    {
        $patient = Patient::find($patientId);
        if ($patient) {
            $this->patient = $patient->toArray();
            $this->isOpen = true;
            $this->dispatch('open-modal');
        } else {
            $this->dispatch(
                'alert',
                type: 'error',
                title: 'Paciente no encontrado',
                position: 'center'
            );
        }
    }

    public function deletePatient($patientId)
    {
        $patient = Patient::find($patientId);
        if ($patient) {
            $patient->delete();
            $this->dispatch(
                'alert',
                type: 'success',
                title: 'Paciente borrado correctamente',
                position: 'center'
            );
        } else {
            $this->dispatch(
                'alert',
                type: 'error',
                title: 'Paciente no encontrado',
                position: 'center'
            );
        }
        $this->resetComponent();
    }

    private function resetComponent()
    {
        $this->isOpen = false;
        $this->resetPatientArray(); // Usar método para resetear $patient array
        $this->resetErrorBag();
    }

    private function resetPatientArray() // Método para resetear $patient array
    {
        $this->patient = [
            'id' => null,
            'nombre' => '',
            'apellido' => '',
            'fecha_nacimiento' => '',
            'dni' => '',
            'peso' => null,
            'talla' => null,
            'imc' => null, // Resetear 'imc' también
        ];
    }


    public function sortAsc()
    {
        $this->sortDirection = 'asc';
    }

    public function sortDesc()
    {
        $this->sortDirection = 'desc';
    }
}