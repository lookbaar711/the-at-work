@extends('backend.layouts/default')

@section('title')
แก้ไข คอรส์เรียน
@parent
@stop

@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />

<style type="text/css">

.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}


</style>
 <style type="text/css">
    .datetimepicker-input {
        background: url(../../../suksa/frontend/template/images/icons/time2.png) no-repeat right 5px center;
        background-color: #FFFFFF; 
    }
    .sizecol{
        width: 32%;
    }
</style>

@stop



{{-- Content --}}
@section('content')
@if($errors->any())
    <div style="padding-top: 5px; padding-left: 10px; padding-right: 10px;">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            @foreach($errors->all() as $error)
                <p style="color: #fff;">{{ $error }}</p>
            @endforeach
        </div>
    </div>
@endif

<section class="content-header">
    <h1 style="padding-left: 8px;">แก้ไขข้อมูลคอร์สเรียน</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> จัดการคอร์สเรียน</a></li>
        <li class="active">แก้ไขข้อมูลคอร์สเรียน</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="users-add" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        แก้ไขข้อมูลคอร์สเรียน
                    </h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ route('courses.postUpdate', $course->id) }}">
                        <!-- CSRF Token -->
                        {{ csrf_field() }}
                        <input type="hidden" name="" value="{{$course->member_id}}" id="member_id">
                        <div class="col-12 row" style="text-align: right;">
                            <div class="col-sm-12">
                                <a class="btn btn-danger" style="font-size: 16px;" href="{{ url('backend/courses') }}">
                                    ยกเลิก
                                </a>
                                <button type="submit" style="font-size: 16px;"  onclick="return chk()" class="btn btn-success">
                                    บันทึก
                                </button>
                            </div>
                        </div>

                        <div class="col-12 row form-row">
                            <label  for="colorfafa">เลือกประเภทคอร์สเรียน :</label>
                            <div class="form-group col-sm-12 radio-toolbar ">
                                <input type="radio" id="radioPublic" name="course_category" class="public course_category" onchange="dis(); showc1(); setVisibility('sub5', 'none'); setVisibility('sub6', 'inline');"  value="Public" required  {{($course->course_category == 0) ? 'checked' : '' }}>
                                <label for="radioPublic" id="colorfafa"  ><i class="fa fa-globe fa-lg "  aria-hidden="true"></i>&nbsp;Public</label>

                                <input type="radio" id="radioPrivate" name="course_category" class="private course_category"  onchange="dis2(); showc2(); setVisibility('sub5', 'inline'); setVisibility('sub6', 'none');" value="Private" required  {{($course->course_category > 0) ? 'checked' : '' }}>
                                <label for="radioPrivate" id="colorfafa2"  ><i class="fa fa-lock fa-lg"  aria-hidden="true" ></i>&nbsp;Private</label>
                            </div>
                        </div>

                        <div class="col-12 row" id="sub5" style="display: none;">
                           <div id="myRepeatingFields6">
                            <label >ระบุชื่อผู้เรียน (ไม่เกิน 10 คน) : <span style="color: red; font-size: 20px;" >*</span></label>
                            <div class="entry">
                            <div class="form-group" >
                                <div class=" col-md-4" >
                                    <input type="email" name="course_student[]" class="course_student form-control" id="emailstudents"name="emailstudents"  aria-describedby="emailHelp"placeholder="กรอกอีเมลผู้เรียน เพื่อเชิญเข้าคอร์สเรียน...">
                                </div>
                                <div class="form-group col-md-1" style="padding-left: 10px;"  >
                                    <button type="button" class="btn btn-success btn-add6 form-control " >เพิ่ม +</button>
                                </div>
                            </div>
                          </div>
                         @foreach ($course->course_student as $i => $items)
                            <div class="entry">
                                    <div class="form-group">
                                        <div class=" col-sm-6" >
                                        <input type="email" name="course_student[]" class="form-control" id=""name="emailstudents" aria-describedby="emailHelp" value="{{($items)}}">
                                        </div>
                                        <div class="form-group col-md-1" style="padding-left: 10px;"  >
                                        <button type="button" class="btn btn-danger  btn-remove  form-control" id="{{$i}}">ลบ</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        </div>

                        <div class="col-12 row">
                            <div class="col-sm-4  sizecol">
                                <div class="form-group">
                                    <label class="profile01 col-sm-auto" >ค่าเรียน :</label>
                                    <div class="col-sm-auto">
                                        <input type="radio" name="course_type" value="0" onclick="show1();" required {{ ($course->course_price == 0) ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                        <label class="container-radio" style="padding-right: 15px;">ฟรี</label>

                                        <input type="radio" name="course_type" value="1" onclick="show2();" required min="1" {{ ($course->course_price > 0) ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                        <label class="container-radio">มีค่าใช้จ่าย</label>
                                        @if($course->course_price > 0)
                                            <input type="text" name="course_price" class="form-control allownumericwithoutdecimal" id="course_price" value="{{ $course->course_price }}" placeholder="กรอกราคาคอร์ส (Coins)..." data-type="currency">
                                        @else
                                            <input type="text" name="course_price" class="form-control allownumericwithoutdecimal" id="course_price" value="" placeholder="กรอกราคาคอร์ส (Coins)..." data-type="currency" disabled>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8"></div>
                        </div>

                        <div id="myRepeatingFields5">
                            <div class="entry">
                                <div class="form-group" >
                                    <div class="col-sm-4" >
                                        <label for="dtp_input1" >วันที่เปิดสอน : <span style="color: red; font-size: 20px;" >*</span></label>
                                        <input class="form-control daterange-input course_date" name="course_date[]" id="datepicker01" type="text"  placeholder="-เลือกวันเวลาเปิดสอน-" autocomplete="off"  >
                                    </div>
                                    <div class="col-sm-2" >
                                        <label for="dtp_input1">เวลาเริ่ม : <span style="color: red; font-size: 20px;" >*</span></label>
                                        {{-- <div class="input-group date form_datetime col-md-12 " style="padding-right: unset;" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1"> --}}
                                        <input class="form-control  daterange-input2 col-md-12 time_start datetimepicker-input" size="16" id="datepicker02" type="text"  placeholder="-เลือกเวลาเริ่ม-" autocomplete="off" name="time_start[]">
                                        {{-- </div> --}}
                                        <input type="hidden" id="dtp_input1" value="" />
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="dtp_input1">เวลาสิ้นสุด : <span style="color: red; font-size: 20px;" >*</span></label>
                                        {{-- <div class="input-group date form_datetime col-md-12 " style="padding-right: unset;" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1"> --}}
                                        <input class="form-control  daterange-input2 col-md-12 time_end datetimepicker-input" size="16" id="datepicker03" type="text"  placeholder="-เลือกเวลาสิ้นสุด-"  autocomplete="off" name="time_end[]">
                                        {{-- </div> --}}
                                        <input type="hidden" id="dtp_input1" value="" />
                                    </div>
                                    <div class="col-sm-1"  >
                                        <label class="profile01" style="color: red; font-size: 20px;">&nbsp; &nbsp;</label>
                                        <button type="button" class="btn btn-success btn-md btn-add5 form-control" >เพิ่ม</button>
                                        {{-- <button type="button" class="btn btn-green btn-md btn-add5 form-control">เพิ่ม</button> --}}
                                    </div>
                                    <div class="col-sm-3"></div>
                                </div>
                            </div>


                            @foreach ($course->course_date as $index => $item)
                                <div class="entry">
                                    <div class="form-group">
                                        <div class="col-sm-4" >
                                            <label for="dtp_input1" class="col-md control-label ">วันที่เปิดสอน : </label>
                                            <input readonly="" class="form-control daterange-input course_date" id="datepicker01"  name="course_date[]" type="text" value="{{date('d/m/Y', strtotime($item['date']))}}"  placeholder="-เลือกวันเวลาเปิดสอน-" autocomplete="off" >
                                        </div>
                                        <div class="col-sm-2" >
                                            <label for="dtp_input1" class="col-md control-label ">เวลาเริ่ม : </label>
                                            {{-- <div class="input-group date form_datetime col-sm-7" style="padding-right: unset;" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1"> --}}
                                            <input readonly="" class="form-control  daterange-input2 datetimepicker-input" size="16" id="datepicker02" type="text"  placeholder="-เลือกเวลาเริ่ม-"  name="time_start[]" autocomplete="off"   value="{{date('H:i', strtotime($item['time_start']))}} " >
                                            {{-- </div> --}}
                                        </div>
                                        <div class="col-sm-2" >
                                            <label for="dtp_input1" class="col-md control-label">เวลาสิ้นสุด :</label>
                                            {{-- <div class="input-group date form_datetime  col-sm-7 " style="padding-right: unset;" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1"> --}}
                                            <input readonly="" class="form-control  daterange-input2 datetimepicker-input" size="16" id="datepicker03" type="text"  placeholder="-เลือกเวลาสิ้นสุด-"  autocomplete="off"  name="time_end[]"  value="{{date('H:i', strtotime($item['time_end']))}}"  >
                                            {{-- </div> --}}
                                        </div>
                                        <div class="col-sm-1" >
                                            <label class="profile01">&nbsp; &nbsp;</label>
                                            <button type="button" class="btn btn-danger  btn-remove  form-control" id="{{$index}}">ลบ</button>
                                        </div>
                                        <div class="col-sm-3"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-12">
                            <div class="col-sm-9">
                                 <div class="form-group">
                                    <label for="course_name" class="p-b-5">ชื่อคอร์ส : <span style="color: red; font-size: 20px;" >*</span></label>
                                    <input id="course_name" name="course_name" type="text" placeholder="ชื่อคอร์ส" class="form-control col-sm-10 required" value="{!! $course->course_name !!}">
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>

                        <div class="col-12"  id="sub6" >
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="full_name" class="p-b-5">จำนวนผู้เข้าเรียนเดิม : <span style="color: red; font-size: 20px;" ></span> </label>
                                    <input id="course_student_limit_old" name="course_student_limit_old" type="text" class="form-control col-sm-10 required allownumericwithoutdecimal" value="{!! $course->course_student_limit !!}" min="1" max="10" disabled>
                                </div>
                            </div>
                            <div class="col-sm-1"></div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="full_name" class="p-b-5">จำนวนผู้เข้าเรียนใหม่ (ไม่เกิน 10 คน) : <span style="color: red; font-size: 20px;" >*</span></label>
                                    <input id="course_student_limit" name="course_student_limit" type="text" class="form-control col-sm-10 required allownumericwithoutdecimal" value="{!! $course->course_student_limit !!}" min="1" max="10">
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>

                        <div class="col-12 row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="p-b-5">กลุ่มการศึกษา : <span style="color: red; font-size: 20px;" >*</span></label>
                                    <select class="form-control required edit-group col-sm-10" name="course_group" id="course_group" onchange="subject_edit()">
                                        <option value="" disabled>--เลือก--</option>

                                        @foreach (array_keys($subjects) as $key)
                                          @if(count($subjects[$key]) > 0)
                                            @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                              @if($course->course_group == $key)
                                                <option value="{{ $key }}" selected>
                                              @else
                                                <option value="{{ $key }}">
                                              @endif
                                              {{ $subjects[$key]['aptitude_name_en'] }}</option>
                                            @else
                                              @if($course->course_group == $key)
                                                <option value="{{ $key }}" selected>
                                              @else
                                                <option value="{{ $key }}">
                                              @endif
                                              {{ $subjects[$key]['aptitude_name_th'] }}</option>
                                            @endif
                                          @endif
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="p-b-5">วิชา : <span style="color: red; font-size: 20px;" >*</span></label>
                                    <select class="form-control required edit-group col-sm-10" name="course_subject" id="course_subject">
                                        <option value="" disabled>--เลือก--</option>
                                        @foreach ($subjects_list as $key => $value)
                                          @if($course->course_subject == $key)
                                            <option value="{{ $key }}" selected>
                                          @else
                                            <option value="{{ $key }}">
                                          @endif
                                            {{ $value['subject_name_th'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>

                        <div class="col-12">
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <label class="p-b-5">เนื้อหาคอร์สเรียน : <span style="color: red; font-size: 20px;" >*</span></label>
                                    <textarea class="form-control" name="course_detail" id="course_detail" rows="5">{{ $course->course_detail }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>

                        <div class="col-12">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="p-b-5">รูปภาพหน้าปกคอร์สเรียน : <span style="color: red; font-size: 20px;" >*</span></label>
                                    <span class="text-muted" style="font-size: 12px;">(ขนาดรูปแนะนำ กว้าง 200 x ยาว 170 xp)</span>

                                    <div class="input-group">
                                            @if(!empty($course->course_img))
                                            <label for="file-upload" class="custom-file-upload btn btn-green btn-block"style="text-align-last: center;" >&nbsp;ไฟล์ภาพ : {{$course->course_img}} </label>
                                            @else
                                            <label for="file-upload" class="custom-file-upload btn btn-green btn-block"style="text-align-last: center;" ><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Upload file </label>
                                            @endif
                                            <input id="file-upload" name='course_img' type="file" style="display:none;"    accept="image/x-png,image/gif,image/jpeg">
                                            <input  name='img2' type="hidden" style="display:none;" value="{{$course->course_img}}"  accept="image/x-png,image/gif,image/jpeg">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>แนบไฟล์เอกสาร สำหรับประกอบการสอน : <span style="color: red; font-size: 20px;" ></span></label>
                                    <span class="text-muted" style="font-size: 12px;">(ไฟล์ที่รองรับ .pdf .ppt :)</span>
                                    @if($course->course_file)
                                    <label for="course_file" class="custom-file-upload btn btn-green btn-block" style="text-align-last: center;" >&nbsp;ไฟล์เอกสาร : {{$course->course_file}}</label>
                                    @else
                                    <label for="course_file" class="custom-file-upload btn btn-green btn-block" style="text-align-last: center;" ><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Upload file  </label>
                                    @endif
                                    <input id="course_file" name="course_file" type="file" style="display:none;"   accept="application/pdf,application/vnd.ms-powerpoint">
                                    <input  name='file2' type="hidden" style="display:none;" value="{{ $course->course_file}}"  accept="application/pdf,application/vnd.ms-powerpoint">
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                            
                        <div class="col-12">
                            <div class="col-sm-9">
                                <div class="form-group check_course" >
                                    <input type="checkbox" class="option-input" id="check_course"  name="course_status" value="open" {{ ($course->course_status == "open") ? 'checked' : '' }}> <label>เปิดรับสมัครคอร์สเรียนทันที</label>

                                    <input type="hidden" name="check_course_status" id="check_course_status" value="{{ $course->course_status }}">
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->

@stop

{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>


{{-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> --}}
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script>
$(document).ready(function(){

   $('.time_start').timepicker({
      timeFormat: 'HH:mm',
      interval: 5,
      minTime: '0',
      maxTime: '11:30pm',
      startTime: '00:00',
      dynamic: true,
      dropdown: true,
      scrollbar: true
  });

  $('.time_end').timepicker({
      timeFormat: 'HH:mm',
      interval: 5,
      minTime: '0',
      maxTime: '11:30pm',
      startTime: '00:00',
      dynamic: true,
      dropdown: true,
      scrollbar: true
  });

});
</script>


<script>

$('#datepicker01').datepicker({
      uiLibrary: 'bootstrap',
      format: 'dd/mm/yyyy',
      autoclose: true,
      todayBtn: true,
  });
//   $('#datepicker02').timepicker({
//     uiLibrary: 'bootstrap',
//     formatViewType: 'time',
//     autoclose: true,
//     startView: 1,
//     maxView: 1,
//     minView: 0,
//     todayBtn: true,
//     minuteStep: 5,
//     timeFormat: 'h:mm p',
//   });
//   $('#datepicker03').timepicker({
//     uiLibrary: 'bootstrap',
//     formatViewType: 'time',
//     autoclose: true,
//     startView: 1,
//     maxView: 1,
//     minView: 0,
//     todayBtn: true,
//     minuteStep: 5,
//   });


    </script>

<script type="text/javascript">

    // Get Subject for option
    function subject_edit(aptitude_id,course_id){
        var course_id = '{!! $course->_id !!}';
        var aptitude_id = $('#course_group').val();
        var subject_edit =[];
        var data = {
                'aptitude_id': aptitude_id,
                'course_id': course_id
            };
        $.ajax({
            url: window.location.origin+'/backend/courses/getSubject',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            data: data,
            dataType: "json",
            success: function(data) {
                //console.log(data);
                select = '<label class="profile01 " >วิชา :</label><select class="form-control" name="course_subject" id="" required style="text-align: center;"><option value="" selected disabled >--เลือกวิชา--</option>';
                var option = '';
                for(i=0; i<data.length; i++){
                    //option += '<option >'+data[i]+'</option><br>';

                    option += '<option value="'+data[i]['subject_id']+'">'+data[i]['subject_name']+'</option><br>';
                }

                $('#course_subject').html(select+option);
            },
        });
    }

    // check input number 1-10
    var number = true;

    $('#course_student_limit').focus(function () {
        var $this = $(this)

    });

    $('#course_student_limit').blur(function () {
        var $this = $(this);
        var check_course_status = $('#check_course_status').val();



        if($this.val().length != 0){
            if(($this.val() >= 1) && ($this.val() <= 10)) { //1-10

                //alert($('#course_student_limit').val());

                if(check_course_status == 'open'){
                    var limit_old = $('#course_student_limit_old').val();

                    if($this.val() < limit_old) {
                        $this.val(limit_old);
                        Swal.fire({
                            type: 'error',
                            title: '<label style="font-size: 22px;">กรุณาแก้ไขจำนวนผู้เข้าเรียนใหม่ ให้มากกว่าจำนวนผู้เข้าเรียนเดิม</label>',
                            showCloseButton: true,
                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonColor: '#003D99',
                            confirmButtonText: 'ปิดหน้าต่าง',
                        });
                    }
                }
            }
            else if($this.val() == 0){
                $this.val(1);
                Swal.fire({
                    type: 'error',
                    title: '<label style="font-size: 22px;">กรุณากรอกจำนวนผู้เข้าเรียนตั้งแต่ 1 คนขึ้นไป</label>',
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonColor: '#003D99',
                    confirmButtonText: 'ปิดหน้าต่าง',
                })
            }
            else{ //10+
                $this.val(10);
                Swal.fire({
                    type: 'error',
                    title: '<label style="font-size: 22px;">กรุณากรอกจำนวนผู้เข้าเรียนไม่เกิน 10 คน</label>',
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonColor: '#003D99',
                    confirmButtonText: 'ปิดหน้าต่าง',
                });
            }
        }

    });

    // check allow input number with out decimal
    $(".allownumericwithoutdecimal").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if ((e.which != 8) && (e.which != 0) && (e.which < 48 || e.which > 57)) {
            //display error message
            if(e.which == 13){
                return false;
            }
            else{
                sweet_alert('กรุณากรอกจำนวนเป็นตัวเลขเท่านั้น');
                return false;
            }
        }
    });

    function sweet_alert(text){
        Swal.fire({
            title: '<strong style="font-size: 22px;">'+text+'</strong>',
            type: 'error',
            showCloseButton: true,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonColor: '#003D99',
            confirmButtonText: 'ปิดหน้าต่าง',
        });
    }

    function show1(){
        $('#course_price').prop('disabled', true);
        $('#course_price').val('');
    }

    function show2(){
        $('#course_price').prop('disabled', false);
    }


    $("input[data-type='currency']").on({
        keyup: function() {
          formatCurrency($(this));
        },
        blur: function() {
          formatCurrency($(this), "blur");
        }
    });


    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }


    function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.

        // get input value
        var input_val = input.val();

        // don't validate empty input
        if (input_val === "") { return; }

        // original length
        var original_len = input_val.length;

        // initial caret position
        var caret_pos = input.prop("selectionStart");

        // check for decimal
        if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);

        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
          right_side += "00";
        }

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = input_val;

            // final formatting
            if (blur === "blur") {
                input_val += "";
            }
        }

        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }


    // button upload
    $(document).ready( function() {
        $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function(){
            readURL(this);
        });
    });

</script>

<script>
        $(function() {
        var student_email_chk = [];
        var count_student_email = 0;
      <?php 
        if(!empty($course->course_student)){
          foreach ($course->course_student as $key => $value) {
      ?>
      student_email_chk.push('{{ $value }}');
      count_student_email++;
      <?php 
          }
        }else{
      ?>
      var student_email_chk = [];
      var count_student_email = 0;
      <?php 
        }
      ?>
            $(document).on('click', '.btn-add6', function(e) {
                var txt11 = $('#emailstudents').val();
                var member_id = $('#member_id').val();
                var email = [];
                $.ajax({
                    method: 'GET',
                    url: window.location.origin +'/backend/members/get_email_student/'+member_id,
                    dataType: 'json',
                    async: false,
                    success: function(data) {
                        email = data;
                    },
                    error: function(data) {
                        //error
                    }
                });
                const result = email.find(fruit => fruit.member_email === txt11);
                if (typeof result == 'undefined') {
                    Swal.fire({
                      type: 'error',
                      confirmButtonColor: '#003D99',
                      title: 'Email นักเรียน ไม่ถูกต้อง',
                      //text: 'Something went wrong!',
                    })
                    return false;
                }

                for(i=0; i<student_email_chk.length; i++){
                  if(student_email_chk[i]==txt11){
                    Swal.fire({
                        type: 'error',
                        confirmButtonColor: '#003D99',
                        title: 'Email นักเรียนนี้ถูกเพิ่มไปแล้ว',
                        //text: 'Something went wrong!',
                      })
                    return false;
                  }
                }
                student_email_chk.push(txt11);

                if(txt11==''){
                    Swal.fire({
                      type: 'error',
                      title: 'กรุณากรอกข้อมูลให้ครบ',
                      //text: 'Something went wrong!',
                    })
                    return false;
                }else if ($('[name="course_student[]"]').length <= 10){
                e.preventDefault();
                var controlForm = $('#myRepeatingFields6'),
                currentEntry = $(this).parents('.entry:first');

                $(currentEntry.clone()).appendTo(controlForm).find('input').attr('readonly', 'readonly');
                currentEntry.find('input').val('');
                controlForm.find('.entry:not(:first) .btn-add6')
                .removeClass('btn-add6').addClass('btn-remove')
                .removeClass('btn-danger').addClass('btn-danger')
                .html('ลบ')
                .attr('id', count_student_email);
                count_student_email++;
            }}).on('click', '.btn-remove', function(e) {
                e.preventDefault();
                var contentPanelId = jQuery(this).attr("id");

              student_email_chk.splice(contentPanelId,1);
                $(this).parents('.entry:first').remove();
                count_student_email--;
                return false;

            });

          });

        </script>

<script>


//อัพรูป เก่า กับ รูปใหม่
let img = $("#file-upload").val();
  if($('input[name="img2"]').val() && !$("#file-upload").val()){
    img = true;
  }
  if( img == '' ){
      sweet_alert('กรุณากรอกข้อมูลให้ครบ');
      img = false ;
  }
    //อัพรูป เก่า กับ รูปใหม่

  //อัพ เก่า กับ ไฟล์ ใหม่
  let fis = $("#course_file").val();
  if($('input[name="file2"]').val() && !$("#course_file").val()){
    fis=true
  }

//อัพไฟล์เก่า กับ ไฟล์ใหม่


function chk(){
  if($('.course_category:checked').val()=='Private'){
    var student_email = $('.course_student').map(function(i, el) {
        return el.value;
    });
    if(student_email[1] === undefined){
      Swal.fire({
        type: 'error',
        title: 'กรุณาเพิ่ม Emial นักเรียน',
        // showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonColor: '#003D99',
        confirmButtonText: 'ปิดหน้าต่าง',
    })
      return false;
    }
  }

  var date_study = $('.course_date').map(function(i, el) {
        return el.value;
    });
    if(date_study[1] === undefined){
      Swal.fire({
        type: 'error',
        title: 'กรุณาเพิ่มวันที่สอน',
        // showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonColor: '#003D99',
        confirmButtonText: 'ปิดหน้าต่าง',
    })
      return false;
    }

  var h_start = parseInt($("#h_start").val());
  var m_start = parseInt($("#m_start").val());

  var h_end = parseInt($("#h_end").val());
  var m_end = parseInt($("#m_end").val());
  if(h_start > h_end){
    if(h_start == h_end){
      if(m_start >= m_end){
        sweet_alert('กรุณาตรวจช่วงเวลาการสอนให้ถูกต้อง');
        return false;
      }
    }
    sweet_alert('กรุณาตรวจช่วงเวลาการสอนให้ถูกต้อง');
    return false;
  }else{
    if(h_start == h_end){
      if(m_start >= m_end){
        sweet_alert('กรุณาตรวจช่วงเวลาการสอนให้ถูกต้อง');
        return false;
      }
    }
  }


    $zero = $("#course_price").val();
    if($zero=='0'){
        sweet_alert('<h4>คอร์สเรียนที่คุณสร้างคือ คอร์สเรียนมีค่าใช้จ่าย กรุณากรอกจำนวน Coins </h4> <p>หากต้องการสร้างคอร์สเรียนฟรี กรุณาเลือกค่าเรียนฟรี</p>');
        return false;
    }
}
    </script>


<script>
    function showc1(){
      document.getElementById("colorfafa").style.color = "black";
      document.getElementById("colorfafa2").style.color = "black";
    }
    function showc2(){
      document.getElementById("colorfafa").style.color = "black";
      document.getElementById("colorfafa2").style.color = "black";
    }


function setVisibility(id, visibility) {
    document.getElementById(id).style.display = visibility;
    }
    function dis()
    {
        emailstudents.visibility = !emailstudents.visibility;
    }
    function dis2()
    {
        emailstudents.visibility = !emailstudents.visibility;
    }


    $(function() {

    $( ".public" ).click(function() {
    $('input[name=course_status]').attr('checked', false);

    $(".check_course").css("display", "inline");
    });

    $( ".private" ).click(function() {
    $('input[name=course_status]').attr('checked', true);

    $(".check_course").css("display", "none");
    });
});
</script>








<script>
    // define variables
    var nativePicker = document.querySelector('.nativeTimePicker');
    var fallbackPicker = document.querySelector('.fallbackTimePicker');
    var fallbackLabel = document.querySelector('.fallbackLabel');

    var hourSelect = document.querySelector('#hour');
    var minuteSelect = document.querySelector('#minute');

    // hide fallback initially
    fallbackPicker.style.display = 'none';
    fallbackLabel.style.display = 'none';

    // test whether a new date input falls back to a text input or not
    var test = document.createElement('input');
    test.type = 'time';
    // if it does, run the code inside the if() {} block
    if(test.type === 'text') {
      // hide the native picker and show the fallback
      nativePicker.style.display = 'none';
      fallbackPicker.style.display = 'block';
      fallbackLabel.style.display = 'block';

      // populate the hours and minutes dynamically
      populateHours();
      populateMinutes();
    }

    function populateHours() {
      // populate the hours <select> with the 6 open hours of the day
      for(var i = 12; i <= 18; i++) {
        var option = document.createElement('option');
        option.textContent = i;
        hourSelect.appendChild(option);
      }
    }

    function populateMinutes() {
      // populate the minutes <select> with the 60 hours of each minute
      for(var i = 0; i <= 59; i++) {
        var option = document.createElement('option');
        option.textContent = (i < 10) ? ("0" + i) : i;
        minuteSelect.appendChild(option);
      }
    }

    // make it so that if the hour is 18, the minutes value is set to 00
    // — you can't select times past 18:00
     function setMinutesToZero() {
       if(hourSelect.value === '18') {
         minuteSelect.value = '00';
       }
     }

     hourSelect.onchange = setMinutesToZero;
     minuteSelect.onchange = setMinutesToZero;



function test(){
  var h_start = parseInt($("#h_start").val());
  var m_start = parseInt($("#m_start").val());

  var h_end = parseInt($("#h_end").val());
  var m_end = parseInt($("#m_end").val());
  if(h_start > h_end){
    if(h_start == h_end){
      if(m_start >= m_end){
        alert('กรุณากรอกเวลาเริ่ม และสิ้นสุด มากกว่าเวลาปัจจุบัน');
      }
    }
    alert('กรุณากรอกเวลาเริ่ม และสิ้นสุด มากกว่าเวลาปัจจุบัน');
  }else{
    if(h_start == h_end){
      if(m_start >= m_end){
        alert('กรุณากรอกเวลาเริ่ม และสิ้นสุด มากกว่าเวลาปัจจุบัน');
      }
    }
  }
  return false;
}


 </script>

<script>
    $(function() {
      var day = [];
        var count_date = 0;
      <?php 
        if(!empty($course)){
          foreach ($course->course_date as $key => $value) {
    
      ?>
      day.push('{{ date('m/d/Y', strtotime($value['date'])) }}');
      count_date++;
      <?php 
          }
        }else{
    
        
      ?>
      var count_date = 0;
      <?php 
        }
      ?>
      console.log(count_date);
        var data_study = new Date();
        var today = new Date();
            
        $(document).on('click', '.btn-add5', function(e) {
            var txt1 = $('#datepicker01').val();
            var txt2 = $('#datepicker02').val();
            var txt3 = $('#datepicker03').val();
    
            var selectedDate = $("#datepicker01").val();
    
            var initial = selectedDate.split(/\//);
            initial = [ initial[1], initial[0], initial[2] ].join('/');
            var inputDate = new Date(initial);
    
          var now = data_study;
    
          var h_start = parseInt($("#datepicker02").val().substring(0, 2));
        var m_start = parseInt($("#datepicker02").val().substring(3, 5));
    
        var h_end = parseInt($("#datepicker03").val().substring(0, 2));
        var m_end = parseInt($("#datepicker03").val().substring(3, 5));
    
            if(txt1=='' || txt2=='' || txt3==''){
                Swal.fire({
                  type: 'error',
                  title: 'กรุณากรอกข้อมูลวันเวลาที่เปิดสอนให้ครบ',
                  // showCloseButton: true,
                  showCancelButton: false,
                  focusConfirm: false,
                  confirmButtonColor: '#003D99',
                  confirmButtonText: 'ปิดหน้าต่าง',
                  //text: 'Something went wrong!',
                })
                return false;
    
            }
            if(count_date==0){
    
              if(inputDate.setHours(0,0,0,0) < now.setHours(0,0,0,0)){
                Swal.fire({
                    type: 'error',
                    title: 'กรุณากรอกวันที่สอนให้ถูกต้อง',
                    // showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonColor: '#003D99',
                    confirmButtonText: 'ปิดหน้าต่าง',
                    //text: 'Something went wrong!',
                  })
                  console.log(now);
                return false;
              }
              if(inputDate.setHours(0,0,0,0) == now.setHours(0,0,0,0)){
                if(h_start < today.getHours()){
                if(h_start == today.getHours()){
                    if(m_start <= today.getMinutes()){
                      alert_error('กรุณากรอกเวลาเริ่ม และสิ้นสุด มากกว่าเวลาปัจจุบัน');
                      return false;
                    }
                }
                alert_error('กรุณากรอกเวลาเริ่ม และสิ้นสุด มากกว่าเวลาปัจจุบัน');
                return false;
            }else{
                if(h_start == today.getHours()){
                    if(m_start <= today.getMinutes()){
                      alert_error('กรุณากรอกเวลาเริ่ม และสิ้นสุด มากกว่าเวลาปัจจุบัน');
                      return false;
                    }
                }
            }
            }
              day.push(initial);
          } else {
            var last_day = new Date(day[day.length-1]);
            if(inputDate.setHours(0,0,0,0) <= last_day.setHours(0,0,0,0)){
                Swal.fire({
                    type: 'error',
                    title: 'กรุณากรอกวันที่สอนให้ถูกต้อง',
                    // showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonColor: '#003D99',
                    confirmButtonText: 'ปิดหน้าต่าง',
                    //text: 'Something went wrong!',
                  });

                $('#datepicker01').val('');
                $('#datepicker02').val('');
                $('#datepicker03').val('');

                return false;
              }
              day.push(initial);
          }
    
    
        if(h_start > h_end){
            if(h_start == h_end){
                if(m_start >= m_end){
                  alert_error('กรุณากรอกเวลาเริ่ม และสิ้นสุด มากกว่าเวลาปัจจุบัน');
                  return false;
                }
            }
            alert_error('กรุณากรอกเวลาเริ่ม และสิ้นสุด มากกว่าเวลาปัจจุบัน');
            return false;
        }else{
            if(h_start == h_end){
                if(m_start >= m_end){
                  alert_error('กรุณากรอกเวลาเริ่ม และสิ้นสุด มากกว่าเวลาปัจจุบัน');
                  return false;
                }
            }
        }
    
    
    
    
            e.preventDefault();
            var controlForm = $('#myRepeatingFields5'),
            currentEntry = $(this).parents('.entry:first');
    
            $(currentEntry.clone()).appendTo(controlForm).find('input').attr('readonly', 'readonly');
    
            currentEntry.find('input').val('');
    
            controlForm.find('.entry:not(:first) .btn-add5')
            .removeClass('btn-add5').addClass('btn-remove')
            .removeClass('btn-dark').addClass('btn-danger')
            .attr('id', count_date)
            .html('ลบ');
    
            count_date++;
            // console.log(day);
            // console.log(count_date);
          }).on('click', '.btn-remove', function(e) {
            e.preventDefault();
            var contentPanelId = jQuery(this).attr("id");
    
            day.splice(contentPanelId,1);
    
            $(this).parents('.entry:first').remove();
            count_date--;
            // console.log(day);
            // console.log(count_date);
            return false;
    
        });
    
      });
      function alert_error(title){
        Swal.fire({
        type: 'error',
        title: title,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonColor: '#003D99',
        confirmButtonText: 'ปิดหน้าต่าง',
    })
}

    
    </script>





@stop
