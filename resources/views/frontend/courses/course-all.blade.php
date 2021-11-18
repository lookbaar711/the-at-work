@extends('frontend/default')

<?php
    if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
        App::setLocale('en');
    }
    else{
        App::setLocale('th');
    }
?>
{{-- {{ dd($courses_free) }} --}}
@section('css')
<link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/course.css') !!}">
@stop
@section('content')
  <style>
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
<script type="text/javascript">
    @if(Session::has('flash_message'))

        var paid_coins_success = '{{ trans('frontend/courses/title.paid_coins_success') }}';
        var course_name = '{{ trans('frontend/courses/title.course_name') }}';
        var aptitude = '{{ trans('frontend/courses/title.aptitude') }}';
        var teacher = '{{ trans('frontend/courses/title.teacher') }}';
        var course_date = '{{ trans('frontend/courses/title.course_date') }}';
        var course_price = '{{ trans('frontend/courses/title.course_price') }}';
        var remaining_coins = '{{ trans('frontend/courses/title.remaining_coins') }}';
        var close_window = '{{ trans('frontend/courses/title.close_window') }}';

        Swal.fire({
            title: '<strong>'+paid_coins_success+'</u></strong>',
            imageUrl: '{!! asset ('suksa/frontend/template/images/alert/img_pu_coins01.png') !!}',
            imageHeight: 150,
            html:
                '<div class="row">'+
                    '<div class="col-md-12" align="left">'+
                        '<b>'+course_name+' {{session('flash_message')[0]}}</b> '+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-md-4 fontss" align="left">'+
                        '<b style="font-size:14px;">'+aptitude+'</b> '+
                    '</div>'+
                    '<div class="col fontss" align="left">'+
                        '<label style="font-size:14px;">{{session('flash_message')[1]}}</label>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-md-4 fontss" align="left">'+
                        '<b style="font-size:14px;" >'+teacher+'</b> '+
                    '</div>'+
                    '<div class="col fontss" align="left">'+
                        '<label style="font-size:14px;">{{session('flash_message')[2]}}</label>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-md-4 fontss" align="left">'+
                        '<b style="font-size:14px;">'+course_date+'</b> '+
                    '</div>'+
                    '<div class="col fontss" align="left">'+
                        '<label style="font-size:14px;">{{session('flash_message')[3]}}</label>'+
                    '</div>'+
                '</div>'+
                '<hr>'+
                '<div class="row">'+
                    '<div class="col-md-4 fontss" align="left">'+
                        '<b style="font-size:14px;" >'+course_price+'</b> '+
                    '</div>'+
                    '<div class="col fontss" align="left">'+
                        '<label style="font-size:14px;">{{session('flash_message')[4]}} Coins </label>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-md-4 fontss" align="left">'+
                        '<b style="font-size:14px;">'+remaining_coins+'</b> '+
                    '</div>'+
                    '<div class="col fontss" align="left">'+
                        '<label style="font-size:14px;">{{session('flash_message')[5]}} Coins </label>'+
                    '</div>'+
                '</div>',
            showCloseButton: true,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonColor: '#003D99',
            confirmButtonText: close_window,
        });
    @elseif(session('course')=='success')

      var create_course_success = '{{ trans('frontend/courses/title.create_course_success') }}';
      var create_course_message = '{{ trans('frontend/courses/title.create_course_message') }}';

      Swal.fire({
              title: '<strong>คุณได้สร้างห้องประชุมเรียบร้อยแล้ว</u></strong>',
              type: 'success',
              imageHeight: 100,
              html:
                  '',
              showCloseButton: true,
              showCancelButton: false,
              focusConfirm: false,
              confirmButtonColor: '#003D99',
              confirmButtonText: close_window,
      });
    @endif
</script>

<section class="p-t-50 p-b-65">
    <div class="container">
        <div class="form-row" align="right" >
            <div class="col" style=" padding-bottom: 5px; " >
                <meta name="csrf-token" content="{{ csrf_token() }}">
                {{-- <div class="form-group has-search">
                  <span class="fa fa-search form-control-feedback"></span>
                  <input type="text" id="text_search" name="text_search" class="form-control" placeholder="@lang('frontend/courses/title.search_course')">
                </div> --}}
            </div>
            <div class="col-md-3" style="padding-bottom: 5px;">
                {{-- <select class="form-control" style="padding-top: 4px;" id="get_study_group" onchange="course_free.get_subjects_id(this.value)"></select> --}}
            </div>
            <div class="col-md-3" style="padding-bottom: 5px;">
                {{-- <select class="form-control" style="padding-top: 4px;" id="get_subjects" ></select> --}}
            </div>
            @if(Auth::guard('members')->user())
              {{-- @if(Auth::guard('members')->user()->member_role == "teacher") --}}
              <div class="col-md-3" style="padding-bottom: 20px;">
                  <a href="{{ route('courses.create') }}" class="flex-c-m size2 bo-rad-23 s-text3 bgwhite hov1 trans-0-5 "><object class="colorz" style="font-size: 16px;" > <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Create Conference Room</object> </a>
              </div>
              {{-- @endif --}}
            @endif
        </div>
        <div align="center" style="margin-top : 30px;">{{-- <i class="fa fa-graduation-cap hat fa-3x" style="color: aquamarine;"></i><br> --}}<h3>Conference Room</h3></div>

        <div class="tab01">

            {{-- <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link open_course_free active" data-toggle="tab" href="#course_free" id="check_course_free" role="tab">@lang('frontend/courses/title.free_course')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link open_course_not_free" data-toggle="tab" href="#course_not_free" id="check_course_not_free" role="tab">@lang('frontend/courses/title.paid_course')</a>
                </li>
            </ul> --}}

            <div class="tab-content p-t-35">

              <div class="tab-pane fade active show course_free" id="course_free" role="tabpanel">
                <div class="row" id="page_courseFree"></div>
              </div>

              <div class="btn-group pull-right page_free navigation_page_courseFree">
                <nav aria-label="Page navigation example">
                   <ul class="pagination page_courseFree" id="alerts_page_num"></ul>
                </nav>
              </div>




              {{-- <div class="tab-pane fade active show course_not_free" id="course_not_free" role="tabpanel">
                <div class="row" id="page_course_not_free"></div>
              </div>

              <div class="btn-group pull-right page_not_free navigation_page_course_not_free">
                <nav aria-label="Page navigation example">
                   <ul class="pagination page_course_not_free" id="alerts_course_not_free"></ul>
                </nav>
              </div> --}}

              {{-- <div class="tab-pane fade course_not_free" id="course_not_free" role="tabpanel">
                  <div class="row" id="result_courseNotFree"></div>
                  <div class="btn-group pull-right">
                    <nav aria-label="Page navigation example">
                       <ul class="pagination navigation_courseNotFree" id="page_num_not_free">
                      </ul>
                    </nav>
                  </div>
              </div> --}}

            </div>
        </div>

    </div>
</section>
<script src="/suksa/frontend/template/js/paginate_course_free.js"></script>
@stop
@push('scripts')
    <script>
        async function footerBottom() {
            await removeFt0();
            windowHeight = $(window).height();
            footerHeight = $('#footer')[0].offsetTop + $('#footer')[0].offsetHeight;
            // console.log(windowHeight);
            // console.log(footerHeight);

            if (footerHeight <= windowHeight) {
                $("#footer").addClass("footer-0");
            }
        }

        function removeFt0() {
            return new Promise(function(resolve, reject) {
            $("#footer").removeClass("footer-0");
            resolve()
            }).then(function(){
                return true;
            })
        }
    </script>
@endpush
