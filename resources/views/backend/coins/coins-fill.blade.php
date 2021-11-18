 @extends('backend.layouts/default')

@section('title')
จัดการ coins
@parent
@stop

@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<style>
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
        <li class="active">เติม coins</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        เติม coins
                    </h4>
                </div>
                <div class="panel-body">
                        <div class="table-responsive">
                          <table class="table table-bordered" id="example" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                      <th style="width: 10%;">ลำดับ</th>
                                      <th style="width: 12.8%;">ชื่อนักเรียน</th>
                                      <th style="width: 11%;">จำนวนเงิน</th>
                                      <th style="width: 12.8%;">ธนาคาร</th>
                                      <th style="width: 14.4%;">วันเวลาทำรายการ</th>
                                      <th style="width: 12.8%;">สถานะ</th>
                                      <th style="width: 12.8%;">หมายเหตุ</th>
                                      <th style="width: 12.8%;">จัดการ</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($coins as $i => $coin)
                                  <tr>
                                      <td>{!! ++$i !!}</td>
                                      <td>{!! $coin->member_fname." ".$coin->member_lname !!}</td>
                                      <td>{!! $coin->coin_number !!}</td>
                                      <td>{!! $coin->coin_bank_name_th !!}</td>
                                      <td>{!! date('d/m/Y', strtotime($coin->coin_date))." ".substr($coin->coin_time,0,5) !!}</td>
                                          @if($coin->coin_status==0)
                                          <td style="color: #F89A14; font-weight: bold;">
                                              &#9679; รออนุมัติ
                                          @elseif($coin->coin_status==1)
                                          <td style="color: rgb(108, 198, 108);  font-weight: bold;">
                                              &#9679; อนุมัติแล้ว
                                          @else
                                          <td style=" color: red;  font-weight: bold;">
                                              &#9679; ไม่อนุมัติ
                                          @endif
                                      </td>
                                      <td class="text-center">
                                          @if($coin->coin_status == 2)
                                            <i class="livicon " id="{!! $coin->_id !!}" onclick="note_description(this.id)" data-name="warning" data-size="20" data-c="#CC0000" data-hc="#CC0000" data-loop="true" data-toggle="modal" data-target="#note" data-note="" ></i>
                                          @endif
                                      </td>
                                      </td>
                                      <td align="center">
                                        @if (!empty($coin->coins_description))
                                          @php
                                            $coins_description = $coin->coins_description;
                                          @endphp
                                        @else
                                          @php
                                            $coins_description = "-";
                                          @endphp
                                        @endif
                                          <button
                                          class="btn btn-info btn_modal_description"
                                          data-button='{
                                            "data_coinid" : "{!! $coin->_id !!}",
                                            "data_memberid" : "{!! $coin->member_id !!}",
                                            "data_fname" : "{!! $coin->member_fname !!}",
                                            "data_lname" : "{!! $coin->member_lname !!}",
                                            "data_bank" : "{!! $coin->coin_bank_name_th !!}",
                                            "data_date" : "{!! date('d/m/Y', strtotime($coin->coin_date)) !!}",
                                            "data_time" : "{!! $coin->coin_time !!}",
                                            "data_number" : "{!! $coin->coin_number !!}",
                                            "data_slip" : "{!! $coin->coin_slip !!}",
                                            "data_status" : "{!! $coin->coin_status !!}",
                                            "data_description" : "{!! $coins_description !!}"
                                          }'
                                          >รายละเอียด</button>
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

<div class="modal fade" id="Modal_Description">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="Modal_Description">
                รายละเอียดการเติม Coins
            </h4>
        </div>

        <div class="modal-body">
          {{ csrf_field() }}

          <div class="row" style="padding-top: 0px; padding-bottom: 0px;">
              <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 text-right">
                  <label for="" class="text-left" >ธนาคาร :</label>
              </div>
              <div class="col-sm-auto col-xs-auto">
                  <span class="bank"></span>
              </div>
          </div>

          <div class="row" style="padding-top: 0px; padding-bottom: 0px;">
              <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 text-right ">
                  <label for="" class="text-left">ชื่อ-สกุล :</label>
              </div>
              <div class="col-sm-auto col-xs-auto">
                  <span class="fname"></span> &nbsp; <span class="lname"><span>
              </div>
          </div>

          <div class="row" style="padding-top: 0px; padding-bottom: 0px;">
                  <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 text-right ">
                  <label for="" class="text-left">วัน-เวลาที่ชำระ :</label>
                   </div>
                    <div class="col-sm-auto col-xs-auto">
                  <span  class="date" ></span>
              </div>
          </div>

          <div class="row" style="padding-top: 0px; padding-bottom: 0px;">
                  <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 text-right ">
                  <label for="" class="text-left">จำนวน Coins :</label>
                   </div>
                    <div class="col-sm-auto col-xs-auto">
                  <span  class="number" ></span>
              </div>
          </div>

          <div class="row" style="padding-top: 0px; padding-bottom: 0px;">
                  <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 text-right ">
                  <label for="" class="text-left">สลิปโอนเงิน :</label>
                   </div>
                    <div class="col-sm-auto col-xs-auto" style=" padding-left: 0px;">
                   <img src="" class="slip" width="50%" />
              </div>
          </div>

          <div class="modal-footer form-row" id="button">
            <div class="row" style="text-align: center;">
                <div class="col-sm-6 col-xs-6 text-right">
                  <p id="notconfirm" class="btn btn-danger">ไม่อนุมัติ</p>
                </div>
                <div class="col-sm-6 col-xs-6 text-left">
                  <p id="confirm"></p>
                </div>
              </div>

          </div>

        </div>
    </div>
  </div>
</div>

<div class="modal" id="modal_annotation">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title text-center" id="exampmodal_annotation">
              <h1 class="oxide2" align="center" style="font-weight: bold;  font-size: 25px;" > หมายเหตุไม่อนุมัติ  </h1>
          </h4>
      </div>

      <div class="modal-body">
        {{ csrf_field() }}
        <div class="row" style="padding-top: 0px; padding-bottom: 0px;">
          <div class="form-group">
            <label for="description">ระบุรายละเอียด : </label>
            <input type="email" id="input_description" class="form-control" value="">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_confirm_description" class="btn btn-primary">บันทึก</button>
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
    <script src="{{ asset('assets/js/filterDropDown.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>
    <script>
        $(document).ready(function() {
                $('#example').DataTable({
                    scrollX: true,
                    filterDropDown: {
                        columns: [
                            {
                                idx: 5
                            }
                        ],
                        bootstrap: true
                    }
                } );
            } );
    </script>
<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
<script>

    var coins_data = {
      data : false,
    }
    $('.btn_modal_description').click(function (event) {

      var button_data = $.parseJSON($(this).attr('data-button'));
      $('#Modal_Description').modal('show');

      var coinid = button_data.data_coinid;
      var memberid = button_data.data_memberid;
      var fname = button_data.data_fname;
      var lname = button_data.data_lname;
      var bank = button_data.data_bank;
      var date = button_data.data_date;
      var time = button_data.data_time;
      var number = button_data.data_number;
      var slip = button_data.data_slip;
      var status = button_data.data_status;
      var modal = $(this)

      $('.modal-body .coinid').val(coinid)
      $('.modal-body .memberid').val(memberid)
      $('.modal-body .coin_number').val(number)
      $('.modal-body .fname').text(fname)
      $('.modal-body .lname').text(lname)
      $('.modal-body .bank').text(bank);
      $('.modal-body .date').text(date+' '+moment(time,'HH:mm').format('HH:mm'))
      $('.modal-body .time').text(time)
      $('.modal-body .number').text(number)
      $('.modal-body .slip').attr('src','{!! asset ("storage/slip/'+ slip +'") !!}');
      $('#confirm').html('<a href="confirm/'+ coinid +'" class="btn btn-success" >อนุมัติ</a>');

      ////////-------------------------------------------------------------------------

      if(status!=0){
          document.getElementById('button').style.display = "none";
      }else{
          document.getElementById('button').style.display = "block";
      }

      coins_data.data = {
        'coinid' :  button_data.data_coinid,
        'memberid' :  button_data.data_memberid,
        'fname' :  button_data.data_fname,
        'lname' :  button_data.data_lname,
        'bank' :  button_data.data_bank,
        'date' :  button_data.data_date,
        'time' :  button_data.data_time,
        'number' :  button_data.data_number,
        'slip' :  button_data.data_slip,
        'status' :  button_data.data_status,
      }


    })

    $('#notconfirm').click(function (e) {
      $('#Modal_Description').modal('hide');
    });

    $('#notconfirm').click(function (e) {
      $('#Modal_Description').modal('hide');
      setTimeout(function () {
        $('#modal_annotation').modal('show');
      }, 500);
    });

    $('#btn_confirm_description').click(function (e) {
      if ($('#input_description').val() == "") {
        Swal.fire({
          type: 'info',
          title: 'กรุณา กรอกรายละเอียด',
          confirmButtonText : 'ปิด'
        })
      }else {
        Swal.fire({
            title: 'Loading..',
            timer: 1000,
            onBeforeOpen: () => {
              Swal.showLoading()
            },
          });
        $.ajax({
          url: "/backend/coins/notconfirm/",
          method:'post',
          data:{
              data: coins_data,
              input: $('#input_description').val(),
              _token: $('input[name="_token"]').val()
          },
          success:function(data) {
              // console.log(data);
              $('#modal_annotation').modal('hide');
              Swal.close();

              Swal.fire({
                type: 'success',
                title: 'ไม่อนุมัติการเติม Coins',
                showConfirmButton: false,
              })

              setTimeout(function () {
                location.reload();
              }, 1000);

              setTimeout(function () {
                $('#modal_annotation').modal('hide');
                $("#example").load();
              }, 100);

          },
        });
      }

    });

    function note_description(coin_id) {
      // alert(coin_id);
      $.ajax({
        url: "/backend/coins/get_description/"+coin_id,
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
