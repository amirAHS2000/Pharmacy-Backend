<?php


namespace App\Globals;

class FileHandler
{
    /**
     * it will move uploaded file to asked path
     * base-path represent the path of file
     *
     * @param $file
     * @param $fileBasePath
     * @param $fileName
     * @return string
     */
    static function uploadFile($file, $fileName = '', $fileBasePath = '')
    {
        if (isset($file)) {
            $fileName = str_replace(' ', '-', $fileName);
            $extension = $file->getClientOriginalExtension();
            $fileName = $fileName .'_'. time() . '.' . $extension;
            $path = public_path() . '/' . $fileBasePath;
            $file->move($path, $fileName);
            return $fileName;
        } else return null;
    }

    static function getFile($fileName, $fileBasePath = '')
    {
        if (!is_null($fileName)) {
            return asset($fileBasePath . '/' . $fileName);
        } else return null;
    }
}
