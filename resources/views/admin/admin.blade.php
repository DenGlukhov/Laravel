@extends('layouts.app')

@section('title')
    Админка
@endsection

@section('content')
    <ul class="nav nav-pills">
        <li class="nav-item col-4">
            <a class="btn btn-warning next_button" aria-current="page" href="{{ route('adminUsers') }}">
                <strong>Список пользователей</strong>
            </a>
        </li>
        <li class="nav-item col-4">
            <a class="btn btn-warning next_button" aria-current="page" href="{{ route('adminCategories') }}">
                <strong>Список категорий</strong>
            </a>
        </li>
        <li class="nav-item col-4">
            <a class="btn btn-warning next_button" aria-current="page" href="{{ route('adminProducts') }}">
                <strong>Список продуктов</strong>
            </a>
        </li>
    </ul>
@endsection