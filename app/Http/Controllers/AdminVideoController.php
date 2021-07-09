<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Validator;
use Auth;
use DB;
use App\Services\VideoService;
use App\Rules\YoutubeUrlRule;
use Illuminate\Support\Str;

class AdminVideoController extends Controller
{
    private $_videoService;

    public function __construct(VideoService $videoService)
    {
        $this->_videoService = $videoService;
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
}
