<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RankNotification extends Mailable
{
    public $course;
    public $rank;
    public $ranking_user;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($course,$rank,$ranking_user)
    {
        $this->course = $course;
        $this->rank = $rank;
        $this->ranking_user = $ranking_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.RankNotification');
    }
}
