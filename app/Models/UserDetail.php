<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'member_type_id', 'phone', 'image', 'address', 'institute_name', 'affiliation', 'country_id', 'council_number',
        'san_number', 'delegate', 'status', 'gender', 'is_faculty', 'pass_designation', 'pass_sub_designation', 'department'
    ];

    public function memberType()
    {
        return $this->belongsTo(MemberType::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
