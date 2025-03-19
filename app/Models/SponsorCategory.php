<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'conference_id', 'category_name', 'slug', 'status'
    ];

    public function sponsors()
    {
        return $this->hasMany(Sponsor::class);
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
}
