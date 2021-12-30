<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Exam extends Model
{
    use HasFactory;

    protected $table ="exams";
    protected $primaryKey = 'exam_id';
    public $timestamps = false;
    protected $fillable = [
        'date',
        'timeslot_id',
        'course_id',
        'tutor_id',
        'exam_type',
    ];



    public function course(){
        return $this->belongsTo(Course::class,'course_id','course_id');
    }

    public function timeslot(){
        return $this->belongsTo(timeslot::class,'timeslot_id','timeslot_id');
    }

    public function invigilations(){
        return $this->hasMany(invigilations::class,'exam_id','exam_id');
    }

    public function tutors()
    {
        return $this->belongsToMany(Tutor::class,invigilations::class,'exam_id','tutor_id');
    }

    public function labs()
    {
        return $this->belongsToMany(Lab::class,'exams_labs','exam_id','lab_id');
    }

}
