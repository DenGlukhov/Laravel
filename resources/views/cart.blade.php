@extends('layouts.app')

@section('styles')
<style>
    .product-buttons {
        display: flex;
        justify-content: space-evenly;
        line-height: 37px;
    }
</style>
@endsection

@section('content')
    <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th>#</th>
                <th>Наименование</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
            </tr>
        </thead>
        <tbody>
            @php
                $summ = 0;
            @endphp
            @forelse ($products as $idx => $product)
                @php 
                    $productSumm = $product->price * $product->quantity;
                    $summ += $productSumm;
                @endphp
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td class="text-center">{{ $product->name }}</td>
                        <td class="text-center">{{ $product->price }} руб.</td>
                        <td class="product-buttons">
                            <form method="post" action="{{ route('addToCart')}}">
                                @csrf
                                <input name='id' hidden value="{{ $product->id }}">
                                <button class="btn btn-success">+</button>
                            </form>
                                {{ "$product->quantity" ?? 0 }}
                            <form method="post" action="{{ route('removeFromCart') }}">
                                @csrf
                                <input name="id" hidden value="{{ $product->id }}">
                                <button @empty ($product->quantity) disabled @endempty class="btn btn-danger">-</button>
                            </form>
                        </td>
                        <td class="text-center">{{ $productSumm }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="5">Здесь пока ничего нет, но можно это <a href="{{ route('home') }}">исправить</a></td>
                    </tr>
            @endforelse
                    <tr>
                        <td class="text-end" colspan="4">Итого:</td>
                        <td class="text-center"><strong>{{ $summ }} руб.</strong></td>
                    </tr>
        </tbody>
    </table>
    @if ($summ)
        <form method="post" action="{{ route('createOrder') }}">
            @csrf
            <label>Ваше имя</label>
            <input disabled class="form-control mb-2" name="name" value="{{ $user->name ?? '' }}">
            <label>Ваш email</label>
            <input disabled class="form-control mb-2" name="email" value="{{ $user->email ?? '' }}">
            <label>Ваш адрес</label>
            <input disabled class="form-control mb-2" name="address" value="{{ $user->addresses()->where('main', 1)->first()->address ?? '' }}">
            <button type="submit" class="btn btn-warning">Оформить заказ</button>
        </form>
    @endif
@endsection