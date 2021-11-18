<!doctype html>

<?php
    $lang = '';
    if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
        $lang = App::setLocale('en');
    }
    else{
        $lang = App::setLocale('th');
    }
?>

<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title>ATWORK</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'>
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


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<style type="text/css">
    .disble-a{
        pointer-events: none;
        cursor: default;
    }
</style>

</head >

<body  class="backgroundimg" style="background-image: url(../suksa/frontend/template/images/banner.jpg);"><!--background-image: url(../suksa/frontend/template/images/banner.jpg); background-size: cover;-->
<!--   Big container   -->
<div class="container">
<div class="row">
    <div class="col-sm-12 ">
        <!--      Wizard container        -->
        <div class="wizard-container">
        <section class="p-t-2 p-b-2" >
          <div style="text-align: left;" >
            <label> <a href="{{url('')}}" style="color: rgb(7, 7, 7); font-size: 18px;">@lang('frontend/users/title.main')</a> / <label ><a href="#"style="color: darkgray; font-size: 18px;">@lang('frontend/users/title.member_register')</a></label></label>
            </div>

            </section>
            <div class="card wizard-card" data-color="green" id="wizardProfile">
                <form role="form" method="POST" id="form_id" action="{{ route('users.store') }}" enctype="multipart/form-data" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="wizard-header">
                        <h3 class="wizard-title">
                            @lang('frontend/users/title.member_register')
                        </h3>
                    </div>
                    <div class="wizard-navigation nav-pills">
                        <ul>
                            <li><a href="#tab1" data-toggle="tab" class="disble-a" style="font-size: 16px">@lang('frontend/users/title.authentication_info')</a></li>
                            <li><a href="#tab2" data-toggle="tab" class="disble-a" style="font-size: 16px">@lang('frontend/users/title.profile_info')</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane" id="tab1" >
                            <span id="alertMessage" class="alertMessage"></span>
                            <div class="row" >
                                <div class="col-sm-6 col-sm-offset-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/users/title.student_email') : <span style="color: red; font-size: 20px;">*</span></label>
                                        <input type="email" name="member_email" id="member_email" class="form-control formEmail" required autocomplete="none" onchange="return checkEmail()">
                                        <div class="emailFormAlert" id="divCheckEmail" ></div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sm-offset-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/users/title.student_password') : <span style="color: red; font-size: 20px;">*</span></label>
                                        <input type="password" name="member_password" id="member_password" class="form-control" required onChange="checkPasswordMatch();">
                                    </div>
                                </div>
                                <div class="col-sm-3 ">
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/users/title.student_confirm_password') : <span style="color: red; font-size: 20px;">*</span></label>
                                       <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required onChange="checkPasswordMatch();"><div class="registrationFormAlert" id="divCheckPasswordMatch"></div>  <!--onSubmit="return validate();"  -->
                                    </div>
                                </div>

                                <input type="hidden" name="correct_password" id="correct_password" value="@lang('frontend/members/title.correct_password')">
                                <input type="hidden" name="incorrect_password" id="incorrect_password" value="@lang('frontend/members/title.incorrect_password')">

                                <input type="hidden" name="current_lang" id="current_lang" value="{{ Config::get('app.locale') }}">
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2" >
                            <span id="alertMessage" class="alertMessage"></span>
                            <div class="row" >
                                <div class="col-sm-3 col-sm-offset-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/users/title.first_name') : <span style="color: red; font-size: 20px;">*</span></label>
                                        <input type="text" name="member_fname" id="member_fname" class="form-control" required autocomplete="none" onChange="checkfullname()" onkeyup="return checkTextOnly(this.id)">
                                        <span style="font-size: 10px; color: red;" id="warning_text_member_fname"></span>
                                    </div>
                                </div>
                                <div class="col-sm-3 ">
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/users/title.last_name') : <span style="color: red; font-size: 20px;">*</span></label>
                                        <input type="text" name="member_lname" id="member_lname" class="form-control" required autocomplete="none" onChange="checkfullname()" onkeyup="return checkTextOnly(this.id)">
                                        <span style="font-size: 10px; color: red;" id="warning_text_member_lname"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-sm-offset-3">
                                    <span style="font-size: 10px; color: red;" id="warning_text_member_fullname"></span>
                                </div>
                                <div class="col-sm-6 col-sm-offset-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">@lang('frontend/users/title.mobile_no') : <span style="color: red; font-size: 20px;">*</span></label>
                                        <input type="text" name="member_tell" id="member_tell" minlength="10" maxlength="10" class="form-control" required autocomplete="none" onkeyup="checkNumberOnly(this.id)">
                                        <span style="font-size: 10px; color: red;" id="warning_text_member_tell"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-footer">
                        <div class="pull-right">
                          <input type='button' id='btnSubmit' class='btn btn-next btn-fill btn-success btn-wd' name='next' value='@lang('frontend/users/title.next_button')' disabled="true"/>
                            <button type="submit" class='btn btn-finish btn-fill btn-success btn-wd' id="onsubmit" name='finish' value='@lang('frontend/users/title.finish_button')' disabled="true">@lang('frontend/users/title.finish_button')</button>
                            </div>
                            <div class="pull-left">
                            <input type='button'class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='@lang('frontend/users/title.previous_button')' />
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
<input type="text" name="lang" id="lang" value="@lang('frontend/users/title.enter_only_numbers')" style="display:none;">
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

<script language="javascript">

    /*
    function IsNumeric(sText,obj)
    {
        var ValidChars = "0123456789";
        var IsNumber=true;
        var Char;
        var lang = $('#lang').val();

        for (i = 0; i < sText.length && IsNumber == true; i++)
        {
            Char = sText.charAt(i);
            if (ValidChars.indexOf(Char) == -1)
            {
                IsNumber = false;
            }
        }

        if(IsNumber==false){
            Swal.fire(lang);
            obj.value=sText.substr(0,sText.length-1);
            $('#textsend').val("");
        }
    }

    window.onload = function() {
        const myInput = document.getElementById('user_tell');
        myInput.onpaste = function(e) {
            e.preventDefault();
        }
    }
    */
</script>

</html>
