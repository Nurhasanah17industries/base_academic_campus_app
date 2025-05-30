<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
  use HasUlids;
    
    protected $table = 'student';
    
    protected $fillable = [
        'name',
        'email',
        'NIM',
        'major',
        'enlorment_year'
    ];

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'nim' => 'string',
        ];
    }


    public function enrollment():HasMany{
        return $this->hasMany(Enrollment::class,'student_id');
    }
}
