<?php

namespace App\DTO;

use App\Traits\Transform;

class TransactionsResult
{
    use Transform;

    public function __construct(
        public readonly array $data,
    ) {}

    /**
     * Static method to convert the API response to a DTO.
     * This method takes an array as input and returns a TransactionsResult object.
     * 
     * @param array $data
     * @return self The constructed TransactionsResult DTO.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            data: self::getTransactionsData($data ?? []),
        );
    }
}
