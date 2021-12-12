<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use App\Services\LessonService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LessonWatchedListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(LessonWatched $event)
    {
        $lesson = new LessonService;
        return   $lesson->lesson_service($event->user, $event->lesson);
    }
}
