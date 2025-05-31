<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\Login as Request;
use App\Traits\Remote;

class AuthController extends Controller
{
    use Remote;

    /**
     * Display the login form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle the login request.
     *
     * @param \App\Http\Requests\Auth\Login $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $authenticate = $this->getAuthToken($request->only('email', 'password'));
    
        if (is_null($authenticate) || $authenticate->status == 'FAILED') {
            return redirect()->back()->withErrors([
                'email'     => trans('auth.failed'),
                'password'  => trans('auth.failed'),
            ]);
        }

        session()->put($request->only('email', 'password'));

        return redirect()->route('dashboard.index');
    }

    /**
     * Handle the logout request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        session()->flush();

        return redirect()->route('auth.create');
    }
}
