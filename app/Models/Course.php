<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasUlids;

    protected $fillable = [ 'name', 'code', 'credits', 'semester'];

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'course_id');
    }

    public function courseLecturers(): HasMany
    {
        return $this->hasMany(CourseLecturer::class, 'course_id');
    }
}
