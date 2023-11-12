<?php

namespace App\Services\V1;

use Illuminate\Support\Facades\File;

class DataProviderService
{
    public function readJsonData($filename)
    {
        $filePath = storage_path("app/{$filename}");

        if (File::exists($filePath)) {
            $jsonData = File::get($filePath);
            $decodedData = json_decode($jsonData, true);

            // Split the data into smaller chunks for processing
            $chunkedData = array_chunk($decodedData, 500); // Adjust the chunk size as needed

            return $chunkedData;
        }

        return [];
    }
}