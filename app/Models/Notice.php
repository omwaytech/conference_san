<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'conference_id', 'title', 'date', 'image', 'slug', 'description', 'is_featured', 'status'
    ];
}
