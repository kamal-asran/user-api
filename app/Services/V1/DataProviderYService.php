<?php

namespace App\Services\V1;

use Illuminate\Support\Facades\File;

class DataProviderYService  extends DataProviderService
{
    public function getUsers()
    {
        $users = [];

        foreach ($this->readJsonData('DataProviderY.json') as $chunk) {
            // Process each chunk of data
            foreach ($chunk as $item) {
                $user = [
                    'balance' => $item['balance'],
                    'currency' => $item['currency'],
                    'email' => $item['email'],
                    'status' => $item['status'],
                    'created_at' => $item['created_at'],
                    'id' => $item['id'],
                    // Add more user attributes as needed
                ];
                $users[] = $user;
            }
        }
        return $users;
    }
}