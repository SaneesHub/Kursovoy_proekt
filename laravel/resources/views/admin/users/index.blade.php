@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Пользователи</h1>
    @foreach ($users as $user)
        <div class="p-4 mb-4 border rounded bg-white shadow">
            <p><strong>{{ $user->name }}</strong> ({{ $user->email }})</p>
            <p>Роль: {{ $user->role->Name_role ?? 'Нет роли' }}</p>
            <a href="{{ route('admin.users.edit', $user->ID_user) }}" class="btn btn-primary">Редактировать</a>

            <form method="POST" action="{{ route('admin.users.destroy', $user->ID_user) }}" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Удалить пользователя?')">Удалить</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
