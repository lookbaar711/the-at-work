@extends('backend.layouts/default')

@section('title')
    จัดการ coins
    @parent
@stop
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
    <style>
      .dot {
        height: 25px;
        width: 25px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
      }

      td, th {
          white-space: nowrap;
      }
    </style>

@stop
{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>จัดการ coins</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                @lang('Dashboard')
            </a>
        </li>
        <li><a href="#"> จัดการ coins</a></li>
        <li class="active">จัดการขอคืนเงิน</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        ขอคืนเงิน
                    </h4>
                </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                        <table class="table table-bordered" id="example">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">ลำดับ</th>
                                    <th>ชื่อ-สกุล</th>
                                    <th>คอร์สเรียน</th>
                                    {{-- <th>จำนวน Coins</th> --}}
                                    <th>เหตุผล</th>
                                    <th>วันเวลาทำรายการ</th>
                                    <th>สถานะ</th>
                                    <th>หมายเหตุ</th>
                                    <th style="width: 20%;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                  @foreach ($refunds as $i => $refund)
                                  <tr>
                                      <td>{!! ++$i !!}</td>
                                      <td>{!! $refund->member_fullname !!}</td>
                                      <td>{!! $refund->course_name !!}</td>
                                      {{-- <td>{!! number_format($refund->course_price) !!}</td> --}}
                                      <td>{!! $refund->refund_reason !!}</td>
                                      <td>{!! date('d/m/Y H:i', strtotime($refund->created_at)) !!}</td>
                                      @if($refund->refund_status==0)
                                      <td style="color: #F89A14; font-weight: bold;">
                                          &#9679; รออนุมัติ
                                      @elseif($refund->refund_status==1)
                                      <td style="color: rgb(108, 198, 108);  font-weight: bold;">
                                          &#9679; อนุมัติแล้ว
                                      @else
                                      <td style=" color: red;  font-weight: bold;" >
                                          &#9679; ไม่อนุมัติ
                                      @endif
                                      </td>
                                      <td class="text-center">
                                        @if($refund->refund_status != 0)
                                          <i class="livicon " id="{!! $refund->_id !!}" onclick="note_description_refund(this.id)" data-name="warning" data-size="20" data-c="#CC0000" data-hc="#CC0000" data-loop="true" data-toggle="modal" data-target="#note" data-note="" ></i>
                                        @endif
                                      </td>
                                      <td align="center">
                                          @if($refund->refund_status==0)
                                              <button id="{!! $refund->_id !!}" onclick="open_modal_notconfirm_refund(this.id)"  class="btn btn-danger btn_modal_description_refund"
                                                data-button='{
                                                "data_refund_id" : "{!! $refund->_id !!}",
                                                "data_member_id" : "{!! $refund->member_id  !!}",
                                                "data_course_id" : "{!! $refund->course_id !!}",
                                                "data_course_name" : "{!! $refund->course_name !!}",
                                                "data_course_price" : "{!! $refund->course_price !!}"
                                              }'>ไม่อนุมัติ</button>

                                              <button id="{!! $refund->_id !!}" onclick="open_modal_confirm_refund(this.id)"  class="btn btn-success btn_modal_description_refund"
                                                data-button='{
                                                "data_refund_id" : "{!! $refund->_id !!}",
                                                "data_member_id" : "{!! $refund->member_id  !!}",
                                                "data_course_id" : "{!! $refund->course_id !!}",
                                                "data_course_name" : "{!! $refund->course_name !!}",
                                                "data_course_price" : "{!! $refund->course_price !!}"
                                              }'>อนุมัติ</button>

                                              {{-- <a href="{{route("coins.confirmrefund", $refund->_id)}}" class="btn btn-success">อนุมัติ</a> --}}
                                          @else
                                              <button class="btn btn-default">ไม่อนุมัติ</button>
                                              <button class="btn btn-default">อนุมัติ</button>
                                          @endif
                                      </td>
                                  </tr>
                                  @endforeach
                                
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>    <!-- row-->
</section>

<div class="modal" id="modal_annotation_confirm_refund">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title text-center" id="exampmodal_annotation_refund">
            <h1 class="oxide2" align="center" style="font-weight: bold;  font-size: 25px;" > หมายเหตุ  </h1>
          </h4>
      </div>
      
      @if(count($refunds) > 0)
        <div class="modal-body">
          {{ csrf_field() }}
          <div class="row" style="padding-top: 0px; padding-bottom: 0px;">
            <div class="form-group">
              <label for="description">ระบุรายละเอียด : </label>
              <input type="text" id="refund_confirm_description" class="form-control" value="">
            </div>
          </div>
        </div>
      @endif

      <div class="modal-footer">
        <button type="button btn_confirm_description_refund" value="" onclick="modal_confirm_refund()" class="btn btn-primary">บันทึก</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal_annotation_notconfirm_refund">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title text-center" id="exampmodal_annotation_refund">
            <h1 class="oxide2" align="center" style="font-weight: bold;  font-size: 25px;" > หมายเหตุ  </h1>
          </h4>
      </div>
      
      @if(count($refunds) > 0)
        <div class="modal-body">
          {{ csrf_field() }}
          <div class="row" style="padding-top: 0px; padding-bottom: 0px;">
            <div class="form-group">
              <label for="description">ระบุรายละเอียด : </label>
              <input type="text" id="refund_notconfirm_description" class="form-control" value="">
            </div>
          </div>
        </div>
      @endif

      <div class="modal-footer">
        <button type="button btn_confirm_description_refund" value="" onclick="modal_notconfirm_refund()" class="btn btn-primary">บันทึก</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal_annotation_view">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title text-center" id="exampmodal_annotation_view">
              <h1 class="oxide2" align="center" style="font-weight: bold;  font-size: 25px;" > หมายเหตุ  </h1>
          </h4>
      </div>

      <div class="modal-body">

        <div class="form-group row">
            <label for="inputEmail" class="col-sm-3 col-form-label text-right">ระบุรายละเอียด : </label>
            <div class="col-sm-9">
              <label class="refund_description_view"></label>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" id="btn_confirm_description_view" class="btn btn-danger">ปิด</button>
      </div>
    </div>
  </div>
</div>
@stop

{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
<script src="{{ asset('assets/js/filterDropDown.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>
<script>

    var refund_data = {
      data : false,
    }

    $('.btn_modal_description_refund').click(function (event) {
      var button_data = $.parseJSON($(this).attr('data-button'));
      // console.log(button_data);
      refund_data.data = {
        'data_refund_id' :  button_data.data_refund_id,
        'data_member_id' : button_data.data_member_id,
        'data_course_id' :  button_data.data_course_id,
        'data_course_name' :  button_data.data_course_name,
        'data_course_price' :  button_data.data_course_price,
      }

      //alert(refund_data.data.data_member_id);
    })

    $(document).ready(function() {
        $('#example').DataTable({
            filterDropDown: {
                columns: [
                    {
                        idx: 5
                    }
                ],
                bootstrap: true
            }
        });
    });

    function open_modal_confirm_refund(id) {
      setTimeout(function () {
        $('#modal_annotation_confirm_refund').modal('show');
      }, 500);
      $('#refund_id').val(id);
    };

    function open_modal_notconfirm_refund(id) {
      setTimeout(function () {
        $('#modal_annotation_notconfirm_refund').modal('show');
      }, 500);
      $('#refund_id').val(id);
    };

    function modal_confirm_refund(id) {
      if ($('#refund_confirm_description').val() == "") {
        Swal.fire({
          type: 'info',
          title: 'กรุณากรอกรายละเอียด',
          confirmButtonText : 'ปิด'
        })
      }else {

      $.ajax({
        url: "/backend/coins/confirmrefund/",
        method:'post',
        data:{
            refund_id: refund_data.data.data_refund_id,
            member_id: refund_data.data.data_member_id,
            course_id: refund_data.data.data_course_id,
            course_name: refund_data.data.data_course_name,
            course_price: refund_data.data.data_course_price,
            refund_description: $('#refund_confirm_description').val(),
            _token: $('input[name="_token"]').val()
        },
        success:function(data) {

            //alert(data);

            if(data=='success'){
              //console.log(data);
              Swal.fire({
                type: 'success',
                title: 'อนุมัติการขอคืนเงิน',
                showConfirmButton: false,
              })

              setTimeout(function () {
                location.reload();
              }, 1000);

              setTimeout(function () {
                $('#modal_annotation_confirm_refund').modal('hide');
                $("#example").load();
              }, 100);
            }
        },
      });

      }
    };

    function modal_notconfirm_refund(id) {
      if ($('#refund_notconfirm_description').val() == "") {
        Swal.fire({
          type: 'info',
          title: 'กรุณากรอกรายละเอียด',
          confirmButtonText : 'ปิด'
        })
      }else {

      $.ajax({
        url: "/backend/coins/notconfirmrefund/",
        method:'post',
        data:{
            refund_id: refund_data.data.data_refund_id,
            member_id: refund_data.data.data_member_id,
            course_id: refund_data.data.data_course_id,
            course_name: refund_data.data.data_course_name,
            course_price: refund_data.data.data_course_price,
            refund_description: $('#refund_notconfirm_description').val(),
            _token: $('input[name="_token"]').val()
        },
        success:function(data) {

            //alert(data);

            if(data=='success'){
              //console.log(data);
              Swal.fire({
                type: 'success',
                title: 'ไม่อนุมัติการขอคืนเงิน',
                showConfirmButton: false,
              })

              setTimeout(function () {
                location.reload();
              }, 1000);

              setTimeout(function () {
                $('#modal_annotation_notconfirm_refund').modal('hide');
                $("#example").load();
              }, 100);
            }
            

        },
      });

      }
    };

    function note_description_refund(refund_id) {

      $.ajax({
        url: "/backend/coins/get_description_refund/"+refund_id,
        method:'get',
        success:function(data) {
            console.log(data);
            $('#modal_annotation_view').modal('show');
            setTimeout(function () {
              $('.refund_description_view').html(data.refund_description == undefined ? "-":data.refund_description);
            }, 100);

            $('#btn_confirm_description_view').click(function (e) {
              $('#modal_annotation_view').modal('hide');
            });
        },
      });
    }

</script>

@stop
