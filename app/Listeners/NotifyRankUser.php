<?php

namespace App\Listeners;

use App\Events\RankCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\RankNotification;
class NotifyRankUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RankCreated  $event
     * @return void
     */
    public function handle(RankCreated $event)
    {
        $course = $event->course;
        $rank = $event->rank;
        $ranking_user =$event->ranking_user;

        \Mail::to($course->user)->send(new RankNotification($course,$rank,$ranking_user));

    }
}
