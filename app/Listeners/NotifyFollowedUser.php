<?php

namespace App\Listeners;

use App\Events\Followed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyFollowedUser
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
     * @param  Followed  $event
     * @return void
     */
    public function handle(Followed $event)
    {
        $userfollowing =$event->userfollowing;
        $userfollowed=$event->userfollowed;
        \Mail::to($userfollowed)->send(new FollowedNotification($userfollowing,$userfollowed));
    }
}
