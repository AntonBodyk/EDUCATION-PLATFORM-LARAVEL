@extends('layouts.main')
@section('content')
    <h1 class="create-course">Форма створення уроку</h1>
    <form action="{{route('lessons.store')}}" class="new-course" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="exampleInputTitle1" class="form-label">Назва уроку</label>
            <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputTitle1" value="{{ old('title') }}">
        </div>
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleInputCourseImg1" class="form-label">Видео</label>
            <input name="lesson_video" type="file" class="form-control @error('lesson_video') is-invalid @enderror" id="exampleInputCourseImg1" value="{{ old('lesson_video') }}">
        </div>
        @error('lesson_video')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleTextAreaBody1" class="form-label">Опис уроку</label>
            <textarea name="description" type="text" class="form-control @error('description') is-invalid @enderror" id="exampleTextAreaBody1">{{old('description')}}</textarea>
        </div>
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleInputCourseExercise1" class="form-label">Завдання</label>
            <input name="lesson_exercise" type="file" class="form-control @error('lesson_exercise') is-invalid @enderror" id="exampleInputCourseExercise1" value="{{ old('lesson_exercise') }}">
        </div>
        @error('lesson_exercise')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn btn-success new-user-btn">Створити</button>
    </form>
@endsection
