@extends('layouts.app')

@section('plugin_styles')
    <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/src/table/datatable/datatables.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/css/light/table/datatable/dt-global_style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/css/dark/table/datatable/dt-global_style.css')}}">
    <!-- END PAGE LEVEL STYLES -->
@endsection

@section('custom_styles')
    <style>
        .badge {
            display: inline-block!important;
            min-width: 80px;
            text-align: right;
        }
    </style>
@endsection
@section('content')
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('issues.index')}}">القضايا</a></li>
                <li class="breadcrumb-item active" aria-current="page">القضايا اليسيرة</li>
            </ol>
        </nav>
    </div>

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>رقم</th>
                        <th>الدائرة</th>
                        <th>رقم القضية</th>
                        <th>تاريخ القيد الهجري</th>
                        <th>عدد الأيام منذ قيد القضية</th>
                        <th>لها موعد قادم</th>
                        <th>حالة القضية</th>
                        <th>مبلغ المطالبة</th>
                        <th>عدد الجلسات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($issues as $issue)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$issue->office}}</td>
                            <td>{{$issue->issue_number}}</td>
                            <td>{{$issue->issue_date}}</td>
                            <td>{!! $issue->age > 180 ? '<span class="badge outline-badge-danger">' . $issue->age . '</span>' : '<span class=" badge outline-badge-success">' . $issue->age . '</span>' !!}</td>
                            <td>{!! $issue->has_future_appointment > 'لا' ? '<span class="badge outline-badge-danger">' . $issue->has_future_appointment . '</span>' : '<span class=" badge outline-badge-success">' . $issue->has_future_appointment . '</span>' !!}</td>
                            <td>{{$issue->status}}</td>
                            <td>{!! $issue->money_claimed > 50000 ? '<span class="shadow-none badge badge-danger">' . number_format($issue->money_claimed, 0, '', ',') . '</span>' : '<span class="shadow-none badge badge-success">' . number_format($issue->money_claimed, 0, '', ',') . '</span>'!!}</td>
                            <td>{!! $issue->sessions > 5 ? '<span class="shadow-none badge badge-danger">' . $issue->sessions . '</span>' :   '<span class="shadow-none badge badge-success">' . $issue->sessions . '</span>'!!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('plugin_scripts')
    <script src="{{asset('src/plugins/src/table/datatable/datatables.js')}}"></script>
@endsection

@section('custom_scripts')
    <script>
        $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>' },
                "sInfo": "إظهار صفحة _PAGE_ من _PAGES_صفحات، بمجموع _TOTAL_ قضايا",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "ابحث",
                "sLengthMenu": "نتائج :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50, 100],
            "pageLength": 10
        });
    </script>
@endsection
