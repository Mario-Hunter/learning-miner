<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Rank;
use App\Course;
class RankController extends Controller
{




	public function store(Course $course)
	{
		$newRank = request('rank');
		$user = auth()->user();
		$rankCase = $user->isRanked($course, $newRank ,$user);
		$rank = $user->rankValue($course, $user);

		if(!$rankCase)
		{
			if($rank['rank'] == null)
				$course->addRank($newRank);
			else
			{
				$oldRank = $rank['rank'];
				$rank['rank'] = $newRank;
				$rank->save();
				$course->rankModifier($newRank - $oldRank);
			}
		}

		return redirect('/courses'."/$course->id");
	}




  /*  
	public function storeL(Course $course){

		$user = auth()->user();
		$rankCase = $user->isRanked($course, 1, $user);
		
		$rank = $user->rankValue($course, $user);


		if(!$rankCase)
		{
			if($rank['rank'] == null)
				$course->addRank(1);
			else
			{
				$rank['rank'] = 1;
				$rank->save();
				$course->rankModifier(1);
			}
		}

		return redirect('/courses'."/$course->id");
	}
*/
	/*public function storeD(Course $course){

		$user = auth()->user();
		$rankCase = $user->isRanked($course, -1, $user);
		
		$rank = $user->rankValue($course, $user);

		if(!$rankCase)
		{
			if($rank['rank'] == null)
				$course->addRank(-1);
			else
			{
				$rank['rank'] = -1;
				$rank->save();
				$course->rankModifier(-1);
			}
		}
		return redirect('/courses'."/$course->id");
	}*/
}
