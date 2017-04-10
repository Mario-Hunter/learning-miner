<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\course;

class Tag extends Model
{
	protected $fillable = ['name'];


    public function course(){
        return $this->belongsToMany(course::class);
    }
}
