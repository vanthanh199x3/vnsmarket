<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Intervention\Image\Facades\Image;

class ResizeUploadedImage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // $img = Image::make($event->path());

        // if($img->height() <= 720) {
        //     return;
        // }

        // $img->encode('jpg', 65); 
        // $img->resize(null, 720, function ( $constraint ) { 
        //     $constraint->aspectRatio(); 
        // });

        // $img->save();
    }
}
