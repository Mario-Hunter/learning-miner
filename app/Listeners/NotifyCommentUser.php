<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\CommentNotification;

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
     * @return void
     */
    public function handle(CommentCreated $event)
    {
        $comment = $event->comment;
        $course = $comment->course;
        $user_commented_on = $course->user;
        \Mail::to($user_commented_on)->send(new CommentNotification($comment));
    }
}
