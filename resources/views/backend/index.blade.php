@extends('backend.layouts.default')

{{-- Page title --}}
@section('title')
    dashboard
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/fullcalendar/css/fullcalendar.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/pages/calendar_custom.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" media="all" href="{{ asset('assets/vendors/bower-jvectormap/css/jquery-jvectormap-1.2.2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendors/animate/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/only_dashboard.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/buttons.css') !!}">
    <meta name="_token" content="{{ csrf_token() }}">
@stop

{{-- Page content --}}
@section('content')

    <section class="content-header">
        <h1>Dashboard</h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="#">
                    <i class="livicon" data-name="home" data-size="16" data-color="#333" data-hovercolor="#333"></i>
                    Dashboard
                </a>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInLeftBig">
                <!-- Trans label pie charts strats here-->
                <div class="lightbluebg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-xs-12 pull-left nopadmar">
                            <div class="row">
                                <div class="square_box col-xs-7 text-right">
                                    <span>อาจารย์รออนุมัติ</span>

                                    <div class="number" id="">{{$data[0]}}</div>
                                </div>
                                <a href="{{ URL::to('backend/members/new') }}" ><i class="livicon  pull-right" data-name="users-add" data-l="true" data-c="#fff"
                                   data-hc="#fff" data-s="70"></i></a>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <small class="stat-label">คน</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInUpBig">
                <!-- Trans label pie charts strats here-->
                <div class="redbg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-xs-12 pull-left nopadmar">
                            <div class="row">
                                <div class="square_box col-xs-7 pull-left">
                                    <span>อาจารย์</span>
                                    <div class="number" id="">{{$data[1]}}</div>
                                </div>
                                <a href="{{ URL::to('backend/members/all') }}"  ><i class="livicon pull-right" data-name="users" data-l="true" data-c="#fff"
                                   data-hc="#fff" data-s="70"></i></a>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <small class="stat-label">คน</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 margin_10 animated fadeInDownBig">
                <!-- Trans label pie charts strats here-->
                <div class="goldbg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-xs-12 pull-left nopadmar">
                            <div class="row">
                                <div class="square_box col-xs-7 pull-left">
                                    <span>วิชาที่มีในระบบ</span>

                                    <div class="number" >{{$data[2]}}</div>
                                </div>
                                <a href="{{ URL::to('subject') }}" ><i class="livicon pull-right" data-name="edit" data-l="true" data-c="#fff"
                                   data-hc="#fff" data-s="70"></i></a>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <small class="stat-label">วิชา</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInRightBig">
                <!-- Trans label pie charts strats here-->
                <div class="palebluecolorbg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-xs-12 pull-left nopadmar">
                            <div class="row">
                                <div class="square_box col-xs-7 pull-left">
                                    <span>กลุ่มความถนัด</span>
                                    <div class="number" id="">8</div>
                                </div>
                                <a href="{{ URL::to('groups') }}" ><i class="livicon pull-right" data-name="address-book" data-l="true" data-c="#fff"
                                   data-hc="#fff" data-s="70"></i></a>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <small class="stat-label">กลุ่ม</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/row-->
        <div class="clearfix"></div>
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/moment/js/moment.min.js') }}"></script>
@stop