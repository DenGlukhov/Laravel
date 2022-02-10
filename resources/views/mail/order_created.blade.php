Здравствуйте, {{ $data['name'] }}!
Благодарим Вас за оформление заказа в нашем магазине.
<table class="table table-bordered">
    <thead class="text-center">
        <tr>
            <th>#</th>
            <th>Наименование</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Сумма</th>
        </tr>
    </thead>
    <tbody>
        @php
            $summ = 0;
        @endphp
        @foreach ($data['products'] as $idx => $product)
            @php 
                $productSumm = $product->price * $product->pivot->quantity;
                $summ += $productSumm;
            @endphp
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="text-center">{{ $product->name }}</td>
                    <td class="text-center">{{ $product->price }} руб.</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td class="text-center">{{ $productSumm }}</td>
                </tr>
        @endforeach
                <tr>
                    <td class="text-end" colspan="4">Итого:</td>
                    <td class="text-center"><strong>{{ $summ }} руб.</strong></td>
                </tr>
    </tbody>
</table>
Будем рады видеть Вас снова!