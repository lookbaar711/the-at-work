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
    <style type="text/css">
        .text-profile-noti{
            color: #6ab22a;
            font-size: 16px;
            font-weight: bold;
        }
        .text-head-coins{
            color: rgb(37, 37, 37);
            font-size: 16px;
        }
        .footer-0 {
          top: unset !important;
          position: absolute !important;
          bottom: 0;
          width: 100%
        }
        td, th {
            white-space: nowrap;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<script type="text/javascript">
@if(session('imgprofile')=='success')
    var close_window = '{{ trans('frontend/users/title.close_window') }}';
    var change_profile_image_success = '{{ trans('frontend/users/title.change_profile_image_success') }}';

    Swal.fire({
        title: '<strong>'+change_profile_image_success+'</strong>',
        type: 'success',
        imageHeight: 100,
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonColor: '#28a745',
        confirmButtonText: close_window,
    });
@endif
</script>
<section class="p-t-20 p-b-20">
  {{-- <div class="container">
    <table align="left" >
       <tr>
          <td style="display: inline-block; padding-right: 15px;">
            <div class="circle-grid-profile">
                @if(empty($members->member_img))
                  <img id="myImage" class="circular_image" src="{{ asset ('suksa/frontend/template/images/icons/imgprofile_default.jpg') }}" style="background-size: cover; width: 100%;">
                @else
                  <img id="myImage"  class="circular_image" src="{{ asset ('storage/memberProfile/'.$members->member_img) }}" style="background-size: cover; width: 100%;" >
                @endif
            </div>
          </td>
        </tr>
    </table>
  </div> --}}
</section>
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <label class="fontsize478">@lang('frontend/users/title.hello')
          @if(Auth::guard('members')->user()->member_role=="teacher")
            @lang('frontend/layouts/title.teacher')
          @else
            @lang('frontend/layouts/title.you')
          @endif

          {{ $members->member_fname." ".$members->member_lname }}
        </label>
        <div class="row align-items-center">
            <div class="col-sm-auto">
                {{-- <object class="fontstyle02">@lang('frontend/users/title.your_coins')
                    <label class="fontnum">
                      @if($members->member_coins>0)
                        {{ $members->member_coins }}
                      @else
                        0
                      @endif
                      <img src="{{ asset ('suksa/frontend/template/images/icons/Coins.png') }}" >
                    </label>
                </object> --}}
            </div>

            <div class="col"></div>
            <div class="col-sm-auto" id="sub3" >
                {{-- <label class="btn btn-outline-secondary" for="upload-profile">@lang('frontend/users/title.change_profile_image')</label><input id="upload-profile" name='upload_slip' type="file" style="display:none;" required onchange="upfile(this.files[0])"> --}}

                {{-- <label class="btn btn-outline-secondary " for="editprofile" onclick="edit()">@lang('frontend/users/title.edit_profile')</label> --}}
            </div>
        </div>
      </div>
      <div class="col-md-6" align="right">
        <label class="btn btn-outline-secondary " for="editprofile" onclick="edit()">@lang('frontend/users/title.edit_profile')</label>
      </div>
    </div>
  </div>
</section>
<!-- Group learning -->
<section class="p-t-25 p-b-65">
    <div class="container">
        <div class="tab" role="tabpanel">
            <ul class="nav nav-tabs" id="myTab" role="tablist" style="width: 100%">
                <li class="nav-item">
                    <a class="nav-link user_home @if(!session('active')) active @endif " id="home-tab" data-toggle="tab" href="#user_home" role="tab" aria-controls="profile" aria-selected="true" onclick="setVisibility('sub3', 'inline');";>@lang('frontend/users/title.profile_info')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link user_contact @if(session('active')) active @endif " id="lern-tab" data-toggle="tab" href="#user_lern" role="tab" aria-controls="lern" aria-selected="true"  onclick="setVisibility('sub3', 'none');";>ประวัติการเข้าร่วมประชุม</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link user_alerts" id="alert-tab" data-toggle="tab" href="#user_alerts" role="tab" aria-controls="alert" aria-selected="true"  onclick="setVisibility('sub3', 'none');";>@lang('frontend/users/title.notification_history')</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">

                <div class="tab-pane user_dis_home fade show @if(!session('active')) active @endif   " id="user_home" role="tabpanel" aria-labelledby="home-tab" >
                    <form class="box1" action="" id="data_user_profile" method="POST">
                      <input name="_method" type="hidden" value="PUT">
                      <input name="id_user" id="id_user" type="hidden" value="{{$members->id}}">
                        {{ csrf_field() }}
                        <div class="form-row">
                            <label class="form-group col-md-12" style="font-size: 25px; font-weight: bold; color: #65BB34;"><br>@lang('frontend/users/title.profile_info')</label>
                            <div class="form-row col-12">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4" style="font-size: 16px;">@lang('frontend/users/title.student_email') :</label>
                                    <input type="text" class="form-control" name="" value="{{$members->member_email}}" disabled />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4" style="font-size: 16px;">@lang('frontend/users/title.mobile_no') :</label>
                                    <input type="text" disabled class="form-control" name="member_tell" id="member_tell" maxlength="10" onkeypress="return isNumber(event)" value="{{$members->member_tell}}" required>
                                </div>
                            </div>
                            <div class="form-row col-12">
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4"  style="font-size: 16px; ">@lang('frontend/users/title.first_name') :</label>
                                    <input type="text" disabled class="form-control" name="member_fname"  value="{{$members->member_fname}}" id="member_fname" required/>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4"  style="font-size: 16px; ">@lang('frontend/users/title.last_name') :</label>
                                    <input type="text" disabled class="form-control" name="member_lname" id="member_lname" value="{{$members->member_lname}}"  required/>
                                </div>
                            </div>

                            <hr>

                        </div>
                        <br><br>
                      <div class="col-md-12" >
                          <div class="container">
                              <div class="row">
                                  <div class="col-sm"></div>
                                  <div class="col-sm">
                                      <button type="button" id="submit" onclick="user_profile_edit.users_update();" class=" flex-c-m size2 bo-rad-23 s-text3 bgwhite hov1 trans-0-5 col-12"
                                      style="display: none;"><object class="colorz">@lang('frontend/users/title.edit_button')</object></button>
                                  </div>
                                  <div class="col-sm"></div>
                              </div>
                          </div>
                      </div>
                    </form>
                </div>

                <div class="tab-pane user_dis_contact fade show @if(session('active')) active @endif " id="user_lern" role="tabpanel" aria-labelledby="lern-tab">
                  <div class="form-row">
                    <div class="container" id="user_page_contact"></div>
                  </div>

                  <div class="btn-group pull-right">
                    <nav aria-label="Page navigation example">
                       <ul class="pagination user_page_contact" id="user_page_num">
                      </ul>
                    </nav>
                  </div>
                </div>

                <div class="tab-pane user_dis_alerts fade" id="user_alerts" role="tabpanel" aria-labelledby="alert-tab">
                  <div class="form-row">
                    <div class="container">
                      <div class="form-row">
                        <div class="container" id="user_page_alerts"></div>
                      </div>

                      <div class="btn-group pull-right">
                        <nav aria-label="Page navigation example">
                           <ul class="pagination user_page_alerts" id="user_alerts_page_num"></ul>
                        </nav>
                      </div>
                    </div>
                  </div>
                </div>
            </div>

        </div>
    </div>
</section>
<script src="/suksa/frontend/template/js/user_profile.js"></script>
<script>

var user_profile_edit = {

  users_update:() => {
     var data_user = {
       'id' : $('#id_user').val(),
       "member_fname" : $('#member_fname').val(),
       "member_lname" : $('#member_lname').val(),
       "member_tell" : $('#member_tell').val()
     }
     
     $.ajax({
         url: window.location.origin + '/users/update_profile' ,
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         type: 'post',
         data: {
           'data': data_user,
         },
         dataType: "json",
         success: function(data) {
           Swal.fire({
               title: '<strong>'+data.success+'</strong>',
               type: 'success',
               showConfirmButton: false,
               timer: 500
           });

           setTimeout(function () {
             location.reload();
           }, 1000);
         }
      });
  },

}

function edit(){

  var bank=[];
   $('[name="user_account_number[]"]').each(function() {
    bank.push($(this).val());
   });

   // console.log(bank);

    if(document.getElementById('member_tell').disabled === true){
        document.getElementById('member_tell').disabled = false;
        document.getElementById('member_fname').disabled = false;
        document.getElementById('member_lname').disabled = false;
        document.getElementById('submit').style.display = "block";
        // console.log(1);
        $('.bank_show').hide();
        if (bank) {
          $('#user_option_bank').hide();
        }else {
          $('#user_option_bank').show();
        }
        // console.log("เปิด");

        $('.bank_edit_form').show();
        $('.bank_show_form').hide();
        $('.remove_bankinformation').show();
        $( "#user_bank_name" ).prop( "disabled", false );
        $( "#user_account_number" ).prop( "disabled", false );
        $( "#btn-option_bank" ).prop( "disabled", false );
    }
    else{
      // console.log(bank.length);
      // console.log("ปิด");
        document.getElementById('member_tell').disabled = true;
        document.getElementById('member_fname').disabled = true;
        document.getElementById('member_lname').disabled = true;
        document.getElementById('submit').style.display = "none";

        $('.bank_show').show();
        if (bank.length > 0) {
          $('#user_option_bank').hide();
        }else {
          $('#user_option_bank').show();
        }
        $('.remove_bankinformation').hide();
        $( "#user_bank_name" ).prop( "disabled", true );
        $( "#user_account_number" ).prop( "disabled", true );
        $( "#btn-option_bank" ).prop( "disabled", true );

        // $('.bank_edit_form').hide();
        // $('.bank_show_form').show();
    }

}
function show2(){
    document.getElementById('course_price').disabled = true;
    document.getElementById('course_price').disabled = true;
    document.getElementById('course_price').disabled = false;
}

function upfile(file){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var formData = new FormData();
    formData.append('img', file);

    var close_window = '{{ trans('frontend/users/title.close_window') }}';
    var uploading_profile_image = '{{ trans('frontend/users/title.uploading_profile_image') }}';
    var uploading_profile_image_message = '{{ trans('frontend/users/title.uploading_profile_image_message') }}';
    var upload_profile_image_error = '{{ trans('frontend/users/title.upload_profile_image_error') }}';

    Swal.fire({
        title: uploading_profile_image,
        html: uploading_profile_image_message,
        timer: 100000,
        onBeforeOpen: () => {
            Swal.showLoading()
            timerInterval = setInterval(() => {
                    //.textContent = Swal.getTimerLeft()
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
            location.href = '{{route("users.imgprofile")}}';
            //location.reload();
            //document.getElementById('myImage').src = window.URL.createObjectURL(file)
        },
        error: function(data) {
          Swal.fire({
                title: '<strong>'+upload_profile_image_error+'</strong>',
                type: 'false',
                imageHeight: 100,
                showCloseButton: true,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonColor: '#28a745',
                confirmButtonText: close_window,
            });
        }
    });
}
$(function() {
  $( "#open_model_user_profile_request" ).click(function() {
     $("#model_user_profile_request").modal('show');
  });

  $( "#close_model_user_profile_request2" ).click(function() {
     $("#model_user_profile_request").modal('toggle');
  });

  //Disable cut copy paste
  $('#alert').bind('cut copy paste', function (ee) {
      ee.preventDefault();
  });

  //Disable mouse right click
  $("#alert").on("contextmenu",function(ee){
      return false;
  });

});
</script>

<!-- ปิดปุ่มแก้ไชเมื่อเลือก tab -->
<script language="JavaScript">
function setVisibility(id, visibility) {
// document.getElementById(id).style.display = visibility;
}
</script>
<!-- ปิดปุ่มแก้ไชเมื่อเลือก tab -->
@include('frontend.users.alert')
@stop
