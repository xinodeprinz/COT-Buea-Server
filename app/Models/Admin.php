<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'current_semester',
        'current_academic_year',
        'data',
        'password',
        'fee_types'
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at'
    ];
}
