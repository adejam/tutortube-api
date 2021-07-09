<?php

namespace App\Services;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Str;

class VideoService
{
    public function validateYoutubeUrl(string $url): bool
    {
        $youtubeRegexp = "/^(http(s)?:\/\/)?((w){3}.)?youtube?(\.com)?\/.+/";

        if (preg_match($youtubeRegexp, $url) == 1) {
            return true;
        }

        return false;
    }

    public function addVideoSubmission(array $data, User $user): Model
    {
        $slice = Str::afterLast($data['url'], '=');
        $video = new Video;
        $video->user_id = $user->id;
        $video->video_id = $slice;
        $video->title = $data['title'];
        $video->category = $data['category'];
        $video->url = $data['url'];
        $video->description = $data['description'];
        $video->save();
        return $video;
    }
}
