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

  <style type="text/css">
    p.dotted {
      border-style: dotted;
      border-radius: 8px;
      color: #d2d2d6;
    } 
  </style>
@endsection
@section('content')
  <script type="text/javascript">
    @if(session('saverevoke')=='fail')
      var withdraw_coins_failed = '{{ trans('frontend/coins/title.withdraw_coins_failed') }}';
      var withdraw_coins_message_1 = '{{ trans('frontend/coins/title.withdraw_coins_message_1') }}';
      var withdraw_coins_message_2 = '{{ trans('frontend/coins/title.withdraw_coins_message_2') }}';

      var close_window = '{{ trans('frontend/coins/title.close_window') }}';

      Swal.fire({
        title: '<strong>'+withdraw_coins_failed+'</u></strong>',
        type: 'error',
        imageHeight: 100,
        html:
            withdraw_coins_message_1+'<br>'+withdraw_coins_message_2,
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonColor: '#28a745',
        confirmButtonText: close_window,
      });
    @endif
  </script>


  <!-- Group learning -->
  <form action="{{ url('coins/revoke') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}

    <section class="p-t-20 p-b-50">
      <div class="container">
        <table align="left" >
          <tr>
            <td style="display: inline-block; padding-right: 15px;">
              <div class="circle-grid-profile">
                @if(empty($members->member_img))
                  <img id="myImage" class="circular_image" src="{{ asset ('suksa/frontend/template/images/icons/imgprofile_default.jpg') }}" style="background-size: cover; width: 100%;">
                @else
                  <img id="myImage"  class="circular_image" src="{{ asset ('storage/memberProfile/'.$members->member_img) }}" style="background-size: cover; width: 100%;" >
                @endif
              </div>
            </td>
          <tr>
        </table>
      </div>
      <div class="container">
        <div class="col p-t-20 ">
          <label class="fontsize478">@lang('frontend/coins/title.hello') {{ $members->member_fname." ".$members->member_lname }}</label>
           <div class="row align-items-center">
              <div class="col-sm-auto">
                      <object class="fontstyle02">@lang('frontend/coins/title.your_coins')
                          <label class="fontnum">
                            @if($members->member_coins>0)
                              {{ $members->member_coins }}
                            @else
                              0
                            @endif
                          <img src="{{ asset ('suksa/frontend/template/images/icons/Coins.png') }}" >
                          </label>
                      </object>
                  </div>
          <div class="col">
          </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="container p-t-10 p-b-10">
        <div class="container p-t-20 p-b-20" style="text-align: center; background-color: #F4F4F6; ">
          <div class="row align-items-center">
            <div class="container col-sm-7">
              <div class="form-row"  style="text-align-last: left;">
                <div class="col-5">
                      <h6 style="text-align: left;">@lang('frontend/coins/title.number_of_coins_to_withdraw') : <span style="color:red;">*</span></h6>
                      <p style="font-size: 11px;">@lang('frontend/coins/title.withdraw_rate')</p>
                </div>
                <div class="col-6">
                      <input  type="text" name="withdraw_coin_number" class="form-control" id="coin_number" onKeyPress="CheckNumm();" aria-describedby="emailHelp" placeholder="@lang('frontend/coins/title.amount')" style="height: 50px;"   data-type="currency"  required>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="p-t-10 ">
      <div class="container">
        <div class="container" style="text-align: center;">
          <div class="row" >
            <div class="container col-sm-7">
              <div class="form-row"  style="text-align-last: left;">
                <div class="col-12 ">
                  <h6 id="title" style="font-size: 18px;">@lang('frontend/coins/title.receive_amount') : <label class="free2" id="number_cois" style="font-size: 30px; color:#65BB34;" ></label></h6>
                </div>
              </div>
            </div>
          </div>
        <hr>
        </div>
      </div>
    </section>

    <section class="p-t-10 ">
      <div class="container">
        <div class="container" style="text-align: center;">
          <div class="row" >
            <div class="container col-sm-7">
              <div class="form-row"  style="text-align-last: left;">
                <div class="col-12 ">
                  <div class="row">
                    <h6 class="col-sm-12" for="dtp_input1"  style="text-align-last: left; padding-bottom: 10px;">@lang('frontend/coins/title.select_bank') : <span style="color:red;">*</span></h6>
                  </div>

                  <select name="member_bank" id="member_bank" class="form-control" style="padding-top: 4px;" required>
                    <option selected value="">@lang('frontend/coins/title.select_bank')</option>
                            
                    @foreach($member_bank as $index => $item)
                        <option value="{{ $item->_id }}" style="color:black;">
                            @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                {{$item->bank_name_en}} 
                            @else
                                {{$item->bank_name_th}} 
                            @endif
                            {{$item->bank_account_number}}
                        </option>
                    @endforeach

                  </select>
                  <br>
                </div>
              </div>
            </div>
          </div>
        <hr>
        </div>
      </div>
    </section>

    <section class="p-t-10 ">
      <div class="container">
        <div class="container" style="text-align: center;">
          <div class="col-sm-12">
            <div class="form-row"  style="text-align-last: left;">
              <div class="col-12 ">
                <div class="row">
                  <div class="col-sm-12 p-l-0 p-r-0" >
                    <p class="dotted">
                      <i class="fa fa-warning" style="font-size:26px;color:red;padding-left: 10px;padding-top: 5px;"></i> &nbsp;<label style="font-size: 20px; color: #E23939; font-weight: bold;">@lang('frontend/courses/title.note')</label>
                      <br>
                      
                      <label style="padding-left: 10px; padding-right: 10px; text-align:left; color: black;">
                        @lang('frontend/coins/title.withdraw_note_detail_1')
                      </label><br>
                      <label style="padding-left: 10px; padding-right: 10px; text-align:left; color: black;">
                        @lang('frontend/coins/title.withdraw_note_detail_2')
                      </label><br>
                      <label style="padding-left: 10px; padding-right: 10px; text-align:left; color: black;">
                        @lang('frontend/coins/title.withdraw_note_detail_example_start')
                      </label><br>
                      <label style="padding-left: 10px; padding-right: 10px; text-align:left; color: black;">
                        @lang('frontend/coins/title.withdraw_note_detail_example_1')
                      </label><br>
                      <label style="padding-left: 10px; padding-right: 10px; text-align:left; color: black;">
                        @lang('frontend/coins/title.withdraw_note_detail_example_2') 
                        @lang('frontend/coins/title.withdraw_note_detail_example_end')
                      </label><br>
                      {{-- <label style="padding-left: 10px; padding-right: 10px; text-align:left; color: black;">
                        @lang('frontend/coins/title.withdraw_note_detail_example_end')
                      </label><br> --}}
                    </p>
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
            <button type="submit" onclick="return chk()" class="flex-c-m size2 bo-rad-23 s-text3 bgwhite hov1 trans-0-5 col-12"><object class="colorz">@lang('frontend/coins/title.save_button')</object></button>
          </div>
          <div class="col-sm"></div>
        </div>
      </div>
    </div>
  </form>

  <!-- Banner -->
  <section class="blog p-t-10 p-b-40"></section>

  <script>
    var please_select_payment_channel = '{{ trans('frontend/coins/title.please_select_payment_channel') }}';
    var please_select_slip = '{{ trans('frontend/coins/title.please_select_slip') }}';
    var please_enter_number_of_coins_to_withdraw = '{{ trans('frontend/coins/title.please_enter_number_of_coins_to_withdraw') }}';
    var please_enter_number_only = '{{ trans('frontend/coins/title.please_enter_number_only') }}';

    var close_window = '{{ trans('frontend/coins/title.close_window') }}';

    $(document).ready(function() {
      $("#coin_number").keyup(money);
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
    async function money(){
      var number = $("#coin_number").val();

      //document.getElementById("title").innerHTML = await  'จำนวนเงินที่ต้องชำระ (บาท) : ';
      if(number==''){
        document.getElementById("number_cois").innerHTML = number;
        console.log('555');
      } 
      else{
        document.getElementById("number_cois").innerHTML = number+'.00';
      }
    }

    // เช็ค ข้อมูล ทุกช่อง
    function chk(){
      $ktb = $("#ktb:checked").val();
      $kb = $("#k:checked").val();
      $scb = $("#SCB:checked").val();
      $slip = $("#file-upload").val();
      $coinnumber = $("#coin_number").val();
      $nums = $("#number").val();
      $member_bank = $("#member_bank").val();

      if($coinnumber ==''){
          alertSwal('<h3>'+please_enter_number_of_coins_to_withdraw+'<h3>')
          return false;
      }
      if($nums ==''){
          alertSwal('<h3>'+please_enter_number_only+'<h3>')
          //กรุณากรอกข้อมูลให้ครบทุกช่อง
          return false;
      }
      
      // if($ktb==null && $kb==null && $scb==null){
      //     alertSwal('<h3>'+please_select_payment_channel+'<h3>')
      //     return false;
      // }
      // if($slip==''){
      //     alertSwal('<h3>'+please_select_slip+'<h3>')
      //     return false;
      // }
      

      if($member_bank==''){
        alertSwal('<h3>'+please_select_bank_account_number+'<h3>')
        return false;
      }
    }  

    // เช็ค ข้อมูล ทุกช่อง
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

    // Jquery Dependency

    $("input[data-type='currency']").on({
      keyup: function() {
        formatCurrency($(this));
      },
      blur: function() {
        formatCurrency($(this), "blur");
      }
    });


    function formatNumber(n) {
      // format number 1000000 to 1,234,567
      return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }


    function formatCurrency(input, blur) {
      // appends $ to value, validates decimal side
      // and puts cursor back in right position.

      // get input value
      var input_val = input.val();

      // don't validate empty input
      if (input_val === "") { return; }

      // original length
      var original_len = input_val.length;

      // initial caret position
      var caret_pos = input.prop("selectionStart");

      // check for decimal
      if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);

        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
          right_side += "00";
        }

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = left_side + "." + right_side;

      } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = input_val;

        // final formatting
        if (blur === "blur") {
          input_val += "";
        }
      }

      // send updated string to input
      input.val(input_val);

      // put caret back in the right position
      var updated_len = input_val.length;
      caret_pos = updated_len - original_len + caret_pos;
      input[0].setSelectionRange(caret_pos, caret_pos);
    }


    // ตัวเลข - - - - - ----


    function autoTab(obj){
      /* กำหนดรูปแบบข้อความโดยให้ _ แทนค่าอะไรก็ได้ แล้วตามด้วยเครื่องหมาย
      หรือสัญลักษณ์ที่ใช้แบ่ง เช่นกำหนดเป็น  รูปแบบเลขที่บัตรประชาชน
      4-2215-54125-6-12 ก็สามารถกำหนดเป็น  _-____-_____-_-__
      รูปแบบเบอร์โทรศัพท์ 08-4521-6521 กำหนดเป็น __-____-____
      หรือกำหนดเวลาเช่น 12:45:30 กำหนดเป็น __:__:__
      ตัวอย่างข้างล่างเป็นการกำหนดรูปแบบเลขบัตรประชาชน
      */
      var pattern=new String("___-_-_____-_"); // กำหนดรูปแบบในนี้
      var pattern_ex=new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้
      var returnText=new String("");
      var obj_l=obj.value.length;
      var obj_l2=obj_l-1;

      for(i=0;i<pattern.length;i++){
          if(obj_l2==i && pattern.charAt(i+1)==pattern_ex){
              returnText+=obj.value+pattern_ex;
              obj.value=returnText;
          }
      }
      if(obj_l>=pattern.length){
          obj.value=obj.value.substr(0,pattern.length);
      }
    }

    // จำกัดการป้อน
    function isNumber(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
      }
      return true;
    }

  </script>


  <script language="javascript">
    var please_enter_number_only = '{{ trans('frontend/coins/title.please_enter_number_only') }}';

    function CheckNumm(){
    if (event.keyCode < 48 || event.keyCode > 57){
        event.returnValue = false;
        alertSwal(please_enter_number_only)
      }
    }
  </script>
  <script>
    // numeral
    var cleaveNumeral = new Cleave('#coin_number', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'

    });
  </script>

@stop
