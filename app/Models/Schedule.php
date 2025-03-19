<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'conference_id', 'hall_id', 'agenda', 'date', 'time', 'duration', 'slug', 'status'
    ];

    public function subSchedules()
    {
        return $this->hasMany(SubSchedule::class, 'schedule_id', 'id');
    }
}
