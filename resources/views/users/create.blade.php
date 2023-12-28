@extends('layouts.main')
@section('content')
    <h1 class="create-user">Форма створення користувача</h1>
    <form action="{{route('users.store')}}" class="new-user" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="exampleInputAvatar1" class="form-label">Фото</label>
            <input name="avatar" type="file" class="form-control" id="exampleInputAvatar1">
        </div>
        <div class="mb-3">
            <label for="exampleInputName1" class="form-label">Ім'я</label>
            <input name="name" type="text" class="form-control" id="exampleInputName1">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Ел.адреса</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Пароль</label>
            <input name="password" type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3">
            <label for="exampleInputRole1" class="form-label">Роль</label>
            <input name="role" type="text" class="form-control" id="exampleInputRole1">
        </div>
        <button type="submit" class="btn btn-success new-user-btn">Створити</button>
    </form>
@endsection
