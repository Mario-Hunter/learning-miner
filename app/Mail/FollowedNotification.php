<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FollowedNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $userfollowing;
    public $userfollowed;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userfollowing,$userfollowed)
    {
        $this->userfollowed = $userfollowed;
        $this->userfollowing = $userfollowing;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.FollowNotification');
    }
}
