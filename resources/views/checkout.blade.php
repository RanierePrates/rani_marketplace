@extends('layouts.front')

@section('content')
    <div class="container">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <h2>Dados para o Pagamento</h2>
                    <hr>
                </div>
            </div>
            <form action="" method="post">

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="">Numero do cartão <span class="brand"></span></label>
                        <input type="text" class="form-control" name="card_number">
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-4 form-group">
                        <label for="">Mês vencimento</label>
                        <input type="text" class="form-control" name="card_month">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="">Ano vencimento</label>
                        <input type="text" class="form-control" name="card_year">
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-5 form-group">
                        <label for="">Código de Segurança</label>
                        <input type="text" class="form-control" name="card_cvv">
                    </div>

                </div>

                <button class="btn btn-success btn-lg">Efetuar Pagamento</button>

            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script>
        const sessionId = '{{ session()->get('pagseguro_session_code') }}';
        PagSeguroDirectPayment.setSessionId(sessionId);
    </script>
    <script>
        let cardNumber = document.querySelector('input[name=card_number]');
        let spanBrand = document.querySelector('span.brand');

        cardNumber.addEventListener('keyup', function() {

            if (cardNumber.value.length >= 6) {
                PagSeguroDirectPayment.getBrand({
                    cardBin: cardNumber.value.substr(0, 6),
                    success: function (response) {
                        let imgFlag = `<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${response.brand.name}.png">`
                        spanBrand.innerHTML = imgFlag;
                    },
                    error: function (error) {
                        console.log('error', error);
                    },
                    complete: function (response) {
                        //console.log('complete', response);
                    }
                });
            }

        });
    </script>
@endsection
