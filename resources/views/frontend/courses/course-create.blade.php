@extends('frontend.default')

<?php
    if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
        App::setLocale('en');
    }
    else{
        App::setLocale('th');
    }
?>

@section('css')
    <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/homepage.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/course-create.css') !!}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="{{ asset ('suksa/frontend/template/js/cleave.min.js') }}"></script>
    <style type="text/css">
      .date-icon {
        background: url(../../suksa/frontend/template/images/147083.png) no-repeat right 5px center;
        background-color: #FFFFFF;
      }
      .time-icon{
        background: url(../../suksa/frontend/template/images/icons/time.png) no-repeat right 5px center;
        background-color: #FFFFFF;
      }
    </style>

<!-- เวลา -->
            <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
            <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
            <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

            <!-- วัน/เดือน/ปี พร้อม เวลา -->
            <!-- <link href="{!! asset ('suksa/frontend/template/css/bootstrap-datetimepicker.css') !!}" rel="stylesheet" type="text/css">
            <link href="{!! asset ('suksa/frontend/template/css/bootstrap-datetimepicker.min.css') !!}" rel="stylesheet" type="text/css"> -->
            <!-- วัน/เดือน/ปี พร้อม เวลา -->
<!-- เวลา -->

    @endsection
@section('content')
@php

      $c_price='';
      $s_limit='';
      $name_course='';
      $details='';
      $img_course='';
      $files='';
      $g_course='';
      $status_course='';
      $subject_status='';
      $datepicker_1=[];
      $datepicker_3=[];
      $datepicker_3=[];
      $pubblic_privete='';
      $student_course=[];
      $id='';

  // -------------------------------------------------------------------//
    if(!empty($course)){
      $c_price= $course['course_price'];//ราคา
      $s_limit= $course['course_student_limit'];//จำกัดนักเรียน
      $name_course= $course['course_name'];//ชื่อคอร์ส
      $details= $course['course_detail'];//ข้อมูล detail
      $img_course= $course['course_img'];//ภาพปก
      $files= $course['course_file'];//ไฟล์
      $g_course= $course['course_group'];//เลือกกลุ่มวิชา
      $status_course= $course['course_status'];//เลือกเปิด
      $subject_status= $course['course_subject'];//เลือกกลุ่มการศึกษา
      $datepicker_1= $course['course_date'];//เลือกเวลา
      $datepicker_2= $course['time_start'];//เลือกเวลา
      $datepicker_3= $course['time_end'];//เลือกเวลา
      $pubblic_privete=$course['course_category'];//เลือกเวลา pubblic_private
      $student_course=$course['course_student'];//เพิ่มนักเรียน
      $id=$course['_id'];

    }

@endphp
<section class="p-t-20 p-b-20">
  <div class="container">
    <div class="row">
      <div class="col"></div>
      <div class="col-sm"></div>
      <div class="col-sm">
        <label style="text-align: right;  font-size: 18px;" ><a href="{{ url('courses/all/') }}" style="font-size: 18px;">Conference Room / </a><label style="color: darkgray;">Create Conference Room</label>
      </div>
    </div>
  </div>
</section>

<section class="p-b-65">
  <div class="container">
    <div class="tab-content" id="myTabContent">
        @if (!empty($id))
        <form class="box1" name="form1" action="{{ url('courses/course_edit') }}" method="POST" onSubmit="JavaScript:return fncSubmit();" enctype="multipart/form-data">
          {{ method_field('PUT') }}
          <input type="hidden" name="id" value="{{$id}}">
        @else
        <form class="box1" name="form1" action="{{ url('courses') }}" method="POST"  onSubmit="JavaScript:return fncSubmit();" enctype="multipart/form-data">
        @endif
          {{ csrf_field() }}

           <label class="profile01" style="font-size: 30px; font-weight: bold; color: #003D99;">Create Conference Room</label>
           <div class="form-row">
              <label class="col-sm-12 p-t-12">เลือกประเภทห้องประชุม :</label>
              <div class="form-group col-sm-12 radio-toolbar p-l-0">
                    <input type="radio" id="radioPublic" name="course_category" class="public course_category" onchange="dis(); showc1(); setVisibility('sub5', 'none'); setVisibility('sub6', 'inline');"  value="Public" required  {{($pubblic_privete == 0) ? 'checked' : '' }}>
                    <label for="radioPublic" id="colorfafa" style="color:#ffffff"  ><i class="fa fa-globe fa-lg "  aria-hidden="true"></i>&nbsp;@lang('frontend/courses/title.course_public')</label>

                    <input type="radio" id="radioPrivate" name="course_category" class="private course_category"  onchange="dis2(); showc2(); setVisibility('sub5', 'inline'); setVisibility('sub6', 'none');" value="Private" required  {{($pubblic_privete > 0) ? 'checked' : '' }}>
                    <label for="radioPrivate" id="colorfafa2"  ><i class="fa fa-lock fa-lg"  aria-hidden="true" ></i>&nbsp;@lang('frontend/courses/title.course_private')</label>
              </div>
            </div>

           <div class="col-sm-10 p-l-0" id="sub5" style="display: none;">
             <div id="myRepeatingFields6">
              <label class="col-md control-label p-l-0">ระบุอีเมลผู้เข้าประชุม (ไม่เกิน 100 คน) : <span style="color: red; font-size: 20px;" >*</span></label>
              <div class="entry">
                <div class="form-row" >
                    <div class="form-group col-md-6" >
                        <input type="email" name="course_student[]" class="course_student form-control" id="emailstudents"name="emailstudents" aria-describedby="emailHelp" placeholder="กรอกอีเมลผู้เข้าประชุม เพื่อเชิญเข้าห้องประชุม">
                    </div>
                    <div class="form-group col-md-1 p-t-0" style="padding-left: 0;"  >
                        <button type="button" class="btn btn-dark btn-md btn-add6 form-control">@lang('frontend/courses/title.add_button') +</button>
                    </div>
                </div>
              </div>
               @foreach ($student_course as $i => $items)
                <div class="entry">
                  <div class="row">
                    <div class="form-group col-sm-6" >
                    <input type="email" name="course_student[]" class="form-control" id="emailstudents"name="emailstudents" aria-describedby="emailHelp" value="{{($items)}}">
                    </div>
                    <div class="form-group col-md-1 p-t-0" style="padding-left: 0;"  >
                      <button type="button" class="btn btn-danger  btn-remove  form-control" id="{{$i}}" style="width:90px;">@lang('frontend/courses/title.remove_button')</button>
                    </div>
                  </div>
                </div>
               @endforeach
             </div>
           </div>

           <div class="form-row">
              {{-- <label class="profile01 col-sm-auto">@lang('frontend/courses/title.study_fee') :</label> --}}

              <input type="hidden" name="course_type" value="0">


              {{-- <div class="form-group col-sm-auto">
                  <label class="container-radio">@lang('frontend/courses/title.free_type')
                      <input type="radio" name="course_type" value="0" onclick="show1(); clearText();" required checked  {{ ($c_price == 0) ? 'checked' : '' }}>
                      <span class="checkmark"></span>
                  </label>
              </div>

              <div class="form-group col-sm-auto">
                  <label class="container-radio">@lang('frontend/courses/title.fee_type')
                      <input type="radio" name="course_type" value="1" onclick="show2();" required min="1" {{ ($c_price > 0) ? 'checked' : '' }}>
                      <span class="checkmark"></span>
                  </label>
              </div> &nbsp;&nbsp;

              <div class="form-group col-sm-3"id="div1" style="margin-top: -10px;">
                @if($c_price > 0)
                    <input type="text" name="course_price" class="form-control " id="course_price" value="{!! $c_price !!}" placeholder="@lang('frontend/courses/title.enter_course_price')" data-type="currency">
                @else
                    <input type="text" name="course_price" class="form-control " id="course_price" value="" placeholder="@lang('frontend/courses/title.enter_course_price')" data-type="currency" disabled>
                @endif
              </div> --}}

              <div class="form-group col-sm-12" id="sub6">
                <label class="profile01">จำนวนผู้เข้าประชุม (ไม่เกิน 100 คน) : <span style="color: red; font-size: 20px;" >*</span></label>
                <input type="text"  class="form-control col-sm-4" name="course_student_limit"  id="student_limit" onKeyPress="CheckNumm();"  type="number"  value="{{($s_limit)}}" min="1" max="100" placeholder="0"  required>
              </div>
           </div>
           <hr>

           <div id="myRepeatingFields5">
              <div class="entry">
                <div class="form-row" >
                  <div class="form-group col-md-4" >
                      <label for="dtp_input1" class="col-md control-label p-l-0">วันที่ประชุม : <span style="color: red; font-size: 20px;" >*</span></label>
                     <input class="form-control daterange-input date-icon course_date" name="course_date[]" id="datepicker01" type="text"  placeholder="เลือกวันที่ประชุม" autocomplete="off"  >
                  </div>
                  <div class="form-group col-md-3">
                      <label for="dtp_input1" class="col-md control-label p-l-0">@lang('frontend/courses/title.start_time') : <span style="color: red; font-size: 20px;" >*</span></label>
                      <div class="input-group date form_datetime col-md-12 p-l-0" style="padding-right: unset;" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                          <input class="form-control daterange-input2 time-icon" size="16" id="datepicker02" type="text"  placeholder="@lang('frontend/courses/title.select_start_time')" autocomplete="off" name="time_start[]">
                          <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                         <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                      </div>
                     <input type="hidden" id="dtp_input1" value="" />
                  </div>
                  <div class="form-group col-md-3">
                      <label for="dtp_input1" class="col-md control-label p-l-0">@lang('frontend/courses/title.end_time') : <span style="color: red; font-size: 20px;" >*</span></label>
                      <div class="input-group date form_datetime col-md-12 p-l-0" style="padding-right: unset;" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                          <input class="form-control daterange-input2 time-icon" size="16" id="datepicker03" type="text"  placeholder="@lang('frontend/courses/title.select_end_time')"  autocomplete="off" name="time_end[]">
                          <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                         <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                      </div>
                     <input type="hidden" id="dtp_input1" value="" />
                  </div>
                  <div class="form-group col-md-2 p-t-0" style="padding-left: 0;"  >
                      <label class="profile01  p-t-0 p-b-0" > &nbsp; &nbsp; <span style="color: red; font-size: 20px;" >&nbsp;</span></label>
                      <button type="button" class="btn btn-dark btn-md btn-add5 form-control">@lang('frontend/courses/title.add_button')</button>
                  </div>
                </div>
              </div>
              @foreach ($datepicker_1 as $item)
              <div class="entry">
                  {{-- <div class="container"> --}}
                      <div class="form-row">
                          <div class="form-group col-md-4" >
                              <label for="dtp_input1" class="col-md control-label p-l-0">วันที่ประชุม : <span style="color: red; font-size: 20px;">*</span></label>
                             <input class="form-control daterange-input date-icon course_date" id="datepicker001"  name="course_date[]" type="text" value="{{date('d/m/Y', strtotime($item['date']))}}" placeholder="เลือกวันที่ประชุม" autocomplete="off" readonly>
                          </div>
                          <div class="form-group col-md-3">
                              <label for="dtp_input1" class="col-md control-label p-l-0">@lang('frontend/courses/title.start_time') : <span style="color: red; font-size: 20px;">*</span></label>
                              <div class="input-group date form_datetime col-md-12 p-l-0" style="padding-right: unset;" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                              <input class="form-control daterange-input2 time-icon" size="16" id="datepicker002" type="text" placeholder="@lang('frontend/courses/title.select_start_time')" name="time_start[]" autocomplete="off"   value="{{date('H:i', strtotime($item['time_start']))}} " readonly>
                          </div>
                        </div>
                          <div class="form-group col-md-3">
                              <label for="dtp_input1" class="col-md control-label p-l-0">@lang('frontend/courses/title.end_time') : <span style="color: red; font-size: 20px;">*</span></label>
                              <div class="input-group date form_datetime col-md-12 p-l-0" style="padding-right: unset;" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                              <input class="form-control daterange-input2 time-icon" size="16" id="datepicker003" type="text" placeholder="@lang('frontend/courses/title.select_end_time')" autocomplete="off" name="time_end[]"  value="{{date('H:i', strtotime($item['time_end']))}}" readonly>
                          </div>
                        </div>
                          <div class="form-group col-md-2">
                              <label class="profile01 p-t-0 p-b-0">&nbsp;&nbsp;<span style="color: red; font-size: 20px;">&nbsp;</span></label>
                              <button type="button" class="btn btn-danger btn-remove  form-control">@lang('frontend/courses/title.remove_button')</button>
                          </div>
                      </div>
                  {{-- </div> --}}
              </div>
              @endforeach
           </div>

           <div class="form-row">
              <label class="col-sm-12">ชื่อการประชุม : <span style="color: red; font-size: 20px;" >*</span></label>
                <div class="form-group col-md-12">
                      <input type="text" name="course_name" id="course_name" class="form-control" placeholder="กรอกชื่อการประชุม"   value="{{($name_course)}}"  required>
                 </div>
           </div>

           <div class="form-row">
              {{-- <div class="form-group col-sm-6">
                 <label class="profile01">@lang('frontend/courses/title.aptitude') : <span style="color: red; font-size: 20px;" >*</span></label>
                  @if (!empty($id))
                    <select class="form-control required edit-group col-sm-10" name="course_group" id="course_group" style=" text-align: center; text-align-last: center; padding-top: 4px;" onchange="subject(this.value)">
                      <option value="">@lang('frontend/courses/title.select')</option>

                      @foreach (array_keys($subject_detail) as $key)
                        @if(count($subject_detail[$key]) > 0)
                            @if($g_course == $key)
                              <option value="{{ $key }}" selected>
                            @else
                              <option value="{{ $key }}">
                            @endif

                            @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                              {{ $subject_detail[$key]['aptitude_name_en'] }}
                            @else
                              {{ $subject_detail[$key]['aptitude_name_th'] }}
                            @endif
                          </option>
                        @endif
                      @endforeach
                    </select>
                 @else
                   <select class="form-control required edit-group col-sm-auto" name="course_group" id="course_group" style=" text-align: center; text-align-last: center; padding-top: 4px;" onchange="subject(this.value)">
                      <option value="">@lang('frontend/courses/title.select')</option>

                      @foreach (array_keys($subject_detail) as $key)
                        @if(count($subject_detail[$key]) > 0)
                            @if($g_course == $key)
                              <option value="{{ $key }}" selected>
                            @else
                              <option value="{{ $key }}">
                            @endif

                            @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                              {{ $subject_detail[$key]['aptitude_name_en'] }}
                            @else
                              {{ $subject_detail[$key]['aptitude_name_th'] }}
                            @endif
                              </option>
                        @endif
                      @endforeach
                    </select>
                 @endif
              </div> --}}

              {{-- <div class="form-group col-md-6" id="subject">
                  <label class="profile01">@lang('frontend/courses/title.subject') : <span style="color: red; font-size: 20px;" >*</span></label>
                  @if (!empty($id))
                  <select class="form-control" name="course_subject" id="course_subject" style=" text-align: center; text-align-last: center; padding-top: 4px;"  required>  <option value="{{ $subject_status}}" readonly>@lang('frontend/courses/title.select')</option>
                    @foreach ($subjects_list as $key => $value)
                      @if($subject_status == $key)
                        <option value="{{ $key }}" selected>
                      @else
                        <option value="{{ $key }}">
                      @endif

                      @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                        {{ $value['subject_name_en'] }}
                      @else
                        {{ $value['subject_name_th'] }}
                      @endif
                        </option>
                    @endforeach
                   </select>
                @else
                  <select class="form-control" name="course_subject" id="course_subject" style=" text-align: center; text-align-last: center; padding-top: 4px;" required>
                    <option value="{{ $subject_status}}">@lang('frontend/courses/title.select')</option>
                 </select>
                @endif
              </div> --}}
           </div>

           <div class="form-row">
             <label class="col-sm-12">เนื้อหาการประชุม : <span style="color: red; font-size: 20px;" >*</span></label>
                <div class="form-group col-md-12">
                   <textarea class="form-control" name="course_detail" id="course_detail" rows="10" placeholder="กรอกเนื้อหา รายละเอียดการประชุม" required>{{($details)}}</textarea>
                </div>
           </div>

           <div class="form-row">
              <div class="col-sm-6">
                  <label>รูปภาพหน้าปกการประชุม : <span style="color: red; font-size: 20px;" >*</span></label>
                  <p>@lang('frontend/courses/title.course_cover_recommend') :</p>
                  @if (!empty($id))
                    <label for="file-upload" class="custom-file-upload btn btn-dark btn-block"style="text-align-last: center;" >&nbsp;@lang('frontend/courses/title.image_file') : {{$img_course}} </label>
                  @else
                    <label for="file-upload" class="custom-file-upload btn btn-dark btn-block"style="text-align-last: center;" ><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;@lang('frontend/courses/title.upload_file') </label>
                  @endif
                  <input id="file-upload" name='course_img' type="file" style="display:none;"    accept="image/x-png,image/gif,image/jpeg">
                  <input  name='img2' type="hidden" style="display:none;" value="{{$img_course}}"  accept="image/x-png,image/gif,image/jpeg">
              </div>

              <div class="col-sm-6">
                  {{-- <label>@lang('frontend/courses/title.attach_file') : <span style="color: red; font-size: 20px;" >&nbsp;</span></label>
                  <p>@lang('frontend/courses/title.file_support') :</p>
                  @if (!empty($id))
                    <label for="course_file" class="custom-file-upload btn btn-dark btn-block" style="text-align-last: center;" >&nbsp;@lang('frontend/courses/title.doc_file') : {{$files}}</label>
                  @else
                    <label for="course_file" class="custom-file-upload btn btn-dark btn-block" style="text-align-last: center;" ><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;@lang('frontend/courses/title.upload_file') </label>
                  @endif
                  <input id="course_file" name="course_file" type="file" style="display:none;"   accept="application/pdf,application/vnd.ms-powerpoint">
                  <input  name='file2' type="hidden" style="display:none;" value="{{$files}}"  accept="application/pdf,application/vnd.ms-powerpoint"> --}}
              </div>
           </div>

           {{-- <div class="col check_course">
              <input type="checkbox" class="option-input " id="check_course" name="course_status"  value="open" {{ ($status_course == "open") ? 'checked' : '' }}  ><span style="font-size: 20px;">@lang('frontend/courses/title.open_now')</span>
           </div> --}}

           <input type="hidden" id="check_course" name="course_status" value="open">

           <div class="col-md-12">
              <hr class="p-b-5">
              <div class="col-sm-12 p-l-0 p-r-0" >
                  <p class="dotted" >
                      <i class="fa fa-warning" style="font-size:26px;color:red;padding-left: 10px;padding-top: 5px;"></i> &nbsp;<label style="font-size: 20px; color: #E23939; font-weight: bold;">@lang('frontend/courses/title.note')</label>
                    <br>
                      <label style="padding-left: 10px; color: black;">
                        1. การสร้างห้องประชุมแบบ Private
                        <br> - เมื่อเชิญผู้เข้าประชุม แล้วผู้เข้าประชุมไม่กดเข้าร่วม ห้องประชุมจะเปิดไม่สำเร็จ
                        <br> (เช่น เชิญผู้เข้าประชุม 2 คน เเต่ไม่มีใครกดเข้าร่วมเลย ห้องประชุมจะเปิดไม่สำเร็จ)
                      </label>
                  </p>
              </div>
              <br>
              <div class="container">
                <div class="row">
                  <div class="col-sm"></div>
                    <div class="col-sm">
                        <button type="submit" onclick="return chk()" class="flex-c-m size2 bo-rad-23 s-text3 bgwhite hov1 trans-0-5 col-12 save_course"><object class="colorz" style="font-size: 20px;">@lang('frontend/courses/title.save_button')</object></button>
                    </div>
                  <div class="col-sm"></div>
                </div>
              </div>
           </div>

        </form>
      </div>
    </div>
  </section>

<script> //เลือกวิชา
function subject(value){
    var subject_text = '{{ trans('frontend/courses/title.subject') }}';
    var select_text = '{{ trans('frontend/courses/title.select') }}';

    if(value!=''){
        var subject =[];
        $.ajax({
          method: 'GET',
          dataType: 'json',
          url: '{{ url('/courses/getsubject') }}'+'/'+value,
          success: function(data) {

              select = '<label class="profile01">'+subject_text+' : <span style="color: red; font-size: 20px; " >*</span></label><select class="form-control" name="course_subject" id="course_subject" required style="text-align: center; text-align: center;  text-align-last: center; padding-top: 4px;"><option value="" selected readonly >'+select_text+'</option>';
              var option = '';
              for(i=0; i<data.length; i++){
                  option += '<option value="'+data[i]['subject_id']+'">'+data[i]['subject_name']+'</option><br>';

              }
              document.getElementById("subject").innerHTML = select+option+'</select>';
              //console.log(data);

          },
          error: function(data) {
              console.log('error');
          }
        });
    }
    else{
        $('#course_subject').val('');
        $('#course_subject').html('<option value="">'+select_text+'</option>');
    }
}
</script>

<script>
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

function show1(){
  // document.getElementById('div1').style.display ='none';
  // document.getElementById('div2').style.display ='none';
//   document.getElementById('div4').style.display ='block';
  document.getElementById('course_price').disabled = true;
}
function show2(){
  // document.getElementById('div1').style.display = 'block';
  // document.getElementById('div2').style.display = 'block';
//   document.getElementById('div4').style.display ='none';
  document.getElementById('course_price').disabled = false;
}

function chk(){
  var please_enter_email = '{{ trans('frontend/courses/title.please_enter_email') }}';
  var please_select_open_course_date = '{{ trans('frontend/courses/title.please_select_open_course_date') }}';
  var please_select_course_time_match = '{{ trans('frontend/courses/title.please_select_course_time_match') }}';
  var please_enter_require_field = '{{ trans('frontend/courses/title.please_enter_require_field') }}';
  var please_enter_coins_1 = '{{ trans('frontend/courses/title.please_enter_coins_1') }}';
  var please_enter_coins_2 = '{{ trans('frontend/courses/title.please_enter_coins_2') }}';

  var please_enter_student_limit = '{{ trans('frontend/courses/title.please_enter_student_limit') }}';
  var please_enter_course_price = '{{ trans('frontend/courses/title.please_enter_course_price') }}';


  var please_enter_course_name = '{{ trans('frontend/courses/title.please_enter_course_name') }}';
  var please_select_course_group = '{{ trans('frontend/courses/title.please_select_course_group') }}';
  var please_select_course_subject = '{{ trans('frontend/courses/title.please_select_course_subject') }}';
  var please_enter_course_detail = '{{ trans('frontend/courses/title.please_enter_course_detail') }}';
  var please_select_course_cover = '{{ trans('frontend/courses/title.please_select_course_cover') }}';

  var close_window = '{{ trans('frontend/courses/title.close_window') }}';

  var check_btn_submit = "";
  var text_swal = '';
// $(".save_course").prop('disabled', true);

//เช็คการเลือกรูปภาพหน้าปกคอร์สเรียน
//อัพรูป เก่า กับ รูปใหม่
let img = $("#file-upload").val();
if($('input[name="img2"]').val() && !$("#file-upload").val()){
  img=true
}
if(img==''){
  text_swal = please_select_course_cover;
  // Swal.fire({
  //     type: 'error',
  //     title: please_select_course_cover,
  //     // showCloseButton: true,
  //     showCancelButton: false,
  //     focusConfirm: false,
  //     confirmButtonColor: '#003D99',
  //     confirmButtonText: close_window,
  // });
  // return false;
}
//อัพรูป เก่า กับ รูปใหม่

//อัพ เก่า กับ ไฟล์ ใหม่
let fis = $("#course_file").val();
if($('input[name="file2"]').val() && !$("#course_file").val()){
  fis=true
}

// ----------------------------------------------------------------

//เช็คการกรอกเนื้อหาคอร์สเรียน
if($('#course_detail').val()==''){
  text_swal = please_enter_course_detail;
  // Swal.fire({
  //     type: 'error',
  //     title: please_enter_course_detail,
  //     // showCloseButton: true,
  //     showCancelButton: false,
  //     focusConfirm: false,
  //     confirmButtonColor: '#003D99',
  //     confirmButtonText: close_window,
  // });
  // return false;
}

// ----------------------------------------------------------------

//เช็คการเลือกวิชา
if($('#course_subject').val()==''){
  text_swal = please_select_course_subject;

  // Swal.fire({
  //     type: 'error',
  //     title: please_select_course_subject,
  //     // showCloseButton: true,
  //     showCancelButton: false,
  //     focusConfirm: false,
  //     confirmButtonColor: '#003D99',
  //     confirmButtonText: close_window,
  // });
  // return false;
}

// ----------------------------------------------------------------

//เช็คการเลือกกลุ่มการศึกษา
if($('#course_group').val()==''){
  text_swal = please_select_course_group;
  //
  // Swal.fire({
  //     type: 'error',
  //     title: please_select_course_group,
  //     // showCloseButton: true,
  //     showCancelButton: false,
  //     focusConfirm: false,
  //     confirmButtonColor: '#003D99',
  //     confirmButtonText: close_window,
  // });
  // return false;
}

// ----------------------------------------------------------------

//เช็คการกรอกชื่อคอร์ส
if($('#course_name').val()==''){
  text_swal = please_enter_course_name;

  // Swal.fire({
  //     type: 'error',
  //     title: please_enter_course_name,
  //     // showCloseButton: true,
  //     showCancelButton: false,
  //     focusConfirm: false,
  //     confirmButtonColor: '#003D99',
  //     confirmButtonText: close_window,
  // });
  // return false;
}

// ----------------------------------------------------------------


//เช็คโรงเรียน เมื่อเลือกประเภทคอร์สเป็น School
if($('.course_category:checked').val()=='School'){
  if($('#member_school').val() == ''){
    // text_swal = please_select_open_course_date;

    Swal.fire({
        type: 'error',
        title: can_not_create_school_course,
        html:
              please_select_school_in_your_profile,
        // showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonColor: '#003D99',
        confirmButtonText: close_window,
    });

    return false;
  }

  var student_email = $('.course_student').map(function(i, el) {
      return el.value;
  });
  if(student_email[1] === undefined){
    Swal.fire({
        type: 'error',
        title: please_enter_email,
        // showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonColor: '#003D99',
        confirmButtonText: close_window,
    });
    return false;
  }
}

// ----------------------------------------------------------------

//เช็คการกรอกจำนวนผู้เข้าเรียน เมื่อเลือกประเภทคอร์สเป็น Public
if($('.course_category:checked').val()=='Public'){
  if(($('#student_limit').val()=='') || ($('#student_limit').val()=='0')){
    text_swal = please_enter_student_limit;

    // Swal.fire({
    //     type: 'error',
    //     title: please_enter_student_limit,
    //     // showCloseButton: true,
    //     showCancelButton: false,
    //     focusConfirm: false,
    //     confirmButtonColor: '#003D99',
    //     confirmButtonText: close_window,
    // });
    // return false;
  }
}

// ----------------------------------------------------------------

//เช็คการกรอกราคาคอร์ส เมื่อเลือกค่าเรียนแบบ มีค่าใช้จ่าย
if($("input[name=course_type]:checked").val()=='1'){ //มีค่าใช้จ่าย
  if($('#course_price').val()==''){
    text_swal = please_enter_course_price;

    // Swal.fire({
    //     type: 'error',
    //     title: please_enter_course_price,
    //     // showCloseButton: true,
    //     showCancelButton: false,
    //     focusConfirm: false,
    //     confirmButtonColor: '#003D99',
    //     confirmButtonText: close_window,
    // });
    // return false;
  }
}

// ----------------------------------------------------------------


//เช็คการเลือกวันที่สอน อย่างน้อย 1 วัน
var date_study = $('.course_date').map(function(i, el) {
  return el.value;
});
if(date_study[1] == undefined){
  text_swal = please_select_open_course_date;

  // Swal.fire({
  //     type: 'error',
  //     title: please_select_open_course_date,
  //     // showCloseButton: true,
  //     showCancelButton: false,
  //     focusConfirm: false,
  //     confirmButtonColor: '#003D99',
  //     confirmButtonText: close_window,
  // });
  // return false;
}

var h_start = parseInt($("#h_start").val());
var m_start = parseInt($("#m_start").val());

var h_end = parseInt($("#h_end").val());
var m_end = parseInt($("#m_end").val());
if(h_start > h_end){
  if(h_start == h_end){
    if(m_start >= m_end){
      sweet_alert(please_select_course_time_match);

      return false;
    }
  }
  sweet_alert(please_select_course_time_match);
  return false;
}else{
  if(h_start == h_end){
    if(m_start >= m_end){
      sweet_alert(please_select_course_time_match);
      return false;
    }
  }
}

// ----------------------------------------------------------------


//เช็คการกรอก email เมื่อเลือกประเภทคอร์สเป็น Private
if($('.course_category:checked').val()=='Private'){
  var student_email = $('.course_student').map(function(i, el) {
      return el.value;
  });
  if(student_email[1] === undefined){
    text_swal = please_enter_email;

    // Swal.fire({
    //     type: 'error',
    //     title: please_enter_email,
    //     // showCloseButton: true,
    //     showCancelButton: false,
    //     focusConfirm: false,
    //     confirmButtonColor: '#003D99',
    //     confirmButtonText: close_window,
    // });
    // return false;
  }
}

// ----------------------------------------------------------------


if (text_swal != '') {
  Swal.fire({
      type: 'error',
      title: text_swal,
      // showCloseButton: true,
      showCancelButton: false,
      focusConfirm: false,
      confirmButtonColor: '#003D99',
      confirmButtonText: close_window,
  });
  return false;
}else {
  return true;
  $(".save_course").prop('disabled', true);
}
  //
  // //เช็คการกรอก email เมื่อเลือกประเภทคอร์สเป็น Private
  // if($('.course_category:checked').val()=='Private'){
  //   var student_email = $('.course_student').map(function(i, el) {
  //       return el.value;
  //   });
  //   if(student_email[1] === undefined){
  //     Swal.fire({
  //         type: 'error',
  //         title: please_enter_email,
  //         // showCloseButton: true,
  //         showCancelButton: false,
  //         focusConfirm: false,
  //         confirmButtonColor: '#003D99',
  //         confirmButtonText: close_window,
  //     });
  //     check_btn_submit = false;
  //     return false;
  //   }
  // }
  //
  // //เช็คการกรอกราคาคอร์ส เมื่อเลือกค่าเรียนแบบ มีค่าใช้จ่าย
  // // if($("input[name=course_type]:checked").val()=='1'){ //มีค่าใช้จ่าย
  // //   if($('#course_price').val()==''){
  // //     Swal.fire({
  // //         type: 'error',
  // //         title: please_enter_course_price,
  // //         // showCloseButton: true,
  // //         showCancelButton: false,
  // //         focusConfirm: false,
  // //         confirmButtonColor: '#003D99',
  // //         confirmButtonText: close_window,
  // //     });
  // //     return false;
  // //   }
  // // }
  //
  // //เช็คการกรอกจำนวนผู้เข้าเรียน เมื่อเลือกประเภทคอร์สเป็น Public
  // if($('.course_category:checked').val()=='Public'){
  //   if(($('#student_limit').val()=='') || ($('#student_limit').val()=='0')){
  //     Swal.fire({
  //         type: 'error',
  //         title: please_enter_student_limit,
  //         // showCloseButton: true,
  //         showCancelButton: false,
  //         focusConfirm: false,
  //         confirmButtonColor: '#003D99',
  //         confirmButtonText: close_window,
  //     });
  //     check_btn_submit = false;
  //     return false;
  //   }
  // }
  //
  // //เช็คการเลือกวันที่สอน อย่างน้อย 1 วัน
  // var date_study = $('.course_date').map(function(i, el) {
  //   return el.value;
  // });
  // if(date_study[1] === undefined){
  //   Swal.fire({
  //       type: 'error',
  //       title: please_select_open_course_date,
  //       // showCloseButton: true,
  //       showCancelButton: false,
  //       focusConfirm: false,
  //       confirmButtonColor: '#003D99',
  //       confirmButtonText: close_window,
  //   });
  //   check_btn_submit = false;
  //   return false;
  // }
  //
  // var h_start = parseInt($("#h_start").val());
  // var m_start = parseInt($("#m_start").val());
  //
  // var h_end = parseInt($("#h_end").val());
  // var m_end = parseInt($("#m_end").val());
  // if(h_start > h_end){
  //   if(h_start == h_end){
  //     if(m_start >= m_end){
  //       sweet_alert(please_select_course_time_match);
  //       check_btn_submit = false;
  //       return false;
  //     }
  //   }
  //   sweet_alert(please_select_course_time_match);
  //   check_btn_submit = false;
  //   return false;
  // }else{
  //   if(h_start == h_end){
  //     if(m_start >= m_end){
  //       sweet_alert(please_select_course_time_match);
  //       check_btn_submit = false;
  //       return false;
  //     }
  //   }
  // }
  //
  // //เช็คการกรอกชื่อคอร์ส
  // if($('#course_name').val()==''){
  //   Swal.fire({
  //       type: 'error',
  //       title: please_enter_course_name,
  //       // showCloseButton: true,
  //       showCancelButton: false,
  //       focusConfirm: false,
  //       confirmButtonColor: '#003D99',
  //       confirmButtonText: close_window,
  //   });
  //   check_btn_submit = false;
  //   return false;
  // }
  //
  // // //เช็คการเลือกกลุ่มการศึกษา
  // // if($('#course_group').val()==''){
  // //   Swal.fire({
  // //       type: 'error',
  // //       title: please_select_course_group,
  // //       // showCloseButton: true,
  // //       showCancelButton: false,
  // //       focusConfirm: false,
  // //       confirmButtonColor: '#003D99',
  // //       confirmButtonText: close_window,
  // //   });
  // //   return false;
  // // }
  //
  // // //เช็คการเลือกวิชา
  // // if($('#course_subject').val()==''){
  // //   Swal.fire({
  // //       type: 'error',
  // //       title: please_select_course_subject,
  // //       // showCloseButton: true,
  // //       showCancelButton: false,
  // //       focusConfirm: false,
  // //       confirmButtonColor: '#003D99',
  // //       confirmButtonText: close_window,
  // //   });
  // //   return false;
  // // }
  //
  // //เช็คการกรอกเนื้อหาคอร์สเรียน
  // if($('#course_detail').val()==''){
  //   Swal.fire({
  //       type: 'error',
  //       title: please_enter_course_detail,
  //       // showCloseButton: true,
  //       showCancelButton: false,
  //       focusConfirm: false,
  //       confirmButtonColor: '#003D99',
  //       confirmButtonText: close_window,
  //   });
  //   check_btn_submit = false;
  //   return false;
  // }
  //
  // //เช็คการเลือกรูปภาพหน้าปกคอร์สเรียน
  // //อัพรูป เก่า กับ รูปใหม่
  // let img = $("#file-upload").val();
  // if($('input[name="img2"]').val() && !$("#file-upload").val()){
  //   img=true
  // }
  // if(img==''){
  //   Swal.fire({
  //       type: 'error',
  //       title: please_select_course_cover,
  //       // showCloseButton: true,
  //       showCancelButton: false,
  //       focusConfirm: false,
  //       confirmButtonColor: '#003D99',
  //       confirmButtonText: close_window,
  //   });
  //   check_btn_submit = false;
  //   return false;
  // }
  //
  //
  // if (check_btn_submit == true) {
  //   $(".save_course").prop('disabled', true);
  // }
  // //อัพรูป เก่า กับ รูปใหม่
  //
  // //อัพ เก่า กับ ไฟล์ ใหม่
  // // let fis = $("#course_file").val();
  // // if($('input[name="file2"]').val() && !$("#course_file").val()){
  // //   fis=true
  // // }
  //
  // //อัพไฟล์เก่า กับ ไฟล์ใหม่

}
function sweet_alert(text){
  var close_window = '{{ trans('frontend/courses/title.close_window') }}';
  Swal.fire({
      title: '<strong><h3>'+text+'</h3></u></strong>',
      type: 'info',
      // showCloseButton: true,
      showCancelButton: false,
      focusConfirm: false,
      confirmButtonColor: '#003D99',
      confirmButtonText: close_window,
    });
  }

// Jquery Dependency

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

function test(){
  var please_select_course_time_match = '{{ trans('frontend/courses/title.please_select_course_time_match') }}';
  var close_window = '{{ trans('frontend/courses/title.close_window') }}';

  var h_start = parseInt($("#h_start").val());
  var m_start = parseInt($("#m_start").val());

  var h_end = parseInt($("#h_end").val());
  var m_end = parseInt($("#m_end").val());
  if(h_start > h_end){
    if(h_start == h_end){
      if(m_start >= m_end){
        alert(please_select_course_time_match);
      }
    }
    alert(please_select_course_time_match);
  }else{
    if(h_start == h_end){
      if(m_start >= m_end){
        alert(please_select_course_time_match);
      }
    }
  }
  return false;
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

</script>

<script src="{{ asset ('suksa/frontend/template/js/profileuser.js') }}"></script>
<script src="{{ asset ('suksa/frontend/template/js/datetime.js') }}"></script>
<script language="javascript">
function CheckNumm(){
  var please_enter_number_only = '{{ trans('frontend/courses/title.please_enter_number_only') }}';
  var close_window = '{{ trans('frontend/courses/title.close_window') }}';

  if(event.keyCode < 48 || event.keyCode > 57){
    event.returnValue = false;
    Swal.fire({
         type: 'error',
        title: please_enter_number_only,
        // showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonColor: '#003D99',
        confirmButtonText: close_window,
    })
    }
  }
</script>

{{-- <script>
// numeral
var cleaveNumeral = new Cleave('#course_price', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand'
});
</script> --}}

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
  var data_study = new Date();
  var count_date = 0;
  <?php
    }
  ?>
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

    var please_enter_open_datetime = '{{ trans('frontend/courses/title.please_enter_open_datetime') }}';
    var please_select_valid_open_course_date = '{{ trans('frontend/courses/title.please_select_valid_open_course_date') }}';
    var please_select_course_time_match = '{{ trans('frontend/courses/title.please_select_course_time_match') }}';

    var close_window = '{{ trans('frontend/courses/title.close_window') }}';

        if(txt1=='' || txt2=='' || txt3==''){
            Swal.fire({
              type: 'error',
              title: please_enter_open_datetime,
              // showCloseButton: true,
              showCancelButton: false,
              focusConfirm: false,
              confirmButtonColor: '#003D99',
              confirmButtonText: close_window,
              //text: 'Something went wrong!',
            })
            return false;

        }
        if(count_date==0){

          if(inputDate.setHours(0,0,0,0) < now.setHours(0,0,0,0)){
            Swal.fire({
                type: 'error',
                title: please_select_valid_open_course_date,
                // showCloseButton: true,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonColor: '#003D99',
                confirmButtonText: close_window,
                //text: 'Something went wrong!',
              })
              console.log(now);


            return false;
          }
          if(inputDate.setHours(0,0,0,0) == now.setHours(0,0,0,0)){
            if(h_start < today.getHours()){
            if(h_start == today.getHours()){
                if(m_start <= today.getMinutes()){
                  alert_error(please_select_course_time_match);
                  return false;
                }
            }
            alert_error(please_select_course_time_match);
            return false;
        }else{
            if(h_start == today.getHours()){
                if(m_start <= today.getMinutes()){
                  alert_error(please_select_course_time_match);
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
                title: please_select_valid_open_course_date,
                // showCloseButton: true,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonColor: '#003D99',
                confirmButtonText: close_window,
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
              alert_error(please_select_course_time_match);
              return false;
            }
        }
        alert_error(please_select_course_time_match);
        return false;
    }else{
        if(h_start == h_end){
            if(m_start >= m_end){
              alert_error(please_select_course_time_match);
              return false;
            }
        }
    }


        var remove_button = '{{ trans('frontend/courses/title.remove_button') }}';

        e.preventDefault();
        var controlForm = $('#myRepeatingFields5'),
        currentEntry = $(this).parents('.entry:first');

        $(currentEntry.clone()).appendTo(controlForm).find('input').attr('readonly', 'readonly');

        currentEntry.find('input').val('');

        controlForm.find('.entry:not(:first) .btn-add5')
        .removeClass('btn-add5').addClass('btn-remove')
        .removeClass('btn-dark').addClass('btn-danger')
        .attr('id', count_date)
        .html(remove_button);

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

</script>


<script>
    $(function() {
      var student_email_chk = [];
      var count_student_email = 0;
      <?php
        if(!empty($course)){
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

      var invalid_email = '{{ trans('frontend/courses/title.invalid_email') }}';
      var email_selected = '{{ trans('frontend/courses/title.email_selected') }}';
      var please_enter_require_field = '{{ trans('frontend/courses/title.please_enter_require_field') }}';
      var remove_button6 = '{{ trans('frontend/courses/title.remove_button') }}';

        $(document).on('click', '.btn-add6', function(e) {
            var txt11 = $('#emailstudents').val();
            var email = [];
            $.ajax({
                method: 'GET',
                url: window.location.origin +'/members/get_email_student',
                dataType: 'json',
                async: false,
                success: function(data) {
                    email = data;
                },
                error: function(data) {
                    //error
                }
            });
            //console.log(email);
            const result = email.find(fruit => fruit.member_email === txt11);
            //console.log(result);
            if (typeof result == 'undefined') {
                Swal.fire({
                  type: 'error',
                  confirmButtonColor: '#003D99',
                  title: invalid_email,
                  //text: 'Something went wrong!',
                })
                return false;
            }

            for(i=0; i<student_email_chk.length; i++){
              if(student_email_chk[i]==txt11){
                Swal.fire({
                    type: 'error',
                    confirmButtonColor: '#003D99',
                    title: email_selected,
                    //text: 'Something went wrong!',
                  })
                return false;
              }
            }
            student_email_chk.push(txt11);

            if(txt11==''){
                Swal.fire({
                  type: 'error',
                  title: please_enter_require_field,
                  //text: 'Something went wrong!',
                })
                return false;
            }else if ($('[name="course_student[]"]').length <= 100){
            e.preventDefault();
            var controlForm = $('#myRepeatingFields6'),
            currentEntry = $(this).parents('.entry:first');

            $(currentEntry.clone()).appendTo(controlForm).find('input').attr('readonly', 'readonly');
            currentEntry.find('input').val('');
            controlForm.find('.entry:not(:first) .btn-add6')
            .removeClass('btn-add6').addClass('btn-remove')
            .removeClass('btn-dark').addClass('btn-danger')
            .attr('id', count_student_email)
            .html(remove_button6);
            // console.log(remove_button6);
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
// define variables
var nativePicker = document.querySelector('.nativeTimePicker');
//var fallbackPicker = document.querySelector('.fallbackTimePicker');
//var fallbackLabel = document.querySelector('.fallbackLabel');

var hourSelect = document.querySelector('#hour');
var minuteSelect = document.querySelector('#minute');

// hide fallback initially
//fallbackPicker.style.display = 'none';
//fallbackLabel.style.display = 'none';

// test whether a new date input falls back to a text input or not
var test = document.createElement('input');
test.type = 'time';
// if it does, run the code inside the if() {} block
if(test.type === 'text') {
  // hide the native picker and show the fallback
  nativePicker.style.display = 'none';
  //fallbackPicker.style.display = 'block';
  //fallbackLabel.style.display = 'block';

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

 //hourSelect.onchange = setMinutesToZero;
 //minuteSelect.onchange = setMinutesToZero;
  </script>

<script>

    function showc1(){
      document.getElementById("colorfafa").style.color = "white";
      document.getElementById("colorfafa2").style.color = "black";
    }
    function showc2(){
      document.getElementById("colorfafa").style.color = "black";
      document.getElementById("colorfafa2").style.color = "white";
    }

    function dis()
    {
    student_limit.disabled= !student_limit.disabled;
    }
    function dis2()
    {
    student_limit.disabled= !student_limit.disabled;
    }



</script>

<!-- ปิดปุ่มแก้ไชเมื่อเลือก tab -->
<script language="JavaScript">
    function setVisibility(id, visibility) {
    document.getElementById(id).style.display = visibility;
    }

  $('#datepicker01').datepicker({
      uiLibrary: 'bootstrap4',
      format: 'dd/mm/yyyy',
      autoclose: true,
      todayBtn: true,
  });


var t = false

$('#student_limit').focus(function () {
    var $this = $(this)

    t = setInterval(

    function () {
        var set_limit = 100;
        if (($this.val() < 1 || $this.val() > set_limit) && $this.val().length != 0) {
            if ($this.val() < 1) {
                $this.val(1)
            }

            var please_enter_number_of_students_up_to_10 = '{{ trans('frontend/courses/title.please_enter_number_of_students_up_to_10') }}';
            var close_window = '{{ trans('frontend/courses/title.close_window') }}';

            if ($this.val() > set_limit) {
                $this.val(set_limit)
                Swal.fire({
                  type: 'error',
                  title: '<label style="font-size: 22px;">'+please_enter_number_of_students_up_to_10+'</label>',
                  // showCloseButton: true,
                  showCancelButton: false,
                  focusConfirm: false,
                  confirmButtonColor: '#003D99',
                  confirmButtonText: close_window,
            })
            }
            $('p').fadeIn(1000, function () {
                $(this).fadeOut(500)
            })
        }
    }, 50)
})

    $('#student_limit').blur(function () {
        if (t != false) {
            window.clearInterval(t)
            t = false;

        }

    })

    function clearText()
    {
      document.getElementById('course_price').value = "";
    }

    // function fncSubmit(){

    //   if(document.form1.course_date.value == "")
    //   {
    //     Swal.fire({
    //           type: 'error',
    //           title: 'กรุณากรอกข้อมูลให้ครบ',
    //           // showCloseButton: true,
    //           showCancelButton: false,
    //           focusConfirm: false,
    //           confirmButtonColor: '#003D99',
    //           confirmButtonText: 'ปิดหน้าต่าง',
    //           //text: 'Something went wrong!',
    //         })
    //     document.form1.course_date.focus();
    //     return false;
    //   }
    //   if(document.form1.time_start.value == "")
    //   {
    //     Swal.fire({
    //           type: 'error',
    //           title: 'กรุณากรอกข้อมูลให้ครบ',
    //           // showCloseButton: true,
    //           showCancelButton: false,
    //           focusConfirm: false,
    //           confirmButtonColor: '#003D99',
    //           confirmButtonText: 'ปิดหน้าต่าง',
    //           //text: 'Something went wrong!',
    //         })
    //     document.form1.time_start.focus();
    //     return false;
    //   }
    //   if(document.form1.time_end.value == "")
    //   {
    //     Swal.fire({
    //           type: 'error',
    //           title: 'กรุณากรอกข้อมูลให้ครบ',
    //           // showCloseButton: true,
    //           showCancelButton: false,
    //           focusConfirm: false,
    //           confirmButtonColor: '#003D99',
    //           confirmButtonText: 'ปิดหน้าต่าง',
    //           //text: 'Something went wrong!',
    //         })
    //     document.form1.time_end.focus();
    //     return false;
    //   }
    //   if(document.form1.course_name.value == "")
    //   {
    //     Swal.fire({
    //           type: 'error',
    //           title: 'กรุณากรอกข้อมูลให้ครบ',
    //           // showCloseButton: true,
    //           showCancelButton: false,
    //           focusConfirm: false,
    //           confirmButtonColor: '#003D99',
    //           confirmButtonText: 'ปิดหน้าต่าง',
    //           //text: 'Something went wrong!',
    //         })
    //     document.form1.course_name.focus();
    //     return false;
    //   }
    //   if(document.form1.course_group.value == "")
    //   {
    //     Swal.fire({
    //           type: 'error',
    //           title: 'กรุณากรอกข้อมูลให้ครบ',
    //           // showCloseButton: true,
    //           showCancelButton: false,
    //           focusConfirm: false,
    //           confirmButtonColor: '#003D99',
    //           confirmButtonText: 'ปิดหน้าต่าง',
    //           //text: 'Something went wrong!',
    //         })
    //     document.form1.course_group.focus();
    //     return false;
    //   }
    //   if(document.form1.course_subject.value == "")
    //   {
    //     Swal.fire({
    //           type: 'error',
    //           title: 'กรุณากรอกข้อมูลให้ครบ',
    //           // showCloseButton: true,
    //           showCancelButton: false,
    //           focusConfirm: false,
    //           confirmButtonColor: '#003D99',
    //           confirmButtonText: 'ปิดหน้าต่าง',
    //           //text: 'Something went wrong!',
    //         })
    //     document.form1.course_subject.focus();
    //     return false;
    //   }
    //   if(document.form1.course_detail.value == "")
    //   {
    //     Swal.fire({
    //           type: 'error',
    //           title: 'กรุณากรอกข้อมูลให้ครบ',
    //           // showCloseButton: true,
    //           showCancelButton: false,
    //           focusConfirm: false,
    //           confirmButtonColor: '#003D99',
    //           confirmButtonText: 'ปิดหน้าต่าง',
    //           //text: 'Something went wrong!',
    //         })
    //     document.form1.course_detail.focus();
    //     return false;
    //   }

    //   document.form1.submit();
    // }



function alert_error(title){
  var close_window = '{{ trans('frontend/courses/title.close_window') }}';
  Swal.fire({
        type: 'error',
        title: title,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonColor: '#003D99',
        confirmButtonText: close_window,
    })
}

</script>
<!-- เคลียร์ -->

@stop
