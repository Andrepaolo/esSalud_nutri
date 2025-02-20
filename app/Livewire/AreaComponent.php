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
    protected $listeners = ['render', 'delete' => 'delete'];

    protected $rules = [
        'area.nombre' => 'required',
        'area.description' => 'required',
    ];

    public function render()
    {
        $areas = Area::where('nombre', 'like', '%' . $this->search . '%')
        ->orderBy('id', 'asc')
        ->paginate(15);

        return view('livewire.area-component', compact('areas'))
            ->layout('layouts.app');
    }

    public function verCamas($area_id)
    {
        $this->areaSeleccionada = $area_id;
    }

    public function create()
    {
        $this->isOpen = true;
        $this->area = ['id' => null];
        $this->resetErrorBag();
    }

    public function store()
    {
        //dd($this->area);
        $this->validate();

        if (!empty($this->area['id'])) {
            $area = Area::find($this->area['id']);
            if ($area) {
                $area->update($this->area);
                $message = 'Área actualizada correctamente';
            }
            else {
                // Manejo del caso donde no se encuentra el producto
                return;}
        } else {
            Area::create($this->area);
            $message = 'Área creada correctamente';
        }

        $this->resetComponent();
        $this->dispatch('alert', type: 'success', title: $message, position: 'center');
        $this->dispatch('close-modal');
    }

    public function edit($areaId)
    {
        $area = Area::find($areaId);
        if ($area) {
            $this->area = $area->toArray();
            $this->isOpen = true;
            $this->dispatch('open-modal');
        }
    }

    public function delete($areaId)
    {
        $area = Area::find($areaId);
        if ($area) {
            $area->delete();
            $this->dispatch('alert', type: 'success', title: 'Área eliminada', position: 'center');
        }
        $this->resetComponent();
    }

    private function resetComponent()
    {
        $this->isOpen = false;
        $this->area = ['id' => '', 'nombre' => '', 'description'=>''];
        $this->resetErrorBag();
    }
    //---------------------------- Exportar a Excel - INICIO ---------------------------------------
    public function exportToExcel()
    {
        return Excel::download(new DailyRecordsExport(), 'registros_diarios_por_area.xlsx');
    }

    //---------------------------- Exportar a Excel - FIN ------------------------------------------
}
