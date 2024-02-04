<p>Доброго дня!</p>

<p>Направляємо файл Excel з відомостями про користувачів.</p>
@if(isset($pathToFile))
    <a href="{{ route('export-users') }}" >Скачати файл</a>
@endif

<p>З повагою, <br>  Компанія SmartLearn</p>



