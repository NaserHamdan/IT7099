<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inviligations extends Model
{
    use HasFactory;

    protected $table = "invigilations";

    protected $fillable = [
        'exam_id',
        'tutor_id',
        'invigilation_type',
        'room',
    ];

    public function tutor(){
        return $this->belongsTo(Tutor::class,'tutor_id','tutor_id');
    }
}
