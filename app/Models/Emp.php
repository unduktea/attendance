<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emp extends Model {
    use HasFactory;

    protected $table = 'emp';
    protected $fillable = [
        'empid', 'empname', 'gender', 'birthdate', 'placeofbirth', 'atasan1', 'atasan2', 'atasan3', 'created_at',
        'updated_at'
    ];

    protected $primaryKey = 'empid';
    protected $keyType = 'string';
    public $incrementing = false;
}
