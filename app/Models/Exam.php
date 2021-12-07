<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $table ="exams";

    public function course(){
        return $this->belongsTo(Course::class,'course_id','course_id');
    }
}
