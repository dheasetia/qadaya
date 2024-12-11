@extends('layouts.app')

@section('plugin_styles')
    <link rel="stylesheet" type="text/css" href="{{asset('src/assets/css/light/elements/alert.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('src/assets/css/dark/elements/alert.css')}}">
    <!--  END CUSTOM STYLE FILE  -->
@endsection
@section('content')
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('issues.index')}}">ملف أكسل</a></li>
                <li class="breadcrumb-item active" aria-current="page">تأكيد تفريغ بيانات</li>
            </ol>
        </nav>
    </div>
    <div class="row layout-top-spacing">
        <div id="alertOutline" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>تفريغ بيانات</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="alert alert-outline-danger alert-dismissible fade show mb-4" role="alert"><strong>تنبيه !!</strong>
                        أنت متأكد من تفريغ جميع البيانات؟ لن يكون هناك بيانات بعذ عملية الحذف
                    </div>

                    <form action="{{route('issues.post-drop-data')}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger inline-block float-end">نعم</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
