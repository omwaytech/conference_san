<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'workshop_registration_id', 'in', 'out', 'status'
    ];
}
