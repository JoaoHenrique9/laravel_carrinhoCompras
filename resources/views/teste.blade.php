@extends('layouts.layout')
@section('pagina_titulo', 'Compras')

@section('content')

    <div class="container">
        <div class="row">
            <h3>Minhas compras</h3>
            @if (Session::has('mensagem-sucesso'))
                <div class="card-panel green">{{ Session::get('mensagem-sucesso') }}</div>
            @endif
            @if (Session::has('mensagem-falha'))
                <div class="card-panel red">{{ Session::get('mensagem-falha') }}</div>
            @endif
            <div class="divider"></div>
            <div class="row col s12 m12 l12">
                <h4>Compras concluídas</h4>
                @forelse ($compras as $order)
                    <h5 class="col l6 s12 m6"> Pedido: {{ $order->id }} </h5>
                    <h5 class="col l6 s12 m6"> Criado em: {{ $order->created_at->format('d/m/Y H:i') }} </h5>
                    <form method="POST" action="{{ route('shopcart.cancelar') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="2"></th>
                                    <th>Produto</th>
                                    <th>Valor</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $total_order = 0;
                                @endphp
                                @foreach ($order->OrderItens as $orderItem)
                                    @php
                                    $total_product = $orderItem->valores;
                                    $total_order += $total_product;
                                    @endphp
                                    <tr>
                                        <td class="center">
                                            @if ($orderItem->status == 'PA')
                                                <p class="center">
                                                    <input type="checkbox" id="item-{{ $orderItem->id }}" name="id[]"
                                                        value="{{ $orderItem->id }}" />
                                                    <label for="item-{{ $orderItem->id }}">Selecionar</label>
                                                </p>
                                            @else
                                                <strong class="red-text">CANCELADO</strong>
                                            @endif
                                        </td>
                                        <td>
                                            <img width="100" height="100" src="{{ $orderItem->product->img }}">
                                        </td>
                                        <td>{{ $orderItem->product->name }}</td>
                                        <td>R$ {{ number_format($orderItem->valor, 2, ',', '.') }}</td>
                                        <td>R$ {{ number_format($total_product, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td><strong>Total do pedido</strong></td>
                                    <td>R$ {{ number_format($total_order, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <button type="submit" class="btn-large red col l12 s12 m12 tooltipped"
                                            data-position="bottom" data-delay="50" data-tooltip="Cancelar itens selecionados">
                                            Cancelar
                                        </button>
                                    </td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                @empty
                    <h5 class="center">
                        @if ($cancelados->count() > 0)
                            Neste momento não há nenhuma compra valida.
                        @else
                            Você ainda não fez nenhuma compra.
                        @endif
                    </h5>
                @endforelse
            </div>
            <div class="row col s12 m12 l12">
                <div class="divider"></div>
                <h4>Compras canceladas</h4>
                @forelse ($cancelados as $order)
                    <h5 class="col l2 s12 m2"> Pedido: {{ $order->id }} </h5>
                    <h5 class="col l5 s12 m5"> Criado em: {{ $order->created_at->format('d/m/Y H:i') }} </h5>
                    <h5 class="col l5 s12 m5"> Cancelado em: {{ $order->updated_at->format('d/m/Y H:i') }} </h5>
                    <table>
                        <thead>
                            <tr>
                                <th></th>
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
                                @php
                                $total_product = $orderItem->valores;
                                $total_order += $total_product;
                                @endphp
                                <tr>
                                    <td>
                                        <img width="100" height="100" src="{{ $orderItem->product->img }}">
                                    </td>
                                    <td>{{ $orderItem->product->name }}</td>
                                    <td>R$ {{ number_format($orderItem->valor, 2, ',', '.') }}</td>

                                    <td>R$ {{ number_format($total_product, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Total do pedido</strong></td>
                                <td>R$ {{ number_format($total_order, 2, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                @empty
                    <h5 class="center">Nenhuma compra ainda foi cancelada.</h5>
                @endforelse
            </div>
        </div>

    </div>

@endsection
