<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasUlids;


    protected $fillable = [
        'name',
        'email',
        'NIM',
        'major',
        'enrollment_year',
    ];

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    // public function getRouteKeyName()
    // {
    //     return 'student_id';
    // }


}
