<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    const CREATED_AT = 'inputdate';
    const UPDATED_AT = 'editdate';
    protected $table = 'attendance';
    protected $fillable = [
        'empid', 'attdate', 'shiftid', 'actualin', 'actualout', 'late', 'early', 'ottotal', 'notes', 'inputdate', 'editdate', 'latitude', 'longitude', 'markas', 'suhu'
    ];

    protected $primaryKey = 'id';
    public $incrementing = true;
}
