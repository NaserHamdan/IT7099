<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    use HasFactory;

    protected $table = 'tutors';
    protected $primaryKey = 'tutor_id';
    public $timestamps = false;
    protected $fillable = [
        'tutor_name',
        'position',
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
