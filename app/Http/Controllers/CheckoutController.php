<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PagSeguro\Configuration\Configure;
use PagSeguro\Services\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->makePagSeguroSession();

        return view('checkout');
    }

    private function makePagSeguroSession()
    {
        if (session()->has('pagseguro_session_code')) {
            return session()->get('pagseguro_session_code');
        }

        $sessionCode = Session::create(
            Configure::getAccountCredentials()
        );

        session()->put('pagseguro_session_code', $sessionCode->getResult());

        return session()->get('pagseguro_session_code');
    }
}
