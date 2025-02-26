<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',          // Asegúrate de que estén todos los campos de la tabla patients (excepto id, timestamps)
        'apellido',
        'fecha_nacimiento',
        'dni',
        'peso',
        'talla',
        'imc',];

    public function medicalRecord()
    {
        return $this->hasOne(ClinicalHistory::class);
    }

    public function dailyRecords()
    {
        return $this->hasMany(DailyRecord::class);
    }
    public function nombreCompleto()
    {
        return $this->nombre . ' ' . $this->apellido;
    }
    
    public function getEdadAttribute()
    {
        if ($this->fecha_nacimiento) {
            return Carbon::parse($this->fecha_nacimiento)->age;
        }
        return null;
    }


    
}
