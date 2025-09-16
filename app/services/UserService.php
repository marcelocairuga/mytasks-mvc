<?php
namespace MyTasks\Services;

use MyTasks\Entities\User;
use MyTasks\Repositories\UserRepository;
use DomainException;

class UserService {
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function authenticate(string $email, string $password): User {
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !password_verify($password, $user->getPassword())) {
            throw new DomainException("Credenciais inválidas.");
        }
        return $user;
    }
}