<?php

use App\Livewire\AreaComponent;
use App\Livewire\BedPatientPage;
use App\Livewire\DailyRecordComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //rotas dentro del app 
    Route::get('/areas', AreaComponent::class)->name('areas');
    Route::get('/drecords', DailyRecordComponent::class)->name('drecords');
    Route::get('/beds-patients', BedPatientPage::class)->name('beds.patients');
    
    //impresion
    Route::get('/imprimir/dietas/{horario}', [DailyRecordComponent::class, 'imprimirDietas'])->name('imprimir.dietas');
    
});
