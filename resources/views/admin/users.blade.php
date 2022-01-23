@extends('layouts.app')

@section('title')
    Список пользователей
@endsection

@section('content')
<h1>
    {{ $title }}
</h1>

<table class="table table-bordered">
    <thead class="text-center">
        <tr>
            <th>#</th>
            <th>Имя</th>
            <th>Почта</th>
            <th>Админ</th>
            <th>Войти</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td class="text-center">{{ $user->id }}</td>
            <td class="text-center">{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td class="text-center">{{ $user->is_admin }}</td>
            <td class="text-center">
                <a href="{{ route('enterAsUser', $user->id) }}">Войти</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
