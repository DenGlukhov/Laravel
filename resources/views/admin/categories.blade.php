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
<h1>
    {{ $title }}
</h1>

<table class="table table-bordered">
    <thead class="text-center">
        <tr>
            <th>#</th>
            <th>Изображение</th>
            <th>Наименование категории</th>
            <th>Описание категории</th>
            <th>Перейти</th>
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
                <a class="btn btn-warning next_button" aria-current="page" href="{{ route('category', $category->id) }}">
                    <strong>Перейти</strong>
                </a>
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
    <form class="mb-2" method="post" action="{{ route('exportCategories') }}">
        @csrf
        <button type="submit" class="btn btn-primary unload_upload_button">Выгрузить категории</button>
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
            <label class="form-label">Файл для импорта категорий</label>
            <input type="file" name="importFile" class="form-control">
        </div>
        <button type="submit" class="btn btn-info unload_upload_button">Загрузить категории из файла</button>
    </form> 
@endsection