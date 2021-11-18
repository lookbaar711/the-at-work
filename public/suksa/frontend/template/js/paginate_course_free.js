var course_free = {
  data: false,
   search_course_free : (data) => {
     // console.log(data);
     $.ajax({
       url: window.location.origin + '/get_data/Course_coursetFree',
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       type: 'POST',
       data: {
         'data': data,
       },
       dataType: "json",
       success: function(data) {
          course_free.new_page(data);
       }
     });
   },

   new_page : (data) => {
     var courses ='';
     var new_Date = Date.now();

     $.each(data.courses_free.data, function(key, value) {
       // console.log(value);
       var date = '';
       var btn = '';

       // if (value.course_date.length > 1 ) {
       //   date = moment(value.course_date[0].date).format('DD/MM/Y')+" - "+moment(value.course_date[value.course_date.length - 1].date).format('DD/MM/Y');
       // }else {

         date =  moment(value.course_date[0].date).format('DD/MM/Y');
       // }

       var lang = $('#current_lang').val();
       var waiting_register = (lang=='en')?'Waiting for register':'กำลังจะเปิดรับสมัคร';
       var openning_register = (lang=='en')?'Openning register':'เปิดรับสมัคร';
       var close_register = (lang=='en')?'Close Register':'ปิดรับสมัคร';
       var teach_date = (lang=='en')?'Course date':'วันที่เปิดสอน';

       var date_true = false;
        if (value.course_student_limit == value.student) {
          btn = '<div class="form-row" style="margin-left: -15px;"><div class="custom-control-inline status_close"></div>&nbsp;<label style="color: #9196A6; font-size: 14px;margin-top: 2px;">'+close_register+'</label></div>';
          date_true = true;
        }else if (value.course_status == "open") {
          btn = '<div class="form-row" style="margin-left: -15px;"><div class="custom-control-inline status_open"></div>&nbsp;<label style="color: #3990F2; font-size: 14px;margin-top: 2px;">'+openning_register+'</label></div>';
          date_true = true;
        }else {
          btn = '<div class="form-row" style="margin-left: -15px;"><div class="custom-control-inline status_commingsoon"></div>&nbsp;<label style="color: #FC8600; font-size: 14px;margin-top: 2px;">'+waiting_register+'</label></div>';
          date_true = true;
        }

        // var  ck_date1 = moment(Date.now()).format('MM-DD-Y HH:mm');
        // var  ck_date2 = moment(value.course_date[0].date+" "+value.course_date[0].time_start).format('MM-DD-Y HH:mm');

        // console.log(ck_date1+" < "+ck_date2);
        // console.log(Date.parse(ck_date1)+" < "+Date.parse(ck_date2));
        // console.log(Date.parse(ck_date1) < Date.parse(ck_date2));

        // if ( Date.parse(ck_date1) < Date.parse(ck_date2) ) {
        //    date_true = true;
        // }else {
        //    date_true = false;
        // }


        if (date_true == true) {
          courses += `
            <a href="`+"/courses/"+value._id+`">
              <div class="col-sm-12 col-md-4 col-lg-3">
                  <div class="card mb-3">
                      <div class="product-grid">
                        <div class="block2-img wrap-pic-w of-hidden pos-relative">
                          <a href="`+"/courses/"+value._id+`"><img src="`+"/storage/course/"+value.course_img+`" onerror="this.onerror=null;this.src='`+window.location.origin+`/suksa/frontend/template/images/icons/blank_image.jpg';" class="img-responsive"></a>
                        </div>
                        <ul class="social">
                          <li><a href="`+"/courses/"+value._id+`" data-tip="รายละเอียด"><i class="fa fa-search"></i></a></li>
                        </ul>
                      </div>
                      <div class="card-body text-center">
                          <a href="`+"/courses/"+value._id+`" class="p-b-5">
                              <p class="fs-18 text-black t-left"><b>`+value.course_category+`</b></p>
                          </a>
                          <a href="`+"/courses/"+value._id+`" class="p-b-5">
                              <p class="fs-18 text-black t-left overflow_course">`+value.course_name+`</p>
                          </a>
                          <a href="`+"/courses/"+value._id+`" class="p-b-5">
                              <p class="fs-14 t-left">`+ teach_date +` : `+ date +`</p>
                         </a>
                         <div class="col-12 text-center">
                            `+ btn +`
                         </div>
                      </div>
                  </div>
              </div>
            </a>
            `;
        }

     });
     if(courses == ''){
       courses = '<h5 class="text-center bg-secondary text-white p-2 col-12">ไม่พบประวัติการสร้างห้องประชุม</h5>';
     }
     $('#page_courseFree').html(courses);
    //

    STR = '';
    var data = data.courses_free;
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

        if (data.total  > 8) {
          $('#alerts_page_num').html(STR);
        }



     ///////---------------------------------------------------------------------

     setTimeout(function () {

     }, 500);

   },

   // search_course_no_fre : (data) => {
   //   // console.log(data);
   //   $.ajax({
   //     url: window.location.origin + '/get_data/Course_course_not_free',
   //     headers: {
   //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   //     },
   //     type: 'POST',
   //     data: {
   //       'data': data,
   //     },
   //     dataType: "json",
   //     success: function(data) {
   //        course_free.new_page_no_free(data);
   //     }
   //   });
   // },

   // new_page_no_free : (data) => {
   //   var courses_ont_free = '';

   //   $.each(data.courses_not_free.data, function(key, value) {
   //     // console.log(value);
   //     var date = '';
   //     var btn2 = '';
   //     var new_Date = Date.now();

   //     // if (value.course_date.length > 1 ) {
   //     //   date = moment(value.course_date[0].date).format('DD/MM/Y')+" - "+moment(value.course_date[value.course_date.length - 1].date).format('DD/MM/Y');
   //     // }else {

   //       date =  moment(value.course_date[0].date).format('DD/MM/Y');
   //     // }

   //     var lang = $('#current_lang').val();
   //     var waiting_register = (lang=='en')?'Waiting for register':'กำลังจะเปิดรับสมัคร';
   //     var openning_register = (lang=='en')?'Openning register':'เปิดรับสมัคร';
   //     var close_register = (lang=='en')?'Close Register':'ปิดรับสมัคร';
   //     var teach_date = (lang=='en')?'Course date':'วันที่เปิดสอน';

   //     var date_true = false;
   //     if (value.course_student_limit == value.student) {
   //       btn2 = '<div class="form-row" style="margin-left: -15px;"><div class="custom-control-inline status_close"></div>&nbsp;<label style="color: #9196A6; font-size: 14px;margin-top: 2px;">'+close_register+'</label></div>';
   //       // date_true = false;
   //       date_true = true;
   //     }else if (value.course_status == "open") {
   //       btn2 = '<div class="form-row" style="margin-left: -15px;"><div class="custom-control-inline status_open"></div>&nbsp;<label style="color: #3990F2; font-size: 14px;margin-top: 2px;">'+openning_register+'</label></div>';
   //       date_true = true;
   //     }else {
   //       btn2 = '<div class="form-row" style="margin-left: -15px;"><div class="custom-control-inline status_commingsoon"></div>&nbsp;<label style="color: #FC8600; font-size: 14px;margin-top: 2px;">'+waiting_register+'</label></div>';
   //       date_true = true;
   //     }

   //     // var  ck_date1 = moment(Date.now()).format('MM-DD-Y HH:mm');
   //     // var  ck_date2 = moment(value.course_date[0].date+" "+value.course_date[0].time_start).format('MM-DD-Y HH:mm');

   //     // console.log(ck_date1+" < "+ck_date2);
   //     // console.log(Date.parse(ck_date1)+" < "+Date.parse(ck_date2));
   //     // console.log(Date.parse(ck_date1) < Date.parse(ck_date2));

   //     // if ( Date.parse(ck_date1) < Date.parse(ck_date2) ) {
   //     //    date_true = true;
   //     // }else {
   //     //    date_true = false;
   //     // }

   //     if (date_true == true) {

   //       courses_ont_free += `
   //           <a href="`+"/courses/"+value._id+`">
   //             <div class="col-sm-12 col-md-4 col-lg-3">
   //                 <div class="card mb-3">
   //                     <div class="product-grid">
   //                       <div class="block2-img wrap-pic-w of-hidden pos-relative">
   //                         <a href="`+"/courses/"+value._id+`"><img src="`+"/storage/course/"+value.course_img+`" onerror="this.onerror=null;this.src='`+window.location.origin+`/suksa/frontend/template/images/icons/blank_image.jpg';" class="img-responsive"></a>
   //                       </div>
   //                       <ul class="social">
   //                         <li><a href="`+"/courses/"+value._id+`" data-tip="รายละเอียด"><i class="fa fa-search"></i></a></li>
   //                       </ul>
   //                     </div>
   //                     <div class="card-body text-center">
   //                         <a href="`+"/courses/"+value._id+`" class="p-b-5">
   //                             <p class="fs-18 text-black t-left">`+value.course_price.toLocaleString(undefined, {minimumFractionDigits: 0})+` Coins <img   style="width: 20px; " src="`+window.location.origin+`/suksa/frontend/template/images/icons/Coins.png"></p>
   //                         </a>
   //                         <a href="`+"/courses/"+value._id+`" class="p-b-5">
   //                             <p class="fs-18 text-black t-left overflow_course">`+value.course_name+`</p>
   //                         </a>
   //                         <a href="`+"/courses/"+value._id+`" class="p-b-5">
   //                             <p class="fs-14 t-left">`+value.course_group+" "+value.course_subject+`</p>
   //                         </a>
   //                         <a href="`+"/courses/"+value._id+`" class="p-b-5">
   //                             <p class="fs-14 t-left">`+ teach_date +` : `+ date +`</p>
   //                        </a>
   //                        <div class="col-12 text-center">
   //                           `+ btn2 +`
   //                        </div>
   //                     </div>
   //                 </div>
   //             </div>
   //           </a>`;
   //       }

   //   });

   //   if(courses_ont_free == ''){
   //     courses_ont_free = '<h5 class="text-center bg-secondary text-white p-2 col-12">ไม่พบประวัติการสร้าง คอร์สเรียน </h5>';
   //   }

   //   $('#page_course_not_free').html(courses_ont_free);

   //   STR = '';
   //   var data = data.courses_not_free;
   //   let li = '';

   //   for (let page = 1; page <= data.last_page; page++) {
   //       if (page == data.current_page) {
   //           li += `<li class="page-item active"><a class="page-link">${page}</a></li>`;
   //       }else if(data.last_page < 7) {
   //           li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
   //       }else{
   //           if ((data.last_page / 2) < data.current_page) {
   //               if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
   //                   if (page == data.current_page - 1 && data.current_page != data.last_page) {
   //                       li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
   //                   }
   //                   li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`; // -
   //               } else if (data.current_page == data.last_page && page == data.current_page - 2) {
   //                   li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
   //                   li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
   //               }else if (page == 1 || page == 2) {
   //                   li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
   //               }
   //           }else {
   //               if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
   //                   li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`; // +
   //                   if (page == data.current_page + 1 && data.current_page != 1) {
   //                       li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
   //                   }
   //               } else if (data.current_page == 1 && page == data.current_page + 2) {
   //                   li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
   //                   li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
   //               }else if (page == data.last_page - 1 || page == data.last_page) {
   //                   li += `<li class="page-item"><a class="page-link" href="`+ data.path+`/?page=`+page+`">`+page+`</a></li>`;
   //               }
   //           }
   //       }
   //   }

   //   STR += `
   //       <hr>
   //       <nav aria-label="Page navigation example">
   //           <ul class="pagination justify-content-end">
   //               <li class="page-item">
   //               <a class="page-link" aria-label="Previous" href="`+ data.prev_page_url +`">
   //                   <span aria-hidden="true">&laquo;</span>
   //                   <span class="sr-only">Previous</span>
   //               </a>
   //               </li>
   //               ${li}
   //               <li class="page-item">
   //               <a class="page-link" href="`+ data.next_page_url +`"  aria-label="Next">
   //                   <span aria-hidden="true">&raquo;</span>
   //                   <span class="sr-only">Next</span>
   //               </a>
   //               </li>
   //           </ul>
   //       </nav>`;

   //       if (data.total  > 8) {
   //         $('#alerts_course_not_free').html(STR);
   //       }


   // },

   // get_subjects_id : (id) => {
   //    ////////----------------------------------------------------- ค้นหา คอร์ส กลุ่มการศึกษา
   //   var lang = $('#current_lang').val();
   //   var study_group_text = (lang=='en')?'- Study group -':'- กลุ่มการศึกษา -';
   //   var subject_text = (lang=='en')?'- Subject -':'- รายวิชา -';

   //   var option = {
   //     course : $('#text_search').val(),
   //     study_group : (($("#get_study_group option:selected").text() == "- กลุ่มการศึกษา -") || ($("#get_study_group option:selected").text() == "- Study group -")) ? "":$("#get_study_group option:selected").val(),
   //     subjects : (($("#get_subjects option:selected").text() == "- กลุ่มการศึกษา -") || ($("#get_subjects option:selected").text() == "- Subject -")) ? "":$("#get_subjects option:selected").val(),
   //   }
   //   if ($("#check_course_free").last().hasClass( "active" ).toString() == "true" ) {
   //     course_free.search_course_free(option);
   //   }

   //   if ( $("#check_course_not_free").last().hasClass( "active" ).toString() == "true" ) {
   //     course_free.search_course_no_fre(option);
   //   }

   //    ////////----------------------------------------------------- ค้นหา คอร์ส กลุ่มการศึกษา
   //   $('#get_subjects').prop('disabled', false);
   //   $.ajax({
   //     url: window.location.origin + '/get_subjects',
   //     headers: {
   //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   //     },
   //     type: 'post',
   //     data: {
   //       'id': id,
   //     },
   //     dataType: "json",
   //     success: function(data) {
   //         var STR = '';
   //           STR += '<option value="">'+subject_text+'</option>';
   //           for (var subjects of data.results) {
   //             STR += '<option value="' + subjects.id + '">' + subjects.subject_name + '</option>';
   //           }
   //         $('#get_subjects').html(STR);
   //         ////////----------------------------------------------------- ค้นหา คอร์ส กลุ่มการศึกษา รายวิชา

   //           var option = {
   //             course : $('#text_search').val(),
   //             study_group : (($("#get_study_group option:selected").text() == "- กลุ่มการศึกษา -") || ($("#get_study_group option:selected").text() == "- Study group -")) ? "":$("#get_study_group option:selected").val(),
   //             subjects : (($("#get_subjects option:selected").text() == "- กลุ่มการศึกษา -") || ($("#get_subjects option:selected").text() == "- Subject -")) ? "":$("#get_subjects option:selected").val(),
   //           }

   //         ////////----------------------------------------------------- ค้นหา คอร์ส กลุ่มการศึกษา รายวิชา

   //     }
   //   });
   // },
}

$(function() {
   ////////----------------------------------------------------- ค้นหา คอร์ส
  var d = "";
  course_free.search_course_free(d);

  var lang = $('#current_lang').val();
  var study_group_text = (lang=='en')?'- Study group -':'- กลุ่มการศึกษา -';
  var subject_text = (lang=='en')?'- Subject -':'- รายวิชา -';

  // $("#text_search").keyup(function(){
  //   var query = {
  //     course : $(this).val(),
  //     study_group : (($("#get_study_group option:selected").text() == "- กลุ่มการศึกษา -") || ($("#get_study_group option:selected").text() == "- Study group -")) ? "":$("#get_study_group option:selected").val(),
  //     subjects : (($("#get_subjects option:selected").text() == "- กลุ่มการศึกษา -") || ($("#get_subjects option:selected").text() == "- Subject -")) ? "":$("#get_subjects option:selected").val(),
  //   }

  //   if ($("#check_course_free").last().hasClass( "active" ).toString() == "true" ) {
  //     course_free.search_course_free(query);
  //   }

  //   if ( $("#check_course_not_free").last().hasClass( "active" ).toString() == "true" ) {
  //     course_free.search_course_no_fre(query);
  //   }

  // });
   ////////----------------------------------------------------- ค้นหา คอร์ส

  //   if($(".nav-link .open_course_free").hasClass('active')) {
  //      $(".navigation_page_course_not_free").css("display", "none");
  //      $(".navigation_page_courseFree").css("display", "inline");
  //   }
  //   else {
  //     $(".navigation_page_courseFree").css("display", "none");
  //     $(".navigation_page_course_not_free").css("display", "inline");
  //   }

  // $(".open_course_free").click(function () {
  //   $(".course_not_free").css("display", "none");
  //   $(".course_free").css("display", "inline");

  //   $(".navigation_page_course_not_free").css("display", "none");
  //   $(".navigation_page_courseFree").css("display", "inline");

  //   $(".page_not_free").css("display", "none");
  //   $(".page_free").css("display", "inline");
  // });


  // $("#get_study_group").on('change',function () {
  //   // console.log(this.value);
  //   if (this.value == '') {
  //     $('#get_subjects').prop('disabled', true);
  //     $('#get_subjects').html('<option value="">'+subject_text+'</option>');
  //   }

  // });

  // $(".open_course_free").on('change',function () {

  //   $(".course_not_free").css("display", "none");
  //   $(".course_free").css("display", "inline");

  //   $(".navigation_page_courseFree").css("display", "inline");
  //   $(".navigation_page_course_not_free").css("display", "none");

  //   $(".page_free").css("display", "inline");
  //   $(".page_not_free").css("display", "none");

  //   var d = "";
  //   var query = {
  //     course : "",
  //     study_group : (($("#get_study_group option:selected").text() == "- กลุ่มการศึกษา -") || ($("#get_study_group option:selected").text() == "- Study group -")) ? "":$("#get_study_group option:selected").val(),
  //     subjects : (($("#get_subjects option:selected").text() == "- กลุ่มการศึกษา -") || ($("#get_subjects option:selected").text() == "- Subject -")) ? "":$("#get_subjects option:selected").val(),
  //   }
  //   if ( $("#check_course_free").last().hasClass( "active" ).toString() == "true" ) {
  //     course_free.search_course_free(query);
  //   }else {
  //     if (query.course != "" || query.study_group != "") {
  //       course_free.search_course_free(query);
  //     }else {
  //       course_free.search_course_free(d);
  //     }

  //   }
  //     // $("#text_search").keyup(function(){
  //     //   var query = $(this).val();
  //     //   course_free.search_course_free(query);
  //     // });
  // });


  // $(".open_course_not_free").click(function () {
  //   $(".course_free").css("display", "none");
  //   $(".course_not_free").css("display", "inline");

  //   $(".navigation_page_courseFree").css("display", "none");
  //   $(".navigation_page_course_not_free").css("display", "inline");

  //   $(".page_free").css("display", "none");
  //   $(".page_not_free").css("display", "inline");

  //   var d = "";
  //   var query = {
  //     course : "",
  //     study_group : (($("#get_study_group option:selected").text() == "- กลุ่มการศึกษา -") || ($("#get_study_group option:selected").text() == "- Study group -")) ? "":$("#get_study_group option:selected").val(),
  //     subjects : (($("#get_subjects option:selected").text() == "- กลุ่มการศึกษา -") || ($("#get_subjects option:selected").text() == "- Subject -")) ? "":$("#get_subjects option:selected").val(),
  //   }
  //   if ( $("#check_course_not_free").last().hasClass( "active" ).toString() == "true" ) {
  //     course_free.search_course_no_fre(query);
  //   }else {
  //     if (query.course != "" || query.study_group != "") {
  //       course_free.search_course_no_fre(query);
  //     }else {
  //       course_free.search_course_no_fre(d);
  //     }

  //   }
  //   // $("#text_search").keyup(function(){
  //   //   var query = $(this).val();
  //   //   course_free.search_course_no_fre(query);
  //   // });
  // });


  ////////------------------------ courset Free ---------------------------------------------------------------
    $(document).on('click', '.page_courseFree a', function(e){
      e.preventDefault();
      var page = $(this).attr('href').split('page=')[1];
      fetch_data_coursetFree(page);
     });


    function fetch_data_coursetFree(page) {
      $.ajax({
        url: "/get/Course_coursetFree",
        method:'post',
        data:{
            page: page,
            _token: $('input[name="_token"]').val()
        },
        success:function(data) {
          course_free.new_page(JSON.parse(data));
        },
      });
    }
    ////////---------------------- end courset Free-----------------------------------------------------------------

    ////////----------------------- courset No Free ----------------------------------------------------------------
      // $(document).on('click', '.page_course_not_free a', function(e){
      //   e.preventDefault();
      //   var page = $(this).attr('href').split('page=')[1];
      //   fetch_data(page);
      //  });

      // function fetch_data_courseNotFree(page) {
      //   $.ajax({
      //     url: "/get/Course_course_not_free",
      //     method:'POST',
      //     data:{
      //         page: page,
      //         _token: $('input[name="_token"]').val()
      //     },
      //     success:function(data) {
      //       course_free.new_page(JSON.parse(data));
      //     },
      //   });

      // }

    ////////---------------------- end courset No Free-----------------------------------------------------------------

    ////////---------------------------------------------------------------------------------------
    // $.ajax({
    //   url: window.location.origin + '/get_study_group',
    //   headers: {
    //     "X-CSRF-TOKEN": $('[name="_token"]').val()
    //   },
    //   type: 'get',
    //   dataType: "json",
    //   success: function(data) {

    //       var STR = '';
    //        STR += '<option value="">'+study_group_text+'</option>';
    //         for (var study of data.results) {
    //           STR += '<option value="' + study.id_aptitude + '">' + study.name + '</option>';
    //         }
    //         $('#get_study_group').html(STR);
    //         $('#get_subjects').prop('disabled', true);
    //         $('#get_subjects').html('<option value="">'+subject_text+'</option>');

    //   }
    // });
    ////////--------------------------------------------------------------------------------------

    ////////---------------------------------------------------------------------------------------


});
