<h1>Olá, {{ $order->customer_name }}!</h1>
<p>Temos ótimas notícias! Seu pedido <strong>#{{ $order->id }}</strong> foi enviado.</p>

@if($trackingCode)
    <p>O código de rastreio é: <strong>{{ $trackingCode }}</strong></p>
@endif

<p>Logo suas peças de crochê estarão com você.</p>
<p>Obrigado por comprar na Vovó Lu Crochê!</p>
