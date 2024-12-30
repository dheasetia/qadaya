@php use App\Classes\Helper; @endphp
@extends('layouts.app')
@section('plugin_styles')
    <link href="{{asset('src/plugins/src/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('src/assets/css/light/components/list-group.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('src/assets/css/light/dashboard/dash_2.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('src/assets/css/dark/components/list-group.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('src/assets/css/dark/dashboard/dash_2.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('custom_styles')
    <style>
        body.dark {
            background: white;
        }
        body.dark:before {
            background: white;
        }
        .main-content {
            background: white!important;
        }
        .widget {
            background: white;
        }
        .report-page {
            max-width: 800px;
            justify-content: center;
            align-items: center;
            margin-right: auto;
            margin-left: auto;
        }
        span.badge {
            min-width: 80px;
        }
        .progress {
            height: 20px!important;
            position: relative;
        }

        .header-container {
            display: none!important;
        }
        td {
            padding: 5px!important;
        }
        td.cell-abu {
            background: #c3c3c3;
            color: #424242;
        }
        td.cell-danger {
            background: #fa7070;
            color: #832222;
        }
        td.cell-success {
            background: #98f18c;
            color: #257723;
        }
        td.cell-warning {
            background: #ecb164;
            color: #956239;
        }
        table {
            border: black solid 1px!important;
            border-radius: 0 0 12px 12px;
        }

    </style>
@endsection

@section('content')
    <div class="report-page">
        <div>
            <div class="row" style="margin-bottom: 20px; background-color: white; height: 90px; border-radius: 10px">
                <div class="col-3">
                    <img src="{{asset('src/assets/img/majlis-ala.png')}}" alt="logo" style="height: 70px; margin-top:10px;">
                </div>
                <div class="col-6 text-right">
                    <h4 style="font-family: 'Noto Kufi Arabic', serif;color: #79797A; align-items: center; justify-content: center; margin-top: 30px;">المحكمة العامة بالدمام</h4>
                </div>
                <div class="col-3" style="margin-right: -70px">
                    <img src="{{asset('src/assets/img/moj-2030.png')}}" alt="logo" style="height: 70px;margin-top:10px;">
                </div>
            </div>

            {{--            <div class="row">--}}
            {{--                <div class="layout-spacing">--}}
            {{--                    <div class="widget widget-three">--}}
            {{--                        <div class="widget-heading">--}}
            {{--                            <h5 class=""> إجماليات قيد النظر</h5>--}}
            {{--                        </div>--}}
            {{--                        <div class="widget-content">--}}
            {{--                            <div class="order-summary">--}}
            {{--                                <div class="summary-list">--}}
            {{--                                    <div class="w-icon">--}}
            {{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>--}}
            {{--                                    </div>--}}
            {{--                                    <div class="w-summary-details">--}}

            {{--                                        <div class="w-summary-info">--}}
            {{--                                            <h6>القضايا اليسيرة</h6>--}}
            {{--                                            <p class="summary-count">{{$total_warning}}</p>--}}
            {{--                                        </div>--}}

            {{--                                        <div class="w-summary-stats">--}}
            {{--                                            <div class="progress br-30">--}}
            {{--                                                <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: {{$total_warning > 0 ? ($easy_issues_count / $total_warning) * 100 : ''}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">{{$easy_issues_count}}</div>--}}
            {{--                                            </div>--}}
            {{--                                        </div>--}}

            {{--                                    </div>--}}

            {{--                                </div>--}}

            {{--                                <div class="summary-list">--}}
            {{--                                    <div class="w-icon">--}}
            {{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone-off"><path d="M10.68 13.31a16 16 0 0 0 3.41 2.6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7 2 2 0 0 1 1.72 2v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.42 19.42 0 0 1-3.33-2.67m-2.67-3.34a19.79 19.79 0 0 1-3.07-8.63A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"></path><line x1="23" y1="1" x2="1" y2="23"></line></svg>--}}
            {{--                                    </div>--}}
            {{--                                    <div class="w-summary-details">--}}
            {{--                                        <div class="w-summary-info">--}}
            {{--                                            <h6>ليس لها موعد</h6>--}}
            {{--                                            <p class="summary-count">{{$total_warning}}</p>--}}
            {{--                                        </div>--}}
            {{--                                        <div class="w-summary-stats">--}}
            {{--                                            <div class="progress">--}}
            {{--                                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: {{$total_warning > 0 ? ($no_next_appointment_count / $total_warning) * 100 : ''}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">{{$no_next_appointment_count}}</div>--}}
            {{--                                            </div>--}}
            {{--                                        </div>--}}

            {{--                                    </div>--}}

            {{--                                </div>--}}

            {{--                                <div class="summary-list">--}}
            {{--                                    <div class="w-icon">--}}
            {{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>--}}
            {{--                                    </div>--}}
            {{--                                    <div class="w-summary-details">--}}

            {{--                                        <div class="w-summary-info">--}}
            {{--                                            <h6>القضيايا أكثر من ٥ جلسات</h6>--}}
            {{--                                            <p class="summary-count">{{$total_warning}}</p>--}}
            {{--                                        </div>--}}

            {{--                                        <div class="w-summary-stats">--}}
            {{--                                            <div class="progress">--}}
            {{--                                                <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: {{$total_warning > 0 ? ($five_sessions_count / $total_warning) * 100 : ''}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">{{$five_sessions_count}}</div>--}}
            {{--                                            </div>--}}
            {{--                                        </div>--}}

            {{--                                    </div>--}}
            {{--                                </div>--}}

            {{--                                <div class="summary-list">--}}
            {{--                                    <div class="w-icon">--}}
            {{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>--}}
            {{--                                    </div>--}}
            {{--                                    <div class="w-summary-details">--}}

            {{--                                        <div class="w-summary-info">--}}
            {{--                                            <h6>القضيايا أكثر من ١٨٠ يوما</h6>--}}
            {{--                                            <p class="summary-count">{{$total_warning}}</p>--}}
            {{--                                        </div>--}}

            {{--                                        <div class="w-summary-stats">--}}
            {{--                                            <div class="progress">--}}
            {{--                                                <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: {{$total_warning > 0 ? ($old_issues_count / $total_warning) * 100 : ''}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">{{$old_issues_count}}</div>--}}
            {{--                                            </div>--}}
            {{--                                        </div>--}}

            {{--                                    </div>--}}
            {{--                                </div>--}}

            {{--                                <div class="summary-list">--}}
            {{--                                    <div class="w-icon">--}}
            {{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>--}}
            {{--                                    </div>--}}
            {{--                                    <div class="w-summary-details">--}}

            {{--                                        <div class="w-summary-info">--}}
            {{--                                            <h6>القضايا  اليسيرة  غير المتعثرة</h6>--}}
            {{--                                            <p class="summary-count">{{$total_warning}}</p>--}}
            {{--                                        </div>--}}

            {{--                                        <div class="w-summary-stats">--}}
            {{--                                            <div class="progress">--}}
            {{--                                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: {{$total_warning > 0 ? ($easy_issues_not_late_count / $total_warning) * 100: ''}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">{{$easy_issues_not_late_count}}</div>--}}
            {{--                                            </div>--}}
            {{--                                        </div>--}}

            {{--                                    </div>--}}
            {{--                                </div>--}}

            {{--                                <div class="summary-list">--}}
            {{--                                    <div class="w-icon">--}}
            {{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>--}}
            {{--                                    </div>--}}
            {{--                                    <div class="w-summary-details">--}}

            {{--                                        <div class="w-summary-info">--}}
            {{--                                            <h6>القضايا  اليسيرة المتعثرة</h6>--}}
            {{--                                            <p class="summary-count">{{$total_warning}}</p>--}}
            {{--                                        </div>--}}

            {{--                                        <div class="w-summary-stats">--}}
            {{--                                            <div class="progress">--}}
            {{--                                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: {{$total_warning > 0 ? ($easy_issues_late_count / $total_warning) * 100 : ''}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">{{$easy_issues_late_count}}</div>--}}
            {{--                                            </div>--}}
            {{--                                        </div>--}}

            {{--                                    </div>--}}
            {{--                                </div>--}}

            {{--                            </div>--}}

            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}

            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td colspan="3" style="text-align: left; font-family: 'Noto Kufi Arabic', sans-serif;color:white; background-color: darkgreen">الدائرة القضائية:</td>
                    <td colspan="3" style="font-family: 'Noto Kufi Arabic', sans-serif;">{{$current_office == 'بدون' ? '---' : $current_office}}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: left; font-family: 'Noto Kufi Arabic', sans-serif;color:white; background-color: darkgreen">قاضي الدائرة:</td>
                    <td colspan="3" style="font-family: 'Noto Kufi Arabic', sans-serif;"></td>
                </tr>
                <tr class="text-center" style="background: #F3A523; color: white">
                    <td colspan="2">إجمالي قيد النظر</td>
                    <td>القضايا اليسيرة</td>
                    <td>ليس لها موعد قادم</td>
                    <td>أكثر من ٥ جلسات</td>
                    <td>تجاوزت ١٨٠ يوما</td>
                </tr>
                <tr class="text-center" style="font-size: 2.5em;font-weight: bold">
                    <td colspan="2">{{$total_warning}}</td>
                    <td>{{$easy_issues_count}}</td>
                    <td>{{$no_next_appointment_count}}</td>
                    <td>{{$five_sessions_count}}</td>
                    <td>{{$old_issues_count}}</td>
                </tr>

                <tr class="text-center" style="font-weight: bold; background-color: darkgreen; color: white; font-family: 'Noto Kufi Arabic', sans-serif";>
                    <td style="width: 10px">رقم</td>
                    <td>رقم القضية</td>
                    <td>
                        <p>مبلغ المطالبة</p>
                    </td>
                    <td>لها موعد قادم</td>
                    <td>عدد الجلسات</td>
                    <td>الأيام منذ القيد</td>
                </tr>
                @if($issues == null)
                    <tr class="text-center">
                        <td colspan="6">لا توجد بيانات، الرجاء اختر اسم الدائرة</td>
                    </tr>
                @else
                    @for ($i = 1 ; $i <= 17 ; $i++)
                        @if ($issues->count() >= $i)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$issues[$i-1]->issue_number}}</td>
                                {!! Helper::render_easy_status($issues[$i-1]) !!}
                                {!! Helper::render_appointment($issues[$i-1]->has_future_appointment) !!}
                                {!! Helper::render_session($issues[$i-1]->sessions) !!}
                                {!! Helper::render_age($issues[$i-1]->age) !!}
                            </tr>
                        @endif
                    @endfor
                    {{--                @foreach($issues as $issue)--}}
                    {{--                    <tr>--}}
                    {{--                        <td class="td-row">{{$loop->iteration}}</td>--}}
                    {{--                        <td class="td-row">{{$issue->issue_number}}</td>--}}
                    {{--                        <td class="td-row">{!!Helper::render_easy_status($issue)  !!}</td>--}}
                    {{--                        <td class="td-row">{!! Helper::render_appointment($issue->has_future_appointment) !!}</td>--}}
                    {{--                        <td class="td-row">{!! Helper::render_session($issue->sessions) !!}</td>--}}
                    {{--                        <td class="td-row">{!! Helper::render_age($issue->age) !!}</td>--}}
                    {{--                    </tr>--}}
                    {{--                @endforeach--}}
                @endif
                </tbody>
            </table>

            @if ($issues != null)
                @if($issues->count() > 17)
                    <br/>
                    <br>
                    <br>
                    <table class="table table-bordered">
                        <tbody>
                        <tr class="text-center" style="font-weight: bold; background-color: darkgreen; color: white; font-family: 'Noto Kufi Arabic', sans-serif";>
                            <td style="width: 10px">رقم</td>
                            <td>رقم القضية</td>
                            <td>
                                <p>مبلغ المطالبة</p>
                            </td>
                            <td>لها موعد قادم</td>
                            <td>عدد الجلسات</td>
                            <td>الأيام منذ القيد</td>
                        </tr>
                        @if ($issues->count() >= 41)
                            @if ($issues->count() >= $i)
                                @for ($i = 18 ; $i <= 41 ; $i++)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$issues[$i-1]->issue_number}}</td>
                                        {!! Helper::render_easy_status($issues[$i-1]) !!}
                                        {!! Helper::render_appointment($issues[$i-1]->has_future_appointment) !!}
                                        {!! Helper::render_session($issues[$i-1]->sessions) !!}
                                        {!! Helper::render_age($issues[$i-1]->age) !!}
                                    </tr>
                                @endfor
                            @endif

                        @else
                            @for ($i = 18 ; $i <= $issues->count() ; $i++)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$issues[$i-1]->issue_number}}</td>
                                    {!! Helper::render_easy_status($issues[$i-1]) !!}
                                    {!! Helper::render_appointment($issues[$i-1]->has_future_appointment) !!}
                                    {!! Helper::render_session($issues[$i-1]->sessions) !!}
                                    {!! Helper::render_age($issues[$i-1]->age) !!}
                                </tr>
                            @endfor
                        @endif
                        </tbody>
                    </table>
                @endif


                @if($issues->count() > 41)
                    <br>
                    <br>
                    <br>
                    <br>
                    <table class="table table-bordered" style="margin-top: 20px">
                        <tbody>
                        <tr class="text-center" style="font-weight: bold; background-color: darkgreen; color: white; font-family: 'Noto Kufi Arabic', sans-serif";>
                            <td style="width: 10px">رقم</td>
                            <td>رقم القضية</td>
                            <td>
                                <p>مبلغ المطالبة</p>
                            </td>
                            <td>لها موعد قادم</td>
                            <td>عدد الجلسات</td>
                            <td>الأيام منذ القيد</td>
                        </tr>
                        @if ($issues->count() > 67)
                            @if ($issues->count() >= $i)
                                @for ($i = 42 ; $i <= 67 ; $i++)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$issues[$i-1]->issue_number}}</td>
                                        {!! Helper::render_easy_status($issues[$i-1]) !!}
                                        {!! Helper::render_appointment($issues[$i-1]->has_future_appointment) !!}
                                        {!! Helper::render_session($issues[$i-1]->sessions) !!}
                                        {!! Helper::render_age($issues[$i-1]->age) !!}
                                    </tr>
                                @endfor
                            @endif
                        @else
                            @for ($i = 42 ; $i <= $issues->count() ; $i++)
                                @if ($issues->count() >= $i)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$issues[$i-1]->issue_number}}</td>
                                        {!! Helper::render_easy_status($issues[$i-1]) !!}
                                        {!! Helper::render_appointment($issues[$i-1]->has_future_appointment) !!}
                                        {!! Helper::render_session($issues[$i-1]->sessions) !!}
                                        {!! Helper::render_age($issues[$i-1]->age) !!}
                                    </tr>
                                @endif
                            @endfor
                        @endif
                        </tbody>
                    </table>
                @endif


                @if($issues->count() > 67)
                    <br>
                    <br>
                    <br>
                    <table class="table table-bordered" style="margin-top: 20px">
                        <tbody>
                        <tr class="text-center" style="font-weight: bold; background-color: darkgreen; color: white; font-family: 'Noto Kufi Arabic', sans-serif";>
                            <td style="width: 10px">رقم</td>
                            <td>رقم القضية</td>
                            <td>
                                <p>مبلغ المطالبة</p>
                            </td>
                            <td>لها موعد قادم</td>
                            <td>عدد الجلسات</td>
                            <td>الأيام منذ القيد</td>
                        </tr>
                        @if ($issues->count() > 93)
                            @if ($issues->count() >= $i)
                                @for ($i = 68 ; $i <= 91 ; $i++)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$issues[$i-1]->issue_number}}</td>
                                        {!! Helper::render_easy_status($issues[$i-1]) !!}
                                        {!! Helper::render_appointment($issues[$i-1]->has_future_appointment) !!}
                                        {!! Helper::render_session($issues[$i-1]->sessions) !!}
                                        {!! Helper::render_age($issues[$i-1]->age) !!}
                                    </tr>
                                @endfor
                            @endif
                        @else
                            @for ($i = 68 ; $i <= $issues->count() ; $i++)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$issues[$i-1]->issue_number}}</td>
                                    {!! Helper::render_easy_status($issues[$i-1]) !!}
                                    {!! Helper::render_appointment($issues[$i-1]->has_future_appointment) !!}
                                    {!! Helper::render_session($issues[$i-1]->sessions) !!}
                                    {!! Helper::render_age($issues[$i-1]->age) !!}
                                </tr>
                            @endfor
                        @endif
                        </tbody>
                    </table>
                @endif


                @if($issues->count() > 91)
                    <br>
                    <br>
                    <br>
                    <br>
                    <table class="table table-bordered" style="margin-top: 20px">
                        <tbody>
                        <tr class="text-center" style="font-weight: bold; background-color: darkgreen; color: white; font-family: 'Noto Kufi Arabic', sans-serif";>
                            <td style="width: 10px">رقم</td>
                            <td>رقم القضية</td>
                            <td>
                                <p>مبلغ المطالبة</p>
                            </td>
                            <td>لها موعد قادم</td>
                            <td>عدد الجلسات</td>
                            <td>الأيام منذ القيد</td>
                        </tr>
                        @if ($issues->count() > 113)
                            @if ($issues->count() >= $i)
                                @for ($i = 92 ; $i <= 113 ; $i++)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$issues[$i-1]->issue_number}}</td>
                                        {!! Helper::render_easy_status($issues[$i-1]) !!}
                                        {!! Helper::render_appointment($issues[$i-1]->has_future_appointment) !!}
                                        {!! Helper::render_session($issues[$i-1]->sessions) !!}
                                        {!! Helper::render_age($issues[$i-1]->age) !!}
                                    </tr>
                                @endfor
                            @endif
                        @else
                            @for ($i = 92 ; $i <= $issues->count() ; $i++)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$issues[$i-1]->issue_number}}</td>
                                    {!! Helper::render_easy_status($issues[$i-1]) !!}
                                    {!! Helper::render_appointment($issues[$i-1]->has_future_appointment) !!}
                                    {!! Helper::render_session($issues[$i-1]->sessions) !!}
                                    {!! Helper::render_age($issues[$i-1]->age) !!}
                                </tr>
                            @endfor
                        @endif
                        </tbody>
                    </table>
                @endif



                @if($issues->count() > 113)
                    <br>
                    <br>
                    <br>
                    <br>
                    <table class="table table-bordered" style="margin-top: 20px">
                        <tbody>
                        <tr class="text-center" style="font-weight: bold; background-color: darkgreen; color: white; font-family: 'Noto Kufi Arabic', sans-serif";>
                            <td style="width: 10px">رقم</td>
                            <td>رقم القضية</td>
                            <td>
                                <p>مبلغ المطالبة</p>
                            </td>
                            <td>لها موعد قادم</td>
                            <td>عدد الجلسات</td>
                            <td>الأيام منذ القيد</td>
                        </tr>
                        @if ($issues->count() > 127)
                            @if ($issues->count() >= $i)
                                @for ($i = 114 ; $i <= 127 ; $i++)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$issues[$i-1]->issue_number}}</td>
                                        {!! Helper::render_easy_status($issues[$i-1]) !!}
                                        {!! Helper::render_appointment($issues[$i-1]->has_future_appointment) !!}
                                        {!! Helper::render_session($issues[$i-1]->sessions) !!}
                                        {!! Helper::render_age($issues[$i-1]->age) !!}
                                    </tr>
                                @endfor
                            @endif
                        @else
                            @for ($i = 114 ; $i <= $issues->count() ; $i++)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$issues[$i-1]->issue_number}}</td>
                                    {!! Helper::render_easy_status($issues[$i-1]) !!}
                                    {!! Helper::render_appointment($issues[$i-1]->has_future_appointment) !!}
                                    {!! Helper::render_session($issues[$i-1]->sessions) !!}
                                    {!! Helper::render_age($issues[$i-1]->age) !!}
                                </tr>
                            @endfor
                        @endif
                        </tbody>
                    </table>
                @endif



                @if($issues->count() > 127)
                    <br>
                    <br>
                    <br>
                    <br>
                    <table class="table table-bordered" style="margin-top: 10px">
                        <tbody>
                        <tr class="text-center" style="font-weight: bold; background-color: darkgreen; color: white; font-family: 'Noto Kufi Arabic', sans-serif";>
                            <td style="width: 10px">رقم</td>
                            <td>رقم القضية</td>
                            <td>
                                <p>مبلغ المطالبة</p>
                            </td>
                            <td>لها موعد قادم</td>
                            <td>عدد الجلسات</td>
                            <td>الأيام منذ القيد</td>
                        </tr>
                        @if ($issues->count() > 149)
                            @if ($issues->count() >= $i)
                                @for ($i = 128 ; $i <= 149 ; $i++)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$issues[$i-1]->issue_number}}</td>
                                        {!! Helper::render_easy_status($issues[$i-1]) !!}
                                        {!! Helper::render_appointment($issues[$i-1]->has_future_appointment) !!}
                                        {!! Helper::render_session($issues[$i-1]->sessions) !!}
                                        {!! Helper::render_age($issues[$i-1]->age) !!}
                                    </tr>
                                @endfor
                            @endif
                        @else
                            @for ($i = 128 ; $i <= $issues->count() ; $i++)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$issues[$i-1]->issue_number}}</td>
                                    {!! Helper::render_easy_status($issues[$i-1]) !!}
                                    {!! Helper::render_appointment($issues[$i-1]->has_future_appointment) !!}
                                    {!! Helper::render_session($issues[$i-1]->sessions) !!}
                                    {!! Helper::render_age($issues[$i-1]->age) !!}
                                </tr>
                            @endfor
                        @endif
                        </tbody>
                    </table>
                @endif
            @endif

            <table class="table table-bordered" style="margin-top: 20px;">
                <tbody>
                <tr>
                    <td rowspan="3" colspan="2" style="width: 167px">إجمالي عدد القضايا <span>: {{$issues->count()}}</span></td>
                    <td class="cell-success"> اليسيرة غير المتعثرة <span>: {{$easy_issues_not_late_count}}</span></td>
                    <td class="cell-success"> لها موعد قادم <span>: {{$has_next_appointment_count}}</span></td>
                    <td class="cell-success"> أقل من أربع جلسات <span>: {{$less_than_four_sessions_count}}</span></td>
                    <td class="cell-success"> عمرها ١٥٠ يوما فأقل <span>: {{$age_less_than_150_days}}</span> <span style="float: left;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#257723" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg></span></td>
                </tr>
                <tr>
                    <td class="cell-danger"> اليسيرة المتعثرة <span>: {{$easy_issues_late_count}}</span></td>
                    <td class="cell-danger"> ليس لها موعد قادم <span>: {{$no_next_appointment_count}}</span></td>
                    <td class="cell-warning"> أربع جلسات <span>: {{$four_session_count}}</span></td>
                    <td class="cell-warning"> عمرها بين ١٥١ إلى ١٧٩ يوما <span>: {{$age_between_151_to_179_days}}</span> <span style="float: left;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#956239" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg></span></td>
                </tr>
                <tr>
                    <td class="cell-abu"> غير اليسيرة <span>: {{$not_easy_count}}</span></td>
                    <td></td>
                    <td class="cell-danger"> خمس جلسات فأكثر <span>: {{$five_sessions_and_more_count}}</span></td>
                    <td class="cell-danger"> عمرها ١٨٠ يوما فأكثر <span>: {{$old_issues_count}}</span> <span style="float: left"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#832222" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg></span></td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
@endsection

