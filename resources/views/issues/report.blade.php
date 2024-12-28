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
        /*body.dark {*/
        /*    background: white;*/
        /*    color: black;*/
        /*}*/
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

        .table tbody tr td.td-row {
            padding: 0 10px!important;
            text-align: center;
        }
        @media print {
            .card {
                display: none;
            }
            svg {
                stroke: black;
            }
            body.dark .progress .progress-bar {
                background: black!important;
                display: block;
            }
            .progress {
                position: relative;
            }
            .progress:before {
                display: block;
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                z-index: 0;
                border-bottom: 20px solid #eeeeee;
                color: white;
            }
            .progress-bar {
                position: absolute;
                top: 0;
                bottom: 0;
                z-index: 1;
                border-bottom: 20px solid #337ab7;
                border-bottom-color: black;
                color: white;
            }
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
<div class="report-page">
    <div>
        <div class="card mb-5">
            <div class="card-body">
                <form id="formOffice" action="{{route('issues.post-report')}}" method="post">
                    @csrf
                    <div class="row">
                        <label for="office" class="col-sm-2 col-form-label" style="font-family: 'Noto Kufi Arabic', sans-serif;">اختر الدائرة</label>
                        <div class="col-sm-10">
                            <select name="office" id="office" class="form-select" aria-label="اختر الدائرة">
                                <option value="">اختر الدائرة</option>
                                @foreach($offices as $office)
                                    <option value="{{$office}}" {{$current_office == $office ? 'selected': ''}}>{{$office}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
{{--        <div class="row">--}}
{{--            <div class="layout-spacing">--}}
{{--                <div class="widget widget-three">--}}
{{--                    <div class="widget-heading">--}}
{{--                        <h5 class=""> إجماليات قيد النظر</h5>--}}
{{--                    </div>--}}
{{--                    <div class="widget-content">--}}
{{--                        <div class="order-summary">--}}
{{--                            <div class="summary-list">--}}
{{--                                <div class="w-icon">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>--}}
{{--                                </div>--}}
{{--                                <div class="w-summary-details">--}}

{{--                                    <div class="w-summary-info">--}}
{{--                                        <h6>القضايا اليسيرة</h6>--}}
{{--                                        <p class="summary-count">{{$total_warning}}</p>--}}
{{--                                    </div>--}}

{{--                                    <div class="w-summary-stats">--}}
{{--                                        <div class="progress br-30">--}}
{{--                                            <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: {{$total_warning > 0 ? ($easy_issues_count / $total_warning) * 100 : ''}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">{{$easy_issues_count}}</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}

{{--                            </div>--}}

{{--                            <div class="summary-list">--}}
{{--                                <div class="w-icon">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone-off"><path d="M10.68 13.31a16 16 0 0 0 3.41 2.6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7 2 2 0 0 1 1.72 2v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.42 19.42 0 0 1-3.33-2.67m-2.67-3.34a19.79 19.79 0 0 1-3.07-8.63A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"></path><line x1="23" y1="1" x2="1" y2="23"></line></svg>--}}
{{--                                </div>--}}
{{--                                <div class="w-summary-details">--}}
{{--                                    <div class="w-summary-info">--}}
{{--                                        <h6>ليس لها موعد</h6>--}}
{{--                                        <p class="summary-count">{{$total_warning}}</p>--}}
{{--                                    </div>--}}
{{--                                    <div class="w-summary-stats">--}}
{{--                                        <div class="progress">--}}
{{--                                            <div class="progress-bar bg-gradient-success" role="progressbar" style="width: {{$total_warning > 0 ? ($no_next_appointment_count / $total_warning) * 100 : ''}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">{{$no_next_appointment_count}}</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}

{{--                            </div>--}}

{{--                            <div class="summary-list">--}}
{{--                                <div class="w-icon">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>--}}
{{--                                </div>--}}
{{--                                <div class="w-summary-details">--}}

{{--                                    <div class="w-summary-info">--}}
{{--                                        <h6>القضيايا أكثر من ٥ جلسات</h6>--}}
{{--                                        <p class="summary-count">{{$total_warning}}</p>--}}
{{--                                    </div>--}}

{{--                                    <div class="w-summary-stats">--}}
{{--                                        <div class="progress">--}}
{{--                                            <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: {{$total_warning > 0 ? ($five_sessions_count / $total_warning) * 100 : ''}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">{{$five_sessions_count}}</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="summary-list">--}}
{{--                                <div class="w-icon">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>--}}
{{--                                </div>--}}
{{--                                <div class="w-summary-details">--}}

{{--                                    <div class="w-summary-info">--}}
{{--                                        <h6>القضيايا أكثر من ١٨٠ يوما</h6>--}}
{{--                                        <p class="summary-count">{{$total_warning}}</p>--}}
{{--                                    </div>--}}

{{--                                    <div class="w-summary-stats">--}}
{{--                                        <div class="progress">--}}
{{--                                            <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: {{$total_warning > 0 ? ($old_issues_count / $total_warning) * 100 : ''}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">{{$old_issues_count}}</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="summary-list">--}}
{{--                                <div class="w-icon">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>--}}
{{--                                </div>--}}
{{--                                <div class="w-summary-details">--}}

{{--                                    <div class="w-summary-info">--}}
{{--                                        <h6>القضايا  اليسيرة  غير المتعثرة</h6>--}}
{{--                                        <p class="summary-count">{{$total_warning}}</p>--}}
{{--                                    </div>--}}

{{--                                    <div class="w-summary-stats">--}}
{{--                                        <div class="progress">--}}
{{--                                            <div class="progress-bar bg-gradient-success" role="progressbar" style="width: {{$total_warning > 0 ? ($easy_issues_not_late_count / $total_warning) * 100: ''}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">{{$easy_issues_not_late_count}}</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="summary-list">--}}
{{--                                <div class="w-icon">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>--}}
{{--                                </div>--}}
{{--                                <div class="w-summary-details">--}}

{{--                                    <div class="w-summary-info">--}}
{{--                                        <h6>القضايا  اليسيرة المتعثرة</h6>--}}
{{--                                        <p class="summary-count">{{$total_warning}}</p>--}}
{{--                                    </div>--}}

{{--                                    <div class="w-summary-stats">--}}
{{--                                        <div class="progress">--}}
{{--                                            <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: {{$total_warning > 0 ? ($easy_issues_late_count / $total_warning) * 100 : ''}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">{{$easy_issues_late_count}}</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}


        <table class="table table-bordered">
            <tbody>
            <tr>
                <td colspan="3" style="text-align: left; font-family: 'Noto Kufi Arabic', sans-serif;color:white; background-color: darkgreen">الدائرة القضائية:</td>
                <td colspan="3" style="font-family: 'Noto Kufi Arabic', sans-serif;">{{$current_office == 'بدون' ? '---' : $current_office}}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: left; font-family: 'Noto Kufi Arabic', sans-serif;color:white; background-color: darkgreen">قاضي الدائرة</td>
                <td colspan="3" style="font-family: 'Noto Kufi Arabic', sans-serif;"></td>
            </tr>
            <tr class="text-center" style="background: #F3A523; color: white">
                <td colspan="2">إجمالي قيد النظر</td>
                <td>القضايا اليسيرة</td>
                <td>ليس لها موعد قادم</td>
                <td>أكثر من ٥ جلسات</td>
                <td>تجاوزت ١٨٠ يوما</td>
            </tr>
            <tr class="text-center" style="font-size: 2.5em;font-weight: bold;color: white">
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
                @foreach($issues as $issue)
                    <tr>
                        <td class="td-row">{{$loop->iteration}}</td>
                        <td class="td-row">{{$issue->issue_number}}</td>
                        {!!Helper::render_easy_status($issue)  !!}
                        {!! Helper::render_appointment($issue->has_future_appointment) !!}
                        {!! Helper::render_session($issue->sessions) !!}
                        {!! Helper::render_age($issue->age) !!}
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <br/>
        <br>
        <br>

{{--        <div style="margin-top: 25px; padding: 10px; border-radius: 10px; border: #191E3A solid 1px;">--}}
{{--            <ul>--}}
{{--                <li> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#37AB55" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>  قضية يسيرة غير متعثرة</li>--}}
{{--                <li> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#E7515A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg> قضية يسيرة متعثرة</li>--}}
{{--                <li> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#E3A140" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg> قضية غير يسيرة</li>--}}
{{--            </ul>--}}
{{--        </div>--}}
    </div>
</div>
@endsection

@section('plugin_scripts')
    <script src="{{asset('src/plugins/src/apex/apexcharts.min.js')}}"></script>
@endsection

@section('custom_scripts')
    <script>
        const formOffice = document.getElementById('formOffice');
        const selectOffice = document.getElementById('office');
        selectOffice.addEventListener('change', function (evt) {
            formOffice.submit();
        });
    </script>
@endsection

