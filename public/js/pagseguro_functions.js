function proccessPayment(token) {

    let data = {
        card_token: token,
        hash: PagSeguroDirectPayment.getSenderHash(),
        installment: document.querySelector('select.select_installments').value,
        card_name: document.querySelector('input[name=card_name]').value,
        _token: csrf
    }

    $.ajax({
        type: 'POST',
        url: urlProcess,
        data: data,
        dataType: 'json',
        success: function (response) {
            toastr.success(response.data.message, 'Sucesso');
            window.location.href = `${urlThanks}?order=${response.data.order}`;
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
