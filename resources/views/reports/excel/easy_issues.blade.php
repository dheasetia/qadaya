<table>
    <caption>القضايا اليسيرة للدائرة القضائية: {{$office}}</caption>
    <thead>
    <tr>
        <th>الرقم</th>
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
            <td>{{$loop->iteration}}</td>
            <td>{{$issue_number}}</td>
            <td>{{$money_claimed}}</td>
            <td>{{$has_future_appointment}}</td>
            <td>{{$sessions}}</td>
            <td>{{$age}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
