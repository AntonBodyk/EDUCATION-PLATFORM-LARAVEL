@extends('layouts.main')
@section('content')
    <h1 class="create-course">Форма створення курсу</h1>
    <form action="{{route('courses.store')}}" class="new-course" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="exampleInputTitle1" class="form-label">Назва курсу</label>
            <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputTitle1" value="{{ old('title') }}">
        </div>
        @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleInputCourseImg1" class="form-label">Картинка</label>
            <input name="course_img" type="file" class="form-control @error('course_img') is-invalid @enderror" id="exampleInputCourseImg1" value="{{ old('course_img') }}">
        </div>
        @error('course_img')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleTextAreaBody1" class="form-label">Опис курсу</label>
            <textarea name="body" type="text" class="form-control @error('body') is-invalid @enderror" id="exampleTextAreaBody1">{{old('body')}}</textarea>
        </div>
        @error('body')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleInputPrice1" class="form-label">Ціна</label>
            <input name="course_price" type="text" class="form-control @error('course_price') is-invalid @enderror" id="exampleInputPrice1" value="{{ old('course_price') }}">
        </div>
        @error('course_price')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleInputCategory1" class="form-label">Категорія курсу</label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" id="exampleInputCategory1">
                <option value="" selected disabled>Виберіть категорію</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category === $category->id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>
        @error('category_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn btn-success new-user-btn">Створити</button>
    </form>
@endsection
