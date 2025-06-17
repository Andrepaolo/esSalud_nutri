<?php

namespace App\Livewire;

use App\Exports\DailyRecordsExport;
use App\Models\Area;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class AreaComponent extends Component
{
    use WithPagination;
    public $area;
    public $areaSeleccionada = null;
    public $search;
    public $isOpen = false;

    // Este listener es crucial para recibir el evento de SortableJS
    protected $listeners = ['render', 'delete' => 'delete', 'updateAreaOrder'];

    protected $rules = [
        'area.nombre' => 'required|string|max:255',
        'area.description' => 'nullable|string|max:65535',
    ];

    public function mount()
    {
        $this->isOpen = false;
        $this->area = ['id' => null, 'nombre' => '', 'description' => ''];
    }

    public function render()
    {
        $areas = Area::where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('orden') // Ordena por el campo 'orden'
            ->paginate(15);

        return view('livewire.area-component', compact('areas'))
            ->layout('layouts.app');
    }

    public function verCamas($area_id)
    {
        $this->areaSeleccionada = $area_id;
        // Aquí podrías emitir un evento o redirigir para mostrar las camas
    }

    public function create()
    {
        $this->isOpen = true;
        $this->area = ['id' => null, 'nombre' => '', 'description' => ''];
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        $dataToSave = [
            'nombre' => $this->area['nombre'],
            'description' => $this->area['description'] ?? 'Sin descripción',
        ];

        if (!empty($this->area['id'])) {
            $areaInstance = Area::find($this->area['id']);
            if ($areaInstance) {
                $areaInstance->update($dataToSave);
                $this->emit('alert', ['title' => 'Área actualizada correctamente', 'type' => 'success']);
            } else {
                $this->emit('alert', ['title' => 'Error: Área no encontrada.', 'type' => 'error']);
                return;
            }
        } else {
            // Asigna el valor de 'orden' al crear una nueva área
            $maxOrder = Area::max('orden');
            $dataToSave['orden'] = is_null($maxOrder) ? 0 : $maxOrder + 1;
            Area::create($dataToSave);
            $this->emit('alert', ['title' => 'Área creada correctamente', 'type' => 'success']);
        }

        $this->resetComponent();
    }

    public function edit($areaId)
    {
        $areaInstance = Area::find($areaId);
        if ($areaInstance) {
            $this->area = $areaInstance->toArray();
            $this->isOpen = true;
            $this->resetErrorBag();
            $this->resetValidation();
        } else {
            $this->emit('alert', ['title' => 'Error: Área no encontrada al intentar editar.', 'type' => 'error']);
        }
    }

    public function delete($areaId)
    {
        $areaInstance = Area::find($areaId);
        if ($areaInstance) {
            $areaInstance->delete();
            $this->emit('alert', ['title' => 'Área eliminada', 'type' => 'success']);
            // Considera reordenar los elementos restantes si es importante mantener una secuencia sin huecos
        } else {
            $this->emit('alert', ['title' => 'Error: Área no encontrada al intentar eliminar.', 'type' => 'error']);
        }
        // $this->resetComponent(); // Opcional
    }

    private function resetComponent()
    {
        $this->isOpen = false;
        $this->area = ['id' => null, 'nombre' => '', 'description' => ''];
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function exportToExcel()
    {
        return Excel::download(new DailyRecordsExport(), 'registros_diarios_por_area.xlsx');
    }

    // Este método se llama cuando SortableJS envía el nuevo orden
    public function updateAreaOrder(array $orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            Area::where('id', $id)->update(['orden' => $index]);
        }

        $this->emit('alert', ['title' => 'Orden de áreas actualizado', 'type' => 'success']);
        // No es necesario re-renderizar aquí, la próxima carga de 'render' ya usará el nuevo orden
    }
}