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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="{{ asset ('suksa/frontend/template/js/cleave.min.js') }}"></script>

    <style>
        .input-group-addon{

          display: none;
        }
        .input-group-append{
          display: none;
        }
    </style>

@endsection
@section('content')
<form action="{{ url('coins/saverefund') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <section class="p-t-50 ">
        <div class="container">
            <div class="tab-content" id="myTabContent">
                <div id="inner">
                <p class="iconhatfont">@lang('frontend/coins/title.refund')</p>
                </div>
                <hr>
            </div>
        </div>
    </section>

    <section class="col-md-12" style="padding-left: 15px;">
        <div class="container">
            <div class="container" style="text-align: center;">
                <div class="row">
                    <div class="container col-sm-7" >
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <h6 class="col-sm-12" for="dtp_input1"  style="text-align-last: left; padding-bottom: 10px;">@lang('frontend/coins/title.course') : <span style="color:red;">*</span></h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select name="refund_course" id="refund_course" class="form-control" style="padding-top: 4px;" required>
                                                <option value="" selected>@lang('frontend/coins/title.select_course')</option>
                                                    
                                                @foreach($member_courses as $index => $item)
                                                    <option value="{{ $item->course_id }}" style="color:black;">
                                                        {{ $item->classroom_name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="col-md-12" style="padding-left: 15px;">
        <div class="container">
            <div class="container" style="text-align: center;">
                <div class="row">
                    <div class="container col-sm-7" >
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <h6 class="col-sm-12" for="dtp_input1"  style="text-align-last: left; padding-bottom: 10px;">@lang('frontend/coins/title.refund_reason') : <span style="color:red;">*</span></h6>
                                       
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">                    
                                            <textarea class="form-control" name="refund_reason" id="refund_reason" rows="3" style="width: 100%;" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <br>
    <div class="col-md-12">
        <div class="container">
            <div class="row"> 
                <div class="col-sm"></div>
                <div class="col-sm">
                    <button type="submit" onclick="return chk()" class="flex-c-m size2 bo-rad-23 s-text3 bgwhite hov1 trans-0-5 col-12"><object class="colorz">@lang('frontend/coins/title.confirm_refund_button')</object></button>
                </div>
                <div class="col-sm"></div>
            </div>
        </div>
    </div>
</form>

<!-- Banner -->
<section class="blog p-t-10 p-b-40">
</section>
        
<script>
    var please_select_course = '{{ trans('frontend/coins/title.please_select_course') }}';
    var please_enter_reason = '{{ trans('frontend/coins/title.please_enter_reason') }}';
    var close_window = '{{ trans('frontend/coins/title.close_window') }}';
    
    function chk(){
        $refund_course = $("#refund_course").val();
        $refund_reason = $("#refund_reason").val();

        if($refund_course == ''){
            alertSwal('<h3>'+please_select_course+'<h3>')
            return false;
        }
        if($refund_reason == ''){
            alertSwal('<h3>'+please_enter_reason+'<h3>')
            return false;
        } 
    }
        
    function alertSwal(val){
        Swal.fire({
                title: '<strong>'+val+'</u></strong>',
                type: 'warning',
                showCloseButton: true,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonColor: '#28a745',
                confirmButtonText: close_window,
        });
    }

</script>




@stop