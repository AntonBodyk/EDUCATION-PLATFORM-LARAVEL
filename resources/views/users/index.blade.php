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
                    <td class="td-buttons">
                        <a class="fa-solid fa-pen update-btn" href="{{route('users.edit', ['user'=> $user->id])}}" data-user-id="{{$user->id}}"></a>
                        <i class="fa-solid fa-user-xmark delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->id}}"></i>
                    </td>

                </tr>


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

@endsection


