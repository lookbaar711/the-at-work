$(document).ready(function(){
    $('.aptitude-checkbox').click(function(){

        var data_index = $(this).attr('data-index');
        var data_select = $(this).attr('data-select');

        if(data_select=="0"){
            //alert('open');
            $(this).attr('data-select','1');
        }
        else{
            //alert('close');

            //เมื่อติ๊กค่ากลุ่มวิชาที่เคยเลือกไว้ออก
            //ซ่อนช่องกรอกวิชาอื่นๆ
            // if($('.other-check-'+data_index).prop("checked") == true){
            //     //alert('select other');
            //     $('#other'+data_index).removeClass("in");
            // }

            //เซ็ตค่าการไม่เลือกกลุ่มวิชาให้เป็นค่า default
            $(this).attr('data-select','0');

            //เซ็ตค่าวิชาทุกตัวที่เลือกให้เป็นค่าว่าง
            $('.sub-check-'+data_index+':checked').prop('checked', false);

            //ถ้ามีการเลือกวิชาอย่างน้อย 1 วิชา ให้แสดงปุ่ม ถัดไป ให้สามารถกดได้
            if($('.subject-checkbox:checked').length > 0){
                //$('#btnSubmit').prop('disabled', false);
            }
            //ถ้าไม่มีการเลือกวิชาเลย ให้ disabled ปุ่ม ถัดไป ให้ไม่สามารถกดได้
            else{
                //$('#btnSubmit').prop('disabled', true);
            }
        }
    });


    $('.subject-checkbox').click(function(){
        //ถ้ามีการเลือกวิชาอย่างน้อย 1 วิชา ให้แสดงปุ่ม ถัดไป ให้สามารถกดได้
        if($('.subject-checkbox:checked').length > 0){
            //$('#btnSubmit').prop('disabled', false);
        }
        //ถ้าไม่มีการเลือกวิชาเลย ให้ disabled ปุ่ม ถัดไป ให้ไม่สามารถกดได้
        else{
            //$('#btnSubmit').prop('disabled', true);
        }
    });
});

var get_profile_member = {
  data: false,
  data_profile_member:() => {
    var id = $('#data_members_id').val();
    $.ajax({
      url: window.location.origin + '/members/get_profile_member/'+ id,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'get',
      dataType: "json",
      success: function(data) {
        // console.log(data);
        var members = data.members[0];
        $('#member_id').val(members.member_id);
        $('#img_profile').html(`<img class="circular_image" src="`+window.location.origin+`/storage/memberProfile/`+members.member_img+`" style="width: 150px; height: 150px; margin-top: -31px;"> <input type="file" name="member_img" onchange="upfile(this.files[0])"  accept="image/x-png,image/gif,image/jpeg"/>`);
        $('#member_idCard').val(members.member_idCard);
        $('#member_Bday').val(moment(members.member_Bday).format('DD/MM/Y'));
        $('select[name=member_sername]').val(members.member_sername);
        $('#member_fname').val(members.member_fname);
        $('#member_lname').val(members.member_lname);
        $('#member_nickname').val(members.member_nickname);
        $('#member_email').val(members.member_email);
        $('#member_tell').val(members.member_tell);
        $('#member_idLine').val(members.member_idLine);
        $('#member_rate_start').val((members.member_rate_start*1).toLocaleString(undefined, {minimumFractionDigits: 0}));
        $('#member_rate_end').val((members.member_rate_end*1).toLocaleString(undefined, {minimumFractionDigits: 0}));
        $('#member_address').val(members.member_address);
        $('#promotion_code').val(members.promotion_code);

        var STR = '';
       // STR += '<option value="">'+study_group_text+'</option>';
        for (var events of data.events) {
          STR += '<option value="' + events.id + '">' + events.event_name + '</option>';
        }
        $('#member_event').html(STR);
        $('select[name=member_event]').val(data.event_id);

        get_profile_member.data = {
          'bank_master' : data.bank_master,
          'bank' : data.member_bank,
          'data' : data.lang,
        };
        if (data.lang == 'th') {
          $('#lang').val('th');
          var STRB = '<option value="">' +"------ กรุณาเลือกธนาคาร ------"+ '</option>';
        }else {
          $('#lang').val('en');
          var STRB = '<option value="">' +"------ Please select a bank ------"+ '</option>';
        }
        for (var bank of data.bank_master) {
          if (data.lang == 'th') {
            STRB += '<option value="' + bank._id + '">' + bank.bank_name_th + '</option>';
          }else {
            STRB += '<option value="' + bank._id + '">' + bank.bank_name_en + '</option>';
          }
        }
        $('.bank_name').append(STRB);

        // console.log(data.bank_master);
        // console.log(members.member_bank);

        /////////////////////////////////////////////////////////////////////////////////

        // if (members.member_education.มัธยมศึกษา) {
        //   $('#member_education1').prop('checked', true);
        // }
        // $('#member_institution').val(members.member_education.มัธยมศึกษา);
        // ////////////
        //
        // if (members.member_education.ปริญญาตรี) {
        //   $('#member_education2').prop('checked', true);
        // }
        // // console.log(members.member_education['ปริญญาตรี'][0]);
        // $('#member_major2').val(members.member_education['ปริญญาตรี'][0]);
        // $('#member_institution2').val(members.member_education['ปริญญาตรี'][1]);
        // /////////////
        //
        // if (members.member_education.ปริญญาโท) {
        //   $('#member_education3').prop('checked', true);
        // }
        // $('#member_major3').val(members.member_education['ปริญญาโท'][0]);
        // $('#member_institution3').val(members.member_education['ปริญญาโท'][1]);
        // ///////////
        //
        // if (members.member_education.ปริญญาเอก) {
        //   $('#member_education4').prop('checked', true);
        // }
        // $('#member_major4').val(members.member_education['ปริญญาเอก'][0]);
        // $('#member_institution4').val(members.member_education['ปริญญาเอก'][1]);
        //
        // $('.show_inputGroupFile01').html(members.member_file['บัตรประชาชน'][0]);
        // $('.show_inputGroupFile02').html(members.member_file['สำเนาศึกษา'][0]);
        // $('.show_inputGroupFile03').html(members.member_file['ใบผลการเรียน'][0]);
        // $('.show_inputGroupFile04').html(members.member_file['วุฒิบัตรอื่นๆ'][0]);


        var lang_history = $('#lang_history').val();
        var count_data_career_history = 1;
        var data_career_history = '';
        for (var i = 0; i < members.member_exp.length; i++) {
            if (count_data_career_history) {
              if(i==0){
                data_career_history += `<div class="form-group">
                                              <div class="row">
                                                <div class="col-md-5">
                                                    <label class="col-form-label">`+lang_history+`</label>
                                                    <input class="form-control" id="member_HJPl" name="member_HJPl[]" type="text" value="`+members.member_exp[i][0]+`" />
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="col-12 col-form-label">&nbsp; </label>
                                                    <input class="form-control" id="member_HJPo" name="member_HJPo[]" type="text" value="`+members.member_exp[i][1]+`" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="col-12 col-form-label">&nbsp; </label>
                                                    <input class="form-control" id="member_HJExp" name="member_HJExp[]" type="text" value="`+members.member_exp[i][2]+`" />
                                                </div>
                                              </div>
                                            </div>`;
              }
              else{
                data_career_history += `<div class="form-group">
                                              <div class="row">
                                                <div class="col-md-5">
                                                    <input class="form-control" id="member_HJPl" name="member_HJPl[]" type="text" value="`+members.member_exp[i][0]+`" />
                                                </div>
                                                <div class="col-md-5">
                                                    <input class="form-control" id="member_HJPo" name="member_HJPo[]" type="text" value="`+members.member_exp[i][1]+`" />
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="form-control" id="member_HJExp" name="member_HJExp[]" type="text" value="`+members.member_exp[i][2]+`" />
                                                </div>
                                              </div>
                                            </div>`;
              }


            }
            count_data_career_history++;
        }

        if (data_career_history == "") {
          data_career_history += `<div class="form-group">
                                    <div class="row">
                                      <div class="col-md-5">
                                          <label class="col-form-label">`+lang_history+`</label>
                                          <input class="form-control" id="member_HJPl" name="member_HJPl[]" type="text" value="" />
                                      </div>
                                      <div class="col-md-5">
                                          <label class="col-12 col-form-label">&nbsp; </label>
                                          <input class="form-control" id="member_HJPo" name="member_HJPo[]" type="text" value="" />
                                      </div>
                                      <div class="col-md-2">
                                          <label class="col-12 col-form-label">&nbsp; </label>
                                          <input class="form-control" id="member_HJExp" name="member_HJExp[]" type="text" value="" />
                                      </div>
                                    </div>
                                  </div>`;
        }

        $('.career_history').html(data_career_history);
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        var count_successfully_info = 1;
        var data_successfully_info = '';
        for (var i = 0; i < members.member_cong.length; i++) {
            if (count_successfully_info) {
                    data_successfully_info += `<div class="form-group">
                                                <div class="row">
                                                   <div class="col-md-12">
                                                       <input class="form-control" name="member_cong[]" id="member_cong" type="text" value="`+members.member_cong[i]+`"/>
                                                   </div>
                                                 </div>
                                               </div>`;
            }
            count_successfully_info++;
        }

        if (data_successfully_info == "") {
          data_successfully_info += `<div class="form-group">
                                      <div class="row">
                                         <div class="col-md-12">
                                             <input class="form-control" name="member_cong[]" id="member_cong" type="text" value=""/>
                                         </div>
                                       </div>
                                     </div>`;
        }
        $('.successfully_info').html(data_successfully_info);




        setTimeout(function () {
          var aptitude = "";
          var aptitude2 = "";
          var member_aptitude_id = Object.keys(members.member_aptitude);
          var member_aptitude_value = Object.values(members.member_aptitude);
          // console.log(members.member_aptitude);
          // console.log(member_aptitude_value);

          //alert(member_aptitude_id.length);
          //alert(data.aptitude.length);

          //alert(data.aptitude[0]['aptitude_name_th']);

          //alert(member_aptitude_value.length);

          //alert(member_aptitude_value[7]);

          $.each(data.aptitude, function(key, value) {
            var checkbox = '';
            var show = '';
            var aptitude_name = '';
            var check_aptitude = 0;

            if (data.lang == 'th') {
              aptitude_name = value.aptitude_name_th;
            }else {
              aptitude_name = value.aptitude_name_en;
            }

            for(i=0;i<member_aptitude_id.length;i++){
              //set checked เมื่อ aptitude_id ที่เลือกตรงกับ aptitude_id master และค่า subject_id ใน aptitude_id ต้องไม่ใช่ค่าว่าง
              if ((value._id == member_aptitude_id[i]) && (member_aptitude_value[i] != '')){
                check_aptitude = 1;
                break;
              }
            }

            //set checked aptitude
            if (check_aptitude == 1) {
              checkbox = `<input type="checkbox" name="aptitude_group[]" value="`+value._id+`" id="checktrue`+key+
                        `" class="option-input checkbox aptitude-checkbox" data-toggle="collapse" data-target="#check`+key+
                        `" data-index="`+key+`" data-select="1" checked onclick="get_profile_member.check_aptitude(`+key+`)"> &nbsp;<object style="font-size: 18px;">
                        `+aptitude_name+`</object>`;
              show = `<div id="check`+key+`" class="collapse in show" aria-expanded="true">`;
            }
            else {
              checkbox = `<input type="checkbox" name="aptitude_group[]" value="`+value._id+`" id="checktrue`+key+
                        `" class="option-input checkbox aptitude-checkbox" data-toggle="collapse" data-target="#check`+key+
                        `" data-index="`+key+`" data-select="0" onclick="get_profile_member.check_aptitude(`+key+`)"> &nbsp;<object style="font-size: 18px;">
                        `+aptitude_name+`</object>`;
              show = `<div id="check`+key+`" class="collapse in " aria-expanded="true">`;
            }

            if ((aptitude_name == "ประถมศึกษาตอนต้น") || (aptitude_name == "ประถมศึกษาตอนปลาย") || (aptitude_name == "มัธยมศึกษาตอนต้น") || (aptitude_name == "มัธยมศึกษาตอนปลาย") || (aptitude_name == "Primary school 1") || (aptitude_name == "Primary school 2") || (aptitude_name == "High school 1") || (aptitude_name == "High school 2")) {
                aptitude += `<div>
                              <div class="label-floating">
                                <div class="row input-group custom-control">
                                    <div class="label-floating">
                                        `+checkbox+`
                                    </div>
                                </div>
                              `+show+`
                              <div class="row col-md-12 custom-control form-group">`;

                //จำนวนวิชาในแต่ละกลุ่มวิชา
                $.each(value.aptitude_subject, function(ke, val) {
                  var checkbox2 ='';
                  var check_subject = 0;

                  //set uncheck
                  if ($('#lang').val() == 'th') {
                    checkbox2 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+
                                `" class="option-input subject-checkbox sub-check-`+key+
                                `" data-toggle="collapse" data-target=""> &nbsp;<object>
                                `+val.subject_name_th+`</object>`;
                  }
                  else{
                    checkbox2 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+
                                `" class="option-input subject-checkbox sub-check-`+key+
                                `" data-toggle="collapse" data-target=""> &nbsp;<object>
                                `+val.subject_name_en+`</object>`;
                  }

                  $.each(member_aptitude_value[key], function(keyy, val_aptitude) {
                    if (val._id == val_aptitude) {
                      if ($('#lang').val() == 'th') {
                        checkbox2 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+
                                    `"  class="option-input subject-checkbox sub-check-`+key+
                                    `" data-toggle="collapse" data-target="" checked> &nbsp;<object>
                                    `+val.subject_name_th+`</object>`;
                      }
                      else{
                        checkbox2 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+
                                    `"  class="option-input subject-checkbox sub-check-`+key+
                                    `" data-toggle="collapse" data-target="" checked> &nbsp;<object>
                                    `+val.subject_name_en+`</object>`;
                      }
                    }
                  });

                  aptitude += `<div class="col-md-4">
                                  `+checkbox2+`
                                </div>`;

                });
                aptitude += `</div>
                            </div>
                            <span class="material-input"></span>
                            </div>
                          </div><hr>`;
            }
            else {
              aptitude2 += `<div>
                            <div class="label-floating">
                              <div class="row input-group custom-control">
                                  <div class="label-floating">
                                      `+checkbox+`
                                  </div>
                              </div>
                            `+show+`
                            <div class="row col-md-12 custom-control form-group">`;

              //จำนวนวิชาในแต่ละกลุ่มวิชา
              $.each(value.aptitude_subject, function(ke, val) {
                var checkbox3 ='';
                var check_subject = 0;

                //set uncheck
                if ($('#lang').val() == 'th') {
                  checkbox3 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+
                              `"  class="option-input subject-checkbox sub-check-`+key+
                              `" data-toggle="collapse" data-target=""> &nbsp;<object>`+val.subject_name_th+`</object>`;
                }
                else{
                  checkbox3 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+
                              `"  class="option-input subject-checkbox sub-check-`+key+
                              `" data-toggle="collapse" data-target=""> &nbsp;<object>`+val.subject_name_en+`</object>`;
                }

                $.each(member_aptitude_value[key], function(keyy, val_aptitude) {
                  if (val._id == val_aptitude) {
                    if ($('#lang').val() == 'th') {
                      checkbox3 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+
                                  `"  class="option-input subject-checkbox sub-check-`+key+
                                  `" data-toggle="collapse" data-target="" checked> &nbsp;<object>`+val.subject_name_th+`</object>`;
                    }
                    else{
                      checkbox3 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+
                                  `"  class="option-input subject-checkbox sub-check-`+key+
                                  `" data-toggle="collapse" data-target="" checked> &nbsp;<object>`+val.subject_name_en+`</object>`;
                    }
                  }
                });

                aptitude2 += `<div class="col-md-4">
                                `+checkbox3+`
                              </div>`;

              });

              aptitude2 += `</div>
                            </div>
                            <span class="material-input"></span>
                            </div>
                          </div><hr>`;
            }

            //code เก่าเอฟ
            // if (member_aptitude_id[key] == value._id) {
            //   checkbox = `<input type="checkbox" name="aptitude_group[]" value="`+value._id+`" id="checktrue`+key+`" class="option-input checkbox" data-toggle="collapse" data-target="#check`+key+`" checked> &nbsp;<object style="font-size: 18px;">`+aptitude_name+`</object>`;
            //   show = `<div id="check`+key+`" class="collapse in show" aria-expanded="true">`;
            // }else {
            //   checkbox = `<input type="checkbox" name="aptitude_group[]" value="`+value._id+`" id="checktrue`+key+`" class="option-input checkbox" data-toggle="collapse" data-target="#check`+key+`" > &nbsp;<object style="font-size: 18px;">`+aptitude_name+`</object>`;
            //   show = `<div id="check`+key+`" class="collapse in " aria-expanded="true">`;
            // }


            // if ((aptitude_name == "ประถมศึกษาตอนต้น") || (aptitude_name == "ประถมศึกษาตอนปลาย") || (aptitude_name == "มัธยมศึกษาตอนต้น") || (aptitude_name == "มัธยมศึกษาตอนปลาย") || (aptitude_name == "Primary school 1") || (aptitude_name == "Primary school 2") || (aptitude_name == "High school 1") || (aptitude_name == "High school 2")) {
            //     aptitude += `<div>
            //                   <div class="label-floating">
            //                     <div class="row input-group custom-control">
            //                         <div class="label-floating">
            //                             `+checkbox+`
            //                         </div>
            //                     </div>
            //                   `+show+`
            //                   <div class="row col-md-12 custom-control form-group">`;

            //       $.each(value.aptitude_subject, function(ke, val) {
            //         var checkbox2 ='';
            //         if ($('#lang').val() == 'th') {
            //           checkbox2 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+`"  class="option-input" data-toggle="collapse" data-target=""> &nbsp;<object>`+val.subject_name_th+`</object>`;
            //         }
            //         else{
            //           checkbox2 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+`"  class="option-input" data-toggle="collapse" data-target=""> &nbsp;<object>`+val.subject_name_en+`</object>`;
            //         }

            //         $.each(member_aptitude_value[key], function(keyy, val_aptitude) {
            //           if (val._id == val_aptitude) {
            //             if ($('#lang').val() == 'th') {
            //               checkbox2 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+`"  class="option-input" data-toggle="collapse" data-target="" checked> &nbsp;<object>`+val.subject_name_th+`</object>`;
            //             }
            //             else{
            //               checkbox2 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+`"  class="option-input" data-toggle="collapse" data-target="" checked> &nbsp;<object>`+val.subject_name_en+`</object>`;
            //             }
            //           }
            //         });

            //         aptitude += `<div class="col-md-4">
            //                         `+checkbox2+`
            //                       </div>`;

            //       });
            //       aptitude += `</div>
            //                   </div>
            //                   <span class="material-input"></span>
            //                   </div>
            //                 </div><hr>`;
            // }
            // else {
            //   aptitude2 += `<div>
            //                 <div class="label-floating">
            //                   <div class="row input-group custom-control">
            //                       <div class="label-floating">
            //                           `+checkbox+`
            //                       </div>
            //                   </div>
            //                 `+show+`
            //                 <div class="row col-md-12 custom-control form-group">`;

            //   $.each(value.aptitude_subject, function(ke, val) {
            //     var checkbox3 ='';
            //     if ($('#lang').val() == 'th') {
            //       checkbox3 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+`"  class="option-input" data-toggle="collapse" data-target=""> &nbsp;<object>`+val.subject_name_th+`</object>`;
            //     }
            //     else{
            //       checkbox3 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+`"  class="option-input" data-toggle="collapse" data-target=""> &nbsp;<object>`+val.subject_name_en+`</object>`;
            //     }

            //     $.each(member_aptitude_value[key], function(keyy, val_aptitude) {
            //       if (val._id == val_aptitude) {
            //         if ($('#lang').val() == 'th') {
            //           checkbox3 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+`"  class="option-input" data-toggle="collapse" data-target="" checked> &nbsp;<object>`+val.subject_name_th+`</object>`;
            //         }
            //         else{
            //           checkbox3 = `<input type="checkbox" name="group`+key+`[]" value="`+val._id+`"  class="option-input" data-toggle="collapse" data-target="" checked> &nbsp;<object>`+val.subject_name_en+`</object>`;
            //         }
            //       }
            //     });

            //     aptitude2 += `<div class="col-md-4">
            //                     `+checkbox3+`
            //                   </div>`;

            //   });

            //   aptitude2 += `</div>
            //                 </div>
            //                 <span class="material-input"></span>
            //                 </div>
            //               </div><hr>`;
            // }

          });
          $('#aptitude').html(aptitude);
          $('#aptitude2').html(aptitude2);
        }, 100);

        get_profile_member.option_bank();

      }
    });
  },

  check_aptitude : (key) => {
    var data_index = $('#checktrue'+key).attr('data-index');
    var data_select = $('#checktrue'+key).attr('data-select');

    if(data_select=="0"){
        //alert('open');
        $('#checktrue'+key).attr('data-select','1');
    }
    else{
        //alert('close');
        $('#checktrue'+key).attr('data-select','0');

        //เมื่อติ๊กค่ากลุ่มวิชาที่เคยเลือกไว้ออก
        //ซ่อนช่องกรอกวิชาอื่นๆ
        // if($('.other-check-'+data_index).prop("checked") == true){
        //     //alert('select other');
        //     $('#other'+data_index).removeClass("in");
        // }

        // //เซ็ตค่าการไม่เลือกกลุ่มวิชาให้เป็นค่า default
        // $(this).attr('data-select','0');

        //เซ็ตค่าวิชาทุกตัวที่เลือกให้เป็นค่าว่าง
        $('.sub-check-'+key+':checked').prop('checked', false);

        //ถ้ามีการเลือกวิชาอย่างน้อย 1 วิชา ให้แสดงปุ่ม ถัดไป ให้สามารถกดได้
        if($('.subject-checkbox:checked').length > 0){
            //$('#btnSubmit').prop('disabled', false);
        }
        //ถ้าไม่มีการเลือกวิชาเลย ให้ disabled ปุ่ม ถัดไป ให้ไม่สามารถกดได้
        else{
            //$('#btnSubmit').prop('disabled', true);
        }
    }
  },

  option_bank : (data) => {
      // code เก่าเอฟ
      // var check = "n";
      // var data_bank1 = [];
      // var data_bank2 = [$('#cong1 option:selected').val(),$('#cong2').val()];
      // if ($('#cong1 option:selected').val() != "") {
      //   if ($('#cong2').val() != "") {
      //     data_bank1.push(data_bank2);
      //     check = "y";
      //   }
      //   else {
      //     if (data == "true" && data_bank1) {
      //       var show_title = '';

      //       if(get_profile_member.data.data == 'th') {
      //         show_title = "กรุณาเลือกธนาคาร";
      //       }
      //       else {
      //         show_title = "Please select a bank";
      //       }

      //       Swal.fire({
      //         type: 'warning',
      //         title: show_title,
      //         confirmButtonColor: '#003D99',
      //         confirmButtonText : 'Close'
      //       })
      //       check = "y";
      //     }
      //   }
      // }
      // else {
      //   if(data == "true" && data_bank1) {
      //     var show_title = '';

      //     if(get_profile_member.data.data == 'th') {
      //       show_title = "กรุณาเลือกธนาคาร";
      //     }
      //     else {
      //       show_title = "Please select a bank";
      //     }

      //     Swal.fire({
      //       type: 'warning',
      //       title: show_title,
      //       confirmButtonColor: '#003D99',
      //       confirmButtonText : 'ปิด'
      //     })
      //     check = "y";
      //   }
      // }



      var check = "n";
      var show_title_1 = '';
      var show_title_2 = '';
      var data_bank1 = [];
      var data_bank2 = [$('#cong1 option:selected').val(),$('#cong2').val()];
      var close_window = '';

      if ($('#lang').val() == 'th') {
        show_title_1 = "กรุณาเลือกธนาคาร";
        show_title_2 = "กรุณากรอกหมายเลขบัญชี";
        close_window = 'ปิดหน้าต่าง';
      }
      else {
        show_title_1 = "Please select a bank";
        show_title_2 = "Please enter account number";
        close_window = 'Close';
      }

      //เลือกธนาคาร
      if ($('#cong1 option:selected').val() != "") {
        //กรอกเลขที่บัญชี
        if ($('#cong2').val() != "") {
          data_bank1.push(data_bank2);
          check = "y";
        }
        //ไม่ได้กรอกเลขที่บัญชี
        else {
          if (data == "true" && data_bank1) {
            Swal.fire({
              type: 'warning',
              title: show_title_2,
              confirmButtonColor: '#003D99',
              confirmButtonText : close_window
            })
            check = "y";
          }
        }
      }
      //ไม่ได้เลือกธนาคาร
      else {
        if(data == "true" && data_bank1) {
          Swal.fire({
            type: 'warning',
            title: show_title_1,
            confirmButtonColor: '#003D99',
            confirmButtonText : close_window
          })
          check = "y";
        }
      }

      if (get_profile_member.data.data == 'th') {
        remove_button = `ลบ`;
      }
      else{
        remove_button = `Remove`;
      }

      if (check == "n") {
          if (get_profile_member.data.bank) {

              if (get_profile_member.data.data == 'th') {
                var STRBB = '<option value="">' +"------ กรุณาเลือกธนาคาร ------"+ '</option>';
              }else {
                var STRBB = '<option value="">' +"------ Please select a bank ------"+ '</option>';
              }

              var stringb = '';
              for (var i = 0; i < get_profile_member.data.bank.length; i++) {
                    stringb += `<div class="form-group">
                                    <div class="row col-md-12">
                                      <div class="col-md-6">

                                          <select name="member_cong1[]" id="member_cong1" class="form-control bank_name" style="font-size: 16px; padding-top: 4px;" disabled>
                                           `;
                                           var x = 0;
                                           for (var bank of get_profile_member.data.bank_master) {
                                             if (get_profile_member.data.data == 'th') {
                                               STRBB += '<option value="' + bank.bank_id + '">' + bank.bank_name_th + '</option>';
                                               if (bank._id ==  get_profile_member.data.bank[i].bank_id) {
                                                 STRBB += '<option value="' + bank._id + '" selected="selected">' + bank.bank_name_th + '</option>';
                                               }

                                             }else {
                                               STRBB += '<option value="' + bank._id + '">' + bank.bank_name_en + '</option>';
                                               if (bank._id ==  get_profile_member.data.bank[i].bank_id ) {
                                                 STRBB += '<option value="' + bank._id + '" selected="selected">' + bank.bank_name_en + '</option>';
                                               }
                                             }
                                            x++;
                                           }

                      stringb +=         STRBB;
                      stringb +=        `</select>
                                      </div>
                                      <div class="col-md-5">

                                          <input class="form-control bank_account_number" name="member_cong2[]" id="member_cong2" value="`+ get_profile_member.data.bank[i].bank_account_number+`" type="text" disabled/>
                                      </div>
                                      <div class="col-md-1">

                                          <button type="button" class="btn btn-danger btn-md btn-add remove_bankinformation" onclick="get_profile_member.remove_bankinformation(this)">`+remove_button+`</button>
                                      </div>
                                    </div>
                                   </div>`;

                   $('.add_bank').html(stringb);
              }

          }
      }
      else {
        if (data_bank1 && check == "y") {

            if (get_profile_member.data.data == 'th') {
              var STRBB = '<option value="">' +"------ กรุณาเลือกธนาคาร ------"+ '</option>';
            }else {
              var STRBB = '<option value="">' +"------ Please select a bank ------"+ '</option>';
            }
            for (var bank of get_profile_member.data.bank_master) {
              if (get_profile_member.data.data == 'th') {
                STRBB += '<option value="' + bank._id + '">' + bank.bank_name_th + '</option>';
              }else {
                STRBB += '<option value="' + bank._id + '">' + bank.bank_name_en + '</option>';
              }
            }

            var member_bank_data = 1;
            for (var i = 0; i < data_bank1.length; i++) {
              if (member_bank_data) {
                  var stringb = `<div class="form-group">
                                  <div class="row col-md-12">
                                    <div class="col-md-6">

                                        <select name="member_cong1[]" id="member_cong1" class="form-control bank_name" style="font-size: 16px;" disabled>
                                         `+ STRBB +`
                                         </select>
                                    </div>
                                    <div class="col-md-5">

                                        <input class="form-control bank_account_number" name="member_cong2[]" id="member_cong2" type="text" disabled/>
                                    </div>
                                    <div class="col-md-1">

                                        <button type="button" class="btn btn-danger btn-md btn-add remove_bankinformation" onclick="get_profile_member.remove_bankinformation(this)">`+remove_button+`</button>
                                    </div>
                                  </div>
                                 </div>`;
              }
              member_bank_data++;
              $('.add_bank').append(stringb);
              $('.bank_name').last().val(data_bank1[i][0]);
              $('.bank_account_number').last().val(data_bank1[i][1]);
              $('#cong1').val("");
              $('#cong2').val("");
            }

        }
      }
  },

  add_career_history : () => {
        var career_history = $(".career_history"); //Fields wrapper
        var x = 1;
        x++;
        $(career_history).append(`<div class="form-group">
                                    <div class="row">
                                      <div class="col-md-4">
                                          <input class="form-control" id="member_HJPl" name="member_HJPl[]" type="text" value=" " />
                                      </div>
                                      <div class="col-md-4">
                                          <input class="form-control" id="member_HJPo" name="member_HJPo[]" type="text" value=" " />
                                      </div>
                                      <div class="col-md-3">
                                          <input class="form-control" id="member_HJExp" name="member_HJExp[]" type="text" value=" " />
                                      </div>
                                      <div class="">
                                          <button type="button" class="btn btn-danger btn-md btn-add remove_fieldAddress_edit">ลบ</button>
                                      </div>
                                    </div>
                                  </div>`);

        $(career_history).on("click",".remove_fieldAddress_edit", function(e){ //user click on remove text
          $(this).parent('div').parent('div').remove(); x--;
        })
  },

  add_successfully_info : () => {
    var successfully_info = $(".successfully_info"); //Fields wrapper
    var x = 1;
    x++;
    $(successfully_info).append(`<div class="form-group">
                                  <div class="row">
                                    <div class="col-md-11">
                                        <input class="form-control" name="member_cong[]" id="member_cong" type="text"/>
                                    </div>
                                    <div class="">
                                        <button type="button" class="btn btn-danger btn-md btn-add remove_successfully_info">ลบ</button>
                                    </div>
                                  </div>
                                 </div>`);

    $(successfully_info).on("click",".remove_successfully_info", function(e){ //user click on remove text
      $(this).parent('div').parent('div').remove(); x--;
    })
  },

  remove_bankinformation: (e) => {
    $(e).parent('div').parent('div').remove();
  },

  confirm_updatedata : () => {

    var class_ = [];
    var class_level = [];
    var aptitude = {};

    var member_bank = {};
    var lang_request = $('#please_complete').val();
    var ck = "y";
    if ($('#member_fname').val() == "") {
      ck = "n";
    }
    if ($('#member_lname').val() == "") {
      ck = "n";
    }
    // if ($('#member_nickname').val() == "") {
    //   ck = "n";
    // }
    if ($('#member_Bday').val() == "") {
      ck = "n";
    }
    if ($('#member_tell').val() == "") {
      ck = "n";
    }
    if ($('#member_rate_start').val() == "") {
      ck = "n";
    }
    if ($('#member_rate_end').val() == "") {
      ck = "n";
    }
    if ($('#member_idLine').val() == "") {
      ck = "n";
    }
    // $('select[name="member_cong1[]"] option:selected').each(function() {
    //  if ($(this).val() == " ") {
    //    if ($('#lang').val() == 'th') {
    //      ck = "n";
    //      lang_request = 'กรุณาเลือกธนาคาร';
    //    }else {
    //      ck = "n";
    //      lang_request = 'Please select a bank';
    //    }
    //  }
    // });


    // $('[name="member_cong2[]"]').each(function() {
    //  if ($(this).val() == " ") {
    //    if ($('#lang').val() == 'th') {
    //      ck = "n";
    //      lang_request = 'กรุณากรอกหมายเลขบัญชี';
    //    }else {
    //      ck = "n";
    //      lang_request = 'Please enter account number';
    //    }
    //  }
    // });

    var aptitude_group=[];
     $('[name="aptitude_group[]"]').each(function() {
      aptitude_group.push($(this).val());
     });

    var bank_name=[];
      $('select[name="member_cong1[]"] option:selected').each(function() {
       bank_name.push($(this).val());
      });

    var bank_account_number=[];
     $('[name="member_cong2[]"]').each(function() {
      bank_account_number.push($(this).val());
     });

    for (var i = 0; i < aptitude_group.length; i++) {
      $('input[name="group'+i+'[]"]:checked').each(function() {
       class_.push($(this).val());
      });
      class_level.push(class_);
      class_ = [];

      aptitude[aptitude_group[i]] = class_level[i];
    }

    var member_aptitude = aptitude;
    var member_aptitude_array = Object.keys(member_aptitude);
    var member_aptitude_values = Object.values(member_aptitude);
    // console.log(member_aptitude_array);
    // console.log(member_aptitude);

    //alert(member_aptitude_array.length);
    var count_subject = 0;
    for (var i = 0; i < member_aptitude_array.length; i++) {
      // console.log(member_aptitude_values[i]);

      if (member_aptitude_values[i].length > 0) {
        count_subject++;
      }
    }

    if (count_subject == 0) {
      ck = "n";
      if ($('#lang').val() == 'th') {
        lang_request = 'กรุณาเลือกรายวิชาที่ถนัด ใน 1 หัวข้อต้องมี 1 ความถนัด';
      }else {
        lang_request = 'Please choose your preferred subject in 1 topic. Must have 1';
      }
    }

    //console.log(member_bank);
    var count_bank = $('[name="member_cong1[]"]').length;
    var count_account = $('[name="member_cong2[]"]').length;
    var close_window = '';

    if ($('#lang').val() == 'th') {
      close_window = 'ปิดหน้าต่าง';
    }
    else {
      close_window = 'Close';
    }

    if ((member_bank) && (count_bank==0) && (count_bank==0)) {
      if ($('#lang').val() == 'th') {
        ck = "n";
        lang_request = 'กรุณาเพิ่มข้อมูลธนาคาร';
      }else {
        ck = "n";
        lang_request = 'Please add bank information';
      }
    }

    if (ck != "y") {
      Swal.fire({
        type: 'warning',
        title: lang_request,
        confirmButtonColor: '#003D99',
        confirmButtonText : close_window,
      });
    }else {

     for (var i = 0; i < bank_name.length; i++) {
       member_bank[i] = [bank_name[i],bank_account_number[i]];
     }

     if(($('#member_HJPl').val() != '') && ($('#member_HJPo').val() != '') && ($('#member_HJExp').val() != '')){
        var member_exp = [[$('#member_HJPl').val(),$('#member_HJPo').val(),$('#member_HJExp').val()]];
     }
     else{
        var member_exp = '';
     }

     if($('#member_cong').val() != ''){
        var member_cong = [$('#member_cong').val()];
     }
     else{
        var member_cong = '';
     }

     var data = {
       "member_id":$('#member_id').val(),
       "member_idCard":$('#member_idCard').val(),
       "member_Bday":$('#member_Bday').val(),
       "member_email":$('#member_email').val(),
       "member_tell":$('#member_tell').val(),
       "member_idLine":$('#member_idLine').val(),
       "member_sername":$('#member_sername').val(),
       "member_fname":$('#member_fname').val(),
       "member_lname":$('#member_lname').val(),
       "member_nickname":$('#member_nickname').val(),
       "member_rate_start":$('#member_rate_start').val(),
       "member_rate_end":$('#member_rate_end').val(),
       "member_address":$('#member_address').val(),
       "member_exp":member_exp,
       "member_cong":member_cong,
       "member_aptitude":member_aptitude,
       "member_bank":member_bank,
     };

       $.ajax({
         url: window.location.origin + '/members/data_profile_member_edit',
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         type: 'post',
         data: {
           'data': data,
         },
         dataType: "json",
         success: function(data) {

           Swal.fire({
             type: 'success',
             title: data.success,
             showConfirmButton: false,
             timer: 1500
           })
           setTimeout(function () {
             $('#model_profile_edit').modal('hide');
             location.reload();
           }, 2000);
           setTimeout(function () {
             location.reload();
           }, 2500);

         }
       });

    }
  },

}
