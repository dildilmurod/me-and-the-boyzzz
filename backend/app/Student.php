<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guard = 'api';

    protected $fillable = [
        'username', 'name', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

//    public function findForPassport($username) {
//        return $this->where('id', $username)->first();
//    }
    public function findForPassport($identifier) {
        return $this->where('username', $identifier)->first();
    }

    public function task(){
        return $this->hasMany('App\Models\Task');
    }

    public function comments(){
        return $this->belongsToMany('App\Models\Comment', 'comment_student', 'student_id', 'comment_id' );
    }












}
