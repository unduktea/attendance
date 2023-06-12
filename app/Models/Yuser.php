<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yuser extends Model
{
    use HasFactory;

    protected $table = 'yuser';

    protected $fillable = [
        'empid', 'password'
    ];
}
