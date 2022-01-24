@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach ($categories as $category)
        <div class="col-3">
            <div class="card mb-4" style="width: 18rem;">
                <img src="{{ asset('storage')}}/{{$category->picture }}" class="card-img-top" alt="{{ $category->name }}">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $category->name }}
                    </h5>
                        <p class="card-text">
                            {{ $category->description }}
                        </p>
                    <a href="#" class="btn btn-primary w-100">Перейти</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
