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
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/profile.css') !!}">
    <style>
        .modal-lg {
            max-width: 650px;
        }
        td, th {
            white-space: nowrap;
        }
        .page-item {
          cursor: pointer;
        }
        .footer-0 {
            top: unset !important;
            position: absolute !important;
            bottom: 0;
            width: 100%
        }
    </style>
@endsection
@section('content')
<section class="p-t-50 p-b-20">
    <div class="container">
        <div class="tab-content" id="myTabContent">

            <div style="text-align: right;" ><a href="{{url('teacher')}}" style="color: rgb(7, 7, 7); font-size: 18px;">@lang('frontend/members/title.all_teacher')</a>  / <label style="color: darkgray; font-size: 18px;">@lang('frontend/members/title.teacher_detail')</label></label></div>
            <div id="inner">
                <i class="fa fa-graduation-cap hat" style="font-size: 55px" id="inner"></i>
                <h3>@lang('frontend/members/title.teacher_detail')</h3>

            </div>

        </div>
    </div>
</section>


<!-- แท็ป -->
<section class="p-t-22 p-b-65">
  <div class="container">
    <div class="tab" role="tabpanel">
      <ul class="nav nav-tabs" id="myTab" role="tabpanel">
        <li class="nav-item">
            <a class="nav-link @if(!session('course')) active @endif" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">@lang('frontend/members/title.teacher_detail')</a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">ประวัติการสอน</a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link @if(session('course')=='success') active @endif" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="" aria-selected="false">@lang('frontend/members/title.teaching_history')</a>
            {{-- <a class="nav-link @if(session('course')=='success') active @endif" id="#" data-toggle="#" href="#" role="#" aria-controls="" aria-selected="false">คอร์สเรียนออนไลน์</a> --}}
        </li>
      </ul>

      <div class="tab-content tabs" id="myTabContent">
        <div class="tab-pane fade show @if(!session('course')) active @endif" id="home" role="tabpanel" aria-labelledby="home-tab">
          <form class="box1">
            <div class="container">
              <div class="row">
                <div class="col-sm-3">
                  @if($members->member_img)
                    <img class="img-responsive6 " src="{{ asset ("storage/memberProfile/".$members->member_img) }}" style="width: 100%; height: 300px; object-fit: cover;">
                  @else
                      <img class="img-responsive6  " src="{{ asset ('suksa/frontend/template/images/icons/imgprofile_default.jpg') }}" style="width: 100%; height: 300px; object-fit: cover;">
                  @endif
                </div>
                <div class="col-sm-9">
                    <label class="fontsize478">
                          <label class="teachersize">{{ $members->member_fname." ".$members->member_lname }} {{ isset($members->member_nickname)?" (".$members->member_nickname.")":"" }}</label>
                        </label>
                          <p class="showteacher"> <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_03.png') }}">&nbsp;&nbsp;@lang('frontend/members/title.teacher_email') :  {{$members->member_email}}</p>
                          <p class="showteacher"> <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_04.png') }}">&nbsp;&nbsp;@lang('frontend/members/title.mobile_no') : {{$members->member_tell}}</p>
                          <p class="showteacher"> <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_05.png') }}">&nbsp;&nbsp;@lang('frontend/members/title.line_id') : {{$members->member_idLine}}</p>
                          <p class="showteacher"> <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_07.png') }}">&nbsp;&nbsp;@lang('frontend/members/title.teaching_rate') {{ number_format($members->member_rate_start)."-".number_format($members->member_rate_end)}} @lang('frontend/members/title.coins_per_hour')
                          </p>
                          <div class="row align-items-center">
                            <div class="col">
                            </div>
                          </div>
                </div>
              </div>
            </div>
<hr>

          <div class="col p-l-0" style="text-align: left">

                <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_06.png') }}">&nbsp;&nbsp;
                <label class="teachersize2">@lang('frontend/members/title.education_info') :</label>
                @php $chk_edu='0';  @endphp
                @if(!empty($members->member_education['มัธยมศึกษา']))
                @php $chk_edu='1';  @endphp
                    <p class="showteacher">@lang('frontend/members/title.high_school') {{$members->member_education['มัธยมศึกษา']}}</p>
                @endif
                @if(!empty($members->member_education['ปริญญาตรี']))
                @php $chk_edu='1';  @endphp
                  <p class="showteacher">@lang('frontend/members/title.bachelor') {{$members->member_education['ปริญญาตรี'][0]." ".$members->member_education['ปริญญาตรี'][1]}}</p>
                @endif
                @if(!empty($members->member_education['ปริญญาโท']))
                @php $chk_edu='1';  @endphp
                  <p class="showteacher">@lang('frontend/members/title.master_s_degree') {{$members->member_education['ปริญญาโท'][0]." ".$members->member_education['ปริญญาโท'][1]}}</p>
                @endif
                @if(!empty($members->member_education['ปริญญาเอก']))
                @php $chk_edu='1';  @endphp
                  <p class="showteacher">@lang('frontend/members/title.ph_d') {{$members->member_education['ปริญญาเอก'][0]." ".$members->member_education['ปริญญาเอก'][1]}}</p>
                @endif
                @if($chk_edu=="0")
                  <p>-</p>
                @endif
                <img  style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_07.png') }}">&nbsp;&nbsp;<label class="teachersize2 p-t-15 ">@lang('frontend/members/title.career_info') :</label>
                 @if(!empty($members->member_exp))
                  @foreach ($members->member_exp as $i => $item)
                    <p class="showteacher">{{$item[0]}} @lang('frontend/members/title.position') {{$item[1]}}  @lang('frontend/members/title.work_experience') {{$item[2]}} @lang('frontend/members/title.years')</p>
                  @endforeach
                @else
                  <p>-</p>
                @endif

                <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_08.png') }}">&nbsp;&nbsp;<label class="teachersize2 p-t-15 ">@lang('frontend/members/title.successfully_teaching') :</label>
                @if(!empty($members->member_cong))
                  @foreach ($members->member_cong as $i => $item)
                  <p class="showteacher">{{$item}}</p>
                  @endforeach
                @else
                  <p>-</p>
                @endif
                <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_09.png') }}">&nbsp;&nbsp;<label class="teachersize2 p-t-15 ">@lang('frontend/members/title.aptitude_info') :</label>

                  @foreach (array_keys($members->detail_aptitude) as $i => $key)
                  @if(count($members->detail_aptitude[$key])>0)
                  <p class="showteacher">{{$key}}</p>
                  <p>
                      @foreach ($members->detail_aptitude[$key] as $items)
                        <label  style="color: #6ab22a;">{{$items}}</label>
                      @endforeach
                  </p>
                  @endif
                  @endforeach

              </div>
          </form>
        </div>

        <div class="tab-pane fade show" id="contact" role="tabpanel" aria-labelledby="contact-tab">
          <input type="hidden" name="teacher_id" value="{{ Request::segment(3) }}">
          <input type="hidden" name="user" value="{{ !empty(Auth::guard('members')->user()->id) ? Auth::guard('members')->user()->id : '' }}">
          
          <div id="pagination"></div>
        </div>

      </div>
    </div>
  </div>
     <!-- modal list student -->
     <div class="modal fade" id="modal_student" role="dialog">
        <div class="modal-dialog modal-lg" style="max-width: 900px;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('frontend/members/title.student_list')</h5>
                </div>

                <div class="modal-body p-3">
                    <div  style="overflow-x: auto;">
                        <table class="table table-striped" border="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('frontend/members/title.student_course_register_date')</th>
                                    <th>@lang('frontend/members/title.student_fullname')</th>
                                    <th>@lang('frontend/members/title.student_email')</th>
                                    <th>@lang('frontend/members/title.student_mobile_no')</th>
                                    <th class="private" style="display: none;">@lang('frontend/members/title.student_status')</th>
                                </tr>
                            </thead>
                            <tbody id="student">
    
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-success" data-dismiss="modal">@lang('frontend/members/title.close_button')</button>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- แท็ป -->


@stop

@push('scripts')
  <script src="/suksa/frontend/template/js/pagination-bt4.js"></script>
  <script>
      var students = [];
      let data = {'page': 1,'teacher_id': $('[name="teacher_id"]').val()};
      pagination(data, '/teacher/searach/course', 'teacherCourse');
      async function search_page(page = 1) {
          let data = {
              'page': page,
              'teacher_id': $('[name="teacher_id"]').val()
          };

          await pagination(data, '/teacher/searach/course', 'teacherCourse');
      }

      function showStudent(course_id) {
            STR = '';
            let result = students.find((student) => {
                return student.course_id == course_id;
            });
            let i = 1;
            for (const student of result.student) {
              if (student.category == 'Private') {
                student_status = student.student_status == 1 ? 'ชำระเงินสำเร็จ' : 'รอการชำระเงิน';
                if (students[0].lang == 'en') {
                  student_status = 'Success'
                }
                $('.private').show();
                STR += '<tr><td>'+ i++ +'</td><td>'+moment(student.student_date).format('DD/MM/Y')+'</td><td>'+student.student_name+'</td>';
                STR += '<td>'+student.student_email+'</td><td>'+student.student_tell+'</td><td>'+student_status+'</td><tr>'
              }else {
                $('.private').hide();
                STR += '<tr><td>'+ i++ +'</td><td>'+moment(student.student_date_regis).format('DD/MM/Y')+'</td><td>'+student.student_fname +" "+student.student_lname+'</td>';
                STR += '<td>'+student.student_email+'</td><td>'+student.student_tell+'</td><tr>'
              }
            }
            $('#student').html(STR);
            $('#modal_student').modal('show');
        }
  </script>
@endpush