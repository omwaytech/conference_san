<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConferenceRegistrationKit extends Model
{
    use HasFactory;
    protected $fillable = [
        'conference_registration_id',
        'status'
    ];
    public function conferenceRegistration()
    {
        return $this->belongsTo(ConferenceRegistration::class);
    }
}
