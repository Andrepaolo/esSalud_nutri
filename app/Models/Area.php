<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','description', 'orden'];

    public function beds()
    {
        return $this->hasMany(Bed::class);
    }
}
