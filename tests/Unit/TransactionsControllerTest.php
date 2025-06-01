<?php

namespace Tests\Feature;

use App\DTO\TransactionResult;
use App\DTO\TransactionsResult;
use App\Http\Controllers\TransactionsController;
use App\Http\Middleware\AuthApi;
use Tests\TestCase;

class TransactionsControllerTest extends TestCase
{
    /**
     * Test that the index method returns a 200 status code.
     * It mocks the getTransactions method to return a TransactionsResult DTO.
     */
    public function test_index_displays_transactions_view()
    {
        $this->withoutMiddleware(AuthApi::class);

        $this->partialMock(TransactionsController::class, function ($mock) {
            $mock->shouldReceive('getTransactions')
                ->once()
                ->andReturn($this->sampleTransactionsResult());
        });

        $response = $this->get(route('transactions.index', [
            'from_date' => '2024-01-01',
            'to_date'   => '2024-12-31',
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('transactions.index');
        $response->assertViewHas('transactions');
    }

    /**
     * Test that the index method redirects to the transactions view with a warning
     * when no transactions are found.
     */
    public function test_show_redirects_when_transactions_not_found()
    {
        $this->withoutMiddleware(AuthApi::class);

        $this->partialMock(TransactionsController::class, function ($mock) {
            $mock->shouldReceive('getTransactions')
                ->once()
                ->andReturn(new TransactionsResult([]));
        });

        $response = $this->get(route('transactions.index'));
       
        $response->assertStatus(200);
        $response->assertViewIs('transactions.index');
        $response->assertViewHas('transactions');
        $response->assertViewHas('warning');
    }

    /**
     * Test that the show method returns a view with the transaction details.
     * It mocks the getTransaction method to return a TransactionResult DTO.
     */
    public function test_show_returns_view_with_transaction()
    {
        $this->withoutMiddleware(AuthApi::class);

        $this->partialMock(TransactionsController::class, function ($mock) {
            $mock->shouldReceive('getTransaction')
                ->with('123')
                ->once()
                ->andReturn($this->sampleTransactionResult());
        });

        $response = $this->get(route('transactions.show', ['transaction' => '123']));

        $response->assertStatus(200);
        $response->assertViewIs('partials.transactions.show');
        $response->assertViewHas('transaction');
    }

    /**
     * Test that the show method redirects to the transactions index with an error
     * message when the transaction is not found.
     */
    public function test_show_redirects_when_transaction_not_found()
    {
        $this->withoutMiddleware(AuthApi::class);

        $this->partialMock(TransactionsController::class, function ($mock) {
            $mock->shouldReceive('getTransaction')
                ->with('not-found')
                ->once()
                ->andReturn(null);
        });

        $response = $this->get(route('transactions.show', ['transaction' => 'not-found']));

        $response->assertRedirect(route('transactions.index'));
        $response->assertSessionHas('error', 'Transaction not found.');
    }

    private function sampleTransactionsResult(): TransactionsResult
    {
        return TransactionsResult::fromArray([$this->sampleTransactionsArray()]);
    }

    private function sampleTransactionResult(): TransactionResult
    {
        return TransactionResult::fromArray([$this->sampleTransactionArray()]);
    }

    private function sampleTransactionsArray(): array
    {
        return [
            'updated_at'    => '2025-01-01T00:00:00Z',
            'created_at'    => '2025-01-01T00:00:00Z',
            'customerInfo' => [
                'number'            => '1234567890',
                'email'             => 'john@doe.com',
                'billingFirstName'  => 'John',
                'billingLastName'   => 'Doe',
            ],
            'fx' => [
                'merchant' => [
                    'originalAmount'    => '100.00',
                    'originalCurrency'  => 'USD',
                    'convertedAmount'   => '85.00',
                    'convertedCurrency' => 'EUR',
                ]
            ],
            'merchant' => [
                'id'                    => 'merchant123',
                'name'                  => 'Test Merchant',
                'allowPartialRefund'    => true,
                'allowPartialCapture'   => true,
            ],
            'transaction' => [
                'merchant' => [
                    'referenceNo'   => 'ref123',
                    'status'        => 'APPROVED',
                    'customData'    => ['key' => 'value'],
                    'type'          => 'SALE',
                    'operation'     => 'PAYMENT',
                    'created_at'    => '2025-01-01T00:00:00Z',
                    'message'       => 'Transaction successful',
                    'transactionId' => 'txn123',
                ],
            ]
        ];
    }

    private function sampleTransactionArray(): array
    {
        return [
            'customerInfo' => [
                'id'                => '123',
                'created_at'        => '2025-01-01T00:00:00Z',
                'updated_at'        => '2025-01-01T00:00:00Z',
                'deleted_at'        =>  null,
                'number'            => '1234567890',
                'expiryMonth'       => '12',
                'expiryYear'        => '2025',
                'startMonth'        => '01',
                'startYear'         => '2020',
                'issueNumber'       => '001',
                'email'             => 'John@doe.com',
                'birthday'          => '1980-01-01',
                'gender'            => 'male',
                'billingTitle'      => 'Mr.', 
                'billingFirstName'  => 'John',
                'billingLastName'   => 'Doe',
                'billingCompany'    => 'Doe Enterprises',
                'billingAddress1'   => '123 Main St',
                'billingAddress2'   => 'Apt 4B',
                'billingCity'       => 'New York',
                'billingState'      => 'NY',
                'billingPostcode'   => '10001',
                'billingCountry'    => 'US',
                'billingPhone'      => '123-456-7890',
                'billingFax'        => '123-456-7891',
                'shippingTitle'     => 'Ms.',
                'shippingFirstName' => 'Jane',
                'shippingLastName'  => 'Doe',
                'shippingCompany'   => 'Doe Shipping',
                'shippingAddress1'  => '456 Elm St',
                'shippingAddress2'  => 'Suite 5A',
                'shippingCity'      => 'Los Angeles',
                'shippingState'     => 'CA',
                'shippingPostcode'  => '90001',
                'shippingCountry'   => 'US',
                'shippingPhone'     => '123-456-7892',
                'shippingFax'       => '123-456-7893',
                'token'             => 'abc123',
            ],
            'fx' => [
                'merchant' => [
                    'originalAmount'    => '100.00',
                    'originalCurrency'  => 'USD',
                ]
            ],
            'merchant' => [
                'name'                  => 'Test Merchant',
            ],
            'transaction' => [
                'merchant' => [
                    'referenceNo'               => 'ref123',
                    'merchantId'                => 'merchant123',
                    'status'                    => 'APPROVED',
                    'channel'                   => 'WEB',
                    'customData'                => 'custom data here', 
                    'type'                      => 'SALE',
                    'agentInfoId'               => 'agent123',
                    'operation'                 => 'PAYMENT',
                    'created_at'                => '2025-01-01T00:00:00Z',
                    'updated_at'                => '2025-01-01T00:00:00Z',
                    'id'                        => 'txn123',
                    'fxTransactionId'           => 'fx123',
                    'acquirerTransactionId'     => 'acq123',
                    'code'                      => '200',
                    'message'                   => 'Transaction successful',
                    'transactionId'             => '123',
                    'agent' => [
                        'id'                => 'agent123',  
                        'customerIp'        => 'test-ip',
                        'customerUserAgent' => 'test-user-agent',
                        'merchantIp'        => 'test-merchant-ip',
                        'merchantUserAgent' => 'test-merchant-user-agent',
                        'created_at'        => '2025-01-01T00:00:00Z',
                        'updated_at'        => '2025-01-01T00:00:00Z',
                        'deleted_at'        => null,
                        'index_hash'        => 'test-index-hash',
                    ]
                ],
            ]
        ];
    }
}

