<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Report</title>
    <style>
        body,
        * {
            font-family: 'DejaVu Sans', sans-serif;
        }
    </style>
</head>
<body>
    <p style="font-size: 28px;">Отчет</p>
    <br />
    <br />
    <p>Количество созданных курсов за последнюю неделю: {{ $coursesLastWeek }}</p>
    <p>Количество созданных курсов за последний месяц: {{ $coursesLastMonth }}</p>
    <p>Общее количество курсов: {{ $totalCourses }}</p>
</body>
</html>
