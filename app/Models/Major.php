<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $table = 'majors';
    public $timestamps = false;
    public function course(){
        return $this->hasMany(Course::class);
    }
}
