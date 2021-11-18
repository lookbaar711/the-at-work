<?php
    if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
        App::setLocale('en');
    }
    else{
        App::setLocale('th');
    }
?>

<style>

    .swal2-container {
      z-index: 10000;
    }

</style>
<div class="modal fade bd-example-modal-lg" id="model_profile_edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">@lang('frontend/members/title.edit_profile_info')</h5>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row">
              <div class="col-sm-12 ">
                  <div class="wizard-container">
                      <div class="wizard-card" data-color="green" id="wizardProfile">
                        @php
                          $members = Auth::guard('members')->user()->_id;
                        @endphp
                        <input type="text" name="data_members_id" id="data_members_id" value="{{$members}}" style="display:none;">
                          <form role="form" method="POST" id="form_profile_edit" action="{{ route('members.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                              {{ csrf_field() }}
                            <input type="text" name="member_id" id="member_id" value="{{$members}}" style="display: none;" />
                            <input type="text" name="please_complete" id="please_complete" value="@lang('frontend/members/title.please_complete')" style="display: none;" />
                            <input type="text" name="lang" id="lang" value="" style="display: none;" />
                            <div class="alert alert-secondary" role="alert">
                              @lang('frontend/members/title.profile_info')
                            </div>
                              <div class="tab-content">

                                  <div class="tab-pane active" id="tab1">
                                      <div class="row">
                                        <div class="row col-md-12">
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label" >@lang('frontend/members/title.id_card_no')  : <span style="color: red; font-size: 20px;" >* </span></label>
                                                    <input name="member_idCard" id="member_idCard" type="text" maxlength="13"   onkeypress="return isNumber(event)" required class="form-control"   autocomplete="cc-exp" disabled>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                  <label class="control-label">@lang('frontend/members/title.prefix') : <span style="color: red; font-size: 20px;" >* </span></label>
                                                  <select name="member_sername" id="member_sername" required class="form-control input-md" style="font-size: 16px; padding-top: 4px;">
                                                        <option value="mr" style="color:black;">@lang('frontend/members/title.mr')</option>
                                                        <option value="mrs" style="color:black;">@lang('frontend/members/title.mrs')</option>
                                                        <option value="miss" style="color:black;">@lang('frontend/members/title.miss')</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-3" >
                                                <div class="form-group label-floating">
                                                    <label class="control-label">@lang('frontend/members/title.first_name') : <span style="color: red; font-size: 20px;" >* </span></label>
                                                    <input name="member_fname" id="member_fname" required type="text" class="form-control"    > <!--onkeypress="return not_number(event)" -->
                                                </div>
                                            </div>

                                            <div class="col-sm-3" >
                                                <div class="form-group label-floating">
                                                    <label class="control-label">@lang('frontend/members/title.last_name') : <span style="color: red; font-size: 20px;" >* </span></label>
                                                    <input name="member_lname" id="member_lname" type="text" required class="form-control"  >
                                                </div>
                                            </div>

                                        </div>
                                      </div>


                                      <div class="row">
                                        <div class="row col-md-12">
                                          <div class="col-sm-3" >
                                              <div class="form-group label-floating">
                                                  <label class="control-label">@lang('frontend/members/title.nickname') : <span style="color: red; font-size: 20px;" > </span></label>
                                                  <input name="member_nickname" id="member_nickname" type="text" class="form-control">
                                              </div>
                                           </div>

                                           <div class="col-md-3">
                                               <div class="form-group label-floating">
                                                   <label class="control-label">@lang('frontend/members/title.member_email') : <span style="color: red; font-size: 20px;" >* </span></label>
                                                   <input name="member_email" id="member_email" type="text" class="form-control" disabled>
                                               </div>
                                            </div>

                                          <div class="col-md-3">
                                              <div class="form-group label-floating">
                                                  <label class="control-label">@lang('frontend/members/title.birthday') : <span style="color: red; font-size: 20px;" >* </span></label>
                                                  <div class='input-group date' id='datepicker_profile'>
                                                      <input type='text' name="date" id="member_Bday" class="form-control" style="background-color : #ffffff;" required readonly>
                                                      <span class="input-group-addon">
                                                          <span class="fa fa-calendar"></span>
                                                      </span>
                                                  </div>
                                                  {{-- <div class='input-group date' id='datetimepicker1'>
                                                      <input name="date" placeholder="MM/DD/YYYY" type="text" id="member_Bday" required class="form-control datetimepicker1" value=""/>
                                                      <span class="input-group-addon">
                                                          <span class="glyphicon glyphicon-calendar"></span>
                                                      </span>
                                                  </div> --}}
                                              </div>
                                          </div>

                                          <div class="col-md-3">
                                               <div class="form-group label-floating">
                                                 <label class="control-label">@lang('frontend/members/title.mobile_no') : <span style="color: red; font-size: 20px;" >* </span></label>
                                                  <input name="member_tell" id="member_tell" type="text" maxlength="10" onkeypress="return isNumber(event)" class="form-control" required >
                                              </div>
                                          </div>

                                        </div>
                                      </div>


                                      <div class="row">
                                        <div class="row col-md-12">

                                          <div class="col-md-3">
                                              <div class="form-group label-floating">
                                                  <label class="control-label">@lang('frontend/members/title.min_price') : <span style="color: red; font-size: 20px;" >* </span></label>
                                                  <input name="member_rate_start" id="member_rate_start" type="text" required class="form-control rate">
                                              </div>
                                          </div>

                                          <div class="col-md-3">
                                              <div class="form-group label-floating">
                                                  <label class="control-label">@lang('frontend/members/title.max_price') : <span style="color: red; font-size: 20px;" >* </span></label>
                                                  <input name="member_rate_end" id="member_rate_end" type="text" required class="form-control rate" >
                                              </div>
                                          </div>

                                          <div class="col-sm-3">
                                              <div class="form-group label-floating">
                                                  <label class="control-label">@lang('frontend/members/title.line_id') : <span style="color: red; font-size: 20px;" >* </span></label>
                                                  <input name="member_idLine" id="member_idLine" required type="text" class="form-control" >
                                              </div>
                                          </div>

                                        </div>
                                      </div>


                                      {{-- <div class="row">
                                        <div class="row col-md-12">
                                          <div class="col-md-6">
                                            @lang('frontend/members/title.teaching_rate_hours') :
                                          </div>
                                        </div>
                                      </div> --}}

                                      {{-- ที่อยู่ --}}
                                      <div class="row">
                                        <div class="row col-md-12">
                                            <div class="col-sm-12" >
                                                <div class="form-group label-floating">
                                                    <label class="control-label">@lang('frontend/members/title.current_address') : <span style="color: red; font-size: 20px;" >* </span></label>
                                                    <textarea name="member_address" id="member_address" type="text" class="form-control" rows="3" role="3" required ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                      </div>

                                      {{-- ประวัติการศึกษา --}}
                                      {{-- <div class="alert alert-secondary" role="alert">
                                        @lang('frontend/members/title.education_info')
                                      </div>
                                      <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="margin-top: -15px;">
                                          <input name="member_education1" id="member_education1" type="checkbox" class="option-input checkbox">&nbsp; <label>@lang('frontend/members/title.high_school')</label>
                                        </label>
                                        <div class="col-sm-10">
                                          <div class="form-group row">
                                             <label for="inputPassword" class="col-2 col-form-label">@lang('frontend/members/title.school')</label>
                                             <div class="col-sm-10">
                                              <input name="member_institution" id="member_institution" type="text" class="form-control"  value="" id="newsSource" required>
                                             </div>
                                           </div>
                                        </div>
                                      </div>

                                      <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="margin-top: -15px;">
                                          <input name="member_education2" type="checkbox" class="option-input checkbox" id="member_education2">&nbsp;<label>@lang('frontend/members/title.bachelor')</label>
                                        </label>
                                        <div class="col-sm-4">
                                          <div class="form-group row">
                                             <label for="inputPassword" class="col-2 col-form-label">@lang('frontend/members/title.faculty')</label>
                                             <div class="col-sm-10">
                                              <input name="member_major2" type="text" class="form-control"  id="member_major2" required>
                                             </div>
                                           </div>
                                        </div>
                                        <div class="col-sm-6">
                                          <div class="form-group row">
                                             <label for="inputPassword" class="col-2 col-form-label">@lang('frontend/members/title.university')</label>
                                             <div class="col-sm-10">
                                              <input name="member_institution2" id="member_institution2" type="text" class="form-control"  value="" required>
                                             </div>
                                           </div>
                                        </div>
                                      </div>


                                      <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="margin-top: -15px;">
                                          <input name="member_education2" type="checkbox" class="option-input checkbox" id="member_education3">&nbsp;<label>@lang('frontend/members/title.master_s_degree')</label>
                                        </label>
                                        <div class="col-sm-4">
                                          <div class="form-group row">
                                             <label for="inputPassword" class="col-2 col-form-label">@lang('frontend/members/title.faculty')</label>
                                             <div class="col-sm-10">
                                              <input name="member_major3" type="text" class="form-control"  id="member_major3" required>
                                             </div>
                                           </div>
                                        </div>
                                        <div class="col-sm-6">
                                          <div class="form-group row">
                                             <label for="inputPassword" class="col-2 col-form-label">@lang('frontend/members/title.university')</label>
                                             <div class="col-sm-10">
                                              <input name="member_institution3" id="member_institution3" type="text" class="form-control"  value="" required>
                                             </div>
                                           </div>
                                        </div>
                                      </div>

                                      <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="margin-top: -15px;">
                                          <input name="member_education2" type="checkbox" class="option-input checkbox" id="member_education4">&nbsp;<label>@lang('frontend/members/title.ph_d')</label>
                                        </label>
                                        <div class="col-sm-4">
                                          <div class="form-group row">
                                             <label for="inputPassword" class="col-2 col-form-label">@lang('frontend/members/title.faculty')</label>
                                             <div class="col-sm-10">
                                              <input name="member_major4" type="text" class="form-control"  id="member_major4" required>
                                             </div>
                                           </div>
                                        </div>
                                        <div class="col-sm-6">
                                          <div class="form-group row">
                                             <label for="inputPassword" class="col-2 col-form-label">@lang('frontend/members/title.university')</label>
                                             <div class="col-sm-10">
                                              <input name="member_institution4" id="member_institution4" type="text" class="form-control" required>
                                             </div>
                                           </div>
                                        </div>
                                      </div> --}}

                                      {{-- ข้อมูลธนาคาร --}}
                                      <div class="alert alert-secondary" role="alert">
                                        @lang('frontend/members/title.bank_information')
                                      </div>

                                      <div id="bankinformation2">
                                          <div class="bankinformation ">
                                            <div class="form-group">
                                              <div class="row col-md-12">
                                                <div class="col-md-6 col-xs-12">
                                                    <label class="col-form-label">  @lang('frontend/members/title.bank')  : <span style="color: red; font-size: 20px;" >* </span></label>
                                                    <select name="cong1[]" id="cong1" required class="form-control bank_name" style="font-size: 16px; padding-top: 4px;"></select>
                                                </div>
                                                <div class="col-md-5 col-xs-12">
                                                  <label class="col-form-label">  @lang('frontend/members/title.account_number') : <span style="color: red; font-size: 20px;" >* </span></label>
                                                    <input class="form-control bank_account_number" name="cong2[]" id="cong2" maxlength="10" onkeypress="return isNumber(event)" type="text" placeholder="@lang('frontend/members/title.account_number')" />
                                                </div>
                                                <div class="col-md-1 col-xs-12">
                                                  <label class="col-12 col-form-label"><span style="color: red; font-size: 20px;" > </span>&nbsp; </label>
                                                    <button type="button" id="btn-exp" onclick="get_profile_member.option_bank('true');" class="btn btn-success btn-md btn-add add_bankinformation">@lang('frontend/members/title.add_button')</button>
                                                </div>
                                              </div>
                                             </div>
                                          </div>
                                          <div class="add_bank"></div>
                                      </div>

                                      {{-- ประวัติการทำงาน --}}
                                      <div class="alert alert-secondary" role="alert">
                                        @lang('frontend/members/title.career_info')
                                      </div>

                                      <div class="row">
                                          <div class="col-md-12">
                                              <div id="myRepeatingFields">
                                                  <div class="entry">
                                                      <div class="container">
                                                          <div class="row">
                                                            <input type="text" name="lang_history" id="lang_history" value="@lang('frontend/members/title.workplace') : " style="display: none;" />
                                                            <div class="career_history col-md-12"></div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>

                                      {{-- ความสำเร็จ --}}
                                      <div class="alert alert-secondary" role="alert">
                                        @lang('frontend/members/title.successfully_info')
                                      </div>

                                      <div class="row">
                                          <div class="col-sm-12">
                                              <div id="myRepeatingFields2">
                                                  <div class="entry col-xs-12">
                                                      <div class="container">
                                                          <div class="row">
                                                            <label class="col-12 col-form-label">@lang('frontend/members/title.teaching_success') : </label>
                                                            <div class="successfully_info col-md-12"></div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>

                                      {{-- ความถนัด --}}
                                      <div class="alert alert-secondary" role="alert">
                                        @lang('frontend/members/title.aptitude_info')
                                      </div>

                                      <label class="col col-sm-offset-1" style="color: #569c37; font-size: 19px">@lang('frontend/members/title.subject')</label>
                                        <div class="row">
                                          <div class="col-sm-12" id="aptitude"></div>
                                        </div>


                                      <label class="col col-sm-offset-1"  style="color: #569c37 ; font-size: 19px">@lang('frontend/members/title.other')</label>
                                        <div class="row">
                                          <div class="col-sm-12" id="aptitude2"></div>
                                        </div>

                                      </div>
                                  <div id="txtfilename"></div>
                              </div>
                              <div class="wizard-footer">
                                <div class="text-center row">
                                  <div class="col-md-4"></div>
                                  <div class="col-md-4">
                                    <button type="button" id="confirm_updatedata" onclick="get_profile_member.confirm_updatedata()" class='flex-c-m size2 bo-rad-23  bgwhite hov1 trans-0-4 color7' style='color: white;' value='@lang('frontend/members/title.confirm_edit_button')'>@lang('frontend/members/title.confirm_edit_button')</button>
                                  </div>
                                  <div class="col-md-4"></div>
                                </div>
                              </div>

                          </form>
                      </div>
                  </div>
              </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>

$(function () {
    $('.datetimepicker1').datetimepicker({
        format: 'LT'
    });
});

(function($, undefined) {

  "use strict";

  // When ready.
  $(function() {

      var $form = $( ".rate" );
      var $input = $( ".rate" );

      $input.on( "keyup", function( event ) {


          // When user select text in the document, also abort.
          var selection = window.getSelection().toString();
          if ( selection !== '' ) {
              return;
          }

          // When the arrow keys are pressed, abort.
          if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
              return;
          }


          var $this = $( this );

          // Get the value.
          var input = $this.val();

          var input = input.replace(/[\D\s\._\-]+/g, "");
                  input = input ? parseInt( input, 10 ) : 0;

                  $this.val( function() {
                      return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
                  } );
      } );

      /**
       * ==================================
       * When Form Submitted
       * ==================================
       */
      $form.on( "submit", function( event ) {

          var $this = $( this );
          var arr = $this.serializeArray();

          for (var i = 0; i < arr.length; i++) {
                  arr[i].value = arr[i].value.replace(/[($)\s\._\-]+/g, ''); // Sanitize the values.
          };

          console.log( arr );

          event.preventDefault();
      });

  });
})(jQuery);
</script>
