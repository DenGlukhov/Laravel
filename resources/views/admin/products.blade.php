@extends('layouts.app')

@section('title')
    Список продуктов
@endsection

@section('styles')
    <style>
        .vertical_align_text {
            vertical-align: middle;
        }
        .updown_button {
            float: right;
            opacity: 0.5;
        }
        .updown_button:hover {
            opacity: 0.9;
        }
    </style>
@endsection

@section('content')
    <a class="updown_button" href="#bottom" title="Вниз страницы">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="color-black" class="bi bi-arrow-down-square-fill" viewBox="0 0 16 16">
            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5a.5.5 0 0 1 1 0z"/>
        </svg>
    </a>
<a name="top"></a>
    @if($errors->isNotEmpty())
        <div class="alert alert-warning" role="alert">
            @foreach($errors->all() as $error)
                {{ $error }} 
                @if (!$loop->last) <br> @endif
            @endforeach
      </div>
    @endif

    @if (session('categoryError'))
        <div class="alert alert-warning">
            Укажите категорию
        </div>
    @endif

<form method="post" action="{{ route('createProduct') }}" class="mb-3 border-bottom" enctype="multipart/form-data">
    @csrf
    <div class="mb-2">
        <label class="form-label"><h4>Создать новый продукт</h4></label>
        <input type="text" name="name" placeholder="Введите наименование создаваемого продукта" class="form-control">
    </div>
    <div class="mb-2">
        <textarea type="text" name="description" placeholder="Введите описание создаваемого продукта" class="form-control"></textarea>
    </div>
    <div class="mb-2">
        <label class="form-label">Изображение создаваемого продукта</label>
        <input type="file" name="picture" class="form-control">
    </div>
    <div class="mb-2">
        <input type="text" name="price" placeholder="Введите стоимость создаваемого продукта, .руб" class="form-control">
    </div>
    <div class="mb-2">
        <select class="form-control" name="category_id">
            <option disabled selected>--Выберите категорию--</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-warning mb-2">Создать продукт</button>
</form>

<h3 class="text-center">
    {{ $title }}
</h3>

<table class="table table-bordered">
    <thead class="text-center">
        <tr>
            <th>#</th>
            <th>Изображение</th>
            <th>Наименование продукта</th>
            <th>Описание продукта</th>
            <th>Стоимость продукта</th>
            <th>ID Категории</th>
            <th>Удалить</th>
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
            <td class="text-center">{{ $product->category_id}}</td>
            <td class="text-center">
                <form method="post" action="{{ route('deleteProduct', $product->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <strong>X</strong>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<a name="bottom"></a>
<a class="updown_button" href="#top" title="Наверх страницы"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="color-black" class="bi bi-arrow-up-square-fill" viewBox="0 0 16 16">
    <path d="M2 16a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2zm6.5-4.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 1 0z"/>
  </svg></a>
@endsection