<h1>Olá, {{ $user->name }}, tudo bem? Espero que sim!</h1>

<h3>Obrigado pela confiança</h3>


<p>
    Faça bom proveito dos nossos produtos. Boas compras. <br>
    Seu email de cadastro é: <strong>{{ $user->email }}</strong>
</p>

Email enviado em {{ date('d-m-Y H:i:s') }}
