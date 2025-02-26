<?php

namespace App\Livewire;

use App\Models\Bed;
use App\Models\Area; // Importa el modelo Area
use Livewire\Component;
use Livewire\WithPagination;

class CrudBed extends Component
{
    use WithPagination;

    public $search = '';
    public $areaFilter = ''; // Para filtrar por área
    public $areas; // Para pasar las áreas a la vista
    public $sortDirection = 'asc';
    public $isOpen = false;
    public $bed; // Propiedad para el modelo Bed en el formulario (si añades CRUD)

    protected $listeners = ['render', 'delete' => 'deleteBed']; // Listener para eventos, ajustado para 'deleteBed'

    protected $rules = [ // Reglas de validación para el formulario (si añades CRUD)
        'bed.codigo' => 'required|unique:beds,codigo', // Ejemplo, ajusta según tus necesidades
        'bed.area_id' => 'required|exists:areas,id', // Ejemplo, ajusta según tus necesidades
    ];


    public function mount()
    {
        $this->areas = Area::all(); // Carga todas las áreas al montar el componente
    }

    public function render()
    {
        $query = Bed::query()->with('area'); // Cargar la relación 'area' para evitar N+1

        // Filtro por Área
        if ($this->areaFilter) {
            $query->where('area_id', $this->areaFilter);
        }

        // Buscador por Código de Cama
        if ($this->search) {
            $query->where('codigo', 'like', '%' . $this->search . '%');
        }


        $beds = $query->orderBy('id', $this->sortDirection)
                     ->paginate(21)
                     ->onEachside(3); // Paginación

        $areas = Area::all(); // Para el filtro de área en la vista


        return view('livewire.crud-bed', compact('beds', 'areas'))
            ->layout('layouts.app'); // Pasa $areas a la vista
    }


    // --- Métodos CRUD (puedes implementarlos más adelante, por ahora los dejamos básicos) ---
    public function create()
    {
        $this->isOpen = true;
        $this->bed = [
            'id' => null,
        ];
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        if (!empty($this->bed['id'])) {
            $bed = Bed::find($this->bed['id']);
            if ($bed) {
                $bed->update($this->bed);
                $message = 'Cama actualizada correctamente';
            } else {
                return; // Manejo si no se encuentra la cama
            }
        } else {
            Bed::create($this->bed);
            $message = 'Cama creada correctamente';
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

    public function edit($bedId)
    {
        $bed = Bed::find($bedId);
        if ($bed) {
            $this->bed = $bed->toArray();
            $this->isOpen = true;
            $this->dispatch('open-modal');
        } else {
            $this->dispatch(
                'alert',
                type: 'error',
                title: 'Cama no encontrada',
                position: 'center'
            );
        }
    }


    public function deleteBed($bedId) // Renombrado para evitar confusión con método delete de Eloquent
    {
        $bed = Bed::find($bedId);
        if ($bed) {
            $bed->delete();
            $this->dispatch(
                'alert',
                type: 'success',
                title: 'Cama borrada correctamente',
                position: 'center'
            );
        } else {
            $this->dispatch(
                'alert',
                type: 'error',
                title: 'Cama no encontrada',
                position: 'center'
            );
        }
        $this->resetComponent();
    }


    private function resetComponent()
    {
        $this->isOpen = false;
        $this->bed = [
            'id' => '',
            'codigo' => '',
            'area_id' => '', // Añade area_id al reset
        ];
        $this->resetErrorBag();
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