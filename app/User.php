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
        'first_name','last_name','dob','gender', 'email', 'password','confirmation_code','confirmed','avatar'
    ];
    protected $dates = ['dob'];

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

    public function interest()
    {
        return $this->hasMany(Interest::class);
    }
    public function follower()
    {
        return $this->hasMany(follower::class);
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

    public static function checkIfInterestExist(User $user, Course $course)
    {
        $interestsArr = $user->interest()->get();

        foreach ($interestsArr as $interest) {
            if($interest->course_id == $course->id)
                return true;
        }
        return false;
    }

    
    public function addScore($value)
    {
        $score = $this->user_score;
        $score+= $value;
        $this->user_score = $score;
        $this->save();
    }
}
