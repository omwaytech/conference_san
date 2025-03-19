<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'conference_id', 'name', 'address', 'phone', 'email', 'featured_image', 'images', 'rating', 'google_map', 'description', 'visible_status',
        'status', 'slug', 'contact_person', 'price', 'website', 'facility', 'promo_code'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
}
