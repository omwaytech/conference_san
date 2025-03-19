<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'f_name',
        'm_name',
        'l_name',
        'email',
        'role',
        'password',
        'status',
        'last_login_at',
        'name_prefix_id'
    ];

    // Role-1 = main admin
    // Role-2 = scientific committee
    // Role-3 = expert
    // Role-4 = user registrations
    // Role-5 = registration committee

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'array'
    ];

    public function userDetail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function conferenceRegistration()
    {
        return $this->hasOne(ConferenceRegistration::class);
    }

    public function workshopRegistration()
    {
        return $this->hasMany(WorkshopRegistration::class);
    }

    public function fullName($user, $value = null)
    {
        if ($value != null) {
            $name = !empty($user->$value->m_name) ? $user->$value->f_name . ' ' . $user->$value->m_name . ' ' . $user->$value->l_name : $user->$value->f_name . ' ' . $user->$value->l_name;
        } else {
            $name = !empty($user->m_name) ? $user->f_name . ' ' . $user->m_name . ' ' . $user->l_name : $user->f_name . ' ' . $user->l_name;
        }
        return $name;
    }

    public function namePrefix()
    {
        return $this->belongsTo(NamePrefix::class, 'name_prefix_id', 'id');
    }

    public function expert()
    {
        return $this->hasOne(Expert::class);
    }
}
