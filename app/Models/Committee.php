<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    use HasFactory;

    protected $fillable = [
        'committee_name', 'slug', 'focal_person', 'email', 'phone', 'description', 'status'
    ];

    public function committeeMembers()
    {
        return $this->hasMany(CommitteeMember::class, 'committee_id', 'id');
    }
}
