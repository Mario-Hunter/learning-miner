<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\CommentNotification;
use App\ActivityLog;

class NotifyCommentUser
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
     * @param  CommentCreated  $event
     * @return voids
     */
    public function handle(CommentCreated $event)
    {

        $comment = $event->comment;
        $course = $comment->course;
        $user_commented_on = $course->user;
        $user_commenting=$comment->user;
        $log = ActivityLog::create(['user_id'=>$user_commenting->id,
            'course_id'=>$course->id,
            'action_type'=>"comment",
            'action_body'=>$comment->body
            ]);
        dd($log);
        

        \Mail::to($user_commented_on)->send(new CommentNotification($comment));
    }
}
