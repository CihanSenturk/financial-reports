<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_login_form_displays_correctly()
    {
        $response = $this->get(route('auth.create'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_successful_login_redirects_to_dashboard()
    {
        Http::fake([
            '*/merchant/user/login' => Http::response([
                'token'  => 'test-token',
                'status' => 'APPROVED',
            ], 200),
        ]);

        $response = $this->post(route('auth.store'), [
            'email'     => 'test@example.com',
            'password'  => 'secret',
        ]);

        $response->assertRedirect(route('dashboard.index'));
        
        $this->assertEquals('test@example.com', session('email'));
        $this->assertEquals('secret', session('password'));
    }

    public function test_failed_login_redirects_back_with_errors()
    {
        Http::fake([
            '*/merchant/user/login' => Http::response([], 401),
        ]);

        $response = $this->from(route('auth.create'))->post(route('auth.store'), [
            'email' => 'invalid@example.com',
            'password' => 'wrong',
        ]);

        $response->assertRedirect(route('auth.create'));
        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_logout_clears_session_and_redirects()
    {
        session(['email' => 'test@example.com', 'password' => 'secret']);

        $response = $this->post(route('auth.logout'));

        $response->assertRedirect(route('auth.create'));
        $this->assertNull(session('email'));
        $this->assertNull(session('password'));
    }
}
