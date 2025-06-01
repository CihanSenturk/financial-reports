<?php

namespace Tests\Unit\Http\Controllers;

use App\DTO\TransactionReportResult;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\AuthApi;
use Mockery;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    public function test_index_returns_view_with_transaction_reports()
    {
        // Disable the AuthApi middleware for this test
        // This ensures authentication checks don't interfere with the test
        $this->withoutMiddleware(AuthApi::class);
    
        // Create a partial mock of the DashboardController
        // This allows mocking specific methods while keeping others real
        $controllerMock = \Mockery::mock(DashboardController::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods(); // Allows mocking protected methods
    
        // Expect the getTransactionReports method to be called once
        // with specific parameters, and return a fixed result
        $controllerMock->shouldReceive('getTransactionReports')
            ->once()
            ->with('2024-01-01', '2024-12-31')
            ->andReturn($this->sampleTransactionReportResult());
    
        // Register the mock controller in the Laravel service container
        // This ensures the mock is used during the request instead of the real controller
        $this->app->instance(DashboardController::class, $controllerMock);
    
        // Send a GET request to the /dashboard route with query parameters
        $response = $this->get(route('dashboard.index', ['from_date' => '2024-01-01', 'to_date' => '2024-12-31']));
    
        // Assert the response status is 200 OK
        $response->assertStatus(200);

        // Assert the view returned is named "dashboard"
        $response->assertViewIs('dashboard');

        // Assert the view has a variable named "transaction_reports"
        $response->assertViewHas('transaction_reports');
    
        // Retrieve the transaction_reports variable from the view
        $transactionReports = $response->viewData('transaction_reports');
    
        // Assert the status is "APPROVED"
        $this->assertEquals('APPROVED', $transactionReports->status);

        // Assert the data is an array
        $this->assertIsArray($transactionReports->data);

        $this->assertTrue($transactionReports->data[0]['currency'] === 'USD');
        $this->assertTrue($transactionReports->data[0]['count'] === 100);
        $this->assertTrue($transactionReports->data[0]['total'] === 2031);
        $this->assertTrue($transactionReports->data[1]['currency'] === 'EUR');
        $this->assertTrue($transactionReports->data[1]['count'] === 50);
        $this->assertTrue($transactionReports->data[1]['total'] === 1500);
    }
    
    private function sampleTransactionReportResult(): TransactionReportResult
    {
        return TransactionReportResult::fromArray($this->sampleTransactionReportArray());
    }

    private function sampleTransactionReportArray(): array
    {
        return [ 
            'status'    => 'APPROVED',
            'response'  => [
                [
                    'currency' => 'USD', 'count' => 100, 'total' => 2031
                ],
                [
                    'currency' => 'EUR', 'count' => 50, 'total' => 1500
                ]
            ]
        ];
    }
}
