<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'apellido', 'fecha_nacimiento', 'dni', 'telefono'];

    public function medicalRecord()
    {
        return $this->hasOne(ClinicalHistory::class);
    }

    public function dailyRecords()
    {
        return $this->hasMany(DailyRecord::class);
    }
}
