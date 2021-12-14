<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exams_labs extends Model
{
    use HasFactory;

    protected $table = "exams_labs";
    public $timestamps = false;
    public function labs(){
        return $this->belongsTo(Lab::class,'lab_id','lab_id');
    }
}
