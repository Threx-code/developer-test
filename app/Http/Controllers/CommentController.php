<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Events\CommentWritten;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        if ($request->validated()) {

            Comment::create([
                'body' => $request->body,
                'user_id' => $request->user_id
            ]);
            $comment =  Comment::where('user_id', $request->user_id)->get()->first();
            return event(new CommentWritten($comment));
        }
    }
}
