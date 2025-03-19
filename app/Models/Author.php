<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id', 'name', 'email', 'designation', 'institution', 'institution_address', 'phone', 'main_author', 'status'
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
