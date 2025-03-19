<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamePrefix extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefix', 'status'
    ];
}
