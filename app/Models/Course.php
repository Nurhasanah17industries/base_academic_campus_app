<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
  use HasUlids;
    
    protected $table = 'courses';
    
    protected $fillable = [
        'name',
        'code',
        'credits',
        'semester'
    ];

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'code' => 'string',
        ];
    }

    public function courselecture():HasMany{
        return $this->hasMany(CourseLecture::class,'course_id');
    }

    public function enrollment():HasMany{
        return $this->hasMany(Enrollment::class,'course_id');
    }

}
