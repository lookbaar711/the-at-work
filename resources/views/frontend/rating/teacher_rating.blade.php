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

<!-- เวลา -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<!-- เวลา -->



@endsection
@section('content')
{{-- <form action="{{ url('coins/add') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }} --}}
    <section class="p-t-50 ">
        <div class="container">
            <div class="tab-content" id="myTabContent">
                <div id="inner">
                <img src="{{ asset ('suksa/frontend/template/images/icons/rating_star.jpg') }}" style="max-width: 250px; max-height: 250px;">
                </div>
                <br>
                <div id="inner">
                    <p class="iconhatfont">@lang('frontend/layouts/title.rating_review')</p>
                </div>
                <br>
                <div id="inner">
                    <h6 style="text-align-last: center; padding-bottom: 10px;">
                        @lang('frontend/layouts/title.please_sent_teacher_rating_1')<br>
                        @lang('frontend/layouts/title.please_sent_teacher_rating_2')
                    </h6>
                </div>
                <br>
            </div>
            
        </div>
    </section>

    <div class="col-md-12">
        <div class="container">
            <div class="row"> 
                <div class="col-sm"></div>
                <div class="col-sm">
                    <a href="../sent_teacher_rating/{{$course_id}}" ><button type="submit" class="flex-c-m-rating size2 bo-rad-23 s-text3 bgwhite hov1 trans-0-5 col-12 sent-rating-teacher"><object class="colorz">@lang('frontend/layouts/title.sent_rating')</object></button></a>
                </div>
                <div class="col-sm"></div>
            </div>
        </div>
    </div>
    <br>
    <div class="col-md-12">
        <div class="container">
            <div class="row"> 
                <div class="col-sm"></div>
                <div class="col-sm">
                    <div style="text-align:center; border-bottom: 1px;">
                        <a href="{{ url('/') }}" >@lang('frontend/layouts/title.next_time')</a>
                    </div>
                </div>
                <div class="col-sm"></div>
            </div>
        </div>
    </div>

    <input type="hidden" name="course_id" id="course_id" value="{{ $course_id }}">
{{-- </form> --}}

<!-- Banner -->
<section class="blog p-t-10 p-b-40">
</section>

@stop