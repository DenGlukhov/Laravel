@extends('layouts.app')

@section('content')
<table class="table table-bordered">
    <thead class="text-center">
        <tr>
            <th>#</th>
            <th>Номер заказа</th>
            <th>Адрес</th>
            <th>Дата оформления</th>
        </tr>
    </thead>
    <tbody>
        
        @forelse ($orders as $idx => $order)
                <tr class="text-center">
                    <td>{{ $idx + 1 }}</td>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->getAddress($order->address_id) }}</td>
                    <td>{{ $order->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="5">Здесь пока ничего нет, но можно это <a href="{{ route('home') }}">исправить</a></td>
                </tr>
        @endforelse
    </tbody>
</table>
@endsection