function pagination(data, url, fnName="") {
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: window.location.origin + url,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            data: data,
            success: function(data) {
                $('#pagination').html(genPagination(data.paginator, fnName));
                resolve()
            }
        });

      }).then(function(){
          return true;
      })

}

function detaliteacher(detail) {
    var detail = Object.keys(detail).map(function(key) {
        return detail[key];
    });

    var lang = $('#current_lang').val();
    var coins_per_hour = (lang=='en')?'Coins/Hour':'Coins/ชั่วโมง';
    var detail_tip = (lang=='en')?'Detail':'รายละเอียด';

    STR = '<div class="row">';
    for (const data of detail) {
        let img = '/suksa/frontend/template/images/imgprofile_default.jpg';
        if (data.member_img) {
            img = '/storage/memberProfile/'+data.member_img;
        }
        // style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"
        STR += `
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card mb-3">
                    <div class="product-grid">
                        <a href="${window.location.origin}/members/detail/${data.member_id}" class="card-img-top">
                            <img width="100%" src="${window.location.origin}${img}" onerror="this.onerror=null;this.src='${window.location.origin}/suksa/frontend/template/images/icons/blank_image.jpg';" alt="" style="background-size: cover; height:350px; object-fit: cover">
                        </a>
                        <ul class="social">
                            <li><a href="${window.location.origin}/members/detail/${data.member_id}" data-tip="`+detail_tip+`"><i class="fa fa-search"></i></a></li>
                        </ul>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="font-weight-bold mb-2">${ data.member_name }</h5>
                        <h6 class="text-secondary mb-2"><span class="" style="color:#3990f2">${ (data.member_rate_start).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')} - ${ (data.member_rate_end).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') }</span> `+coins_per_hour+`</h6>
                    </div>
                </div>
            </div>`
    }
    STR += '</div>';
    return STR;
}

function teacherCourse(detail) {
    var lang = $('#current_lang').val();

    var detail = Object.keys(detail).map(function(key) {
        return detail[key];
    });
    students = detail;
    for (const data of detail) {
        let img = '/suksa/frontend/template/images/icons/imgprofile_default.jpg';
        if (data.course_img) {
            img = '/storage/course/'+data.course_img;
        }
        let course_price = (lang=='en')?'Free Course':'คอร์สเรียนฟรี';
        if (data.course_price) {
            course_price = data.course_price + ' Coins';
        }
        let aptitude_name = (lang=='en')?data.aptitude_name_en:data.aptitude_name_th; data.aptitude_name_th;
        let subject_name = (lang=='en')?data.subject_name_en:data.subject_name_th;

        let student_list = (lang=='en')?'Student list':'รายชื่อผู้เรียน';
        let see_list = '';

        if(lang=='en'){
            see_list = $('[name="teacher_id"]').val() == data.member_id && $('[name="user"]').val() == $('[name="teacher_id"]').val() ? 'View student list' : 'Student';
        }
        else{
            see_list = $('[name="teacher_id"]').val() == data.member_id && $('[name="user"]').val() == $('[name="teacher_id"]').val() ? 'ดูรายชื่อผู้เรียน' : 'ผู้เรียน';
        }
 
        let course_document = (lang=='en')?'Course Document':'ไฟล์เอกสารประกอบการสอน';
        let download_button = 'Download';
        let course_detail = (lang=='en')?'Detail':'รายละเอียด';

        // if (data.lang == 'en') {
        //     aptitude_name = data.aptitude_name_en;
        //     subject_name = data.subject_name_en;
        //     see_list = $('[name="teacher_id"]').val() == data.member_id ? 'Students List' : 'Students';
        //     student_list = 'List';
        //     course_document = 'Course Document';
        //     download_button = 'Download';
        //     course_detail = 'Detail';
        // }

        let student_status = data.student;
        let course_category = 'fa fa-globe';
        if (data.course_category == 'Private') {
            course_category = 'fa fa-lock';
            student_list = (lang=='en')?'Payment status':'ดูสถานะชำระเงิน';

            student_status = data.student.filter((student)=> student.student_status == 1)
        }
        let modal ='';

        if (data.student.length && $('[name="teacher_id"]').val() == data.member_id && $('[name="user"]').val() == $('[name="teacher_id"]').val()) {
            modal = `<a onclick="showStudent('${data.course_id}')" style="cursor: pointer; color: #3990F2; border-bottom: 1px solid #3990F2;">${student_list}</a>`
        }
        let download = '';
        let result = data.student.filter((student) => {  
            return student.student_id == data.student_id && student.student_status != '0';
        });

        if (data.course_file && result.length) {
            download = `<a href="${window.location.origin+'/storage/coursefile/'+data.course_file}" download style="color: #3990F2; border-bottom: 1px solid #3990F2;">${download_button}</a>`
        }else if (data.course_file && data.member_status == 'teacher' && data.member_id == data.teacher_id){
            download = `<a href="${window.location.origin+'/storage/coursefile/'+data.course_file}" download style="color: #3990F2; border-bottom: 1px solid #3990F2;">${download_button}</a>`
        }else if (data.course_file && data.teacher_id) {
            download = `<a href="${window.location.origin+'/storage/coursefile/'+data.course_file}" download style="color: #3990F2; border-bottom: 1px solid #3990F2;">${download_button}</a>`
        }

        STR += `
        <div class="row">
            <div class="col-sm-4">
                <img class="img-responsive" src="${window.location.origin}${img}" onerror="this.onerror=null;this.src='http://localhost:8000/suksa/frontend/template/images/icons/blank_image.jpg';" >
            </div>
            <div class="col-sm-5">
                <p class="fs-16 text-profile-noti overflow_course" >${data.course_name}</p>
                <p class="fs-16 header-noti">${(course_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')}</p>
                <p class="fs-16 header-noti">${aptitude_name}, ${subject_name}</p>
                <p class="fs-16 header-noti">
                    <i class="fa">&#xf073;</i>
                    ${data.date ? moment(data.date).format('DD/MM/Y')+', ' : ''} ${data.time_start} ${data.time_end ?  ' - '+data.time_end : ''}
                    ${data.date_start ? moment(data.date_start).format('DD/MM/Y') : ''} ${data.date_end ? '- '+moment(data.date_end).format('DD/MM/Y') : ''}
                </p>
                <p class="fs-16 header-noti">
                    <i class="${course_category}"></i> ${see_list} ${$('[name="teacher_id"]').val() == data.member_id && $('[name="user"]').val() == $('[name="teacher_id"]').val() ? student_status.length + '/'+ data.course_student_limit : student_status.length}
                    ${modal}
                </p>
                <p class="fs-16 header-noti">
                    <i class="fa fa-file"></i> ${course_document}
                    ${download}
                </p>
            </div>
            <div class="col-sm-3 text-right" style="align-self: center;">
                <a href="${window.location.origin+'/courses/'+data.course_id}" class="btn btn-outline-dark bo-rad-23" style="border-radius: 20px; font-size: 14px"> ${course_detail}</a>
            </div>
        </div>
        <hr> `;
    }

    return STR;
}

function profile () {
    window.location.assign('/')
}

function genPagination(data, fnName="") {
    STR = '';
    if (fnName == "detaliteacher") {
        STR += detaliteacher(data.data);
    }else if (fnName == 'teacherCourse') {
        STR += teacherCourse(data.data);
    }
    // STR += detaliCoins(data.data);
    let li = '';
    for (let page = 1; page <= data.last_page; page++) {
        if (page == data.current_page) {
            li += `<li class="page-item active"><a class="page-link">${page}</a></li>`;
        }else if(data.last_page < 7) {
            li += `<li class="page-item"><a class="page-link" onclick="search_page(${page})">${page}</a></li>`;
        }else{
            if ((data.last_page / 2) < data.current_page) {
                if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                    if (page == data.current_page - 1 && data.current_page != data.last_page) {
                        li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                    }
                    li += `<li class="page-item"><a class="page-link" onclick="search_page(${page})">${page}</a></li>`;
                } else if (data.current_page == data.last_page && page == data.current_page - 2) {
                    li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                    li += `<li class="page-item"><a class="page-link" onclick="search_page(${page})">${page}</a></li>`;
                }else if (page == 1 || page == 2) {
                    li += `<li class="page-item"><a class="page-link" onclick="search_page(${page})">${page}</a></li>`;
                }
            }else {
                if (page == data.current_page - 1 || page == data.current_page + 1 && page != data.current_page) {
                    li += `<li class="page-item"><a class="page-link" onclick="search_page(${page})">${page}</a></li>`;
                    if (page == data.current_page + 1 && data.current_page != 1) {
                        li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                    }
                } else if (data.current_page == 1 && page == data.current_page + 2) {
                    li += `<li class="page-item"><a class="page-link" onclick="search_page(${page})">${page}</a></li>`;
                    li += `<li class="page-item"><button type="submit" class="page-link">...</button></li>`;
                }else if (page == data.last_page - 1 || page == data.last_page) {
                    li += `<li class="page-item"><a class="page-link" onclick="search_page(${page})">${page}</a></li>`;
                }
            }
        }
    }

    let detail = data.data;
    detail = Object.keys(detail).map(function(key) {
        return detail[key];
    });

    if (detail.length) {
        STR += `
        <nav aria-label="Page navigation example" class="pb-4 mt-3">
            <ul class="pagination justify-content-end">
                <li class="page-item">
                <a class="page-link" aria-label="Previous" onclick=search_page(${data.current_page != 1 ? data.current_page - 1 : 1})>
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
                </li>
                ${li}
                <li class="page-item">
                <a class="page-link" onclick=search_page(${data.current_page != data.last_page ? data.current_page + 1 : data.last_page}) aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
                </li>
            </ul>
        </nav>`;
    }else if(fnName == "detaliteacher" && detail.length == 0) {
        let nodata = 'ไม่พบอาจารย์ผู้สอน';
        if ($('[name="lang"]').val() == 'en') {
            nodata = 'Teacher not found';
        }
        STR += `<h5 class="text-center bg-secondary text-white p-2">${nodata}</h5>`;
    }

    return STR;
}
