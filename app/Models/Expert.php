<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'conference_id', 'status'
    ];

    public function expert()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
