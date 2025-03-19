<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccompanyPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'conference_registration_id', 'person_name', 'relation', 'status'
    ];
}
