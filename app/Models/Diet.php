<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = ['name'];

    public function dailyRecords()
    {
        return $this->belongsToMany(DailyRecord::class, 'daily_record_diet_option');
    }
}
