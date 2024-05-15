<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    const PATH = 'uploads/foto';

    const DEPARTMENTS = [
        'Finance',
        'Tech',
        'Marketing',
        'HR',
        'Customer Service',
    ];

    protected $fillable = [
        'nama',
        'nomor',
        'jabatan',
        'departmen',
        'tanggal_masuk',
        'foto',
        'status',
    ];
}
