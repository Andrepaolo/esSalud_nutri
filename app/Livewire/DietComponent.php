<?php

namespace App\Livewire;

use App\Models\Diet;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule; // Importa la clase Rule

class DietComponent extends Component
{
    use WithPagination;
    public $diet;
    public $dietaSeleccionada;
    public $search = '';
    public $isOpen=false;

    public $sortField = 'name';
    public $sortDirection = 'asc';

    // Mueve las reglas de validación a un método
    protected function rules()
    {
        return [
            'diet.name' => [
                'required',
                'string',
                'max:255',
                // Regla UNIQUE:
                // 'diets' es el nombre de la tabla
                // 'name' es la columna a verificar
                // $this->diet['id'] es el ID del registro a ignorar (si estamos editando)
                Rule::unique('diets', 'name')->ignore($this->diet['id']),
            ],
        ];
    }

    public function mount()
    {
        $this->isOpen = false;
        $this->diet = ['id' => null, 'name' => ''];
    }

    public function render()
    {
        // ... (resto del método render igual) ...
        $diets = Diet::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(8);

        return view('livewire.diet-component', compact('diets'));
    }

    public function create()
    {
        $this->isOpen = true;
        $this->diet = ['id' => null, 'name' => ''];
        $this->resetErrorBag(); // Limpia los errores de validación anteriores
        $this->resetValidation(); // Limpia las reglas de validación anteriores
    }

    public function edit($id)
    {
        $diet = Diet::findOrFail($id);
        $this->diet = $diet->toArray();
        $this->isOpen = true;
        $this->resetErrorBag(); // Limpia los errores de validación anteriores
        $this->resetValidation(); // Limpia las reglas de validación anteriores
    }

    public function store()
    {
        // La validación se llamará usando las reglas del método rules()
        $this->validate();

        $dataToSave = [
            'name' => $this->diet['name'],
        ];

        if (!empty($this->diet['id'])) {
            $dietInstance = Diet::find($this->diet['id']);
            if ($dietInstance) {
                $dietInstance->update($dataToSave);
                session()->flash('message', 'Dieta actualizada correctamente.');
            } else {
                session()->flash('error', 'Error: Dieta no encontrada.');
                return;
            }
        } else {
            // Al crear, el ID es null, por lo que la regla unique funciona sin ignorar nada
            Diet::create($dataToSave);
            session()->flash('message', 'Dieta creada correctamente.');
        }

        $this->resetComponent();
    }

    public function delete($id)
    {
        Diet::findOrFail($id)->delete();
        session()->flash('message', 'Dieta eliminada correctamente.');
    }

    private function resetComponent()
    {
        $this->isOpen = false;
        $this->diet = ['id' => null, 'name' => ''];
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function closeDietFormModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->diet = ['id' => null, 'name' => ''];
    }

    public function sortBy()
    {
        $this->sortDirection = ($this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->resetPage();
    }
}
