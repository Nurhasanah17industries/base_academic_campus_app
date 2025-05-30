<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseLecture extends Model
{
  use HasUlids;
    
    protected $table = 'course_lecture';
    
    protected $fillable = [
        'course_id',
        'lecturer_id',
        'role',
    ];

    protected function casts(): array
    {
        return [
            'role' => 'string',
        ];
    }

    public function course():BelongsTo{
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function lecture():BelongsTo{
        return $this->belongsTo(Lecture::class, 'lecturer_id');
    }
}
