@php use App\Classes\Helper;use App\Enums\Category; @endphp
@extends('layouts.app')
@section('plugin_styles')
    <link href="{{asset('src/plugins/src/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('src/assets/css/light/components/list-group.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('src/assets/css/light/dashboard/dash_2.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{asset('src/assets/css/dark/components/list-group.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('src/assets/css/dark/dashboard/dash_2.css')}}" rel="stylesheet" type="text/css"/>
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
            height: 20px !important;
            position: relative;
        }

        @media print {
            .card {
                display: none;
            }

            svg {
                stroke: black;
            }

            body.dark .progress .progress-bar {
                background: black !important;
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
    <div class="row layout-top-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>توليد ملف أكسل</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form class="row g-3 align-items-center" method="post" action="{{route('reports.query')}}">
                    @csrf
                    <div class="col-md-5">
                        <div class="form-group mb-4">
                            <label for="office">اسم الدائرة</label>
                            <select class="form-select" name="office" id="office">
                                <option value="">اختر اسم الدائرة</option>
                                @foreach($offices as $office)
                                    <option value="{{$office}}">{{$office}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group mb-4">
                            <label for="category">تصنيف القضية</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">اختر تصنيف القضية</option>
                                @foreach($categories as $category)
                                    <option value="{{$category}}">{{$category}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 pt-2">
                        <button type="submit" class="mt-4 mb-4 btn btn-primary btn-lg">توليد ملف أكسل</button>
                    </div>
                </form>
            </div>
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

