<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $timestamps = false;

    protected $fillable = [
        'name',
        'matricule',
        'email',
        'level',
        'date_of_birth',
        'sub_division',
        'place_of_birth',
        'phone_number',
        'gender',
        //'country',
        'region',
        'father_name',
        'mother_name',
        'father_contact',
        'mother_contact',
        'parent_address',
        'department',
        'passed_concour',
        'certificate',
        'has_graduated',
        'image_url',
        'birth_certificate',
        'gce_ol',
        'gce_al',
        'password',
        'registered_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    protected $hidden = [
        'id',
        'gce_al',
        'gce_ol',
        'birth_certificate',
        'password',
        'passed_concour',
        'has_graduated'
        //'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function department()
    {
        return $this->hasOne(Department::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}
