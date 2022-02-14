@extends('layouts.app')

@section('styles')
<style>
    .category-card {
        height: 400px;
    }
    .card-text {
        height: 46px;
    }
    .card-title {
        height: 22px;
    }
    .clip {
        white-space: nowrap; /* Запрещаем перенос строк */
        overflow: hidden; /* Обрезаем все, что не помещается в область */
        padding: 5px; /* Поля вокруг текста */
        text-overflow: ellipsis; /* Добавляем многоточие */
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        @foreach ($categories as $category)
        <div class="col-3">
            <div class="category-card card mb-4" style="background-color: rgb(204, 218, 174); display: inline-flex; flex-flow: column nowrap; ">
                <img src="{{ asset('storage')}}/{{$category->picture }}" class="card-img-top" alt="{{ $category->name}}">
                <div class="card-body">
                    <h5 class="card-title" title="{{ $category->name }}">
                        {{ $category->name }}
                    </h5>
                        <p class="card-text" title="{{ $category->description }}">
                            {{ $category->description }}
                        </p>
                    <a href="{{ route('category', $category->id) }}" class="btn btn-primary w-100">Перейти</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
