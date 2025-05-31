<?php

namespace App\Traits;

trait Transform
{
    /**
     * This method is used to transform the customer data into a structured array.
     * It extracts relevant fields from the customer array and returns them in a specific format.
     *
     * @param array $customer
     * @return array
     */
    public static function getCustomerInfo($customer = []): array
    {
        if (empty($customer)) {
            return [];
        }
        
        return [
            'id'                => $customer['id'] ?? null,
            'created_at'        => $customer['created_at'] ?? null,
            'updated_at'        => $customer['updated_at'] ?? null, 
            'deleted_at'        => $customer['deleted_at'] ?? null,
            'number'            => $customer['number'] ?? null,
            'expiryMonth'       => $customer['expiryMonth'] ?? null,
            'expiryYear'        => $customer['expiryYear'] ?? null,
            'startMonth'        => $customer['startMonth'] ?? null,
            'startYear'         => $customer['startYear'] ?? null,
            'issueNumber'       => $customer['issueNumber'] ?? null,
            'email'             => $customer['email'] ?? null,
            'birthday'          => $customer['birthday'] ?? null,
            'gender'            => $customer['gender'] ?? null,
            'billingTitle'      => $customer['billingTitle'] ?? null,
            'billingFirstName'  => $customer['billingFirstName'] ?? null,
            'billingLastName'   => $customer['billingLastName'] ?? null,
            'billingCompany'    => $customer['billingCompany'] ?? null,
            'billingAddress1'   => $customer['billingAddress1'] ?? null,
            'billingAddress2'   => $customer['billingAddress2'] ?? null,
            'billingCity'       => $customer['billingCity'] ?? null,
            'billingState'      => $customer['billingState'] ?? null,
            'billingPostcode'   => $customer['billingPostcode'] ?? null,
            'billingCountry'    => $customer['billingCountry'] ?? null,
            'billingPhone'      => $customer['billingPhone'] ?? null,
            'billingFax'        => $customer['billingFax'] ?? null,
            'shippingTitle'     => $customer['shippingTitle'] ?? null,
            'shippingFirstName' => $customer['shippingFirstName'] ?? null,
            'shippingLastName'  => $customer['shippingLastName'] ?? null,
            'shippingCompany'   => $customer['shippingCompany'] ?? null,
            'shippingAddress1'  => $customer['shippingAddress1'] ?? null,
            'shippingAddress2'  => $customer['shippingAddress2'] ?? null,
            'shippingCity'      => $customer['shippingCity'] ?? null,
            'shippingState'     => $customer['shippingState'] ?? null,
            'shippingPostcode'  => $customer['shippingPostcode'] ?? null,
            'shippingCountry'   => $customer['shippingCountry'] ?? null,
            'shippingPhone'     => $customer['shippingPhone'] ?? null,
            'shippingFax'       => $customer['shippingFax'] ?? null,
            'token'             => $customer['token'] ?? null,
        ];
    }

    /**
     * This method is used to transform the foreign exchange (FX) data into a structured array.
     * It extracts relevant fields from the FX array and returns them in a specific format.
     *
     * @param array $fx
     * @return array
     */
    public static function getTransactionFx($fx= []): array
    {
        if (empty($fx)) {
            return [];
        }
        
        return [
            'merchant' => [
                'originalAmount'    => $fx['originalAmount'] ?? null,
                'originalCurrency'  => $fx['originalCurrency'] ?? null,
            ]
        ];
    }

    /**
     * This method is used to transform the transaction data into a structured array.
     * It extracts relevant fields from the transaction array and returns them in a specific format.
     *
     * @param array $transaction
     * @return array
     */
    public static function getTransactionData($transaction = []): array
    {
        if (empty($transaction)) {
            return [];
        }
        
        return [
            'merchant' => [
                'referenceNo'               => $transaction['referenceNo'] ?? null,
                'merchantId'                => $transaction['merchantId'] ?? null,
                'status'                    => $transaction['status'] ?? null,
                'channel'                   => $transaction['channel'] ?? null,
                'customData'                => $transaction['customData'] ?? null,
                'type'                      => $transaction['type'] ?? null,
                'agentInfoId'               => $transaction['agentInfoId'] ?? null,
                'operation'                 => $transaction['operation'] ?? null,
                'created_at'                => $transaction['created_at'] ?? null,
                'updated_at'                => $transaction['updated_at'] ?? null,
                'id'                        => $transaction['id'] ?? null,
                'fxTransactionId'           => $transaction['fxTransactionId'] ?? null,
                'acquirerTransactionId'     => $transaction['acquirerTransactionId'] ?? null,
                'code'                      => $transaction['code'] ?? null,
                'message'                   => $transaction['message'] ?? null,
                'transactionId'             => $transaction['transactionId'] ?? null,
                'agent'                     => self::getTransactionAgent($transaction['agent'] ?? []),
            ],
        ];
    }

    /**
     * This method is used to transform the agent data into a structured array.
     * It extracts relevant fields from the agent array and returns them in a specific format.
     *
     * @param array $agent
     * @return array
     */
    public static function getTransactionAgent($agent = []): array
    {
        if (empty($agent)) {
            return [];
        }
        
        return [
            'id'                => $agent['id'] ?? null,
            'customerIp'        => $agent['customerIp'] ?? null,
            'customerUserAgent' => $agent['customerUserAgent'] ?? null,
            'merchantIp'        => $agent['merchantIp'] ?? null,
            'merchantUserAgent' => $agent['merchantUserAgent'] ?? null,
            'created_at'        => $agent['created_at'] ?? null,
            'updated_at'        => $agent['updated_at'] ?? null,
            'deleted_at'        => $agent['deleted_at'] ?? null,
            'index_hash'        => $agent['index_hash'] ?? null,
        ];
    }

    /**
     * This method is used to transform the transactions data into a structured array.
     * It extracts relevant fields from the transactions array and returns them in a specific format.
     *
     * @param array $data
     * @return array
     */
    public static function getTransactionsData($data = []): array
    {
        if (empty($data)) {
            return [];
        }

        $transactions = [];

        foreach ($data as $key => $transaction) {
            $transactions[$key] = [
                'updated_at'    => $transaction['updated_at'] ?? null,
                'created_at'    => $transaction['created_at'] ?? null,
                'customerInfo' => [
                    'number'            => $transaction['customerInfo']['number'] ?? null,
                    'email'             => $transaction['customerInfo']['email'] ?? null,
                    'billingFirstName'  => $transaction['customerInfo']['billingFirstName'] ?? null,
                    'billingLastName'   => $transaction['customerInfo']['billingLastName'] ?? null,
                ],
                'fx' => [
                    'merchant' => [
                        'originalAmount'    => $transaction['fx']['merchant']['originalAmount'] ?? null,
                        'originalCurrency'  => $transaction['fx']['merchant']['originalCurrency'] ?? null,
                        'convertedAmount'   => $transaction['fx']['merchant']['convertedAmount'] ?? null,
                        'convertedCurrency' => $transaction['fx']['merchant']['convertedCurrency'] ?? null,
                    ]
                ],
                'merchant' => [
                    'id'                    => $transaction['merchant']['id'] ?? null,
                    'name'                  => $transaction['merchant']['name'] ?? null,
                    'allowPartialRefund'    => $transaction['merchant']['allowPartialRefund'] ?? null,
                    'allowPartialCapture'   => $transaction['merchant']['allowPartialCapture'] ?? null,
                ],
                'transaction' => [
                    'merchant' => [
                        'referenceNo'   => $transaction['transaction']['merchant']['referenceNo'] ?? null,
                        'status'        => $transaction['transaction']['merchant']['status'] ?? null,
                        'customData'    => $transaction['transaction']['merchant']['customData'] ?? null,
                        'type'          => $transaction['transaction']['merchant']['type'] ?? null,
                        'operation'     => $transaction['transaction']['merchant']['operation'] ?? null,
                        'created_at'    => $transaction['transaction']['merchant']['created_at'] ?? null,
                        'message'       => $transaction['transaction']['merchant']['message'] ?? null,
                        'transactionId' => $transaction['transaction']['merchant']['transactionId'] ?? null,
                    ], 
                ],
            ];

            if (isset($transaction['refundable'])) {
                $transactions[$key]['refundable'] = $transaction['refundable'] ?? null;
            }

            if (isset($transaction['acquirer'])) {
                $transactions[$key]['acquirer'] = [
                    'id'    => $transaction['acquirer']['id'] ?? null,
                    'name'  => $transaction['acquirer']['name'] ?? null,
                    'code'  => $transaction['acquirer']['code'] ?? null,
                    'type'  => $transaction['acquirer']['type'] ?? null,
                ];
            }
        }
        
        return $transactions;
    }
}
