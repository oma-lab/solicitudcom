<?php

namespace Tests;
use Illuminate\Http\UploadedFile;

trait MocksFileUploads{
    public function uploadedFile($path){
        
        $this->assertFileExists($path);

        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($fileInfo, $path);

        return new UploadedFile(
            $path, '', $mime, filesize($path), null, true
        );
    }
}