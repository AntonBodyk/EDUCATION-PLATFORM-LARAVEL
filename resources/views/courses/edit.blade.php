@extends('layouts.main')
@section('content')
    <h1 class="update-course">Форма оновлення курсу</h1>
    <form action="{{route('courses.update', ['course'=> $course->id])}}" class="update-course-info" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <input type="hidden" name="id" value="{{ $course->id }}">
        <div class="mb-3">
            <label for="exampleInputTitle1" class="form-label">Назва курсу</label>
            <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputTitle1" value="{{old('title', $course->title)}}">
        </div>
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleTextAreaBody1" class="form-label">Опис курсу</label>
            <textarea name="body" type="text" class="form-control @error('body') is-invalid @enderror" id="exampleTextAreaBody1">{{old('body', $course->body)}}</textarea>
        </div>
        @error('body')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleInputCategory1" class="form-label">Категорія курсу</label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" id="exampleInputCategory1">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{old('category_id', $course->category_id)  == $category->id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>
        @error('category_id')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn btn-success new-user-btn">Оновити</button>
    </form>
@endsection
