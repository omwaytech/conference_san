<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorMeal extends Model
{
    use HasFactory;
    protected $fillable = [
        'sponsor_id',
        'lunch_taken',
        'dinner_taken'
    ];
}
