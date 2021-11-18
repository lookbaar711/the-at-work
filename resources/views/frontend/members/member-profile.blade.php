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
  <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/profile.css') !!}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
      .footer-0 {
        top: unset !important;
        position: absolute !important;
        bottom: 0;
        width: 100%
      }
      .modal-lg {
          max-width: 1100px;
      }
      td, th {
          white-space: nowrap;
      }
      .swal2-container {
        z-index: 10000;
      }

  </style>


@endsection

@section('content')
<script type="text/javascript">
    var close_window = '{{ trans('frontend/layouts/modal.close_window') }}';

    @if(session('course')=='success')

      var create_course_success = '{{ trans('frontend/courses/title.create_course_success') }}';
      var create_course_message = '{{ trans('frontend/courses/title.create_course_message') }}';

      Swal.fire({
              title: '<strong>'+create_course_success+'</u></strong>',
              type: 'success',
              imageHeight: 100,
              html:
                  create_course_message+'<br>',
              showCloseButton: true,
              showCancelButton: false,
              focusConfirm: false,
              confirmButtonColor: '#003D99',
              confirmButtonText: close_window,
      });
    @endif
    @if(session('imgprofile')=='success')
      var change_profile_image_success = '{{ trans('frontend/members/title.change_profile_image_success') }}';

      Swal.fire({
          title: '<strong>'+change_profile_image_success+'</strong>',
          type: 'success',
          imageHeight: 100,
          showCloseButton: true,
          showCancelButton: false,
          focusConfirm: false,
          confirmButtonColor: '#003D99',
          confirmButtonText: close_window,
      });
    @endif
</script>
<!-- Group learning -->

<section class="p-t-20 p-b-50">
  <div class="container">
    <table align="left" >
       <tr>
          <td style="display: inline-block; padding-right: 15px;">
            <div class="circle-grid-profile">
                @if(empty($members->member_img))
                  <img id="myImage" class="circular_image" src="{{ asset ('suksa/frontend/template/images/icons/imgprofile_default.jpg') }}" style="background-size: cover; width: 100%;">
                @else
                  <img id="myImage" class="circular_image" src="{{ asset ('storage/memberProfile/'.$members->member_img) }}" style="background-size: cover; width: 100%;" >
                @endif
              </div>
          </td>
        </tr>
    </table>
  </div>
</section>

<section>
  <div class="container">
    <div class="col">
        <label class="fontsize478">@lang('frontend/members/title.hello')
          @if(Auth::guard('members')->user()->member_role=="teacher")
            @lang('frontend/layouts/title.teacher')
          @else
            @lang('frontend/layouts/title.you')
          @endif

          {{ $members->member_fname." ".$members->member_lname }}
        </label>
        <div class="row align-items-center">
          <div class="col">
            <object class="fontstyle02">@lang('frontend/members/title.your_coins')
              <label class="fontnum">
                @if($members->member_coins>0)
                  {{ $members->member_coins }}
                @else
                  0
                @endif
                <img src="{{ asset ('suksa/frontend/template/images/icons/Coins.png') }}" >
              </label>
            </object>
          </div>
          <div class="col-sm-auto" id="disabled_button">
            <label class="btn btn-outline-secondary" for="upload-profile">@lang('frontend/members/title.change_profile_image')</label>
            <label class="btn btn-outline-secondary" class="get_data_menber" id="edit_data_member">@lang('frontend/members/title.edit_profile')</label>
            <input id="upload-profile" name='upload-profile' type="file" style="display:none;" required onchange="upfile(this.files[0])" accept="image/x-png,image/gif,image/jpeg" >
          </div>

        </div>
    </div>
  </div>
</section>

<!-- Group learning -->
<section class="p-t-25 p-b-65">
  <div class="container">

    <div class="tab" role="tabpanel">
      <ul class="nav nav-tabs" id="myTab" role="tabpanel" style="width: 100%">
        <li class="nav-item">
          <a class="nav-link home @if(!session('course') && !session('alertsuccess') && !session('active')) active @endif" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" onclick="setVisibility('disabled_button', 'inline');";>@lang('frontend/members/title.profile_info')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link contact @if(session('course') || session('alertsuccess') || session('active')) active @endif" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="" aria-selected="false" onclick="setVisibility('disabled_button', 'none');";>@lang('frontend/members/title.teaching_history')</a>
        </li>
        <li class="nav-item">
          <a class="nav-link coins" id="profile-tab" data-toggle="tab" href="#coins" role="tab" aria-controls="profile" aria-selected="false" onclick="setVisibility('disabled_button', 'none');";>@lang('frontend/members/title.coins_history')</a>
        </li>
        <li class="nav-item">
          <a class="nav-link alerts" id="profile-tab" data-toggle="tab" href="#alerts" role="tab" aria-controls="profile" aria-selected="false" onclick="setVisibility('disabled_button', 'none');";>@lang('frontend/members/title.notification_history')</a>
        </li>
        <li class="nav-item">
          <a class="nav-link request"  id="profile-tab" data-toggle="tab" href="#request" role="tab" aria-controls="profile" aria-selected="false" onclick="setVisibility('disabled_button', 'none');";>@lang('frontend/members/title.request_history')</a>
        </li>
      </ul>
      @php
        // dd();
      @endphp

      <div class="tab-content tabs" id="myTabContent">
        <div class="tab-pane fade dis_home show
          @if(!session('course') && !session('alertsuccess') && !session('active') )
            active
          @endif" id="home" role="tabpanel" aria-labelledby="home-tab">
          <form class="box1">
            <div class="form-row">
              <div class="form-group col-md-12">
                  <div class="row ">
                    <div class="col-sm-12">
                        <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_01.png') }}">&nbsp;&nbsp; @lang('frontend/members/title.id_card_no') : <label>{{$members->member_idCard}}</label>
                    </div>
                    <div class="col-sm-12">
                        <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_02.png') }}">&nbsp;&nbsp; @lang('frontend/members/title.birthday') : <label>{{$members->member_Bday->format('d/m/Y')}}</label>
                    </div>
                  </div>
                  <div class="row ">
                    <div class="col-sm-12">
                        <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_03.png') }}">&nbsp;&nbsp; @lang('frontend/members/title.teacher_email') : <label>{{$members->member_email}}</label>
                    </div>
                    <div class="col-sm-12">
                        <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_04.png') }}">&nbsp;&nbsp; @lang('frontend/members/title.mobile_no') : <label>{{$members->member_tell}}</label>
                    </div>
                    <div class="col-sm-12">
                        <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_05.png') }}">&nbsp;&nbsp; @lang('frontend/members/title.line_id') : <label>{{ ($members->member_idLine)?$members->member_idLine:'-' }}</label>
                    </div>
                    <div class="col-sm-12">
                        <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_07.png') }}">&nbsp;&nbsp; <label>
                          @lang('frontend/members/title.teaching_rate') {{number_format($members->member_rate_start)."-".number_format($members->member_rate_end)}} @lang('frontend/members/title.coins_per_hour')
                        </label>
                    </div>
                  </div>
              </div>
            </div>
            <hr style="margin-top: 0px;">
            <div class="form-row">
                <div class="form-group col-md-12">
                <img class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_20.png') }}">&nbsp;&nbsp; <label for="inputAddress" style="font-weight: bold;">@lang('frontend/members/title.bank_information') :</label><br>
                @if (count($members->member_bank))
                  @foreach ($members->member_bank as $key => $value)
                    @if ((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                      <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label">  @lang('frontend/members/title.bank')  : {{ $value['bank_name_en'] }}</label>
                        </div>
                        <div class="col-md-5">
                          <label class="col-form-label">  @lang('frontend/members/title.account_number') : {{ $value['bank_account_number'] }}</label>
                        </div>
                      </div>
                    @else
                      <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label">  @lang('frontend/members/title.bank')  : {{ $value['bank_name_th'] }}</label>
                        </div>
                        <div class="col-md-5">
                          <label class="col-form-label">  @lang('frontend/members/title.account_number') : {{ $value['bank_account_number'] }}</label>
                        </div>
                      </div>
                    @endif
                  @endforeach
                @else
                  @if ((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                    <div class="row">
                      <div class="col-md-6">
                          <label class="col-form-label">  @lang('frontend/members/title.bank')  : - </label>
                      </div>
                      <div class="col-md-5">
                        <label class="col-form-label">  @lang('frontend/members/title.account_number') : - </label>
                      </div>
                    </div>
                  @else
                    <div class="row">
                      <div class="col-md-6 ">
                          <label class="col-form-label">  @lang('frontend/members/title.bank')  : - </label>
                      </div>
                      <div class="col-md-5">
                        <label class="col-form-label">  @lang('frontend/members/title.account_number') : - </label>
                      </div>
                    </div>
                  @endif
                @endif
                </div>
            </div>
            <hr style="margin-top: 0px;">
            <div class="form-row">
                <div class="form-group col-md-12">
                <img class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_06.png') }}">&nbsp;&nbsp; <label for="inputAddress" style="font-weight: bold;">@lang('frontend/members/title.education_info') :</label><br>
                  <div class="row ">
                    @if(!empty($members->member_education['มัธยมศึกษา']))
                    <div class="col-sm-12">
                      @lang('frontend/members/title.high_school') : <label>{{$members->member_education['มัธยมศึกษา']}}</label>
                    </div>
                    @endif

                    @if(!empty($members->member_education['ปริญญาตรี']))
                    <div class="col-sm-12">
                      @lang('frontend/members/title.bachelor') : <label>{{$members->member_education['ปริญญาตรี'][0]}} {{$members->member_education['ปริญญาตรี'][1]}}</label>
                    </div>
                    @endif

                    @if(!empty($members->member_education['ปริญญาโท']))
                    <div class="col-sm-12">
                      @lang('frontend/members/title.master_s_degree') : <label>{{$members->member_education['ปริญญาโท'][0]}} {{$members->member_education['ปริญญาโท'][1]}}</label>
                    </div>
                    @endif

                    @if(!empty($members->member_education['ปริญญาเอก']))
                    <div class="col-sm-12">
                      @lang('frontend/members/title.ph_d') : <label>{{$members->member_education['ปริญญาเอก'][0]}} {{$members->member_education['ปริญญาเอก'][1]}}</label>
                    </div>
                    @endif
                  </div>
                </div>
            </div>
            <hr style="margin-top: 0px;">
            <div class="form-row">
              <div class="form-group col-md-12">
                  <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_07.png') }}">&nbsp;&nbsp;<label for="inputAddress" style="font-weight: bold;">@lang('frontend/members/title.career_info') :</label>
                  @if(!@empty($members->member_exp))
                  @foreach ($members->member_exp as $i => $item)
                      <div class="row ">
                        <div class="col-sm-3">
                          @lang('frontend/members/title.workplace') : <label>{{$item[0]}}</label>
                        </div>
                        <div class="col-sm-3">
                          @lang('frontend/members/title.position') : <label>{{$item[1]}}</label>
                        </div>
                        <div class="col-sm-3">
                          @lang('frontend/members/title.work_experience') : <label>{{$item[2]}}</label>
                        </div>
                      </div>
                  @endforeach
                  @endif
              </div>
            </div>
            <hr style="margin-top: 0px;">
            <div class="form-row">
              <div class="col-sm-12">
                  <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_08.png') }}">&nbsp;&nbsp;<label style="font-weight: bold;">@lang('frontend/members/title.successfully_teaching') :</label>
              </div>
                @if(!@empty($members->member_cong))
                @foreach ($members->member_cong as $i => $item)
                  <div class="col-sm-12">
                    <label>{{$item}}</label>
                  </div>
                @endforeach
                @endif
            </div>
            <hr style="margin-top: 0px;">
            <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_09.png') }}">&nbsp;&nbsp; <label style="font-weight: bold;">@lang('frontend/members/title.aptitude_info')</label>
            <div class="form-group ">
              <div id="myRepeatingFields3">
                <div class="entry form-group  ">
                  @foreach (array_keys($members->detail_aptitude) as $i => $key)
                  @if(count($members->detail_aptitude[$key])>0)
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label>{{$key}} :</label>
                      <p style="color: #6ab22a;">
                        @foreach ($members->detail_aptitude[$key] as $j => $items)
                        @if($j>0)
                        {{","}}
                        @endif
                        {{$items}}
                        @endforeach
                      </p>
                    </div>
                  </div>
                  @endif
                  @endforeach
                </div>
              </div>
            </div>
          </form>
        </div>

        <!-- modal list student -->
        <div class="modal fade" id="myModalProfile" role="dialog">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">@lang('frontend/members/title.student_list')</h5>

              </div>
              <div class="modal-body" id="list_student" style="overflow-x:auto;">

              </div>
              <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-success" data-dismiss="modal">@lang('frontend/members/title.close_button')</button>
              </div>
            </div>
          </div>
        </div>

        <div class="tab-pane fade dis_contact show @if(session('course') || session('alertsuccess') || session('active')) active @endif" id="contact" role="tabpanel" aria-labelledby="contact-tab">
          <div class="container">
            <div class="row">
              <div class="col-sm"></div>
              <div class="col-sm"></div>
              <div class="col-sm-3">
                <a href="{{ route('courses.create') }}" class="flex-c-m size2 bo-rad-23 s-text3 bgwhite hov1 trans-0-5 "><object class="colorz" style="font-size: 16px;" > <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;@lang('frontend/members/title.create_course')</object> </a>
              </div>
            </div>
          </div>
          <hr/>
            <div class="container" id="page_contact"></div>

            <div class="btn-group pull-right">
              <nav aria-label="Page navigation example">
                 <ul class="pagination page_contact" id="page_num">
                </ul>
              </nav>
            </div>
        </div>
        {{-- profile_coins --}}
        {{-- @include('frontend.members.member-profile_coins') --}}

        <div class="tab-pane fade dis_coins" id="coins" role="tabpanel" aria-labelledby="profile-tab">
          <div class="form-row">
            <div class="container">
              <div class="form-row">
                <div class="container" id="page_coins"></div>
              </div>
              <div class="btn-group pull-right">
                <nav aria-label="Page navigation example">
                   <ul class="pagination page_coins" id="coins_page_num">
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>

        {{-- profile_alerts --}}
        {{-- @include('frontend.members.member-profile_alerts') --}}
        <div class="tab-pane fade dis_alerts" id="alerts" role="tabpanel" aria-labelledby="profile-tab">
          <div class="form-row">
            <div class="container">
              <div class="form-row">
                <div class="container" id="page_alerts"></div>
              </div>

              <div class="btn-group pull-right">
                <nav aria-label="Page navigation example">
                   <ul class="pagination page_alerts" id="alerts_page_num"></ul>
                </nav>
              </div>

            </div>
          </div>
        </div>


        <div class="tab-pane fade dis_request" id="request" role="tabpanel" aria-labelledby="profile-tab">
          <div class="container">
            <div class="form-row">
              <div class="container" id="page_request"></div>
            </div>

              <div class="btn-group pull-right">
                <nav aria-label="Page navigation example">
                   <ul class="pagination page_request" id="alerts_page_request"></ul>
                </nav>
              </div>
          </div>
        </div>

        @include('frontend.members.modal_request_detal')
        {{-- profile_request --}}
        {{-- @include('frontend.members.member-profile_request') --}}

        {{-- Model Request Subjects --}}
        @include('frontend.members.model_profile_request')
        {{-- Model ประวัติการสอน --}}
        @include('frontend.members.modal_list_student')
        @include('frontend.members.modal_list_student_private')

        @include('frontend.members.member-profile-edit')

      </div>
    </div>
  </div>
</section>

<script src="/suksa/frontend/template/js/member_profile.js"></script>
<script src="/suksa/frontend/template/js/member_profile_edit.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script> --}}
<script>

function upfile(file){
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var formData = new FormData();
  formData.append('img', file);

  var close_window = '{{ trans('frontend/layouts/modal.close_window') }}';
  var uploading_profile_image = '{{ trans('frontend/members/title.uploading_profile_image') }}';
  var uploading_profile_image_message = '{{ trans('frontend/members/title.uploading_profile_image_message') }}';
  var upload_profile_image_error = '{{ trans('frontend/members/title.upload_profile_image_error') }}';

  Swal.fire({
    title: uploading_profile_image,
    html: uploading_profile_image_message,
    timer: 100000,
    onBeforeOpen: () => {
        Swal.showLoading()
        timerInterval = setInterval(() => {
        }, 100)
    },
    onClose: () => {
        clearInterval(timerInterval)
    }
    }).then((result) => {
        if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.timer
        ) {
            console.log('I was closed by the timer')
        }
    })
    $.ajax({
      url: "/imgprofile",
      data: formData,
      contentType: false,
      cache: false,
      processData: false,
      type: "POST",
      success: function(data) {
        location.href = '{{route("members.imgprofile")}}';
      },
      error: function(data) {
        Swal.fire({
          title: '<strong>'+upload_profile_image_error+'</strong>',
          type: 'false',
          imageHeight: 100,
          showCloseButton: true,
          showCancelButton: false,
          focusConfirm: false,
          confirmButtonColor: '#003D99',
          confirmButtonText: close_window,
        });
      }
    });
  }

  function show_student(course_id){
    var list_student = '';
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    var data = {
        course_id : course_id
    }
    $.ajax({
            url: "{{ URL::to('members/list_student') }}",
            data: data,
            type: "POST",
            success: function(data) {
              console.log(data);
              document.getElementById("list_student").innerHTML = data;
              // for(i=0; i<data.length; i++){
              //   list_student =+ '<tr>'+
              //                     '<td>'+data[0].student_fname+'</td>'+
              //                     '<td>'+data[0].student_fname+'</td>'+
              //                     '<td></td>'+
              //                     '<td></td>'+
              //                   '</tr>';
              // }
              // $('#list_student').innerHTML = data;
            },
            error: function(data) {
              console.log(data);
            }
          });
  }

  function open_course(course_id){
        var confirm_open_register = '{{ trans('frontend/members/title.confirm_open_register') }}';
        var confirm_open_register_message_1 = '{{ trans('frontend/members/title.confirm_open_register_message_1') }}';
        var confirm_open_register_message_2 = '{{ trans('frontend/members/title.confirm_open_register_message_2') }}';
        var submit_button = '{{ trans('frontend/members/title.submit_button') }}';
        var cancel_button = '{{ trans('frontend/members/title.cancel_button') }}';

        Swal.fire({
              html:
                '<div class="grid">'+
                    '<div class="row">'+
                        '<div class="col" align="center">'+
                            '<h3><b>'+confirm_open_register+'</b></h3>'+
                            '<p></b></p>'+
                        '</div>'+
                    '</div><br>'+
                    '<div class="row">'+
                        '<div class="col" align="center">'+
                            '<label>'+confirm_open_register_message_1+'<label>'+
                            '<label>'+confirm_open_register_message_2+'</label>'+
                        '</div>'+
                    '</div>'+
                '</div>',
              showCancelButton: !0,
              confirmButtonText: submit_button,
              confirmButtonColor: '#003D99',
              cancelButtonText: cancel_button,
              reverseButtons: !0
        }).then((result) => {
            if (result.value) {
              location.href = '{{ URL::to('courses/opencourse/') }}'+'/'+course_id;
            }
        })
        //return false;
  }

  // ปิดปุ่มแก้ไชเมื่อเลือก tab
  function setVisibility(id, visibility) {
    document.getElementById(id).style.display = visibility;
  }

  $(function() {
    $( "#open_model_profile_request" ).click(function() {
       $("#model_profile_request").modal('show');
    });

    $( "#close_model_profile_request2" ).click(function() {
       $("#model_profile_request").modal('toggle');
    });

    $( "#edit_data_member" ).click(function() {
       $("#model_profile_edit").modal('show');
    });


    //Disable cut copy paste
    $('#alerts').bind('cut copy paste', function (ee) {
        ee.preventDefault();
    });

    //Disable mouse right click
    $("#alerts").on("contextmenu",function(ee){
        return false;
    });

    if ( $('.nav-link.contact').hasClass('active') ) {
      profile_contact.contact(); // เรียกฟังชั้น ประวัติการสอนให้ทำงาน
    }

    $("#edit_data_member").click(function () {
      // alert("ddddddd");
      get_profile_member.data_profile_member();
    });

  });

</script>

@include('frontend.users.alert')

@stop
