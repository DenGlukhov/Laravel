@extends('layouts.app')

@section('styles')
<style>
    .updown_button {
        float: right;
        opacity: 0.5;
    }
    .updown_button:hover {
        opacity: 0.9;
    }
</style>
@endsection

@section('title')
    Список пользователей
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
<div style="display:flex; flex-direction:column; justify-content: space-evenly;" >
    <a name="top"></a>    
    <a style="display: flex; justify-content: flex-end;" class="updown_button" href="#bottom" title="Вниз страницы">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="color-black" class="bi bi-arrow-down-square-fill" viewBox="0 0 16 16">
            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5a.5.5 0 0 1 1 0z"/>
        </svg>
    </a>

    <h3 class="text-center">
        Список ролей
    </h3>

    <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th>#</th>
                <th>Название</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @forelse ($roles as $idx => $role)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $role->name }}</td>
            </tr>
            @empty 
            <tr>
                <td colspan="2">На данный момент роли не определены</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <form method="post" action="{{ route('addRole') }}" class="mb-4">
    @csrf
    <label class="mb-2">Создать новую роль</label>
    <input class="form-control mb-2" name="new_role" placeholder="Введите название новой роли">
    <button type="submit" class="btn btn-success" >Создать</button>
    </form>

    <h3 class="text-center">
        {{ $title }}
    </h3>

    <table style="vertical-align: middle" class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th>#</th>
                <th>Имя</th>
                <th width="20%">Почта</th>
                <th>Назначение ролей</th>
                <th>Текущая роль</th>
                <th>Войти</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="text-center">{{ $user->id }}</td>
                <td class="text-center">{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <form style="display:flex; justify-content: space-evenly; gap: 5px;" method="post" action="{{ route('applyRole', $user->id)}}">
                        @csrf
                        <select class="form-control text-center" name="role_id">
                            <option disabled selected>Укажите роль</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" style="height: 37px" class="btn btn-warning">Применить</button>
                    </form>
                </td>
                <td class="text-center">
                    <ul>
                        @foreach ($user->roles as $role)
                        <li>{{ $role->name }}</li>
                        @endforeach
                    </ul>
                </td>
                <td class="text-center">
                    <a href="{{ route('enterAsUser', $user->id) }}">Войти</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a class="updown_button" style="display: flex; justify-content: flex-end;" href="#top" title="Наверх страницы"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="color-black" class="bi bi-arrow-up-square-fill" viewBox="0 0 16 16">
        <path d="M2 16a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2zm6.5-4.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 1 0z"/>
        </svg>
    </a>
    <a name="bottom"></a>
</div>
@endsection
