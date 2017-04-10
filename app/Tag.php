<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $fillable = ['name'];


    public function courses(){
        return $this->belongsToMany(Course::class);
    }

    public function getRouteKeyName(){
    	return 'name';
    }
}
