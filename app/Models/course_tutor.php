<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course_tutor extends Model
{
    use HasFactory;
    protected $table = 'courses_tutors';

    protected $fillable = [
        'course_id',
        'tutor_id',
    ];
    public $timestamps = false;

}
