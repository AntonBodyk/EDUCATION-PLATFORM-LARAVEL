@extends('layouts.main')
@section('content')
    <h1 class="update-user">Форма оновлення даних користувача</h1>

        <form action="{{route('users.update', ['user' => $user->id])}}" method="POST" class="update-user-info" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="mb-3">
                <label for="exampleInputAvatar" class="form-label">Фото</label>
                <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="exampleInputAvatar" name="avatar" value="{{old('avatar', $user->avatar)}}">
            </div>
            @error('avatar')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="exampleInputSecondName" class="form-label">Прізвище</label>
                <input type="text" class="form-control @error('second_name') is-invalid @enderror" id="exampleInputSecondName" name="second_name" value="{{old('second_name', $user->second_name)}}">
            </div>
            @error('second_name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="exampleInputFirstName" class="form-label">Ім'я</label>
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="exampleInputFirstName" name="first_name" value="{{old('first_name', $user->first_name)}}">
            </div>
            @error('first_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="exampleInputLastName" class="form-label">Ім'я по батькові</label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="exampleInputLastName" name="last_name" value="{{old('last_name', $user->last_name)}}">
            </div>
            @error('last_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" value="{{old('email', $user->email)}}">
            </div>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="exampleInputRole1" class="form-label">Роль</label>
                <select class="form-select @error('role_id') is-invalid @enderror" name="role_id" id="exampleInputRole1">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}"  {{old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
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
