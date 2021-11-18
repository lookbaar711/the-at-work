@extends('backend.layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('groups/title.management')
@parent
@stop

@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop
{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>@lang(' จัดการความถนัด')</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                @lang('Dashboard')
            </a>
        </li>
        <li><a href="#"> @lang('จัดการความถนัด')</a></li>
        <li class="active">@lang('วิชา')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('รายวิชา')
                    </h4>
                    <div class="pull-right">
                        <a href="{{ route('subjects.create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> เพิ่มวิชา</a>
                    </div>
                </div>
                <br />
                <div class="panel-body">
                        <div class="table-responsive">
                        <table class="table table-bordered " id="table">
                            <thead>
                                <tr class="filters">
                                    <th>ลำดับ</th>
                                    <th>ชื่อวิชา (ภาษาไทย)</th>
                                    <th>ชื่อวิชา (ภาษาอังกฤษ)</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subject as $i => $subject)
                                <tr>
                                    <td>{!! ++$i !!}</td>
                                    <td>{{ $subject->subject_name_th }}</td>
                                    <td>{{ $subject->subject_name_en }}</td>
                                    <td align="center">
                                        <form action="{{ route('subjects.destroy',$subject->id) }}" method="POST">
                                        <a href="{{ route('subjects.show', $subject->id) }}" class="btn btn-responsive button-alignment btn-success"><i class="fa fa-pencil-square-o"></i>แก้ไข</a>
                                            <input name="_method" type="hidden" value="DELETE">
                                            {{ csrf_field() }}
                                            {{-- <button type="submit" class="btn btn-responsive button-alignment btn-danger"><i class="fa fa-times"></i>ลบ</button> --}}
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                </div>
            </div>
    </div>    <!-- row-->
</section>




@stop

{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>
    <script>
        $(document).ready( function () {
            $('#table').DataTable();
        } );
    </script>
<script>
    $(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});
    $(document).on("click", ".users_exists", function () {

        var group_name = $(this).data('name');
        $(".modal-header h4").text( group_name+" Group" );
    });</script>
@stop
