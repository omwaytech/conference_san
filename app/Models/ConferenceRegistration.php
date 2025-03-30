<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConferenceRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'conference_id',
        'registrant_type',
        'attend_type',
        'payment_voucher',
        'transaction_id',
        'verified_status',
        'token',
        'total_attendee',
        'is_invited',
        'is_featured',
        'remarks',
        'description',
        'status',
        'amount',
        'meal_type',
        'registration_id'
    ];

    // registrant_type => // 1 for attendee, 2 for speaker
    // attend_type => // 1 for physical, 2 for online
    // verified_status => // 0 for pending, 1 for accepted, 2 for rejected
    // meal_type => // 1 for veg, 2 for non-veg

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function committeMember()
    {
        return $this->hasMany(CommitteeMember::class, 'user_id', 'user_id')->where('status',1);
    }

    public static function totalRegistrants($delegate, $conference)
    {
        if ($conference == null) {
            $conferenceId = 0;
        } else {
            $conferenceId = $conference->id;
        }

        if ($delegate == 1) {
            $cond = "AND MT.delegate = 'National'";
        } else {
            $cond = "AND MT.delegate = 'International'";
        }
        $sql = "SELECT
                    MT.id,
                    MT.delegate,
                    MT.type,
                    COUNT(DISTINCT UD.user_id) AS user_count,
                    GROUP_CONCAT(DISTINCT UD.user_id) AS user_ids
                FROM member_types AS MT
                LEFT JOIN
                (
                    SELECT
                        UD.member_type_id,
                        UD.status AS ud_status,
                        CR.status AS cr_status,
                        CR.verified_status,
                        CR.user_id
                    FROM user_details AS UD
                    JOIN conference_registrations AS CR ON UD.user_id = CR.user_id
                    WHERE UD.status = 1 AND CR.status = 1 AND CR.verified_status = 1 AND CR.conference_id = $conferenceId
                )  AS UD ON MT.id = UD.member_type_id
                WHERE MT.status = 1 $cond
                GROUP BY MT.id, MT.delegate, MT.type";

        $totalRegistrants = DB::select($sql);

        return $totalRegistrants;
    }

    public function userDetail()
    {
        return $this->belongsTo(UserDetail::class, 'user_id', 'user_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'conference_registration_id', 'id');
    }

    public function meals()
    {
        return $this->hasMany(Meal::class, 'conference_registration_id', 'id');
    }

    public function accompanyPersons()
    {
        return $this->hasMany(AccompanyPerson::class, 'conference_registration_id', 'id');
    }
}
