<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function courses(){
        return $this->hasMany(Course::class);
    }

    public function publish(Course $course){

        $this->courses()->save($course);
    }

    public function rank()
    {
        return $this->hasMany(Rank::class);
    }

    public function isRanked(Course $course, $value, User $user)
    {
        
        foreach ($course->rank()->get() as $rank) 
        {
            if($rank->user_id == $user->id && $rank->rank == $value)
            {
                return true;   
            }
            else if($rank->user_id == $user->id && $rank->rank != $value)
            {
                return false;
            }
        }
        return null;
    }

    public function rankValue(Course $course, User $user)
    {
        foreach ($course->rank()->get() as $rank) 
        {
            if($rank->user_id == $user->id)
                return $rank;   
        }
        return null;
    }

}
