<!doctype html>

<?php 
    if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
        App::setLocale('en');
    }
    else{
        App::setLocale('th'); 
    }
?>

<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title>Suksa</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
<meta name="viewport" content="width=device-width">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">

<!-- fonts kanit -->
<link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" /> -->

<!-- CSS Files -->
<link href="{!! asset('suksa/frontend/template/login_register/assets/css/bootstrap.min.css') !!}" rel="stylesheet">
<link href="{!! asset('suksa/frontend/template/login_register/assets/css/material-bootstrap-wizard.css') !!}" rel="stylesheet">

<!-- CSS Just for demo purpose, don't include it in your project -->
<link href="{!! asset('suksa/frontend/template/login_register/assets/css/demo.css') !!}" rel="stylesheet">

<!-- CSS Just for demo purpose, don't include it in your project -->
<link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/buttons.css') !!}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="{!! asset('suksa/frontend/template/css/profile-create.css') !!}" rel="stylesheet">

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript" src="https://unpkg.com/default-passive-events"></script>

<!-- วันที่ -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.css" rel="stylesheet" id="bootstrap-css">
<!-- วันที่ -->

<style type="text/css">
    .disble-a{
        pointer-events: none;
        cursor: default;
    }
</style>
</head >

<body class="backgroundimg" style="background-image: url(../../../suksa/frontend/template/images/banner.jpg);"><!--background-image: url(../suksa/frontend/template/images/banner.jpg); background-size: cover;-->
<!--   Big container   -->

<div class="container">
<div class="row">
    <div class="col-sm-12 ">
        <!--      Wizard container        -->
        <div class="wizard-container">
            <section class="p-t-2 p-b-2">
                <label><a href="{{url('')}}" style="color: rgb(7, 7, 7); font-size: 18px;">@lang('frontend/members/title.main')</a></label> / 
                <label><a href="#"style="color: darkgray; font-size: 18px;">@lang('frontend/members/title.teacher_register')</a></label>
            </section>
            <div class="card wizard-card" data-color="green" id="wizardProfile">
                <form role="form" method="POST" id="form_id" action="{{ route('members.store') }}" enctype="multipart/form-data" autocomplete="off">
                    {{ csrf_field() }}
                    <input type="hidden" name="member_update" id="member_update" value="{{$members->_id}}">
                    <div class="wizard-header">
                        <h3 class="wizard-title">
                            @lang('frontend/members/title.teacher_register')
                        </h3>
                    </div>
                    <div class="wizard-navigation" >
                        <ul>
                            <li><a href="#tab1" data-toggle="tab" class="disble-a" style="font-size: 16px" require>@lang('frontend/members/title.authentication_info')</a></li>
                            <li><a href="#tab2" data-toggle="tab" class="disble-a" style="font-size: 16px" require>@lang('frontend/members/title.profile_info')</a></li>
                            <li><a href="#tab3" data-toggle="tab" class="disble-a" style="font-size: 16px">@lang('frontend/members/title.education_info')</a></li>
                            <li><a href="#tab4" data-toggle="tab" class="disble-a" style="font-size: 16px">@lang('frontend/members/title.career_info')</a></li>
                            <li><a href="#tab5" data-toggle="tab" class="disble-a" style="font-size: 16px">@lang('frontend/members/title.successfully_info')</a></li>
                            <li><a href="#tab6" data-toggle="tab" class="disble-a" style="font-size: 16px">@lang('frontend/members/title.aptitude_info')</a></li>
                            <li><a href="#tab7" data-toggle="tab" class="disble-a" style="font-size: 16px">@lang('frontend/members/title.attach_files')</a></li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane" id="tab1" >
                            <span id="alertMessage" class="alertMessage"></span>
                            <div class="row" >
                                <div class="col-sm-6 col-sm-offset-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/members/title.teacher_email') : <span style="color: red; font-size: 20px;">*</span></label>
                                        <input type="email" name="member_email" id="member_email" value="{{$members->member_email}}" class="form-control formEmail" required autocomplete="off">
                                        {{-- onblur="checkEmail();" --}}
                                        <div class="emailFormAlert" id="divCheckEmail"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sm-offset-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/members/title.teacher_password') : <span style="color: red; font-size: 20px;">*</span></label>
                                        <input type="password" name="member_password" id="member_password" value="{{$members->member_real_password}}" class="form-control" required autocomplete="on" onChange="checkPasswordMatch();">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/members/title.teacher_confirm_password') : <span style="color: red; font-size: 20px;">*</span></label>
                                       <input type="password" name="password_confirmation" id="password_confirmation" value="{{$members->member_real_password}}" class="form-control" required autocomplete="on" onChange="checkPasswordMatch();">
                                       <div class="registrationFormAlert" id="divCheckPasswordMatch"></div>
                                    </div>
                                </div>

                                <input type="hidden" name="correct_password" id="correct_password" value="@lang('frontend/members/title.correct_password')">
                                <input type="hidden" name="incorrect_password" id="incorrect_password" value="@lang('frontend/members/title.incorrect_password')">

                                <input type="hidden" name="current_lang" id="current_lang" value="{{ Config::get('app.locale') }}">
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2"> 
                            <div class="col-sm-12" align="center">
                                <div class="upload-btn-wrapper">
                                    <div class="circle-grid-profile">
                                        <div class="circle-image">
                                            @if($members->member_img!="")
                                                <img id="up" class="circular_image" src="{{ asset('storage/memberProfile/'.$members->member_img) }}" style="width: 100%; " >
                                                <input type="hidden" value="{{ $members->member_img }}" name="update_img">
                                            @else
                                                <img id="up" class="circular_image" src="{{ asset('suksa/frontend/template/images/icons/imgprofile_upload.jpg') }}" style="width: 100%; " >
                                            @endif
                                            
                                            <img id="membet_img_file" class="circular_image" src=""  style="background-size: cover; width: 100%;">
                                            <input type="file" name="member_img" id="member_img" accept="image/x-png,image/gif,image/jpeg" onchange="upfile(this.files[0])">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size: 16px;">
                                            @lang('frontend/members/title.id_card_no') : <span style="color: red; font-size: 20px;">*</span></label>
                                        <input type="text" name="member_idCard" id="member_idCard" value="{{$members->member_idCard}}" maxlength="13" class="form-control" autocomplete="cc-exp" required onkeyup="checkNumberOnly(this.id)">
                                        <span style="font-size: 10px; color:#569c37;">@lang('frontend/members/title.secret_data_text')</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">  
                                    <div class="form-group label-floating">     
                                        <label class="control-label">@lang('frontend/members/title.birthday') : <span style="color: red; font-size: 20px;">*</span></label>

                                        <div class='input-group date' id='datepicker'>
                                            <input type='text' name="member_Bday" id="member_Bday" value="{{$members->member_Bday->format('d/m/Y')}}" class="form-control" required readonly>
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2 col-sm-offset-2">       
                                    <div class="form-group">         
                                        <select name="member_sername" id="member_sername" class="form-control input-md" style="font-size: 16px;" required>
                                            <option value="" style="font-size: 16px;" disabled="" selected="">- @lang('frontend/members/title.prefix') -</option>
                                            <option value="mr" 
                                            @if($members->member_sername=='mr') selected 
                                            @endif>@lang('frontend/members/title.mr')</option>
                                            <option value="mrs" 
                                            @if($members->member_sername=='mrs') selected 
                                            @endif>@lang('frontend/members/title.mrs')</option>
                                            <option value="miss" 
                                            @if($members->member_sername=='miss') selected @endif>@lang('frontend/members/title.miss')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3" >
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/members/title.first_name') : <span style="color: red; font-size: 20px;">*</span></label>
                                        <input type="text" name="member_fname" id="member_fname" value="{{$members->member_fname}}" class="form-control" required autocomplete="none" onkeyup="return checkTextOnly(this.id)"> 
                                        <span style="font-size: 10px; color: red;" id="warning_text_member_fname"></span>
                                    </div>
                                </div>
                                <div class="col-sm-3" >
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/members/title.last_name') : <span style="color: red; font-size: 20px;">*</span></label>
                                        <input type="text" name="member_lname" id="member_lname" value="{{$members->member_lname}}" class="form-control" required autocomplete="none" onkeyup="return checkTextOnly(this.id)">
                                        <span style="font-size: 10px; color: red;" id="warning_text_member_lname"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2 col-sm-offset-2" >
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/members/title.nickname')</label>
                                        <input type="text" name="member_nickname" id="member_nickname" value="{{$members->member_nickname}}" class="form-control" autocomplete="none" onkeyup="return checkTextOnly(this.id)">
                                        <span style="font-size: 10px; color: red;" id="warning_text_member_nickname"></span>
                                    </div>  
                                </div>
                                <div class="col-sm-3  ">               
                                     <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/members/title.mobile_no') : <span style="color: red; font-size: 20px;">*</span></label>
                                        <input type="text" name="member_tell" id="member_tell" value="{{$members->member_tell}}"  maxlength="10" required class="form-control" autocomplete="none" onkeyup="checkNumberOnly(this.id)">
                                        <span style="font-size: 10px; color: red;" id="warning_text_member_tell"></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">                
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/members/title.line_id') : <span style="color: red; font-size: 20px;">*</span></label>
                                        <input type="text" name="member_idLine" id="member_idLine" value="{{$members->member_idLine}}" class="form-control" autocomplete="none" required>
                                    </div>
                                </div>
                            </div> 
                            <!--ปิดเลือกคำนำหน้า -->
                            <div class="row">        
                                <div class="col-sm-4  col-sm-offset-2"> 
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/members/title.min_price') : <span style="color: red; font-size: 20px;">*</span></label>
                                        <input type="text" name="member_rate_start" id="member_rate_start" value="{{$members->member_rate_start}}" class="form-control" autocomplete="none" required onkeyup="checkNumberOnly(this.id)">
                                        {{-- onkeypress="return isNumber(event)" OnChange="JavaScript:chkNum(this)" --}}
                                        <p style="color: #569c37; font-size: 10px;">@lang('frontend/members/title.price_range')@lang('frontend/members/title.coins_hour')</p>
                                    </div>
                                </div>
                                <div class="col-sm-4">  
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/members/title.max_price') : <span style="color: red; font-size: 20px;">*</span></label>
                                        <input type="text" name="member_rate_end" id="member_rate_end" value="{{$members->member_rate_end}}" class="form-control phd" autocomplete="none" required onkeyup="checkNumberOnly(this.id)">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2" >
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/members/title.current_address') : <span style="color: red; font-size: 20px;">*</span></label>
                                        <input type="text" name="member_address" id="member_address" value="{{$members->member_address}}" class="form-control phd" autocomplete="none" required>

                                        {{-- <textarea type="text" name="member_address" id="member_address" class="form-control" autocomplete="none" rows="1" role="3" required></textarea> --}}
                                     </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <div class="form-group">
                                        <select name="member_event" id="member_event" class="form-control input-md" style="font-size: 16px;">
                                            <option value="" style="font-size: 16px; color:#A9A9A9;" disabled="" selected="">- @lang('frontend/members/title.event') -</option>
                                            @foreach($events as $index => $item)
                                                <option value="{{ $item->_id }}" style="color:black;" 
                                                @if(isset($members->event_id) && ($members->event_id==$item->_id)) selected @endif>{{ $item->event_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group label-floating">
                                        {{-- <label class="control-label">@lang('frontend/members/title.promotion_code')</label>
                                        <input type="text" name="promotion_code" id="promotion_code" value="{{$members->promotion_code}}" class="form-control"> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <div class="row">                                             
                                <div class="col-sm-2 col-sm-offset-1">
                                    <div class="input-group ">                      
                                        <div class="form-group label-floating">          
                                            <input type="checkbox" name="member_education1" id="member_education1" class="option-input checkbox" 
                                            @if(!empty($members->member_education['มัธยมศึกษา']))
                                                checked
                                            @endif
                                            >&nbsp;&nbsp;
                                            <label>@lang('frontend/members/title.high_school')</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group label-floating">
                                        <label>@lang('frontend/members/title.school')</label>
                                        <input type="text" name="member_institution1" id="member_institution1" class="form-control"  
                                        @if(!empty($members->member_education['มัธยมศึกษา']))
                                            value="{{$members->member_education['มัธยมศึกษา']}}"
                                        @else
                                            disabled=""
                                        @endif
                                        >
                                        <input type="hidden" name="member_major1" class="form-control" id="member_major1">
                                    </div>
                                </div>
                                <div class="col-sm-2 col-sm-offset-1">
                                    <div class="input-group ">
                                        <div class="form-group label-floating">
                                            <input type="checkbox" name="member_education2" id="member_education2" class="option-input checkbox" 
                                            @if(!empty($members->member_education['ปริญญาตรี']))
                                                checked
                                            @endif
                                            >&nbsp;&nbsp;
                                            <label>@lang('frontend/members/title.bachelor')</label>                          
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group label-floating">
                                        <label>@lang('frontend/members/title.faculty')</label>
                                        <input type="text" name="member_major2" id="member_major2" class="form-control"  
                                        @if(!empty($members->member_education['ปริญญาตรี'][0]))
                                            value="{{$members->member_education['ปริญญาตรี'][0]}}"
                                        @else
                                            disabled=""
                                        @endif>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group label-floating">
                                        <label>@lang('frontend/members/title.university')</label>
                                        <input type="text" name="member_institution2" id="member_institution2" class="form-control" 
                                        @if(!empty($members->member_education['ปริญญาตรี'][1]))
                                            value="{{$members->member_education['ปริญญาตรี'][1]}}"
                                        @else
                                            disabled=""
                                        @endif>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-sm-offset-1">
                                    <div class="input-group ">                
                                        <div class="form-group label-floating">    
                                            <input type="checkbox" name="member_education3" id="member_education3" class="option-input checkbox" 
                                            @if(!empty($members->member_education['ปริญญาโท']))
                                                checked
                                            @endif>&nbsp;&nbsp;
                                            <label>@lang('frontend/members/title.master_s_degree')</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group label-floating">
                                        <label>@lang('frontend/members/title.faculty')</label>
                                        <input type="text" name="member_major3" id="member_major3" class="form-control" 
                                        @if(!empty($members->member_education['ปริญญาโท'][0]))
                                            value="{{$members->member_education['ปริญญาโท'][0]}}"
                                        @else
                                            disabled=""
                                        @endif>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group label-floating">
                                        <label>@lang('frontend/members/title.university')</label>
                                        <input type="text" name="member_institution3" id="member_institution3" class="form-control" 
                                        @if(!empty($members->member_education['ปริญญาโท'][1]))
                                            value="{{$members->member_education['ปริญญาโท'][1]}}"
                                        @else
                                            disabled=""
                                        @endif>
                                    </div>
                                </div>       
                                <div class="col-sm-2 col-sm-offset-1">
                                    <div class="input-group ">      
                                        <div class="form-group label-floating">
                                            <input type="checkbox" name="member_education4" id="member_education4" class="option-input checkbox" 
                                            @if(!empty($members->member_education['ปริญญาเอก']))
                                                checked
                                            @endif>&nbsp;&nbsp;
                                            <label>@lang('frontend/members/title.ph_d')</label> 
                                        </div>
                                    </div>
                                </div>                                                            
                                <div class="col-sm-4">
                                    <div class="form-group label-floating">
                                        <label>@lang('frontend/members/title.faculty')</label>
                                        <input type="text" name="member_major4" id="member_major4" class="form-control" 
                                        @if(!empty($members->member_education['ปริญญาเอก'][0]))
                                            value="{{$members->member_education['ปริญญาเอก'][0]}}"
                                        @else
                                            disabled=""
                                        @endif>
                                    </div>
                                </div>   
                                <div class="col-sm-4">
                                    <div class="form-group label-floating">
                                        <label>@lang('frontend/members/title.university')</label>
                                        <input type="text" name="member_institution4" id="member_institution4" class="form-control" 
                                        @if(!empty($members->member_education['ปริญญาเอก'][1]))
                                            value="{{$members->member_education['ปริญญาเอก'][1]}}"
                                        @else
                                            disabled=""
                                        @endif>
                                    </div>
                                </div>                                      
                            </div>
                        </div>
                        <div class="tab-pane" id="tab4" >
                            <h4 class="info-text">@lang('frontend/members/title.career_info')</h4>
                            <div class="row">                                  
                                <div class="col-sm-12 col-sm-offset-1">
                                    <div id="myRepeatingFields">
                                        <div class="entry input-group col-xs-12">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <input type="text" name="member_HJPl[]" id="member_HJPl" class="form-control"    placeholder="@lang('frontend/members/title.workplace')">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="member_HJPo[]" id="member_HJPo" class="form-control" placeholder="@lang('frontend/members/title.position')">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="member_HJExp[]" id="member_HJExp" class="form-control" placeholder="@lang('frontend/members/title.work_experience')">
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" id="btn-exp" class="btn btn-success btn-md btn-add input-group-btn">@lang('frontend/members/title.add_button')</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(!empty($members->member_exp))
                                            @foreach ($members->member_exp as $item)
                                                <div class="entry input-group col-xs-12">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <input type="text" name="member_HJPl[]" id="member_HJPl" value="{{$item[0]}}" class="form-control" placeholder="@lang('frontend/members/title.workplace')">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" name="member_HJPo[]" id="member_HJPo" value="{{$item[1]}}" class="form-control" placeholder="@lang('frontend/members/title.position')">
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input type="text" name="member_HJExp[]" id="member_HJExp" value="{{$item[2]}}" class="form-control" placeholder="@lang('frontend/members/title.work_experience')">
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <button type="button" class="btn btn-danger btn-md btn-remove input-group-btn">@lang('frontend/members/title.remove_button')</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab5">
                            <h4 class="info-text">@lang('frontend/members/title.successfully_info')</h4>
                            <div class="row">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div id="myRepeatingFields2">
                                        <div class="entry input-group col-xs-12">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <input type="text" name="member_cong[]" id="member_cong" class="form-control" placeholder="@lang('frontend/members/title.successfully_teaching')">
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" class="btn btn-success btn-md btn-add2 input-group-btn">@lang('frontend/members/title.add_button')</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(!empty($members->member_cong))
                                            @foreach ($members->member_cong as $item)
                                                <div class="entry input-group col-xs-12">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <input type="text" name="member_cong[]" id="member_cong" value="{{$item}}" class="form-control" placeholder="@lang('frontend/members/title.successfully_teaching')">
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <button type="button" class="btn btn-md input-group-btn btn-remove btn-danger">@lang('frontend/members/title.remove_button')</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab6">
                            <label class="col col-aptitude" style="color: #569c37; font-size: 19px">@lang('frontend/members/title.subject')</label>
                            <div class="row">
                                @foreach($aptitude as $index => $aptitude_detail)
                                    @if($index > 3)
                                        @continue
                                    @endif
                                    <div class="col-sm-12 col-aptitude">
                                        <div class="form-group label-floating">
                                            <div class="custom-control custom-checkbox mb-3">
                                                @php $data_select = '0'; @endphp
                                                @foreach(array_keys($members->member_aptitude) as $i => $members_aptitude_id)
                                                    @if(($members_aptitude_id == $aptitude_detail->id) && (count($members->member_aptitude[$aptitude_detail->id]) > 0))
                                                        
                                                    @php $data_select = '1'; @endphp
                                                    @endif
                                                @endforeach

                                                <input type="checkbox" name="group[]" value="{{$aptitude_detail->id}}" class="option-input checkbox aptitude-checkbox" data-toggle="collapse" data-target="#check{{$index}}" data-index="{{$index}}"  
                                                @if($data_select=='1')
                                                    data-select="1" checked 
                                                @else
                                                    data-select="0" 
                                                @endif
                                                > &nbsp;
                                                <object>
                                                    @if(session('lang')=='en')
                                                        {{$aptitude_detail->aptitude_name_en}}
                                                    @else
                                                        {{$aptitude_detail->aptitude_name_th}}
                                                    @endif
                                                </object>
                                                @php $data_in = '0'; @endphp
                                                @foreach(array_keys($members->member_aptitude) as $i => $members_aptitude_id)
                                                    @if(($aptitude_detail->id == $members_aptitude_id) && (count($members->member_aptitude[$members_aptitude_id]) > 0))
                                                    @php $data_in = '1'; @endphp
                                                    @endif
                                                @endforeach

                                                <div id="check{{$index}}"  
                                                    @if($data_in=='1')
                                                        class="collapse in"
                                                    @else
                                                        class="collapse"
                                                    @endif
                                                > 
                                                    <div><h4></h4></div>
                                                    @foreach($aptitude_detail->subject_detail as $subject)
                                                        @php $other[] = $subject->subject_name_en; @endphp
                                                        <div class="col-sm-offset-0">
                                                            <div class="col-sm-3 col-sm-offset-0">
                                                                <input type="checkbox" name="subject_{{$index}}[]" class="option-input checkbox custom-control-input subject-checkbox sub-check-{{$index}}" value="{{$subject->id}}" 
                                                                @if(!empty($members->member_aptitude[$aptitude_detail->id]))
                                                                    @foreach($members->member_aptitude[$aptitude_detail->id] as $members_subject_id)
                                                                    @php $member_other[] = $subject->subject_name_th;  @endphp
                                                                    @if($subject->id==$members_subject_id)
                                                                        checked 
                                                                    @endif
                                                                    @endforeach

                                                                @endif
                                                                >
                                                                <label class="custom-control-label" for="01" style="color: #569c37" > 
                                                                &nbsp;
                                                                @if(session('lang')=='en')
                                                                    {{$subject->subject_name_en}}
                                                                @else
                                                                    {{$subject->subject_name_th}}
                                                                @endif
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @if(!empty($members->detail_aptitude[$aptitude_detail->aptitude_name_en]))
                                                        @php 
                                                            $other=array_diff($members->detail_aptitude[$aptitude_detail->aptitude_name_en],$other); 
                                                        @endphp
                                                    @else
                                                        @php 
                                                            $other=[]; 
                                                        @endphp
                                                    @endif
                                                
                                                    <div class="col-sm-offset-0">
                                                        <div class="col-sm-3 col-sm-offset-0">  
                                                            <input type="checkbox" name="chk_other{{$index}}[]" value="chk_other{{$index}}[]" class="option-input checkbox subject-checkbox sub-check-{{$index}} other-check-{{$index}}" data-toggle="collapse" data-target="#other{{$index}}"
                                                            @if(!empty($other))
                                                                checked
                                                            @endif
                                                            >
                                                            <label class="custom-control-label" for="eng" style="color: #569c37">&nbsp;&nbsp;@lang('frontend/members/title.other')</label>  
                                                            <div><h4></h4></div>
                                                            <div id="other{{$index}}" class="collapse
                                                            @if(!empty($other)) show @endif ">
                                                                <div id="other_{{$index}}_input">
                                                                    <div class="entry input-group col-md-12"> 
                                                                        <input class="form-control" name="other{{$index}}[]" id="other_chk{{$index}}" type="text" placeholder="@lang('frontend/members/title.enter_other_lang')" autocomplete="off" />
                                                                        <span class="input-group-btn" style="margin-top: -17px;">
                                                                            <button class="btn btn-md btn-success btn-add-other input-group-btn  btn-other-{{$index}}">@lang('frontend/members/title.add_button')</button>
                                                                        </span>
                                                                    </div>

                                                                    @foreach($other as $item)
                                                                    <div class="entry input-group col-md-12"> 
                                                                        <input class="form-control" name="other{{$index}}[]" type="text" placeholder="@lang('frontend/members/title.enter_other_lang')" value="{{$item}}" autocomplete="off" />
                                                                        <span class="input-group-btn" style="margin-top: -17px;">
                                                                            <button class="btn btn-md btn-danger btn-remove">@lang('frontend/members/title.remove_button')</button>
                                                                        </span>
                                                                    </div>
                                                                    @endforeach
                                                                    @php $other=[]; @endphp
                                                                </div>
                                                            </div>       
                                                        </div>
                                                    </div>
                                                </div>                                         
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-sm-12">
                                    <hr class="col col-aptitude" style="font-size: 18px; margin-right: 15px;">
                                </div>
                            </div>
                            <label class="col col-aptitude"  style="color: #569c37 ; font-size: 19px">@lang('frontend/members/title.other')</label>
                            <div class="row">  
                                @foreach($aptitude as $index => $aptitude_detail)
                                    @if ($index < 4)
                                        @continue
                                    @endif
                                    <div class="col-sm-12 col-aptitude">
                                        <div class="form-group label-floating">
                                            <div class="custom-control custom-checkbox mb-3">
                                                @php $data_select = '0'; @endphp
                                                @foreach(array_keys($members->member_aptitude) as $i => $members_aptitude_id)
                                                    @if(($members_aptitude_id == $aptitude_detail->id) && (count($members->member_aptitude[$aptitude_detail->id]) > 0))
                                                        
                                                    @php $data_select = '1'; @endphp
                                                    @endif
                                                @endforeach

                                                <input type="checkbox" name="group[]" value="{{$aptitude_detail->id}}" class="option-input checkbox aptitude-checkbox" data-toggle="collapse" data-target="#check{{$index}}" data-index="{{$index}}"  
                                                @if($data_select=='1')
                                                    data-select="1" checked 
                                                @else
                                                    data-select="0" 
                                                @endif
                                                > &nbsp;
                                                <object>
                                                    @if(session('lang')=='en')
                                                        {{$aptitude_detail->aptitude_name_en}}
                                                    @else
                                                        {{$aptitude_detail->aptitude_name_th}}
                                                    @endif
                                                </object>
                                                @php $data_in = '0'; @endphp
                                                @foreach(array_keys($members->member_aptitude) as $i => $members_aptitude_id)
                                                    @if(($aptitude_detail->id == $members_aptitude_id) && (count($members->member_aptitude[$members_aptitude_id]) > 0))
                                                    @php $data_in = '1'; @endphp
                                                    @endif
                                                @endforeach

                                                <div id="check{{$index}}"  
                                                    @if($data_in=='1')
                                                        class="collapse in"
                                                    @else
                                                        class="collapse"
                                                    @endif
                                                >  
                                                    <div><h4></h4></div>
                                                    @foreach($aptitude_detail->subject_detail as $subject)
                                                        @php $other[] = $subject->subject_name_en;  @endphp
                                                        <div class="col-sm-offset-0">
                                                            <div class="col-sm-3 col-sm-offset-0">
                                                                <input type="checkbox" name="subject_{{$index}}[]" class="option-input checkbox custom-control-input subject-checkbox sub-check-{{$index}}" value="{{$subject->id}}"  
                                                                @if(!empty($members->member_aptitude[$aptitude_detail->id]))
                                                                @foreach($members->member_aptitude[$aptitude_detail->id] as $members_subject_id)
                                                                @php $member_other[] = $subject->subject_name_th;  @endphp
                                                                    @if($subject->id==$members_subject_id)
                                                                        checked 
                                                                    @endif
                                                                @endforeach

                                                                @endif
                                                                >
                                                                <label class="custom-control-label" for="01" style="color: #569c37"> 
                                                                    &nbsp;
                                                                    @if(session('lang')=='en')
                                                                        {{$subject->subject_name_en}}
                                                                    @else
                                                                        {{$subject->subject_name_th}}
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @if(!empty($members->detail_aptitude[$aptitude_detail->aptitude_name_en]))
                                                        @php 
                                                            $other=array_diff($members->detail_aptitude[$aptitude_detail->aptitude_name_en],$other); 
                                                        @endphp
                                                    @else
                                                        @php 
                                                            $other=[]; 
                                                        @endphp
                                                    @endif
                                                    
                                                    <div class="col-sm-offset-0">
                                                        <div class="col-sm-3 col-sm-offset-0">  
                                                            <input type="checkbox" name="chk_other{{$index}}[]" value="chk_other{{$index}}[]" class="option-input checkbox subject-checkbox sub-check-{{$index}} other-check-{{$index}}" data-toggle="collapse" data-target="#other{{$index}}"
                                                            @if(!empty($other))
                                                                checked
                                                            @endif
                                                            >
                                                            <label class="custom-control-label" for="eng" style="color: #569c37">&nbsp;&nbsp;@lang('frontend/members/title.other')</label>  
                                                            <div><h4></h4></div>
                                                            <div id="other{{$index}}" class="collapse
                                                            @if(!empty($other))
                                                                show
                                                            @endif
                                                            ">
                                                                <div id="other_{{$index}}_input">
                                                                    <div class="entry input-group col-md-12"> 
                                                                        <input class="form-control" name="other{{$index}}[]" id="other_chk{{$index}}" type="text" placeholder="@lang('frontend/members/title.enter_other_lang')" autocomplete="off" />
                                                                        <span class="input-group-btn" style="margin-top: -17px;">
                                                                            <button  class="btn btn-success btn-md btn-add-other input-group-btn btn-other-{{$index}}">@lang('frontend/members/title.add_button')</button>
                                                                        </span>
                                                                    </div>
                                                                    @foreach($other as $item)
                                                                    <div class="entry input-group col-md-12"> 
                                                                        <input class="form-control" name="other{{$index}}[]" type="text" placeholder="@lang('frontend/members/title.enter_other_lang')" value="{{$item}}" autocomplete="off" />
                                                                        <span class="input-group-btn " style="margin-top: -17px;">
                                                                            <button  class="btn btn-danger btn-md btn-remove">@lang('frontend/members/title.remove_button')</button>
                                                                        </span>
                                                                    </div>
                                                                    @endforeach
                                                                    @php $other=[]; @endphp
                                                                </div>
                                                            </div>                               
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                        </div>
                                    </div>
                                @endforeach    
                            </div>
                        </div>


                        <div class="tab-pane" id="tab7" >
                            <span id="alertMessage" class="alertMessage"></span>
                            <div class="row" style="margin-left: 100px;" >
                                <div class="col-sm-6 col-sm-offset-1">
                                    <div class="input-group col-sm-12">
                                        <div class="form-group label-floating">
                                            <div class="input-group mb-3 ">
                                                <div class="custom-file" align="center"></div>
                                                <div class="row files" id="files1">
                                                        <p class="oxide456">[@lang('frontend/members/title.id_card')]</p>
                                                    <span class="btn btn-success btn-file">
                                                        @lang('frontend/members/title.select_file')<input  type="file" name="files1" id="inputGroupFile01" multiple  />
                                                    </span>
                                                    <br />
                                                    <label class="fileList"  for="inputGroupFile01"></label>
                                                    @if(!empty($members->member_file['บัตรประชาชน']))
                                                    @foreach($members->member_file['บัตรประชาชน'] as $item)
                                                        <p id="txtfile1">
                                                        <input type="hidden" name="txtfile1[]" value="{{$item}}"  />
                                                        <a href="{{ URL::asset('/storage/fileUpload/'.$item) }}" target="_bank">{{$item}}</a> <a class="removeFile" href="#" data-fileid="">@lang('frontend/members/title.remove_button')</a>
                                                        </p>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group label-floating">
                                        <div class="input-group mb-3 ">
                                            <div class="custom-file"  align="center">
                                            </div>
                                            <div class="row files" id="files2">
                                                <p class="oxide456">[@lang('frontend/members/title.education_certificate')]</p>
                                                <span class="btn btn-success btn-file">
                                                    @lang('frontend/members/title.select_file')<input  type="file" name="files2" id="inputGroupFile02" multiple  />
                                                </span>
                                                <br />
                                                <label class="fileList"  for="inputGroupFile02"></label>
                                                @if(!empty($members->member_file['สำเนาศึกษา']))
                                                @foreach($members->member_file['สำเนาศึกษา'] as $item)
                                                    <p id="txtfile2">
                                                        <input type="hidden" name="txtfile2[]" value="{{$item}}"  />
                                                        <a href="{{ URL::asset('/storage/fileUpload/'.$item) }}" target="_bank">{{$item}}</a> <a class="removeFile" href="#" data-fileid="">@lang('frontend/members/title.remove_button')</a>
                                                    </p>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-sm-offset-1">
                                    <div class="form-group label-floating">
                                        <div class="input-group mb-3 ">
                                            <div class="row files" id="files3">
                                                <p class="oxide456">[@lang('frontend/members/title.transcript')]</p>
                                                <span class="btn btn-success btn-file">
                                                    @lang('frontend/members/title.select_file')<input  type="file" name="files3" id="inputGroupFile03" multiple  />
                                                </span>
                                                <br />
                                                <label class="fileList"  for="inputGroupFile02"></label>
                                                @if(!empty($members->member_file['ใบผลการเรียน']))
                                                @foreach($members->member_file['ใบผลการเรียน'] as $item)
                                                    <p id="txtfile3">
                                                        <input type="hidden" name="txtfile3[]" value="{{$item}}"  />
                                                        <a href="{{ URL::asset('/storage/fileUpload/'.$item) }}" target="_bank">{{$item}}</a> <a class="removeFile" href="#" data-fileid="">@lang('frontend/members/title.remove_button')</a>
                                                    </p>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group label-floating">
                                      <div class="input-group mb-3 ">
                                            <div class="custom-file" align="center">
                                            </div>
                                            <div class="row files" id="files4">
                                                <p class="oxide456">[@lang('frontend/members/title.other_certificate')]</p>
                                                <span class="btn btn-success btn-file">
                                                    @lang('frontend/members/title.select_file')<input type="file" name="files4" id="inputGroupFile04" multiple>
                                                </span>
                                                <br />
                                                <label class="fileList"  for="inputGroupFile02"></label>
                                                @if(!empty($members->member_file['วุฒิบัตรอื่นๆ']))
                                                @foreach($members->member_file['วุฒิบัตรอื่นๆ'] as $item)
                                                    <p  id="txtfile4">
                                                        <input type="hidden" name="txtfile4[]" value="{{$item}}" />
                                                        <a href="{{ URL::asset('/storage/fileUpload/'.$item) }}" target="_bank">{{$item}}</a> <a class="removeFile" href="#" data-fileid="">@lang('frontend/members/title.remove_button')</a>
                                                        </p>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                            </div>
                        </div>
                        <div id="txtfilename">
    
                        </div>
                    </div>
                    <div class="wizard-footer">
                        <div class="pull-right">
                          <input type='button' id='btnSubmit'   class='btn btn-next btn-fill btn-success btn-wd' name='next' value='@lang('frontend/members/title.next_button')' /> 
                            <button type="submit" id="uploadBtn" class='btn btn-finish btn-fill btn-success btn-wd' name='finish' value='@lang('frontend/members/title.finish_button')'>@lang('frontend/members/title.finish_button')</button>
                            
                            </div>
                            <div class="pull-left">
                            <input type='button'class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='@lang('frontend/members/title.previous_button')' />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div> <!-- wizard container -->
    </div>
</div><!-- end row -->
</div> <!--  big container -->
</div>

</body>
<!--   Core JS Files   -->
<script src="{{ asset ('suksa/frontend/template/login_register/assets/js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
<script src="{{ asset ('suksa/frontend/template/login_register/assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset ('suksa/frontend/template/login_register/assets/js/jquery.bootstrap.js') }}" type="text/javascript"></script>

<!--  Plugin for the Wizard -->
<script src="{{ asset ('suksa/frontend/template/login_register/assets/js/material-bootstrap-wizard.js') }}"></script>

<!--  More information about jquery.validate here: http://jqueryvalidation.org/  -->
<script src="{{ asset ('suksa/frontend/template/login_register/assets/js/jquery.validate.min.js') }}"></script>

<!--  More information about jquery.validate here: http://jqueryvalidation.org/  -->
<script src="{{ asset ('suksa/frontend/template/js/input.js') }}"></script>
<script src="{{ asset ('suksa/frontend/template/js/other-subject.js') }}"></script>
<!-- วันที่ -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<!-- วันที่ -->

<script type="text/javascript">
    //set datepicker
    $(function () {
        $('#datepicker').datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            orientation: "button"
        });
    });

</script>
</html>
