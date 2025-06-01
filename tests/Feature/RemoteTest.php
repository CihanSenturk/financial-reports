<?php

namespace Tests\Unit;


use App\DTO\AuthResult;
use App\DTO\MerchantResult;
use App\DTO\TransactionResult;
use App\DTO\TransactionsResult;
use App\DTO\TransactionReportResult;
use App\Traits\Remote;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class RemoteTest extends TestCase
{
    use Remote;

    protected function setUp(): void
    {
        parent::setUp();

        Session::put('email', 'test@example.com');
        Session::put('password', 'test123');

        Cache::flush(); // her test öncesi token cache'ini sıfırla
    }

    public function test_get_auth_token_successful()
    {
        Http::fake([
            '*/merchant/user/login' => Http::response([
                'token' => 'test-token',
                'status' => 'APPROVED'
            ], 200),
        ]);

        $credentials = ['email' => 'test@example.com', 'password' => 'secret'];
        $authResult = $this->getAuthToken($credentials);

        $this->assertInstanceOf(AuthResult::class, $authResult);
        $this->assertEquals('APPROVED', $authResult->status);
        $this->assertEquals('test-token', $authResult->token);
    }

    public function test_get_auth_token_failed()
    {
        Http::fake([
            '*/merchant/user/login' => Http::response([], 401),
        ]);

        $credentials = ['email' => 'wrong@example.com', 'password' => 'wrong'];
        $authResult = $this->getAuthToken($credentials);

        $this->assertInstanceOf(AuthResult::class, $authResult);
        $this->assertEquals('FAILED', $authResult->status);
        $this->assertEquals('', $authResult->token);
    }

    public function test_get_transaction_reports_returns_dto()
    {
        $mockLoginResponse = [
            'status' => 'APPROVED',
            'token' => 'fake-token',
        ];
    
        $mockReportResponse = [
            'status' => 'APPROVED',
            'response' => [
                ['some_report_data' => true],
            ],
        ];
    
        Http::fake([
            '*/merchant/user/login' => Http::response($mockLoginResponse, 200),
            '*' => Http::response($mockReportResponse, 200),
        ]);
    
        Cache::shouldReceive('has')->andReturn(false);
        Cache::shouldReceive('put')->andReturn(true);
    
        $result = $this->getTransactionReports('2024-01-01', '2024-12-31');
    
        $this->assertInstanceOf(TransactionReportResult::class, $result);
        $this->assertEquals('APPROVED', $result->status);
        $this->assertIsArray($result->data);
    }

    public function test_get_transactions_returns_dto()
    {
        $mockLoginResponse = [
            'status' => 'APPROVED',
            'token' => 'fake-token',
        ];

        $mockTransactionsResponse = [
            'data' => [
                [
                    'customerInfo' => [],
                    'fx' => ['merchant' => []],
                    'transaction' => ['merchant' => []],
                    'merchant' => ['name' => 'Test Merchant'],
                    'refundable' => true,
                    'acquirer' => [],
                ]
            ],
            'next_page_url' => null,
            'current_page' => 1,
        ];

        Http::fake([
            '*/merchant/user/login' => Http::response($mockLoginResponse, 200),
            '*' => Http::response($mockTransactionsResponse, 200),
        ]);

        Cache::shouldReceive('has')->andReturn(false);
        Cache::shouldReceive('put')->andReturn(true);

        $result = $this->getTransactions('2024-01-01', '2024-12-31');

        $this->assertInstanceOf(TransactionsResult::class, $result);
        $this->assertIsArray($result->data);
    }

    public function test_get_transaction_returns_dto()
    {
        $mockLoginResponse = [
            'status' => 'APPROVED',
            'token' => 'fake-token',
        ];

        $mockTransactionResponse = [
            'customerInfo' => [],
            'fx' => ['merchant' => []],
            'transaction' => ['merchant' => []],
            'merchant' => ['name' => 'Test Merchant'],
            'refundable' => true,
            'acquirer' => [],
        ];

        Http::fake([
            '*/merchant/user/login' => Http::response($mockLoginResponse, 200),
            '*' => Http::response($mockTransactionResponse, 200),
        ]);

        Cache::shouldReceive('has')->andReturn(false);
        Cache::shouldReceive('put')->andReturn(true);

        $transactionId = Str::uuid()->toString();

        $result = $this->getTransaction($transactionId);

        $this->assertInstanceOf(TransactionResult::class, $result);
        $this->assertIsArray($result->customerInfo);
    }

    public function test_get_merchant_returns_dto()
    {
        $mockLoginResponse = [
            'status' => 'APPROVED',
            'token' => 'fake-token',
        ];

        $mockMerchantResponse = [
            'id' => 1,
            'customerInfo' => [
                'name' => 'Test Merchant',
                'email' => 'test@gmail.com',
            ],
        ];

        Http::fake([
            '*/merchant/user/login' => Http::response($mockLoginResponse, 200),
            '*' => Http::response($mockMerchantResponse, 200),
        ]);

        Cache::shouldReceive('has')->andReturn(false);
        Cache::shouldReceive('put')->andReturn(true);

        $transactionId = Str::uuid()->toString();

        $result = $this->getMerchant($transactionId);

        $this->assertInstanceOf(MerchantResult::class, $result);
        $this->assertEquals('test@gmail.com', $result->customerInfo['email']);
    }
}
