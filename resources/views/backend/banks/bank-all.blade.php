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
    <h1>จัดการบัญชีธนาคาร   </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                @lang('Dashboard')
            </a>
        </li>
        <li><a href="#"> จัดการบัญชีธนาคาร</a></li>
        <li class="active">บัญชีธนาคาร</li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        บัญชีธนาคาร
                    </h4>
                    <div class="pull-right">
                        <a href="{{ route('banks.create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> เพิ่มบัญชี</a>
                    </div>
                </div>
                <br />
                <div class="panel-body">
                        <div class="table-responsive">
                        <table class="table table-bordered " id="table">
                            <thead>
                                <tr class="filters">
                                    <th>ลำดับ</th>
                                    {{-- <th>โลโก้</th> --}}
                                    <th>ธนาคาร</th>
                                    <th>ชื่อบัญชี</th>
                                    <th>หมายเลขบัญชี</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banks as $i => $bank)
                                <tr>
                                    <td>{!! ++$i !!}</td>
                                    {{-- <td><img src="{{ asset('storage/bank_logo/'.$bank->bank_img) }}" style="width: 100px; height: 100px; object-fit: cover;"></td> --}}
                                    <td>{{ $bank->bank_name_th }}</td>
                                    <td>{{ $bank->account_name }}</td>
                                    <td>{{ $bank->bank_account_number }}</td>
                                    <td align="center">
                                        <form action="{{ route('banks.destroy',$bank->id) }}" method="POST">
                                        <a href="{{ route('banks.show', $bank->id) }}" class="btn btn-responsive button-alignment btn-success"><i class="fa fa-pencil-square-o"></i>แก้ไข</a>
                                            <input name="_method" type="hidden" value="DELETE">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-responsive button-alignment btn-danger"><i class="fa fa-times"></i>ลบ</button>
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
