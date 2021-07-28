<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Services\VideoService;

class YoutubeUrlRule implements Rule
{
    public function passes($attribute, $value)
    {
        $videoService = app()->make(VideoService::class); // this creates an instance of video services

        return $videoService->validateYoutubeUrl($value);
    }

    public function message()
    {
        return 'The Url isnt correct.';
    }
}
