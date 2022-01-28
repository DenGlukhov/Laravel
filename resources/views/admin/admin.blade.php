@extends('layouts.app')

@section('title')
    Админка
@endsection

@section('styles')
    <style>
        .unload-upload-button {
            width: 235px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="mb-2">
            <a href="{{ route('adminUsers') }}">Список пользователей</a>
            <a href="{{ route('adminProducts') }}">Список продуктов</a>
            <a href="{{ route('adminCategories') }}">Список категорий</a>
        </div>
        <form class="mb-2" method="post" action="{{ route('exportCategories') }}">
            @csrf
            <button type="submit" class="btn btn-primary unload-upload-button">Выгрузить категории</button>
        </form>
        <form method="post" action="{{ route('importCategories') }}">
            @csrf
            <button type="submit" class="btn btn-info unload-upload-button">Загрузить категории из файла</button>
        </form>
    </div>
@endsection