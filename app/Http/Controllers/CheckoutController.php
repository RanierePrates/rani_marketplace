<?php

namespace App\Http\Controllers;

use App\Payment\PagSeguro\CreditCard;
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
        $reference = 'XPTO';
        $cartItems = session()->get('cart');
        $user = auth()->user();

        $creditCardPayment = new CreditCard($cartItems, $user, $request->all(), $reference);
        $result = $creditCardPayment->doPayment();

        $userOrder = [
            'reference' => $reference,
            'pagseguro_code' => $result->getCode(),
            'pagseguro_status' => $result->getStatus(),
            'items' => serialize($cartItems),
            'store_id' => 42
        ];

        $user->orders()->create($userOrder);

        return response()->json([
            'data' => [
                'status' => true,
                'message' => 'Pedido criado com sucesso!'
            ]
        ]);

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
