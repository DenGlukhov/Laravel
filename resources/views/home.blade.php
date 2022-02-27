@extends('layouts.app')

@section('styles')
<style>
   .card-body {
        text-align:center;
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

<categories-component 
    :categories="{{ $categories }}"
    route-category="{{ route('category', '') }}" 
    page-title="Список категорий" 
    test="test">
</categories-component>

{{-- <div class="row" style="display:inline-flex; flex-flow: row wrap; justify-content:space-evenly; border:4px solid rgb(228, 75, 169); background:rgb(208, 170, 212);">
    @foreach ($categories as $category)
    <div class="col-3 mb-4 mt-4" style="display:flex; flex:1 1 300px;">
        <div  class="category-card card" style="display:flex; flex-flow:row wrap;">
            <img src="{{ asset('storage')}}/{{$category->picture }}" class="card-img-top" alt="{{ $category->name}}" style="flex:1;" >
            <div class="card-body" style="display:flex; flex-direction:column; align-self:flex-end; flex:2;">
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
</div> --}}
@endsection
