<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;

    protected $fillable = [
        'conference_id',
        'user_id',
        'title',
        'slug',
        'venue',
        'start_date',
        'end_date',
        'time',
        'chair_person_name',
        'chair_person_affiliation',
        'chair_person_image',
        'chair_person_cv',
        'contact_person_name',
        'contact_person_email',
        'contact_person_phone',
        'cpd_point',
        'no_of_participants',
        'no_of_days',
        'estimated_budget',
        'registration_deadline',
        'description',
        'is_applied',
        'approved_status',
        'remarks',
        'status'
    ];

    // approved status values
    // 0 => pending
    // 1 => accepted
    // 2 => correction
    // 3 => rejected

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function registrationPrice()
    {
        return $this->hasMany(WorkshopRegistrationPrice::class);
    }

    public function registrations()
    {
        return $this->hasMany(WorkshopRegistration::class);
    }

    public function discussions()
    {
        return $this->hasMany(WorkshopDiscussion::class);
    }

    public function trainers()
    {
        return $this->hasMany(WorkshopTrainer::class);
    }
}
