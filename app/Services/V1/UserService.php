<?php

namespace App\Services\V1;

class UserService
{
    private $providers;

    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    public function getUsers()
    {
        $users = [];

        foreach ($this->providers as $provider) {
            foreach ($provider->getUsers() as $chunkUsers) {
                $users = array_merge($users, $chunkUsers);
            }
        }

        return $users;

    }

}