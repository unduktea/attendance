<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cutis extends Model
{
    use HasFactory;

    protected $table = 'cutis';
    protected $fillable = [
        'id', 'empid', 'tgl_mulai', 'tgl_selesai', 'alasan', 'acc1', 'acc2', 'acc3', 'disetujui1', 'disetujui2', 'disetujui3', 'status'
    ];

    protected $primaryKey = 'id';
    public $incrementing = true;
}
