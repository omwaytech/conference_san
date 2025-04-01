<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScientificSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'conference_id',
        'type',
        'topic',
        'hall_id',
        'chairperson',
        'co_chairperson',
        'participants',
        'time',
        'day',
        'duration',
        'status',
        'category_id',
        'screen',
        'moderator'
    ];

    // values of type:                      chairperson         participants
    // 1 = Paper Presentation        =      chairperson     =   presenters
    // 2 = Poster Presentation       =      chairperson     =   presenters
    // 3 = Panel Discussion          =      moderator       =   panelists
    // 4 = Debate                    =      moderator       =   opponents
    // 5 = General Activity

    public function category()
    {
        return $this->belongsTo(ScientificSessionCategory::class, 'category_id', 'id');
    }

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function chairperson()
    {
        return $this->belongsTo(User::class, 'chairperson', 'id');
    }
    public function poll()
    {
        return $this->hasMany(Poll::class, 'scientific_session_id', 'id');
    }
}
