@extends('layouts.app')

@section('title')
    Список продуктов
@endsection

@section('styles')
    <style>
        .vertical_align_text {
            vertical-align: middle;
        }
    </style>
@endsection
@section('content')
<h1>
    {{ $title }}
</h1>

<table class="table table-bordered">
    <thead class="text-center">
        <tr>
            <th>#</th>
            <th>Изображение</th>
            <th>Наименование продукта</th>
            <th>Описание продукта</th>
            <th>Стоимость продукта</th>
            <th>ID Категории</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr class='vertical_align_text'>
            <td class="text-center">{{ $product->id }}</td>
            <td class="text-center" width='100'> 
                <img src="{{ asset('storage') }}/{{ $product->picture }}" height='100'>
            </td>
            <td class="text-center">{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td class="text-center">{{ $product->price }} .руб</td>
            <td class="text-center">{{ $product->category_id }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection