<?php

namespace App\DTO;

use App\Traits\Transform;

class MerchantResult
{
    use Transform;

    public function __construct(
        public readonly array $customerInfo,
    ) {}

    /**
     * Static method to convert the API response to a DTO.
     * This method is used to create an instance of the DTO from an array.
     * 
     * @param array $data
     * @return self The constructed MerchantResult DTO.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            customerInfo: self::getCustomerInfo($data[0]['customerInfo'] ?? []),
        );
    }
}
