<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\CourseCreated' => [
            'App\Listeners\NotifyCourseUser',

        ],

        'App\Events\CommentCreated' => [
            'App\Listeners\NotifyCommentUser',
            
        ],

        'App\Events\RankCreated' => [
            'App\Listeners\NotifyRankUser',
            
        ],



    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
