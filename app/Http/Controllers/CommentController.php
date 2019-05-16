<?php
//©Alibek009
namespace App\Http\Controllers;

use App\Comment;
use App\Lesson;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function store(Request $request)
    {
        $comment = new Comment;
        $comment->body = $request->get('comment_body');
        $comment->user()->associate($request->user());
        $post = Lesson::find($request->get('post_id'));
        $post->comments()->save($comment);

        return back();
    }


    public function replyStore(Request $request)
    {
        $reply = new Comment();
        $reply->body = $request->get('comment_body');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $post = Lesson::find($request->get('post_id'));
        $post->comments()->save($reply);
        return back();
    }


}
