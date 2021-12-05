<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    public $timestamps = false;
    protected $fillable = [
        'course_code',
        'course_title',
        'number_of_students',
        'marking_diffucality',
        'course_coordinator',
        'have_exam',
        'year_id',
        'major_id',
        'reviewed',
    ];

    /**
     * Get the value of fillable
     */
    public function getFillable()
    {
        return $this->fillable;
    }
}
