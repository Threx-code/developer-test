<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use App\Services\CommentService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentWrittenListener
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
    public function handle(CommentWritten $event)
    {
        $commentService = new CommentService;
        return $commentService->comment_service($event->comment->user_id);
    }
}
