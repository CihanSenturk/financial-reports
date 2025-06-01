<?php

namespace Tests\Feature;

use App\DTO\MerchantResult;
use App\Http\Controllers\MerchantsController;
use App\Http\Middleware\AuthApi;
use Tests\TestCase;

class MerchantsControllerTest extends TestCase
{
    /**
     * Test that the show method returns a view with the merchant details.
     * It mocks the getMerchant method to return a MerchantResult DTO.
     */
    public function test_show_returns_view_with_transaction()
    {
        $this->withoutMiddleware(AuthApi::class);

        $this->partialMock(MerchantsController::class, function ($mock) {
            $mock->shouldReceive('getMerchant')
                ->with('123')
                ->once()
                ->andReturn($this->sampleMerchantResult());
        });

        $response = $this->get(route('merchants.show', ['merchant' => '123']));

        $response->assertStatus(200);
        $response->assertViewIs('partials.merchants.show');
        $response->assertViewHas('merchant');
    }

    /**
     * Test that the show method redirects to the transactions index with an error
     * message when the transaction is not found.
     */
    public function test_show_redirects_when_transaction_not_found()
    {
        $this->withoutMiddleware(AuthApi::class);

        $this->partialMock(MerchantsController::class, function ($mock) {
            $mock->shouldReceive('getMerchant')
                ->with('not-found')
                ->once()
                ->andReturn(null);
        });

        $response = $this->get(route('merchants.show', ['merchant' => 'not-found']));

        $response->assertRedirect(route('transactions.index'));
        $response->assertSessionHas('error', 'Merchant not found.');
    }

    private function sampleMerchantResult(): MerchantResult
    {
        return MerchantResult::fromArray([$this->sampleMerchantArray()]);
    }

    private function sampleMerchantArray(): array
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
        ];
    }
}

