<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        th {
            font-size: 16px;
            font-weight: bold;
            background: grey;
        }
        .cell {
            background: red;
        }
    </style>
</head>
<body>
<table>
    <caption>القضايا اليسيرة للدائرة القضائية: {{$office}}</caption>
    <thead>
    <tr>
        <th style="font-weight: bold;">الرقم</th>
        <th>رقم القضية</th>
        <th>مبلغ المطالبة</th>
        <th>لها موعد قادم</th>
        <th>الجلسات</th>
        <th>الأيام منذ القيد</th>
    </tr>
    </thead>
    <tbody>
    @foreach($issues as $issue)
        <tr>
            <td class="cell">{{$loop->iteration}}</td>
            <td>{{$issue->issue_number}}</td>
            <td>{{$issue->money_claimed}}</td>
            <td>{{$issue->has_future_appointment}}</td>
            <td>{{$issue->sessions}}</td>
            <td>{{$issue->age}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>

