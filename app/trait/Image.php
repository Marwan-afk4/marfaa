<?php

namespace App\trait;

use Illuminate\Support\Facades\Storage;

trait Image
{


    public function storeBase64Image($base64Image, $folderPath = 'admin/manuel/receipt'){

        // Validate if the base64 string has a valid image MIME type
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            // Extract the image MIME type
            $imageType = $type[1]; // e.g., 'jpeg', 'png', 'gif', etc.

            // Extract the actual base64 encoded data (remove the data URL part)
            $imageData = substr($base64Image, strpos($base64Image, ',') + 1);
            $imageData = base64_decode($imageData);

            // Generate a unique file name with the appropriate extension
            $fileName = uniqid() . '.' . $imageType;

            // Define the folder path in storage


            // Save the image to the storage disk (default is local)
            Storage::disk('public')->put($folderPath . '/' . $fileName, $imageData);

            // Return the image path
            return $folderPath . '/' . $fileName;
        }

        return response()->json(['error' => 'Invalid base64 image string'], 400);
    }
}
