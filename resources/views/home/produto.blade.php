@extends('layouts.layout')
@section('title', 'Carrinho')
@section('content')
    <div class="container">
        <div class="row">

            <div class="col-lg-9 mb-4">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="img-conteudo">
                                <img class="card-img-top img-responsive"src="../{{ $product->img }}"  alt="">
                            </div>
                        </div>
                        <div class=" col-md-12 col-lg-6">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <div class="pt-5">
                                    <h6>Descrição:</h6>
                                    <p class="card-text text-left">{{ $product->description }}</p>
                                </div>

                            </div>
                        </div>
                    </div>



                </div>
            </div>
            <!-- /.col-lg-9 -->

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Sumário do Pedido</h4>
                        <p class="card-text">
                            <dt>Valor:</dt>
                            <dd class="text-danger">
                                <h1>R$ {{ number_format($product->valor, 2, ',', '.') }}</h1>
                            </dd>
                        </p>
                        <div class="">
                            <form action="{{ route('shopcart.add') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input class="btn btn btn-lg btn-primary btn-block m-1" type="submit" value="Comprar">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-3 -->
        </div>
    </div>
@endsection
