<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopRegistrationPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'workshop_id', 'member_type_id', 'price', 'status'
    ];
}
