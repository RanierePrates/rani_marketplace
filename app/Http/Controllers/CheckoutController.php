<?php

namespace App\Http\Controllers;

use App\Payment\PagSeguro\CreditCard;
use App\Store;
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

        if (!session()->has('cart')) {
            return redirect()->route('home');
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
        try {
            $reference = 'XPTO';
            $cartItems = session()->get('cart');
            $stores = array_unique(array_column($cartItems, 'store_id'));
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

            $userOrder = $user->orders()->create($userOrder);
            $userOrder->stores()->sync($stores);

            app(Store::class)->notifyStoreOwners($stores);

            session()->forget(['cart', 'pagseguro_session_code']);

            return response()->json([
                'data' => [
                    'status'    => true,
                    'message'   => 'Pedido criado com sucesso!',
                    'order'     => $reference
                ]
            ]);
        } catch (\Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar pedido!';

            return response()->json([
                'data' => [
                    'status'    => false,
                    'message'   => $message
                ]
                ], 401);
        }

    }

    public function thanks()
    {
        return view('thanks');
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
