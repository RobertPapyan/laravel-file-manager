<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait SearchTrait
{


    public function getSearchContent($disk,$search){
        $allFiles = Storage::allFiles($disk);
        $allDirectories = Storage::allDirectories($disk);
        $files = [];
        $directories = [];
        foreach($allFiles as $index => $file){

            if(str_contains(basename($file),$search)){
                array_push($files,[
                    "type" => "file",
                    "path" => $file,
                    "basename" => basename($file),
                    "dirname" => $this->cutDisk(dirname($file),$disk),
                    "extension" => pathinfo($file, PATHINFO_EXTENSION),
                    "filename" => pathinfo($file, PATHINFO_FILENAME),
                    "size" => Storage::size($file),
                    "timestamp" => Storage::lastModified($file),
                    "visibility" => Storage::getVisibility($file)
                ]);
            }
        }

        foreach($allDirectories as $index => $dir){
            if(str_contains(basename($dir),$search)){
                array_push($directories,[
                    "type" => "dir",
                    "path" => $dir,
                    "basename" => basename($dir),
                    "dirname" => $this->cutDisk(dirname($dir),$disk),
                    "timestamp" => Storage::lastModified($dir),
                    "visibility" => Storage::getVisibility($dir)
                ]);
            }
        }


        return ["files" => $files,  "directories"=>$directories ];
    }

    public function cutDisk($path,$disk){
        $pos = strpos($path, $disk);
     if ($pos !== false) {
            $newPath = substr_replace($path,'', $pos, strlen($disk)+1);
        }
        return $newPath;
    }
}
