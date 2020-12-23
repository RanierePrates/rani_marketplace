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

        $cartItems = array_map(function ($item) {
            return $item['amount'] * $item['price'];
        }, session()->get('cart'));

        $cartItems = array_sum($cartItems);

        return view('checkout', compact(['cartItems']));
    }

    public function proccess(Request $request)
    {
        $dataPost = $request->all();
        $reference = 'XPTO';
        //Instantiate a new direct payment request, using Credit Card
        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();

        $creditCard->setReceiverEmail(env('PAGSEGURO_EMAIL'));
        $creditCard->setReference($reference);
        $creditCard->setCurrency("BRL");
        $cartItems = session()->get('cart');

        foreach ($cartItems as $item) {
            $creditCard->addItems()->withParameters(
                $reference,
                $item['name'],
                $item['amount'],
                $item['price']
            );
        }

        $user = auth()->user();
        $email = env('PAGSEGURO_ENV') == 'sandbox' ? 'teste@sandbox.pagseguro.com.br' : $user->email;

        $creditCard->setSender()->setName($user->name);
        $creditCard->setSender()->setEmail($email);
        $creditCard->setSender()->setPhone()->withParameters(
            11,
            56273440
        );

        $creditCard->setSender()->setDocument()->withParameters(
            'CPF',
            '12765384568'
        );

        $creditCard->setSender()->setHash($dataPost['hash']);
        $creditCard->setSender()->setIp('127.0.0.0');
        $creditCard->setShipping()->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );

        $creditCard->setBilling()->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );

        // Set credit card token
        $creditCard->setToken($dataPost['card_token']);

        list($quantity, $installmentAmount) = explode('|', $dataPost['installment']);

        $installmentAmount = number_format($installmentAmount, 2, '.', '');


        $creditCard->setInstallment()->withParameters($quantity, $installmentAmount);
        $creditCard->setHolder()->setBirthdate('01/10/1979');
        $creditCard->setHolder()->setName($dataPost['card_name']);
        $creditCard->setHolder()->setPhone()->withParameters(
            11,
            56273440
        );
        $creditCard->setHolder()->setDocument()->withParameters(
            'CPF',
            '12765384568'
        );
        $creditCard->setMode('DEFAULT');
        $result = $creditCard->register(
            \PagSeguro\Configuration\Configure::getAccountCredentials()
        );

        dd($result);

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
