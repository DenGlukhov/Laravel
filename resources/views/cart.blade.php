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

@if($errors->isNotEmpty())
<div class="alert alert-warning" role="alert">
    @foreach($errors->all() as $error)
        {{ $error }} 
        @if (!$loop->last) <br> @endif
    @endforeach
    @if (session('emailError'))
    <div class="alert alert-warning">
        Указанная почта уже используется
    </div>
@endif
  </div>
@endif

    <cart-component
        :prods="{{ $products }}"
        @if ($user)
        :user="{{ $user }}"
        @endif
        address="{{ $address }}"    
    >
    </cart-component>

@endsection
