<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
  use HasUlids;
    
    protected $table = 'course_enrollment';
    
    protected $fillable = [
        'student_id',
        'course_id',
        'grade',
        'attendence',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'grade' => 'string',
        ];
    }

    public function student():BelongsTo{
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function course():BelongsTo{
        return $this->belongsTo(Course::class, 'course_id');
    }
}
