<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorAttendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'sponsor_id',
        'status'
    ];

    public function sponsor()
    {
        return $this->belongsTo(sponsor::class);
    }
}
