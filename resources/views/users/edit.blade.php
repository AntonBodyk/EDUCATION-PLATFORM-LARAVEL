@extends('layouts.main')
@section('content')
    <h1 class="update-user">Форма оновлення даних користувача</h1>

        <form action="{{route('users.update', ['user' => $user->id])}}" method="POST" class="update-user-info" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="mb-3">
                <label for="exampleInputName1" class="form-label">Фото</label>
                <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="exampleInputName1" name="avatar">
            </div>
            @error('avatar')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="exampleInputName1" class="form-label">Ім'я</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName1" name="name">
            </div>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
            </div>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Пароль</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="exampleInputPassword1">
            </div>
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="exampleInputRole1" class="form-label">Роль</label>
                <select class="form-select @error('role_id') is-invalid @enderror" name="role_id" id="exampleInputRole1">
                    <option value="" selected disabled>Виберіть категорію</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $user === $role->id ? 'selected' : '' }}>
                            {{ $role->role_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('role_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-primary update-user-btn" data-user-id="{{$user->id}}">Оновити</button>
        </form>

@endsection
