@extends('backend.layouts/default')

{{-- Web site Title --}}
@section('title')
    @lang('admin/subject/title.create')
    @parent
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        เพิ่มวิชา
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                @lang('Dashboard')
            </a>
        </li>
        <li>จัดการความถนัด</li>
        <li class="active">
            เพิ่มวิชา
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
                        เพิ่มวิชา
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
                    <form class="form-horizontal" role="form" method="post" action="{{ route('subjects.store') }}">
                        <!-- CSRF Token -->

                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->
                            first('name', 'has-error') }}">
                            <label for="title" class="col-sm-3 control-label">
                                ชื่อวิชา (ภาษาไทย)
                                <span style="color: red; font-size: 15px;">* </span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="name" name="subject_name_th" class="form-control" placeholder="ชื่อวิชา (ภาษาไทย)" value="{!! old('name') !!}" required>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('name', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->
                            first('name', 'has-error') }}">
                            <label for="title" class="col-sm-3 control-label">
                                ชื่อวิชา (ภาษาอังกฤษ)
                                <span style="color: red; font-size: 15px;">* </span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="name" name="subject_name_en" class="form-control" placeholder="ชื่อวิชา (ภาษาอังกฤษ)" value="{!! old('name') !!}" required>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('name', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('subjects.index') }}">
                                    ยกเลิก
                                </a>
                                <button type="submit" class="btn btn-success">
                                    ตกลง
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
