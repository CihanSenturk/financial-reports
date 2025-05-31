<?php

namespace App\DTO;

class AuthResult
{
    public function __construct(
        public readonly string $token,
        public readonly string $status,
    ) {}

    /**
     * Static method to convert the API response to a DTO.
     * This method is used to create an instance of the DTO from an array.
     * 
     * @param array $data
     * @return self The constructed AuthResult DTO.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            token: $data['token'],
            status: $data['status'],
        );
    }

    /**
     * To return the DTO as an array.
     * 
     * @return array
     */
    public function toArray(): array
    {
        return [
            'token'     => $this->token,
            'status'    => $this->status,
        ];
    }
}
