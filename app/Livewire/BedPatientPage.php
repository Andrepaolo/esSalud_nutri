<?php

namespace App\Livewire;

use Livewire\Component;

class BedPatientPage extends Component
{
    public function render()
    {
        return view('livewire.bed-patient-page')
        ->layout('layouts.app');
    }
}
