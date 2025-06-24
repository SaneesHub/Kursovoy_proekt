@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Счёт №{{ $invoice->id_invoice }}</h2>

        <div class="mb-4">
            <p><strong>Услуга:</strong> {{ $invoice->service->description_services }}</p>
            <p><strong>Тип:</strong> {{ $invoice->service->type_services }}</p>
            <p><strong>Сумма к оплате:</strong> {{ $invoice->sum_payment }} ₽</p>
            <p><strong>Дата формирования:</strong> {{ \Carbon\Carbon::parse($invoice->date_formation)->format('d.m.Y') }}</p>
            <p>
                <strong>Статус:</strong>
                @if ($invoice->status_payment)
                    <span class="text-green-600 font-semibold">Оплачено</span>
                @else
                    <span class="text-red-600 font-semibold">Не оплачено</span>
                @endif
            </p>
        </div>

        @if (!$invoice->status_payment)
            <form action="{{ route('invoice.pay', $invoice->id_invoice) }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <i class="fas fa-credit-card mr-1"></i> Оплатить
                </button>
            </form>
        @else
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4">
                <i class="fas fa-check-circle mr-2"></i> Вы уже оплатили данный счёт.
            </div>
        @endif
    </div>
</div>
@endsection
