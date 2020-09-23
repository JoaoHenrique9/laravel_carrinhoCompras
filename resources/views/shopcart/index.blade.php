@extends('layouts.layout')
@section('title', 'Carrinho')

@section('content')
 @php
        function text_limiter_caracter($str, $limit, $suffix = '...'){
            if (strlen($str) <= $limit) return $str; $limit=strpos($str, ' ' , $limit);
            return substr($str, 0, $limit + 1) . $suffix;}
    @endphp
    <div class="container">
        <div class="row">

            <div class="col-sm-12 col-lg-9">

                <h2 class="text-center">Produtos no Carrinho</h2>

                @if (Session::has('mensagem-sucesso'))
                    <div class="alert alert-success text-center p-3">
                        <strong>{{ Session::get('mensagem-sucesso') }}</strong>
                    </div>
                @endif
                @if (Session::has('mensagem-falha'))
                    <div class="alert alert-danger text-center p-3">
                        <strong>{{ Session::get('mensagem-falha') }}</strong>
                    </div>
                @endif
                @forelse ($orders as $order)
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Qtd</th>
                                <th>Produto</th>
                                <th>Valor</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $total_order = 0;
                            @endphp
                            @foreach ($order->orderItens as $orderItem)
                                <tr>
                                    <td><a href="{{route('product.show',['product' => $orderItem->product->id])}} ">
                                            <img height="100" width="100" class="img-fluid d-md-block"
                                                src="{{ $orderItem->product->img }}" alt="">
                                        </a>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <a class="" href="#"
                                                onclick="carrinhoRemoverProduto({{ $order->id }}, {{ $orderItem->product_id }}, 1 )"><i
                                                    class="fas fa-angle-left"></i></a>
                                            <span class="px-2">{{ $orderItem->qtd }} </span>
                                            <a class="" href=""
                                                onclick="carrinhoAdicionarProduto({{ $orderItem->product_id }})"><i
                                                    class="fas fa-angle-right"></i></a>
                                        </div>
                                    </td>
                                    <td>{{ text_limiter_caracter($orderItem->product->name, 40) }}</td>
                                    <td>R$ {{ number_format($orderItem->product->valor, 2, ',', '.') }}</td>
                                    @php
                                    $total_product = $orderItem->valores;
                                    $total_order += $total_product;
                                    @endphp
                                    <td>R$ {{ number_format($total_product, 2, ',', '.') }}</td>

                                </tr>

                        </tbody>
                        @endforeach
                    </table>

                </div>

                <div class="col-lg-3 ">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Sumário do Pedidos</h4>
                            <p class="card-text">
                                <dt>Total</dt>
                                <dd class="text-danger">
                                    <h2>R$ {{ number_format($total_order, 2, ',', '.') }}</h2>
                                </dd>
                            </p>
                            <form method="POST" action="{{ route('shopcart.concluir') }}">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="submit" class="btn btn-success btn-block" value="Concluir Compra">
                            </form>
                            <a href="{{ route('home') }}" class="btn btn-danger btn-block mt-2">Continuar Comprando</a>
                        </div>
                    </div>
                </div>
            @empty
                <h2 class="alert alert-success text-center">Não há nenhum pedido no carrinho</h2>
            @endforelse
        </div>
    </div>
<form id="form-remover-product" method="POST" action="{{ route('shopcart.remover') }}">
    @csrf
    @method('DELETE')
    <input type="hidden" name="order_id">
    <input type="hidden" name="product_id">
    <input type="hidden" name="item">
</form>
<form id="form-adicionar-product" method="POST" action="{{ route('shopcart.add') }}">
    @csrf
    <input type="hidden" name="id">
</form>

    <script type="text/javascript" src="{{url(mix('js/carrinho.js'))}} "></script>
@endsection
