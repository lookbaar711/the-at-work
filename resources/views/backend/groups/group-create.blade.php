@extends('backend.layouts/default')

{{-- Web site Title --}}
@section('title')
    @lang('admin/groups/title.create')
    @parent
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>เพิ่มกลุ่มความถนัด</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                @lang('Dashboard')
            </a>
        </li>
        <li>จัดการความถนัด</li>
        <li class="active">เพิ่มกลุ่มความถนัด</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="users-add" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        เพิ่มกลุ่มความถนัด
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
                    <form id="group_create" class="form-horizontal" role="form" method="post" action="{{ route('groups.store') }}">
                        <!-- CSRF Token -->

                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->
                            first('name', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                ชื่อกลุ่มความถนัด<br> (ภาษาไทย)
                                <span style="color: red; font-size: 15px;">* </span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="aptitude_name_th" name="aptitude_name_th" class="form-control" placeholder="ป้อนชื่อกลุ่มความถนัดภาษาไทย"
                                       value="{!! old('aptitude_name_th') !!}" required>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('name', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->
                            first('name', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                ชื่อกลุ่มความถนัด<br> (ภาษาอังกฤษ)
                                <span style="color: red; font-size: 15px;">* </span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="aptitude_name_en" name="aptitude_name_en" class="form-control" placeholder="ป้อนชื่อกลุ่มความถนัดภาษาอังกฤษ"
                                       value="{!! old('aptitude_name_en') !!}" required>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('name', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        <div class="form-group">
                                <div class="row">
                                <label for="title" class="col-sm-2 control-label">
                                    วิชาที่ถนัด
                                <span style="color: red; font-size: 15px;">* </span>
                                </label>
                                <div class="col-sm-10">
                                <div class="row">
                                @foreach($subjects as $item)
                                    <div class="col-md-4">
                                        <input type="checkbox" name="aptitude_subject[]" class="subject-checkbox" value="{{ $item->id }}" >&nbsp;{{ $item->subject_name_th }}
                                    </div>
                                @endforeach
                                </div>
                                </div>
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('groups.index') }}">
                                    @lang('ยกเลิก')
                                </a>
                                <button id="submit_form" class="btn btn-success">
                                    @lang('บันทึก')
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

@section('footer_scripts')
<script>
    $('#submit_form').click(function() {
        if($('.subject-checkbox:checked').length > 0){
            document.getElementById("group_create").submit();
        }
        //ถ้าไม่มีการเลือกวิชาเลย ให้แจ้งเตือนให้เลือก
        else{
            if(($('#aptitude_name_th').val()!='') && ($('#aptitude_name_en').val()!='')){
                Swal.fire({
                    type: 'warning',
                    title: 'กรุณาเลือกวิชาที่ถนัด',
                    confirmButtonText : 'ปิด'
                });

                return false;
            }
        }
    });
</script>
@stop