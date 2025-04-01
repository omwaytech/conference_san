<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollAnswer extends Model
{
    use HasFactory;
    protected $fillable = [
        'poll_id',
        'answer_text',
        'is_correct',
        'votes_count'
    ];
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function votes()
    {
        return $this->hasMany(UserVote::class, 'answer_id', 'id');
    }
}
