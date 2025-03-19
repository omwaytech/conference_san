<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'conference_id',
        'expert_id',
        'topic',
        'presentation_type',
        'cover_letter',
        'presentation_file',
        'forward_expert',
        'request_status',
        'keywords',
        'abstract_content',
        'submitted_date',
        'accepted_date',
        'remarks',
        'status',
        'has_presented_before',
        'presentation_place'
    ];

    // request status values
    // 0 => pending
    // 1 => accepted
    // 2 => correction
    // 3 => rejected

    public function expert()
    {
        return $this->belongsTo(User::class, 'expert_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function userDetails()
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'user_id');
    }

    public function presenter()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class, 'conference_id', 'id');
    }
    public static function getData($presentationType = null, $requestStatus = null)
    {
        return self::with(['user' => function ($query) {
            $query->select('id', 'f_name', 'm_name', 'l_name');
        }])
            ->when($presentationType, function ($query, $presentationType) {
                return $query->where('presentation_type', $presentationType);
            })
            ->when(isset($requestStatus), function ($query) use ($requestStatus) {
                return $query->where('request_status', $requestStatus);
            })
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();
    }


    public function authors()
    {
        return $this->hasMany(Author::class);
    }

    public function discussions()
    {
        return $this->hasMany(SubmissionDiscussion::class);
    }
}
