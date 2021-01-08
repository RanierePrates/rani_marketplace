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

submitButton.addEventListener('click', function (event) {

    event.preventDefault();
    document.querySelector('div.msg').innerHTML = '';

    let buttonTarget = event.target;
    buttonTarget.disabled = true;
    buttonTarget.innerHTML = 'Carregando...';

    PagSeguroDirectPayment.createCardToken({
        cardNumber: cardNumber.value,
        brand: brand,
        cvv: cvv.value,
        expirationMonth: expirationMonth.value,
        expirationYear: expirationYear.value,
        success: function (response) {
            proccessPayment(response.card.token, buttonTarget);
        },
        error: function (error) {
            buttonTarget.disabled = false;
            buttonTarget.innerHTML = 'Efetuar Pagamento';
            for (let index in error.errors) {
                let message = showErrorMessages(errorsMapPagseguroJS(index));
                document.querySelector('div.msg').innerHTML = message;

            }

        },
        complete: function (response) {

        }
    });
})
