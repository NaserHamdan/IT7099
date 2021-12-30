<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Setting extends Model
{
    use HasFactory;

    protected $table = "settings";
    protected $primaryKey = 'setting_id';
    public $timestamps = false;
    protected $fillable = [
        'setting_id',
        'start_date',
        'end_date',
        'timetable_type',
    ];
}
