<?php
namespace App\DTO;
class UserLoginReturnDataDTO {
    public string $type = "UserLoginReturnDataDTO";
    public string $token;
    public array $userData;

    public function __construct(string $token, array $userData) {
        $this->token = $token;
        $this->userData = $userData;
    }
    public function ReturnUserData( array $userData) {

        $this->userData = $userData;
    }
}