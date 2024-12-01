<?php

namespace App\Interfaces;


use App\Repositories\UserRepository;
use App\Models\User;


interface UserServiceInterface{

    public function createUser(UserRepository $userRepositories);
    public function getUserById(int $userId);
    public function setUpPin(User $user, string $pin): void;
    public function validatePin(int $userId, string $pin): bool;
    public function hasSetPin(User $user): bool;
}