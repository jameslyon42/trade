<?php

namespace App\Models\Repositories;

use App\Models\Entities\User;

class UserRepository
{
    public $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    /**
     * Gets a user with the given email
     *
     * @param string $email
     *
     * @return Mixed
     */
    public function getUserByEmail(string $email)
    {
        $user = $this->userModel->where('email', $email)->first();

        return $user ? $user->toArray() : false;
    }
}