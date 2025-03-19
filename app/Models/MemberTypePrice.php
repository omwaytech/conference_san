<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberTypePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'conference_id', 'member_type_id', 'early_bird_amount', 'regular_amount', 'on_site_amount', 'guest_amount', 'status'
    ];

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }

    public function memberType()
    {
        return $this->belongsTo(MemberType::class);
    }
}
