<?php

namespace App\Http\Controllers;

use App\Classes\YouTubeDownloader;
use App\Tag;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class VideoController extends Controller
{
    public function download()
    {
        return view('video.download');
    }

    public function store(Request $request){

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'video_url' => 'required|string|max:255',
            'video_tag' => 'required|string'
        ]);

        $handler = new YouTubeDownloader();

        // Youtube video url
        $youtubeURL = $request->video_url;


        // Check whether the url is valid
        if(!empty($youtubeURL) && !filter_var($youtubeURL, FILTER_VALIDATE_URL) === false){
            // Get the downloader object
            $downloader = $handler->getDownloader($youtubeURL);

            // Set the url
            $downloader->setUrl($youtubeURL);

            // Validate the youtube video url
            if($downloader->hasVideo()){
                // Get the video download link info


                $videoDownloadLink = $downloader->getVideoDownloadLink();

                $videoTitle = $videoDownloadLink[0]['title'];
                $videoQuality = $videoDownloadLink[0]['quality'];
                $videoFormat = $videoDownloadLink[0]['format'];
                $videoFileName = strtolower(str_replace(' ', '_', $videoTitle)).'.'.$videoFormat;
                $downloadURL = $videoDownloadLink[0]['url'];

                //
                $fileName = preg_replace('/[^A-Za-z0-9.\_\-]/', '', basename($videoFileName));

                if(!empty($downloadURL)){
                    // Define headers
                    header("Cache-Control: public");
                    header("Content-Description: File Transfer");
                    header("Content-Disposition: attachment; filename=$fileName");
                    header("Content-Type: application/zip");
                    header("Content-Transfer-Encoding: binary");



                    try{
                        set_time_limit(0); // unlimited max execution time
                        $source = '/videos/'.date('m-d-Y-His').'.mp4';
                        $options = array(
                            CURLOPT_FILE    => $source,
                            CURLOPT_TIMEOUT =>  28800, // set this to 8 hours so we dont timeout on big files
                            CURLOPT_URL     => $downloadURL,
                        );
                        $ch = curl_init();
                        curl_setopt_array($ch, $options);
                       // curl_exec($ch);
                        curl_close($ch);


                        // create video
                        $video = auth()->user()->videos()->create([
                            'title' => $request->title,
                            'source' => 'test'
                        ]);

                        // create tags for video
                        $tags = explode(',',$request->video_tag);
                        $video->tag($tags);
                    }catch(Exception $exception){
                        echo 'Caught exception: '.  $exception->getMessage();
                    }




                   // return redirect(route('video.download'));

                    // Read the file
                    //readfile($downloadURL);

                }
            }else{
                echo "The video is not found, please check YouTube URL.";
            }
        }else{
            echo "Please provide valid YouTube URL.";
        }


        /*$video = Video::create([
            'name' => $request->name,
            'label' => $request->label
        ]);*/

        //$video->tags()->sync($request->)
    }
}
