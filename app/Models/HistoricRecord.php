<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricRecord extends Model
{
    use HasFactory;

    protected $fillable = ['daily_record_id'];

    public function dailyRecord()
    {
        return $this->belongsTo(DailyRecord::class);
    }
}
