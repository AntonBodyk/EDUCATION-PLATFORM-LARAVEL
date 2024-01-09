@extends('layouts.main')
@section('content')
    <section class="container mt-6">
        <div class="row">
            <div class="col-md-8">
                <h1>Ласкаво просимо до адмін-панелі</h1>
                @auth()
                    <p>Тут ви можете керувати користувачами, курсами та іншими аспектами вашого сайту.</p>
                    <p>Не соромтеся використовувати навігаційне меню вгорі, щоб легко переміщатися між розділами.</p>
                @endauth
            </div>
        </div>
    </section>
@endsection
