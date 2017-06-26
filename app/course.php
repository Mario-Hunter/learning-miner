<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\CommentCreated;
use Illuminate\Support\Facades\Auth;
use App\User;

class Course extends Model
{
    protected $fillable = ['url','tags','name','title','description','image_url'];



    public function comments()
    {
    	return $this->hasMany(Comment::class);
    }

    public function addComent($body)
    {
        $comment = Comment::create(['body' => $body,
            'course_id'=>$this->id,
            'user_id'=>auth()->id()
            ]);
        $this->comments()->save($comment);
        if(Auth::user() != $comment->course->user){
            event(new CommentCreated($comment));
        }
    }

    public function addRank($value)
    {

        $this->rank()->create([
            'rank' => $value,
            'course_id' => $this->id,
            'user_id' => auth()->id()
            ]);
        $this->totalRankModifier($value);
    }

    public function totalRankModifier($value)
    {
        $rankCourse = $this->totalRanks;
        $rankCourse += $value;
        $this->totalRanks = $rankCourse;
        $this->save();
        $this->averageRank();
        $this->dynamicRank();
    }

    public function averageRank()
    {
        $numberOfRanks = 0;
        foreach ($this->rank()->get() as $ranking) {
            $numberOfRanks++;
        }
        
        if($numberOfRanks == 0)
            $numberOfRanks = 1;

        $rank = $this->totalRanks;
        $rank /= (float) $numberOfRanks;
        $this->rank = $rank;
        $this->save();
    }

    public function dynamicRank()
    {
        $averageRank = $this->rank;
        $user = $this->user()->get();
        $rank = auth()->user()->rankValue($this,auth()->user());

        $arrayOfMeanAndSD = $this->standardDeviation();
        $mean = $arrayOfMeanAndSD[0][0];
        $sd = $arrayOfMeanAndSD[0][1];
        
        if($sd == 0)
            $sd = 1;

        $oldEffectRank = $rank['effectScore'];
        $newEffectRank = auth()->user()->user_score * ($rank['rank'] - $mean) / $sd;
        $searchRank = $this->searchRank;
        $searchRank += $newEffectRank - $oldEffectRank;
        $rank['effectScore'] = $newEffectRank;
        $this->searchRank = $searchRank;
        $this->save();
        $rank->save();
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function rank()
    {
        return $this->hasMany(Rank::class);
    }

    public function interest()
    {
        return $this->hasMany(Interest::class);
    }
    
    public function buttonCases()
    {
        $idPrev = $this->id;
        $idPrev--;
        $idNext = $this->id;
        $idNext++;

        $coursePrev = Course::where('id',"$idPrev")->get();
        $courseNext = Course::where('id',"$idNext")->get();

        $prevFlag = false;
        $nextFlag = false;

        foreach ($coursePrev as $key) {
            $prevFlag = true;
        }

        foreach ($courseNext as $key) {
            $nextFlag = true;
        }


        if($nextFlag && $prevFlag)
            return 1;
        else if(!$nextFlag && $prevFlag)
            return 2;
        else if($nextFlag && !$prevFlag)
            return 3;
    }

    public function insertTags($course,$tags)
    {
        foreach($tags as $newTag)
        {
          $bannedWords= "is in at or on ";

          if (stripos($bannedWords, $newTag) == 0 && !is_numeric($newTag) )
          {
            $tag = Tag::firstOrCreate(['name'=>$newTag]);
            
            $course->tags()->syncWithoutDetaching([$tag->id]);
        }
    }
}

public function standardDeviation()
{
    $ranks = $this->rank()->get();

    $r1 = 0;
    $r2 = 0;
    $r3 = 0;
    $r4 = 0;
    $r5 = 0; 

    $r = 0;

    foreach ($ranks as $rank) {

        if($rank->rank == 1)
            $r1++;
        else if($rank->rank == 2)
            $r2++;
        else if($rank->rank == 3)
            $r3++;
        else if($rank->rank == 4)
            $r4++;
        else if($rank->rank == 5)
            $r5++;

        $r++;
    } 

    $mean = (float)(5*$r5 + 4*$r4 + 3*$r3 + 2*$r2 + 1*$r1)/$r;


    $meanSquared = (float)(25*$r5 + 16*$r4 + 9*$r3 + 4*$r2 + 1*$r1)/$r;

    $standardDeviation = sqrt((float)($meanSquared - pow($mean, 2)));
    $arrayOfMeanAndSD[] = array($mean, $standardDeviation);
    return $arrayOfMeanAndSD;
}
}
