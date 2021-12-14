<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invigilations extends Model
{
    use HasFactory;

    protected $table = "invigilations";

    protected $fillable = [
        'exam_id',
        'tutor_id',
        'invigilation_type',
        'room',
    ];
    public $timestamps = false;
    public function tutor(){
        return $this->belongsTo(Tutor::class,'tutor_id','tutor_id');
    }
    public function exam(){
        return $this->belongsTo(Exam::class,'exam_id','exam_id');
    }
}
