<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\CBGateway;

class GuestController extends Controller
{   
   
    public function getProfilePhoto($filename, $width = 160, $height = 160)
    {
        $default_filename = public_path() . '/img/user_photo.png';        
        $content = file_get_contents($default_filename);
        /*$filepath = "account/photograph/" . $filename;
        
        if (Storage::disk('s3')->exists($filepath)) {
            $content = Storage::get($filepath);
        }*/
        return (new Response($content, '201'))->header('Content-Type', 'image/png');
    }
}
