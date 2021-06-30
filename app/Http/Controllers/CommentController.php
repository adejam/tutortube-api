<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Video;
use App\Models\Comment;
use Auth;
use DB;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $rules = array(
        'comment' => 'required|string|max:191',
        'video_id' => 'required|string|max:191',
        );

        $data = $request->validate($rules);
        $video = DB::table('videos')
            ->select('video_id')
            ->where('video_id', '=', $request->video_id)
            ->first();

        if (!$video) {
            abort(404);
        }
        
        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->video_id = $video->video_id;
        $comment->comment = $data['comment'];
        $comment->save();
        return response(
            [
            'message' => "Video Added Successfully",
            'comment' => $comment,
            ],
            201
        );
    }
}
