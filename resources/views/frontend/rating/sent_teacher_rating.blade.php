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

        .td-rating{
            width:70px; 
            text-align: center;
        }
        .td-star{
            width:350px; 
            padding-left: 35px;
        }
        .td-star-mobile{
            width:350px; 
            padding-left: 5%;
        }
    </style>


    <link href="{{ asset('assets/vendors/starability/starability-all.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/bootstrapStarRating/css/star-rating.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/bootstrapRating/bootstrap-rating.css') }}" rel="stylesheet" type="text/css"/>
    {{--<link href="{{ asset('assets/vendors/bootstrapStarRating/themes/theme.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.0/css/theme-krajee-fa.css">

    <link href="{{ asset('assets/css/pages/custom_rating.css') }}" rel="stylesheet" type="text/css"/>



<!-- เวลา -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<!-- เวลา -->



@endsection
@section('content')
{{-- <form action="{{ url('coins/add') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }} --}}

<form action="{{ url('rating/save_teacher_rating') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <section class="p-t-50 ">
        <div class="container-menu-header-v2 p-t-2">
            <div class="tab-content col-md-12" id="myTabContent">
                <div id="inner">
                <img src="{{ asset ('suksa/frontend/template/images/icons/rating_star.jpg') }}" style="max-width: 250px; max-height: 250px;">
                </div>
                <br>
                <div id="inner">
                    <p class="iconhatfont">@lang('frontend/layouts/title.rating_review')</p>
                </div>
                <br>
                
                {{-- <div id="inner">
                    <h6 style="text-align-last: center; padding-bottom: 10px;">
                        1. อาจารย์ผู้สอนมีความพร้อมในการสอนครั้งนี้มากเพียงใด ?
                    </h6>
                    <br>
                    <center>
                        <table border="0">
                            <tr>
                                <td class="td-star">
                                    <fieldset class="starability-basic">
                                        <input type="radio" id="rate11" name="rating_1" value="1" />
                                        <label for="rate11" title="Terrible"></label>
                                        <input type="radio" id="rate12" name="rating_1" value="2" />
                                        <label for="rate12" title="Not good"></label>
                                        <input type="radio" id="rate13" name="rating_1" value="3" />
                                        <label for="rate13" title="Average"></label>
                                        <input type="radio" id="rate14" name="rating_1" value="4" />
                                        <label for="rate14" title="Very good"></label>
                                        <input type="radio" id="rate15" name="rating_1" value="5" checked/>
                                        <label for="rate15" title="Amazing"></label>
                                    </fieldset>
                                </td>
                            </tr>
                        </table>
                        <table border="0">
                            <tr>
                                <td class="td-rating">@lang('frontend/layouts/title.improve')</td>
                                <td class="td-rating">@lang('frontend/layouts/title.not_good')</td>
                                <td class="td-rating">@lang('frontend/layouts/title.medium')</td>
                                <td class="td-rating">@lang('frontend/layouts/title.good')</td>
                                <td class="td-rating">@lang('frontend/layouts/title.very_good')</td>
                            </tr>
                        </table>
                    </center>
                    <br>

                    <input type="hidden" name="rating_id[]" id="rating_id_1" value="5e4bc0461d9c7d35a80051e5">
                </div>
                <hr>
                
                <div id="inner">
                    <h6 style="text-align-last: center; padding-bottom: 10px;">
                        2. อาจารย์อธิบายเนื้อหาวิชาได้เข้าใจง่าย ในระดับใด ?
                    </h6>
                    <br>
                    <center>
                        <table border="0">
                            <tr>
                                <td class="td-star">
                                    <fieldset class="starability-basic">
                                        <input type="radio" id="rate21" name="rating_2" value="1" />
                                        <label for="rate21" title="Terrible"></label>
                                        <input type="radio" id="rate22" name="rating_2" value="2" />
                                        <label for="rate22" title="Not good"></label>
                                        <input type="radio" id="rate23" name="rating_2" value="3" />
                                        <label for="rate23" title="Average"></label>
                                        <input type="radio" id="rate24" name="rating_2" value="4" />
                                        <label for="rate24" title="Very good"></label>
                                        <input type="radio" id="rate25" name="rating_2" value="5" checked/>
                                        <label for="rate25" title="Amazing"></label>
                                    </fieldset>
                                </td>
                            </tr>
                        </table>
                        <table border="0">
                            <tr>
                                <td class="td-rating">@lang('frontend/layouts/title.improve')</td>
                                <td class="td-rating">@lang('frontend/layouts/title.not_good')</td>
                                <td class="td-rating">@lang('frontend/layouts/title.medium')</td>
                                <td class="td-rating">@lang('frontend/layouts/title.good')</td>
                                <td class="td-rating">@lang('frontend/layouts/title.very_good')</td>
                            </tr>
                        </table>
                    </center>
                    <br>

                    <input type="hidden" name="rating_id[]" id="rating_id_2" value="5e4bc04e1d9c7d35a80051e6">
                </div>
                <hr>

                <div id="inner">
                    <h6 style="text-align-last: center; padding-bottom: 10px;">
                        3. อาจารย์รับฟังและตอบคำถามของนักเรียนได้ชัดเจน ในระดับใด ?
                    </h6>
                    <br>
                    <center>
                        <table border="0">
                            <tr>
                                <td class="td-star">
                                    <fieldset class="starability-basic">
                                        <input type="radio" id="rate31" name="rating_3" value="1" />
                                        <label for="rate31" title="Terrible"></label>
                                        <input type="radio" id="rate32" name="rating_3" value="2" />
                                        <label for="rate32" title="Not good"></label>
                                        <input type="radio" id="rate33" name="rating_3" value="3" />
                                        <label for="rate33" title="Average"></label>
                                        <input type="radio" id="rate34" name="rating_3" value="4" />
                                        <label for="rate34" title="Very good"></label>
                                        <input type="radio" id="rate35" name="rating_3" value="5" checked/>
                                        <label for="rate35" title="Amazing"></label>
                                    </fieldset>
                                </td>
                            </tr>
                        </table>
                        <table border="0">
                            <tr>
                                <td class="td-rating">@lang('frontend/layouts/title.improve')</td>
                                <td class="td-rating">@lang('frontend/layouts/title.not_good')</td>
                                <td class="td-rating">@lang('frontend/layouts/title.medium')</td>
                                <td class="td-rating">@lang('frontend/layouts/title.good')</td>
                                <td class="td-rating">@lang('frontend/layouts/title.very_good')</td>
                            </tr>
                        </table>
                    </center>
                    <br>

                    <input type="hidden" name="rating_id[]" id="rating_id_3" value="5e4bc0711d9c7d35a80051e7">
                </div>
                <hr> --}}

                @foreach ($teaching_rating_questions as $i => $items)
                    <div id="inner">
                        <h6 style="text-align-last: center; padding-bottom: 10px;">
                            @php 
                                $j = $i+1; 
                                $rate_id_1 = 'rate'.$j.'1';
                                $rate_id_2 = 'rate'.$j.'2';
                                $rate_id_3 = 'rate'.$j.'3';
                                $rate_id_4 = 'rate'.$j.'4';
                                $rate_id_5 = 'rate'.$j.'5';
                                $rate_name = 'rating_'.$j;
                                $rating_id = 'rating_id_'.$j;
                            @endphp

                            {{ $j }}. 
                            @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                {{ $items->question_en }}
                            @else
                                {{ $items->question_th }}
                            @endif
                        </h6>
                        <br>
                        <center>
                            <table border="0">
                                <tr>
                                    <td class="td-star">
                                        <fieldset class="starability-basic">
                                            <input type="radio" id="{{ $rate_id_1 }}" name="{{ $rate_name }}" value="1" />
                                            <label for="{{ $rate_id_1 }}" title="@lang('frontend/layouts/title.improve')"></label>
                                            <input type="radio" id="{{ $rate_id_2 }}" name="{{ $rate_name }}" value="2" />
                                            <label for="{{ $rate_id_2 }}" title="@lang('frontend/layouts/title.not_good')"></label>
                                            <input type="radio" id="{{ $rate_id_3 }}" name="{{ $rate_name }}" value="3" />
                                            <label for="{{ $rate_id_3 }}" title="@lang('frontend/layouts/title.medium')"></label>
                                            <input type="radio" id="{{ $rate_id_4 }}" name="{{ $rate_name }}" value="4" />
                                            <label for="{{ $rate_id_4 }}" title="@lang('frontend/layouts/title.good')"></label>
                                            <input type="radio" id="{{ $rate_id_5 }}" name="{{ $rate_name }}" value="5" />
                                            <label for="{{ $rate_id_5 }}" title="@lang('frontend/layouts/title.very_good')"></label>
                                        </fieldset>
                                    </td>
                                </tr>
                            </table>
                            <table border="0">
                                <tr>
                                    <td class="td-rating">@lang('frontend/layouts/title.improve')</td>
                                    <td class="td-rating">@lang('frontend/layouts/title.not_good')</td>
                                    <td class="td-rating">@lang('frontend/layouts/title.medium')</td>
                                    <td class="td-rating">@lang('frontend/layouts/title.good')</td>
                                    <td class="td-rating">@lang('frontend/layouts/title.very_good')</td>
                                </tr>
                            </table>
                        </center>
                        <br>

                        <input type="hidden" name="rating_id[]" id="{{ $rating_id }}" value="{{ $items->_id }}">
                    </div>
                    <hr>
                @endforeach

                <br>
            </div>
        </div>

        <div class="wrap_header_mobile" style="padding-left: 0px;">
            <div class="tab-content col-md-12" id="myTabContent">
                <div id="inner">
                <img src="{{ asset ('suksa/frontend/template/images/icons/rating_star.jpg') }}" style="max-width: 250px; max-height: 250px;">
                </div>
                <br>
                <div id="inner">
                    <p class="iconhatfont">@lang('frontend/layouts/title.rating_review')</p>
                </div>
                <br>

                @foreach ($teaching_rating_questions as $i => $items)
                    <div id="inner">
                        <h6 style="text-align-last: center; padding-bottom: 10px;">
                            @php 
                                $j = $i+1; 
                                $rate_id_1 = 'rate_m_'.$j.'1';
                                $rate_id_2 = 'rate_m_'.$j.'2';
                                $rate_id_3 = 'rate_m_'.$j.'3';
                                $rate_id_4 = 'rate_m_'.$j.'4';
                                $rate_id_5 = 'rate_m_'.$j.'5';
                                $rate_name = 'rating_m_'.$j;
                                $rating_id = 'rating_id_m_'.$j;
                            @endphp

                            {{ $j }}. 
                            @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                {{ $items->question_en }}
                            @else
                                {{ $items->question_th }}
                            @endif
                        </h6>
                        <br>
                        <center>
                            <table border="0">
                                <tr>
                                    <td class="td-star-mobile">
                                        <fieldset class="starability-basic-mobile">
                                            <input type="radio" id="{{ $rate_id_1 }}" name="{{ $rate_name }}" value="1" />
                                            <label for="{{ $rate_id_1 }}" title="@lang('frontend/layouts/title.improve')"></label>
                                            <input type="radio" id="{{ $rate_id_2 }}" name="{{ $rate_name }}" value="2" />
                                            <label for="{{ $rate_id_2 }}" title="@lang('frontend/layouts/title.not_good')"></label>
                                            <input type="radio" id="{{ $rate_id_3 }}" name="{{ $rate_name }}" value="3" />
                                            <label for="{{ $rate_id_3 }}" title="@lang('frontend/layouts/title.medium')"></label>
                                            <input type="radio" id="{{ $rate_id_4 }}" name="{{ $rate_name }}" value="4" />
                                            <label for="{{ $rate_id_4 }}" title="@lang('frontend/layouts/title.good')"></label>
                                            <input type="radio" id="{{ $rate_id_5 }}" name="{{ $rate_name }}" value="5" />
                                            <label for="{{ $rate_id_5 }}" title="@lang('frontend/layouts/title.very_good')"></label>
                                        </fieldset>
                                    </td>
                                </tr>
                            </table>
                            <table border="0">
                                <tr>
                                    <td class="td-rating">@lang('frontend/layouts/title.improve')</td>
                                    <td class="td-rating">@lang('frontend/layouts/title.not_good')</td>
                                    <td class="td-rating">@lang('frontend/layouts/title.medium')</td>
                                    <td class="td-rating">@lang('frontend/layouts/title.good')</td>
                                    <td class="td-rating">@lang('frontend/layouts/title.very_good')</td>
                                </tr>
                            </table>
                        </center>
                        <br>

                        <input type="hidden" name="rating_m_id[]" id="{{ $rating_id }}" value="{{ $items->_id }}">
                    </div>
                    <hr>
                @endforeach

                <br>
            </div>
        </div>
    </section>

    <div class="col-md-12">
        <div class="container">
            <div class="row" align="center">
                <div class="col-sm">
                    <button type="submit" class="flex-c-m-rating bo-rad-23 s-text3 bgwhite hov1 trans-0-5 col-12 save-rating-teacher" style="width: 320px; height: 40px;"><object class="colorz">@lang('frontend/layouts/title.comfirm_rating')</object></button>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="course_id" id="course_id" value="{{ $course_id }}">
</form>
{{-- </form> --}}

<!-- Banner -->
<section class="blog p-t-10 p-b-40">
</section>

<!-- begining of page level js -->
<script src="{{ asset('assets/vendors/bootstrapStarRating/js/star-rating.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/bootstrapStarRating/themes/theme.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/vendors/bootstrapRating/bootstrap-rating.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/bootstrapRating/bootstrap-rating.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/js/pages/custom_rating.js') }}" type="text/javascript"></script>
<!-- end of page level js -->

@stop