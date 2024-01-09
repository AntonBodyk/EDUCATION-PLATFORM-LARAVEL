@extends('layouts.main')
@section('content')
    <h1 class="course-title">Список курсів</h1>
    <div class="table-container">
        <table class="table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Course_Img</th>
                <th>Body</th>
                <th>Category_id</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($courses as $course)
                <tr class="tr-users">
                    <td class="td-id">{{$course->id}}</td>
                    <td class="td-avatar">{{$course->title}}</td>
                    <td class="td-name">{{$course->course_img}}</td>
                    <td class="td-email">{{$course->body}}</td>
                    <td class="td-role">{{$course->category_id}}</td>
                    <td class="td-buttons">
                        <a class="fa-solid fa-pen update-btn" href="{{route('courses.edit', ['course'=> $course->id])}}" data-user-id="{{$course->id}}"></a>
                        <i class="fa-solid fa-trash delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal{{$course->id}}"></i>
                    </td>

                </tr>


                <div class="modal fade" id="deleteModal{{$course->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ви дійсно хочете видалити курс?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-footer">
                                <form action="{{route('courses.destroy', ['course' => $course->id])}}" method="POST">
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
        {{ $courses->links() }}
    </div>

@endsection


