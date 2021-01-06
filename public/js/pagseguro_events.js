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
