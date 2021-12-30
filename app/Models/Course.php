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

    public function major(){
        return $this->belongsTo(Major::class,'major_id','major_id');
    }

    public function year(){
        return $this->belongsTo(Year::class,'year_id','year_id');
    }

    public function tutors()
    {
        return $this->belongsToMany(Tutor::class,'courses_tutors','course_id','tutor_id');
    }

    public function exams(){
        return $this->hasMany(Exam::class,'course_id','course_id');
    }

    public function courses_tutors(){
        return $this->hasMany(course_tutor::class,'course_id','course_id');
    }
    /**
     * Get the value of fillable
     */
    public function getFillable()
    {
        return $this->fillable;
    }
}
