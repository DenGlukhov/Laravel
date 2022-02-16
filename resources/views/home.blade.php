@extends('layouts.app')

@section('styles')
<style>
    .category-card {
        height: 400px;
        padding:10px;
    }
    .card-body {
        text-align:center;
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
        <div class="col-3 mb-4" style="display:flex;">
            <div  class="category-card card" style="display: inline-flex;">
              <img src="{{ asset('storage')}}/{{$category->picture }}" class="card-img-top" alt="{{ $category->name}}">
              <div class="card-body">
                    <h5 class="card-title" title="{{ $category->name }}">
                        {{ $category->name }}
                    </h5>
                        <p class="card-text" title="{{ $category->description }}">
                            {{ $category->description }}
                        </p>
                    <a href="{{ route('category', $category->id) }}" class="btn btn-primary w-100" style="align-self:flex-end; flex: ">Перейти</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
