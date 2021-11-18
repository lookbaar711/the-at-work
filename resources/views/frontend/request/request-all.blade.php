@extends('frontend/default')

@section('content')
  @php
  if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
      App::setLocale('en');
  }
  else{
      App::setLocale('th');
  }
  @endphp

  <section class="p-t-50 p-b-65">
      <div class="container">
          <div class="form-row">
              <div class="col-sm-12">
                <h4>@lang('frontend/members/title.there_are') <t style="color:#6ab22a;">{{count($teacher_detail)}} @lang('frontend/members/title.teacher')</t> @lang('frontend/members/title.there_are_teacher')</h4>
              </div>
          </div>
          <hr>
          @foreach($teacher_detail as $item)
            <div class="form-row">
              <div class="form-group col-md-2 col-sm-12 text-center">
                @if(($item->member_img=="") || !isset($item->member_img))
                  <img src="{{ asset ('suksa/frontend/template/images/icons/blank_image.jpg') }}" class="mr-3 rounded-circle" style="width: 100px; height: 100px;" onerror="this.onerror=null;this.src='http://localhost:8000/suksa/frontend/template/images/icons/blank_image.jpg';">
                @else
                  <img src="{{ asset ("storage/memberProfile/".$item->member_img) }}" class="mr-3 rounded-circle" style="width: 100px; height: 100px;" onerror="this.onerror=null;this.src='http://localhost:8000/suksa/frontend/template/images/icons/blank_image.jpg';">
                @endif
              </div>
              <div class="form-group col-md-5 col-sm-12">
                <h5 class="mt-0 mb-1">{{$item->member_fname." ".$item->member_lname}}
                  @if(($item->member_nickname != '') || !is_null($item->member_nickname))
                    ({{ $item->member_nickname}})
                  @endif

                  @if ($item->online_status == '1')  {{-- 0 ออฟไลน์ --}} {{-- 1 ออนไลน์ --}}
                    <p class="btn btn-sm" style="background: #7ED103; border-radius: 25px; font-size: 12px; color: white;">@lang('frontend/users/title.Online')</p>
                  @else
                    <p class="btn btn-sm" style="background: #BCBCBC; border-radius: 25px; font-size: 12px; color: white;">@lang('frontend/users/title.Offline')</p>
                  @endif

                </h5>
                <h6 class="mt-0 mb-1"><p class="showteacher"> <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_03.png') }}"> {{$item->member_email}}</h6>
                <h6 class="mt-0 mb-1"><p class="showteacher"><img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_07.png') }}">
                  @lang('frontend/members/title.teaching_rate') {{ number_format($item->member_rate_start)." - ".number_format($item->member_rate_end) }} @lang('frontend/members/title.coins_hour')</h6>
              </div>
              <div class="form-group col-md-5 col-sm-12 text-right" style="align-self: center;">

                  <a href="{{ url('members/detail/'.$item->member_id) }}">
                    <button class="btn btn-outline-dark button-s btn-sm" style="border-radius: 25px;" >
                      <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_06.png') }}"> @lang('frontend/members/title.teacher_information')
                    </button>
                  </a>

                  {{-- <button class="btn btn-sm" style="background: linear-gradient(to right, #17a7c0 0%, #7de442 100%); border-radius: 25px; color: white;">
                    <img  class="p-b-5 " style="width: 20px; " src="{{ asset ('suksa/frontend/template/images/icons/ico_10.png') }}">&nbsp; @lang('frontend/members/title.send_message')
                  </button> --}}

              </div>
            </div>

          <hr>
          @endforeach
      </div>
  </section>

@stop
