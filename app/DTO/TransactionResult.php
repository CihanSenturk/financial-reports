<?php

namespace App\DTO;

use App\Traits\Transform;

class TransactionResult
{
    use Transform;

    public function __construct(
        public readonly array $customerInfo,
        public readonly array $fx,
        public readonly array $merchant,
        public readonly array $transaction,
    ) {}

    /**
     * Static method to convert the API response to a DTO.
     * This method takes an array as input and returns a TransactionResult object.
     * 
     * @param array $data
     * @return self The constructed TransactionResult DTO.
     */
    public static function fromArray(array $data): self
    {
        $customerInfo = self::getCustomerInfo($data[0]['customerInfo'] ?? []);

        $fx = self::getTransactionFx($data[0]['fx']['merchant'] ?? []);

        $transaction = self::getTransactionData($data[0]['transaction']['merchant'] ?? []);

        $merchant = [
            'name' => $data[0]['merchant']['name'] ?? null,
        ];

        return new self(
            customerInfo: $customerInfo,
            fx: $fx,
            merchant: $merchant,
            transaction: $transaction,
        );
    }
}
