@extends('layouts.app')

@section('content')
<div class="container max-w-2xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Чат по запросу #{{ $request->id_request }}</h2>

    <div class="bg-gray-100 p-4 h-96 overflow-y-scroll rounded">
        @foreach($messages as $msg)
            <div class="mb-2">
                <strong>{{ $msg->id_user === Auth::user()->id_user ? 'Вы' : 'Оператор' }}:</strong>
                <span>{{ $msg->content }}</span>
                <div class="text-xs text-gray-500">{{ $msg->date_sending }}</div>
            </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('chat.send') }}" class="mt-4">
        @csrf
        <input type="hidden" name="id_request" value="{{ $request->id_request }}">
        <input type="hidden" name="use_id_user" value="{{ $request->id_user }}">
        <input type="hidden" name="use_id_role" value="{{ $request->id_role }}">

        <textarea name="content" class="w-full border p-2 rounded" placeholder="Введите сообщение" required></textarea>
        <button type="submit" class="btn btn-primary mt-2">Отправить</button>
    </form>
</div>
@endsection
