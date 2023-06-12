<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lemburs extends Model
{
    use HasFactory;

    protected $table = 'lemburs';
    protected $fillable = [
        'empid', 'tanggal', 'shift', 'over_before', 'over_after', 'break_before', 'break_after', 'kompensation', 'reason', 'status', 'created_at', 'updated_at'
    ];

    protected $primaryKey = 'id';
    public $incrementing = true;
}
