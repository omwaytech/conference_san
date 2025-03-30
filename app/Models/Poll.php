<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;
    protected $fillable = [
        'scientific_session_id',
        'question_text',
        'status'
    ];

    public function answers()
    {
        return $this->hasMany(PollAnswer::class, 'poll_id');
    }

    public function votes()
    {
        return $this->hasMany(UserVote::class);
    }

    public function scientificSession()
    {
        return $this->belongsTo(ScientificSession::class);
    }
}
