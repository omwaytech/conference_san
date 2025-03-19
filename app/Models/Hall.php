<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    protected $fillable = [
        'hall_name',
        'status'
    ];

    public function scientificSession()
    {
        return $this->hasMany(ScientificSession::class);
    }
}
