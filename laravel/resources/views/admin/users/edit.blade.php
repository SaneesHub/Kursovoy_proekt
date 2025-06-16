@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактировать пользователя: {{ $user->name }}</h1>
    <form method="POST" action="{{ route('admin.users.update', $user->ID_user) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="ID_role">Роль</label>
            <select name="ID_role" id="ID_role" class="form-control">
                @foreach ($roles as $role)
                    <option value="{{ $role->ID_role }}" {{ $user->ID_role == $role->ID_role ? 'selected' : '' }}>
                        {{ $role->Name_role }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Сохранить</button>
    </form>
</div>
@endsection
