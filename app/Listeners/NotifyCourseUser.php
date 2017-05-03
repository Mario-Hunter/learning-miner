<?php

namespace App\Listeners;

use App\Events\CourseCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\CourseNotification;

class NotifyCourseUser
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
     * @param  CourseCreated  $event
     * @return void
     */
    public function handle(CourseCreated $event)
    {
        $course= $event->course;
        $user =$course->user;
        \Mail::to($user)->send(new CourseNotification($course));
    }
}
