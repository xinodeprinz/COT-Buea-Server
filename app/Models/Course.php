<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'course_title',
        'credit_value',
        'course_master',
        'semester',
        'level',
        'department_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'level',
        'id',
        'department_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
