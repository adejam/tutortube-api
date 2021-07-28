<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Comment;
use Validator;
use Auth;
use DB;
use App\Services\VideoService;
use App\Rules\YoutubeUrlRule;
use Illuminate\Support\Str;
use App\Http\Controllers\VideoController;

class AdminVideoController extends Controller
{
    private $_videoService;

    public function __construct(VideoService $videoService)
    {
        $this->_videoService = $videoService;
    }

    public function index($category)
    {
        $res = VideoController::index($category);
        return $res;
    }

    public function singleVideo($category, $video_id)
    {
        $res = VideoController::singleVideo($category, $video_id);
        return $res;
    }
    
    public function store(Request $request)
    {
        $rules = array(
            'title' => ['required', 'string', 'max:191'],
            'url' => ['required', 'url', 'max:191', new YoutubeUrlRule],
            'category' => ['required', 'string', 'max:191'],
            'description' => ['required', 'string', 'max:1000'],
        );

        $data = request()->validate($rules);
        $video = $this->_videoService->addVideoSubmission($data, Auth::user());
        return response(
            [
            'message' => "Video Added Successfully",
            'video' => $video,
            ],
            201
        );
    }

    public function update(Request $request)
    {
        $rules = array(
            'title' => ['required', 'string', 'max:191'],
            'description' => ['required', 'string', 'max:1000'],
        );

        $video = Video::where('video_id', '=', $request->video_id)
            ->first();

        if (!$video) {
            return response(['error' => 'The page does not exist.'], 404);
        }

        $data = request()->validate($rules);

        $video->title = $data['title'];
        $video->description = $data['description'];
        $video->save();

        return response(
            [
            'message' => "Video Updated Successfully",
            'video' => $video,
            ],
            200
        );
    }

    public function delete(Request $request)
    {
        $video = Video::where('video_id', '=', $request->video_id)->first();
        
        $comments = Comment::where('video_id', '=', $video->video_id)->get();
        foreach ($comments as $comment) {
            $comment->delete();
        }
        $video->delete();
        return response(
            [
            'message' => 'video deleted successfully'
            ],
            200
        );
    }
}
