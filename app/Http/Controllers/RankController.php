<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Rank;
use App\Course;
use App\Events\RankCreated;
class RankController extends Controller
{


	public function store(Course $course)
	{
		
		$newRank = request('starrating');
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
				$course->totalRankModifier($newRank - $oldRank);
			}

			$userToBeRanked = $course->user()->get();
			$score = $userToBeRanked[0]->user_score;
			$score += ($newRank - 2) * (($user->user_score + 100) / 100);
			$userToBeRanked[0]->user_score = $score;
			$userToBeRanked[0]->save();

		}
		event(new RankCreated($course,$newRank,$user));

		return redirect('/courses'."/$course->id");
	}
}
