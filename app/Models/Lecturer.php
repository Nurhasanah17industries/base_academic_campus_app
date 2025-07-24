<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lecturer extends Model
{
    use HasUlids;


    protected $fillable = [
        'name',
        'NIP',
        'department',
        'email',
    ];

    public function courseLecturers(): HasMany
    {
        return $this->hasMany(CourseLecturer::class, 'lecturer_id');
    }
}
