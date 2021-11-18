@extends('backend.layouts/default')

{{-- Page title --}}
@section('title')
อาจารย์ใหม่

@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/mss.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .pre {
    font-size: .7rem;
    margin: 0;
}
</style>
@stop
{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>อาจารย์รออนุมัติ</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#">จัดการอาจารย์</a></li>
        <li class="active">อาจารย์รออนุมัติ</li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading">
                <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    รายชื่ออาจารย์รออนุมัติ
                </h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                <table class="table table-bordered " id="table">
                    <thead>
                        <tr>
                            <th style="width: 10px;">ลำดับ</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>Email</th>
                            <th>วันเวลาที่ลงทะเบียน</th>
                            <th>สถานะ</th>
                            <th style="width: 10px;">หมายเหตุ</th>
                            <th style="width: 100px;">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                     @foreach ($members as $i => $member)
                        <tr>
                            <td>{!! ++$i !!}</td>
                            <td>{!! $member->member_fname ." ". $member->member_lname !!}</td>
                            <td>{!! $member->member_email !!}</td>
                            <td>{!! $member->created_at->format('d/m/Y H:i') !!}</td>
                            @if($member->member_status==0)
                                <td style="color: #F89A14; font-weight: bold;">
                                    &#9679; รอการอนุมัติ
                            @else
                                <td style="color: red;  font-weight: bold;">
                                    &#9679; ไม่อนุมัติ
                            @endif
                            </td>
                            <td align="center">
                                @if($member->member_status==2 || $member->member_status==4)
                                <i class="livicon" data-name="warning" data-size="20" data-c="#CC0000" data-hc="#CC0000" data-loop="true" data-toggle="modal" data-target="#note" data-note="{{$member->member_note}}" ></i>
                                @endif
                            </td>
                            <td>
                                <div align="center">
                                    <button class="btn btn-success"  data-toggle="modal" data-target="#myModal"
                    onclick=" educ( {{ json_encode($member->member_education) }},
                                    {{json_encode($member->member_exp)}},
                                    {{json_encode($member->member_cong)}},
                                    {{json_encode($member->detail_aptitude)}},
                                    {{json_encode($member->member_file) }},
                                    {{$member->member_strlenPass}} )"
                                    data-card="{!! $member->member_idCard !!}"
                                    data-email="{!! $member->member_email !!}"
                                    data-sername="{!! $member->member_sername !!}"
                                    data-fname="{!! $member->member_fname !!}"
                                    data-lname="{!! $member->member_lname !!}"
                                    data-nickname="{!! $member->member_nickname !!}"
                                    data-day="{!! $member->member_Bday->format('d/m/Y') !!}"
                                    data-line="{!! $member->member_idLine !!}"
                                    data-tell="{!! $member->member_tell !!}"
                                    data-address="{!! $member->member_address !!}"
                                    data-id="{!! $member->id !!}"
                                    data-event_name="{!! $member->event_name !!}"
                                    {{-- data-promotion_code="{!! $member->promotion_code !!}" --}}
                                    data-status="{!! $member->member_status !!}"
                                    data-rate="{!! number_format($member->member_rate_start)."-".number_format($member->member_rate_end)." Coins/ชั่วโมง" !!}"
                                    >รายละเอียด</button>
                                    {{-- <a href="{!! url("backend/members/notallowed/".$member->id) !!}" class="btn btn-danger">ไม่อนุมัติ</a> --}}
                                </div>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">
                            <h1 class="oxide2" align="center" style="font-weight: bold; font-size: 25px;" > ข้อมูลผู้สอน  </h1>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row col-12" >
                            <form>
                                    <label  class="oxide">&nbsp;ข้อมูลเข้าสู่ระบบ</label>
                                      <div class="form-group">
                                        <div class="col-sm-12" style="padding-bottom: 10px;">
                                          <div class="col-md-12">
                                            <div class="col-sm-12">
                                                <label class="control-label">อีเมล : </label> <object id="email"></object>
                                            </div>
                                            <div class="col-sm-12">
                                                <label class="control-label">รหัสผ่าน : </label> <object id="pass" ></object>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    <label class="oxide">&nbsp;ข้อมูลส่วนตัว</label>
                                    <div class="form-group">
                                      <div class="col-sm-12" style="padding-bottom: 10px;">
                                        <div class="col-md-12">
                                          <div class="col-sm-12">
                                              <label class="control-label">เลขบัตรประชาชน : </label> <object id="card"></object>
                                          </div>

                                          <div class="col-sm-4">
                                              <label class="control-label">คำนำหน้า : </label> <object id="sername"></object>
                                          </div>
                                          <div class="col-sm-4">
                                              <label class="control-label">ชื่อ : </label> <object id="fname"></object>
                                          </div>
                                          <div class="col-sm-4">
                                                <label class="control-label">นามสกุล : </label> <object id="lname"></object>
                                          </div>

                                          <div class="col-sm-4">
                                              <label class="control-label">ชื่อเล่น : </label> <object id="nickname"></object>
                                          </div>
                                          <div class="col-sm-8">
                                                <label class="control-label">วัน/เดือน/ปี : </label> <object id="day"></object>
                                          </div>

                                          <div class="col-sm-4">
                                              <label class="control-label">เบอร์โทรศัพท์ : </label> <object id="tell"></object>
                                          </div>
                                          <div class="col-sm-4">
                                              <label class="control-label">ID Line : </label> <object id="line"> </object>
                                          </div>
                                          <div class="col-sm-4">
                                              <label class="control-label">เรทสอน : </label> <object id="rate"></object>
                                          </div>

                                          <div class="col-sm-12">
                                              <label class="control-label">อีเว้นท์ : </label> <object id="event_name"></object>
                                          </div>
                                          {{-- <div class="col-sm-12">
                                              <label class="control-label">รหัสโปรโมชั่น : </label> <object id="promotion_code"> </object>
                                          </div> --}}
                                          <div class="col-sm-12">
                                              <label class="control-label">ที่อยู่ปัจจุบัน : </label> <object id="address"></object>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <label class="oxide">&nbsp;ประวัติการศึกษา</label>
                                    <div class="form-group">
                                      <div class="col-sm-12" style="padding-bottom: 10px;">
                                        <div id=education></div>
                                      </div>
                                    </div>
                                    <label class="oxide">&nbsp;ประวัติการทำงาน</label>
                                    <div class="form-group">
                                      <div class="col-sm-12" style="padding-bottom: 10px;">
                                        <div id="his"></div>
                                      </div>
                                    </div>
                                    <label class="oxide">&nbsp;ความสำเร็จเกี่ยวกับการสอน</label>
                                    <div class="form-group">
                                      <div class="col-sm-12" style="padding-bottom: 10px;">
                                        <div id="con"></div>
                                      </div>
                                    </div>
                                    <label  class="oxide">&nbsp;กลุ่มวิชาที่ถนัด</label>
                                    <div class="form-group">
                                      <div class="col-sm-12" style="padding-bottom: 10px;">
                                        <div id="apti"></div>
                                      </div>
                                    </div>
                                    <label  class="oxide">&nbsp;ไฟล์เอกสาร</label>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                          <div class="col-md-12">
                                            <div id="showfile"></div>
                                          </div>
                                        </div>
                                    </div>
                    </form>
                    </div><!-- end row -->
                </div>
                <div class="modal-footer" id="footer">
                    <form id="approve" action="#" method="POST">
                        {{ csrf_field() }}
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                            ปิด
                        </button>
                        <button type="submit" class="btn btn-success pull-right" >
                            <i class="fa fa-check" style="margin-top: 5px;"></i> อนุมัติ
                        </button>
                        <a href="#" data-dismiss="modal" onclick="" id="notapprovess" class="btn btn-danger pull-right" >
                                <i class="fa fa-times" style="margin-top: 4px;"></i> ไม่อนุมัติ
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade" id="note" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg"> --}}
            <div class="modal fade" id="note" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">
                            <h1 class="oxide2" align="center" style="font-weight: bold; font-size: 25px;"> หมายเหตุไม่อนุมัติ  </h1>
                    </h4>
                </div>
                <div class="modal-body">
                    <div>
                        <pre id="notetxt" style="font-size: 14px;"></pre>
                    </div>
                </div>
                <div class="modal-footer" id="footer">
                    <button type="button" class="btn btn-danger pull-center" data-dismiss="modal">
                        ปิด
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
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
                                idx: 4
                            }
                        ],
                        bootstrap: true
                    }
                } );
            } );
</script>

<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
  </div>
</div>
<script>
$('#myModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var email = button.data('email');
  
  if(button.data('sername') == 'mr'){
    var sername = 'นาย';
  }
  else if(button.data('sername') == 'mrs'){
    var sername = 'นาง';
  }
  else if(button.data('sername') == 'miss'){
    var sername = 'นางสาว';
  }
  
  var fname = button.data('fname');
  var lname = button.data('lname');
  var nickname = button.data('nickname');
  var day = button.data('day');
  var tell = button.data('tell');
  var line = button.data('line');
  var card = button.data('card');
  var rate = button.data('rate');
  var address = button.data('address');
  var id = button.data('id');
  var status = button.data('status');
  var event_name = button.data('event_name');
  // var promotion_code = button.data('promotion_code')
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-body #card').text(card);
  modal.find('.modal-body #sername').text(sername);
  modal.find('.modal-body #email').text(email);
  modal.find('.modal-body #fname').text(fname);
  modal.find('.modal-body #fname').text(fname);
  modal.find('.modal-body #lname').text(lname);
  modal.find('.modal-body #nickname').text(nickname == '' ?'-':nickname);
  modal.find('.modal-body #day').text(day);
  modal.find('.modal-body #tell').text(tell);
  modal.find('.modal-body #line').text(line == '' ?'-':line);
  modal.find('.modal-body #rate').text(rate);
  modal.find('.modal-body #address').text(address);
  modal.find('.modal-body #event_name').text(event_name == '' ?'-':event_name);
  // modal.find('.modal-body #promotion_code').text(promotion_code == '' ?'-':promotion_code)
  modal.find('.modal-footer #approve').attr('action','{!! url("backend/members/approve/'+ id +'") !!}');
  modal.find('.modal-footer #notapprove').attr('href','{!! url("backend/members/notallowed/'+ id +'") !!}');
  modal.find('.modal-footer #notapprovess').attr('onclick','notcomfirm("'+id+'")');
    if(status!=0){
        document.getElementById('footer').style.display = "none";
    }else{
        document.getElementById('footer').style.display = "block";
    }
})
$('#note').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var note = button.data('note');

  var modal = $(this)
  modal.find('.modal-body #notetxt').text(note)
})
function educ(educ, exp, cong, apptitude, file, strlen, other_subjects){
    // console.log(educ['ปริญญาตรี']);
    var education = "";
    var his = "";
    var con = "";
    var apti = "";
    var edu_level = ['มัธยม','ปริญญาตรี','ปริญญาโท','ปริญญาเอก'];
    var showfile = "";
    var strl = "";
        if(educ['มัธยมศึกษา']!= null){                
            education += '<div class="col-md-12" style="padding-bottom: 0px;">';
            education += "<div class='control-label col-sm-4'>"+
            "<label class='control-label'>มัธยมศึกษา</label></div>"+
            "<div class='col-sm-7'><label class='control-label'>โรงเรียน : </label>&nbsp;"+
            "<object>"+educ['มัธยมศึกษา']+"</object>&nbsp;&nbsp;</div>";
            education += '</div>';
        }
        if(educ['ปริญญาตรี']!= null){
            // console.log('ผ่าน');
            education += '<div class="col-md-12" style="padding-bottom: 0px;">';
            education += "<div class='control-label col-sm-4'>"+
            "<label class='control-label'>ปริญญาตรี</label></div><div class='col-sm-4'>"+
            "<label class='control-label'>คณะ : </label>&nbsp;<object>"+educ['ปริญญาตรี'][0]+
            "</object>&nbsp;&nbsp;</div><div class='col-sm-4'><label class='control-label'>"+
            "มหาวิทยาลัย : </label>&nbsp;<object>"+educ['ปริญญาตรี'][1]+"</object></div></div>";
            education += '</div>';
        }
        if(educ['ปริญญาโท']!= null){
            education += '<div class="col-md-12" style="padding-bottom: 0px;">';
            education += "<div class='control-label col-sm-4'>"+
            "<label class='control-label'>ปริญญาโท</label></div><div class='col-sm-4'>"+
            "<label class='control-label'>คณะ : </label>&nbsp;<object>"+educ['ปริญญาโท'][0]+
            "</object>&nbsp;&nbsp;</div><div class='col-sm-4'><label class='control-label'>"+
            "มหาวิทยาลัย : </label>&nbsp;<object>"+educ['ปริญญาโท'][1]+"</object></div></div>";
            education += '</div>';
        }
        if(educ['ปริญญาเอก']!= null){
            education += '<div class="col-md-12" style="padding-bottom: 0px;">';
            education += "<div class='control-label col-sm-4'>"+
            "<label class='control-label'>ปริญญาเอก</label></div><div class='col-sm-4'>"+
            "<label class='control-label'>คณะ : </label>&nbsp;<object>"+educ['ปริญญาเอก'][0]+
            "</object>&nbsp;&nbsp;</div><div class='col-sm-4'><label class='control-label'>"+
            "มหาวิทยาลัย : </label>&nbsp;<object>"+educ['ปริญญาเอก'][1]+"</object></div></div>";
            education += '</div>';
        }


    if(education==''){
        education += '<div class="col-md-12" style="padding-bottom: 0px;">';
        education += "<div class='control-label col-sm-12'><label class='control-label'>-</label></div>";
    }
    document.getElementById("education").innerHTML = education;

    for(i=0; i<exp.length; i++){ //ประสบการณ์
        his += '<div class="col-md-12" style="padding-bottom: 0px;">';
        his += '<div class="control-label col-sm-4">'+
        '<label class="control-label">สถานที่ทำงาน : </label>&nbsp;<object> '+exp[i][0]+
        '</object></div><div class="col-sm-4"><label class="control-label">'+
        'ตำแหน่ง : </label>&nbsp;<object>'+exp[i][1]+'</object>&nbsp;&nbsp;</div>'+
        '<div class="col-sm-4"><label class="control-label">ประสบการณ์การทำงาน (ปี) : '+
        '</label><object>'+exp[i][2]+'</object></div></div>';
        his += '</div>';
    }
    if(his==''){
        his += '<div class="col-md-12" style="padding-bottom: 0px;">';
        his += "<div class='control-label col-sm-12'><label class='control-label'>-</label></div>";
    }
    document.getElementById("his").innerHTML = his;

    for(i=0; i<cong.length; i++){ //ความสำเร็จ
        con += '<div class="col-md-12" style="padding-bottom: 0px;">';
        con += '<div class="col-sm-12"><p class="control-label">'+cong[i]+'</p></div>';
        con += '</div>';
    }
    if(con==''){
        con += '<div class="col-md-12" style="padding-bottom: 0px;">';
        con += "<div class='control-label col-sm-12'><label class='control-label'>-</label></div>";
    }
    document.getElementById("con").innerHTML = con;

    key = Object.keys(apptitude); //ความถนัด
    var start = 0;
    var end = start+1;
    for(i=0; i<key.length; i++){
      console.log(apptitude[key[i]]);

      if (apptitude[key[i]].length > 0){
        //open div
        if((start%3)==0){
          apti +='<div class="col-md-12" style="padding-bottom: 0px;">';
        }
        else{
          
        }
        // education += "<div class='control-label col-sm-4'>"+
        // apti +='<div class="col-md-4" style="margin-left: -20px; margin-bottom: 10px;"><label class="control-label"> '+key[i]+' :</label>';

        apti +='<div class="control-label col-sm-4" style="margin-bottom: 10px;"><label class="control-label"> '+key[i]+' :</label>';

        for(f=0; f<apptitude[key[i]].length; f++){
          apti +='<li style="margin-top: 2px; padding-bottom: 2px;"><object>'+apptitude[key[i]][f]+' </object></li>';
        }

        apti += "</div>";

        //close div
        if(((end%3)==0) || (start==key.length)){
          apti +='</div>';
        }
      }
      start++;
      end++;
    }

    document.getElementById("apti").innerHTML = apti;

    file_level =  Object.keys(file); //ไฟล์
    for(i=0; i<file_level.length; i++){
        showfile += '<div class="col-sm-3" ><p class="control-label">['+file_level[i]+']</p>';
            for(f=0; f<file[file_level[i]].length; f++){
                showfile +='<li class="fa fa-file" aria-hidden="true" style="margin-top: 2px; padding-bottom: 2px;"><a style="font-family: kanit" href="{{ URL::asset('/storage/fileUpload') }}'+'/'+file[file_level[i]][f]+'" target="_blank" >  ไฟล์</a></li><br>';
            }
        showfile += "</div>";
    }
    if(showfile==''){showfile="-";}
    document.getElementById("showfile").innerHTML = showfile;

    for(i=0; i<strlen; i++){ //รหัสผ่าน
        strl +="*";
    }
    document.getElementById("pass").innerHTML = strl;
}
function notcomfirm(id){
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    Swal.fire({
  title: 'หมายเหตุไม่อนุมัติ',
  input: 'textarea',
  inputAttributes: {
    autocapitalize: 'off'
  },
  showCancelButton: true,
  confirmButtonText: 'ตกลง',
  cancelButtonText: 'ยกเลิก',
  showLoaderOnConfirm: true,
  preConfirm: (login) => {
    var data = {
        id : id,
        comment : login
    }
    if(login == ''){

    } else {
        $.ajax({
            url: "notallowed",
            data: data,
            type: "POST",
            success: function(data) {
                location.href = '{{ URL::to('backend/members/new') }}';
            },
            error: function(data) {
              console.log(data);
            }
          });
    }

  },
  allowOutsideClick: () => !Swal.isLoading()
})
}

function note(note){
    Swal.fire({
  title: '<strong>หมายเหตุไม่อนุมัติ</strong>',
  html: note,
  showCloseButton: true,
  showCancelButton: true,
  showConfirmButton: false,
  focusConfirm: false,
  confirmButtonText:
    '<i class="fa fa-thumbs-up"></i> Great!',
  confirmButtonAriaLabel: 'Thumbs up, great!',
  cancelButtonText:
    'ปิด',
  cancelButtonAriaLabel: 'Thumbs down'
})
}
</script>
@stop
