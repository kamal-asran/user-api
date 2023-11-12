<?php

namespace App\Services\V1;

use Illuminate\Support\Facades\File;

class DataProviderXService extends DataProviderService
{
    

    public function getUsers()
    {
        $users = [];

        foreach ($this->readJsonData('DataProviderX.json') as $chunk) {
            // Process each chunk of data
            foreach ($chunk as $item) {
                $user = [
                    'parentAmount' => $item['parentAmount'],
                    'Currency' => $item['Currency'],
                    'parentEmail' => $item['parentEmail'],
                    'statusCode' => $item['statusCode'],
                    'registerationDate' => $item['registerationDate'],
                    'parentIdentification' => $item['parentIdentification'],
                    // Add more user attributes as needed
                ];
                $users[] = $user;
            }
        }
        return $users;
    }
}