<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    public function uploadFile($file, $directory = 'categories')
    {
        if ($file) {
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs($directory, $fileName, 'public');
            return $fileName;
        }
        return null;
    }
}
