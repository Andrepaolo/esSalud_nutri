<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bed;
use App\Models\Area;

class BedComponent extends Component
{
    public $area_id;
    public $beds = [];

    // Recibe el ID del área y carga sus camas
    public function mount($area_id)
    {
        $this->area_id = $area_id;
        $this->loadBeds();
    }

    // Método para cargar camas de un área específica
    public function loadBeds()
    {
        $this->beds = Bed::where('area_id', $this->area_id)->get();
    }

    public function render()
    {
        return view('livewire.bed-component');
    }
}
