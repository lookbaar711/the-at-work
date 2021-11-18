<!doctype html>
<?php
    if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
        App::setLocale('en');
    }
    else{
        App::setLocale('th');
    }

    /*
    if(isset(Auth::guard('members')->user()->member_lang)){
        if(Auth::guard('members')->user()->member_lang=='en'){
            App::setLocale('en');
        }
        else{
            App::setLocale('th');
        }
    }
    else{
        if(session('lang')=='en'){
            App::setLocale('en');
        }
        else{
            App::setLocale('th');
        }
    }
    */

    $url_alerts_profile = "";

    //echo 'config : '.Config::get('app.locale').' -- session : '.session('lang');

    if(Auth::guard('members')->user()){
        $member_noti = get_member_noti();
        $count_noti = count_member_noti();
        $count_badge_noti = count_badge_member_noti();
        $show_noti = 1;
        $member_role = Auth::guard('members')->user()->member_role;

        if(Auth::guard('members')->user()->member_type =='student'){
            $approve_topup_coins_url = url('users/profile/');
            $not_approve_topup_coins_url = url('users/profile/');
            $approve_withdraw_coins_url = url('users/profile/');
            $not_approve_withdraw_coins_url = url('users/profile/');
            $url_alerts_profile = url('users/profile/');
        }
        else{
            if(Auth::guard('members')->user()->member_role =='teacher'){
                $approve_topup_coins_url = url('members/profile/');
                $not_approve_topup_coins_url = url('members/profile/');
                $approve_withdraw_coins_url = url('members/profile/');
                $not_approve_withdraw_coins_url = url('members/profile/');
                $url_alerts_profile = url('members/profile/');
            }
            else{
                $approve_topup_coins_url = url('users/profile/');
                $not_approve_topup_coins_url = url('users/profile/');
                $approve_withdraw_coins_url = url('users/profile/');
                $not_approve_withdraw_coins_url = url('users/profile/');
                $url_alerts_profile = url('users/profile/');
            }
        }
    }
    else{
        $count_noti = 0;
        $count_badge_noti = 0;
        $member_role = '';

        $approve_topup_coins_url = '#';
        $not_approve_topup_coins_url = '#';
        $approve_withdraw_coins_url = '#';
        $not_approve_withdraw_coins_url = '#';
    }

    //echo 'lang = '.session('lang').' -- member_lang = '.Auth::guard('members')->user()->member_lang;
    //echo $_SERVER['HTTP_HOST'];
?>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}">
        <title>
            @if($count_badge_noti > 0)
                ({{ $count_badge_noti }})
            @endif
            ATWORK
        </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

        <!-- fonts kanit -->
        <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/fonts/font-awesome-4.7.0/css/font-awesome.min.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/fonts/themify/themify-icons.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/fonts/elegant-font/html-css/style.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/bootstrap/css/bootstrap.min.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/animate/animate.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/css-hamburgers/hamburgers.min.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/animsition/css/animsition.min.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/select2/select2.min.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/daterangepicker/daterangepicker.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/slick/slick.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/lightbox2/css/lightbox.min.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/util.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/main.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/modal.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/bootstrap-datetimepicker.css') !!}" >
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/bootstrap-datetimepicker.min.css') !!}" >
        {{-- <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/owl.carousel.min.css') !!}" >
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/owl.theme.default.min.css') !!}" > --}}
        @yield('css')

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

        <!-- 1. Addchat css -->
        <link href="{{ asset('assets/addchat/css/addchat.min.css') }}" rel="stylesheet">

    <style>
          div.card-shodow {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .text-green{
            font-size: 16px;
            color: rgb(10, 10, 10);
        }
        .overflow_course {
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
          width: 200px;
          display: block;
          height: 34px;
        }
        .overflow_index {
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
          /* width: 200px; */
          display: block;
          /* height: 34px; */
        }
        .img-thumbnail {
            padding: .25rem;
            background-color: #fff;
            border: unset;
            border-radius: .25rem;
            transition: all .2s ease-in-out;
            max-width: 100%;
            height: auto;
        }
        .btn-login-header {
          top: 72px;
          left: 1501px;
          border-radius: 25px;
          background: transparent linear-gradient(90deg, #003D99 0%, #42A2EC 100%) 0% 0% no-repeat padding-box;
          opacity: 1;

        }
        .line-header {
          /* top: 173px; */
          left: -5px;
          width: 100%;
          height: 9px;
          background: transparent linear-gradient(90deg, #003D99 0%, #42A2EC 100%) 0% 0% no-repeat padding-box;
          opacity: 1;
        }
        .w-90 {
            width: 90%;
        }
        .p-r-510 {
            width: 510;
        }
        .topbar-child-22 {
          right: 0;
          display: -webkit-box;
          display: -webkit-flex;
          display: -moz-box;
          display: -ms-flexbox;
          display: flex;
          align-items: center;
          flex-wrap: wrap;
          padding-right: 20px;
      }

      .btn-login-header2 {
          border-radius: 25px;
          background: #ffe5e500 linear-gradient(90deg, #003D99 0%, #42A2EC 100%) 0% 0% no-repeat padding-box;
          opacity: 1;
          color: white;
      }
      .item-menu-mobile{
        color: #fff;
        background-color: #003D99;
        border-color: #003D99;
      }
      .btn-noti{
        color: #fff;
        background-color: #003D99;
        border-color: #003D99;
      }

      .side-menu .main-menu>li {
          color: black;
          position: relative;
      }
      .carousel-inner img {
          width: 100%;
      }
      .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 60px;
        line-height: 60px;
        background-color: #22324A;
        text-align: center;
        color: #888888;
        animation-duration: 1500ms;
        opacity: 1;
        font-size: 14px;
    }
    .btn-show-menu {
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        height: auto;
        justify-content: center;
        align-items: center;
    }
    a:hover {
        color: #003D99;
    }
    .side-menu .sub-menu a:hover {
        text-decoration: none;
        padding-left: 20px;
        color: #003D99 !important;
    }
    </style>
  </head>

  <body>
    <body>
        <div class="animsition">

            <!-- Header -->

            <header class="header2">

                <!-- Header PC -->

                <div class="container-menu-header-v2 p-t-2">
                      <div class="topbar2">
                        <div class="text-right" style="margin-right: 71%;">
                          <a href="{{ url('/') }}" class="logo2">
                              <img src="{{ asset ('/img/Group 1547.png') }}" style="width: 200px;">
                          </a>
                        </div>

                          @if(!Auth::guard('members')->user())
                          <div class="topbar-child2 m-l-30">

                              <a class="nav-link" href="{{ url('/') }}">  HOME </a>

                              <li class="nav-item btn-group" style="margin-top: 7px;">
                                <a class="dropdown-toggle nav-link" href="#"  data-toggle="dropdown" role="button" aria-expanded="false" >
                                  <label class="nav-item">
                                    CONFERENCE ROOM
                                  </label>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" style="margin-top: -12px;">
                                  <a class="dropdown-item p-4" href="{{ URL::to('courses/all/') }}" style="padding: 4px!important; padding-left: 15px!important;">
                                      All Conference Room
                                  </a>
                                  @if(Auth::guard('members')->user())
                                    <a class="dropdown-item p-4" href="{{ URL::to('users/active_course') }}" style="padding: 4px!important; padding-left: 15px!important;">
                                        My Conference Room
                                    </a>
                                  @endif
                                </div>
                              </li>


                              @if(!Auth::guard('members')->user())
                                <a  href="{{ route('users.create') }}"class="btn  btn-sm"  style="border-radius: 25px;  width: 115px; color: #003D99;border-color: #003D99;">
                                  <i class="fa fa-user" aria-hidden="true" ></i>&nbsp;
                                  <span>Sign Up</span>
                                </a>
                                &nbsp;
                                <a class="btn btn-login-header btn-sm" data-toggle="modal" data-target="#myModal" style="cursor: pointer;  width: 115px;">
                                  <i class="fa fa-lock" aria-hidden="true" style="color: #ffffff;"></i>&nbsp;
                                  <span style="color: #ffffff;">Sign In</span>
                                </a>
                              @endif

                          </div>
                          @else

                          <div class="topbar-child2 m-l-30" style="padding-top: 20px;">

                            <a class="nav-link" href="{{ url('/') }}" style="margin-top: -7px;">  HOME </a>

                            <li class="nav-item btn-group" >
                              <a class="dropdown-toggle nav-link" href="#"  data-toggle="dropdown" role="button" aria-expanded="false" >
                                <label class="nav-item">
                                  CONFERENCE ROOM
                                </label>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right" style="margin-top: -12px;">
                                <a class="dropdown-item p-4" href="{{ URL::to('courses/all/') }}" style="padding: 4px!important; padding-left: 15px!important;">
                                    All Conference Room
                                </a>
                                @if(Auth::guard('members')->user())
                                  <a class="dropdown-item p-4" href="{{ URL::to('users/active_course') }}" style="padding: 4px!important; padding-left: 15px!important;">
                                      My Conference Room
                                  </a>
                                @endif
                              </div>
                            </li>

                            <div class="btn-group">
                                <a class="dropdown-toggle " href="#"  data-toggle="dropdown" role="button" aria-expanded="false">
                                  <label class="text-green">@lang('frontend/layouts/title.hello')
                                  @if(Auth::guard('members')->user()->member_role=="teacher")
                                      @lang('frontend/layouts/title.teacher')
                                  @else
                                      @lang('frontend/layouts/title.you')
                                  @endif
                                    {{ Auth::guard('members')->user()->member_fname }} {{ Auth::guard('members')->user()->member_lname }}</label></a>
                                <span class="caret"></span>

                                <div class="dropdown-menu dropdown-menu-right">

                                  @if(Auth::guard('members')->user()->member_role =='teacher')
                                      <a class="dropdown-item" href="{{ url('members/profile/') }}" >
                                  @else
                                      <a class="dropdown-item" href="{{ url('users/profile/') }}" >
                                  @endif
                                      <img src="{{ asset ('suksa/frontend/template/images/icons/145671.jpg') }}" class="imgsize-s" >
                                      <label style="color:black;">@lang('frontend/layouts/title.my_profile')</label>
                                      </a>
                                      @if(Auth::guard('members')->user()->member_role =='teacher')
                                      <a class="dropdown-item" href="{{ url('/calendar/') }}" >
                                      <i class="fa" style="font-size:24px">&#xf073;</i> <label for="">@lang('frontend/members/title.my_schedul')</label>
                                  </a>
                                  @endif


                                  @if(Auth::guard('members')->user()->member_role =='teacher')
                                      <a class="dropdown-item" href="{{ url('changeaccount') }}" >
                                        <i class="fa fa-retweet" aria-hidden="true" style="font-size:24px"></i>
                                        <label style="color:black;"> @lang('frontend/layouts/title.switch_to_student') </label>
                                      </a>
                                  @elseif(Auth::guard('members')->user()->member_role =='student')
                                      <a class="dropdown-item" href="{{ url('changeaccount') }}">
                                        <i class="fa fa-retweet" aria-hidden="true" style="font-size:24px"></i>
                                        <label style="color:black;"> @lang('frontend/layouts/title.switch_to_teacher') </label>
                                      </a>
                                  @endif

                                  <a class="dropdown-item btn_modal_change_password" href="#" id="btn_modal_change_password">
                                    <i class="fas fa-lock" aria-hidden="true" style="font-size:24px"></i>
                                    <label style="color:black;"> @lang('frontend/layouts/title.Change_password') </label>
                                  </a>

                                  <a class="dropdown-item" href="{{ url('logout/frontend') }}"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <img src="{{ asset ('suksa/frontend/template/images/icons/145670.jpg') }}" class="imgsize-s" >
                                    <label style="color:black;"> @lang('frontend/layouts/title.logout') </label>
                                    <form id="logout-form" action="{{ url('logout') }}" method="GET">
                                        {{ csrf_field() }}
                                    </form>
                                  </a>

                                </div>

                                <input type="hidden" name="member_id" id="member_id" value="{{ Auth::guard('members')->user()->member_id }}">
                            </div>

                            <span class="linedivide1" style="margin-top: 0px; margin-left: 15px; margin-right: 15px;"></span>

                            <div class="header-wrapicon2" style="padding-right: 20px; padding-top: 3px;">

                                <input type="hidden" name="badge" id="badge" value="{{ $count_badge_noti }}">
                                <a href="#test" class="js-show-header-dropdown clear-badge" style=""> <img src="{{ asset ('suksa/frontend/template/images/icons/img_noti1.png') }}" style="height: 24px; width: 24px;"></a>
                                <div id="show_noti">
                                    @if($count_badge_noti > 0)
                                        <span class="header-icons-noti">{{ $count_badge_noti }}</span>
                                    @endif
                                </div>
                                <!-- Header noti -->
                                <div class="header-cart header-dropdown">
                                    <div class="header-cart-item-txt">
                                        <a href="#" class="header-cart-item-name">
                                            <h5 class="header-noti" style="padding-left: 20px;"><b>@lang('frontend/layouts/title.notification')</b></h5>
                                        </a>
                                    </div>

                                    <ul class="header-cart-wrapitem" id="header_noti">
                                        @if(isset($member_noti) && ($count_noti > 0))
                                            @foreach($member_noti as $noti)
                                                @if($show_noti > 1)

                                                @endif

                                                @if($noti->noti_type == 'open_course_teacher')
                                                    @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                                <p class="text-head-noti"><b>Close to the time to teach</b></p>
                                                                <p class="fs-13 header-noti">{{ $noti->classroom_name }} of {{ $noti->teacher_fullname }} </p>
                                                                <p class="fs-13 header-noti">Teaching date {{ date('d/m/Y', strtotime($noti->classroom_date)) }} Time {{ $noti->classroom_time_start.'-'.$noti->classroom_time_end }}</p>
                                                                <div class="row">
                                                                    <div class="col-sm-7" >
                                                                        <p class="fs-12">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                    </div>
                                                                    <a href="{{ URL::to('classroom/check/'.$noti->_id) }}" target="_blank" class="btn-noti size-noti "><object class="color-noti fs-14">Join</object></a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                                <p class="text-head-noti"><b>ใกล้ถึงเวลาเข้าประชุม</b></p>
                                                                <p class="fs-13 header-noti">{{ $noti->classroom_name }} ของคุณ</p>
                                                                <p class="fs-13 header-noti">วันที่ประชุม {{ date('d/m/Y', strtotime($noti->classroom_date)) }} เวลา {{ $noti->classroom_time_start.'-'.$noti->classroom_time_end }}</p>
                                                                <div class="row">
                                                                    <div class="col-sm-7" >
                                                                        <p class="fs-12">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                    </div>
                                                                    <a href="{{ URL::to('classroom/check/'.$noti->_id) }}" target="_blank" class="btn-noti size-noti" style="padding-top: 2px;"><object class="color-noti fs-14">เข้าร่วม</object></a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @elseif($noti->noti_type == 'open_course_student')
                                                    @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                                <p class="text-head-noti"><b>Close to the time to study</b></p>
                                                                <p class="fs-13 header-noti">{{ $noti->classroom_name }} with teacher {{ $noti->teacher_fullname }} </p>
                                                                <p class="fs-13 header-noti">Teaching date {{ date('d/m/Y', strtotime($noti->classroom_date)) }} Time {{ $noti->classroom_time_start.'-'.$noti->classroom_time_end }}</p>
                                                                <div class="row">
                                                                    <div class="col-sm-7" >
                                                                        <p class="fs-12">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                    </div>
                                                                    <a href="{{ URL::to('classroom/check/'.$noti->_id) }}" target="_blank" class="btn-noti size-noti "><object class="color-noti fs-14">Join</object></a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                                <p class="text-head-noti"><b>ใกล้ถึงเวลาเข้าประชุม</b></p>
                                                                <p class="fs-13 header-noti">{{ $noti->classroom_name }}</p>
                                                                <p class="fs-13 header-noti">วันที่ประชุม {{ date('d/m/Y', strtotime($noti->classroom_date)) }} เวลา {{ $noti->classroom_time_start.'-'.$noti->classroom_time_end }}</p>
                                                                <div class="row">
                                                                    <div class="col-sm-7" >
                                                                        <p class="fs-12">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                    </div>
                                                                    <a href="{{ URL::to('classroom/check/'.$noti->_id) }}" target="_blank" class="btn-noti size-noti" style="padding-top: 2px;"><object class="color-noti fs-14">เข้าร่วม</object></a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @elseif($noti->noti_type == 'register_course_teacher')
                                                    @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                                <a href="#">
                                                                    <p class="text-head-noti"><b>Someone register for your course</b></p>
                                                                    <p class="fs-13 header-noti">{{ $noti->student_fullname }} register for  {{ $noti->classroom_name }}</p>
                                                                    <p class="fs-13 header-noti">Teaching date {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' to '.date('d/m/Y', strtotime($noti->classroom_end_date)) }}

                                                                        {{ date('d/m/Y', strtotime($noti->classroom_start_date)) }}</p>
                                                                    <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                </a>
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                                <a href="#">
                                                                    <p class="text-head-noti"><b>มีคนเข้าร่วมห้องประชุมของคุณ</b></p>
                                                                    <p class="fs-13 header-noti">{{ $noti->student_fullname }} เข้าร่วมประชุม {{ $noti->classroom_name }}</p>
                                                                    <p class="fs-13 header-noti">วันที่ประชุม {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' ถึง '.date('d/m/Y', strtotime($noti->classroom_end_date)) }}</p>
                                                                    <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                </a>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @elseif($noti->noti_type == 'register_course_private_teacher')
                                                    @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                                <a href="#">
                                                                    <p class="text-head-noti"><b>Someone register for your course</b></p>
                                                                    <p class="fs-13 header-noti">{{ $noti->student_fullname }} register for  {{ $noti->classroom_name }}</p>
                                                                    <p class="fs-13 header-noti">Teaching date {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' to '.date('d/m/Y', strtotime($noti->classroom_end_date)) }}</p>
                                                                    <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                </a>
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                                <a href="#">
                                                                    <p class="text-head-noti"><b>เข้าร่วมประชุมสำเร็จ</b></p>
                                                                    <p class="fs-13 header-noti">{{ $noti->student_fullname }} เข้าร่วมประชุม {{ $noti->classroom_name }} ของคุณ</p>
                                                                    <p class="fs-13 header-noti">วันที่ประชุม {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' ถึง '.date('d/m/Y', strtotime($noti->classroom_end_date)) }}</p>
                                                                    <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                </a>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @elseif($noti->noti_type == 'register_course_student')
                                                    @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                            <a href="#">
                                                                <p class="text-head-noti"><b>Registration completed</b></p>
                                                                <p class="fs-13 header-noti">You register for {{ $noti->classroom_name }} with teacher {{ $noti->teacher_fullname }}</p>
                                                                <p class="fs-13 header-noti">Teaching date {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' to '.date('d/m/Y', strtotime($noti->classroom_end_date)) }}</p>
                                                                <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                            </a>
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                            <a href="#">
                                                                <p class="text-head-noti"><b>เข้าร่วมประชุมสำเร็จ</b></p>
                                                                <p class="fs-13 header-noti">คุณเข้าร่วมประชุม {{ $noti->classroom_name }}</p>
                                                                <p class="fs-13 header-noti">วันที่ประชุม {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' ถึง '.date('d/m/Y', strtotime($noti->classroom_end_date)) }}</p>
                                                                <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                            </a>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @elseif($noti->noti_type == 'register_course_private_student')
                                                    @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                            <a href="#">
                                                                <p class="text-head-noti"><b>Registration completed</b></p>
                                                                <p class="fs-13 header-noti">You register for {{ $noti->classroom_name }} with teacher {{ $noti->teacher_fullname }}</p>
                                                                <p class="fs-13 header-noti">Teaching date {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' to '.date('d/m/Y', strtotime($noti->classroom_end_date)) }}</p>
                                                                <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                            </a>
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                            <a href="#">
                                                                <p class="text-head-noti"><b>เข้าร่วมประชุมสำเร็จ</b></p>
                                                                <p class="fs-13 header-noti">เข้าร่วมประชุม {{ $noti->classroom_name }}</p>
                                                                <p class="fs-13 header-noti">วันที่ประชุม {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' ถึง '.date('d/m/Y', strtotime($noti->classroom_end_date)) }}</p>
                                                                <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                            </a>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @elseif($noti->noti_type == 'invite_course_student')
                                                    @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                                <p class="text-head-noti"><b>Private course created, waiting for payment</b></p>
                                                                <p class="fs-13 header-noti">{{ $noti->course_name }} with teacher {{ $noti->teacher_fullname }}</p>
                                                                <p class="fs-13 header-noti">Teaching date
                                                                    {{ date('d/m/Y ', strtotime($noti->course_start_date)) }}
                                                                @if(count($noti->course_datetime)>1)
                                                                to {{ date('d/m/Y ', strtotime($noti->course_end_date)) }}
                                                                @endif
                                                                </p>
                                                            <div class="row">
                                                                <div class="col-sm-7" >
                                                                    <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                </div>
                                                                    <a href="{{ URL::to('courses/'.$noti->course_id) }}" class="btn-noti-invate size-noti"><object class="color-noti fs-14">Pay</object></a>
                                                            </div>
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                                <p class="text-head-noti"><b>ห้องประชุม Private ถูกสร้างแล้ว</b></p>
                                                                <p class="fs-13 header-noti">{{ $noti->course_name }}</p>
                                                                <p class="fs-13 header-noti">วันที่ประชุม
                                                                    {{ date('d/m/Y ', strtotime($noti->course_start_date)) }}
                                                                @if(count($noti->course_datetime)>1)
                                                                ถึง {{ date('d/m/Y ', strtotime($noti->course_end_date)) }}
                                                                @endif
                                                                </p>
                                                            <div class="row">
                                                                <div class="col-sm-7" >
                                                                    <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                </div>
                                                                    <a href="{{ URL::to('courses/'.$noti->course_id) }}" class="btn-noti-invate size-noti" style="padding-top: 2px;"><object class="color-noti fs-14">ลงทะเบียน</object></a>
                                                            </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @elseif($noti->noti_type == 'cancel_course_teacher_not')
                                                    @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                                <p class="text-head-noti"><b>Open course {{$noti->classroom_name }} (Private) unsuccessful</b></p>
                                                                <p class="fs-13 header-noti">Because no one pays study fee.</p>
                                                                <p class="fs-13 header-noti">Contact students to re-open the course.</p>
                                                            <div class="row">
                                                                <div class="col-sm-7" >
                                                                    <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                            <div class="header-cart-item-txt">
                                                                <p class="text-head-noti"><b>เปิดห้องประชุม {{$noti->classroom_name }} (Private)  ไม่สำเร็จ</b></p>
                                                                <p class="fs-13 header-noti">เนื่องจากไม่มีผู้เข้าร่วมประชุม</p>
                                                                <p class="fs-13 header-noti">ติดต่อสมาชิกเพื่อเปิดห้องประชุมใหม่อีกครั้ง</p>
                                                            <div class="row">
                                                                <div class="col-sm-7" >
                                                                    <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endif
                                                @php
                                                   $show_noti++;
                                                @endphp
                                            @endforeach
                                        @else
                                        <li class="header-cart-item">
                                            <div class="header-cart-item-txt">
                                                <img src="{{ asset ('suksa/frontend/template/images/icons/img_noti1.png') }}"  style="width: 30px; height: 30px;">
                                                <span class="linedivide3"></span>
                                                @lang('frontend/layouts/title.noti_not_found')
                                            </div>
                                        </li>
                                        @endif
                                    </ul>

                                    <div class="header-cart-item-txt" style="padding-top: 10px; text-align: center;">
                                        <input type="text" name="url_alerts_profile" id="url_alerts_profile_1" value="{{$url_alerts_profile}}" style="display:none;">

                                            <button class="btn-outline default btn_url_alerts_profile" >@lang('frontend/layouts/title.see_all_noti')</button>

                                    </div>

                                </div>
                            </div>

                          </div>

                          @endif

                      </div>
                </div>

                <!-- Header Mobile -->

                <div class="wrap_header_mobile">
                    <!-- Logo moblie -->
                    <a href="{{ url('/') }}" class="logo-mobile">
                            <img src="{{ asset ('suksa/frontend/template/images/logo1.png') }}">
                    </a>
                    <!-- Button show menu -->
                    <div class="btn-show-menu" >
                        <!-- Header Icon mobile -->
                        <div class="header-wrapicon2" style="width: 20px; margin: auto">
                            <input type="hidden" name="badge_mobile" id="badge_mobile" value="{{ $count_badge_noti }}">
                            <a href="#test" class="js-show-header-dropdown clear-badge"> <img src="{{ asset ('suksa/frontend/template/images/icons/img_noti1.png') }}" style="height: 24px; width: 24px;"></a>
                            <div id="show_noti_mobile">
                                @if($count_badge_noti > 0)
                                    <span class="header-icons-noti header-icons-noti-mobile" style="margin-right: -23px; margin-top: -3px;">{{ $count_badge_noti }}</span>
                                @endif
                            </div>
                            <!-- Header noti -->
                            <div class="header-cart2 header-dropdown" >
                                <div class="header-cart-item-txt">
                                    <a href="#" class="header-cart-item-name">
                                        <p class="header-noti" style="padding-left: 20px;"><b>@lang('frontend/layouts/title.notification')</b></p>
                                    </a>
                                </div>
                                <ul class="header-cart-wrapitem" id="header_noti_mobile">
                                    @if(isset($member_noti) && ($count_noti > 0))
                                        @foreach($member_noti as $noti)
                                            @if($noti->noti_type == 'open_course_teacher')
                                                @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                            <p class="text-head-noti"><b>Close to the time to teach</b></p>
                                                            <p class="fs-13 header-noti">{{ $noti->classroom_name }}  of {{ $noti->teacher_fullname }} </p>
                                                            <p class="fs-13 header-noti">Teaching date {{ date('d/m/Y', strtotime($noti->classroom_date)) }} Time {{ $noti->classroom_time_start.'-'.$noti->classroom_time_end }}</p>
                                                            <div class="row">
                                                                <div class="col-sm-7" >
                                                                    <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                </div>
                                                                <div class="col-sm-7" style="margin-top: -22px; text-align:right;">
                                                                    <a href="{{ URL::to('classroom/check/'.$noti->_id) }}" target="_blank" class="btn-noti size-noti "><object class="color-noti fs-14">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Join&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </object></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                            <p class="text-head-noti"><b>ใกล้ถึงเวลาเข้าประชุม</b></p>
                                                            <p class="fs-13 header-noti">{{ $noti->classroom_name }} ของคุณ</p>
                                                            <p class="fs-13 header-noti">วันที่ประชุม {{ date('d/m/Y', strtotime($noti->classroom_date)) }} เวลา {{ $noti->classroom_time_start.'-'.$noti->classroom_time_end }}</p>
                                                            <div class="row">
                                                                <div class="col-sm-7" >
                                                                    <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                </div>
                                                                <div class="col-sm-7" style="margin-top: -22px; text-align:right;">
                                                                    <a href="{{ URL::to('classroom/check/'.$noti->_id) }}" target="_blank" class="btn-noti size-noti" style="padding-top: 2px;"><object class="color-noti fs-14">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เข้าร่วม&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </object></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @elseif($noti->noti_type == 'open_course_student')
                                                @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                            <p class="text-head-noti"><b>Close to the time to study</b></p>
                                                            <p class="fs-13 header-noti">{{ $noti->classroom_name }} with teacher {{ $noti->teacher_fullname }} </p>
                                                            <p class="fs-13 header-noti">Teaching date {{ date('d/m/Y', strtotime($noti->classroom_date)) }} Time {{ $noti->classroom_time_start.'-'.$noti->classroom_time_end }}</p>
                                                            <div class="row">
                                                                <div class="col-sm-7" >
                                                                    <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                </div>
                                                                <div class="col-sm-7" style="margin-top: -22px; text-align:right;">
                                                                    <a href="{{ URL::to('classroom/check/'.$noti->_id) }}" target="_blank" class="btn-noti size-noti "><object class="color-noti fs-14">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Join&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</object></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                            <p class="text-head-noti"><b>ใกล้ถึงเวลาเข้าประชุม</b></p>
                                                            <p class="fs-13 header-noti">{{ $noti->classroom_name }}</p>
                                                            <p class="fs-13 header-noti">วันที่ประชุม {{ date('d/m/Y', strtotime($noti->classroom_date)) }} เวลา {{ $noti->classroom_time_start.'-'.$noti->classroom_time_end }}</p>
                                                            <div class="row">
                                                                <div class="col-sm-7">
                                                                    <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}
                                                                    </p>
                                                                </div>
                                                                <div class="col-sm-7" style="margin-top: -22px; text-align:right;">
                                                                    <a href="{{ URL::to('classroom/check/'.$noti->_id) }}" target="_blank" class="btn-noti size-noti" style="padding-top: 2px;"><object class="color-noti fs-14">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เข้าร่วม&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </object></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @elseif($noti->noti_type == 'register_course_teacher')
                                                @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                            <a href="#">
                                                                <p class="text-head-noti"><b>Someone register for your course</b></p>
                                                                <p class="fs-13 header-noti">{{ $noti->student_fullname }} register for {{ $noti->classroom_name }}</p>
                                                                <p class="fs-13 header-noti">Teaching date {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' to '.date('d/m/Y', strtotime($noti->classroom_end_date)) }} </p>
                                                                <p class="fs-12 header-noti">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                            </a>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                            <a href="#">
                                                                <p class="text-head-noti"><b>มีคนเข้าร่วมห้องประชุมของคุณ</b></p>
                                                                <p class="fs-13 header-noti">{{ $noti->student_fullname }} เข้าร่วมประชุม {{ $noti->classroom_name }}</p>
                                                                <p class="fs-13 header-noti">วันที่ประชุม {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' ถึง '.date('d/m/Y', strtotime($noti->classroom_end_date)) }}</p>
                                                                <p class="fs-12 header-noti">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                            </a>
                                                        </div>
                                                    </li>
                                                @endif
                                            @elseif($noti->noti_type == 'register_course_private_teacher')
                                                @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                            <a href="#">
                                                                <p class="text-head-noti"><b>Someone register for your course</b></p>
                                                                <p class="fs-13 header-noti">{{ $noti->student_fullname }} register for {{ $noti->classroom_name }}</p>
                                                                <p class="fs-13 header-noti">Teaching date {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' to '.date('d/m/Y', strtotime($noti->classroom_end_date)) }} </p>
                                                                <p class="fs-12 header-noti">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                            </a>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                            <a href="#">
                                                                <p class="text-head-noti"><b>เข้าร่วมประชุมสำเร็จ</b></p>
                                                                <p class="fs-13 header-noti">{{ $noti->student_fullname }} เข้าร่วมประชุม {{ $noti->classroom_name }}</p>
                                                                <p class="fs-13 header-noti">วันที่ประชุม {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' ถึง '.date('d/m/Y', strtotime($noti->classroom_end_date)) }}</p>
                                                                <p class="fs-12 header-noti">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                            </a>
                                                        </div>
                                                    </li>
                                                @endif
                                            @elseif($noti->noti_type == 'register_course_student')
                                                @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                            <a href="#">
                                                                <p class="text-head-noti"><b>Registration completed</b></p>
                                                                <p class="fs-13 header-noti">You register for {{ $noti->classroom_name }} with teacher {{ $noti->teacher_fullname }}</p>
                                                                <p class="fs-13 header-noti">Teaching date {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' to '.date('d/m/Y', strtotime($noti->classroom_end_date)) }}</p>
                                                                <p class="fs-12 header-noti">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                            </a>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                                <p class="text-head-noti"><b>เข้าร่วมประชุมสำเร็จ</b></p>
                                                                <p class="fs-13 header-noti">คุณเข้าร่วมประชุม {{ $noti->classroom_name }}</p>
                                                                <p class="fs-13 header-noti">วันที่ประชุม {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' ถึง '.date('d/m/Y', strtotime($noti->classroom_end_date)) }}</p>
                                                                <p class="fs-12 header-noti">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                        </div>
                                                    </li>
                                                @endif
                                            @elseif($noti->noti_type == 'register_course_private_student')
                                                @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                            <a href="#">
                                                                <p class="text-head-noti"><b>Registration completed</b></p>
                                                                <p class="fs-13 header-noti">You register for {{ $noti->classroom_name }} with teacher {{ $noti->teacher_fullname }}</p>
                                                                <p class="fs-13 header-noti">Teaching date {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' to '.date('d/m/Y', strtotime($noti->classroom_end_date)) }}</p>
                                                                <p class="fs-12 header-noti">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                            </a>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                                <p class="text-head-noti"><b>เข้าร่วมประชุมสำเร็จ</b></p>
                                                                <p class="fs-13 header-noti">เข้าร่วมประชุม {{ $noti->classroom_name }}</p>
                                                                <p class="fs-13 header-noti">วันที่ประชุม {{ ($noti->classroom_start_date==$noti->classroom_end_date)?date('d/m/Y', strtotime($noti->classroom_start_date)) : date('d/m/Y', strtotime($noti->classroom_start_date)).' ถึง '.date('d/m/Y', strtotime($noti->classroom_end_date)) }}</p>
                                                                <p class="fs-12 header-noti">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                        </div>
                                                    </li>
                                                @endif
                                            @elseif($noti->noti_type == 'invite_course_student')
                                                @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                                <p class="text-head-noti"><b>Private course created, waiting for payment</b></p>
                                                                <p class="fs-13 header-noti">{{ $noti->course_name }} with teacher {{ $noti->teacher_fullname }}</p>
                                                                <p class="fs-13 header-noti">Teaching date {{ date('d/m/Y ', strtotime($noti->course_start_date)) }}
                                                                @if(count($noti->course_datetime)>1)
                                                                to {{ date('d/m/Y ', strtotime($noti->course_end_date)) }}
                                                                @endif
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-sm-7" >
                                                                        <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                    </div>
                                                                    <div class="col-sm-7" style="margin-top: -22px; text-align:right;">
                                                                        <a href="{{ URL::to('courses/'.$noti->course_id) }}" class="btn-noti-invate size-noti "><object class="color-noti fs-14">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pay&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</object></a>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                                <p class="text-head-noti"><b>ห้องประชุม Private ถูกสร้างแล้ว</b></p>
                                                                <p class="fs-13 header-noti">{{ $noti->course_name }}</p>
                                                                <p class="fs-13 header-noti">วันที่ประชุม {{ date('d/m/Y ', strtotime($noti->course_start_date)) }}
                                                                @if(count($noti->course_datetime)>1)
                                                                ถึง {{ date('d/m/Y ', strtotime($noti->course_end_date)) }}
                                                                @endif
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-sm-7" >
                                                                        <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                    </div>
                                                                    <div class="col-sm-7" style="margin-top: -22px; text-align:right;">
                                                                        <a href="{{ URL::to('courses/'.$noti->course_id) }}" class="btn-noti-invate size-noti" style="padding-top: 2px;"><object class="color-noti fs-14">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงทะเบียน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</object></a>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @elseif($noti->noti_type == 'cancel_course_teacher_not')
                                                @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                                <p class="text-head-noti"><b>Open course {{ $noti->classroom_name }} (Private) unsuccessful</b></p>
                                                                <p class="fs-13 header-noti">Because no one pays study fee.</p>
                                                                <p class="fs-13 header-noti">Contact students to re-open the course.</p>
                                                                <div class="row">
                                                                    <div class="col-sm-7" >
                                                                        <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="header-cart-item" style="border-bottom: 1px solid #eee;">
                                                        <div class="header-cart-item-txt">
                                                                <p class="text-head-noti"><b>เปิดห้องประชุม {{$noti->classroom_name }} (Private)  ไม่สำเร็จ</b></p>
                                                                <p class="fs-13 header-noti">เนื่องจากไม่มีผู้เข้าร่วมประชุม</p>
                                                                <p class="fs-13 header-noti">ติดต่อสมาชิกเพื่อเปิดห้องประชุมใหม่อีกครั้ง</p>
                                                                <div class="row">
                                                                    <div class="col-sm-7" >
                                                                        <p class="fs-12" style="margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($noti->created_at)) }}</p>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endif

                                            @php
                                              $show_noti++;
                                            @endphp

                                        @endforeach
                                    @else
                                        <li class="header-cart-item">
                                            <div class="header-cart-item-txt">
                                                    <img src="{{ asset ('suksa/frontend/template/images/icons/img_noti1.png') }}"  style="width: 30px; height: 30px;">
                                                    <span class="linedivide3"></span>
                                                @lang('frontend/layouts/title.noti_not_found')
                                            </div>
                                        </li>
                                    @endif

                                </ul>
                                <div class="header-cart-item-txt" style="padding-top: 10px; text-align: center;">
                                    <input type="text" name="url_alerts_profile" id="url_alerts_profile_2" value="{{$url_alerts_profile}}" style="display:none;">

                                        <button class="btn-outline default btn_url_alerts_profile" >@lang('frontend/layouts/title.see_all_noti')</button>

                                </div>
                            </div>
                        </div>

                        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </div>

                    </div>
                </div>

                <!-- Menu Mobile -->

                <div class="wrap-side-menu">
                    <nav class="side-menu">
                        <ul class="main-menu">
                            @if(!Auth::guard('members')->user())
                            <a href="{{ route('users.create') }}">
                            <li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
                                <span class="topbar-child1 topbar-email">
                                  <i class="fa fa-user" aria-hidden="true" ></i>&nbsp;
                                Sign Up
                                </span>
                            </li>
                            </a>
                            <a href="#" data-toggle="modal" data-target="#myModal">
                                <li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
                                    <span class="topbar-child1 topbar-email">
                                      <i class="fa fa-lock" aria-hidden="true"></i>&nbsp;
                                      Sign In
                                    </span>
                                </li>
                            </a>

                            @else
                            <li class="" aria-hidden="true">
                                <a href="#" style="color: #080808;">
                                    @lang('frontend/layouts/title.hello')
                                    @lang('frontend/layouts/title.you')
                                    {{ Auth::guard('members')->user()->member_fname }} {{ Auth::guard('members')->user()->member_lname }}
                                    <div class="" style="color: #080808; padding-left:17px; padding-bottom:4px;">
                                        <span style="font-size: 14px; color: #e4c200;" class="set_coins"></span>
                                    </div>
                                </a>
                                <ul class="sub-menu">
                                    @if(Auth::guard('members')->user()->member_role =='teacher')
                                        <li class=" p-0 item-topbar-mobile">
                                            <a class="dropdown-item" style="padding: 4px!important; padding-left: 15px!important;" href="{{ url('members/profile/') }}">
                                                <i class="fa fa-user " aria-hidden="true" style="font-size:24px"></i>&nbsp;@lang('frontend/layouts/title.my_profile')
                                            </a>
                                        </li>
                                    @else
                                        <li class=" p-0 item-topbar-mobile">
                                            <a class="dropdown-item" style="padding: 4px!important; padding-left: 15px!important;" href="{{ url('users/profile/') }}" >
                                                <i class="fa fa-user" aria-hidden="true" style="font-size:24px"></i>&nbsp;@lang('frontend/layouts/title.my_profile')
                                            </a>
                                        </li>
                                    @endif

                                    <li class=" p-0 item-topbar-mobile">
                                      <a class="dropdown-item btn_modal_change_password" style="padding: 4px!important; padding-left: 15px!important;" href="#" id="btn_modal_change_password">
                                        <i class="fas fa-lock" aria-hidden="true" style="font-size:24px"></i> &nbsp;@lang('frontend/layouts/title.Change_password')
                                      </a>
                                    </li>

                                    <li class=" p-0 item-topbar-mobile">
                                        <a class="dropdown-item" style="padding: 4px!important; padding-left: 15px!important;" href="{{ url('logout') }}">
                                            <i class="fas fa-sign-out-alt" style="font-size:25px"></i>&nbsp;@lang('frontend/layouts/title.logout')
                                        </a>
                                    </li>
                                </ul>

                                <i class="arrow-main-menu fa fa-angle-right" aria-hidden="true"></i>
                                <input type="hidden" name="member_id" id="member_id" value="{{ Auth::guard('members')->user()->_id }}">
                            </li>
                            @endif
                            <a href="{{ URL::to('/') }}" >
                                <li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
                                    <span class="topbar-child1 topbar-email">
                                    HOME
                                    </span>
                                </li>
                            </a>

                            <li class="">
                                @if(Auth::guard('members')->user())
                                    <a href="#" style="color: #080808;">CONFERENCE ROOM</a>
                                    <ul class="sub-menu">
                                        <li class="p-0 item-topbar-mobile">
                                            <a class="dropdown-item p-4" href="{{ URL::to('courses/all/') }}" style="padding: 4px!important; padding-left: 15px!important;">
                                                All Conference Room
                                            </a>
                                        </li>
                                        @if(Auth::guard('members')->user())
                                        <li class="p-0 item-topbar-mobile">
                                            <a class="dropdown-item p-4" href="{{ URL::to('users/active_course') }}" style="padding: 4px!important; padding-left: 15px!important;">
                                                My Conference Room
                                            </a>
                                        </li>
                                        @endif
                                    </ul>

                                    @if(Auth::guard('members')->user())
                                        <i class="arrow-main-menu fa fa-angle-right" aria-hidden="true"></i>
                                    @endif
                                @else
                                  <li class="">
                                    <a href="#" style="color: #080808;">CONFERENCE ROOM</a>
                                    <ul class="sub-menu" style="display: none;">
                                      <li class="p-0 item-topbar-mobile">
                                          <a class="dropdown-item p-4" href="{{ URL::to('courses/all/') }}" style="padding: 4px!important; padding-left: 15px!important;">
                                              All Conference Room
                                          </a>
                                      </li>
                                      @if(Auth::guard('members')->user())
                                      <li class="p-0 item-topbar-mobile">
                                          <a class="dropdown-item p-4" href="{{ URL::to('users/active_course') }}" style="padding: 4px!important; padding-left: 15px!important;">
                                              My Conference Room
                                          </a>
                                      </li>
                                      @endif
                                    </ul>
                                    <i class="arrow-main-menu fa fa-angle-right" aria-hidden="true"></i>
                                </li>
                                @endif
                              </li>
                          </a>
                      </ul>
                  </nav>
                </div>

            </header>



            <section>
                <div ><hr class="line-header" style="margin-bottom: 0;"/></div>
                <input type="hidden" name="current_lang" id="current_lang" value="{{ Config::get('app.locale') }}">
            </section>



            <!-- Group learning -->

            @include('frontend.alert') {{-- alert แจ้งเตือน --}}

            @yield('content')

            <!-- The Modal -->
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ url('login') }}" method="POST">
                            {{ csrf_field() }}
                            <!-- Modal Header -->
                            <div class="modal-header" style="padding:0px; border-bottom: 0px solid #e9ecef;">

                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm">

                                        </div>
                                        <div class="col-sm" style="text-align: center;">
                                            <img src="{!! asset ('suksa/frontend/template/images/logo_the_at_work.png') !!}" width="200px;">
                                        </div>
                                        <div class="col-sm">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <label>@lang('frontend/layouts/modal.email')</label>
                                <input type="email" name="member_email" class="form-control"  placeholder="@lang('frontend/layouts/modal.enter_email')" required>
                                <br>
                                <label>@lang('frontend/layouts/modal.password')</label>
                                <input type="password" name="member_password" class="form-control"  placeholder="@lang('frontend/layouts/modal.enter_password')" required>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                              <div>
                                <button type="button" class="btn btn-link" id="forgot_password"><u>@lang('frontend/layouts/title.forgot_your_password')</u></button>
                              </div>
                              <div class="text-right col-md-9">
                                <button type="submit" class="btn" style="color: #fff; background-color: #003D99; border-color: #003D99;">@lang('frontend/layouts/modal.login')</button>
                                <button type="button" class="btn" style="color: #003D99; background-color: #fff; border-color: #fff; border-color:#003D99;" data-dismiss="modal">@lang('frontend/layouts/modal.close')</button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="modal_forgot_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="container">
                    <div class="row modal-body" style="margin-left: -15px; margin-right: -15px;">
                      <meta name="csrf-token" content="{{ csrf_token() }}">
                      <div class="col-md-12 text-center">
                        <span style="font-size: 55px;">
                          <i class="fas fa-lock"></i>
                        </span>
                        <h2>@lang('frontend/layouts/title.forgot_your_password')</h2>
                        <br>
                        <div class="form-group text-left p-b-10">
                         <label for="exampleFormControlInput1">@lang('frontend/layouts/modal.enter_email') : <span style="color: red; font-size: 20px;" >* </span></label>
                         <input type="email" class="form-control" id="email_forgot_password" name="email_forgot_password" placeholder="@lang('frontend/layouts/title.enter_the_email_that_is_registered')" autocomplete="off" required>
                       </div>
                        <button type="button" id="btn_post_forgot_password" style="color: #fff; background-color: #003D99; border-color: #003D99;" class="btn col-md-12">@lang('frontend/layouts/title.send_the_password_to_your_email')</button>
                      </div>
                    </div>
                </div>
                </div>
              </div>
            </div>

            <div class="modal fade" id="modal_change_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="container">
                    <div class="row modal-body" style="margin-left: -15px; margin-right: -15px; margin-top: 0px; margin-bottom: 0px;">
                      {{ csrf_field() }}
                      <div class="col-md-12 text-center">
                        <div style="font-size: 55px; height:82px;">
                          <i class="fas fa-lock" style="vertical-align: text-top;"></i>
                        </div>
                        <h2>@lang('frontend/layouts/title.Change_password')</h2>
                        <br>

                        {{-- <div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label for="inputEmail4">Email</label>
                              <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                            </div>
                          </div>
                          <button type="submit" class="btn btn-primary">Sign in</button>
                        </div> --}}

                        <div class="needs-validation" novalidate>
                          <div class="form-group text-left" style="margin-bottom: 16px;">
                            <label for="">@lang('frontend/layouts/title.Current_password')</label>
                            <input type="password" class="form-control current_password_is_valid" name="Current_password" id="Current_password" placeholder="@lang('frontend/layouts/title.Enter_the_current_password')" required>
                            <input type="hidden" name="text_Current_password" value="@lang('frontend/layouts/title.current_password_is_correct')" required>
                            <input type="hidden" name="check_password" id="check_password" value="0">
                          </div>
                          <div class="form-row text-left" style="margin-left: -5px; margin-right: -5px;">
                            <div class="form-group col-md-6" style="margin-bottom: 16px;">
                              <label for="">@lang('frontend/layouts/title.New_password')</label>
                              <input type="password" class="form-control" id="New_password" name="New_password" placeholder="@lang('frontend/layouts/title.Enter_a_new_password')">
                              <input type="hidden" name="text_New_password" value="@lang('frontend/layouts/title.Enter_a_new_password')">
                            </div>
                            <div class="form-group col-md-6" style="margin-bottom: 16px;">
                              <label for="">@lang('frontend/layouts/title.Confirm_password')</label>
                              <input type="password" class="form-control confirm_password_is_valid" id="Confirm_password"  name="Confirm_password"placeholder="@lang('frontend/layouts/title.Enter_the_password_again')" required>
                              <input type="hidden" name="text_Confirm_password" value="@lang('frontend/layouts/title.Confirm_password')" required>
                            </div>
                          </div>
                        </div>
                        <button type="button" id="btn_confirm_password" onclick="forgot_password.confirm_password();" class="btn col-md-12" style="color: #fff; background-color: #003D99; border-color: #003D99;" disabled>@lang('frontend/layouts/title.Confirm_password_change')</button>
                      </div>
                    </div>
                </div>
                </div>
              </div>
            </div>




            <!-- Back to top -->
            <div class="btn-back-to-top bg0-hov" id="myBtn">
                <span class="symbol-btn-back-to-top">
                    <i class="fa fa-angle-double-up" aria-hidden="true"></i>
                </span>
            </div>
        </div>

        <div id="dropDownSelect1"></div>

        <footer class="footer animsition">Copyright © 2020 ATWORK. All rights reserved.</footer>

        <!-- Container Selection1 -->

        <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/animsition/js/animsition.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/bootstrap/js/popper.js') }}"></script>
      <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/select2/select2.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/slick/slick.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset ('suksa/frontend/template/js/slick-custom.js') }}"></script>
      <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/countdowntime/countdowntime.js') }}"></script>
      <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/lightbox2/js/lightbox.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/sweetalert/sweetalert.min.js') }}"></script>

      <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/parallax100/parallax100.js') }}"></script>
      <script src="{{ asset ('suksa/frontend/template/js/main.js') }}"></script>
      <script src="{{ asset ('suksa/frontend/template/js/profileuser.js') }}"></script>
      <script src="{{ asset ('suksa/frontend/template/js/forgot_password.js') }}"></script>
      <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

      <script src="{{ asset ('suksa/frontend/template/js/bootstrap-datetimepicker.js') }}"></script>
      <script src="{{ asset ('suksa/frontend/template/js/bootstrap-datetimepicker.min.js') }}"></script>


    <script>
        $(document).ready(function () {
            //Disable cut copy paste
            $('.header-cart-wrapitem').bind('cut copy paste', function (e) {
                e.preventDefault();
            });

            //Disable mouse right click
            $(".header-cart-wrapitem").on("contextmenu",function(e){
                return false;
            });
        });

        var member_id = $('#member_id').val();

        if(member_id != ''){
            var hostname = '{{ $_SERVER['HTTP_HOST'] }}';
            var my_channel = '';
            var my_event = '';
            var pusher_key = '';
            var lang = $('#current_lang').val();

            //if(location.hostname === "localhost" || location.hostname === "127.0.0.1"){

            if((hostname == "127.0.0.1:8000") || (hostname == "127.0.0.1") || (hostname == "localhost")){
                my_channel = 'localhost-frontend-channel';
                my_event = 'localhost-frontend-event';
                pusher_key = 'b53b849bdf61324a1c28';
            }
            else{ ////theatwork.com
                my_channel = 'production-frontend-channel';
                my_event = 'production-frontend-event';
                pusher_key = '22b57c0b86c24a366500';
            }

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher(pusher_key, {
                cluster: 'ap1',
                forceTLS: true
            });

            var channel = pusher.subscribe(my_channel);
            channel.bind(my_event, function(data) {
                //console.log(data.noti_type);
                var count_member_noti = data.count_member_noti;

                if(member_id == data.member_id){
                    var badge = $('#badge').val();
                    var new_badge = parseInt(badge)+1;

                    if(badge == 0){
                        if(count_member_noti == 1){
                            var header_noti = document.getElementById('header_noti');
                            header_noti.innerHTML = '';
                        }

                        var show_noti = document.getElementById('show_noti');
                        show_noti.innerHTML += '<span class="header-icons-noti">'+new_badge+'</span>';

                        var show_noti_mobile = document.getElementById('show_noti_mobile');
                        show_noti_mobile.innerHTML += '<span class="header-icons-noti" style="margin-right: -23px; margin-top: -3px;">'+new_badge+'</span>';
                    }
                    else{
                        $('.header-icons-noti').text(new_badge);
                    }

                    document.title = '('+new_badge+')'+' Suksa Online';

                    $('#badge').val(new_badge);


                    var header_noti = document.getElementById('header_noti');
                    var header_noti_mobile = document.getElementById('header_noti_mobile');
                    var noti_box = '';

                    if(data.noti_type == 'open_course_teacher'){
                        var url_open_classroom  = '{{ url('classroom/check') }}'+'/'+data.noti_id;
                        if(lang == 'en'){
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><p class="text-head-noti"><b>Close to the time to teach </b></p><p class="fs-13 header-noti">'+data.classroom_name+' of '+data.teacher_fullname+'</p><p class="fs-13 header-noti">Teaching date '+data.classroom_date+' Time '+data.classroom_time_start+'-'+data.classroom_time_end+'</p>'+
                                '<div class="row">'+
                                '<div class="col-sm-7" >'+
                                '<p class="fs-12" style="margin-top: 2px;">'+data.created_at+'</p>'+
                                '</div>'+
                                    '<a href="'+url_open_classroom+'" target="_blank" '+'class="btn-noti size-noti "><object class="color-noti '+'fs-14">Join</object></a>'+
                                '</div>'+
                                '</div></li>';
                        }
                        else{
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><p class="text-head-noti"><b>ใกล้ถึงเวลาเข้าประชุม</b></p><p class="fs-13 header-noti">'+data.classroom_name+' ของคุณ</p><p class="fs-13 header-noti">วันที่ประชุม '+data.classroom_date+' เวลา '+data.classroom_time_start+'-'+data.classroom_time_end+'</p>'+
                                '<div class="row">'+
                                '<div class="col-sm-7" >'+
                                '<p class="fs-12" style="margin-top: 2px;">'+data.created_at+'</p>'+
                                '</div>'+
                                    '<a href="'+url_open_classroom+'" target="_blank" '+'class="btn-noti size-noti" style="padding-top: 2px;"><object class="color-noti '+'fs-14">เข้าร่วม</object></a>'+
                                '</div>'+
                                '</div></li>';
                        }
                    }
                    else if(data.noti_type == 'open_course_student'){
                        var url_open_classroom  = '{{ url('classroom/check') }}'+'/'+data.noti_id;
                        if(lang == 'en'){
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><p class="text-head-noti"><b>Close to the time to study</b></p><p class="fs-13 header-noti">'+data.classroom_name+' with teacher '+data.teacher_fullname+'</p><p class="fs-13 header-noti">Teaching date '+data.classroom_date+' Time '+data.classroom_time_start+'-'+data.classroom_time_end+'</p>'+
                            '<div class="row">'+
                            '<div class="col-sm-7" >'+
                            '<p class="fs-12" style="margin-top: 2px;">'+data.created_at+
                            '</p>'+
                            '</div>'+
                                '<a href="'+url_open_classroom+'" target="_blank" '+
                                'class="btn-noti size-noti "><object class="color-noti '+
                                'fs-14">Join</object></a>'+
                            '</div>'+
                            '</div></li>';
                        }
                        else{
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><p class="text-head-noti"><b>ใกล้ถึงเวลาเข้าประชุม</b></p><p class="fs-13 header-noti">'+data.classroom_name+' กับผู้สอน '+data.teacher_fullname+'</p><p class="fs-13 header-noti">วันที่นัด '+data.classroom_date+' เวลา '+data.classroom_time_start+'-'+data.classroom_time_end+'</p>'+
                            '<div class="row">'+
                            '<div class="col-sm-7" >'+
                            '<p class="fs-12" style="margin-top: 2px;">'+data.created_at+
                            '</p>'+
                            '</div>'+
                                '<a href="'+url_open_classroom+'" target="_blank" '+
                                'class="btn-noti size-noti" style="padding-top: 2px;"><object class="color-noti '+
                                'fs-14">เข้าร่วม</object></a>'+
                            '</div>'+
                            '</div></li>';
                        }
                    }
                    else if(data.noti_type == 'register_course_teacher'){
                        if(lang == 'en'){
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><a href="#"><p class="text-head-noti"><b>Someone register for your course</b></p><p class="fs-13 header-noti">'+data.student_fullname+' register for '+data.classroom_name+'</p><p class="fs-13 header-noti">Teaching date '+data.classroom_datetime+'</p><p class="fs-12 header-noti">'+data.created_at+'</p></a></div></li>';
                        }
                        else{
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><a href="#"><p class="text-head-noti"><b>มีคนเข้าร่วมห้องประชุมของคุณ</b></p><p class="fs-13 header-noti">'+data.student_fullname+' เข้าร่วมประชุม '+data.classroom_name+'</p><p class="fs-13 header-noti">วันที่ประชุม '+data.classroom_datetime+'</p><p class="fs-12 header-noti">'+data.created_at+'</p></a></div></li>';
                        }
                    }
                    else if(data.noti_type == 'register_course_private_teacher'){
                        if(lang == 'en'){
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><a href="#"><p class="text-head-noti"><b>Someone register for your course</b></p><p class="fs-13 header-noti">'+data.student_fullname+' register for '+data.classroom_name+'</p><p class="fs-13 header-noti">Teaching date '+data.classroom_date+'</p><p class="fs-12 header-noti">'+data.created_at+'</p></a></div></li>';
                        }
                        else{
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><a href="#"><p class="text-head-noti"><b>เข้าร่วมประชุมสำเร็จ</b></p><p class="fs-13 header-noti">'+data.student_fullname+' เข้าร่วมประชุม '+data.classroom_name+'</p><p class="fs-13 header-noti">วันที่ประชุม '+data.classroom_date+'</p><p class="fs-12 header-noti">'+data.created_at+'</p></a></div></li>';
                        }
                    }
                    else if(data.noti_type == 'register_course_student'){
                        if(lang == 'en'){
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><a href="#"><p class="text-head-noti"><b>Registration completed</b></p><p class="fs-13 header-noti">You register for '+data.classroom_name+' with teacher '+data.teacher_fullname+'</p><p class="fs-13 header-noti">Teaching date '+data.classroom_datetime+'</p></a></div></li>';
                        }
                        else{
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><a href="#"><p class="text-head-noti"><b>เข้าร่วมประชุมสำเร็จ</b></p><p class="fs-13 header-noti">คุณเข้าร่วมประชุม '+data.classroom_name+'</p><p class="fs-13 header-noti">วันที่ประชุม '+data.classroom_datetime+'</p></a></div></li>';
                        }
                    }
                    else if(data.noti_type == 'register_course_private_student'){
                        if(lang == 'en'){
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><a href="#"><p class="text-head-noti"><b>Registration completed</b></p><p class="fs-13 header-noti">You register for '+data.classroom_name+' with teacher '+data.teacher_fullname+'</p><p class="fs-13 header-noti">Teaching date '+data.classroom_date+'</p></a></div></li>';
                        }
                        else{
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><a href="#"><p class="text-head-noti"><b>เข้าร่วมประชุมสำเร็จ</b></p><p class="fs-13 header-noti">เข้าร่วมประชุม '+data.classroom_name+'</p><p class="fs-13 header-noti">วันที่ประชุม '+data.classroom_date+'</p></a></div></li>';
                        }
                    }
                    else if(data.noti_type == 'invite_course_student'){
                        var url_course  = '{{ url('courses') }}'+'/'+data.course_id;
                        if(lang == 'en'){
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><p class="text-head-noti"><b>Private course created, waiting for payment</b></p><p class="fs-13 header-noti">'+data.course_name+' with teacher '+data.teacher_fullname+'</p><p class="fs-13 header-noti">Teaching date '+data.course_datetime+'</p>'+
                                '<div class="row">'+
                                '<div class="col-sm-7" >'+
                                '<p class="fs-12" style="margin-top: 2px;">'+data.created_at+'</p>'+
                                '</div>'+
                                    '<a href="'+url_course+'" '+'class="btn-noti-invate size-noti"><object class="color-noti '+'fs-14">Pay</object></a>'+
                                '</div>'+
                                '</div></li>';
                        }else{
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><p class="text-head-noti"><b>ห้องประชุม Private ถูกสร้างแล้ว</b></p><p class="fs-13 header-noti">'+data.course_name+'</p><p class="fs-13 header-noti">วันที่ประชุม '+data.course_datetime+'</p>'+
                                '<div class="row">'+
                                '<div class="col-sm-7" >'+
                                '<p class="fs-12" style="margin-top: 2px;">'+data.created_at+'</p>'+
                                '</div>'+
                                    '<a href="'+url_course+'" '+'class="btn-noti-invate size-noti" style="padding-top: 2px;"><object class="color-noti '+'fs-14">ลงทะเบียน</object></a>'+
                                '</div>'+
                                '</div></li>';
                        }
                    }
                    else if(data.noti_type == 'cancel_course_teacher_not'){
                        if(lang == 'en'){
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><p class="text-head-noti"><b>Open course '+data.classroom_name+' (Private) unsuccessful</b></p><p class="fs-13 header-noti">Because no one pays study fee.</p>'+
                                '<p class="fs-13 header-noti">Contact students to re-open the course.</p>'+
                                '<div class="row">'+
                                '<div class="col-sm-7" >'+
                                '<p class="fs-12" style="margin-top: 2px;">'+data.created_at+'</p>'+
                                '</div>'+
                                '</div>'+
                                '</div></li>';
                        }else{
                            noti_box = '<li class="header-cart-item" style="border-bottom: 1px solid #eee;"><div class="header-cart-item-txt"><p class="text-head-noti"><b>เปิดห้องประชุม '+data.classroom_name+' (Private) ไม่สำเร็จ</b></p><p class="fs-13 header-noti">เนื่องจากไม่มีผู้เข้าร่วมประชุม</p>'+
                                '<p class="fs-13 header-noti">ติดต่อสมาชิกเพื่อเปิดห้องประชุมใหม่อีกครั้ง</p>'+
                                '<div class="row">'+
                                '<div class="col-sm-7" >'+
                                '<p class="fs-12" style="margin-top: 2px;">'+data.created_at+'</p>'+
                                '</div>'+
                                '</div>'+
                                '</div></li>';
                        }
                    }

                    // if(count_member_noti > 1){
                    //     noti_box += '<hr>';
                    // }

                    header_noti.insertAdjacentHTML("afterbegin", noti_box);
                    header_noti_mobile.insertAdjacentHTML("afterbegin", noti_box);
                }
            });
        }

        $('.clear-badge').click(function() {
            $.ajax({
                url:"{{ route('frontend.clear_badge') }}",
                method:"POST",
                data:{
                    member_id: $('#member_id').val(),
                    _token: $('input[name="_token"]').val()
                },
                success:function(result){
                    if(result > 0){
                        var show_noti = document.getElementById('show_noti');
                        show_noti.innerHTML = '';

                        var show_noti_mobile = document.getElementById('show_noti_mobile');
                        show_noti_mobile.innerHTML = '';

                        $('#badge').val('0');
                        document.title = 'Suksa Online';
                    }
                }
            });
        });

        $('#datepicker').datetimepicker({
            uiLibrary: 'bootstrap4',
            format: "dd MM yyyy - hh:ii",
            autoclose: true,
            todayBtn: true,
            pickerPosition: "bottom-left"
        });
        // $('#datepicker01').datetimepicker({
        //     uiLibrary: 'bootstrap4',
        //     formatdate: "dd MM yyyy",
        //     autoclose: true,
        //     todayBtn: true,
        //     pickerPosition: "bottom-left"

        // });
        $('#datepicker02').datetimepicker({
            uiLibrary: 'bootstrap4',
            formatViewType: 'time',
            autoclose: true,
            startView: 1,
            maxView: 1,
            minView: 0,
            todayBtn: true,
            minuteStep: 5,
            format: 'hh:ii'
        });
        $('#datepicker03').datetimepicker({
            uiLibrary: 'bootstrap4',
            formatViewType: 'time',
            autoclose: true,
            startView: 1,
            maxView: 1,
            minView: 0,
            todayBtn: true,
            minuteStep: 5,
            format: 'hh:ii'
        });

        $('#start_Date').datetimepicker({
          uiLibrary: 'bootstrap4',
          lang:'th',
          format: 'dd/mm/yyyy',
          minView: "month",
          language: "fr",
          autoclose: true,
        });

        $('.start_Date').datetimepicker({
          uiLibrary: 'bootstrap4',
          lang:'th',
          format: 'dd/mm/yyyy',
          minView: "month",
          language: "fr",
          autoclose: true,
        });

        $("#start_time").datetimepicker({
          uiLibrary: 'bootstrap4',
          formatViewType: 'time',
          autoclose: true,
          startView: 1,
          maxView: 1,
          minView: 0,
          todayBtn: true,
          minuteStep: 5,
          format: 'hh:ii'
        });

        $('#datepicker_profile').datetimepicker({
          uiLibrary: 'bootstrap4',
          lang:'th',
          format: 'dd/mm/yyyy',
          minView: "month",
          language: "fr",
          autoclose: true,
        });

        // $('#start_Date').datetimepicker({
        //     format : "HH:mm",
        //     use24hours: true
        // });


        window.addEventListener("load", activateStickyFooter);

        function activateStickyFooter() {
          // adjustFooterCssTopToSticky();
          // window.addEventListener("resize", adjustFooterCssTopToSticky);
        }

        // function adjustFooterCssTopToSticky() {
        //   const footer = document.querySelector("#footer");
        //   const bounding_box = footer.getBoundingClientRect();
        //   const footer_height = bounding_box.height;
        //   const window_height = window.innerHeight;
        //   const above_footer_height = bounding_box.top - getCssTopAttribute(footer);
        //   if (above_footer_height + footer_height <= window_height) {
        //     const new_footer_top = window_height - (above_footer_height + footer_height);
        //     footer.style.top = new_footer_top + "px";
        //   } else if (above_footer_height + footer_height > window_height) {
        //     footer.style.top = null;
        //   }
        // }

        function getCssTopAttribute(htmlElement) {
          const top_string = htmlElement.style.top;
          if (top_string === null || top_string.length === 0) {
            return 0;
          }
          const extracted_top_pixels = top_string.substring(0, top_string.length - 2);
          return parseFloat(extracted_top_pixels);
        }

        LOREM_IPSUM_SENTENCES = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla viverra libero nibh, nec egestas mauris gravida non. Cras mattis, lacus ac ornare congue, augue felis volutpat nisi, ac lacinia eros libero quis urna. Praesent efficitur ex justo, sit amet condimentum leo elementum ac. Praesent lobortis id lacus non euismod. Pellentesque non ullamcorper nisi. Pellentesque iaculis urna ligula, vitae venenatis enim consequat id. Aliquam consequat egestas tellus. Aliquam erat volutpat. Interdum et malesuada fames ac ante ipsum primis in faucibus. In eu tortor eget sapien eleifend dignissim. Ut pretium nibh enim, eu cursus eros imperdiet id. Vestibulum aliquet finibus nisl nec blandit. Sed tempor id elit eu aliquet. Sed volutpat sodales maximus. Suspendisse dictum mauris rutrum nisl pretium gravida.".split(".");
        LOREM_IPSUM_INDEX = 1;

        function addContent() {
          const page_content = document.querySelector("#page-content");
          const text_node = document.createTextNode(LOREM_IPSUM_SENTENCES[LOREM_IPSUM_INDEX]);
          const div = document.createElement("div");
          div.appendChild(text_node);
          page_content.appendChild(div);
          LOREM_IPSUM_INDEX = (LOREM_IPSUM_INDEX + 1) % (LOREM_IPSUM_SENTENCES.length - 1);
          // reajust the footer
          adjustFooterCssTopToSticky();
        }

        $(function() {
            $('.btn_url_alerts_profile').click(function () {
              var valorAccion = $("input[name='url_alerts_profile']").val();
              var member_role = '{{ $member_role }}';

              if(member_role == 'teacher'){
                window.location.href = valorAccion+'/#alerts';
              }
              else{
                window.location.href = valorAccion+'/#user_alerts';
              }
            });
        });

    </script>
    @stack('scripts')


  </body>
</html>
