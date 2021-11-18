@extends('backend.layouts/default')

@section('title')
จัดการ classroom
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
        <li><a href="#"> จัดการห้องประชุม</a></li>
        <li class="active">จัดการห้องประชุม</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        จัดการห้องประชุม
                    </h4>
                </div>
                <div class="panel-body">
                        <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">ลำดับ</th>
                                    <th>ชื่อการประชุม</th>
                                    <th>ชื่อผู้จัด</th>
                                    <th>วันที่เริ่มประชุม</th>
                                    <th>เวลาที่เริ่มประชุม</th>
                                    <th>จำนวนผู้เข้าร่วม</th>
                                    <th>สถานะ</th>
                                    <th style="width: 30px;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($classroom->count() >= 1)
                                    @foreach ($classroom as $i => $item)
                                    <tr>
                                        <td>{!! ++$i !!}</td>

                                        {{-- @if ($condition) --}}

                                        {{-- @endif --}}
                                        <td>{!! $item->classroom_name !!}</td>
                                        <td>{!! $item->classroom_teacher['teacher_fname'].' '.$item->classroom_teacher['teacher_lname'] !!}</td>
                                        <td>{!! date('d/m/Y', strtotime($item->classroom_date))!!}</td>
                                        <td>{!! substr($item->classroom_time_start,0,5)." - ".substr($item->classroom_time_end,0,5) !!}</td>
                                        <td>{!! count($item->classroom_student) !!}</td>
                                        @if($item->classroom_status == 0)
                                          @if (date('Y-m-d H:i', strtotime($item->classroom_date." ".$item->classroom_time_end)) < date("Y-m-d H:i"))
                                            <td style=" color: red;  font-weight: bold;">
                                            &#9679; ปิดห้องประชุม
                                          @else
                                            <td style="color: #F89A14; font-weight: bold;">
                                            &#9679; รอเปิดห้องประชุม
                                          @endif
                                        @elseif($item->classroom_status == 1)
                                          @if (date('Y-m-d H:i', strtotime($item->classroom_date." ".$item->classroom_time_end)) < date("Y-m-d H:i"))
                                            <td style=" color: red;  font-weight: bold;">
                                            &#9679; ปิดห้องประชุม
                                          @else
                                            <td style="color: rgb(108, 198, 108);  font-weight: bold;">
                                            &#9679; กำลังเปิดห้องประชุม
                                          @endif
                                        @else
                                            <td style=" color: red;  font-weight: bold;">
                                            &#9679; ปิดห้องประชุม
                                        @endif
                                        </td>
                                        <td align="center">
                                          @if($item->classroom_status == 0)
                                            @if (date('Y-m-d H:i', strtotime($item->classroom_date." ".$item->classroom_time_end)) < date("Y-m-d H:i"))
                                              <button class="btn btn-secondary" disabled>เปิด</button>
                                            @else
                                              <button class="btn btn-success openClassRoom" data-classroom_id="{!! $item->course_id !!}">เปิด</button>
                                            @endif
                                          @elseif($item->classroom_status == 1)
                                            @if (date('Y-m-d H:i', strtotime($item->classroom_date." ".$item->classroom_time_end)) < date("Y-m-d H:i"))
                                              <button class="btn btn-secondary" disabled>เปิด</button>
                                            @else
                                              <button class="btn btn-success openClassRoom" data-classroom_id="{!! $item->course_id !!}">เปิด</button>
                                            @endif
                                          @else
                                            <button class="btn btn-secondary" disabled>เปิด</button>
                                          @endif
                                        {{-- @if(date('Y-m-d H:i') < date('Y-m-d H:i', strtotime($item->classroom_date." ".$item->classroom_time_start))) --}}
                                            {{-- <button class="btn btn-success openClassRoom" data-classroom_id="{!! $item->course_id !!}">เปิด</button> --}}
                                        {{-- @else
                                            <button class="btn btn-default" >เปิด</button>
                                        @endif --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>    <!-- row-->
</section>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">
                        รายละเอียดการเติม classroom
                    </h4>
                </div>
                <form action="{{ url('backend/classroom/confirm') }}" method="POST" >
                <div class="modal-body">
                {{ csrf_field() }}
                <input type="hidden" class="coinid" value="" name="coin_id" >
                <input type="hidden" class="memberid" value="" name="member_id" >
                <input type="hidden" class="coin_number" value="" name="coin_number" >
                <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">ธนาคาร :</label>
                        <div class="col-sm-3">
                            <img src="" class="bank" width="50px;"/>
                        </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">ชื่อ-สกุล :</label>
                    <div class="col-sm-3">
                        <label class="fname"></label>
                    </div>
                    <div class="col-sm-3">
                            <label class="lname"></label>
                        </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">วันที่ชำระ :</label>
                    <div class="col-sm-3">
                            <label  class="date" ></label>
                        </div>
                        <label for="" class="col-sm-3 col-form-label">วันที่ชำระ :</label>
                            <label  class="time" ></label>
                </div>
                <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">จำนวน Coisn :</label>
                        <div class="col-sm-3">
                            <label  class="number" ></label>
                        </div>
                    </div>
                     <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">สลิปการชำระ :</label>
                    <div class="col-sm-3">
                            <div class="col-sm-5">
                                    <img src="" class="slip"/>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        ปิด
                    </button>
                    <button type="submit" class="btn btn-success pull-right" >
                        ยืนยัน
                    </button>
                </div>
            </div>
        </form>
        </div>
    </div>


    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
        </div>
      </div>
    </div>






@stop

{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
<script src="{{ asset('assets/js/filterDropDown.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>
    <script>
        $(document).ready(function() {
                $('#table').DataTable({
                    // Definition of filter to display
                    filterDropDown: {
                        columns: [
                            {
                                idx: 6
                            }
                        ],
                        bootstrap: true
                    }
                } );
            } );
    </script>


    <div class="modal fade" id="open_class_room_confirm" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Open Class Room</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}

                </div>
                <div class="modal-body">
                    คุณต้องการเปิดห้องประชุมนี้ใช่หรือไม่ ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                    <a href="#" id="open_class_room" class="btn btn-primary">เปิด</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });


        $(document).on('click','.openClassRoom',function(){
            var classroom_id = $(this).attr('data-classroom_id');

            var obj = document.getElementById('open_class_room');
            obj.setAttribute('href', window.location.href+'/open_class_room/'+classroom_id);

            $('#open_class_room_confirm').modal('show');
        });
    </script>

<script type="text/javascript">
    @if(session('bbb_status')=='เปิดห้องประชุมนี้เรียบร้อยแล้ว')
        Swal.fire({
            title: '<strong>{{session('bbb_status')}}</u></strong>',
            type: 'success',
            imageHeight: 100,
            showCloseButton: true,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'ปิดหน้าต่าง',
        });
    @elseif(session('bbb_status')!='')     
        Swal.fire({
            title: '<strong>{{session('bbb_status')}}</u></strong>',
            type: 'error',
            imageHeight: 100,
            showCloseButton: true,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'ปิดหน้าต่าง',
        });
    @endif

    @php 
        Session::forget('bbb_status'); 
    @endphp
</script>


@stop
