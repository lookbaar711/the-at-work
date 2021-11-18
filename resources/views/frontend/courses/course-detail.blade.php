@extends('frontend/default')

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
        .colorlink {
    color: rgb(255, 255, 255);
    background: linear-gradient(to left, #42A2EC, #003D99);
    font-family: 'Kanit', sans-serif;
    }
    .card-content  {
      border-style: solid;
      border-color: #f1f1f1;
    }
    </style>
@stop
@section('content')
    <section class="p-t-25 p-b-0">
        <div class="container">
            <div class="tab-content" id="myTabContent">
                <div style="text-align: right;" ><a href="{{url('courses/all')}}" style="color: rgb(7, 7, 7); font-size: 18px;">Conference Room</a> / <label style="color: darkgray; font-size: 18px;">Conference Room Detail</label></div>
            </div>
        </div>
    </section>

    <section class="blog p-t-10 p-b-65">
        <!-- style="background-image: url(../suksa/frontend/template/images/banner005.jpg); background-size: cover; width: 100%;" -->
        <!-- <section id="reviews" class="reviews"> -->
            <form action="" method="get">
                {{-- <input type="hidden" id="time" value="{{ date('d/m/Y', strtotime($courses->course_date)).", ".$courses->course_time_start."-".$courses->course_time_end}}"> --}}
                @if(Auth::guard('members')->user())
                <input type="hidden" id="coins" value="{{Auth::guard('members')->user()->member_coins}}">
                @endif
                <div class="form-row">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-7" style="float: none; margin: 0 auto;">
                                       <img src="{!! asset ("storage/course/".$courses->course_img) !!}" onerror="this.onerror=null;this.src='http://localhost:8000/suksa/frontend/template/images/icons/blank_image.jpg';" class="img-responsive3" >
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm">
                                    <br>

                                    {{-- @if(!empty($courses->course_price))
                                        <label class="free2">{{ number_format($courses->course_price) }} <img style="width: 20px;" src="{{ asset ('suksa/frontend/template/images/icons/Coins.png') }}"></label>
                                        <input type="hidden" id="course_type" value="notfree">
                                        <input type="hidden" id="course_price" value="{{$courses->course_price}}">
                                        <input type="hidden" id="course_price_format" value="{{ number_format($courses->course_price) }}">
                                    @else
                                        <label class="free2">@lang('frontend/courses/title.free_course') </label>
                                        <input type="hidden" id="course_type" value="free">
                                    @endif --}}

                                    <input type="hidden" id="course_type" value="free">
                                    <p class="free3" id="course_name">{{$courses->course_name}}</p>
                                    
                                    <label>วันที่เปิดประชุม</label>
                                    @foreach($courses->course_date as $item)
                                    <p class="">{{date('d/m/Y', strtotime($item['date'])).', '.date('H:i', strtotime($item['time_start']))."-".date('H:i', strtotime($item['time_end']))}}</p>
                                    @endforeach
                                    <br>
                                    <label class="">@lang('frontend/courses/title.detail')</label>
                                    <p class="">{{$courses->course_detail}}</p>
                              </div>
                            </div>
                            <br>
                            <div class="card-content " >
                                    <div class="row p-b-2  p-t-20 p-l-10">
                                        <div class="col-sm-auto">

                                         <div class="circle-grid-profile">
                                            {{-- <a href="{{url('members/detail/'.$members->id)}}"> --}}
                                            @if(empty($members->member_img))
                                                <img id="myImage" class="circular_image" src="{{ asset ('suksa/frontend/template/images/icons/imgprofile_default.jpg') }}" onerror="this.onerror=null;this.src='http://localhost:8000/suksa/frontend/template/images/icons/blank_image.jpg';" style="background-size: cover; width: 100%;">
                                            @else
                                                <img id="myImage"  class="circular_image" src="{{ asset ('storage/memberProfile/'.$members->member_img) }}" onerror="this.onerror=null;this.src='http://localhost:8000/suksa/frontend/template/images/icons/blank_image.jpg';" style="background-size: cover; width: 100%;" >
                                            @endif
                                            {{-- </a> --}}
                                        </div>
                                    </div>
                                    <div class="col-sm-auto  p-t-20">
                                        <p>ผู้สร้างห้องประชุม</p>
                                        {{-- <a href="{{url('members/detail/'.$members->id)}}"> --}}
                                        <p id="teacher" style="color: black;">{{$members->member_fname." ".$members->member_lname}}</p>
                                        {{-- </a> --}}
                                        <p style="color: black;">@lang('frontend/courses/title.teacher_email') : {{$members->member_email}} | @lang('frontend/courses/title.mobile_no') : {{$members->member_tell}} 
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <br>
                              <div class="col-md-12">
                                  <div class="container">
                                    <div class="row">
                                      <div class="col-sm"></div>
                                        <div class="col-sm">
                                          <input type="text" class="" name="check_btn_login" id="check_btn_login" value="{{ Auth::guard('members')->user() }}" style="display:none;">
                                          {{-- @if(Auth::guard('members')->user()) --}}
                                            {{-- @if(Auth::guard('members')->user()->member_type =='student') --}}
                                            @php
                                              // dd(Date('Y-m-d H:i:s'),Date($courses->course_date_start." ".$courses->course_time_start),Date($courses->course_date_start." ".$courses->course_time_start) > Date('Y-m-d H:i:s') );
                                            @endphp
                                              @if($status=='exit')
                                                  <label  class="flex-c-m size2 bo-rad-23 s-text3 bgwhite hov1 trans-0-5 col-12"><object class="colorz">คุณได้ลงทะเบียนแล้ว</object></label>
                                              @elseif($courses->stutent==$courses->course_student_limit)
                                                  <label  class="btn btn-button-close col-12"><object class="colorz">ปิดการลงทะเบียน</object></label>
                                              @elseif($status=='empty')
                                                    @if($courses->course_status=="open")
                                                        @if($courses->course_category=="Private")
                                                          <button onclick="return confirm('{{json_encode($courses->course_date)}}');" class="flex-c-m size2 bo-rad-23 s-text3 bgwhite hov1 trans-0-5 col-12"><object class="colorz">ลงทะเบียน</object></button>
                                                        @else
                                                          <button onclick="return confirm('{{json_encode($courses->course_date)}}');" class="flex-c-m size2 bo-rad-23 s-text3 bgwhite hov1 trans-0-5 col-12"><object class="colorz">ลงทะเบียน</object></button>
                                                        @endif
                                                    @endif
                                              @endif
                                            {{-- @endif --}}
                                          {{-- @endif --}}
                                        </div>
                                      <div class="col-sm"></div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                    </form>
    </section>
    <section class="blog p-t-10">
    </section>

    <script type="text/javascript">
        var close_window = '{{ trans('frontend/courses/title.close_window') }}';
        var please_login = '{{ trans('frontend/layouts/modal.please_login') }}'; 
        
        @if(session('classroom')=='fail')
            var paid_coins_failed = '{{ trans('frontend/courses/title.paid_coins_failed') }}';
            var paid_coins_message = '{{ trans('frontend/courses/title.paid_coins_message') }}';

            Swal.fire({
                    title: '<strong>'+paid_coins_failed+'</u></strong>',
                    imageUrl: '../suksa/frontend/template/images/alert/img_pu_coins02.png',
                    imageHeight: 150,
                    html:
                        paid_coins_message,
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonColor: '#003D99',
                    confirmButtonText: close_window,
            });
        @elseif(session('flash_message'))
            var paid_coins_success = '{{ trans('frontend/courses/title.paid_coins_success') }}';
            var course_name = '{{ trans('frontend/courses/title.course_name') }}';
            var teacher = '{{ trans('frontend/courses/title.teacher') }}';
            var course_date = '{{ trans('frontend/courses/title.course_date') }}';
            var course_price = '{{ trans('frontend/courses/title.course_price') }}';
            var remaining_coins = '{{ trans('frontend/courses/title.remaining_coins') }}';

            Swal.fire({
                title: '<strong>ลงทะเบียนเข้าประชุมสำเร็จ</u></strong>',
                html:
                    '<div class="row">'+
                        '<div class="col-md-4 fontss" align="left">'+
                            '<b style="font-size:14px;" >หัวข้อการประชุม</b> '+
                        '</div>'+
                        '<div class="col fontss" align="left">'+
                            '<label style="font-size:14px;">{{session('flash_message')[0]}}</label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-md-4 fontss" align="left">'+
                            '<b style="font-size:14px;" >ผู้สร้างห้องประชุม</b> '+
                        '</div>'+
                        '<div class="col fontss" align="left">'+
                            '<label style="font-size:14px;">{{session('flash_message')[1]}}</label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-md-4 fontss" align="left">'+
                            '<b style="font-size:14px;">วันที่เปิดประชุม</b> '+
                        '</div>'+
                        '<div class="col fontss" align="left">'+
                            '<label style="font-size:14px;">{{session('flash_message')[2]}}</label>'+
                        '</div>'+
                    '</div>',
                showCloseButton: true,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonColor: '#003D99',
                confirmButtonText: close_window,
            });
        @endif
    
        var request_id = '';
        function confirm(time){
            var course_type = document.getElementById("course_type").value;
            var ck_login = $('#check_btn_login').val();
            if (ck_login != "") {
                free(time);
                return false;
            }
            else {
              Swal.fire({
                type: 'info',
                title: please_login,
                confirmButtonColor: '#003D99',
                confirmButtonText : close_window
              })
              return false;
            }

        }
        function free(time){
            //alert(time);

            var teacher = document.getElementById("teacher").innerText;
            var course_name = document.getElementById("course_name").innerText;
            //var time = document.getElementById("time").value;
            var coins = document.getElementById("coins").value;
            var time = JSON.parse(time);



            var date = '';
            for(i=0; i<time.length; i++){
                var d = new Date(time[i]['date']);
                var formatted_date = d.getDate() + "/" + ("0" + (d.getMonth() + 1)).slice(-2) + "/" + d.getFullYear()
                if(i>0){
                     date += '<div class="col-sm-4" align="left">'+
                                '<b style="font-size:14px;"></b>'+
                        '</div>'+
                        '<div class="col-sm-8" align="left">'+
                            '<p style="font-size:14px;">'+formatted_date+', '+time[i]['time_start'].substring(0, 5)+' - '+time[i]['time_end'].substring(0, 5)+'</p>'+
                        '</div>';
                }else{
                    date += '<div class="col-sm-8" align="left">'+
                            '<p style="font-size:14px;">'+formatted_date+', '+time[i]['time_start'].substring(0, 5)+' - '+time[i]['time_end'].substring(0, 5)+'</p>'+
                        '</div>';
                }
            }



            var course_status = '{{$courses->course_category}}';

            var your_coins = '{{ trans('frontend/courses/title.your_coins') }}';
            var course_register = '{{ trans('frontend/courses/title.course_register') }}';
            var course_name_text = '{{ trans('frontend/courses/title.course_name_text') }}';
            var aptitude = '{{ trans('frontend/courses/title.aptitude') }}';
            var teacher_text = '{{ trans('frontend/courses/title.teacher_text') }}';
            var course_date = '{{ trans('frontend/courses/title.course_date') }}';
            var course_price = '{{ trans('frontend/courses/title.course_price') }}';
            var free = '{{ trans('frontend/courses/title.free') }}';
            var submit_button = '{{ trans('frontend/courses/title.submit_button') }}';
            var paid_button = '{{ trans('frontend/courses/title.paid_button') }}';
            var select = '{{ trans('frontend/courses/title.select') }}';

            $.ajax({
               url: window.location.origin + '/get_request/',
               headers: {
                 "X-CSRF-TOKEN": $('[name="_token"]').val()
               },
               type: 'get',
               dataType: "json",
               success: function(data) {
                  console.log(data);

                   var STR = '';
                    STR += '<option value="">'+select+'</option>';
                     for (var request of data.results) {
                       STR += '<option value="' + request._id + '">' + request.request_topic + '</option>';
                     }
                     //console.log(STR);
                     $('#request_id').html(STR);

               }
             });

            Swal.fire({
              html:
                '<div class="grid">'+
                    
                    '<div class="row">'+
                        '<div class="col" align="center">'+
                            '<h4><b>ลงทะเบียนเข้าประชุม</b></h4><br>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-4" align="left">'+
                            '<b style="font-size:14px;">หัวข้อการประชุม</b> '+
                        '</div>'+
                        '<div class="col" align="left">'+
                            '<p style="font-size:14px;">'+course_name+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-4" align="left">'+
                            '<b style="font-size:14px;">ผู้สร้างห้องประชุม</b> '+
                        '</div>'+
                        '<div class="col" align="left">'+
                            '<p style="font-size:14px;">'+teacher+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-4" align="left">'+
                            '<b style="font-size:14px;">วันที่เปิดประชุม</b>'+
                        '</div>'+
                        date+
                    '</div>'+
                    '<br>'+
                    '<div class="row">'+
                        '<div class="col-md-12" align="center">'+
                        '<a href="'+window.location.origin+'/classroom/save/{{$courses->id}}/null" id="route_save"><button class=" sizepopup bo-rad-23 s-text3 bgwhite hov1 trans-0-5 col colorlink" >ยืนยันการลงทะเบียน</button></div></div></a>'+
                        '</div>'+
                    '</div>'+
                '</div>',
              showCloseButton: true,
              showCancelButton: false,
              focusConfirm: false,
              showConfirmButton: false,
            })
            return false;
        }

        function request(){
            var request_id = document.getElementById("request_id").value;
            // console.log(request_id);
            if(request_id){
                $('#route_save').attr('href',window.location.origin+'/classroom/save/{{$courses->id}}/'+request_id);
            }else{
                $('#route_save').attr('href',window.location.origin+'/classroom/save/{{$courses->id}}/'+'null');
            }

        }


    </script>
@stop
