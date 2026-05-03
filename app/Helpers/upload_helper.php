<?php

if (! function_exists('handle_upload')) {
    function handle_upload($file, $path = 'writable/uploads/research/', $maxWidth = 1920)
    {
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            
            // Move file
            $file->move(ROOTPATH . $path, $newName);
            
            // Compress Image (Basic GD logic)
            $imagePath = ROOTPATH . $path . $newName;
            $info = getimagesize($imagePath);
            
            if ($info) {
                // simple resize if too large
                \Config\Services::image()
                    ->withFile($imagePath)
                    ->resize($maxWidth, $maxWidth, true, 'width')
                    ->save($imagePath);
            }

            return $newName;
        }
        return null;
    }
}
