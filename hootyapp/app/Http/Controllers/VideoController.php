<?php
namespace App\Http\Controllers;

class VideoController extends Controller
{
    public function __construct()
    {

    }

    public function view($userId, $videoId, $filename)
    {
        // $user_id = auth()->guard('web')->user()->id;
        // $AWS_REGION =getenv('AWS_REGION');
        // $AWS_S3_BUCKET = getenv('AWS_S3_BUCKET') ;
        // $videos = DB::table('videos')
        // ->where('user_id', $user_id)
        // ->get();
        error_log($userId);
        error_log($videoId);
        $video_host = \Config::get('app.movie_masher_url');
        $video_path = $video_host . '/user-media/' . $userId . '/' . $videoId . '/' . ($filename == 'default' ? 'original.mp4' : $filename . '.mp4');
        error_log($video_path);
        return view('user.video', compact('video_path'));
    }
}
