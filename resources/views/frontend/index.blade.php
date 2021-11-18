@extends('frontend.default')

<?php
    if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
        App::setLocale('en');
    }
    else{
        App::setLocale('th');
    }

    $check_login = Auth::guard('members')->user();
?>

<style>


</style>

@section('css')
    <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/homepage.css') !!}">
@endsection

@section('content')

    <section class="slide1">
        <div class="wrap-slick1">
            <div class="slick1 slick-initialized slick-slider">
                <div class="slick-list draggable">
                  <div class="slick-track" style="opacity: 1; width: 100%;">
                    <div class="item-slick1 item1-slick1 slick-slide slick-current slick-active p-t-50" style="background-image: url('img/bn001_v5.jpg'); width: 100%; position: relative; left: 0px; top: 0px; z-index: 999; opacity: 1;" data-slick-index="0" aria-hidden="false" tabindex="0">
                      <div class="container">
                        <div class="row" data-scrollax-parent="true">
                          <div class="col-md-12">
                            <div class="services-2 noborder-left  ftco-animate fadeInUp ftco-animated">
                              <h1 class="m-b-10"><strong><span style="color: #003D99;" class="subheading">The Best Teamwork</span></strong></h1>
                            </div>
                            <div class="services-2 noborder-left  ftco-animate fadeInUp ftco-animated">
                              <h1 class="m-b-10"><strong><span style="color: #000000;" class="subheading">Comes from your hand.</span></strong></h1>
                            </div>

                            @if(!Auth::guard('members')->user())
                              <div class="services-2 noborder-left  ftco-animate fadeInUp ftco-animated p-t-20">
                                <a  href="{{ route('users.create') }}"class="btn  btn-sm"  style="border-radius: 25px;  width: 115px; color: #003D99;border-color: #003D99;">
                                  <i class="fa fa-user" aria-hidden="true" ></i>&nbsp;
                                  <span>Sign Up</span>
                                </a>

                                <a class="btn btn-login-header btn-sm" data-toggle="modal" data-target="#myModal" style="cursor: pointer;  width: 115px;">
                                  <i class="fa fa-lock" aria-hidden="true" style="color: #ffffff;"></i>&nbsp;
                                  <span style="color: #ffffff;">Sign In</span>
                                </a>
                              </div>
                            @endif


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

    <section class="p-t-50 p-b-65 t-center" >
        <div class="container">
          <div class="row">

              <div class="container">
                <div class="row">
                  <div class="col-sm-auto"></div>
                  <div class="col-sm" style="text-align: center; font-size: 30px;  ">
                    <label style="color: #003D99;"><strong><h1>Why AT<span style="color: #42A2EC;">WORK</span> ?</h1></strong></label>
                  </div>
                  <div class="col-sm-auto"></div>
                </div>
              </div>

              <div class="row">
                <br><br><br>
              </div>

              <div class="container marketing">
                <div class="row">

                  <div class="col-md-3 col-xs-12 p-3 ">
                    <div class="services-2 noborder-left text-center ftco-animate fadeInUp ftco-animated">
                      <div class="icon mt-2 d-flex justify-content-center align-items-center">
                        <span> <img src="{!! asset ('/img/ico_why01.png') !!}" style="width: 58px;"></span>
                      </div>
                      <div class="text media-body">
                        <p style="font-size: 14px;">Video Conference with <br> central controller</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3 col-xs-12 p-3 ">
                    <div class="services-2 noborder-left text-center ftco-animate fadeInUp ftco-animated">
                      <div class="icon mt-2 d-flex justify-content-center align-items-center">
                        <span> <img src="{!! asset ('/img/ico_why02.png') !!}" style="width: 58px;"></span>
                      </div>
                      <div class="text media-body">
                        <p style="font-size: 14px;">Two Way <br> Communication</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3 col-xs-12 p-3 ">
                    <div class="services-2 noborder-left text-center ftco-animate fadeInUp ftco-animated">
                      <div class="icon mt-2 d-flex justify-content-center align-items-center">
                        <span> <img src="{!! asset ('/img/ico_why03.png') !!}" style="width: 58px;"></span>
                      </div>
                      <div class="text media-body">
                        <p style="font-size: 14px;">Supported 1-on-1 meeting & group meeting <br> (up to 100 participants)</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3 col-xs-12 p-3 ">
                    <div class="services-2 noborder-left text-center ftco-animate fadeInUp ftco-animated">
                      <div class="icon mt-2 d-flex justify-content-center align-items-center">
                        <span> <img src="{!! asset ('/img/ico_why04.png') !!}" style="width: 58px;"></span>
                      </div>
                      <div class="text media-body">
                        <p style="font-size: 14px;">Interactive <br> Whiteboard</p>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

            <div class="container marketing">
              <div class="row">

                <div class="col-md-4 col-xs-12 p-3 ">
                  <div class="services-2 noborder-left text-center ftco-animate fadeInUp ftco-animated">
                    <div class="icon mt-2 d-flex justify-content-center align-items-center">
                      <span> <img src="{!! asset ('/img/ico_why05.png') !!}" style="width: 58px;"></span>
                    </div>
                    <div class="text media-body">
                      <p style="font-size: 14px;">Schedule <br> Management System</p>
                    </div>
                  </div>
                </div>

                <div class="col-md-4 col-xs-12 p-3 ">
                  <div class="services-2 noborder-left text-center ftco-animate fadeInUp ftco-animated">
                    <div class="icon mt-2 d-flex justify-content-center align-items-center">
                      <span> <img src="{!! asset ('/img/ico_why06.png') !!}" style="width: 58px;"></span>
                    </div>
                    <div class="text media-body">
                      <p style="font-size: 14px;">Files & Video <br> Sharing Center</p>
                    </div>
                  </div>
                </div>

                <div class="col-md-4 col-xs-12 p-3 ">
                  <div class="services-2 noborder-left text-center ftco-animate fadeInUp ftco-animated">
                    <div class="icon mt-2 d-flex justify-content-center align-items-center">
                      <span> <img src="{!! asset ('/img/ico_why07.png') !!}" style="width: 58px;"></span>
                    </div>
                    <div class="text media-body">
                      <p style="font-size: 14px;">Playback <br> Cloud Server</p>
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>
    </section>

    <section class="p-t-50 p-b-40 t-center" >
        <div class="container">
          <div class="row">
            <div class="container">
              <div class="row">
                <div class="col-xs-12 col-md-12">
                  <img src="{!! asset ('/img/Group 1547.png') !!}" style="width: 200px;">
                </div>
                <div class="col-xs-12 col-md-12">
                  <label><b><h2><span style="color: #003D99;">Coming together</span> <span style="color: #42A2EC;"> is a beginning.</span></h2></b></label>
                </div>
                <div class="col-xs-12 col-md-12">
                  <label><h3> Staying together is progress. And working together is success. </h3></label>
                </div>
              </div>
          </div>
        </div>
    </section>

    <div class="carousel slide p-b-40" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{!! asset ('/img/bn02-2.png') !!}" class="d-block w-100">
        </div>
      </div>
    </div>

    <div class="form-inline">
      <div class="col-md-7 col-xs-12 text-right p-b-40" >
          <img src="{!! asset ('/img/img_logoedis2.png') !!}" class="col" style="width: auto;">
      </div>
      <div class="col-md-3 col-xs-12 text-right p-b-40" >
        <a href="https://edispro.com/">
          <img src="{!! asset ('/img/img_logoedis.png') !!}" class="col" style="width: auto;">
        </a>
      </div>
      <div class="col-md-2 col-xs-12 text-right p-b-40" >
        <a href="http://suksa.online/">
          <img src="{!! asset ('/img/img_logosuksa.png') !!}" class="col" style="width: auto;">
        </a>
      </div>
    </div>

    <script src="/suksa/frontend/template/js/modal_request.js"></script>

@stop
