<?php

if (!function_exists('gravatar')) {
    /**
     * Generate Gravatar URL
     *
     * @param {string} email
     */
    function gravatar($email)
    {
        return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email)));
    }
}

if (!function_exists('upload_to_s3')) {
    /**
     * Upload File to AWS S3 and Return URL S3
     *
     * @param {string} file
     */
    function upload_to_s3($file)
    {
        // generate uuid filename
        $fileextension = $file->extension();
        $filenewName   = (string) \Str::uuid() . '.' . $fileextension;

        // folder path based on year/month
        $dateNow  = now();
        $filePath = '/' . $dateNow->year . '/' . $dateNow->month;

        // store file attachment to s3 with public access
        $filesave = \Storage::disk('s3')->putFileAs(
            $filePath,
            $file,
            $filenewName,
            'public'
        );

        // build url to files
        $urlFile = \Storage::disk('s3')->url($filesave);

        return $urlFile;
    }
}
