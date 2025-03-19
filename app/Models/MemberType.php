<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberType extends Model
{
    use HasFactory;

    protected $fillable = [
        'delegate', 'type', 'status'
    ];

    public function workshopRegistrationPrice()
    {
        return $this->hasMany(WorkshopRegistrationPrice::class);
    }
}
