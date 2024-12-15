@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('content')
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('issues.bulk-reports')}}">تقرير</a></li>
                <li class="breadcrumb-item active" aria-current="page">تقارير آلية</li>
            </ol>
        </nav>
    </div>
    <div class="row layout-top-spacing">
        <div id="buttonsSolid" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area text-center split-buttons">
                    <h4 class="mb-4" style="font-family: 'Noto Kufi Arabic', sans-serif;">اختر أزرار أسماء الدوائر القضاية لاستخراج التقرير الآلي</h4>
                    @if(count($offices) === 0)
                        <div class="row">
                            <div class="d-grid gap-2">
                                <a href="{{route('issues.import')}}" class="btn btn-danger mb-2 me-4">لا توجد ملفات الرجاء النقر على قائمة استيراد ملف أكسل في القائمة الدانبية</a>
                            </div>
                        </div>
                    @else
                        @if(count($files) === 0)
                            <div class="row">
                                <div class="d-flex">
                                    <button id="btn-generate-pdf" onclick="generatePDF()" class="btn btn-danger btn-lg mb-2">
                                        <span id="generate-pdf-loader" class="d-none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin me-2"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg></span>
                                        توليد ملفات بي دي أف لجميع الدوائر القضائية
                                    </button>
                                </div>
                            </div>
                        @else

                            <div class="row">
                                @foreach($files as $file)
                                    <div class="col-md-4 col-lg-6 col-xl-3">
                                        <a href="{{asset('storage') . '/' .$file}}" class="btn btn-success mb-2 me-4" style="width: 100%" download>{{substr(Str::title(str_replace('-', ' ', $file)), 0, strlen($file) - 4)}}</a>
                                    </div>
                                @endforeach
                            </div>
                            <button id="btn-regenerate-pdf" onclick="regeneratePDF()" class="btn btn-danger btn-lg mb-2" style="margin-top: 20px">
                                <span id="regenerate-pdf-loader" class="d-none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin me-2"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg></span>
                                إعادة توليد ملفات بي دي أف لجميع الدوائر القضائية
                            </button>
                        @endif
                    @endif


                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_scripts')
    <script>
        async function generatePDF() {
            const loader = document.getElementById('generate-pdf-loader');
            const button = document.getElementById('btn-generate-pdf');

            const csrf_string = "<?php echo csrf_token() ?>";
            const url = "<?php echo(url('api/generate-pdf')) ?>"
            try {
                loader.classList.remove('d-none');
                button.classList.add('disabled');
                const response = await fetch(url, {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": "<?php echo csrf_token() ?>"
                    },
                    method: "POST",
                    credentials: "same-origin",
                });
                if (!response.ok) {
                    throw new Error(`Response Status: ${response.status}`)
                }
                const data = await response.json();
                location.reload();
            } catch (error) {
                console.log(error.message)
            } finally {
                loader.classList.add('d-none');
                button.classList.remove('disabled');
            }
        }

        async function regeneratePDF() {
            const loader = document.getElementById('regenerate-pdf-loader');
            const button = document.getElementById('btn-regenerate-pdf');

            {{--const csrf_string = "<?php echo csrf_token() ?>";--}}
            const url = "<?php echo(url('api/generate-pdf')) ?>"
            try {
                loader.classList.remove('d-none');
                button.classList.add('disabled');
                const response = await fetch(url, {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": "<?php echo csrf_token() ?>"
                    },
                    method: "POST",
                    credentials: "same-origin",
                });
                if (!response.ok) {
                    throw new Error(`Response Status: ${response.status}`)
                }
                const data = await response.json();
                location.reload();
            } catch (error) {
                console.log(error.message)
            } finally {
                loader.classList.add('d-none');
                button.classList.remove('disabled');
            }
        }
    </script>
@endsection
