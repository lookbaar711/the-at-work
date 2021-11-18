@extends('backend.layouts/default')

{{-- Page title --}}
@section('title')
    View User Details
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/vendors/x-editable/css/bootstrap-editable.css') }}" rel="stylesheet"/>

    <link href="{{ asset('assets/css/pages/user_profile.css') }}" rel="stylesheet"/>
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>User Profile</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend') }}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="#">Users</a>
            </li>
            <li class="active">User Profile</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav  nav-tabs ">
                    <li class="active">
                        <a href="#tab1" data-toggle="tab">
                            <i class="livicon" data-name="user" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i>
                            ข้อมูลอาจารย์</a>
                    </li>
                    <li>
                        <a href="#tab2" data-toggle="tab">
                            <i class="livicon" data-name="notebook" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                            ประสบการณ์</a>
                    </li>
                    <li>
                        <a href="#tab3" data-toggle="tab">
                            <i class="livicon" data-name="notebook" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                            ความถนัด</a>
                    </li>

                </ul>
                <div  class="tab-content mar-top">
                    <div id="tab1" class="tab-pane fade active in">
                      <input type="text" name="get_data_teacher" id="get_data_teacher" value="{{$member}}" style="display: none;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <div class="panel-heading form-group">
                                      <div class="form-group row col-md-10">
                                         <h3 class="panel-title">ข้อมูลส่วนตัว</h3>
                                       </div>
                                       <div class="form-group row">
                                         <button type="button" class="btn btn-warning modal-lg_profile_teacher col-md-2"><i class="fa fa-pencil-square-o"> </i> แก้ไขข้อมูล</button>
                                       </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="users">
                                                         <tr>
                                                            <td>เลขบัตรประชาชน</td>
                                                            <td>
                                                              <div class="col-md-6">
                                                                {{ $member->member_idCard }}
                                                              </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>คำนำหน้า</td>
                                                            <td>
                                                              <div class="col-md-6">
                                                                <p class="user_name_max">{{ $member->member_sername }}</p>
                                                              </div>
                                                          </td>
                                                        </tr>
                                                        <tr>
                                                            <td>ชื่อ</td>
                                                            <td>
                                                              <div class="col-md-6">
                                                                <p class="user_name_max">{{ $member->member_fname }}</p>
                                                              </div>
                                                          </td>
                                                        </tr>
                                                        <tr>
                                                            <td>นามสกุล</td>
                                                            <td>
                                                              <div class="col-md-6">
                                                                <p class="user_name_max">{{ $member->member_lname }}</p>
                                                              </div>
                                                          </td>
                                                        </tr>
                                                        <tr>
                                                            <td>ชื่อเล่น</td>
                                                            <td>
                                                              <div class="col-md-6">
                                                                {{ ($member->member_nickname == '')?'-':$member->member_nickname }}
                                                              </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>อีเมล</td>
                                                            <td>
                                                              <div class="col-md-6">
                                                                {{ $member->member_email }}
                                                              </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>วัน/เดือน/ปี เกิด</td>
                                                            <td>
                                                              <div class="col-md-6">
                                                                {{ $member->member_Bday->format('d/m/Y') }}
                                                              </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>เบอร์โทรศัพท์</td>
                                                            <td>
                                                              <div class="col-md-6">
                                                                {{ $member->member_tell }}
                                                              </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>เรทการสอน</td>
                                                            <td>
                                                              <div class="col-md-6">
                                                                {{ number_format($member->member_rate_start).' - '.number_format($member->member_rate_end) }}
                                                              </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>ID Line</td>
                                                            <td>
                                                              <div class="col-md-6">
                                                                {{ ($member->member_idLine == '')?'-':$member->member_idLine }}
                                                              </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>ที่อยู่</td>
                                                            <td>
                                                              <div class="col-md-6">
                                                                {{ $member->member_address }}
                                                              </div>
                                                          </td>
                                                        </tr>
                                                        <tr>
                                                            <td>ข้อมูลธนาคาร</td>
                                                            <td>
                                                              @if (count($member->member_bank) > 0)
                                                                @foreach($member->member_bank as $index => $item)
                                                                  <div class="col-md-6">
                                                                      {{$item->bank_name_th}}
                                                                  </div>
                                                                  <div class="col-md-6">
                                                                    เลขบัญชี
                                                                    {{$item->bank_account_number}}
                                                                  </div>
                                                                @endforeach
                                                              @else
                                                                  <div class="col-md-6">
                                                                    ธนาคาร -
                                                                  </div>
                                                                  <div class="col-md-6">
                                                                    เลขบัญชี -
                                                                  </div>
                                                              @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>วัน/เดือน/ปี</td>
                                                            <td>
                                                              <div class="col-md-6">
                                                                {!! $member->created_at->diffForHumans() !!}
                                                              </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>อีเว้นท์</td>
                                                            <td>
                                                              <div class="col-md-6">
                                                                  {{ ($member->event_name == '') ?'-':$member->event_name }}
                                                              </div>
                                                            </td>
                                                        </tr>
                                                        {{-- <tr>
                                                            <td>รหัสโปรโมชั่น</td>
                                                            <td>
                                                              <div class="col-md-6">
                                                                {{ ($member->promotion_code == '')?'-':$member->promotion_code }}
                                                              </div>
                                                            </td>
                                                        </tr> --}}
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="img-file">
                                                    {{-- @if($user->pic)
                                                        <img src="{!! url('/').'/uploads/users/'.$user->pic !!}" alt="profile pic" class="img-max">
                                                    @elseif($user->gender === "male")
                                                        <img src="{{ asset('assets/images/authors/avatar3.png') }}"
                                                             alt="..."
                                                             class="img-responsive"/>
                                                    @elseif($user->gender === "female")
                                                        <img src="{{ asset('assets/images/authors/avatar5.png') }}"
                                                             alt="..."
                                                             class="img-responsive"/>
                                                    @else
                                                        <img src="{{ asset('assets/images/authors/no_avatar.jpg') }}"
                                                             alt="..."
                                                             class="img-responsive"/>
                                                    @endif --}}
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab2" class="tab-pane fade">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            ข้อมูลประสบการณ์
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-8">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="users">
                                                            <tr>
                                                                <td colspan="5" align="center" style="background-color: #515763; color: white;">การศึกษา</td>
                                                                </tr>
                                                                @if(!empty($member->member_education['มัธยมศึกษา']))
                                                                <tr>
                                                                    <td colspan="2">มัธยมศึกษา</td>
                                                                    <td>{{$member->member_education['มัธยมศึกษา']}}</td>
                                                                    <td></td>
                                                                </tr>
                                                                @endif
                                                                @if(!empty($member->member_education['ปริญญาตรี']))
                                                                <tr>
                                                                    <td colspan="2">ปริญญาตรี</td>
                                                                    <td>{{$member->member_education['ปริญญาตรี'][0]}}</td>
                                                                    <td>{{$member->member_education['ปริญญาตรี'][1]}}</td>
                                                                </tr>
                                                                @endif
                                                                @if(!empty($member->member_education['ปริญญาโท']))
                                                                <tr>
                                                                    <td colspan="2">ปริญญาโท</td>
                                                                    <td>{{$member->member_education['ปริญญาโท'][0]}}</td>
                                                                    <td>{{$member->member_education['ปริญญาโท'][1]}}</td>
                                                                </tr>
                                                                @endif
                                                                @if(!empty($member->member_education['ปริญญาเอก']))
                                                                <tr>
                                                                    <td colspan="2">ปริญญาเอก</td>
                                                                    <td>{{$member->member_education['ปริญญาเอก'][0]}}</td>
                                                                    <td>{{$member->member_education['ปริญญาเอก'][1]}}</td>
                                                                </tr>
                                                                @endif
                                                                <tr>
                                                                    <td colspan="5" align="center" style="background-color: #515763; color: white;">ประสบการณ์ทำงาน</td>

                                                                </tr>
                                                                @foreach ($member->member_exp as $i => $item)
                                                                <tr>
                                                                    <td colspan="5">สถานที่ทำงาน {{$item[0]}} ตำแหน่ง {{$item[1]}} {{$item[2]}} ปี</td>
                                                                </tr>
                                                                @endforeach
                                                                <tr>
                                                                    <td colspan="5" align="center" style="background-color: #515763; color: white;">ความสำเร็จ</td>
                                                                </tr>
                                                                @foreach ($member->member_cong as $i => $item)
                                                                <tr>
                                                                    <td colspan="5">{{ $item }}</td>
                                                                </tr>
                                                                @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab3" class="tab-pane fade">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                ระดับ และความถนัดวิชาต่างๆ
                                            </h3>
                                        </div>
                                          <div class="panel-body" style="text-align: left;">
                                              <div class="col-md-8">
                                                  <div class="panel-body">
                                                      <div class="table-responsive">
                                                          <table class="table table-bordered table-striped" id="users">
                                                              @foreach(array_keys($member->detail_aptitude) as $i => $key)
                                                              @if(count($member->detail_aptitude[$key]) > 0)
                                                                  <tr>
                                                                      <td colspan="2" align="left" style="background-color: #515763; color: white;">{{ $key }}</td>
                                                                  </tr>
                                                                  @foreach ($member->detail_aptitude[$key] as $j => $items)
                                                                      <tr>
                                                                          <td colspan="2" align="left">{{ $items }}</td>
                                                                      </tr>
                                                                  @endforeach
                                                              @endif
                                                              @endforeach
                                                          </table>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="modal fade" id="modal-lg_profile_teacher" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <input type="text" name="member_id_teacher" id="member_id_teacher" value="" style="display:none;">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลอาจารย์</h5>
                      </div>
                      <div class="modal-body">
                        <div>
                          <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">เลขบัตรประชาชน : <span style="color: red; font-size: 20px;" >* </span></label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="id_card_number_teacher" id="id_card_number_teacher" value="" maxlength="13" onkeypress="return isNumber(event)">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputPassword" class="col-sm-3 col-form-label">อีเมล : <span style="color: red; font-size: 20px;" >* </span></label>
                            <div class="col-sm-9">
                              <input type="email" class="form-control" name="email_teacher" id="email_teacher">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputPassword" class="col-sm-3 col-form-label">ข้อมูลธนาคาร : <span style="color: red; font-size: 20px;" >* </span></label>
                            <div class="col-sm-5">
                              <select name="bank_teacher[]" id="bank_teacher" class="form-control bank_teacher_name" style="font-size: 16px;"></select>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" class="form-control" name="account_number_teacher" id="account_number_teacher" maxlength="10" onkeypress="return isNumber(event)">
                            </div>
                            <div class="col-sm-1">
                              <button type="button" class="btn btn-success" onclick="get_profile_teacher.option_bank('1')">เพิ่ม</button>
                            </div>
                          </div>
                          <div class="add_bank_tescher">

                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <div class="col-md-4"></div>
                        <div class="col-md-4 text-center">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                          <button type="button" class="btn btn-success" id="btn_update_bank" onclick="get_profile_teacher.update_bank()" >บันทึก</button>
                        </div>
                        <div class="col-md-4"></div>
                      </div>
                    </div>
                </div>
              </div>

            </div>
        </div>
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- Bootstrap WYSIHTML5 -->
    <script  src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">

      var get_profile_teacher = {
          data: false,

          open_modal_edit_teacher:() => {
            id="modal-lg_profile_teacher"
            var data_teacher = JSON.parse($('#get_data_teacher').val());
            // console.log(data_teacher);
            $('#member_id_teacher').val(data_teacher.member_id);
            $("input[name*='id_card_number_teacher']").val(data_teacher.member_idCard);
            $("input[name*='email_teacher']").val(data_teacher.member_email);

            var stringb = '';
            // for (var i = 0; i < get_profile_teacher.data.member_bank.length; i++) {
            var STRBB = '<option value="">' +"------ กรุณาเลือกธนาคาร ------"+ '</option>';
            var x = 0;
            for (var bank of data_teacher.bank_master) {
                STRBB += '<option value="' + bank._id + '">' + bank.bank_name_th + '</option>';
             x++;
            }

            $('.bank_teacher_name').html(STRBB);

            get_profile_teacher.data = data_teacher;
            get_profile_teacher.option_bank();

          },

          option_bank : (date) => {

              if (date != 1) {
                if (get_profile_teacher.data.member_bank.length > 0) {
                  var STRBB = '<option value="">' +"------ กรุณาเลือกธนาคาร ------"+ '</option>';
                  var stringb = '';
                  for (var i = 0; i < get_profile_teacher.data.member_bank.length; i++) {
                        stringb += ` <div class="form-group row">
                                      <label for="inputPassword" class="col-sm-3 col-form-label">ข้อมูลธนาคาร : <span style="color: red; font-size: 20px;" >* </span></label>
                                      <div class="col-sm-5">
                                      <select name="add_bank_teacher[]" id="add_bank_teacher" class="form-control bank_name" style="font-size: 16px;" disabled>`;
                                      var x = 0;
                                      for (var bank of get_profile_teacher.data.bank_master) {
                                          STRBB += '<option value="' + bank._id + '">' + bank.bank_name_th + '</option>';
                                          if (bank._id ==  get_profile_teacher.data.member_bank[i].bank_id) {
                                            STRBB += '<option value="' + bank._id + '" selected="selected">' + bank.bank_name_th + '</option>';
                                          }
                                       x++;
                                      }

                          stringb +=  STRBB;
                          stringb +=  `<select/>
                                      </div>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="add_account_number_teacher" value="`+ get_profile_teacher.data.member_bank[i].bank_account_number+`" id="add_account_number_teacher" disabled>
                                      </div>
                                      <div class="col-sm-1">
                                        <button type="button" class="btn btn-danger btn-md btn-add remove_bankinformation" onclick="get_profile_teacher.remove_bankinformation(this)">ลบ</button>
                                      </div>
                                      </div>`;



                       $('.add_bank_tescher').html(stringb);
                  }
                }
              }else {
                if (date == 1) {
                  if ($('#bank_teacher option:selected').val() == "" || $('#account_number_teacher').val() == "") {
                    Swal.fire({
                      type: 'info',
                      title: "กรุณาเลือกธนาคาร",
                      confirmButtonText : 'ปิด'
                    })
                  }else {
                    var stringb = '';
                    var STRBB = '<option value="" selected="selected">' +"------ กรุณาเลือกธนาคาร ------"+ '</option>';
                          stringb += ` <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-3 col-form-label">ข้อมูลธนาคาร : <span style="color: red; font-size: 20px;" >* </span></label>
                                        <div class="col-sm-5">
                                        <select name="add_bank_teacher[]" id="add_bank_teacher" class="form-control bank_name" style="font-size: 16px;" disabled>`;
                                        var x = 0;
                                        for (var bank of get_profile_teacher.data.bank_master) {
                                            STRBB += '<option value="' + bank._id + '">' + bank.bank_name_th + '</option>';
                                            // console.log(bank._id+" == "+$('#bank_teacher').val());
                                            if (bank._id ==  $('#bank_teacher').val()) {
                                              STRBB += '<option value="' + bank._id + '" selected="selected">' + bank.bank_name_th + '</option>';
                                            }
                                         x++;
                                        }

                            stringb +=  STRBB;
                            stringb +=  `<select/>
                                        </div>
                                        <div class="col-sm-3">
                                          <input type="text" class="form-control" name="add_account_number_teacher" value="`+$("input[name*='account_number_teacher']").val()+`" id="add_account_number_teacher" disabled>
                                        </div>
                                        <div class="col-sm-1">
                                          <button type="button" class="btn btn-danger btn-md btn-add remove_bankinformation" onclick="get_profile_teacher.remove_bankinformation(this)">ลบ</button>
                                        </div>
                                        </div>`;

                         $('.add_bank_tescher').append(stringb);

                         $( "#bank_teacher" ).val("");
                         $('#account_number_teacher').val("");
                  }
                }
                else {
                  var stringb = '';
                  var STRBB = '<option value="" selected="selected">' +"------ กรุณาเลือกธนาคาร ------"+ '</option>';
                        stringb += ` <div class="form-group row">
                                      <label for="inputPassword" class="col-sm-3 col-form-label">ข้อมูลธนาคาร : <span style="color: red; font-size: 20px;" >* </span></label>
                                      <div class="col-sm-5">
                                      <select name="add_bank_teacher[]" id="add_bank_teacher" class="form-control bank_name" style="font-size: 16px;">`;
                                      var x = 0;
                                      for (var bank of get_profile_teacher.data.bank_master) {
                                          STRBB += '<option value="' + bank.bank_id + '">' + bank.bank_name_th + '</option>';
                                       x++;
                                      }

                          stringb +=  STRBB;
                          stringb +=  `<select/>
                                      </div>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="add_account_number_teacher" value="" id="add_account_number_teacher" >
                                      </div>
                                      <div class="col-sm-1">
                                        <button type="button" class="btn btn-danger btn-md btn-add remove_bankinformation" onclick="get_profile_teacher.remove_bankinformation(this)">ลบ</button>
                                      </div>
                                      </div>`;



                       $('.add_bank_tescher').append(stringb);
                }
              }

          },

          remove_bankinformation: (e) => {
            $(e).parent('div').parent('div').remove();
          },

          update_bank : () => {
            var class_ = [];
            var class_level = [];
            var aptitude = {};
            var member_bank = {};
            var ck = "y";

            var lang_request = $('#please_complete').val();

            var bank_name=[];
              $('select[name="add_bank_teacher[]"] option:selected').each(function() {
                if ($(this).val()) {
                  ck = "y";
                  bank_name.push($(this).val());
                }
              });


            var bank_account_number=[];
             $('[name="add_account_number_teacher"]').each(function() {
               if ($(this).val()) {
                 ck = "y";
                 bank_account_number.push($(this).val());
               }
             });
             if (bank_name.length <= 0 && bank_account_number.length <= 0) {
               ck = "n";
               lang_request = 'กรุณาเลือกธนาคาร และ เลขบัญชี';
             }else {
               if (bank_name.length <= 0) {
                 ck = "n";
                 lang_request = 'กรุณาเลือกธนาคาร';
               }else {
                 ck = "y";
               }
               if (bank_account_number.length <= 0) {
                 ck = "n";
                 lang_request = 'กรุณากรอกเลขบัญชี';
               }else {
                 ck = "y";
               }
             }



           for (var i = 0; i < bank_name.length; i++) {
             member_bank[i] = [bank_name[i],bank_account_number[i]];
           }
           // console.log(ck);
           // console.log(member_bank);



            if ($('#id_card_number_teacher').val() == "") {
              ck = "n";
            }
            if ($('#email_teacher').val() == "") {
              ck = "n";
            }
            if (member_bank.length > 0) {
              ck = "n";
            }

            // console.log(ck);
            // console.log(member_bank);

            if (ck != "y") {
              Swal.fire({
                type: 'warning',
                title: lang_request,
                confirmButtonText : 'ปิด'
              })
          }else {
           var data = {
             "member_id":$('#member_id_teacher').val(),
             "member_idCard":$('#id_card_number_teacher').val(),
             "member_email":$('#email_teacher').val(),
             "member_bank":member_bank,
           };

             $.ajax({
               url: window.location.origin + '/backend/members/update/member',
               headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               type: 'post',
               data: {
                 'data': data,
               },
               dataType: "json",
               success: function(data) {

                 Swal.fire({
                   type: 'success',
                   title: data.success,
                   showConfirmButton: false,
                   timer: 1500
                 })
                 setTimeout(function () {
                   $('#modal-lg_profile_teacher').modal('hide');
                   location.reload();
                 }, 2000);
                 setTimeout(function () {
                   location.reload();
                 }, 2500);

               }
             });

          }
        },

      }

      $(function() {
        $(".modal-lg_profile_teacher").click(function () {
          $('#modal-lg_profile_teacher').modal('show');
          get_profile_teacher.open_modal_edit_teacher();
        });

      });

      function isNumber(evt) {
          evt = (evt) ? evt : window.event;
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode > 31 && (charCode < 48 || charCode > 57)) {
              return false;
          }
          return true;
      }

    </script>



@stop
