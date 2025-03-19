<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopTrainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'workshop_id', 'name', 'image', 'affiliation', 'cv', 'status'
    ];

    public function workshop()
    {
        $this->belongsTo(Workshop::class);
    }
}
