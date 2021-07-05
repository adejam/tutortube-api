<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use App\Models\Video;

class VideoController extends Controller
{
    public function index($category)
    {
        $videos = DB::table('videos')->select(
            'video_id',
            'url',
            'description',
            'title',
            'category'
        )
            ->where('category', '=', $category)
            ->orderByDesc('created_at')
            ->get();

        $categoriesArray = [ 'html','css', 'javascript', 'react', 'next','bootstrap'];

        $categoryExist = existInArray($categoriesArray, $category);

        if (!$categoryExist) {
            return response(['error' => 'The page does not exist.'], 404);
        }

        return response(['videos' => $videos], 200);
    }

    public function singleVideo($category, $video_id)
    {
        $video = Video::select(
            'video_id',
            'url',
            'description',
            'title',
            'category'
        )
            ->where('videos.video_id', '=', $video_id)
            ->where('videos.category', '=', $category)
            ->first();

        if (!$video) {
            return response(['error' => 'The page does not exist.'], 404);
        }
        $comments = $video->comments()
            ->join('users', 'users.id', 'comments.user_id')
            ->select(
                'users.name',
                'comment',
            )
            ->orderByDesc('comments.created_at')
            ->get();

        return response(['video' => $video, 'comments' => $comments ], 200);
    }
}
