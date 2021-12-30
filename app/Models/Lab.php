<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $table = 'labs';
    protected $primaryKey = 'lab_id';
    public $timestamps = false;
    protected $fillable = [
        'room',
        'building',
        'capacity',
        'reviewed',
    ];



    public function exams_labs(){
        return $this->hasMany(exams_labs::class,'lab_id','lab_id');
    }

    /**
     * Get the value of fillable
     */
    public function getFillable()
    {
        return $this->fillable;
    }
}
