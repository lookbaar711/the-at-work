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
    <h1>จัดการห้องประชุม</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                @lang('Dashboard')
            </a>
        </li>
        <li><a href="#">จัดการห้องประชุม</a></li>
        <li class="active">ห้องประชุม</li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        ห้องประชุม
                    </h4>
                    <div class="pull-right">
                        {{-- <a href="{{ route('meeting_rooms.create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> เพิ่มห้องประชุม</a> --}}
                    </div>
                </div>
                <br />
                <div class="panel-body">
                        <div class="table-responsive">
                        <table class="table table-bordered " id="table">
                            <thead>
                                <tr class="filters">
                                    <th>ลำดับ</th>
                                    <th>ชื่อห้องประชุม</th>
                                    <th>ผู้เปิดห้องประชุม</th>
                                    <th>วันที่เริ่มต้น</th>
                                    <th>วันที่สิ้นสุด</th>
                                    <th>สถานะ</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($meeting_rooms as $i => $meeting_room)
                                <tr>
                                    <td>{!! ++$i !!}</td>
                                    <td>{{ $meeting_room->meeting_room_name }}</td>
                                    <td>{{ $meeting_room->meeting_room_owner_name }}</td>
                                    <td>{{ date('d/m/Y', strtotime($meeting_room->meeting_room_start_date)) }}</td>
                                    <td>{{ date('d/m/Y', strtotime($meeting_room->meeting_room_end_date)) }}</td>
                                    
                                    @if($meeting_room->meeting_room_status == 0)
                                        <td style="color: #F89A14; font-weight: bold;">
                                        &#9679; รอเปิดห้องสอน</td>
                                    @elseif($meeting_room->meeting_room_status == 1)
                                        <td style="color: rgb(108, 198, 108);  font-weight: bold;">
                                        &#9679; กำลังเปิดห้องสอน</td>
                                    @else
                                        <td style=" color: red;  font-weight: bold;">
                                        &#9679; ปิดห้องสอน</td>
                                    @endif
                                    
                                    <td align="center">
                                        <form action="{{ route('meeting_rooms.destroy',$meeting_room->id) }}" method="POST">
                                            {{ csrf_field() }}

                                            @if($meeting_room->meeting_room_status == 0)
                                                <button class="btn btn-success openMeetingRoom" data-meeting-room-id="{!! $meeting_room->_id !!}">เปิด</button>

                                                <a href="{{ route('meeting_rooms.edit', $meeting_room->id) }}" class="btn btn-responsive button-alignment btn-success"><i class="fa fa-pencil-square-o"></i>แก้ไข</a>
                                                <input name="_method" type="hidden" value="DELETE">
                                                
                                                <button type="submit" class="btn btn-responsive button-alignment btn-danger"><i class="fa fa-times"></i>ลบ</button>

                                            @elseif($meeting_room->meeting_room_status == 1)
                                                <button class="btn btn-success openMeetingRoom" data-meeting-room-id="{!! $meeting_room->_id !!}">เปิด</button>

                                                <button class="btn btn-secondary" disabled><i class="fa fa-pencil-square-o"></i>แก้ไข</button>
                                                
                                                <button class="btn btn-secondary" disabled><i class="fa fa-times"></i>ลบ</button>
                                            @else
                                                <button class="btn btn-secondary" disabled>เปิด</button>

                                                <button class="btn btn-secondary" disabled><i class="fa fa-pencil-square-o"></i>แก้ไข</button>
                                                
                                                <button class="btn btn-secondary" disabled><i class="fa fa-times"></i>ลบ</button>
                                            @endif
                                                  
                                            {{-- <a href="{{ route('meeting_rooms.edit', $meeting_room->id) }}" class="btn btn-responsive button-alignment btn-success"><i class="fa fa-pencil-square-o"></i>แก้ไข</a>
                                                <input name="_method" type="hidden" value="DELETE">
                                                {{ csrf_field() }}
                                            <button type="submit" class="btn btn-responsive button-alignment btn-danger"><i class="fa fa-times"></i>ลบ</button> --}}
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


    <div class="modal fade" id="open_meeting_room_confirm" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Open Meeting Room</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}

                </div>
                <div class="modal-body">
                    คุณต้องการเปิดห้องประชุมนี้ใช่หรือไม่ ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                    <a href="#" id="open_meeting_room" class="btn btn-primary">เปิด</a>
                </div>
            </div>
        </div>
    </div>

@stop

{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>
    <script>
        $(document).ready( function () {
            $('#table').DataTable();
        } );

        $(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});
        $(document).on("click", ".users_exists", function () {

            var group_name = $(this).data('name');
            $(".modal-header h4").text( group_name+" Group" );
        });

        $(document).on('click','.openMeetingRoom',function(){
            var meeting_room_id = $(this).attr('data-meeting-room-id');

            var obj = document.getElementById('open_meeting_room');
            obj.setAttribute('href', window.location.href+'/open_meeting_room/'+meeting_room_id);

            $('#open_meeting_room_confirm').modal('show');

            return false;
        });
    </script>

@stop
