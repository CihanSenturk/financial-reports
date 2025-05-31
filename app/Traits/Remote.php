<?php

namespace App\Traits;

use Exception;
use App\DTO\AuthResult;
use App\DTO\MerchantResult;
use App\DTO\TransactionResult;
use App\DTO\TransactionsResult;
use App\DTO\TransactionReportResult;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

trait Remote
{
    public $result = []; 

    public $base_url = 'https://sandbox-reporting.rpdpymnt.com/api/v3';

    public $sandbox_base_url = 'https://sandbox-reporting.rpdpymnt.com/api/v3';

    /**
     * Get the base URL based on the environment.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return env('financial_house.environment') === 'sandbox' ? $this->sandbox_base_url : $this->base_url;
    }

    /**
     * Get the authentication token using the provided credentials.
     *
     * @param array $credentials
     * @return AuthResult
     */
    public function getAuthToken(array $credentials): AuthResult
    {
        $cache_key = 'auth_token_' . $credentials['email'];

        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        }

        $response = Http::post($this->getBaseUrl() . '/merchant/user/login', $credentials);

        if ($response->failed() || empty($response->json())) {
            return new AuthResult('', 'FAILED');
        }

        $result = AuthResult::fromArray($response->json());

        Cache::put($cache_key, $result, Date::now()->addMinutes(10));
        
        return $result;
    }

    /**
     * Get the authentication token from the session or cache.
     *
     * @return AuthResult
     * @throws Exception
     */
    public function getToken()
    {
        if (! session()->has('email') || ! session()->has('password')) {
            return new AuthResult('', 'FAILED');
        }

        $cache_key = 'auth_token_' . session('email');

        if (Cache::has($cache_key)) {
            $auth_result = Cache::get($cache_key);

            if ($auth_result->status == 'APPROVED') {
                return $auth_result->token;
            }
        }

        $credentials = [
            'email'     => session('email'),
            'password'  => session('password'),
        ];

        $auth_result = $this->getAuthToken($credentials);

        if ($auth_result->status == 'APPROVED') {
            return $auth_result->token;
        }

        throw new Exception('Authentication failed. Please check your credentials.');
    }

    /**
     * Get the result from the API endpoint.
     *
     * @param string $path
     * @param array $query
     * @param bool $with_header
     * @param bool $pagination
     * @param int $page
     * @return array
     * @throws Exception
     */
    public function getResult($path, $query = [], $with_header = true, $pagination = false, $page = 1)
    {
        try {
            $headers = [];

            if ($with_header) {
                $headers = [
                    'Authorization' => $this->getToken(),
                ];
            }

            $url = $this->getBaseUrl() . $path;
            
            if (! empty($query)) {
                $url .= '?' . http_build_query($query);
            }

            $response = Http::withHeaders($headers)->post($url);

            if ($response->successful()) {
                $result = $response->json();

                if (! $pagination) {
                    return $result;
                }

                if (isset($result['next_page_url']) && ! empty($result['next_page_url'])) {
                    $this->result = array_merge($this->result, $result['data'] ?? null);

                    $query['page'] = $result['current_page'] + 1;

                    $this->getResult($path, $query, $with_header, $pagination, $page + 1);
                } else if ($page == 1)  {
                    return $result['data'] ?? [];
                }
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        $last_result = $this->result;

        if ($page == 1) {
            $this->result = [];
        }

        return $last_result;
    }

    /**
     * Get transaction reports for the specified date range.
     *
     * @param string|null $from_date
     * @param string|null $to_date
     * @param int $page
     * @return TransactionReportResult
     */
    public function getTransactionReports($from_date = null, $to_date = null, $page = 1)
    {
        if (! $from_date || ! Date::parse($from_date)->isValid()) {
            $from_date = Date::now()->startOfYear()->format('Y-m-d');
        }

        if (! $to_date || ! Date::parse($to_date)->isValid()) {
            $to_date = Date::now()->endOfYear()->format('Y-m-d');
        }
        
        $result = $this->getResult(
            '/transactions/report', 
            [
                'fromDate' => $from_date,
                'toDate'   => $to_date,
            ],
        );

        return TransactionReportResult::fromArray($result);
    }

    /**
     * Get transactions for the specified date range.
     *
     * @param string|null $from_date
     * @param string|null $to_date
     * @return TransactionsResult
     */
    public function getTransactions($from_date = null, $to_date = null)
    {
        $this->result = [];

        if (! $from_date || ! Date::parse($from_date)->isValid()) {
            $from_date = Date::now()->startOfYear()->format('Y-m-d');
        }

        if (! $to_date || ! Date::parse($to_date)->isValid()) {
            $to_date = Date::now()->endOfYear()->format('Y-m-d');
        }

        $result = $this->getResult(
            '/transaction/list', 
            [
                'fromDate' => $from_date,
                'toDate'   => $to_date,
            ],
            true,
            true
        );

        return TransactionsResult::fromArray($result);
    }

    /**
     * Get a specific transaction by its ID.
     *
     * @param string $transaction_id
     * @return TransactionResult|null
     */
    public function getTransaction($transaction_id)
    {
        if (empty($transaction_id)) {
            return null;
        }

        $result = $this->getResult(
            '/transaction', 
            ['transactionId' => $transaction_id], 
        );
        
        return TransactionResult::fromArray([$result]);
    }

    /**
     * Get merchant details for a specific transaction.
     *
     * @param string $transaction_id
     * @return MerchantResult|null
     */
    public function getMerchant($transaction_id)
    {
        if (empty($transaction_id)) {
            return null;
        }

        $result = $this->getResult(
            '/client', 
            ['transactionId' => $transaction_id], 
        );
        
        return MerchantResult::fromArray([$result]);
    }
}
