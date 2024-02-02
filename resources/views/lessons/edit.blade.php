@extends('layouts.main')
@section('content')
    <h1 class="update-course">Форма оновлення уроку</h1>
    <form action="{{route('lessons.update', ['lesson'=> $lesson->id])}}" class="update-course-info" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <input type="hidden" name="id" value="{{ $lesson->id }}">
        <div class="mb-3">
            <label for="exampleInputTitle1" class="form-label">Назва уроку</label>
            <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputTitle1" value="{{old('title', $lesson->title)}}">
        </div>
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleTextAreaDescription1" class="form-label">Опис уроку</label>
            <textarea name="description" type="text" class="form-control @error('description') is-invalid @enderror" id="exampleTextAreaDescription1">{{old('description', $lesson->description)}}</textarea>
        </div>
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn btn-success new-user-btn">Оновити</button>
    </form>
@endsection
