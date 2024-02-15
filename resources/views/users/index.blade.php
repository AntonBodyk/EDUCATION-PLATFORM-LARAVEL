@extends('layouts.main')
@section('content')
    <h1 class="user-title">Список користувачів</h1>
    <div class="table-container">
        <table class="table">
            <thead>
            <tr>
                <th>
                    <a class="th-link-surname" href="{{ route('users.index', ['sortColumn' => 'second_name', 'sortDirection' => $sortColumn === 'second_name' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                        Прізвище
                    </a>
                </th>
                <th>
                    <a class="th-link-name" href="{{ route('users.index', ['sortColumn' => 'first_name', 'sortDirection' => $sortColumn === 'first_name' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                        Ім'я
                    </a>
                </th>
                <th>По батькові</th>
                <th>
                    <a class="th-link-email" href="{{ route('users.index', ['sortColumn' => 'email', 'sortDirection' => $sortColumn === 'email' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                        Ел.пошта
                    </a>
                </th>
                <th>Статус</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="tr-users">
                    <td class="td-name">{{$user->second_name}}</td>
                    <td class="td-name">{{$user->first_name}}</td>
                    <td class="td-name">{{$user->last_name}}</td>
                    <td class="td-email">{{$user->email}}</td>
                    <td class="td-role">
                        <a class="td-role-link" href="{{ route('users.index', ['roleFilter' => $user->role->role_name]) }}">
                            {{$user->role->role_name}}
                        </a>
                    </td>
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
        {{ $users->appends(request()->query())->links() }}
    </div>

@endsection


