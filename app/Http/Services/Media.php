<?php
namespace App\Http\Services;

class Media{

    public  static function upload(object $image,string $dir) : string
    {
        //upload image
        $newimagename= $image->hashName();
        $image->move(public_path($dir),$newimagename);
        return $newimagename;
    }

    public  static function delete(string $photopath) : bool
    {
        if(file_exists($photopath)){
            unlink($photopath);
            return true;
        }
        return false;
    }
}




