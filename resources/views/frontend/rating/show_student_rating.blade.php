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

    <link type="text/css" href="{{ asset('assets/vendors/bootstrap-multiselect/css/bootstrap-multiselect.css') }}"
      rel="stylesheet"/>

<!-- เวลา -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<!-- เวลา -->



@endsection
@section('content')

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

                <div>
                    <h6 style="text-align-last: center; padding-bottom: 10px;">
                        @lang('frontend/layouts/title.course') : {{ $rating_detail['course_name'] }}
                    </h6>
                    <h6 style="text-align-last: center; padding-bottom: 10px;">
                        @lang('frontend/layouts/title.teacher') : {{ $rating_detail['teacher_name'] }}
                    </h6>
                    <h6 style="text-align-last: center; padding-bottom: 10px;">
                        @lang('frontend/layouts/title.student') : {{ $rating_detail['student_name'] }}
                    </h6>
                    <br>
                </div>
                <hr>
                
                @foreach ($learning_rating_questions as $i => $items)
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
                                            <input type="radio" id="{{ $rate_id_1 }}" name="{{ $rate_name }}" value="1" 
                                            @if(($student_rating->rating[$i][0] == $items->_id) && ($student_rating->rating[$i][1] == '1'))
                                            checked
                                            @endif
                                            />
                                            <label title="@lang('frontend/layouts/title.improve')"></label>

                                            <input type="radio" id="{{ $rate_id_2 }}" name="{{ $rate_name }}" value="2" 
                                            @if(($student_rating->rating[$i][0] == $items->_id) && ($student_rating->rating[$i][1] == '2'))
                                            checked
                                            @endif
                                            />
                                            <label title="@lang('frontend/layouts/title.not_good')"></label>
                                            
                                            <input type="radio" id="{{ $rate_id_3 }}" name="{{ $rate_name }}" value="3" 
                                            @if(($student_rating->rating[$i][0] == $items->_id) && ($student_rating->rating[$i][1] == '3'))
                                            checked
                                            @endif
                                            />
                                            <label title="@lang('frontend/layouts/title.medium')"></label>
                                            
                                            <input type="radio" id="{{ $rate_id_4 }}" name="{{ $rate_name }}" value="4" 
                                            @if(($student_rating->rating[$i][0] == $items->_id) && ($student_rating->rating[$i][1] == '4'))
                                            checked
                                            @endif
                                            />
                                            <label title="@lang('frontend/layouts/title.good')"></label>
                                            
                                            <input type="radio" id="{{ $rate_id_5 }}" name="{{ $rate_name }}" value="5" 
                                            @if(($student_rating->rating[$i][0] == $items->_id) && ($student_rating->rating[$i][1] == '5'))
                                            checked
                                            @endif
                                            />
                                            <label title="@lang('frontend/layouts/title.very_good')"></label>
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

                <div>
                    <h6 style="text-align-last: center; padding-bottom: 10px;">
                        @lang('frontend/layouts/title.recommend')
                    </h6>
                    <center>
                        <textarea class="form-control" name="recommend_web" id="recommend_web" rows="3" style="width: 100%; max-width: 400px;" readonly>{{ $student_rating->recommend }}</textarea>
                    </center>
                    <br>
                </div>
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

                <div>
                    <h6 style="text-align-last: center; padding-bottom: 10px;">
                        @lang('frontend/layouts/title.course') : {{ $rating_detail['course_name'] }}
                    </h6>
                    <h6 style="text-align-last: center; padding-bottom: 10px;">
                        @lang('frontend/layouts/title.teacher') : {{ $rating_detail['teacher_name'] }}
                    </h6>
                    <h6 style="text-align-last: center; padding-bottom: 10px;">
                        @lang('frontend/layouts/title.student') : {{ $rating_detail['student_name'] }}
                    </h6>
                    <br>
                </div>
                <hr>
                
                @foreach ($learning_rating_questions as $i => $items)
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
                                            <input type="radio" id="{{ $rate_id_1 }}" name="{{ $rate_name }}" value="1" 
                                            @if(($student_rating->rating[$i][0] == $items->_id) && ($student_rating->rating[$i][1] == '1'))
                                            checked
                                            @endif
                                            />
                                            <label title="@lang('frontend/layouts/title.improve')"></label>

                                            <input type="radio" id="{{ $rate_id_2 }}" name="{{ $rate_name }}" value="2" 
                                            @if(($student_rating->rating[$i][0] == $items->_id) && ($student_rating->rating[$i][1] == '2'))
                                            checked
                                            @endif
                                            />
                                            <label title="@lang('frontend/layouts/title.not_good')"></label>
                                            
                                            <input type="radio" id="{{ $rate_id_3 }}" name="{{ $rate_name }}" value="3" 
                                            @if(($student_rating->rating[$i][0] == $items->_id) && ($student_rating->rating[$i][1] == '3'))
                                            checked
                                            @endif
                                            />
                                            <label title="@lang('frontend/layouts/title.medium')"></label>
                                            
                                            <input type="radio" id="{{ $rate_id_4 }}" name="{{ $rate_name }}" value="4" 
                                            @if(($student_rating->rating[$i][0] == $items->_id) && ($student_rating->rating[$i][1] == '4'))
                                            checked
                                            @endif
                                            />
                                            <label title="@lang('frontend/layouts/title.good')"></label>
                                            
                                            <input type="radio" id="{{ $rate_id_5 }}" name="{{ $rate_name }}" value="5" 
                                            @if(($student_rating->rating[$i][0] == $items->_id) && ($student_rating->rating[$i][1] == '5'))
                                            checked
                                            @endif
                                            />
                                            <label title="@lang('frontend/layouts/title.very_good')"></label>
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

                <div>
                    <h6 style="text-align-last: center; padding-bottom: 10px;">
                        @lang('frontend/layouts/title.recommend')
                    </h6>
                    <center>
                        <textarea class="form-control" name="recommend_mobile" id="recommend_mobile" rows="3" style="width: 100%; max-width: 280px;" readonly>{{ $student_rating->recommend }}</textarea>
                    </center>
                    <br>
                </div>
            </div>
        </div>
    </section>

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