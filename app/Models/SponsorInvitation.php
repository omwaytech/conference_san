<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsor_id', 'name', 'email', 'phone', 'address', 'image', 'token', 'description', 'no_of_people', 'status'
    ];

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
}
