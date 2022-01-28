@extends('layouts.app')

@section('title')
    Админка
@endsection

@section('content')
    <div class="container">
        <div class="mb-2">
            <a href="{{ route('adminUsers') }}">Список пользователей</a>
            <a href="{{ route('adminProducts') }}">Список продуктов</a>
            <a href="{{ route('adminCategories') }}">Список категорий</a>
        </div>
        <form method="post" action="{{ route('exportCategories') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Выгрузить категории</button>
        </form>
    </div>
@endsection