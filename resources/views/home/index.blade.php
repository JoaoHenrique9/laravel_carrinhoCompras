@extends('layouts.layout')
@section('title', 'Home')
@section('content')
    @php
        function text_limiter_caracter($str, $limit, $suffix = '...'){
            if (strlen($str) <= $limit) return $str; $limit=strpos($str, ' ' , $limit);
            return substr($str, 0, $limit + 1) . $suffix;}
    @endphp
    <div class="container">
        <div class="row ">
            @foreach ($produtos as $produto)
                <div class="col-lg-4 col-md-6 mb-4 p-10 ">
                    <div class="conteudo">
                        <div class="card">
                            <div class="img-conteudo">
                                <a href="{{ route('product.show', ['product' => $produto->id]) }}" class=""><img
                                    class="card-img-top" height="150" width="100" src="{{ $produto->img }}" alt=""></a>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">
                                    <a href="{{ route('product.show', ['product' => $produto->id]) }}">
                                        <span class="">{{ text_limiter_caracter($produto->name, 60) }}</span></a>
                                </h6>
                                <h5 class="text-danger">R$ {{ number_format($produto->valor, 2, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endsection
