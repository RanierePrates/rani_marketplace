@extends('layouts.front')

@section('stylesheets')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

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
                    <div class="col-md-12 form-group">
                        <label for="">Nome no cartão</label>
                        <input type="text" class="form-control" name="card_name">
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-5 form-group">
                        <label for="">Código de Segurança</label>
                        <input type="text" class="form-control" name="card_cvv">
                    </div>

                    <div class="col-md-12 installments form-group"></div>

                </div>

                <button class="btn btn-success btn-lg processCheckout">Efetuar Pagamento</button>

            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        const sessionId = '{{ session()->get('pagseguro_session_code') }}';
        PagSeguroDirectPayment.setSessionId(sessionId);
    </script>
    <script>
        let amountTransaction = '{{ $cartItems }}';
        let cardNumber = document.querySelector('input[name=card_number]');
        let spanBrand = document.querySelector('span.brand');
        let expirationMonth = document.querySelector('input[name=card_month]');
        let expirationYear = document.querySelector('input[name=card_year]');
        let cvv = document.querySelector('input[name=card_cvv]');
        let brand = '';

        cardNumber.addEventListener('keyup', function() {

            if (cardNumber.value.length >= 6) {
                PagSeguroDirectPayment.getBrand({
                    cardBin: cardNumber.value.substr(0, 6),
                    success: function (response) {
                        let imgFlag = `<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${response.brand.name}.png">`;
                        spanBrand.innerHTML = imgFlag;

                        brand = response.brand.name;
                        getInstallments(amountTransaction);
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

        let submitButton = document.querySelector('button.processCheckout')

        submitButton.addEventListener('click', function (event) {

            event.preventDefault();

            PagSeguroDirectPayment.createCardToken({
                cardNumber: cardNumber.value,
                brand: brand,
                cvv: cvv.value,
                expirationMonth: expirationMonth.value,
                expirationYear: expirationYear.value,
                success: function (response) {
                    proccessPayment(response.card.token);
                    console.log(response)
                }
            });
        })

        function proccessPayment(token) {

            let data = {
                card_token: token,
                hash: PagSeguroDirectPayment.getSenderHash(),
                installment: document.querySelector('select.select_installments').value,
                card_name: document.querySelector('input[name=card_name]').value,
                _token: '{{ csrf_token() }}'
            }

            $.ajax({
                type: 'POST',
                url: '{{ route("checkout.proccess")}}',
                data: data,
                dataType: 'json',
                success: function (response) {
                    toastr.success(response.data.message, 'Sucesso');
                    window.location.href = '{{ route('checkout.thanks') }}?order=' + response.data.order;
                }
            });
        }

        function getInstallments(amount) {
            PagSeguroDirectPayment.getInstallments({
                amount: amount,
                brand: brand,
                maxInstallmentNoInterest: 0,
                success: function (response) {
                    let selectInstallments = drawSelectInstallments(response.installments[brand])
                    document.querySelector('div.installments').innerHTML = selectInstallments;
                },
                error: function (error) {

                },
                complete: function (response) {

                }
            });
        }

        function drawSelectInstallments(installments) {
            let select = '<label>Opções de Parcelamento:</label>';

            select += '<select class="form-control select_installments">';

            for(let l of installments) {
                select += `<option value="${l.quantity}|${l.installmentAmount}">${l.quantity}x de ${l.installmentAmount} - Total fica ${l.totalAmount}</option>`;
            }

            select += '</select>';

            return select;
        }
    </script>
@endsection
