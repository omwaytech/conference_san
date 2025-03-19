<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id', 'hall_id', 'agenda', 'time', 'duration', 'status'
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
