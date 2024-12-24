@php use App\Classes\Helper;use App\Enums\Category; @endphp
@extends('layouts.app')
@section('plugin_styles')

@endsection
@section('custom_styles')
    <style>
        .widget {
            border: none!important;
            background: none!important;
        }
        .widget-header {
            padding-top: 30px!important;
            padding-right: 20px!important;
        }
        .widget-header h4{
            font-family: "Noto Kufi Arabic", sans-serif;
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
                <form class="row g-3 align-items-center" method="post" action="{{route('reports.query')}}" id="form-report">
                    @csrf
                    <div class="col-md-5">
                        <div class="form-group mb-4">
                            <label for="office">اسم الدائرة</label>
                            <select class="form-select" name="office" id="office">
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
                                @foreach($categories as $category)
                                    <option value="{{$category}}">{{$category}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 pt-2">
                        <button type="submit" id="submit-button" class="mt-4 mb-4 btn btn-primary btn-lg">
                            <span id="regenerate-excel-loader" class="d-none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin me-2"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg></span>
                            توليد ملف أكسل
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('plugin_scripts')

@endsection

{{--@section('custom_scripts')--}}
{{--    <script>--}}
{{--        function serialize (data) {--}}
{{--            let obj = {};--}}
{{--            for (let [key, value] of data) {--}}
{{--                if (obj[key] !== undefined) {--}}
{{--                    if (!Array.isArray(obj[key])) {--}}
{{--                        obj[key] = [obj[key]];--}}
{{--                    }--}}
{{--                    obj[key].push(value);--}}
{{--                } else {--}}
{{--                    obj[key] = value;--}}
{{--                }--}}
{{--            }--}}
{{--            return obj;--}}
{{--        }--}}

{{--        const formReport = document.getElementById('form-report');--}}

{{--        formReport.addEventListener('submit', async function(e) {--}}
{{--            e.preventDefault();--}}
{{--            const loader = document.getElementById('regenerate-excel-loader');--}}
{{--            const button = document.getElementById('submit-button');--}}
{{--            const data = new FormData(formReport);--}}
{{--            const payload = serialize(data);--}}
{{--            const url = "{{route('api.generate-excel')}}";--}}
{{--            try {--}}
{{--                loader.classList.remove('d-none');--}}
{{--                button.classList.add('disabled');--}}
{{--                const response = await fetch(url, {--}}
{{--                    headers: {--}}
{{--                        "Content-Type": "application/json",--}}
{{--                        "Accept": "application/json",--}}
{{--                        "X-Requested-With": "XMLHttpRequest",--}}
{{--                        "X-CSRF-Token": "{{csrf_token()}}"--}}
{{--                    },--}}
{{--                    body: JSON.stringify(payload),--}}
{{--                    method: "POST",--}}
{{--                    credentials: "same-origin"--}}
{{--                });--}}
{{--                if (!response.ok) {--}}
{{--                    throw new Error(`Response Status: ${response.status}`);--}}
{{--                }--}}
{{--                const data = await response.json();--}}
{{--                console.log(data);--}}
{{--            } catch (error) {--}}
{{--                console.log(error.message)--}}
{{--            } finally {--}}
{{--                loader.classList.add('d-none');--}}
{{--                button.classList.remove('disabled');--}}
{{--            }--}}
{{--        })--}}

{{--    </script>--}}
{{--@endsection--}}

