<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'conference_id', 'deadline', 'abstract_word_limit', 'keyword_word_limit', 'authors_limit', 'abstract_guidelines', 'poster_guidelines'
    ];

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
}
