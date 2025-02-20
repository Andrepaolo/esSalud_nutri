<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'bed_id', 'patient_id', 'fecha_registro', 
        'desayuno','am10', 'almuerzo','pm4', 'cena', 
        'indicaciones', 'diagnostico'
    ];
    protected $casts = [
        'fecha_registro' => 'date',
        'desayuno' => 'array',
        'am10' => 'array',
        'almuerzo' => 'array',
        'pm4' => 'array',
        'cena' => 'array',
    ];

    public function bed()
    {
        return $this->belongsTo(Bed::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function dietOptions() {
        return $this->belongsToMany(Diet::class, 'daily_record_diet_option')
                    ->withPivot('meal'); // Acceder a la columna 'meal'
    }

}
