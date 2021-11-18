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

<section class="p-t-25 p-b-65">
    <div class="container">
        <div class="tab" role="tabpanel">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link request_home @if(!session('active')) active @endif " id="profile-tab" data-toggle="tab" href="#request_profile" role="tab" aria-controls="profile" aria-selected="true">@lang('frontend/users/title.profile_info')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link request_contact @if(session('active')) active @endif " id="lern-tab" data-toggle="tab" href="#request_lern" role="tab" aria-controls="lern" aria-selected="true" >@lang('frontend/users/title.course_register_history')</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <br>
                <div class="tab-pane request_home fade show @if(!session('active')) active @endif   " id="request_profile" role="tabpanel" aria-labelledby="profile-tab" >
                    <input type="text" name="members_id" id="members_id" value="{{$members->id}}" style="display:none;">
                    {{ csrf_field() }}
                    <div class="container">
                      <div class="row">
                        <div class="col-sm-3">
                          @if(empty($members->member_img))
                            <img id="myImage" class="img-responsive6" src="{{ asset ('suksa/frontend/template/images/icons/imgprofile_default.jpg') }}" style="width: 100%; height: 300px; object-fit: cover;" >
                          @else
                            <img id="myImage"  class="img-responsive6" src="{{ asset ('storage/memberProfile/'.$members->member_img) }}" style="width: 100%; height: 300px; object-fit: cover;" >
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label class="fontsize478">
                            <label class="teachersize">{{ $members->member_fname." ".$members->member_lname }}</label>
                          </label>
                          <p class="showteacher"> <img class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_03.png') }}">&nbsp;&nbsp;@lang('frontend/users/title.student_email') : {{$members->member_email}}</p>
                          <p class="showteacher"> <img class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_04.png') }}">&nbsp;&nbsp;@lang('frontend/users/title.mobile_no') : {{$members->member_tell}}</p>
                          <div class="row align-items-center">
                            <div class="col"></div>
                          </div>
                        </div>
                        {{-- <div class="col-sm-3">
                          <button type='button' class='btn flex-c-m size2 bo-rad-23 color7 col-8'>
                              <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_10.png') }}">&nbsp; <p style='color: white; margin-top: -4px;'> ส่งข้อความ</p>
                          </button>
                        </div> --}}
                    </div>
                  </div>
                </div>

                <div class="tab-pane request_dis_contact fade show @if(session('active')) active @endif " id="request_lern" role="tabpanel" aria-labelledby="lern-tab">
                  <div class="form-row">
                    <div class="container" id="request_page_contact"></div>
                  </div>
                  <div class="btn-group pull-right">
                    <nav aria-label="Page navigation example">
                       <ul class="pagination request_page_contact" id="request_page_num">
                      </ul>
                    </nav>
                  </div>
                </div>

        </div>
    </div>
</section>
<script>

$(function() {

  $(".request_home").click(function () {
    $(".request_dis_home").css("display", "inline");
    $(".request_dis_contact").css("display", "none");
  });

  $(".request_contact").click(function () {
    request_profile_contact.contact();
    $(".request_dis_home").css("display", "none");
    $(".request_dis_contact").css("display", "inline");
  });
  //-------------------------------------------------------------------------------

  $(document).on('click', '.request_page_contact a', function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    request_fetch_data_contact(page);
   });

  function request_fetch_data_contact(page) {
    $.ajax({
      url: "/get/request_profile_contact",
      method:'post',
      data:{
          page: page,
          'id': $('#members_id').val(),
          _token: $('input[name="_token"]').val()
      },
      success:function(data) {
        request_profile_contact.new_page_contact(JSON.parse(data));
      },
    });
  }
  //-------------------------------------------------------------------------------

});

var request_profile_contact = {
  data: false,
  contact:() => {
    $.ajax({
      url: window.location.origin + '/get_date/request_profile_contact',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      data: {
        'id': $('#members_id').val(),
      },
      dataType: "json",
      success: function(data) {
        // console.log(data);
        request_profile_contact.new_page_contact(data);


      }
    });
  },

  new_page_contact : (data) => {
      request_profile_contact.data = {data : data};
      var contact ='';
       $.each(data.cousres.courses.data, function(key, value) {

        var price = '';
        if (value.course_price) {
           price = '<p class="notfree">'+value.course_price.toLocaleString(undefined, {minimumFractionDigits: 0})+' Coins</p>';
        }else {
          price = '<p class="free">'+data.free_course+'</p>';
        }

        if(value.student==1){
          var show_text_student = data.student;
        }
        else{
          var show_text_student = data.student+'s';
        }

        var icon = '<i class="fa fa-users " style="font-size:16px;"></i> <label>'+ value.student +' '+ show_text_student +'</label>';

        var course_file = '';
        if (value.course_file) {
           course_file = '<p style=" color: black;"><i class="fa fa-file" style="font-size:16px;"></i>&nbsp;1 '+data.course_document+' <a style="color: #3990F2; border-bottom: 1px solid #3990F2;" href="'+window.location.origin+'/storage/coursefile/'+value.course_file+'" download>'+data.download_button+'</a></p>';
        }else {
          course_file = '<p style=" color: black;"><i class="fa fa-file" style="font-size:16px;"></i>&nbsp; '+data.course_document+'</p>';
        }


        var btn = '';
        // if (value.status_show == "true") {
        //   $.each(value.course_date, function(index, el) {
        //     if (moment(Date.now()).format('DD/MM/Y HH:mm:ss') < moment(el.date+" "+el.time_end).format('DD/MM/Y HH:mm:ss')) {
        //       btn = `<a href="`+window.location.origin+`/classroom/check/`+value.link_open+`" class="btn  button-s" target="_blank" style="margin-top: 0px; margin-top: 0px; background: #6ab22a; color: white;" >เข้าห้องเรียน </a> <a href="`+window.location.origin+`/courses/`+value._id+`" class="btn btn-outline-dark  " style="border-radius: 20px; font-size: 14px">`+data.course_detail+`</a>`;
        //     }else {
        //       btn = `<a href="`+window.location.origin+`/courses/`+value._id+`" class="btn btn-outline-dark" style="border-radius: 20px; font-size: 14px">`+data.course_detail+`</a>`;
        //     }
        //   });
        // }
        // else {
          var btn = ``;

          if(value.check_assess == '1'){
            btn += `<a href="`+window.location.origin+`/rating/show_student_rating/`+value.rating_id+`" class="btn button-s col-sm-6 col-md-4" target="_blank" style="margin-top: 0px; margin-top: 0px; background: #6ab22a; color: white;" >`
                      +data.review_button+` </a> `;
          }

          btn += `<a href="`+window.location.origin+`/courses/`+value._id+`" class="btn btn-outline-dark col-sm-12 col-md-6" style="border-radius: 20px; font-size: 14px;">`+data.course_detail+`</a>`;
          // btn = '<button onclick="open_course(`'+value._id+'`)" class="btn status-commingsoon" >'+data.waiting_register+'</button> <a href="'+window.location.origin+'/courses/'+value._id+'/edit " class="btn btn-outline-dark" style="border-radius: 20px; font-size: 14px">'+data.course_create+'</a>';
        // }

        // var date_1 = ;
        var course_date = '';
        var date_1 = '';

        for (var i = 0; i < value.course_date.length; i++) {
          // console.log(value.course_date.length);
          if (i > 0) {
              date_1 = moment(value.course_date[0].date).format('DD/MM/Y');
              date_2 = moment(value.course_date[i].date).format('DD/MM/Y');
              date_3 = date_1+" - "+date_2;
              course_date = date_3;
          }else {
            date_1 = moment(value.course_date[0].date).format('DD/MM/Y');
            course_date = date_1;
          }
        }


          contact += `
          <div class="form-row">
              <div class="container">
                <div class="row">
                <div class="col-sm-4"> <img src="`+window.location.origin+`/storage/course/`+value.course_img+`" onerror="this.onerror=null;this.src='http://localhost:8000/suksa/frontend/template/images/icons/blank_image.jpg';" class="img-responsive"></div>
                  <div class="col-sm-5">
                    <p class="fs-16 text-profile-noti overflow_course">`+value.course_name+`</p>
                    <p class="fs-16 header-noti">`+price+`</p>
                    <p class="fs-16 header-noti">`+value.course_group+" "+value.course_subject+`</p>
                    <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+course_date+`</p>
                    <p style=" color: black;">`+icon+`</p>
                    `+course_file+`
                  </div>
                  <div class="col-sm-3 p-l-0 p-r-0" style="align-self: center; text-align: right;">
                    <br>
                    `+btn+`
                  </div>
              </div>
            </div>
          </div>
          <hr>
            `;

      });
      $('#request_page_contact').html(contact);
     //

     STR = '';
     var data = data.cousres.courses;
     let li = '';

     for (let page = 1; page <= data.last_page; page++) {
         if (page == data.current_page) {
             li += `<li class="page-item active"><a class="page-link">${page}</a></li>`;
         }else if(data.last_page < 7) {
             li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
         }else{
             if ((data.last_page / 2) < data.current_page) {
                 if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                     if (page == data.current_page - 1 && data.current_page != data.last_page) {
                         li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                     }
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`; // -
                 } else if (data.current_page == data.last_page && page == data.current_page - 2) {
                     li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                 }else if (page == 1 || page == 2) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                 }
             }else {
                 if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`; // +
                     if (page == data.current_page + 1 && data.current_page != 1) {
                         li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                     }
                 } else if (data.current_page == 1 && page == data.current_page + 2) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                     li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                 }else if (page == data.last_page - 1 || page == data.last_page) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                 }
             }
         }
     }

     STR += `
         <hr>
         <nav aria-label="Page navigation example">
             <ul class="pagination justify-content-end">
                 <li class="page-item">
                 <a class="page-link" aria-label="Previous" href="`+ data.prev_page_url +`">
                     <span aria-hidden="true">&laquo;</span>
                     <span class="sr-only">Previous</span>
                 </a>
                 </li>
                 ${li}
                 <li class="page-item">
                 <a class="page-link" href="`+ data.next_page_url +`"  aria-label="Next">
                     <span aria-hidden="true">&raquo;</span>
                     <span class="sr-only">Next</span>
                 </a>
                 </li>
             </ul>
         </nav>`;

         if (data.total >= 3) {
           $('#request_page_num').html(STR);
         }


  }
}

</script>
@stop
