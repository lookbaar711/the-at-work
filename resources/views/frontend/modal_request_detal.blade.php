@php
if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
    App::setLocale('en');
}
else{
    App::setLocale('th');
}
@endphp
<div class="modal fade bd-example-modal-lg" id="modal_request_2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">@lang('frontend/members/title.request_summary')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        {{-- <form> --}}

        <div class="modal-body">
          <label>@lang('frontend/members/title.request_teaching') :</label>
          <p class="study_now2"></p>
          <label>@lang('frontend/members/title.teaching') :</label>
          <p class="price_range2"></p>
          <label>@lang('frontend/members/title.topic') :</label>
          <p class="topic2"></p>
          <label>@lang('frontend/members/title.study_group') :</label>
          <p class="study_group2"></p>
          <label>@lang('frontend/members/title.subjects') :</label>
          <p class="subjects2"></p>
          <label>@lang('frontend/members/title.description') :</label>
          <p class="details_study2"></p>
          @php
            $members = Auth::guard('members')->user();
          //   print_r("<pre>");
          // print_r($members);
          // print_r("<pre>");
          @endphp
          <input type="text" name="data_members" id="data_members" value="{{$members}}" style="display:none;">


        </div>

          {{-- <form> --}}

      </div>
      <div class="modal-footer">
        <div class="col-md-3"></div>
        <div class="col-sm-12 col-md-6 text-center ">
            <div class="show_request"></div>
            <button type="button" id="confirm_request_2" onclick="request.confirm_request()" style="color: white;" class="btn btn-light flex-c-m bo-rad-23  bgwhite hov1 trans-0-4 color7">@lang('frontend/members/title.confirm_create_request')</button>
        </div>
        <div class="col-md-3"></div>
      </div>
    </div>
  </div>
</div>
