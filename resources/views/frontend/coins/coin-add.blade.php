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
    
            .daterange-input {
            background: url(../suksa/frontend/template/images/147083.png) no-repeat right 5px center;
            background-color: #FFFFFF;
            }
            .daterange-input2{
            background: url(../suksa/frontend/template/images/icons/time.png) no-repeat right 5px center;
            background-color: #FFFFFF;
            }

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
<form action="{{ url('coins/add') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <section class="p-t-50 ">
        <div class="container">
            <div class="tab-content" id="myTabContent">
                <div id="inner">
                <p class="iconhatfont">@lang('frontend/coins/title.topup_coins')</p>
                </div>
                <hr>
            </div>
            <div class="container" style="text-align: center;">
                <div class="row" >
                    <div class="container col-sm-7">
                        <div class="row">
                            <div class="col-sm-12 p-b-3"  >
                              <div style="text-align: left; font-size: 18px;">
                                <h6 style="text-align-last: left; padding-bottom: 10px;">@lang('frontend/coins/title.select_payment_channel') :  <span style="color:red;">*</span> </h6>
                              </div>
                            </div>



                            @foreach($bank as $index => $item)
                                

                                <div class="col-sm-4">
                                    <input type="radio" name="coin_bank" id="{{ $item->_id }}" value="{{ $item->_id }}" class="input-hidden">
                                    <label for="{{ $item->_id }}">
                                        <div class="card-body">
                                            <div class="img-responsive4">

                                            <img class="pic-1" src="{{ asset ('suksa/frontend/template/images/icons/'.$item->bank_code.'.png') }}">   
                                            </div>
                                            <ul>
                                                <li>
                                                    @if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en'))
                                                        {{ $item->bank_name_en }} 
                                                    @else
                                                        {{ $item->bank_name_th }} 
                                                    @endif
                                                </li>
                                                <p>{{ $item->bank_account_number }}</p>
                                                <p>{{ $item->account_name }}</p>
                                            </ul>
                                        </div>
                                    </label>
                                </div> 

                            @endforeach

                            {{-- 
                            <div class="col-md-4" >
                                <input type="radio" name="coin_bank" value="5dd616b51d9c7d3a84001c4a" id="ktb" class="input-hidden" />
                                <label for="ktb">
                                    <div class="card-body"   alt="I'm ktb">
                                        <div class="img-responsive4">
                                            <img class="pic-1" src="{{  asset ('suksa/frontend/template/images/icons/KTB iBanking.png')  }}"  >
                                        </div>
                                        <ul >
                                            <li >KTB iBanking</li>
                                            <p >XXX-X-XXXXX-X</p>
                                            <p >ทดสอบบัญชี</p>
                                        </ul>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" name="coin_bank" value="5e1941de1d9c7d37c0006272" id="k" class="input-hidden" />
                                <label for="k">
                                    <div class="card-body"  alt="I'm k">
                                        <div class="img-responsive4">     
                                          <img class="pic-1" src="{{ asset ('suksa/frontend/template/images/icons/KBank iBanking.png') }}">
                                        </div>
                                        <ul>
                                            <li>KBank iBanking</li>
                                            <p>XXX-X-XXXXX-X</p>
                                            <p>ทดสอบบัญชี</p>
                                        </ul>
                                    </div>
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <input type="radio" name="coin_bank" value="5e1949ab1d9c7d37c0006273" id="SCB" class="input-hidden" />
                                <label for="SCB">
                                    <div class="card-body" alt="I'm SCB">
                                        <div class="img-responsive4">
                                        <img class="pic-1" src="{{ asset ('suksa/frontend/template/images/icons/SCB iBanking.png') }}">   
                                            </div>
                                        <ul>
                                            <li>SCB iBanking</li>
                                            <p>XXX-X-XXXXX-X</p>
                                            <p>ทดสอบบัญชี</p>
                                        </ul>
                                    </div>
                                </label>
                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container p-t-10 p-b-10">
            <div class="container p-t-20 p-b-20" style="text-align: center; background-color: #F4F4F6;">
                <div class="row align-items-center">
                    <div class="container col-sm-7">
                        <div class="form-row"  style="text-align-last: left;">
                            <div class="col-sm-5" style="padding-right:10px">
                                <h6>@lang('frontend/coins/title.number_of_coins_to_topup') : <span style="color:red;">*</span></h6>
                                <p style="font-size: 11px;">@lang('frontend/coins/title.topup_rate')</p>
                            </div>
                            <div class="col-7">
                                <input type="text" name="coin_number" class="form-control" id="coin_number" onKeyPress="CheckNumm();"  onchange="money()" aria-describedby="emailHelp" placeholder="@lang('frontend/coins/title.amount')" style="height: 50px;" data-type="currency"  required>
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
                                <h6 id="title">@lang('frontend/coins/title.paid_amount') : <label class="free2" id="number_cois" ></label></h6>
                            </div>
                        </div>
                    </div>
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
                                        <h6 class="col-sm-12" for="dtp_input1"  style="text-align-last: left; padding-bottom: 10px;">@lang('frontend/coins/title.select_bank') : <span style="color:red;">*</span></h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select name="member_bank" id="member_bank" class="form-control" style="padding-top: 4px;" required>
                                                <option value="" selected>@lang('frontend/coins/title.select_bank')</option>
                                                    
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
                                <div class="col-md-6">
                                    <div class="row">
                                        <h6 class="col-sm-12" for="dtp_input1"  style="text-align-last: left; padding-bottom: 10px;">@lang('frontend/coins/title.paid_date') : <span style="color:red;">*</span></h6>
                                       
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">                    
                                            <input class="form-control daterange-input" name="coin_date" id="datepicker01" type="text"  placeholder="@lang('frontend/coins/title.select_paid_date')" autocomplete="off" > 
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="col-md-3">
                                    <div class="row">
                                        <h6 class="col-sm-12" style="text-align-last: left; padding-bottom: 10px;">@lang('frontend/coins/title.time') : <span style="color:red;">*</span></h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select name="h" id="inputState" class="form-control" style="padding-top: 4px;" required>
                                                <option selected value="">@lang('frontend/coins/title.hour')</option>
                                                    @for ($i=0; $i<24; $i++)
                                                        <option>{{sprintf("%02d", $i)}}</option>
                                                    @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row"><h6 class="col-sm-12" style="text-align-last: left; padding-bottom: 10px;">&nbsp;</h6></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select name="m" id="inputState" class="form-control" style="padding-top: 4px;" required>
                                                <option selected value="">@lang('frontend/coins/title.minute')</option>
                                                    @for ($i=0; $i<60; $i++)
                                                        <option>{{ sprintf("%02d", $i) }}</option>
                                                    @endfor
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
                <div class="row" >
                    <div class="container col-sm-7">
                        <div class="form-group">
                            <div class="form-row"  style="text-align-last: left;">
                                <h6 class="col-12">@lang('frontend/coins/title.upload_slip') : <span style="color:red;">*</span></h6>
                                <div class="col-5">
                                    
                                    <label for="file-upload" class="custom-file-upload btn btn-dark btn-block" style="text-align-last: center;" ><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;@lang('frontend/coins/title.upload_button') </label>
                                    <input id="file-upload" name='upload_slip' type="file" style="display:none;" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
                            {{-- </div>
                        </div>
                    </div>
                    
                </div>
            </div>
</section> --}}
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
<section class="blog p-t-10 p-b-40">
</section>
        
<script>
    var please_select_payment_channel = '{{ trans('frontend/coins/title.please_select_payment_channel') }}';
    var please_select_slip = '{{ trans('frontend/coins/title.please_select_slip') }}';
    var please_enter_number_of_coins_to_topup = '{{ trans('frontend/coins/title.please_enter_number_of_coins_to_topup') }}';
    var please_select_paid_date = '{{ trans('frontend/coins/title.please_select_paid_date') }}';

    var please_select_bank_account_number = '{{ trans('frontend/coins/title.please_select_bank_account_number') }}';

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
        } else{
            document.getElementById("number_cois").innerHTML = number+'.00';
        }              
    }
    
    function chk(){
        $ktb = $("#ktb:checked").val();
        $kb = $("#k:checked").val();
        $scb = $("#SCB:checked").val();
        $slip = $("#file-upload").val();
        $zero = $("#coin_number").val();
        $dates = $("#datepicker01").val();
        $member_bank = $("#member_bank").val();

        if($("input[name='coin_bank']:checked").val()==null){
            alertSwal('<h3>'+please_select_payment_channel+'<h3>')
            return false;
        }
        if(($zero=='0') || ($zero=='')){
            alertSwal('<h3>'+please_enter_number_of_coins_to_topup+'<h3>')
            return false;
        }
        if($member_bank==''){
            alertSwal('<h3>'+please_select_bank_account_number+'<h3>')
            return false;
        }
        if($dates==''){
            alertSwal('<h3>'+please_select_paid_date+'<h3>')
            return false;
        }
        if($slip==''){
            alertSwal('<h3>'+please_select_slip+'<h3>')
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
        } 
        else {
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
</script>

<script language="javascript"> 
    function CheckNumm(){	
        if(event.keyCode < 48 || event.keyCode > 57){  
            var close_window = '{{ trans('frontend/coins/title.close_window') }}';
            vent.returnValue = false;
            Swal.fire({
                title: '<strong>'+val+'</u></strong>',
                type: 'info',
                showCloseButton: true,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonColor: '#28a745',
                confirmButtonText: close_window,
            });		 
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
<script>
    // $('#datepicker01').datepicker({
    //     uiLibrary: 'bootstrap4',
    //     formatdate: "dd MM yyyy",
    //     autoclose: true,
    //     todayBtn: true,      
    // });

    $('#datepicker01').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayBtn: true,
    });
</script>


@stop