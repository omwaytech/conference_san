<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionDiscussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id', 'sender_id', 'remarks', 'attachment', 'committee_member_id', 'committee_remarks', 'expert_visible', 'presenter_visible', 'status'
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class, 'submission_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function committeeMember()
    {
        return $this->belongsTo(User::class, 'committee_member_id', 'id');
    }
}
