@extends('layouts.main')
@section('content')
    <h1 class="user-title">Список користувачів</h1>
    <div class="table-container">
        <table class="table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Avatar</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Password</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="tr-users">
                    <td class="td-id">{{$user->id}}</td>
                    <td class="td-avatar">{{$user->avatar}}</td>
                    <td class="td-name">{{$user->name}}</td>
                    <td class="td-email">{{$user->email}}</td>
                    <td class="td-role">{{$user->role}}</td>
                    <td class="td-password">{{$user->password}}</td>
                    <td class="td-buttons"><i class="fa-solid fa-pen update-btn" data-bs-toggle="modal" data-bs-target="#updateModal{{$user->id}}"></i>
                        <i class="fa-solid fa-user-xmark delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->id}}"></i></td>

                </tr>

                <div class="modal fade" id="updateModal{{$user->id}}" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Оновлення данних користувача</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="modal-body">
                                <form action="{{route('users.update', ['user' => $user->id])}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <label for="exampleInputName1" class="form-label">Фото</label>
                                        <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="exampleInputName1" name="avatar" value="{{$user->avatar}}">
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
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" value="{{$user->email}}">
                                    </div>
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Пароль</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="exampleInputPassword1" value="{{$user->password}}">
                                    </div>
                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="mb-3">
                                        <label for="exampleInputRole1" class="form-label">Роль</label>
                                        <select class="form-select @error('role') is-invalid @enderror" name="role" id="exampleInputRole1">
                                            <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Вчитель</option>
                                            <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Учень</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Адміністратор</option>
                                        </select>
                                    </div>
                                    @error('role')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <button type="submit" class="btn btn-primary confirm-update-btn" data-user-id="{{$user->id}}">Оновити</button>
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
    </div>


    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

                    let userId = this.getAttribute('data-user-id');
                    // console.log(userId);
                    let updateModal = new bootstrap.Modal(document.getElementById('updateModal{{$user->id}}'));

                    let hasErrors = document.querySelector('.modal-body[data-user-id="' + userId + '"] .alert-danger');

                    if (hasErrors) {
                        updateModal.show();
                    }
        });
    </script>
@endsection


