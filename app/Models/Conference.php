<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;

    protected $fillable = [
        'conference_theme', 'conference_logo', 'start_date', 'end_date', 'venue_name', 'venue_address', 'venue_contact', 'location_map', 'start_time',
        'organizer_name', 'organizer_logo', 'contact_person', 'organizer_email', 'organizer_phone', 'description', 'slug', 'early_bird_registration_deadline',
        'regular_registration_deadline', 'status'
    ];

    public static function latestConference()
    {
        $conference = Conference::where('status', 1)->latest()->first();

        return $conference;
    }

    public function registrations()
    {
        return $this->hasMany(ConferenceRegistration::class);
    }

    public function submissionSetting()
    {
        return $this->hasOne(SubmissionSetting::class);
    }
}
