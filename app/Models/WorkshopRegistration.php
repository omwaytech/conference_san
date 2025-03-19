<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'workshop_id', 'transaction_id', 'payment_voucher', 'verified_status', 'token', 'remarks', 'status', 'meal_type', 'amount'
    ];
    // meal_type => // 1 for veg, 2 for non-veg

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    public function attendances()
    {
        return $this->hasMany(WorkshopAttendance::class);
    }
}
