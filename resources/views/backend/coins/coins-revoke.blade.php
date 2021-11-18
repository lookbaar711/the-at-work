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
        <li class="active">ถอน coins</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        ถอน coins
                    </h4>
                </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                        <table class="table table-bordered" id="example">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">ลำดับ</th>
                                    <th >ชื่อ-สกุล</th>
                                    <th >จำนวนเงิน</th>
                                    <th >ธนาคาร</th>
                                    <th >เลขบัญชี</th>
                                    <th >วันเวลาทำรายการ</th>
                                    <th >สถานะ</th>
                                    <th >หมายเหตุ</th>
                                    <th style="width: 20%;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                  @foreach ($withdraws as $i => $withdraw)
                                  <tr>
                                      <td>{!! ++$i !!}</td>
                                      <td>{!! $withdraw->member_fname." ".$withdraw->member_lname !!}</td>
                                      <td>{!! $withdraw->withdraw_coin_number !!}</td>
                                      <td>{!! $withdraw->member_bank_name_th !!}</td>
                                      <td>{!! $withdraw->member_account_number !!}</td>
                                      <td>{!! date('d/m/Y', strtotime($withdraw->withdraw_date))." ".substr($withdraw->withdraw_time,0,5) !!}</td>
                                      @if($withdraw->withdraw_status==0)
                                      <td style="color: #F89A14; font-weight: bold;">
                                          &#9679; รออนุมัติ
                                      @elseif($withdraw->withdraw_status==1)
                                      <td style="color: rgb(108, 198, 108);  font-weight: bold;">
                                          &#9679; อนุมัติแล้ว
                                      @else
                                      <td style=" color: red;  font-weight: bold;" >
                                          &#9679; ไม่อนุมัติ
                                      @endif
                                      </td>
                                      <td class="text-center">
                                        @if($withdraw->withdraw_status == 2)
                                          <i class="livicon " id="{!! $withdraw->_id !!}" onclick="note_description_revoke(this.id)" data-name="warning" data-size="20" data-c="#CC0000" data-hc="#CC0000" data-loop="true" data-toggle="modal" data-target="#note" data-note="" ></i>
                                        @endif
                                      </td>
                                      <td align="center">
                                          @if($withdraw->withdraw_status==0)
                                              <button id="{!! $withdraw->_id !!}" onclick="open_modal_revoke(this.id)"  class="btn btn-danger btn_modal_description_revoke"
                                                data-button='{
                                                "data_withdrawid" : "{!! $withdraw->_id !!}",
                                                "data_member_id" : "{!! $withdraw->member_id  !!}",
                                                "data_member" : "{!! $withdraw->member_fname." ".$withdraw->member_lname !!}",
                                                "data_coin_number" : "{!! $withdraw->withdraw_coin_number !!}",
                                                "data_bank" : "{!!  $withdraw->withdraw_bank!!}",
                                                "data_withdraw_account_number" : "{!! $withdraw->withdraw_account_number !!}"
                                              }'>ไม่อนุมัติ</button>
                                              <a href="{{route("coins.confirmrevoke", $withdraw->id)}}" class="btn btn-success">อนุมัติ</a>
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

<div class="modal" id="modal_annotation_revoke">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title text-center" id="exampmodal_annotation_revoke">
            <h1 class="oxide2" align="center" style="font-weight: bold;  font-size: 25px;" > หมายเหตุไม่อนุมัติ  </h1>
          </h4>
      </div>
      
      @if(count($withdraws) > 0)
        <div class="modal-body">
          {{ csrf_field() }}
          <div class="row" style="padding-top: 0px; padding-bottom: 0px;">
            <div class="form-group">
              <label for="description">ระบุรายละเอียด : </label>
              <input type="text" id="input_description_revoke" class="form-control" value="">
              <input type="text" id="member_id" class="form-control" value="{!! $withdraw->member_id !!}" style="display:none;">
              <input type="text" id="withdraw_coin_number" class="form-control" value="{!! $withdraw->withdraw_coin_number !!}" style="display:none;">
              <input type="text" id="withdraw_id" class="form-control" value="" style="display:none;">
            </div>
          </div>
        </div>
      @endif

      <div class="modal-footer">
        <button type="button btn_confirm_description_revoke" value="" onclick="modal_revoke()" class="btn btn-primary">บันทึก</button>
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
              <h1 class="oxide2" align="center" style="font-weight: bold;  font-size: 25px;" > หมายเหตุไม่อนุมัติ  </h1>
          </h4>
      </div>

      <div class="modal-body">

        <div class="form-group row">
            <label for="inputEmail" class="col-sm-3 col-form-label text-right">ระบุรายละเอียด : </label>
            <div class="col-sm-9">
              <label class="input_description_view"></label>
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

    var withdraw_data = {
      data : false,
    }

    $('.btn_modal_description_revoke').click(function (event) {
      var button_data = $.parseJSON($(this).attr('data-button'));
      // console.log(button_data);
      withdraw_data.data = {
        'data_withdrawid' :  button_data.data_withdrawid,
        'data_member_id' : button_data.data_member_id,
        'data_member' :  button_data.data_member,
        'data_coin_number' :  button_data.data_coin_number,
        'data_bank' :  button_data.data_bank,
        'data_withdraw_account_number' :  button_data.data_withdraw_account_number,
      }
    })

    $(document).ready(function() {
        $('#example').DataTable({
            filterDropDown: {
                columns: [
                    {
                        idx: 6
                    }
                ],
                bootstrap: true
            }
        });
    });

    function open_modal_revoke(id) {
      setTimeout(function () {
        $('#modal_annotation_revoke').modal('show');
      }, 500);
      $('#withdraw_id').val(id);
    };

    function modal_revoke(id) {
      if ($('#input_description_revoke').val() == "") {
        Swal.fire({
          type: 'info',
          title: 'กรุณา กรอกรายละเอียด',
          confirmButtonText : 'ปิด'
        })
      }else {

      $.ajax({
        url: "/backend/coins/notconfirmrevoke/",
        method:'post',
        data:{
            id: $('#withdraw_id').val(),
            member_id: withdraw_data.data.data_member_id,
            withdraw_coin_number: withdraw_data.data.data_coin_number,
            input: $('#input_description_revoke').val(),
            _token: $('input[name="_token"]').val()
        },
        success:function(data) {
            // console.log(data);
            Swal.fire({
              type: 'success',
              title: 'ไม่อนุมัติการเติม Coins',
              showConfirmButton: false,
            })

            setTimeout(function () {
              location.reload();
            }, 1000);

            setTimeout(function () {
              $('#modal_annotation_revoke').modal('hide');
              $("#example").load();
            }, 100);

        },
      });

      }
    };

    function note_description_revoke(coin_id) {

      $.ajax({
        url: "/backend/coins/get_description_revoke/"+coin_id,
        method:'get',
        success:function(data) {
            // console.log(data);
            $('#modal_annotation_view').modal('show');
            setTimeout(function () {
              $('.input_description_view').html(data[0].coins_description == undefined ? "-":data[0].coins_description);
            }, 100);

            $('#btn_confirm_description_view').click(function (e) {
              $('#modal_annotation_view').modal('hide');
            });





        },
      });
    }

</script>

@stop
