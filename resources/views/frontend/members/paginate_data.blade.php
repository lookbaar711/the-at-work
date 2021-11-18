<?php
    if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
        App::setLocale('en');
    }
    else{
        App::setLocale('th');
    }
?>

{{-- <div class="row" id="result"> --}}

		{{-- <div class="col-md-3 col-sm-6">
	        <div class="product-grid">

	            <div class="product-image">
	              	<a href="{{ url('members/detail/'.$member->id) }}">
	              	@if($member->member_img != "")
	                	<img class="pic-1" src="{{ asset ('storage/memberProfile/'.$member->member_img) }}" style="background-size: cover; height:300px; object-fit: cover">
	                @else
	                	<img class="pic-1" src="{{ asset ('suksa/frontend/template/images/icons/blank_image.jpg') }}" style="background-size: cover; height:300px; object-fit: cover">
	                @endif
	              	</a>
	              	<ul class="social">
	                  <li>
	                    <a href="{{ url('members/detail/'.$member->id) }}" data-tip="@lang('frontend/members/title.teacher_detail')"><i class="fa fa-search"></i></a>
	                  </li>
	              	</ul>
	            </div>

	            <div class="product-content">
	                <div class="title">
	                    <a style="font-size: 14px;" href="{{ url('members/detail/'.$member->id) }}">{{ $member->member_rate_start }} - {{ $member->member_rate_end }} @lang('frontend/members/title.coins_per_hour')</a>
	                </div>
	                <div class="title">
	                    <a href="{{ url('members/detail/'.$member->id) }}">{{ $member->member_fname }} {{ $member->member_lname }}</a>
	                </div>
	                 <div class="title">
	                    <a href="{{ url('members/detail/'.$member->id) }}">
	                    @php
                        $subject_all = []; $data_apptitude = ''; $subject = ''; $subject_all = [];
                      @endphp
	                    	@foreach (array_keys($member->member_aptitude) as $key)
			                    @if (count($member->member_aptitude[$key]) > 0)
			                        @foreach ($member->member_aptitude[$key] as $i => $items)
			                            @if(in_array($items, $subject_all))

			                            @else
                                    @php
                                      $data_apptitude++;
                                    @endphp

			                                @if ($data_apptitude > 3)
                                        @php
                                          continue;
                                        @endphp
			                                @else
                                        @php
                                          $subject .= $items.' ';
                                        @endphp
			                                @endif
			                            @endif
                                  @php
                                    $subject_all[] = $items;
                                  @endphp
			                        @endforeach
			                    @endif
			                @endforeach
			                {{$subject}}
	                    </a>
	                </div>
	            </div>

	        </div>
	    </div> --}}

{{-- </div> --}}

<div class="btn-group pull-right page_menber">
	{{-- {{ $members->links("pagination::bootstrap-4") }} --}}
</div>
