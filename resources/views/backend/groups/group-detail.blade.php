@extends('backend.layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('groups/title.edit')
@parent
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        รายละเอียดกลุ่มความถนัด
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                @lang('Dashboard')
            </a>
        </li>
        <li>จัดการความถนัด</li>
        <li class="active">รายละเอียดกลุ่มความถนัด</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="wrench" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        รายละเอียดกลุ่มความถนัด
                    </h4>
                </div>
                <div class="panel-body">
                    @if($aptitude)
                    <form class="form-horizontal" role="form" method="post" action="">
                            <!-- CSRF Token -->
                            <input name="_method" type="hidden" value="PUT">
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->
                                first('name', 'has-error') }}">
                                <label for="title" class="col-sm-2 control-label">
                                    ชื่อกลุ่มความถนัด<br> (ภาษาไทย)
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="aptitude_name" name="aptitude_name_th" class="form-control" value="{{ old('name', $aptitude->aptitude_name_th) }}" disabled 
                                           placeholder=@lang('groups/form.name') >
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->
                                first('name', 'has-error') }}">
                                <label for="title" class="col-sm-2 control-label">
                                    ชื่อกลุ่มความถนัด<br> (ภาษาอังกฤษ)
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="aptitude_name" name="aptitude_name_en" class="form-control" value="{{ old('name', $aptitude->aptitude_name_en) }}" disabled 
                                           placeholder=@lang('groups/form.name') >
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                    <div class="row">
                                    <label for="title" class="col-sm-2 control-label">
                                            วิชาที่ถนัด
                                    </label>
                                    <div class="col-sm-10">
                                    <div class="row">
                                    @foreach($aptitude->detail as $subject)
                                        <div class="col-md-4">
                                            <input type="checkbox" checked disabled>&nbsp;{{ $subject }}
                                        </div>
                                    @endforeach
                                    </div>
                                    </div>
                                    </div>
                            </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('groups.index') }}">
                                    กลับ
                                </a>
                            </div>
                        </div>
                    </form>
                    @else
                        <h1>@lang('groups/message.error.no_aptitude_exists')</h1>
                            <a class="btn btn-danger" href="{{ route('groups.index') }}">
                                @lang('button.back')
                            </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>

@stop
