@extends('layouts.main')
@section('content')
    <h1 class="create-user">Форма створення користувача</h1>
    <form action="{{route('users.store')}}" class="new-user" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="exampleInputAvatar1" class="form-label">Фото</label>
            <input name="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" id="exampleInputAvatar1" value="{{ old('avatar') }}">
        </div>
        @error('avatar')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleInputSecondName" class="form-label">Прізвище</label>
            <input name="second_name" type="text" class="form-control @error('second_name') is-invalid @enderror" id="exampleInputSecondName" value="{{ old('second_name') }}">
        </div>
        @error('second_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleInputFirstName" class="form-label">Ім'я</label>
            <input name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" id="exampleInputFirstName" value="{{ old('first_name') }}">
        </div>
        @error('first_name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleInputLastName" class="form-label">Ім'я по батькові</label>
            <input name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" id="exampleInputLastName" value="{{ old('last_name') }}">
        </div>
        @error('last_name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Ел.адреса</label>
            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('email') }}">
        </div>
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Пароль</label>
            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" value="{{ old('password') }}">
        </div>
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleInputRole1" class="form-label">Роль</label>

            <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" id="exampleInputRole1">
                <option value="" selected disabled>Виберіть роль</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $role === $role->id ? 'selected' : '' }}>
                        {{ $role->role_name }}
                    </option>
                @endforeach
            </select>
        </div>
        @error('role_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn btn-success new-user-btn">Створити</button>
    </form>
@endsection
