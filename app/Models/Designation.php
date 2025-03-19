<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation', 'order_no', 'status'
    ];

    public function committeeMembers()
    {
        return $this->hasMany(CommitteeMember::class, 'designation_id', 'id');
    }
}
