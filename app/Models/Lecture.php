<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lecture extends Model
{
  use HasUlids;
    
    protected $table = 'lecture';
    
    protected $fillable = [
        'name',
        'NIP',
        'department',
        'email'
    ];

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'NIP' => 'string',
        ];
    }

    public function courselecture():HasMany{
        return $this->hasMany(CourseLecture::class,'lecturer_id');
    }
}
