@extends('layouts.layout')
@section('title', 'Compras')

@section('content')
    @php
        function text_limiter_caracter($str, $limit, $suffix = '...'){
        if (strlen($str) <= $limit) return $str; $limit=strpos($str, ' ' , $limit);
        return substr($str, 0, $limit + 1) . $suffix;}
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Minhas compras</h2>
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

            </div>
                <div class="col-12">
                    <h3 class=" p-2">Compras concluídas</h3>
                    <hr>
                    @forelse ($compras as $order)
                    <div class="row">
                        <div class="col-6">
                            <h5 class="text-success"> Pedido: {{ $order->id }} </h5>
                        </div>
                        <div class="col-6">
                            <h5 class="text-success"> Criado em: {{ $order->created_at->format('d/m/Y H:i') }} </h5>
                        </div>
                    </div>


                        <form method="POST" action="{{ route('shopcart.cancelar') }}">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th>Produto</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $total_order = 0;
                                    @endphp
                                    @foreach ($order->orderItem as $orderItem)
                                        @php
                                        $total_product = $orderItem->valor;
                                        $total_order += $total_product;
                                        @endphp
                                        <tr>
                                            <td class="center">
                                                @if ($orderItem->status == 'PA')
                                                    <p class="center">
                                                        <input type="checkbox" id="item-{{ $orderItem->id }}" name="id[]"
                                                            value="{{ $orderItem->id }}" class="form-check-input"/>
                                                        <label for="item-{{ $orderItem->id }} " class="form-check-label">Selecionar</label>
                                                    </p>
                                                @else
                                                    <strong class="red-text">CANCELADO</strong>
                                                @endif
                                            </td>
                                            <td>
                                                <img width="100" height="100" src="../{{ $orderItem->product->img }}">
                                            </td>
                                            <td>{{ text_limiter_caracter($orderItem->product->name,60) }}</td>
                                            <td>R$ {{ number_format($orderItem->valor, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" class="btn btn-lg btn-danger">
                                            Cancelar
                                        </button></td>
                                        <td class="text-right"><strong>Total do pedido:</strong></td>
                                        <td class="text-danger">R$ {{ number_format($total_order, 2, ',', '.') }}</td>
                                    </tr>
                                    <td colspan="4"></td>
                                </tfoot>
                            </table>
                        </form>
                    @empty
                        <h5 class="center">
                            @if ($cancelados->count() > 0)
                            <div class="alert alert-warning text-center p-3">
                                Neste momento não há nenhuma compra valida.
                            </div>
                            @else
                            <div class="alert alert-warning text-center p-3">
                                Você ainda não fez nenhuma compra.
                            </div>
                            @endif
                        </h5>
                    @endforelse
                </div>
            </div>
            <h3 class="my-5">Compras canceladas</h3>
            <hr>
            <div class=row>


                @forelse ($cancelados as $order)
                    <h5 class="col-4 text-success"> Pedido: {{ $order->id }} </h5>
                    <h5 class="col-4 text-success"> Criado em: {{ $order->created_at->format('d/m/Y H:i') }} </h5>
                    <h5 class="col-4 text-success"> Cancelado em: {{ $order->updated_at->format('d/m/Y H:i') }} </h5>


                    <table class="table ">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Produto</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total_order = 0;
                            @endphp
                            @foreach ($order->orderItem as $orderItem)
                                @php
                                $total_product = $orderItem->valor;
                                $total_order += $total_product;
                                @endphp
                                <tr>
                                    <td>
                                        <img width="100" height="100" src="../{{ $orderItem->product->img }}">
                                    </td>
                                    <td>{{text_limiter_caracter($orderItem->product->name, 60)}}</td>
                                    <td>R$ {{ number_format($orderItem->valor, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="1"></td>
                                <td class="text-right"><strong>Total do pedido:</strong></td>
                                <td class="text-danger">R$ {{ number_format($total_order, 2, ',', '.') }}</td>
                            </tr>
                                <td colspan="4" ></td>

                        </tfoot>
                    </table>
                @empty
                    <h5 class="center">Nenhuma compra ainda foi cancelada.</h5>
                @endforelse
            </div>
        </div>

    </div>

@endsection
