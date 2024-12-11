@extends('layouts.app')

@section('custom_styles')
    <link rel="stylesheet" type="text/css" href="{{asset('src/assets/css/light/elements/alert.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('src/assets/css/dark/elements/alert.css')}}">
@endsection
@section('content')
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('issues.index')}}">القضايا</a></li>
                <li class="breadcrumb-item active" aria-current="page">استيراد ملف أكسل</li>
            </ol>
        </nav>
    </div>

    <div class="row layout-top-spacing">
        <div class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <h5 class="mb-4">اختر الملف أكسل من جهازك بعد تهذيبه حسب متطلبات البرنامج، ثم انقر على رز "رفع"</h5>
                    <div class="alert alert-light-danger alert-dismissible fade show border-0 mb-4" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                        <h5 style="color: #E7515A">تنبيه! هذه العملية تحذف البيانات القديمة!</h5>
                    </div>

                    <form action="{{route('issues.importStore')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-4 mt-3">
                            <input type="file" class="form-control-file" name="excel_file" id="exampleFormControlFile1">
                        </div>
                        <button type="submit" name="time" class="mt-4 mb-4 btn btn-primary" style="display: inline-block; min-width: 100px;">  رفع </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
