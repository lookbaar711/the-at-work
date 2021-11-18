@extends('frontend/default')

<?php
    if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
        App::setLocale('en');
        $lang = 'en';
    }
    else{
        App::setLocale('th');
        $lang = 'th';
    }
?>

@section('css')
    <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/profile.css') !!}">
    <style>
        .footer-0 {
            top: unset !important;
            position: absolute !important;
            bottom: 0;
            width: 100%
        }
        .page-item {
            cursor: pointer;
        }

        .has-search .form-control {
          padding-left: 2.375rem;
        }

        .has-search .form-control-feedback {
            position: absolute;
            z-index: 2;
            display: block;
            width: 2.375rem;
            height: 2.375rem;
            line-height: 2.375rem;
            text-align: center;
            pointer-events: none;
            color: #aaa;
        }
    </style>
@endsection
@section('content')

{{-- <section class="mt-3 mb-3"> p-t-50 p-b-65--}}
<section class="p-t-50 p-b-30">
    <div class="container">
      <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="row">
            <div class="col-md-6">
              <div class="form-group has-search">
                <span class="fa fa-search form-control-feedback"></span>
                <input type="text" id="" name="teacher_name" class="form-control search_icon mb-2" onkeyup="search_page()" placeholder="@lang('frontend/members/title.search_teacher')">
              </div>
                {{-- <input id="" name="teacher_name" type="text" class="form-control search_icon mb-2" onkeyup="search_page()" placeholder="@lang('frontend/members/title.search_teacher')"> --}}
            </div>
            <input type="hidden" name="lang" value="{{ $lang }}">
            <div class="col-md-3">
                <select class="form-control mb-2" style="padding-top: 4px;" ame="aptitude" onchange="search_page()">
                    <option value="">- @lang('frontend/members/title.study_group') -</option>
                    @foreach ($aptitude as $item)
                        <option value="{{ $item->_id }}">{{ ($lang=='en')?$item->aptitude_name_en:$item->aptitude_name_th }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control mb-2" style="padding-top: 4px;" name="subject" onchange="search_page()">
                    <option value="">- @lang('frontend/members/title.subject') -</option>
                    @foreach ($subject as $item)
                        <option value="{{ $item->_id }}">{{ ($lang=='en')?$item->subject_name_en:$item->subject_name_th }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
{{-- </section> --}}

<div align="center" style="margin-top : 30px; margin-bottom : 30px;">
    <i class="fa fa-graduation-cap hat fa-3x" style="color: aquamarine;"></i>
    <br>
    <h3>@lang('frontend/members/title.all_teacher')</h3>
</div>

{{-- <section class="blog"> --}}
    <div class="container" id="pagination"></div>
</section>

@stop

@push('scripts')
    <script src="/suksa/frontend/template/js/pagination-bt4.js"></script>
    <script>
       let data = {'page': 1};
        pagination(data, '/teacher/searach', 'detaliteacher');

        async function search_page(page = 1) {
            let data = {
                'page': page,
                'teacher_name': $('[name="teacher_name"]').val(),
                'aptitude': $('[name="aptitude"]').val(),
                'subject': $('[name="subject"]').val()
            };

            await pagination(data, '/teacher/searach', 'detaliteacher');
        }
    </script>
@endpush
