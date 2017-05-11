<?php

namespace App\Listeners;

use App\Events\CourseCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\CourseNotification;
use App\ActivityLog;

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
        $log = ActivityLog::create(['user_id'=>$user->id,
            'course_id'=>$course->id,
            'action_type'=>"course",
            'action_body'=>$course->name
            ]);
        \Mail::to($user)->send(new CourseNotification($course));
    }
}
