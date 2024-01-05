@extends('layouts.main')
@section('content')
    <form action="{{ route('send-email') }}" method="post" class="send-email" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="exampleInputName1" class="form-label">Отчет</label>
            <input type="file" class="form-control @error('report') is-invalid @enderror" id="exampleInputName1" name="report">
        </div>
        @error('report')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" class="form-control " placeholder="Введіть електронну адресу" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" required>
        </div>
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn btn-primary send-email-btn">Відправити</button>
    </form>
@endsection
