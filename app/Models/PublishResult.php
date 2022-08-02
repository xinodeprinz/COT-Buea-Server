<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester',
        'academic_year'
    ];

    protected $hidden = [
        'updated_at'
    ];
}
