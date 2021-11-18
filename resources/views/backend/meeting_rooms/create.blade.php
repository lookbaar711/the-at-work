@extends('backend.layouts/default')

{{-- Web site Title --}}
@section('title')
    เพิ่มข้อมูลห้องประชุม
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
        เพิ่มข้อมูลห้องประชุม
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                @lang('Dashboard')
            </a>
        </li>
        <li>จัดการห้องประชุม</li>
        <li class="active">
            เพิ่มข้อมูลห้องประชุม
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
                        เพิ่มข้อมูลห้องประชุม
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
                    <form class="form-horizontal" role="form" method="post" action="{{ route('meeting_rooms.store') }}" enctype="multipart/form-data">
                        <!-- CSRF Token -->

                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->
                            first('meeting_room_name', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                ชื่อห้องประชุม
                                <span style="color: red; font-size: 15px;">* </span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="name" name="meeting_room_name" class="form-control" placeholder="ชื่อห้องประชุม" value="{!! old('meeting_room_name') !!}" required>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('meeting_room_name', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->
                            first('meeting_room_detail', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                รายละเอียด
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="name" name="meeting_room_detail" class="form-control" placeholder="รายละเอียด"
                                       value="{!! old('meeting_room_detail') !!}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('meeting_room_detail', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->
                            first('meeting_room_start_date', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                วันที่เริ่มต้น
                                <span style="color: red; font-size: 15px;">* </span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" name="meeting_room_start_date" class="form-control datetimepicker-input" id="meeting_room_start_date" placeholder="DD/MM/YYYY" data-date-format="DD/MM/YYYY" autocomplete="off" value="{!! old('meeting_room_start_date') !!}" required>
                            </div>

                            <div class="col-sm-4">
                                {!! $errors->first('meeting_room_start_date', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->
                            first('meeting_room_end_date', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                วันที่สิ้นสุด
                                <span style="color: red; font-size: 15px;">* </span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" name="meeting_room_end_date" class="form-control datetimepicker-input" id="meeting_room_end_date" placeholder="DD/MM/YYYY" data-date-format="DD/MM/YYYY" autocomplete="off" value="{!! old('meeting_room_end_date') !!}" required>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('meeting_room_end_date', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('meeting_rooms.index') }}">
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

        $("#meeting_room_start_date").datetimepicker({
            format: 'DD/MM/YYYY',
            widgetPositioning:{
                vertical:'bottom'
            },
            keepOpen:false,
            useCurrent: false,
            minDate: today
        });

        $("#meeting_room_end_date").datetimepicker({
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
