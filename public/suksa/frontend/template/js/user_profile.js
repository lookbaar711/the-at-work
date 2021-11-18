

var user_profile_contact = {
  data: false,
  contact:() => {
    $.ajax({
      url: window.location.origin + '/get_date/user_profile_contact',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      // data: {
      //   'data': data,
      // },
      dataType: "json",
      success: function(data) {
        // console.log(data);
        user_profile_contact.new_page_contact(data);
      }
    });
  },

  new_page_contact : (data) => {
      var lang = $('#current_lang').val();
      var course_register_history_not_found = (lang=='en')?'Course register history no found.':'ไม่พบประวัติการสมัครคอร์สเรียน';
      var join_button = (lang=='en')?'Join':'เข้าห้องประชุม';
      var student = 'ผู้เข้าร้วม';
      var assess_button = (lang=='en')?'Assess':'ให้คะแนน';

      user_profile_contact.data = {data : data};
      var contact ='';
       $.each(data.cousres.courses.data, function(key, value) {


        var price = '';
        // if (value.course_price) {
        //   price = '<p class="notfree fs-16 header-noti">'+value.course_price.toLocaleString(undefined, {minimumFractionDigits: 0})+' Coins</p>';
        // }
        // else {
        //   price = '<p class="free fs-16 header-noti">'+data.free_course+'</p>';
        // }

        price = '<p class="free fs-16 header-noti">'+value.course_category+'</p>';

        var icon = '<i class="fa fa-users fs-16 header-noti" style="font-size:16px;"></i> <label>'+ value.student +' '+student +' </label>';



        var course_file = '';
        if (value.course_file) {
          course_file = '<p class="fs-16 header-noti " style=" color: black;"><i class="fa fa-file fs-16 header-noti" style="font-size:16px;"></i>&nbsp;1 '+data.course_document+' <a class="fs-16 header-noti" style="color: #3990F2; border-bottom: 1px solid #3990F2;" href="'+window.location.origin+'/storage/coursefile/'+value.course_file+'" download>'+data.download_button+'</a></p>';
        }
        else {
          course_file = '<p class="fs-16 header-noti " style=" color: black;"><i class="fa fa-file fs-16 header-noti" style="font-size:16px;"></i>&nbsp; '+data.course_document+'</p>';
        }


        var btn = '';
        if (value.status_show == "true") {
          $.each(value.course_date, function(index, el) {
            var current_datetime = new Date();
            var course_start_datetime = new Date(el.date+" "+el.time_start);
            var course_end_datetime = new Date(el.date+" "+el.time_end);
            course_start_datetime.setMinutes(course_start_datetime.getMinutes() - 10);

            if(((current_datetime.getTime() >= course_start_datetime.getTime())
              && (current_datetime.getTime() <= course_end_datetime.getTime())) || (value.classroom_status == 1)){
              btn = `<a href="`+window.location.origin+`/classroom/check/`+value.link_open+
              `" class="btn button-s" target="_blank" style="margin-top: 0px; margin-top: 0px; background: #003D99; color: white;" >`+join_button+` </a> <a href="`
              +window.location.origin+`/courses/`+value._id+`" class="btn btn-outline-dark  " style="border-radius: 20px; font-size: 14px">`+data.course_detail+`</a>`; //001
            }
            else {
              btn = `<a href="`+window.location.origin+`/courses/`+value._id+`" class="btn btn-outline-dark " style="border-radius: 20px; font-size: 14px">`+data.course_detail+`</a>`; //0022
            }
          });
        }
        else {
          btn = `<a href="`+window.location.origin+`/courses/`+value._id+`" class="btn btn-outline-dark" style="border-radius: 20px; font-size: 14px">`+data.course_detail+`</a>`; //0031
        }

        // var date_1 = ;
        var course_date = '';
        var date_1 = '';

        for (var i = 0; i < value.course_date.length; i++) {
          // console.log(value.course_date.length);
          if (i > 0) {
              date_1 = moment(value.course_date[0].date).format('DD/MM/Y');
              date_2 = moment(value.course_date[i].date).format('DD/MM/Y');
              date_3 = date_1+" - "+date_2;
              course_date = date_3;
          }else {
            date_1 = moment(value.course_date[0].date).format('DD/MM/Y');
            course_date = date_1;
          }
        }

        var course_name = '';
        if (value.course_name.length > 20) {
          var text_new = value.course_name.slice(0, 20);
          course_name = text_new+`...`;
        }else {
          course_name = value.course_name;
        }
          contact += `
              <div class="form-row">
                  <div class="container">
                    <div class="row">
                      <div class="col-sm-4"> <img src="`+window.location.origin+`/storage/course/`+value.course_img+`" onerror="this.onerror=null;this.src='http://localhost:8000/suksa/frontend/template/images/icons/blank_image.jpg';" class="img-responsive"></div>
                      <div class="col-sm-4">
                        <p class="fs-16 text-profile-noti overflow_course">`+ course_name +`</p>
                        <p class="fs-16 header-noti">`+ price +`</p>
                        <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i>&nbsp;`+course_date+`</p>
                        <p class="fs-16 header-noti"style=" color: black;">`+icon+`</p>
                      </div>
                      <div class="col-sm-4 p-l-0 p-r-0 text-right" style="align-self: center;">
                        <br>
                        `+btn+`
                      </div>
                  </div>
                </div>
              </div>
              <hr>
            `;

      });
      if(contact == ''){
        contact = '<h3>'+course_register_history_not_found+'</h3>';
      }
      $('#user_page_contact').html(contact);

     //

     STR = '';
     var data = data.cousres.courses;
     let li = '';

     for (let page = 1; page <= data.last_page; page++) {
         if (page == data.current_page) {
             li += `<li class="page-item active"><a class="page-link">${page}</a></li>`;
         }else if(data.last_page < 7) {
             li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
         }else{
             if ((data.last_page / 2) < data.current_page) {
                 if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                     if (page == data.current_page - 1 && data.current_page != data.last_page) {
                         li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                     }
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`; // -
                 } else if (data.current_page == data.last_page && page == data.current_page - 2) {
                     li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                 }else if (page == 1 || page == 2) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                 }
             }else {
                 if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`; // +
                     if (page == data.current_page + 1 && data.current_page != 1) {
                         li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                     }
                 } else if (data.current_page == 1 && page == data.current_page + 2) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                     li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                 }else if (page == data.last_page - 1 || page == data.last_page) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                 }
             }
         }
     }

     STR += `
         <hr>
         <nav aria-label="Page navigation example">
             <ul class="pagination justify-content-end">
                 <li class="page-item">
                 <a class="page-link" aria-label="Previous" href="`+ data.prev_page_url +`">
                     <span aria-hidden="true">&laquo;</span>
                     <span class="sr-only">Previous</span>
                 </a>
                 </li>
                 ${li}
                 <li class="page-item">
                 <a class="page-link" href="`+ data.next_page_url +`"  aria-label="Next">
                     <span aria-hidden="true">&raquo;</span>
                     <span class="sr-only">Next</span>
                 </a>
                 </li>
             </ul>
         </nav>`;

         if (data.total >= 3) {
           $('#user_page_num').html(STR);
         }

  }
}

var user_profile_coins = {

  coins:() => {
    $.ajax({
      url: window.location.origin + '/get_date/user_profile_coins',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      // data: {
      //   'data': data,
      // },
      dataType: "json",
      success: function(data) {
        // console.log(data);
        user_profile_coins.new_page_coins(data);
      }
    });
  },

  new_page_coins : (data) => {
    // console.log(data);
      var lang = $('#current_lang').val();
      var coins_history_not_found = (lang=='en')?'Coins history no found.':'ไม่พบประวัติการใช้ Coins';

      var courses ='';

          $.each(data.coins.data, function(key, value) {
            switch (value.event) {
              case 'topup_coins':
                type = "เติม";
                show_type = data.topup;
                break;
              case 'withdraw_coins':
                type = "ถอน";
                show_type = data.withdraw;
                break;
              case 'pay_coins':
                type = "จ่าย";
                show_type = data.pay;
                break;
              case 'get_coins':
                type = "รับ";
                show_type = data.get;
                break;
              case 'return_coins':
                type = "คืน";
                show_type = data.return;
                break;
              default:
              // deduct_coins
                type = "หัก";
                show_type = data.deduct;
            }


            var btn = '';
            if (value.coin_status =='0') {
               btn = `<button class="dot2" style="background-color:#F39C12; color:#ffffff; text-align:center; font-size: 10px;">`+data.waiting_approve+`</button>`;
            }else if (value.coin_status =='1') {
              if((value.event == 'topup_coins') || (value.event == 'withdraw_coins')){
                btn = `<button class="dot2" style="background-color:#2ECC71; color:#ffffff; text-align:center; font-size: 10px;">`+data.approved+`</button>`;
              }
              else{
                btn = `<button class="dot2" style="background-color:#2ECC71; color:#ffffff; text-align:center; font-size: 10px;">`+data.success+`</button>`;
              }
            }else {
              if(type == "จ่าย"){
                btn = `<button class="dot2" style="background-color:#6E7179; color:#ffffff; text-align:center; font-size: 10px;">`+data.refund+`</button>`;
              }
              else{
                btn = `<button class="dot2" style="background-color:#6E7179; color:#ffffff; text-align:center; font-size: 10px;">`+data.not_approved+`</button>`;
              }
            }

            if((value.member_bank_name_en) && (value.member_bank_name_th)){
              var bank_name = (lang=='en')?value.member_bank_name_en:value.member_bank_name_th;
            }
            else{
              var bank_name = '';
            }

              courses += `
                  <div class="form-row">
                    <div class="container">
                      <div class="row">
                        <div class="col-12 col-md-10">
                          <p class="fs-16 header-noti">
                          `+show_type+" "+value.coin_number+" Coins"+`

                          `+btn+`
                          </p>
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i>&nbsp;`+moment(value.created_at).format('DD/MM/Y HH:mm:ss')+`</p>
                        </div>
                        <div class="col-12 col-md-2 col-sm-12 text-right" style="align-self: center;">
                          <button class="btn btn-outline-dark button-s" style="margin-top:0px; margin-left: 0px; font-size: 14px;" onclick="detail_coins(
                              '`+value.event+`',
                              '`+moment(value.coin_date).format('DD/MM/Y')+`',
                              '`+moment(value.coin_time,'HH:mm').format('HH:mm')+`',
                              '`+bank_name+`',
                              '`+value.coin_number+`',
                              '`+value.member_account_number+`',
                              '`+value.coin_status+`',
                              '`+value.ref_name+`',
                              '`+value.coins_description+`'
                          )">`+data.course_detail+`</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr/>
                `;
          });
      if(courses == ''){
        courses = '<h3>'+coins_history_not_found+'</h3>';
      }
      $('#user_page_coins').html(courses);

      STR = '';
      var data = data.coins;
      let li = '';

      for (let page = 1; page <= data.last_page; page++) {
          if (page == data.current_page) {
              li += `<li class="page-item active"><a class="page-link">${page}</a></li>`;
          }else if(data.last_page < 7) {
              li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
          }else{
              if ((data.last_page / 2) < data.current_page) {
                  if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                      if (page == data.current_page - 1 && data.current_page != data.last_page) {
                          li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                      }
                      li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`; // -
                  } else if (data.current_page == data.last_page && page == data.current_page - 2) {
                      li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                      li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                  }else if (page == 1 || page == 2) {
                      li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                  }
              }else {
                  if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                      li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`; // +
                      if (page == data.current_page + 1 && data.current_page != 1) {
                          li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                      }
                  } else if (data.current_page == 1 && page == data.current_page + 2) {
                      li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                      li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                  }else if (page == data.last_page - 1 || page == data.last_page) {
                      li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                  }
              }
          }
      }

      STR += `
          <hr>
          <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-end">
                  <li class="page-item">
                  <a class="page-link" aria-label="Previous" href="`+ data.prev_page_url +`">
                      <span aria-hidden="true">&laquo;</span>
                      <span class="sr-only">Previous</span>
                  </a>
                  </li>
                  ${li}
                  <li class="page-item">
                  <a class="page-link" href="`+ data.next_page_url +`"  aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                      <span class="sr-only">Next</span>
                  </a>
                  </li>
              </ul>
          </nav>`;

          if (data.total >= 3) {
            $('#user_coins_page_num').html(STR);
          }
  },

}

var user_profile_alerts = {
  alerts:() => {
    $.ajax({
      url: window.location.origin + '/get_date/profile_alerts',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      // data: {
      //   'data': data,
      // },
      dataType: "json",
      success: function(data) {
        // console.log(data);
        user_profile_alerts.new_page_alerts(data);
      }
    });
  },

  new_page_alerts : (data) => {
      var alerts ='';
      var lang = $('#current_lang').val();
      var notification_history_not_found = (lang=='en')?'Notification history no found.':'ไม่พบประวัติการแจ้งเตือน';
      var assess_button = (lang=='en')?'Assess':'ให้คะแนน';

      $.each(data.alerts.data, function(key, value) {

        if (data.lang == "en") {
          if(value.noti_type == 'open_course_teacher'){
            var room_name = '';
            if (value.classroom_name.length > 20) {
              var text_new = value.classroom_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.classroom_name;
            }
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>Close to the time to teach</b></p>
                    <p class="fs-16 header-noti">`+ room_name +` of `+ value.teacher_fullname +` </p>
                    <p class="fs-16 header-noti">Teaching date `+moment(value.classroom_date).format('DD/MM/Y') +` Time `+moment(value.classroom_time_end).format('DD/MM/Y') +` </p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                    <a href="`+window.location.origin+`/classroom/check/`+value._id+`" target="_blank">
                      <button class="btn btn-noti" style="border-radius: 20px; font-size: 14px; color: white; width: 90px;" >Join</button>
                    </a>
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if (value.noti_type == 'open_course_student'){
            var room_name = '';
            if (value.classroom_name.length > 20) {
              var text_new = value.classroom_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.classroom_name;
            }
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>Close to the time to study</b></p>
                    <p class="fs-16 header-noti">`+ room_name +` with teacher `+ value.classroom_name +` </p>
                    <p class="fs-16 header-noti">Teaching date `+moment(value.classroom_date).format('DD/MM/Y') +` Time `+moment(value.classroom_time_end).format('DD/MM/Y') +`</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                  <a href="`+window.location.origin+`/classroom/check/`+value._id+`">
                    <button class="btn btn-noti" style="border-radius: 20px; font-size: 14px; color: white; width: 90px;" >Join</button>
                  </a>
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'register_course_teacher'){
            var date_se = '';
            if (value.classroom_start_date == value.classroom_end_date) {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y')+" to "+moment(value.classroom_end_date).format('DD/MM/Y');
            }

            var room_name = '';
            if (value.classroom_name.length > 20) {
              var text_new = value.classroom_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.classroom_name;
            }
            alerts += `
            <div class="form-row">
              <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>Someone register for your course</b></p>
                    <p class="fs-16 header-noti">`+ value.student_fullname +` register for  `+ room_name +`</p>
                    <p class="fs-16 header-noti">Teaching date `+ date_se +`</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'register_course_private_teacher'){
            var date_se = '';
            if (value.classroom_start_date == value.classroom_end_date) {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y')+" to "+moment(value.classroom_end_date).format('DD/MM/Y');
            }

            var room_name = '';
            if (value.classroom_name.length > 20) {
              var text_new = value.classroom_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.classroom_name;
            }

            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>Someone register for your course</b></p>
                    <p class="fs-16 header-noti">`+ value.student_fullname +` register for  `+ room_name +`</p>
                    <p class="fs-16 header-noti">Teaching date `+ date_se +`</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm')+`</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'register_course_student'){
            var date_se = '';
            if (value.classroom_start_date == value.classroom_end_date) {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y')+" to "+moment(value.classroom_end_date).format('DD/MM/Y');
            }

            var room_name = '';
            if (value.classroom_name.length > 20) {
              var text_new = value.classroom_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.classroom_name;
            }

            alerts += `
            <div class="form-row">
                <div class="container">
                  <div class="row">
                    <div class="col-sm-6">
                      <p class="fs-16 text-head-noti"><b>Registration completed</b></p>
                      <p class="fs-16 header-noti">You register for `+ room_name +` with teacher `+ value.classroom_name +`</p>
                      <p class="fs-16 header-noti">Teaching date `+ date_se +`</p>
                      <div class="row">
                        <div class="col-sm-7" >
                            <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6" style="text-align-last: right;">
                      <button class="btn btn-outline-dark button-s " style="margin-top:0px; margin-left: 0px;"
                      onclick="register_course_student(
                      '`+value.classroom_name+`',
                      '`+value.teacher_fullname+`',
                      '`+moment(value.classroom_datetime[0].classroom_date).format('DD/MM/Y')+` `+moment(value.classroom_datetime[0].classroom_time_start,'HH:mm').format('HH:mm')+` - `+moment(value.classroom_datetime[0].classroom_time_end,'HH:mm').format('HH:mm')+`'
                      )"
                       >Detail</button>
                    </div>
                  </div>
                </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'register_course_private_student'){
            var date_se = '';
            if (value.classroom_start_date == value.classroom_end_date) {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y')+" to "+moment(value.classroom_end_date).format('DD/MM/Y');
            }

            var room_name = '';
            if (value.classroom_name.length > 20) {
              var text_new = value.classroom_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.classroom_name;
            }

            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>Registration completed</b></p>
                    <p class="fs-16 header-noti">You register for `+ room_name +` with teacher `+ value.classroom_name +`</p>
                    <p class="fs-16 header-noti">Teaching date `+ date_se +`</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'invite_course_student'){
            var date_to = ''; /// `+moment(date.created_at).format('DD/MM/Y HH:mm') +`
              if (value.course_datetime.length > 1) {
                date_to = moment(value.course_start_date).format('DD/MM/Y')+` To `+moment(value.course_end_date).format('DD/MM/Y');
              }else {
                date_to =  moment(value.course_start_date).format('DD/MM/Y');
              }

              var course_name = '';
              if (value.course_name.length > 20) {
                var text_new = value.course_name.slice(0, 20);
                course_name = text_new+`...`;
              }else {
                course_name = value.course_name;
              }
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>Private course created, waiting for payment</b></p>
                    <p class="fs-16 header-noti">`+ course_name +` with teacher `+ value.teacher_fullname +`</p>
                    <p class="fs-16 header-noti">Teaching date `+ date_to +` </p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                    <a href="`+window.location.origin+`/courses/`+value.course_id+`">
                      <button class="btn btn-noti-invate" style="border-radius: 20px; font-size: 14px; color: white; width: 90px;">Pay</button>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'cancel_course_teacher_not'){
            var room_name = '';
            if (value.classroom_name.length > 20) {
              var text_new = value.classroom_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.classroom_name;
            }

            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>Open course `+ room_name +` (Private) unsuccessful</b></p>
                    <p class="fs-16 header-noti">Because no one pays study fee.</p>
                    <p class="fs-16 header-noti">Contact students to re-open the course.</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>`;
          }
        }
        else {

          if(value.noti_type == 'open_course_teacher'){
            var room_name = '';
            if (value.classroom_name.length > 20) {
              var text_new = value.classroom_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.classroom_name;
            }
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>ใกล้ถึงเวลาเข้าประชุม</b></p>
                    <p class="fs-16 header-noti">`+ room_name+` ของคุณ</p>
                    <p class="fs-16 header-noti">วันที่ประชุม `+moment(value.classroom_date).format('DD/MM/Y')+` เวลา `+value.classroom_time_start+` - `+value.classroom_time_end+`</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                    <a href="`+window.location.origin+`/classroom/check/`+value._id+`" target="_blank">
                      <button class="btn btn-noti" style="border-radius: 20px; font-size: 14px; color: white; width: 90px;" >เข้าร่วม</button>
                    </a>
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'open_course_student'){
            var room_name = '';
            if (value.classroom_name.length > 20) {
              var text_new = value.classroom_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.classroom_name;
            }
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>ใกล้ถึงเวลาเข้าประชุม</b></p>
                    <p class="fs-16 header-noti">`+ room_name +` </p>
                    <p class="fs-16 header-noti">วันที่ประชุม `+moment(value.classroom_dat).format('DD/MM/Y')+` เวลา `+value.classroom_time_start+`-`+value.classroom_time_end+` </p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                    <a href="`+window.location.origin+`/classroom/check/`+value._id+`" target="_blank">
                      <button class="btn btn-noti" style="border-radius: 20px; font-size: 14px; color: white; width: 90px;" >เข้าร่วม</button>
                    </a>
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'register_course_teacher'){
            var date_se = '';
            if (value.classroom_start_date == value.classroom_end_date) {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y')+" ถึง "+moment(value.classroom_end_date).format('DD/MM/Y');
            }
            var room_name = '';
            if (value.classroom_name.length > 20) {
              var text_new = value.classroom_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.classroom_name;
            }
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>มีคนเข้าร่วมห้องประชุมของคุณ</b></p>
                    <p class="fs-16 header-noti"> `+ value.student_fullname +` เข้าร่วมประชุม  `+room_name+` </p>
                    <p class="fs-16 header-noti">วันที่ประชุม `+date_se+`</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'register_course_private_teacher'){
            var date_se = '';
            if (value.classroom_start_date == value.classroom_end_date) {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y');
            }
            var room_name = '';
            if (value.classroom_name.length > 20) {
              var text_new = value.classroom_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.classroom_name;
            }
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>เข้าร่วมประชุมสำเร็จ</b></p>
                    <p class="fs-16 header-noti">`+value.student_fullname+` เข้าร่วมประชุม `+room_name+` ของคุณ</p>
                    <p class="fs-16 header-noti">วันที่ประชุม `+date_se+` ถึง `+moment(value.classroom_end_date).format('DD/MM/Y')+`</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm')+`</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'register_course_student'){
            var date_se = '';
            if (value.classroom_start_date == value.classroom_end_date) {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y');
            }

            var room_name = '';
            if (value.classroom_name.length > 20) {
              var text_new = value.classroom_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.classroom_name;
            }
            console.log(value);
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>เข้าร่วมประชุมสำเร็จ</b></p>
                    <p class="fs-16 header-noti">คุณเข้าร่วมประชุม `+room_name+` </p>
                    <p class="fs-16 header-noti">วันที่ประชุม `+date_se+` ถึง `+moment(value.classroom_end_date).format('DD/MM/Y')+`</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6" style="text-align-last: right;">
                    <button class="btn btn-outline-dark button-s" style="margin-top:0px; margin-left: 0px;"
                    onclick="register_course_student(
                      '`+value.classroom_name+`',
                      '`+value.teacher_fullname+`',
                      '`+moment(value.classroom_datetime[0].classroom_date).format('DD/MM/Y')+` `+moment(value.classroom_datetime[0].classroom_time_start,'HH:mm').format('HH:mm')+` - `+moment(value.classroom_datetime[0].classroom_time_end,'HH:mm').format('HH:mm')+`'
                      )"
                     >รายละเอียด</button>
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'register_course_private_student'){
            var date_se = '';
            if (value.classroom_start_date == value.classroom_end_date) {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y');
            }
            var room_name = '';
            if (value.classroom_name.length > 20) {
              var text_new = value.classroom_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.classroom_name;
            }

            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>เข้าร่วมประชุมสำเร็จ</b></p>
                    <p class="fs-16 header-noti">เข้าร่วมประชุม `+room_name+`</p>
                    <p class="fs-16 header-noti">วันที่สอน `+date_se+` ถึง `+moment(value.classroom_end_date).format('DD/MM/Y')+`</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'invite_course_student'){
            var date_to = '';
              if (value.course_datetime.length > 1) {
                date_to = moment(value.course_start_date).format('DD/MM/Y')+` ถึง `+moment(value.course_end_date).format('DD/MM/Y');
              }else {
                date_to =  moment(value.course_start_date).format('DD/MM/Y');
              }

              var course_name = '';
              if (value.course_name.length > 20) {
                var text_new = value.course_name.slice(0, 20);
                course_name = text_new+`...`;
              }else {
                course_name = value.course_name;
              }

            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>ห้องประชุม Private ถูกสร้างแล้ว</b></p>
                    <p class="fs-16 header-noti">`+ course_name +`</p>
                    <p class="fs-16 header-noti">วันที่ประชุม `+date_to+` </p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                    <a href="`+window.location.origin+`/courses/`+value.course_id+`">
                      <button class="btn btn-noti-invate" style="border-radius: 20px; font-size: 14px; color: white; width: 90px;" >ลงทะเบียน</button>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'cancel_course_teacher_not'){
            var room_name = '';
            if (value.classroom_name.length > 20) {
              var text_new = value.classroom_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.classroom_name;
            }
            alerts += `<div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>เปิดห้องประชุม `+ room_name +` (Private) ไม่สำเร็จ</b></p>
                    <p class="fs-16 header-noti">เนื่องจากไม่มีผู้เข้าร่วมประชุม</p>
                    <p class="fs-16 header-noti">ติดต่อสมาชิกเพื่อเปิดห้องประชุมใหม่อีกครั้ง</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            `;
          }
        }


      });
      if(alerts == ''){
        alerts = '<h3>'+notification_history_not_found+'</h3>';
      }
      $('#user_page_alerts').html(alerts);

     STR = '';
     var data = data.alerts;
     let li = '';

     for (let page = 1; page <= data.last_page; page++) {
         if (page == data.current_page) {
             li += `<li class="page-item active"><a class="page-link">${page}</a></li>`;
         }else if(data.last_page < 7) {
             li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
         }else{
             if ((data.last_page / 2) < data.current_page) {
                 if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                     if (page == data.current_page - 1 && data.current_page != data.last_page) {
                         li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                     }
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`; // -
                 } else if (data.current_page == data.last_page && page == data.current_page - 2) {
                     li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                 }else if (page == 1 || page == 2) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                 }
             }else {
                 if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`; // +
                     if (page == data.current_page + 1 && data.current_page != 1) {
                         li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                     }
                 } else if (data.current_page == 1 && page == data.current_page + 2) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                     li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                 }else if (page == data.last_page - 1 || page == data.last_page) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                 }
             }
         }
     }

     STR += `
         <hr>
         <nav aria-label="Page navigation example">
             <ul class="pagination justify-content-end">
                 <li class="page-item">
                 <a class="page-link" aria-label="Previous" href="`+ data.prev_page_url +`">
                     <span aria-hidden="true">&laquo;</span>
                     <span class="sr-only">Previous</span>
                 </a>
                 </li>
                 ${li}
                 <li class="page-item">
                 <a class="page-link" href="`+ data.next_page_url +`"  aria-label="Next">
                     <span aria-hidden="true">&raquo;</span>
                     <span class="sr-only">Next</span>
                 </a>
                 </li>
             </ul>
         </nav>`;

         if (data.total >= 3) {
           $('#user_alerts_page_num').html(STR);
         }

  },

}

var user_profile_request = {
  request:() => {
    $.ajax({
      url: window.location.origin + '/get_date/user_profile_request',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      // data: {
      //   'data': data,
      // },
      dataType: "json",
      success: function(data) {
        // console.log(data);
        user_profile_request.new_page_request(data);
      }
    });
  },

  new_page_request : (data) => {
      var request ='';
      var lang = $('#current_lang').val();
      var request_history_not_found = (lang=='en')?'Request history no found.':'ไม่พบประวัติการ Request';

      $.each(data.request.data, function(key, value) {

      var study_date = moment(value.request_date+" "+value.request_time).format('DD/MM/Y HH:mm');

      if(lang=='en'){
          var study_status = value.request_type == "1" ? " Learn immediately : "+study_date:" Specify study date : "+study_date;
      }
      else{
          var study_status = value.request_type == "1" ? " เรียนทันที : "+study_date:" ระบุวันที่เรียน : "+study_date;
      }

      var rate_price = (lang=='en')?'Teaching duration per hour (Coins)':'ช่วงราคาสอนต่อชั่วโมง (Coins)';
      var detail = (lang=='en')?'Detail':'รายละเอียด';

          request += `<div class="form-row">
                        <div class="col-12 col-md-10">
                            <p class="fs-16 text-head-noti"> `+ value.request_topic +` </p>
                            <p class="fs-16 header-noti" >`+ value.course_group +` , `+ value.course_subject +`</p>
                            <p class="fs-16 header-noti" >`+ rate_price +` `+ value.request_price.toLocaleString(undefined, {minimumFractionDigits: 0}) +`</p>
                            <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i>`+ study_status +`</p>
                        </div>
                        <div class="col-12 col-md-2 col-sm-12 text-right" style="align-self: center;">
                          <button class="btn btn-outline-dark button-s" style="margin-top:0px; margin-left: 0px;" id="open_model_user_profile_request" onclick="user_profile_request.open_modal_request('`+ value._id +`')" >`+detail+` </button>
                        </div>
                      </div>
                      <hr>`;
        });
      if(request == ''){
        request = '<h3>'+request_history_not_found+'</h3>';
      }
      $('#user_page_request').html(request);
     //

     STR = '';
     var data = data.request;
     let li = '';

     for (let page = 1; page <= data.last_page; page++) {
         if (page == data.current_page) {
             li += `<li class="page-item active"><a class="page-link">${page}</a></li>`;
         }else if(data.last_page < 7) {
             li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
         }else{
             if ((data.last_page / 2) < data.current_page) {
                 if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                     if (page == data.current_page - 1 && data.current_page != data.last_page) {
                         li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                     }
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`; // -
                 } else if (data.current_page == data.last_page && page == data.current_page - 2) {
                     li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                 }else if (page == 1 || page == 2) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                 }
             }else {
                 if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`; // +
                     if (page == data.current_page + 1 && data.current_page != 1) {
                         li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                     }
                 } else if (data.current_page == 1 && page == data.current_page + 2) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                     li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                 }else if (page == data.last_page - 1 || page == data.last_page) {
                     li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
                 }
             }
         }
     }

     STR += `
         <hr>
         <nav aria-label="Page navigation example">
             <ul class="pagination justify-content-end">
                 <li class="page-item">
                 <a class="page-link" aria-label="Previous" href="`+ data.prev_page_url +`">
                     <span aria-hidden="true">&laquo;</span>
                     <span class="sr-only">Previous</span>
                 </a>
                 </li>
                 ${li}
                 <li class="page-item">
                 <a class="page-link" href="`+ data.next_page_url +`"  aria-label="Next">
                     <span aria-hidden="true">&raquo;</span>
                     <span class="sr-only">Next</span>
                 </a>
                 </li>
             </ul>
         </nav>`;

         if (data.total >= 3) {
           $('#user_alerts_page_request').html(STR);
         }

  },

  open_modal_request : (id) => {
    var lang = $('#current_lang').val();
    var request_summary = (lang=='en')?'Request summary':'สรุปการ Request';
    var request_teaching = (lang=='en')?'Request teaching duration':'ช่วงเวลาที่ต้องการเรียน';
    var teaching = (lang=='en')?'Teaching duration per hour':'ช่วงราคาสอนต่อชั่วโมง (Coins)';
    var study_group = (lang=='en')?'Study group':'กลุ่มการศึกษา';
    var subjects = (lang=='en')?'Subjects':'วิชา';
    var detail = (lang=='en')?'Detail':'รายละเอียด';
    var topic = (lang=='en')?'Topic':'หัวข้อที่อยากเรียน';

    $.ajax({
      url: "/get_user/open_modal_request/"+id,
      method:'get',
      success:function(data) {
        // console.log(JSON.parse(data));
        var request = JSON.parse(data);

        Swal.fire({
              html:
                '<div class="grid">'+
                    '<div class="row">'+
                        '<div class="col" align="left">'+
                            '<h4><b>'+request_summary+'</b></h4>'+
                        '</div>'+
                    '</div>'+
                    '<hr>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+request_teaching+'</b> '+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+moment(request[0].request_date+" "+request[0].request_time).format('DD/MM/Y HH:mm')+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-4" align="left">'+
                            '<b style="font-size:14px;">'+teaching+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+request[0].request_price.toLocaleString(undefined, {minimumFractionDigits: 0})+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-4" align="left">'+
                            '<b style="font-size:14px;">'+topic+' </b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+request[0].request_topic+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-4" align="left">'+
                            '<b style="font-size:14px;">'+study_group+' </b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+request[0].course_group+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-4" align="left">'+
                            '<b style="font-size:14px;">'+subjects+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+request[0].course_subject+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-4" align="left">'+
                            '<b style="font-size:14px;">'+detail+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+request[0].request_detail+'</p>'+
                        '</div>'+
                    '</div>'+
                '</div>',
            //   showCloseButton: false,
              showCancelButton: false,
              focusConfirm: false,
              confirmButtonColor: '#003D99',
              showConfirmButton: true,
              confirmButtonText: close_window,
        })

        // setTimeout(function() {
        //   $('#model_user_profile_request').modal('show');
        // }, 500);
        //
        // $(".study_now2").html(moment(request[0].request_date+" "+request[0].request_time).format('DD/MM/Y HH:mm'));
        // $(".price_range2").html(request[0].request_price);
        // $(".study_group2").html(request[0].course_group);
        // $(".subjects2").html(request[0].course_subject);
        // $(".details_study2").html(request[0].request_detail);
        //
        //
        // $('.show_request').html('<button type="button" class="close"> ปิด </button>');
      },
    });

  },

}


$(function() {
  if ($(location).attr('hash') == "#user_alerts") {
    $('.nav-link.user_alerts').addClass('active');
    $('.nav-link.user_home').removeClass('active');

    user_profile_alerts.alerts();
    $(".user_dis_home").css("display", "none");
    $(".user_dis_contact").css("display", "none");
    $(".user_dis_coins").css("display", "none");
    $(".user_dis_alerts").css("display", "inline");
    $(".user_dis_request").css("display", "none");
    $("#sub3").css("display", "none");
  }

  $(".user_home").click(function () {
    $(".user_dis_home").css("display", "inline");
    $(".user_dis_contact").css("display", "none");
    $(".user_dis_coins").css("display", "none");
    $(".user_dis_alerts").css("display", "none");
    $(".user_dis_request").css("display", "none");
    $("#sub3").css("display", "inline");
  });

  $(".user_contact").click(function () {
    user_profile_contact.contact();
    $(".user_dis_home").css("display", "none");
    $(".user_dis_contact").css("display", "inline");
    $(".user_dis_coins").css("display", "none");
    $(".user_dis_alerts").css("display", "none");
    $(".user_dis_request").css("display", "none");
    $("#sub3").css("display", "none");

  });
  //-------------------------------------------------------------------------------

  $(".user_coins").click(function () {
    user_profile_coins.coins();
    $(".user_dis_home").css("display", "none");
    $(".user_dis_contact").css("display", "none");
    $(".user_dis_coins").css("display", "inline");
    $(".user_dis_alerts").css("display", "none");
    $(".user_dis_request").css("display", "none");
    $("#sub3").css("display", "none");
  });
  //-------------------------------------------------------------------------------

  $(".user_alerts").click(function () {
    user_profile_alerts.alerts();
    $(".user_dis_home").css("display", "none");
    $(".user_dis_contact").css("display", "none");
    $(".user_dis_coins").css("display", "none");
    $(".user_dis_alerts").css("display", "inline");
    $(".user_dis_request").css("display", "none");
    $("#sub3").css("display", "none");
  });
  //-------------------------------------------------------------------------------

  $(".user_request").click(function () {
    user_profile_request.request();
    $(".user_dis_home").css("display", "none");
    $(".user_dis_contact").css("display", "none");
    $(".user_dis_coins").css("display", "none");
    $(".user_dis_alerts").css("display", "none");
    $(".user_dis_request").css("display", "inline");
    $("#sub3").css("display", "none");
  });
  //-------------------------------------------------------------------------------
  setTimeout(function () {
    if($(".nav-link.user_contact").hasClass('active')) {
      user_profile_contact.contact();
    }
  }, 1000);


  $(document).on('click', '.user_page_contact a', function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    fetch_data_contact(page);
   });

  function fetch_data_contact(page) {
    $.ajax({
      url: "/get/user_profile_contact",
      method:'post',
      data:{
          page: page,
          _token: $('input[name="_token"]').val()
      },
      success:function(data) {
        user_profile_contact.new_page_contact(JSON.parse(data));
      },
    });
  }
  //-------------------------------------------------------------------------------

  $(document).on('click', '.user_page_coins a', function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    fetch_data_coins(page);
   });

  function fetch_data_coins(page) {
    $.ajax({
      url: "/get/user_profile_coins",
      method:'post',
      data:{
          page: page,
          _token: $('input[name="_token"]').val()
      },
      success:function(data) {
        user_profile_coins.new_page_coins(JSON.parse(data));
      },
    });
  }
  //-------------------------------------------------------------------------------

  $(document).on('click', '.user_page_alerts a', function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    fetch_data_alerts(page);
   });

  function fetch_data_alerts(page) {
    $.ajax({
      url: "/get/user_profile_alerts",
      method:'post',
      data:{
          page: page,
          _token: $('input[name="_token"]').val()
      },
      success:function(data) {
        user_profile_alerts.new_page_alerts(JSON.parse(data));
      },
    });
  }
  //-------------------------------------------------------------------------------

  $(document).on('click', '.user_page_request a', function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    fetch_data_request(page);
   });

  function fetch_data_request(page) {
    $.ajax({
      url: "/get/user_profile_request",
      method:'post',
      data:{
          page: page,
          _token: $('input[name="_token"]').val()
      },
      success:function(data) {
        user_profile_request.new_page_request(JSON.parse(data));
      },
    });
  }
  //-------------------------------------------------------------------------------


});
