@extends('layouts.main')
@section('content')
    <h1 class="course-title">Структура курсу</h1>
    <div class="table-container">
        <table class="table">
            <thead>
            <tr>
                <th>
                    <a class="th-link-id" href="{{ route('lessons.index') }}">
                        Id
                    </a>
                </th>
                <th>
                    <a class="th-link-title" href="{{ route('lessons.index') }}">
                        Title
                    </a>
                </th>
                <th>
                    <a class="th-link-body" href="{{ route('lessons.index')}}">
                        Description
                    </a>
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($lessons as $lesson)
                <tr class="tr-courses">
                    <td class="td-id">{{$lesson->id}}</td>
                    <td class="td-avatar">{{$lesson->title}}</td>
                    <td class="td-email">{{$lesson->description}}</td>
                    <td class="td-buttons">
                        <a class="fa-solid fa-pen update-btn" href="{{route('lessons.edit', ['lesson'=> $lesson->id])}}" data-user-id="{{$lesson->id}}"></a>
                        <i class="fa-solid fa-trash delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal{{$lesson->id}}"></i>
                    </td>

                </tr>


                <div class="modal fade" id="deleteModal{{$lesson->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ви дійсно хочете видалити урок?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-footer">
                                <form action="{{route('lessons.destroy', ['lesson' => $lesson->id])}}" method="POST">
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



@endsection


