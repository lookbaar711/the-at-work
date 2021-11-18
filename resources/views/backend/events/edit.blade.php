@extends('backend.layouts/default')

{{-- Web site Title --}}
@section('title')
    แก้ไขข้อมูลอีเว้นท์
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">

     <style type="text/css">
        .datetimepicker-input {
            background: url(../../../suksa/frontend/template/images/calendar_icon.png) no-repeat right 5px center;
            background-color: #FFFFFF; 
        }
    </style>
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        แก้ไขข้อมูลอีเว้นท์
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                @lang('Dashboard')
            </a>
        </li>
        <li>จัดการอีเว้นท์</li>
        <li class="active">
            แก้ไขข้อมูลอีเว้นท์
        </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="users-add" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        แก้ไขข้อมูลอีเว้นท์
                    </h4>
                </div>
                <div class="panel-body">
                    {!! $errors->first('slug', '<span class="help-block">Another role with same slug exists, please choose another name</span> ') !!}
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="post" action="{{ route('events.update', $event->id) }}" enctype="multipart/form-data">
                        <!-- CSRF Token -->
                        <input name="_method" type="hidden" value="PUT">
                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->
                            first('name', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                ชื่ออีเว้นท์
                                <span style="color: red; font-size: 15px;">* </span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="name" name="event_name" class="form-control" placeholder="ชื่ออีเว้นท์" value="{!! $event->event_name !!}" required>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('event_name', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->
                            first('name', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                รายละเอียด
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="name" name="event_detail" class="form-control" placeholder="รายละเอียด"
                                       value="{!! $event->event_detail !!}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('event_detail', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->
                            first('event_location', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                สถานที่จัดงาน
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="name" name="event_location" class="form-control" placeholder="สถานที่จัดงาน"
                                       value="{!! $event->event_location !!}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('event_location', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->
                            first('event_start_date', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                วันที่เริ่มต้น
                                <span style="color: red; font-size: 15px;">* </span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="event_start_date" name="event_start_date" class="form-control datetimepicker-input" placeholder="DD/MM/YYYY" data-date-format="DD/MM/YYYY" autocomplete="off" value="{!! date('d/m/Y', strtotime($event->event_start_date)) !!}" required>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('event_start_date', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->
                            first('event_end_date', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                วันที่สิ้นสุด
                                <span style="color: red; font-size: 15px;">* </span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="event_end_date" name="event_end_date" class="form-control datetimepicker-input" placeholder="DD/MM/YYYY" data-date-format="DD/MM/YYYY" autocomplete="off" value="{!! date('d/m/Y', strtotime($event->event_end_date)) !!}" required>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('event_end_date', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('events.index') }}">
                                    ยกเลิก
                                </a>
                                <button type="submit" class="btn btn-success">
                                    บันทึก
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" ></script>
    <script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

        $("#event_start_date").datetimepicker({
            format: 'DD/MM/YYYY',
            widgetPositioning:{
                vertical:'bottom'
            },
            keepOpen:false,
            useCurrent: false,
            minDate: today
        });

        $("#event_end_date").datetimepicker({
            format: 'DD/MM/YYYY',
            widgetPositioning:{
                vertical:'bottom'
            },
            keepOpen:false,
            useCurrent: false,
            minDate: today
        });
    </script>
@stop
