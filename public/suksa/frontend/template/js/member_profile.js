

var profile_contact = {
  data: false,
  contact:() => {
    $.ajax({
      url: window.location.origin + '/get_date/profile_contact',
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
        profile_contact.new_page_contact(data);
      }
    });
  },

  new_page_contact : (data) => {
    var lang = $('#current_lang').val();
    var teaching_history_not_found = (lang=='en')?'Teaching history no found.':'ไม่พบประวัติการสอน';
    var student_list = (lang=='en')?'Student list':'รายชื่อผู้เรียน';
    var view_student_list = (lang=='en')?'View student list':'ดูรายชื่อผู้เรียน';
    var view_payment_status = (lang=='en')?'Payment status':'ดูสถานะชำระเงิน';
    var join_button = (lang=='en')?'Join':'เข้าห้องเรียน';

    profile_contact.data = {data : data};
    var contact ='';
    $.each(data.cousres.data, function(key, value){
      var price = '';
      if(value.course_price){
         price = '<p class="notfree">'+value.course_price.toLocaleString(undefined, {minimumFractionDigits: 0})+' Coins</p>';
      }
      else{
        price = '<p class="free">'+data.free_course+'</p>';
      }

      var icon = '';
      var list_student = '';
      if(value.course_category == 'Public'){
        icon = '<i class="fs-16 fa fa-globe fa-lg " style="font-size:16px;"></i> <label calss="fs-16">'+view_student_list+'</label>';
        if (value.student_name){
          list_student = '<button type="button" class="btn btn-link fs-16" onclick="profile_contact.gen_modal_list_student(`'+value._id+'`)">'+student_list+'</button>';
        }
        else{
          list_student = '<button type="button" class="btn btn-link fs-16" disabled>'+student_list+'</button>';
        }
      }
      else{
        icon = '<i class="fs-16 fa fa-lock fa-lg" style="font-size:16px;"> </i> <label calss="fs-16">'+view_student_list+'</label>';
        list_student = '<button type="button" class="btn btn-link fs-16" onclick="profile_contact.gen_modal_list_student(`'+value._id+'`)">'+view_payment_status+'</button>';
      }

      var student = '';
      if(value.student > 0){
        student = " "+value.student+' / '+value.course_student_limit;
      }
      else{
        student = ' 0 / '+value.course_student_limit;
      }

      var course_file = '';
      if(value.course_file){
         course_file = '<p class="fs-16 header-noti" color: black;"><i class="fa fa-file" style="font-size:16px;"></i>&nbsp;1 '+data.course_document+' <a style="color: #3990F2; class="fs-16 header-noti" border-bottom: 1px solid #3990F2;" href="'+window.location.origin+'/storage/coursefile/'+value.course_file+'" download>'+data.download_button+'</a></p>';
      }
      else{
        course_file = '<p class="fs-16 header-noti" color: black;"><i class="fa fa-file" style="font-size:16px;"></i>&nbsp; '+data.course_document+'</p>';
      }

      var btn = '';

      //Public Course
      if(value.course_category == 'Public'){
        //ถ้าเปิดรับสมัคร
        if(value.course_status == "open"){
          $.each(value.course_date, function(index, el){
            /**** ถ้าวันเวลาปัจจุบัน ตรงกับ วันเวลาที่เปิดคอร์ส ****/
            var current_datetime = new Date();
            var course_start_datetime = new Date(el.date+" "+el.time_start);
            var course_end_datetime = new Date(el.date+" "+el.time_end);
            course_start_datetime.setMinutes(course_start_datetime.getMinutes() - 10);

            //ถ้าวันเวลาที่เปิดสอน -10 นาที น้อยกว่า วันเวลาปัจจุบัน และต้องน้อยกว่าวันเวลาที่ปิดการสอน
            if((current_datetime.getTime() >= course_start_datetime.getTime())
              && (current_datetime.getTime() <= course_end_datetime.getTime())){
              if(value.classroom_status == 1){
                //ให้แสดงปุ่ม เข้าห้องเรียน และ รายละเอียด
                btn = `<a href="`+window.location.origin+`/classroom/check/`
                      +value.link_open+`" class="btn  button-s" target="_blank" style="margin-top: 0px; margin-top: 0px; background: #6ab22a; color: white;" >`
                      +join_button+` </a> <a href="`+window.location.origin+`/courses/`+value._id+`" class="btn btn-outline-dark  " style="border-radius: 20px; font-size: 14px">`
                      +data.course_detail+`</a>`; //0011
              }
              else if(value.classroom_status == 2){
                //ให้แสดงปุ่ม รายละเอียด
                btn = `<a href="`+window.location.origin+`/courses/`+value._id+
                      `" class="btn btn-outline-dark" style="border-radius: 20px; font-size: 14px">`
                      +data.course_detail+`</a>`; //0012
              }
              else{ //value.classroom_status == 0 or null
                //ให้แสดงปุ่ม เปิดรับสมัคร และ รายละเอียด
                btn = `<span class="btn btn-button-open" >`+ data.openning_register +
                    `</span> <a href="`+window.location.origin+`/courses/`+value._id+
                    `" class="btn btn-outline-dark  " style="border-radius: 20px; font-size: 14px">`
                    +data.course_detail+`</a>`; //0013
              }
              return false;
            }
            /**** ถ้าวันเวลาปัจจุบัน ไม่ตรงกับ วันเวลาที่เปิดคอร์ส ****/
            else{
              first_open_course = new Date(value.course_date_start+" "+value.course_time_start);
              first_open_course.setMinutes(first_open_course.getMinutes() - 10);

              //ถ้าวันเวลาปัจจุบัน น้อยกว่า วันเวลาที่เปิดสอนวันแรก
              if(current_datetime.getTime() < first_open_course.getTime()){
                //ถ้าจำนวนนักเรียนเต็มโควตา
                if(value.course_student_limit == value.student){
                  //ให้แสดงปุ่ม ปิด และ รายละเอียด
                  btn = `<span class="btn btn-button-close" >`+ data.close_register +
                        `</span> <a href="`+window.location.origin+`/courses/`+value._id+
                        `" class="btn btn-outline-dark" style="border-radius: 20px; font-size: 14px">`
                        +data.course_detail+`</a>`; //002
                }
                //ถ้าจำนวนนักเรียนไม่เต็มโควตา
                else{
                  if(value.classroom_status == 1){
                    //ให้แสดงปุ่ม เข้าห้องเรียน และ รายละเอียด
                    btn = `<a href="`+window.location.origin+`/classroom/check/`
                          +value.link_open+`" class="btn  button-s" target="_blank" style="margin-top: 0px; margin-top: 0px; background: #6ab22a; color: white;" >`
                          +join_button+` </a> <a href="`+window.location.origin+`/courses/`+value._id+`" class="btn btn-outline-dark  " style="border-radius: 20px; font-size: 14px">`
                          +data.course_detail+`</a>`; //0031
                  }
                  else if(current_datetime.getTime() < course_start_datetime.getTime()){
                    //ให้แสดงปุ่ม เปิดรับสมัคร และ รายละเอียด
                    btn = `<span class="btn btn-button-open" >`+ data.openning_register +
                        `</span> <a href="`+window.location.origin+`/courses/`+value._id+
                        `" class="btn btn-outline-dark  " style="border-radius: 20px; font-size: 14px">`
                        +data.course_detail+`</a>`; //0032
                  }
                  else{
                    //ให้แสดงปุ่ม รายละเอียด
                    btn = `<a href="`+window.location.origin+`/courses/`+value._id+
                          `" class="btn btn-outline-dark" style="border-radius: 20px; font-size: 14px">`
                          +data.course_detail+`</a>`; //0033
                  }
                }
              }
              //ถ้าวันเวลาปัจจุบัน มากกว่า วันเวลาที่เปิดสอน
              else{
                //ให้แสดงปุ่ม รายละเอียด
                btn = `<a href="`+window.location.origin+`/courses/`+value._id+
                      `" class="btn btn-outline-dark" style="border-radius: 20px; font-size: 14px">`
                      +data.course_detail+`</a>`; //004
              }
            }
          });
        }
        //ถ้ายังไม่เปิดรับสมัคร
        else{
          $.each(value.course_date, function(index, el){
            var current_datetime = new Date();
            var course_start_datetime = new Date(value.course_date_start+" "+value.course_time_start);
            course_start_datetime.setMinutes(course_start_datetime.getMinutes() - 10);

            //ถ้าวันเวลาปัจจุบัน น้อยกว่า วันเวลาที่เปิดสอนวันแรก -10 นาที
            if(current_datetime.getTime() < course_start_datetime.getTime()){
              //ให้แสดงปุ่ม กำลังจะเปิดรับสมัคร และ แก้ไขคอร์ส
              btn = '<button onclick="open_course(`'
                    +value._id+'`)" class="btn status-commingsoon" >'
                    +data.waiting_register+'</button> <a href="'+window.location.origin+
                    '/courses/'+value._id+'/edit " class="btn btn-outline-dark" style="border-radius: 20px; font-size: 14px">'
                    +data.course_edit+'</a>'; //005
              return false;
            }
            //ถ้าวันเวลาปัจจุบัน มากกว่าหรือเท่ากับ วันเวลาที่เปิดสอน
            else{
              //ให้แสดงปุ่ม รายละเอียด
              btn = `<a href="`+window.location.origin+`/courses/`+value._id+
                    `" class="btn btn-outline-dark" style="border-radius: 20px; font-size: 14px">`
                    +data.course_detail+`</a>`; //006 d1.getTime()
            }
          });
        }
      }
      //Private Course
      else{
        //ถ้าเปิดรับสมัคร
        if(value.course_status == "open"){
          $.each(value.course_date, function(index, el){
            /**** ถ้าวันเวลาปัจจุบัน ตรงกับ วันเวลาที่เปิดคอร์ส ****/
            var current_datetime = new Date();
            var course_start_datetime = new Date(el.date+" "+el.time_start);
            var course_end_datetime = new Date(el.date+" "+el.time_end);
            course_start_datetime.setMinutes(course_start_datetime.getMinutes() - 10);

            //ถ้าวันเวลาที่เปิดสอน น้อยกว่า วันเวลาปัจจุบัน +10 นาที และต้องน้อยกว่าวันเวลาที่ปิดการสอน
            if(((current_datetime.getTime() >= course_start_datetime.getTime())
              && (current_datetime.getTime() <= course_end_datetime.getTime())) || (value.classroom_status == 1)){
              if(value.course_student_limit == value.student){
                //ให้แสดงปุ่ม เข้าห้องเรียน และ รายละเอียด
                btn = `<a href="`+window.location.origin+`/classroom/check/`
                      +value.link_open+`" class="btn  button-s" target="_blank" style="margin-top: 0px; margin-top: 0px; background: #6ab22a; color: white;" >`
                      +join_button+` </a> <a href="`+window.location.origin+`/courses/`+value._id+`" class="btn btn-outline-dark  " style="border-radius: 20px; font-size: 14px">`
                      +data.course_detail+`</a>`; //0071
                return false;
              }
              else{
                //ให้แสดงปุ่ม รายละเอียด
                btn = `<a href="`+window.location.origin+`/courses/`+value._id+
                      `" class="btn btn-outline-dark" style="border-radius: 20px; font-size: 14px">`
                      +data.course_detail+`</a>`; //0072
              }
            }
            /**** ถ้าวันเวลาปัจจุบัน ไม่ตรงกับ วันเวลาที่เปิดคอร์ส ****/
            else{
              //course_start_datetime = new Date(value.course_date_start+" "+value.course_time_start);
              //course_start_datetime.setMinutes(course_start_datetime.getMinutes() + 10);

              //ถ้าวันเวลาปัจจุบัน น้อยกว่า วันเวลาที่เปิดสอนวันแรก
              if(current_datetime.getTime() < course_start_datetime.getTime()){
                //ให้แสดงปุ่ม รายละเอียด
                btn = `<a href="`+window.location.origin+`/courses/`+value._id+
                      `" class="btn btn-outline-dark" style="border-radius: 20px; font-size: 14px">`
                      +data.course_detail+`</a>`; //008
              }
              //ถ้าวันเวลาปัจจุบัน มากกว่า วันเวลาที่เปิดสอน
              else{
                //ให้แสดงปุ่ม รายละเอียด
                btn = `<a href="`+window.location.origin+`/courses/`+value._id+
                      `" class="btn btn-outline-dark" style="border-radius: 20px; font-size: 14px">`
                      +data.course_detail+`</a>`; //009
              }
            }
          });
        }
        //ถ้าสถานะคอร์สเปลี่ยนเป็นยกเลิก course_status = cancel
        else{
          //ให้แสดงปุ่ม รายละเอียด
          btn = `<a href="`+window.location.origin+`/courses/`+value._id+
                `" class="btn btn-outline-dark" style="border-radius: 20px; font-size: 14px">`
                +data.course_detail+`</a>`; //010
        }
      }

      // var date_1 = ;
      var course_date = '';
      var date_1 = '';


      for(var i = 0; i < value.course_date.length; i++){
        // console.log(value.course_date.length);
        if(i > 0){
          date_1 = moment(value.course_date[0].date).format('DD/MM/YYYY');
          date_2 = moment(value.course_date[i].date).format('DD/MM/YYYY');
          date_3 = date_1+" - "+date_2;
          course_date = date_3;
        }
        else{
          date_1 = moment(value.course_date[0].date).format('DD/MM/YYYY');
          course_date = date_1;
        }
      }

      contact += `
          <div class="form-row">
              <div class="container">
                <div class="row">
                  <div class="col-sm-4"> <img src="`+window.location.origin+`/storage/course/`+value.course_img+`" onerror="this.onerror=null;this.src='http://localhost:8000/suksa/frontend/template/images/icons/blank_image.jpg';" class="img-responsive"></div>
                  <div class="col-sm-5">
                    <p class="fs-16 text-profile-noti overflow_course">`+value.course_name+`</p>
                    <p class="fs-16 header-noti">`+price+`</p>
                    <p class="fs-16 header-noti">`+value.course_group+" "+value.course_subject+`</p>
                    <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+course_date+`</p>
                    <p class="fs-16 header-noti" color: black;">`+icon+` `+student+` `+list_student+`</p>
                    `+course_file+`
                  </div>
                  <div class="col-sm-3 p-l-0 p-r-0" style="align-self: center; text-align-last: right;">
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
      contact = '<h3>'+teaching_history_not_found+'</h3>';
    }
    $('#page_contact').html(contact);

    STR = '';
    var data = data.cousres;
    let li = '';

    for (let page = 1; page <= data.last_page; page++) {
        if (page == data.current_page) {
            li += `<div class="page-item active"><a class="page-link">${page}</a></div>`;
        }else if(data.last_page < 7) {
            li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
        }else{
            if ((data.last_page / 2) < data.current_page) {
                if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                    if (page == data.current_page - 1 && data.current_page != data.last_page) {
                        li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                    }
                    li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`; // -
                } else if (data.current_page == data.last_page && page == data.current_page - 2) {
                    li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                    li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                }else if (page == 1 || page == 2) {
                    li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                }
            }else {
                if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                    li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`; // +
                    if (page == data.current_page + 1 && data.current_page != 1) {
                        li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                    }
                } else if (data.current_page == 1 && page == data.current_page + 2) {
                    li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                    li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                }else if (page == data.last_page - 1 || page == data.last_page) {
                    li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                }
            }
        }
    }

    STR += `
        <hr>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <div class="page-item">
                <a class="page-link" aria-label="Previous" href="`+ data.prev_page_url +`">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
                </div>
                ${li}
                <div class="page-item">
                <a class="page-link" href="`+ data.next_page_url +`"  aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
                </div>
            </ul>
        </nav>`;
        if (data.total >= 3) {
          $('#page_num').html(STR);
        }


  },

  gen_modal_list_student:(id) => {
    // console.log(data);
    $.ajax({
      url: window.location.origin + '/members/student_status/'+id,
      type: 'get',
      dataType: "json",
      success: function(data) {
        // console.log(data);
        profile_contact.modal_list_student(data);
      }
    });
  },

  modal_list_student :(data) => {
    // console.log(data);
    // var st_bt = '';
    var list = '';
    if (data[0].category == 'Public') {
      st_bt = 'Public';
      list = list = data;
    }else {
      list = data; // Private
      st_bt = 'Private';
      // $('#check_th').val('Private');
    }

    // console.log(list);

    STR = '';
    var da = '';
    if (list[0].student_date == "-") {
      da = '-';
    }else {
      da = moment(student.student_date_regis).format('DD/MM/YYYY');
    }

    var lang = $('#current_lang').val();
    var payment_success = (lang=='en')?'Payment successful':'ชำระเงินสำเร็จ';
    var payment_pending = (lang=='en')?'Payment pending':'รอการชำระเงิน';

    let i = 1;
    for (const student of list) {

        STR += '<tr><td>'+ i++ +'</td><td>'+da+'</td><td><a href="'+window.location.origin+'/request/user_profile/'+student.student_id+'" target="_blank">'
                      +student.student_name+'</a></td>';
        if (student.student_status) {
          if (student.student_status == 0) {
            if (student.student_date == "-") {
              STR += '<td>'+student.student_email+'</td><td>'+student.student_tell+'</td><td>'+"-"+'</td><tr>'
            }else {
              STR += '<td>'+student.student_email+'</td><td>'+student.student_tell+'</td><td>'+payment_pending+'</td><tr>'
            }
          }else {
            // TR = '<thูสถานะชำระเงิน</th>';
            STR += '<td>'+student.student_email+'</td><td>'+student.student_tell+'</td><td>'+payment_success+'</td><tr>'
          }
        }else {
          // $('#status').remove(TR);
          STR += '<td>'+student.student_email+'</td><td>'+student.student_tell+'</td><tr>'
        }

    }

    // $('#status').append(TR);

    if(st_bt == 'Public'){
      $('#modal_student').modal('show');
      $('#student').html(STR);
    }
    else{
      $('#modal_student_private').modal('show');
      $('#student_private').html(STR);
    }
  }
}

var profile_coins = {

  coins:() => {
    $.ajax({
      url: window.location.origin + '/get_date/profile_coins',
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
        profile_coins.new_page_coins(data);
      }
    });
  },

  new_page_coins : (data) => {
    // console.log(data);
      var lang = $('#current_lang').val();
      var coins_history_not_found = (lang=='en')?'Coins history no found.':'ไม่พบประวัติการใช้ Coins';

      var courses ='';

          $.each(data.coins.data, function(key, value) {
            var type = ''; //`+value.course_name+`
            var show_type = '';
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
                        <div class="col-sm-6">
                          <p class="fs-16 header-noti">
                          `+show_type+" "+value.coin_number+" Coins"+`

                          `+btn+`
                          </p>
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i>&nbsp;`+moment(value.created_at).format('DD/MM/YYYY HH:mm:ss')+`</p>
                        </div>
                        <div class="col-sm-6" style="align-self: center;
                        text-align-last: right;">
                          <button class="btn btn-outline-dark button-s " style="margin-top:0px; margin-left: 0px; font-size: 14px;" onclick="detail_coins(
                              '`+value.event+`',
                              '`+moment(value.coin_date).format('DD/MM/YYYY')+`',
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
      $('#page_coins').html(courses);

      STR = '';
      var data = data.coins;
      let li = '';
      for (let page = 1; page <= data.last_page; page++) {
          if (page == data.current_page) {
              li += `<div class="page-item active"><a class="page-link">${page}</a></div>`;
          }else if(data.last_page < 7) {
              li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
          }else{
              if ((data.last_page / 2) < data.current_page) {
                  if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                      if (page == data.current_page - 1 && data.current_page != data.last_page) {
                          li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                      }
                      li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`; // -
                  } else if (data.current_page == data.last_page && page == data.current_page - 2) {
                      li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                      li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                  }else if (page == 1 || page == 2) {
                      li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                  }
              }else {
                  if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                      li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`; // +
                      if (page == data.current_page + 1 && data.current_page != 1) {
                          li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                      }
                  } else if (data.current_page == 1 && page == data.current_page + 2) {
                      li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                      li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                  }else if (page == data.last_page - 1 || page == data.last_page) {
                      li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                  }
              }
          }
      }

      STR += `
          <hr>
          <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-end">
                  <div class="page-item">
                  <a class="page-link" aria-label="Previous" href="`+ data.prev_page_url +`">
                      <span aria-hidden="true">&laquo;</span>
                      <span class="sr-only">Previous</span>
                  </a>
                  </div>
                  ${li}
                  <div class="page-item">
                  <a class="page-link" href="`+ data.next_page_url +`"  aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                      <span class="sr-only">Next</span>
                  </a>
                  </div>
              </ul>
          </nav>`;

          if (data.total >= 3) {
            $('#coins_page_num').html(STR);
          }

      // return STR;
  },

}

var profile_alerts = {
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
        profile_alerts.new_page_alerts(data);
      }
    });
  },

  new_page_alerts : (data) => {
      var alerts ='';
      var lang = $('#current_lang').val();
      var notification_history_not_found = (lang=='en')?'Notification history no found.':'ไม่พบประวัติการแจ้งเตือน';
      var detail = (lang=='en')?'Detail':'รายละเอียด';
      var assess_button = (lang=='en')?'Assess':'ให้คะแนน';

      $.each(data.alerts.data, function(key, value) {
        console.log(value);
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
                    <p class="fs-16 header-noti">Teaching date `+moment(value.classroom_date).format('DD/MM/YYYY') +` Time `+moment(value.classroom_time_end).format('DD/MM/Y') +` </p>
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
                    <p class="fs-16 header-noti">Teaching date `+moment(value.classroom_date).format('DD/MM/YYYY') +` Time `+moment(value.classroom_time_end).format('DD/MM/Y') +`</p>
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
          else if(value.noti_type == 'approve_topup_coins'){
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>Top up coins successfully</b></p>
                    <p class="fs-16 header-noti">You top up `+value.coins+` coins successfully</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6" style="align-self: center;
                  text-align-last: right;">
                    
                  </div>
                </div>
                </div>
            </div>
            <hr>`;

            // <button class="btn btn-outline-dark button-s " style="margin-top:0px; margin-left: 0px;"
            // onclick="approve_topup_coins(
            // '`+data.confirm+`',
            // '`+value.coins+`',
            // '`+moment(value.updated_at).format('DD/MM/Y')+`',
            // '`+moment(value.created_at).format('DD/MM/Y')+`')">`+detail+`</button>
          }
          else if(value.noti_type == 'not_approve_topup_coins'){
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                  <p class="fs-16 text-head-noti"><b>Top up coins unsuccessful</b></p>
                  <p class="fs-16 header-noti">You top up `+value.coins+` coins unsuccessful</p>
                  <p class="fs-16 header-noti">Because `+value.coins_description+`</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6" style="align-self: center;
                  text-align-last: right;">
                    
                  </div>
                </div>
              </div>
            </div>
            <hr>`;

            // <button class="btn btn-outline-dark button-s " style="margin-top:0px; margin-left: 0px;" onclick="approve_topup_coins(
            // '`+data.unsuccess+`',
            // '`+value.coins+`',
            // '`+moment(value.updated_at).format('DD/MM/Y')+`',
            // '`+moment(value.created_at).format('DD/MM/Y')+`',
            // )">`+detail+`</button>
          }
          else if(value.noti_type == 'approve_withdraw_coins'){
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>Withdraw coins successfully</b></p>
                    <p class="fs-16 header-noti">You withdraw `+value.coins+` coins successfully</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6" style="align-self: center;
                  text-align-last: right;">
                    
                  </div>
                </div>
              </div>
            </div>
            <hr>`;

            // <button class="btn btn-outline-dark button-s " style="margin-top:0px; margin-left: 0px;" onclick="approve_withdraw_coins(
            // '1',
            // '`+value.coins+`',
            // '`+moment(value.updated_at).format('DD/MM/Y')+` ',
            // '`+moment(value.created_at).format('DD/MM/Y')+`',
            // )">`+detail+`</button>
          }
          else if(value.noti_type == 'not_approve_withdraw_coins'){
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                  <p class="fs-16 text-head-noti"><b>Withdraw coins unsuccessful</b></p>
                  <p class="fs-16 header-noti">You withdraw `+value.coins+` coins unsuccessful</p>
                  <p class="fs-16 header-noti">Because `+value.coins_description+`</p>  
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6" style="align-self: center;
                  text-align-last: right;">
                    
                  </div>
                </div>
              </div>
            </div>
            <hr>`;

            // <button class="btn btn-outline-dark button-s " style="margin-top:0px; margin-left: 0px;" onclick="approve_withdraw_coins(
            // '`+'0'+`',
            // '`+value.coins+`',
            // '`+moment(value.updated_at).format('DD/MM/Y')+` ',
            // '`+moment(value.created_at).format('DD/MM/Y')+`',
            // )">`+detail+`</button>
          }
          else if(value.noti_type == 'register_course_teacher'){
            var date_se = '';
            if (value.classroom_start_date == value.classroom_end_date) {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/Y')+" to "+moment(value.classroom_end_date).format('DD/MM/YYYY');
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
              date_se = moment(value.classroom_start_date).format('DD/MM/YYYY');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/YYYY')+" to "+moment(value.classroom_end_date).format('DD/MM/YYYY');
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
              date_se = moment(value.classroom_start_date).format('DD/MM/YYYY');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/YYYY')+" to "+moment(value.classroom_end_date).format('DD/MM/YYYY');
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
                      '`+moment(value.classroom_datetime[0].classroom_date).format('DD/MM/YYYY')+` `+moment(value.classroom_datetime[0].classroom_time_start,'HH:mm').format('HH:mm')+` - `+moment(value.classroom_datetime[0].classroom_time_end,'HH:mm').format('HH:mm')+`'
                      )"
                     >`+detail+`</button>
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'register_course_private_student'){
            var date_se = '';
            if (value.classroom_start_date == value.classroom_end_date) {
              date_se = moment(value.classroom_start_date).format('DD/MM/YYYY');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/YYYY')+" to "+moment(value.classroom_end_date).format('DD/MM/YYYY');
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
                date_to = moment(value.course_start_date).format('DD/MM/YYYY')+` To `+moment(value.course_end_date).format('DD/MM/YYYY');
              }else {
                date_to =  moment(value.course_start_date).format('DD/MM/YYYY');
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
          else if(value.noti_type == 'invite_course_teacher'){
            var date_to = ''; /// `+moment(date.created_at).format('DD/MM/Y HH:mm') +`
              if (value.course_datetime.length > 1) {
                date_to = moment(value.course_start_date).format('DD/MM/YYYY')+` To `+moment(value.course_end_date).format('DD/MM/YYYY');
              }else {
                date_to =  moment(value.course_start_date).format('DD/MM/YYYY');
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
                  <p class="fs-16 text-head-noti"><b>Create course `+value.noti_course_type +` successfully</b></p>
                  <p class="fs-16 header-noti">`+ course_name +` with teacher `+ value.teacher_fullname +`</p>
                  <p class="fs-16 header-noti">Teaching date `+ date_to +`</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                </div>
              </div>
              <hr>`;
          }
          else if(value.noti_type == 'cancel_course_teacher'){
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
                    <p class="fs-16 header-noti">Because students haven't paid all the study fee.</p>
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
          else if(value.noti_type == 'cancel_course_student'){
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
                    <p class="fs-16 text-head-noti"><b>The `+ room_name +` course (Private) is canceled</b></p>
                    <p class="fs-16 header-noti">Because someone didn't pay the study fee.</p>
                    <p class="fs-16 header-noti">You have refunded `+ value.course_price +` Coins</p>
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
          else if(value.noti_type == 'request_to_teacher'){
            alerts += `
            <div class="form-row">
              <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>There is a request that matches you</b></p>
                    <p class="fs-16 header-noti">students `+ value.student_fullname +` </p>
                    <p class="fs-16 header-noti">Request education group `+ value.request_group_name_en +`  subjects `+ value.request_subject_name_en +` </p>
                    <p class="fs-16 header-noti">Preferred date `+ value.request_date +`  Time `+ value.request_time +` </p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm')+`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                    <a href="`+window.location.origin+`/request/user_profile/`+value.student_id+`" target="_blank">
                      <buttonclass="btn btn-noti-invate" style="border-radius: 20px; font-size: 14px; color: white; width: 90px;">`+detail+`</button>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'get_coins_course'){
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>You have received coins</b></p>
                    <p class="fs-16 header-noti">You have received `+value.coins+` coins</p>
                    <p class="fs-16 header-noti">From the course `+value.course_name+`</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6" style="align-self: center;
                  text-align-last: right;">
                    
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if (value.noti_type == 'sent_student_rating'){
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
                    <p class="fs-16 text-head-noti"><b>Learning assessment</b></p>
                    <p class="fs-16 header-noti">You have teached `+ room_name +` successfully</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                  <a href="`+window.location.origin+`/rating/student_rating/`+value.course_id+`">
                    <button class="btn btn-noti" style="border-radius: 20px; font-size: 14px; color: white; width: 90px;" >`+assess_button+`</button>
                  </a>
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if (value.noti_type == 'sent_teacher_rating'){
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
                    <p class="fs-16 text-head-noti"><b>Teaching assessment</b></p>
                    <p class="fs-16 header-noti">You have studied `+ room_name +` </p>
                    <p class="fs-16 header-noti">With teacher `+ value.teacher_fullname +` successfully</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                  <a href="`+window.location.origin+`/rating/teacher_rating/`+value.course_id+`">
                    <button class="btn btn-noti" style="border-radius: 20px; font-size: 14px; color: white; width: 90px;" >`+assess_button+`</button>
                  </a>
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if (value.noti_type == 'approve_refund_teacher'){
            var room_name = '';
            if (value.course_name.length > 20) {
              var text_new = value.course_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.course_name;
            }

            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>Refund successfully</b></p>
                    <p class="fs-16 header-noti">You don't receive `+ value.coins +` coins of `+ value.student_fullname +`</p>
                    <p class="fs-16 header-noti">From the course `+ room_name +` </p>
                    <p class="fs-16 header-noti">Because `+ value.refund_description +` </p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                  
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if (value.noti_type == 'approve_refund_student'){
            var room_name = '';
            if (value.course_name.length > 20) {
              var text_new = value.course_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.course_name;
            }

            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>Refund successfully</b></p>
                    <p class="fs-16 header-noti">You have received `+ value.coins +` coins refund from the course `+ room_name +`</p>
                    <p class="fs-16 header-noti">Because `+ value.refund_description +` </p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                  
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if (value.noti_type == 'not_approve_refund_teacher'){
            var room_name = '';
            if (value.course_name.length > 20) {
              var text_new = value.course_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.course_name;
            }

            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>Refund unsuccessfully</b></p>
                    <p class="fs-16 header-noti">You have receive `+ value.coins +` coins of `+ value.student_fullname +`</p>
                    <p class="fs-16 header-noti">From the course `+ room_name +` </p>
                    <p class="fs-16 header-noti">Because `+ value.refund_description +` </p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                  
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if (value.noti_type == 'not_approve_refund_student'){
            var room_name = '';
            if (value.course_name.length > 20) {
              var text_new = value.course_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.course_name;
            }

            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>Refund unsuccessfully</b></p>
                    <p class="fs-16 header-noti">You don't received `+ value.coins +` coins refund from the course `+ room_name +`</p>
                    <p class="fs-16 header-noti">Because `+ value.refund_description +` </p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                  
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
                    <p class="fs-16 text-head-noti"><b>ใกล้ถึงเวลาสอน</b></p>
                    <p class="fs-16 header-noti">`+ room_name+` ของคุณ `+ value.teacher_fullname +` </p>
                    <p class="fs-16 header-noti">วันที่สอน `+moment(value.classroom_date).format('DD/MM/YYYY')+` เวลา `+value.classroom_time_start+` - `+value.classroom_time_end+`</p>
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
                    <p class="fs-16 text-head-noti"><b>ใกล้ถึงเวลาเข้าเรียน</b></p>
                    <p class="fs-16 header-noti">`+ room_name +`  กับผู้สอน `+ value.teacher_fullname +` </p>
                    <p class="fs-16 header-noti">วันที่นัด `+moment(value.classroom_dat).format('DD/MM/YYYY')+` เวลา `+value.classroom_time_start+`-`+value.classroom_time_end+` </p>
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
          else if(value.noti_type == 'approve_topup_coins'){
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>เติม Coins สำเร็จ</b></p>
                    <p class="fs-16 header-noti">คุณเติม Coins จำนวน `+value.coins+`  Coins สำเร็จ</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6" style="align-self: center;
                  text-align-last: right;">
                    
                  </div>
                </div>
                </div>
            </div>
            <hr>`;

            // <button class="btn btn-outline-dark button-s " style="margin-top:0px; margin-left: 0px;"
            // onclick="approve_topup_coins(
            // '`+data.confirm+`',
            // '`+value.coins+`',
            // '`+moment(value.updated_at).format('DD/MM/Y')+`',
            // '`+moment(value.created_at).format('DD/MM/Y')+`')">รายละเอียด</button>
          }
          else if(value.noti_type == 'not_approve_topup_coins'){
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>เติม Coins ไม่สำเร็จ</b></p>
                    <p class="fs-16 header-noti">คุณเติม Coins จำนวน  `+value.coins+` Coins ไม่สำเร็จ</p>
                    <p class="fs-16 header-noti">เนื่องจาก `+value.coins_description+`</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6" style="align-self: center;
                  text-align-last: right;">
                    
                  </div>
                </div>
              </div>
            </div>
            <hr>`;

            // <button class="btn btn-outline-dark button-s " style="margin-top:0px; margin-left: 0px;" onclick="approve_topup_coins(
            // '`+'ไม่สำเร็จ'+`',
            // '`+value.coins+`',
            // '`+moment(value.updated_at).format('DD/MM/Y')+`',
            // '`+moment(value.created_at).format('DD/MM/Y')+`',
            // )">รายละเอียด</button>
          }
          else if(value.noti_type == 'approve_withdraw_coins'){
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>ถอน Coins สำเร็จ</b></p>
                    <p class="fs-16 header-noti">คุณถอน Coins จำนวน `+value.coins+` Coins สำเร็จ</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6" style="align-self: center;
                  text-align-last: right;">
                    
                  </div>
                </div>
              </div>
            </div>
            <hr>`;

            // <button class="btn btn-outline-dark button-s " style="margin-top:0px; margin-left: 0px;" onclick="approve_withdraw_coins(
            // '`+'1'+`',
            // '`+value.coins+`',
            // '`+moment(value.updated_at).format('DD/MM/Y')+` ',
            // '`+moment(value.created_at).format('DD/MM/Y')+`',
            // )">รายละเอียด</button>
          }
          else if(value.noti_type == 'not_approve_withdraw_coins'){

            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                  <p class="fs-16 text-head-noti"><b>ถอน Coins ไม่สำเร็จ</b></p>
                  <p class="fs-16 header-noti">คุณถอน Coins จำนวน `+value.coins+` Coins ไม่สำเร็จ</p>
                  <p class="fs-16 header-noti">เนื่องจาก `+value.coins_description+`</p>   
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6" style="align-self: center;
                  text-align-last: right;">
                    
                  </div>
                </div>
              </div>
            </div>
            <hr>`;

            // <button class="btn btn-outline-dark button-s " style="margin-top:0px; margin-left: 0px;" onclick="approve_withdraw_coins(
            // '`+'0'+`',
            // '`+value.coins+`',
            // '`+moment(value.updated_at).format('DD/MM/Y')+` ',
            // '`+moment(value.created_at).format('DD/MM/Y')+`',
            // )">รายละเอียด</button>
          }
          else if(value.noti_type == 'register_course_teacher'){
            var date_se = '';
            if (value.classroom_start_date == value.classroom_end_date) {
              date_se = moment(value.classroom_start_date).format('DD/MM/YYYY');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/YYYY')+" ถึง "+moment(value.classroom_end_date).format('DD/MM/YYYY');
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
                    <p class="fs-16 text-head-noti"><b>มีคนสมัครเรียนคอร์สของคุณ</b></p>
                    <p class="fs-16 header-noti"> `+ value.student_fullname +` สมัครเรียน  `+room_name+` </p>
                    <p class="fs-16 header-noti">วันที่สอน `+date_se+`</p>
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
              date_se = moment(value.classroom_start_date).format('DD/MM/YYYY');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/YYYY');
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
                    <p class="fs-16 text-head-noti"><b>ชำระเงินสำเร็จ</b></p>
                    <p class="fs-16 header-noti">`+value.student_fullname+` ชำระค่าเรียน `+room_name+`</p>
                    <p class="fs-16 header-noti">วันที่สอน `+date_se+` ถึง `+moment(value.classroom_end_date).format('DD/MM/YYYY')+`</p>
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
              date_se = moment(value.classroom_start_date).format('DD/MM/YYYY');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/YYYY');
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
                    <p class="fs-16 text-head-noti"><b>สมัครเรียนสำเร็จ</b></p>
                    <p class="fs-16 header-noti">คุณสมัครเรียน `+room_name+` กับผู้สอน `+value.teacher_fullname+` </p>
                    <p class="fs-16 header-noti">วันที่สอน `+date_se+` ถึง `+moment(value.classroom_end_date).format('DD/MM/YYYY')+`</p>
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
                      '`+moment(value.classroom_datetime[0].classroom_date).format('DD/MM/YYYY')+` `+moment(value.classroom_datetime[0].classroom_time_start,'HH:mm').format('HH:mm')+` - `+moment(value.classroom_datetime[0].classroom_time_end,'HH:mm').format('HH:mm')+`'
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
              date_se = moment(value.classroom_start_date).format('DD/MM/YYYY');
            }else {
              date_se = moment(value.classroom_start_date).format('DD/MM/YYYY');
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
                    <p class="fs-16 text-head-noti"><b>ชำระเงินสำเร็จ</b></p>
                    <p class="fs-16 header-noti">ชำระค่าเรียน `+room_name+`  กับผู้สอน `+value.teacher_fullname+` </p>
                    <p class="fs-16 header-noti">วันที่สอน `+date_se+` ถึง `+moment(value.classroom_end_date).format('DD/MM/YYYY')+`</p>
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
                date_to = moment(value.course_start_date).format('DD/MM/YYYY')+` ถึง `+moment(value.course_end_date).format('DD/MM/YYYY');
              }else {
                date_to =  moment(value.course_start_date).format('DD/MM/YYYY');
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
                    <p class="fs-16 text-head-noti"><b>คอร์ส Private ถูกสร้างแล้ว รอการชำระ</b></p>
                    <p class="fs-16 header-noti">`+ course_name +`  กับผู้สอน `+ value.teacher_fullname +` </p>
                    <p class="fs-16 header-noti">วันที่สอน `+date_to+` </p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                    <a href="`+window.location.origin+`/courses/`+value.course_id+`">
                      <button class="btn btn-noti-invate" style="border-radius: 20px; font-size: 14px; color: white; width: 90px;" >ไปชำระเงิน</button>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'invite_course_teacher'){
            var date_to = ''; /// `+moment(date.created_at).format('DD/MM/Y HH:mm') +`
              if (value.course_datetime.length > 1) {
                date_to = moment(value.course_start_date).format('DD/MM/YYYY')+` ถึง `+moment(value.course_end_date).format('DD/MM/YYYY');
              }else {
                date_to =  moment(value.course_start_date).format('DD/MM/YYYY');
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
                  <p class="fs-16 text-head-noti"><b>สร้างคอร์ส `+ value.noti_course_type +` สำเร็จ</b></p>
                  <p class="fs-16 header-noti">`+ course_name +` กับผู้สอน `+ value.teacher_fullname +`</p>
                  <p class="fs-16 header-noti">วันที่สอน `+ date_to +`</p>
                  <div class="row">
                    <div class="col-sm-7" >
                        <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                    </div>
                  </div>
              </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'cancel_course_teacher'){
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
                    <p class="fs-16 text-head-noti"><b>เปิดคอร์สเรียน `+ room_name +` (Private) ไม่สำเร็จ</b></p>
                    <p class="fs-16 header-noti">เนื่องจากนักเรียนชำระเงินค่าเรียนไม่ครบทุกคน</p>
                    <p class="fs-16 header-noti">ติดต่อนักเรียนเพื่อเปิดคอร์สเรียนใหม่อีกครั้ง</p>
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
                    <p class="fs-16 text-head-noti"><b>เปิดคอร์สเรียน `+ room_name +` (Private) ไม่สำเร็จ</b></p>
                    <p class="fs-16 header-noti">เนื่องจากไม่มีผู้ชำระเงินค่าเรียน</p>
                    <p class="fs-16 header-noti">ติดต่อนักเรียนเพื่อเปิดคอร์สเรียนใหม่อีกครั้ง</p>
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
          else if(value.noti_type == 'cancel_course_student'){
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
                  <p class="fs-16 text-head-noti"><b>คอร์ส `+room_name+` (Private) ถูกยกเลิก</b></p>
                  <p class="fs-16 header-noti">เนื่องจากมีผู้ไม่ชำระเงินค่าเรียน</p>
                  <p class="fs-16 header-noti">คุณได้รับคืน Coins จำนวน `+value.course_price+`  Coins</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm')+`</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            `;
          }
          else if(value.noti_type == 'request_to_teacher'){
            alerts += `
            <div class="form-row">
              <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>มี Request ที่ตรงกับคุณ</b></p>
                    <p class="fs-16 header-noti">ผู้เรียน `+value.student_fullname+`  </p>
                    <p class="fs-16 header-noti">ได้ Request กลุ่มการศึกษา `+value.request_group_name_th+` รายวิชา `+value.request_subject_name_th+` </p>
                    <p class="fs-16 header-noti">วันที่ต้องการเรียน `+value.request_date+`  เวลา `+value.request_time+` </p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ moment(value.created_at).format('DD/MM/YYYY HH:mm')+`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                    <a href="`+window.location.origin+`/request/user_profile/`+value.student_id+`">
                      <button class="btn btn-noti-invate" style="border-radius: 20px; font-size: 14px; color: white; width: 90px;">รายละเอียด</button>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <hr>`;
          }
          else if(value.noti_type == 'get_coins_course'){
            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="fs-16 text-head-noti"><b>คุณได้รับ Coins</b></p>
                    <p class="fs-16 header-noti">คุณได้รับ `+value.coins+` Coins</p>
                    <p class="fs-16 header-noti">จากการสอนคอร์ส `+value.course_name+`</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6" style="align-self: center;
                  text-align-last: right;">
                    
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if (value.noti_type == 'sent_student_rating'){
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
                    <p class="fs-16 text-head-noti"><b>ให้คะแนนการเรียน</b></p>
                    <p class="fs-16 header-noti">คุณได้ทำการสอน `+ room_name +` เรียบร้อยแล้ว</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                  <a href="`+window.location.origin+`/rating/student_rating/`+value.course_id+`">
                    <button class="btn btn-noti" style="border-radius: 20px; font-size: 14px; color: white; width: 90px;" >`+assess_button+`</button>
                  </a>
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if (value.noti_type == 'sent_teacher_rating'){
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
                    <p class="fs-16 text-head-noti"><b>ให้คะแนนการสอน</b></p>
                    <p class="fs-16 header-noti">คุณได้ทำการเรียน `+ room_name +` </p>
                    <p class="fs-16 header-noti">กับผู้สอน `+ value.teacher_fullname +` เรียบร้อยแล้ว</p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                  <a href="`+window.location.origin+`/rating/teacher_rating/`+value.course_id+`">
                    <button class="btn btn-noti" style="border-radius: 20px; font-size: 14px; color: white; width: 90px;" >`+assess_button+`</button>
                  </a>
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if (value.noti_type == 'approve_refund_teacher'){
            var room_name = '';
            if (value.course_name.length > 20) {
              var text_new = value.course_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.course_name;
            }

            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>ขอคืนเงินสำเร็จ</b></p>
                    <p class="fs-16 header-noti">คุณไม่ได้รับ `+ value.coins +` Coins ของ `+ value.student_fullname +`</p>
                    <p class="fs-16 header-noti">จากคอร์สเรียน `+ room_name +` </p>
                    <p class="fs-16 header-noti">เนื่องจาก `+ value.refund_description +` </p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                  
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if (value.noti_type == 'approve_refund_student'){
            var room_name = '';
            if (value.course_name.length > 20) {
              var text_new = value.course_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.course_name;
            }

            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>ขอคืนเงินสำเร็จ</b></p>
                    <p class="fs-16 header-noti">คุณได้รับ `+ value.coins +` Coins คืนจากคอร์สเรียน `+ room_name +`</p>
                    <p class="fs-16 header-noti">เนื่องจาก `+ value.refund_description +` </p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                  
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if (value.noti_type == 'not_approve_refund_teacher'){
            var room_name = '';
            if (value.course_name.length > 20) {
              var text_new = value.course_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.course_name;
            }

            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>ขอคืนเงินไม่สำเร็จ</b></p>
                    <p class="fs-16 header-noti">คุณได้รับ `+ value.coins +` Coins ของ `+ value.student_fullname +`</p>
                    <p class="fs-16 header-noti">จากคอร์สเรียน `+ room_name +` </p>
                    <p class="fs-16 header-noti">เนื่องจาก `+ value.refund_description +` </p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                  
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
          else if (value.noti_type == 'not_approve_refund_student'){
            var room_name = '';
            if (value.course_name.length > 20) {
              var text_new = value.course_name.slice(0, 20);
              room_name = text_new+`...`;
            }else {
              room_name = value.course_name;
            }

            alerts += `
            <div class="form-row">
                <div class="container">
                <div class="row form-row">
                  <div class="col-sm-10">
                    <p class="fs-16 text-head-noti"><b>ขอคืนเงินไม่สำเร็จ</b></p>
                    <p class="fs-16 header-noti">คุณไม่ได้รับ `+ value.coins +` Coins คืนจากคอร์สเรียน `+ room_name +`</p>
                    <p class="fs-16 header-noti">เนื่องจาก `+ value.refund_description +` </p>
                    <div class="row">
                      <div class="col-sm-7" >
                          <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+moment(value.created_at).format('DD/MM/YYYY HH:mm') +`</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 text-right">
                  
                  </div>
                </div>
                </div>
            </div>
            <hr>`;
          }
        }


      });

      if(alerts == ''){
        alerts = '<h3>'+notification_history_not_found+'</h3>';
      }
      $('#page_alerts').html(alerts);
     //

     STR = '';
     var data = data.alerts;
     let li = '';

     for (let page = 1; page <= data.last_page; page++) {
         if (page == data.current_page) {
             li += `<div class="page-item active"><a class="page-link">${page}</a></div>`;
         }else if(data.last_page < 7) {
             li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
         }else{
             if ((data.last_page / 2) < data.current_page) {
                 if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                     if (page == data.current_page - 1 && data.current_page != data.last_page) {
                         li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                     }
                     li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`; // -
                 } else if (data.current_page == data.last_page && page == data.current_page - 2) {
                     li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                     li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                 }else if (page == 1 || page == 2) {
                     li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                 }
             }else {
                 if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                     li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`; // +
                     if (page == data.current_page + 1 && data.current_page != 1) {
                         li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                     }
                 } else if (data.current_page == 1 && page == data.current_page + 2) {
                     li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                     li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                 }else if (page == data.last_page - 1 || page == data.last_page) {
                     li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                 }
             }
         }
     }

     STR += `
         <hr>
         <nav aria-label="Page navigation example">
             <ul class="pagination justify-content-end">
                 <div class="page-item">
                 <a class="page-link" aria-label="Previous" href="`+ data.prev_page_url +`">
                     <span aria-hidden="true">&laquo;</span>
                     <span class="sr-only">Previous</span>
                 </a>
                 </div>
                 ${li}
                 <div class="page-item">
                 <a class="page-link" href="`+ data.next_page_url +`"  aria-label="Next">
                     <span aria-hidden="true">&raquo;</span>
                     <span class="sr-only">Next</span>
                 </a>
                 </div>
             </ul>
         </nav>`;

         if (data.total >= 3) {
           $('#alerts_page_num').html(STR);
         }


  },

}

var profile_request = {
  request:() => {
    $.ajax({
      url: window.location.origin + '/get_date/profile_request',
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
        profile_request.new_page_request(data);
      }
    });
  },

  new_page_request : (data) => {
      var request ='';
      var lang = $('#current_lang').val();
      var request_history_not_found = (lang=='en')?'Request history no found.':'ไม่พบประวัติการ Request';

      $.each(data.request.data, function(key, value) {

        var study_date = moment(value.request_date+" "+value.request_time).format('DD/MM/YYYY HH:mm');

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
                              <p class="fs-16 fs-16 text-head-noti"> `+ value.request_topic +` </p>
                              <p class="fs-16 header-noti" >`+ value.course_group +` , `+ value.course_subject +`</p>
                              <p class="fs-16 header-noti" >`+ rate_price +` `+ value.member_rate_start +` - `+ value.member_rate_end +`</p>
                              <p class="fs-16 header-noti"><i style="font-size:16px" class="fa">&#xf073;</i> `+ study_status +`</p>
                          </div>
                          <div class="col-12 col-md-2 col-sm-12 text-right">
                              <button class="btn btn-outline-dark button-s" style="margin-top:0px; margin-left: 0px;" id="open_model_profile_request" onclick="profile_request.open_modal_request('`+ value._id +`')" > `+ detail +` </button>
                          </div>
                        </div>
                        <hr>`;
      });
      if(request == ''){
        request = '<h3>'+request_history_not_found+'</h3>';
      }
      $('#page_request').html(request);
     //

     STR = '';
     var data = data.request;
     let li = '';

     for (let page = 1; page <= data.last_page; page++) {
         if (page == data.current_page) {
             li += `<div class="page-item active"><a class="page-link">${page}</a></div>`;
         }else if(data.last_page < 7) {
             li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
         }else{
             if ((data.last_page / 2) < data.current_page) {
                 if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                     if (page == data.current_page - 1 && data.current_page != data.last_page) {
                         li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                     }
                     li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`; // -
                 } else if (data.current_page == data.last_page && page == data.current_page - 2) {
                     li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                     li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                 }else if (page == 1 || page == 2) {
                     li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                 }
             }else {
                 if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                     li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`; // +
                     if (page == data.current_page + 1 && data.current_page != 1) {
                         li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                     }
                 } else if (data.current_page == 1 && page == data.current_page + 2) {
                     li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                     li += `<div class="page-item"><button type="submit" class="page-link">...</button></div>`;
                 }else if (page == data.last_page - 1 || page == data.last_page) {
                     li += `<div class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></div>`;
                 }
             }
         }
     }

     STR += `
         <hr>
         <nav aria-label="Page navigation example">
             <ul class="pagination justify-content-end">
                 <div class="page-item">
                 <a class="page-link" aria-label="Previous" href="`+ data.prev_page_url +`">
                     <span aria-hidden="true">&laquo;</span>
                     <span class="sr-only">Previous</span>
                 </a>
                 </div>
                 ${li}
                 <div class="page-item">
                 <a class="page-link" href="`+ data.next_page_url +`"  aria-label="Next">
                     <span aria-hidden="true">&raquo;</span>
                     <span class="sr-only">Next</span>
                 </a>
                 </div>
             </ul>
         </nav>`;

         if (data.total >= 3) {
           $('#alerts_page_request').html(STR);
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
      url: "/get/open_modal_request/"+id,
      method:'get',
      success:function(data) {
        // console.log(JSON.parse(data));
        var request = JSON.parse(data);
        var request_detail = request[0].request_detail;
        if (request_detail == null) {
          request_detail = "-";
        }
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
                            '<p style="font-size:14px;">'+moment(request[0].request_date+" "+request[0].request_time).format('DD/MM/YYYY HH:mm')+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
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
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+study_group+' </b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+request[0].course_group+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+subjects+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+request[0].course_subject+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+detail+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+request_detail+'</p>'+
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
      },
    });

  },

}



$(function() {
  if ($(location).attr('hash') == "#alerts") {
    $('.nav-link.alerts').addClass('active');
    $('.nav-link.home').removeClass('active');

    profile_alerts.alerts();
    $(".dis_home").css("display", "none");
    $(".dis_contact").css("display", "none");
    $(".dis_coins").css("display", "none");
    $(".dis_alerts").css("display", "inline");
    $(".dis_request").css("display", "none");
  }

  $(".home").click(function () {
    $(".dis_home").css("display", "inline");
    $(".dis_contact").css("display", "none");
    $(".dis_coins").css("display", "none");
    $(".dis_alerts").css("display", "none");
    $(".dis_request").css("display", "none");
  });

  $(".contact").click(function () {
    profile_contact.contact();
    $(".dis_home").css("display", "none");
    $(".dis_contact").css("display", "inline");
    $(".dis_coins").css("display", "none");
    $(".dis_alerts").css("display", "none");
    $(".dis_request").css("display", "none");

  });
  //-------------------------------------------------------------------------------

  $(".coins").click(function () {
    profile_coins.coins();
    $(".dis_home").css("display", "none");
    $(".dis_contact").css("display", "none");
    $(".dis_coins").css("display", "inline");
    $(".dis_alerts").css("display", "none");
    $(".dis_request").css("display", "none");
  });
  //-------------------------------------------------------------------------------

  $(".alerts").click(function () {
    profile_alerts.alerts();
    $(".dis_home").css("display", "none");
    $(".dis_contact").css("display", "none");
    $(".dis_coins").css("display", "none");
    $(".dis_alerts").css("display", "inline");
    $(".dis_request").css("display", "none");
  });
  //-------------------------------------------------------------------------------

  $(".request").click(function () {
    profile_request.request();
    $(".dis_home").css("display", "none");
    $(".dis_contact").css("display", "none");
    $(".dis_coins").css("display", "none");
    $(".dis_alerts").css("display", "none");
    $(".dis_request").css("display", "inline");
  });
  //-------------------------------------------------------------------------------

  $(document).on('click', '.page_contact a', function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    fetch_data_contact(page);
   });

  function fetch_data_contact(page) {
    $.ajax({
      url: "/get/profile_contact",
      method:'post',
      data:{
          page: page,
          _token: $('input[name="_token"]').val()
      },
      success:function(data) {
        profile_contact.new_page_contact(JSON.parse(data));
      },
    });
  }
  //-------------------------------------------------------------------------------

  $(document).on('click', '.page_coins a', function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    fetch_data_coins(page);
   });

  function fetch_data_coins(page) {
    $.ajax({
      url: "/get/profile_coins",
      method:'post',
      data:{
          page: page,
          _token: $('input[name="_token"]').val()
      },
      success:function(data) {
        profile_coins.new_page_coins(JSON.parse(data));
      },
    });
  }
  //-------------------------------------------------------------------------------

  $(document).on('click', '.page_alerts a', function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    fetch_data_alerts(page);
   });

  function fetch_data_alerts(page) {
    $.ajax({
      url: "/get/profile_alerts",
      method:'post',
      data:{
          page: page,
          _token: $('input[name="_token"]').val()
      },
      success:function(data) {
        profile_alerts.new_page_alerts(JSON.parse(data));
      },
    });
  }
  //-------------------------------------------------------------------------------

  $(document).on('click', '.page_request a', function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    fetch_data_request(page);
   });

  function fetch_data_request(page) {
    $.ajax({
      url: "/get/profile_request",
      method:'post',
      data:{
          page: page,
          _token: $('input[name="_token"]').val()
      },
      success:function(data) {
        profile_request.new_page_request(JSON.parse(data));
      },
    });
  }
  //-------------------------------------------------------------------------------
});
