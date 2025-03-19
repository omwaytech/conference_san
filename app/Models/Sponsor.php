<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsor_category_id', 'name', 'amount', 'logo', 'address', 'contact_person', 'email', 'phone',
        'description', 'visible_status', 'status', 'token', 'total_attendee', 'dinner_remaining', 'dinner_remaining_2',
        'dinner_remaining_3', 'dinner_remaining_4'
    ];

    public function category()
    {
        return $this->belongsTo(SponsorCategory::class, 'sponsor_category_id', 'id');
    }

    public function invitation()
    {
        return $this->hasOne(SponsorInvitation::class);
    }
}
