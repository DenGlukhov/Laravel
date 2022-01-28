@extends('layouts.app')

@section('content')

@section('styles')
<style>
    .product-price {
        font-size: 23px;
        text-align: center;
        margin-bottom: 10px;
    }
    .card-text {
        height: 46px;
    }
    .card-title {
        height: 22px;
    }
    .clip {
        overflow: hidden; /* Обрезаем все, что не помещается в область */
        text-overflow: ellipsis; /* Добавляем многоточие */
        white-space: nowrap; /* Запрещаем перенос строк */
        padding: 3px; /* Поля вокруг текста */
    }
    .product-buttons {
        display: flex;
        justify-content: space-between;
        line-height: 37px;
    }
</style>
@endsection

    <div class="container">
        <div class="row">
            @foreach ($products as $product)
            <div class="col-3">
                <div class="card mb-4" style="width: 18rem;">
                    <img src="{{ asset('storage')}}/{{$product->picture }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title clip" title="{{ $product->name }}">
                            {{ $product->name }}
                        </h5>
                        <p class="card-text clip" title="{{ $product->description }}">
                            {{ $product->description }}
                        </p>
                            <div class="product-price">
                                {{ $product->price }} руб.
                            </div>
                                <div class="product-buttons">
                                    <button class="btn btn-success">+</button>
                                    0
                                    <button class="btn btn-danger">-</button>
                                </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection