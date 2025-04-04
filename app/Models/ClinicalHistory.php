<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalHistory extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'diagnostico', 'tratamiento'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
