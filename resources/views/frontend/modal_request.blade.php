@php
if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
    App::setLocale('en');
}
else{
    App::setLocale('th');
}
@endphp
<script src="{{ asset ('suksa/frontend/template/js/cleave.min.js') }}"></script>
<div class="modal fade bd-example-modal-lg" id="modal_request" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">@lang('frontend/members/title.build')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <style>
      select {
          text-align: center;
          text-align-last: center;
          /* webkit*/
        }
        option {
          text-align: left;
          /* reset to left*/
        }
        .swal2-container {
          z-index: 10000;
        }
        </style>

      <div class="modal-body">

        {{-- <form> --}}
        <label>@lang('frontend/members/title.how_long') :</label>
          <div class="row">
            <div class="col-6">
              <label class="container-radio">@lang('frontend/members/title.learn')
                  <input type="radio" name="study_now" class="study_now " value="1" checked="checked"/>
                  <span class="checkmark"></span>
              </label>
            </div>
            <div class="col-6 p-l-0">
              <div class="form-check">
                <label class="container-radio">@lang('frontend/members/title.specify')
                    <input type="radio" name="study_now" class="study_now " value="2" >
                    <span class="checkmark"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-6">
              <label>@lang('frontend/members/title.date_fo_study') :</label>
              <span style="color: red; font-size: 20px;" >*</span>
              <input class="form-control time_study daterange-input course_date" id="start_Date" type="text" name="day_study[]" placeholder="@lang('frontend/members/title.select_date')" autocomplete="off">
              <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
              <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
            </div>
            <div class="form-group col-6">
              <label>@lang('frontend/members/title.study_time') :</label>
              <span style="color: red; font-size: 20px;" >*</span>
              <input class="form-control time_study daterange-input2 start_time" id="start_time" type="text"  name="start_time"  placeholder="@lang('frontend/members/title.select_time')" autocomplete="off" >
              <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
              <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputState">@lang('frontend/members/title.study_group') :</label>
              <span style="color: red; font-size: 20px;" >*</span>
              <select class="form-control" style="padding-top: 4px;" id="study_group" onchange="request.subjects(this.value)"></select>
            </div>
            <div class="form-group col-md-6">
              <label for="inputState">@lang('frontend/members/title.subjects') :</label>
              <span style="color: red; font-size: 20px;" >*</span>
              <select class="form-control" style="padding-top: 4px;" id="subjects"></select>
            </div>
          </div>

          <label for="inputState col-sm-12">@lang('frontend/members/title.topic') : <span style="color: red; font-size: 20px;" >*</span></label>
          <div class="form-row">
            <div class="form-group col-sm-auto  col-md-12">
              <input type="text" class="form-control" id="topic"  name="topic">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col">
              <label for="inputEmail4">@lang('frontend/members/title.description') :</label>
              <textarea class="form-control" name="details_study" id="details_study" rows="4"></textarea>
            </div>
          </div>

          <label for="inputState col-sm-12">@lang('frontend/members/title.teaching') : <span style="color: red; font-size: 20px;" >*</span></label>
          <div class="form-row">
            <div class="form-group col-sm-auto">
              <input type="text" class="form-control"id="price_range"  name="price_range" onKeyPress="CheckNumm();" {{--  onchange="money();" --}}  placeholder="@lang('frontend/members/title.teaching') " data-type="currency"  required>
            </div>
          </div>


          <div id="data_menber"></div>
          <input type="text" class="form-control" id="lang_request" value="@lang('frontend/layouts/title.please_give_full_information')" name="lang_request" style="display:none;">
          {{-- <form> --}}

          <input type="hidden" name="current_date" id="current_date" value="{{ date('d/m/Y') }}">

      </div>
      <div class="modal-footer">
        <div class="col-md-3"></div>
        <div class="col-sm-12 col-md-6 text-center">
            <button type="button" id="confirm_request" onclick="request.make_data_request()" style="color: white; border: 1px;" class="btn flex-c-m size2 bo-rad-23">@lang('frontend/members/title.create_button')</button>
        </div>
        <div class="col-md-3"></div>
      </div>
    </div>
  </div>
</div>

<style>
 .daterange-input {
  background: url(../suksa/frontend/template/images/1470832.png ) no-repeat right 5px center;
  background-color: #ffffff;
  }
  .daterange-input2{
  background: url(../suksa/frontend/template/images/icons/time2.png) no-repeat right 5px center;
  background-color: #ffffff;
  }
</style>

<!-- กรอกเลข มี , และป้อนเลข 0 ไม่ได้  -->
<script>
    $(document).ready(function() {
        $("#price_range").keyup();
    });
    function formatNumber(n) {
      // format number 1000000 to 1,234,567
      return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }
    function financial(x) {
        if(x==''){
            return '';
        }
      return Number.parseFloat(x).toFixed(2);
    }
// Jquery Dependency

$("input[data-type='currency']").on({
keyup: function() {
//formatCurrency($(this));
},
blur: function() {
//formatCurrency($(this), "blur");
}
});


function formatNumber(n) {
// format number 1000000 to 1,234,567
return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}

</script>

<script language="javascript"> // ห้ามป้อน ตัวหนังสือ
function CheckNumm(){
if (event.keyCode < 48 || event.keyCode > 57){
event.returnValue = false;
// Swal.fire({
//     title: '<strong>'+val+'</u></strong>',
//     type: 'info',
//     showCloseButton: true,
//     showCancelButton: false,
//     focusConfirm: false,
//     confirmButtonColor: '#003D99',
//     confirmButtonText: 'ปิดหน้าต่าง',
//     });
}
}
</script>

<script>
// ห้ามป้อน 0
var cleaveNumeral = new Cleave('#price_range', {
numeral: true,
numeralThousandsGroupStyle: 'thousand'
});
</script>
