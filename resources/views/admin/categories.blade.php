@extends('layouts.app')

@section('title')
    Список категорий
@endsection

@section('styles')
    <style>
        .vertical_align_text {
            vertical-align: middle;
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
@endsection