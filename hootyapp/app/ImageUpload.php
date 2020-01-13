<?php 
namespace App;

use DB;
use File;

class ImageUpload
{

    public static function removeFile($path)
    {
        if(File::exists(public_path($path))){
            File::delete(public_path($path));
        }
    }

    public static function upload($path, $image)
    {
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path($path),$imageName);

        return $imageName;
    }

    public static function uploadimg($path, $image, $imgname)
    {
        $imageName = $imgname.'.'.$image->getClientOriginalExtension();
        $image->move(public_path($path),$imageName);

        return $imageName;
    }
}
