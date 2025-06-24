@extends('layouts.app')

@section('content')
    <h2>Счета пользователя</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Услуга</th>
                <th>Дата формирования</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->service->description_services ?? '—' }}</td>
                    <td>{{ $invoice->date_formation }}</td>
                    <td>{{ $invoice->sum_payment }} ₽</td>
                    <td>
                        @if ($invoice->status_payment)
                            <span class="text-success">Оплачен</span>
                        @else
                            <span class="text-danger">Не оплачен</span>
                        @endif
                    </td>
                    <td>
                        @if (!$invoice->status_payment)
                            <form method="POST" action="{{ route('invoice.pay', $invoice->id_invoice) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Оплатить</button>
                            </form>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
