@extends('layouts.app')

@section('title')
    Список категорий
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
<a name="top"></a>    
<a class="updown_button" href="#bottom" title="Вниз страницы">
    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="color-black" class="bi bi-arrow-down-square-fill" viewBox="0 0 16 16">
        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5a.5.5 0 0 1 1 0z"/>
    </svg>
</a>

@if($errors->isNotEmpty())
    <div class="alert alert-warning" role="alert">
        @foreach($errors->all() as $error)
            {{ $error }} 
            @if (!$loop->last) <br> @endif
        @endforeach
      </div>
    @endif

<form method="post" action="{{ route('createCategory') }}" class="mb-3 border-bottom" enctype="multipart/form-data">
    @csrf
    <div class="mb-2">
        <label class="form-label"><h4>Создать новую категорию</h4></label>
        <input type="text" name="name" placeholder="Введите наименование создаваемой категории" class="form-control">
    </div>
    <div class="mb-2">
        <textarea type="text" name="description" placeholder="Введите описание создаваемой категории" class="form-control"></textarea>
    </div>
    <div class="mb-2">
        <label class="form-label">Изображение создаваемой категории</label>
        <input type="file" name="picture" class="form-control">
    </div>
    <button type="submit" class="btn btn-warning mb-2">Создать категорию</button>
</form>

@if (session('startImportCategories'))
    <div class="alert alert-success">
        Импорт категорий из файла запущен
    </div>
@endif
@if (session('importFileError'))
    <div class="alert alert-warning">
        Тип загружаемого файла не соответствует требуемому, необходимо загрузить файл с расширением .csv!
    </div>
@endif
@if (session('importFileIsMissing'))
    <div class="alert alert-warning">
        Файл не найден, загрузите файл в формате .csv!
    </div>
@endif
    <form method="post" action="{{ route('importCategories') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label"><h4>Импортировать категории из файла<br></h4>Файл для импорта категорий</label>
            <input type="file" name="importFile" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Загрузить категории из файла</button>
    </form>  

<h3 class="text-center">
    {{ $title }}
</h3>

<table class="table table-bordered">
    <thead class="text-center">
        <tr>
            <th>#</th>
            <th>Изображение</th>
            <th>Наименование категории</th>
            <th>Описание категории</th>
            <th>Перейти</th>
            <th>Удалить</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr class='vertical_align_text'>
            <td class="text-center">{{ $category->id }}</td>
            <td class="text-center" width='100'> 
                <img src="{{ asset('storage') }}/{{ $category->picture }}" height='100'>
            </td>
            <td class="text-center">{{ $category->name }}</td>
            <td>{{ $category->description }}</td>
            <td class="text-center">
                <a class="btn btn-warning" aria-current="page" href="{{ route('category', $category->id) }}">
                    <strong>Перейти</strong>
                </a>
            </td>
            <td class="text-center">
                <form method="post" action="{{ route('deleteCategory', $category->id) }}">
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

@if (session('startExportCategories'))
    <div class="alert alert-success">
        Выгрузка категорий запущена
    </div>
@endif
    <form class="mb-2 border-top" method="post" action="{{ route('exportCategories') }}">
        @csrf
        <div>
            <label class="form-label mt-2"><h4>Выгрузить список категорий в файл</h4></label>
        </div>
        <button type="submit" class="btn btn-primary">Выгрузить категории</button>
    </form>
<a class="updown_button" href="#top" title="Наверх страницы"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="color-black" class="bi bi-arrow-up-square-fill" viewBox="0 0 16 16">
    <path d="M2 16a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2zm6.5-4.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 1 0z"/>
    </svg>
</a>
<a name="bottom"></a>
@endsection