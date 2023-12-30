@extends('layouts.main')
@section('content')
    <h1 class="user-title">Список користувачів</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Avatar</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Password</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->avatar}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->role}}</td>
                <td>{{$user->password}} <i class="fa-solid fa-pen update-btn" data-bs-toggle="modal" data-bs-target="#updateModal{{$user->id}}"></i>
                    <i class="fa-solid fa-user-xmark delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->id}}"></i></td>

            </tr>

            <div class="modal fade" id="updateModal{{$user->id}}" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Оновлення данних користувача</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('users.update', ['user' => $user->id])}}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="exampleInputName1" class="form-label">Фото</label>
                                    <input type="file" class="form-control" id="exampleInputName1" name="avatar" value="{{$user->avatar}}">
                                </div>
                                @error('avatar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="mb-3">
                                    <label for="exampleInputName1" class="form-label">Ім'я</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName1" name="name" value="{{$user->name}}">
                                </div>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" value="{{$user->email}}">
                                </div>
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Пароль</label>
                                    <input type="password" class="form-control" name="password" id="exampleInputPassword1" value="{{$user->password}}">
                                </div>
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="mb-3">
                                    <label for="exampleInputRole1" class="form-label">Роль</label>
                                    <input type="text" class="form-control" name="role" id="exampleInputRole1" value="{{$user->role}}">
                                </div>
                                @error('role')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <button type="submit" class="btn btn-primary confirm-update-btn">Оновити</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ви дійсно хочете видалити користувача?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-footer">
                            <form action="{{route('users.destroy', ['user' => $user->id])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Ні</button>
                                <button type="submit" class="btn btn-danger confirm-delete-btn">Так</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
@endsection
