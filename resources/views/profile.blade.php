@extends('layouts.app')

@section('title')
    Профиль
@endsection

@section('styles')
    <style>
        .user-picture {
            display:flex;
            width: 180px ;
            border-radius: 180px;
        }
        .main-address {
            font-weight: bold;
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

    @if(session('saveProfileSuccess'))
        <div class="alert alert-success" role="alert">
            Изменения успешно сохранены
        </div>
    @endif
        {{-- <example-component></example-component> --}}
        {{-- <profile-component
            :user="{{ $user }}"
            :addresses="{{ $user->addresses }}"
            route-profile="{{ route('profile', '') }}"
            route-orders="{{ route('orders') }}" 
            page-title="Страница профиля" 
            :errors="{{ $errors }}"
        ></profile-component> --}}
    <form method="post" action="{{ route('saveProfile') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{ $user->id }}" name="userId">
        <div class="mb-3">
            <label class="form-label">Изображение</label>
                <div class="image-block mb-2">
                    <img class='user-picture mb-2' src="{{ asset('storage') }}/{{ $user->picture }}">
                </div>        
            <input type="file" name="picture" class="form-control">
                
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Почта</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">Мы не палим Вашу почту, честно :)</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Имя</label>
            <input name="name" value="{{ $user->name }}" class="form-control">
        </div>
        <div>
            <label class="form-label">Изменить пароль:</label>
            <input type="password" autocomplete="off" placeholder="Введите текущий пароль" name="current_password" class="form-control mb-2">
        </div>
        <div>
            <input type="password" placeholder="Введите новый пароль" name="password" class="form-control mb-2">
        </div>
        <div>
            <input type="password" placeholder="Повторите новый пароль" name="password_confirmation" class="form-control mb-2">
        </div>
        <div class="mb-3">
            <label class="form-label">Список адресов:</label>
            <ul>
                @forelse ($user->addresses as $address)
                    <input class="form-check-input" @if ($address->main) checked @endif id="{{ $address->id }}" name="main_address" type="radio" value="{{ $address->id }}">
                    <label for="{{ $address->id }}">{{$address->address}}</label>
                    <br>
                @empty 
                    <em>- Адреса не указаны -</em>
                @endforelse
            </ul>
        </div>
        <div class="mb-3">
            <label class="form-label">Новый адрес</label>
            <input name="new_address" class="form-control" placeholder="Введите новый адрес">
                <div class="form-check mt-1">
                    <input name="set_main_address" class="form-check-input" type="checkbox" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    Сделать адресом по-умолчанию
                    </label>
                </div>
        </div>
            <button type="submit" class="btn btn-warning"><strong>Сохранить</strong></button>
    </form>
    <a class="btn btn-danger next_button mt-2" aria-current="page" href="{{ route('orders', Auth::user()->id) }}">
        <strong>Мои заказы</strong>
    </a>
@endsection