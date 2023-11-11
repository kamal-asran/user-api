<?php

namespace App\Services\V1;

use Illuminate\Support\Facades\File;

class UserService
{
    public function getUsers()
    {
        $dataProviderX = $this->readJsonData('DataProviderX.json');
        $dataProviderY = $this->readJsonData('DataProviderY.json');

        // Combine the data from providers and return the users
        $users = array_merge($dataProviderX, $dataProviderY);

        // Apply filters
        if (isset($filters['provider'])) {
            $users = array_filter($users, function ($user) use ($filters) {
                return $user['provider'] === $filters['provider'];
            });
        }

        if (isset($filters['statusCode'])) {
            $users = array_filter($users, function ($user) use ($filters) {
                return $this->getStatusCodeValue($user) === $filters['statusCode'];
            });
        }

        if (isset($filters['balanceMin'])) {
            $users = array_filter($users, function ($user) use ($filters) {
                return $user['balance'] >= $filters['balanceMin'];
            });
        }

        if (isset($filters['balanceMax'])) {
            $users = array_filter($users, function ($user) use ($filters) {
                return $user['balance'] <= $filters['balanceMax'];
            });
        }

        if (isset($filters['currency'])) {
            $users = array_filter($users, function ($user) use ($filters) {
                return $user['currency'] === $filters['currency'];
            });
        }

        return $users;
    }

    private function getStatusCodeValue($user)
    {
        $statusCodes = [
            'DataProviderX' => [
                1 => 'authorised',
                2 => 'decline',
                3 => 'refunded',
            ],
            'DataProviderY' => [
                100 => 'authorised',
                200 => 'decline',
                300 => 'refunded',
            ],
        ];

        return $statusCodes[$user['provider']][$user['statusCode']] ?? null;
    }

    private function readJsonData($filename)
    {
        $filePath = storage_path("app/{$filename}");

        if (File::exists($filePath)) {
            // Read the file and return the decoded JSON data
            $jsonData = File::get($filePath);
            return json_decode($jsonData, true);
        }

        return [];
    }
}