<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Video;

class VideoController extends Controller
{
    public function index($category, $video_id=null)
    {
        $videos = $video_id ? Video::select(
            'video_id',
            'url',
            'description',
            'title',
            'category'
        )
            ->where('video_id', '=', $video_id)
            ->where('category', '=', $category)
            ->orderByDesc('created_at')
            ->firstOrFail()
                        : Video::select(
                            'video_id',
                            'url',
                            'description',
                            'title',
                            'category'
                        )
            ->where('category', '=', $category)
            ->orderByDesc('created_at')
            ->get();

        return response($videos, 200);
    }
}
