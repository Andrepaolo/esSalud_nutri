<?php

use App\Livewire\AreaComponent;
use App\Livewire\DailyRecordComponent;
use App\Models\Area;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
});
