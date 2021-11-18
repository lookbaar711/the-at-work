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
    <h1>จัดการความถนัด</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                @lang('Dashboard ')
            </a>
        </li>
        <li><a href="#">จัดการความถนัด</a></li>
        <li class="active">กลุ่มความถนัด</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        กลุ่มความถนัด
                    </h4>
                    <div class="pull-right">
                    <a href="{{ route('groups.create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('เพิ่มกลุ่มความถนัด')</a>
                    </div>
                </div>
                <br />
                <div class="panel-body">
                    @if ($aptitudes->count() >= 1)
                        <div class="table-responsive">

                        <table class="table table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">ลำดับ</th>
                                    <th>ชื่อกลุ่มความถนัด(ภาษาไทย)</th>
                                    <th>ชื่อกลุ่มความถนัด(ภาษาอังกฤษ)</th>
                                    <th>จำนวนวิชา</th>
                                    <th style="width: 250px;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aptitudes as $i => $aptitude)
                                <tr>
                                    <td>{!! ++$i !!}</td>
                                    <td>{!! $aptitude->aptitude_name_th !!}</td>
                                    <td>{!! $aptitude->aptitude_name_en !!}</td>
                                    <td>
                                        {!! count($aptitude->aptitude_subject) !!} วิชา
                                    </td>
                                    <td align="center">
                                        <form action="{{ route('groups.destroy',$aptitude->id) }}" method="POST">
                                            <a href="{{ route('groups.detail', $aptitude->id) }}" class="btn btn-warning">รายละเอียด</a>
                                        <a href="{{ route('groups.show', $aptitude->id) }}" class="btn btn-responsive button-alignment btn-success"><i class="fa fa-pencil-square-o"></i>แก้ไข</a>
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input name="id" type="hidden" value="{{ $aptitude->id }}">
                                        {{ csrf_field() }}
                                        {{-- <button type="submit" class="btn btn-responsive button-alignment btn-danger"><i class="fa fa-times"></i>ลบ</button> --}}
                                        
                                        </a>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    @else
                        @lang('general.noresults')
                    @endif   
                </div>
            </div>
        </div>
    </div>    <!-- row-->
</section>
@foreach ($aptitudes as $i => $item)
<div class="modal fade" id="myModal-{{++$i}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">
                        รายละเอียด
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">                                                                  
                        @foreach ($item->subject_name as $name)
                            {{$name->subject_name}}, 
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        ปิด
                    </button>
                </div>
            </div>
        </div>
</div>
@endforeach


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
<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
<div class="modal fade" id="users_exists" tabindex="-2" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                @lang('groups/message.users_exists')
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});
    $(document).on("click", ".users_exists", function () {

        var group_name = $(this).data('name');
        $(".modal-header h4").text( group_name+" Group" );
    });

    $('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text('New message to ' + recipient)
    modal.find('.modal-li').text(recipient)
    modal.find('.modal-body input').val(recipient)
    })
</script>
@stop
