<?php

namespace App\DTO;

class TransactionReportResult
{
    public function __construct(
        public readonly string $status,
        public readonly array $data,
    ) {}

    /**
     * This method to convert the API response to a DTO.
     * This method takes an array as input and returns a TransactionReportResult DTO.
     * 
     * @param array $data
     * @return self The constructed TransactionReportResult DTO.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: $data['status'],
            data: $data['response'],
        );
    }
}
