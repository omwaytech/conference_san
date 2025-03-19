<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopDiscussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'workshop_id', 'user_id', 'remarks', 'attachment', 'status'
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
