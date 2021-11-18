<script>
    var close_window = '{{ trans('frontend/users/modal.close_window') }}';

    function show(course_name,subject,member_name,email,date,price){

        var course_name_text = '{{ trans('frontend/users/modal.course_name_text') }}';
        var teacher_fullname = '{{ trans('frontend/users/modal.teacher_fullname') }}';
        var course_date = '{{ trans('frontend/users/modal.course_date') }}';
        var course_price = '{{ trans('frontend/users/modal.course_price') }}';
        var date = JSON.parse(date);
        var date_time = '';

        for(i=0; i<date.length; i++){
            var d = new Date(date[i]['date']);
            var formatted_date = d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear()
            date_time += '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+formatted_date+', '+date[i]['time_start'].substring(0, 5)+'-'+date[i]['time_end'].substring(0, 5)+'</p>'+
                        '</div>';
        }

        if(parseInt(price)>0){
            price = price+' Coins';
        } else{
            price = 'Free';
        }
        Swal.fire({
          html:
            '<div class="grid">'+
                '<div class="row">'+
                    '<div class="col" align="left">'+
                        '<h4><b>รายละเอียด</b></h4><br>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+course_name_text+'</b> '+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+course_name+'</p>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+subject+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+teacher_fullname+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+member_name+'</p>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+email+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+course_date+'</b>'+
                    '</div>'+
                    date_time+
                '</div>'+
                '<hr>'+
                '<div class="row">'+
                    '<div class="col-sm-6" align="left">'+
                        '<b style="font-size:14px;">'+course_price+' (Coins)</b>'+
                    '</div>'+
                    '<div class="col-sm-6" align="right">'+
                        '<p style="font-size:14px;">'+price+'</p>'+
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
    }
    function detail_coins(event,date,time,bank,number,acc_number,coin_status,ref_name,description){

        var account_number = '{{ trans('frontend/users/modal.account_number') }}';
        var account_name = '{{ trans('frontend/users/modal.account_name') }}';
        var course_name_text = '{{ trans('frontend/users/modal.course_name_text') }}';
        var paid_amount = '{{ trans('frontend/users/modal.paid_amount') }}';
        var receive_amount = '{{ trans('frontend/users/modal.receive_amount') }}';

        var type = '';

        switch (event) {
          case 'topup_coins':
            type = "เติม";
            var status = paid_amount;

            var transaction_detail = '{{ trans('frontend/users/modal.topup_detail') }}';
            var transaction_date = '{{ trans('frontend/users/modal.topup_date') }}';
            var transaction_coins_number = '{{ trans('frontend/users/modal.topup_coins_number') }}';
            var topup_coins_status = '{{ trans('frontend/users/modal.topup_coins_status') }}';
            var approve_status = '{{ trans('frontend/users/modal.approve_status') }}';
            var not_approve_status = '{{ trans('frontend/users/modal.not_approve_status') }}';
            var waiting_status = '{{ trans('frontend/users/modal.waiting_status') }}';
            var because = '{{ trans('frontend/users/modal.because') }}';

            if(coin_status==1){
                var show_coins_status = approve_status;
            }
            else if(coin_status==2){
                var show_coins_status = not_approve_status;
            }
            else{
                var show_coins_status = waiting_status;
            }

            var show = '<div class="grid">'+
                '<div class="row">'+
                    '<div class="col" align="left">'+
                        '<h4><b>'+transaction_detail+'</b></h4><br>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+transaction_date+'</b> '+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+date+', '+time+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+account_name+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+bank+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+transaction_coins_number+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+number+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+status+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+number+'</p>'+
                    '</div>'+
                '</div>'+
                '<hr>'+

                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+topup_coins_status+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+show_coins_status+'</p>'+
                    '</div>'+
                '</div>';

            if(coin_status==2){
                show += '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+because+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+description+'</p>'+
                    '</div>'+
                '</div>';
            }

            show += '</div>';
            break;
          case 'withdraw_coins':
            type = "ถอน";
            var status = receive_amount;

            var transaction_detail = '{{ trans('frontend/users/modal.withdraw_detail') }}';
            var transaction_date = '{{ trans('frontend/users/modal.withdraw_date') }}';
            var transaction_coins_number = '{{ trans('frontend/users/modal.withdraw_coins_number') }}';
            var withdraw_coins_status = '{{ trans('frontend/users/modal.withdraw_coins_status') }}';
            var approve_status = '{{ trans('frontend/users/modal.approve_status') }}';
            var not_approve_status = '{{ trans('frontend/users/modal.not_approve_status') }}';
            var waiting_status = '{{ trans('frontend/users/modal.waiting_status') }}';
            var because = '{{ trans('frontend/users/modal.because') }}';

            if(coin_status==1){
                var show_coins_status = approve_status;
            }
            else if(coin_status==2){
                var show_coins_status = not_approve_status;
            }
            else{
                var show_coins_status = waiting_status;
            }

            var show = '<div class="grid">'+
                '<div class="row">'+
                    '<div class="col" align="left">'+
                        '<h4><b>'+transaction_detail+'</b></h4><br>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+transaction_date+'</b> '+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+date+', '+time+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+account_name+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+bank+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+account_number+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+acc_number+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+transaction_coins_number+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+number+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+status+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+number+'</p>'+
                    '</div>'+
                '</div>'+
                '<hr>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+withdraw_coins_status+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+show_coins_status+'</p>'+
                    '</div>'+
                '</div>';

            if(coin_status==2){
                show += '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+because+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+description+'</p>'+
                    '</div>'+
                '</div>';
            }

            show += '</div>';
            break;
          case 'pay_coins':
            type = "จ่าย";
            var transaction_detail = '{{ trans('frontend/users/modal.pay_detail') }}';
            var transaction_date = '{{ trans('frontend/users/modal.pay_date') }}';
            var transaction_coins_number = '{{ trans('frontend/users/modal.pay_coins_number') }}';

            var show = '<div class="grid">'+
                '<div class="row">'+
                    '<div class="col" align="left">'+
                        '<h4><b>'+transaction_detail+'</b></h4><br>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+transaction_date+'</b> '+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+date+', '+time+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+course_name_text+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+ref_name+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+transaction_coins_number+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+number+'</p>'+
                    '</div>'+
                '</div>'+
            '</div>';
            break;
          case 'get_coins':
            type = "รับ";
            var transaction_detail = '{{ trans('frontend/users/modal.get_detail') }}';
            var transaction_date = '{{ trans('frontend/users/modal.get_date') }}';
            var transaction_coins_number = '{{ trans('frontend/users/modal.get_coins_number') }}';

            var show = '<div class="grid">'+
                '<div class="row">'+
                    '<div class="col" align="left">'+
                        '<h4><b>'+transaction_detail+'</b></h4><br>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+transaction_date+'</b> '+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+date+', '+time+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+course_name_text+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+ref_name+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+transaction_coins_number+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+number+'</p>'+
                    '</div>'+
                '</div>'+
            '</div>';
            break;
          case 'return_coins':
            type = "คืน";
            var transaction_detail = '{{ trans('frontend/users/modal.return_detail') }}';
            var transaction_date = '{{ trans('frontend/users/modal.return_date') }}';
            var transaction_coins_number = '{{ trans('frontend/users/modal.return_coins_number') }}';

            var show = '<div class="grid">'+
                '<div class="row">'+
                    '<div class="col" align="left">'+
                        '<h4><b>'+transaction_detail+'</b></h4><br>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+transaction_date+'</b> '+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+date+', '+time+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+course_name_text+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+ref_name+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+transaction_coins_number+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+number+'</p>'+
                    '</div>'+
                '</div>'+
            '</div>';
            break;
          default:
          // deduct_coins
            type = "หัก";
            var transaction_detail = '{{ trans('frontend/users/modal.deduct_detail') }}';
            var transaction_date = '{{ trans('frontend/users/modal.deduct_date') }}';
            var transaction_coins_number = '{{ trans('frontend/users/modal.deduct_coins_number') }}';

            var show = '<div class="grid">'+
                '<div class="row">'+
                    '<div class="col" align="left">'+
                        '<h4><b>'+transaction_detail+'</b></h4><br>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+transaction_date+'</b> '+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+date+', '+time+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+course_name_text+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+ref_name+'</p>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-sm-12" align="left">'+
                        '<b style="font-size:14px;">'+transaction_coins_number+'</b>'+
                    '</div>'+
                    '<div class="col-sm-12" align="left">'+
                        '<p style="font-size:14px;">'+number+'</p>'+
                    '</div>'+
                '</div>'+
            '</div>';
        }


        Swal.fire({
          html: show,
        //   showCloseButton: false,
          showCancelButton: false,
          focusConfirm: false,
          confirmButtonColor: '#003D99',
          showConfirmButton: true,
          confirmButtonText: close_window,
        })
    }
    function register_course_student(course_name, teacher, date){

        var course_register_detail = '{{ trans('frontend/users/modal.course_register_detail') }}';
        var course_name_text = '{{ trans('frontend/users/modal.course_name_text') }}';
        var teacher_fullname = '{{ trans('frontend/users/modal.teacher_fullname') }}';
        var course_date = '{{ trans('frontend/users/modal.course_date') }}';
        // var date = JSON.parse(date);
        // var date_time = '';

        // for(i=0; i<date.length; i++){
        //     var d = new Date(date[i]['classroom_date']);
        //     var formatted_date = d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear()
        //     date_time += '<div class="col-sm-12" align="left">'+
        //                     '<p style="font-size:14px;">'+formatted_date+', '+date[i]['classroom_time_start'].substring(0, 5)+'-'+date[i]['classroom_time_end'].substring(0, 5)+'</p>'+
        //                 '</div>';
        // }
        // console.log(date_time);
        Swal.fire({
              html:
                '<div class="grid">'+
                    '<div class="row">'+
                        '<div class="col" align="left">'+
                            '<h4><b>'+course_register_detail+'</b></h4><br>'+
                        '</div>'+
                    '</div>'+
                    '<hr>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+course_name_text+'</b> '+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+course_name+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+teacher_fullname+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+teacher+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+course_date+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+date+'</p>'+
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
    }
    function open_course_student(course_name, teacher,  date, date_noti , price){

        var close_to_study_time = '{{ trans('frontend/users/modal.close_to_study_time') }}';
        var from = '{{ trans('frontend/users/modal.from') }}';
        var course_onlone = '{{ trans('frontend/users/modal.course_onlone') }}';
        var course_name_text = '{{ trans('frontend/users/modal.course_name_text') }}';
        var teacher_fullname = '{{ trans('frontend/users/modal.teacher_fullname') }}';
        var course_date = '{{ trans('frontend/users/modal.course_date') }}';
        var total_coins = '{{ trans('frontend/users/modal.total_coins') }}';

        if(parseInt(price)>0){
            price = price+' Coins';
        }else{
            price = "Free";
        }
        Swal.fire({
              html:
                '<div class="grid">'+
                    '<div class="row">'+
                        '<div class="col" align="left">'+
                            '<h4><b>'+close_to_study_time+'</b></h4>'+
                            '<p>'+date_noti+'</b></p>'+
                        '</div>'+
                    '</div>'+
                    '<hr>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+from+'</b> '+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+course_onlone+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+course_name_text+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+course_name+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+teacher_fullname+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+teacher+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+total_coins+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+price+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+course_date+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+date+'</p>'+
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
    }
    function open_course_teacher(course_name, date, date_noti){

        var close_to_teach_time = '{{ trans('frontend/users/modal.close_to_teach_time') }}';
        var from = '{{ trans('frontend/users/modal.from') }}';
        var course_onlone = '{{ trans('frontend/users/modal.course_onlone') }}';
        var course_name_text = '{{ trans('frontend/users/modal.course_name_text') }}';
        var teacher_fullname = '{{ trans('frontend/users/modal.teacher_fullname') }}';
        var course_date = '{{ trans('frontend/users/modal.course_date') }}';
        var total_coins = '{{ trans('frontend/users/modal.total_coins') }}';

        Swal.fire({
              html:
                '<div class="grid">'+
                    '<div class="row">'+
                        '<div class="col" align="left">'+
                            '<h4><b>'+close_to_teach_time+'</b></h4>'+
                            '<p>'+date_noti+'</b></p>'+
                        '</div>'+
                    '</div>'+
                    '<hr>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+from+'</b> '+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+course_onlone+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+course_name_text+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+course_name+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+course_date+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+date+'</p>'+
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
    }
    function register_course_teacher(course_name, student, date_noti, date){

        var someone_register = '{{ trans('frontend/users/modal.someone_register') }}';
        var from = '{{ trans('frontend/users/modal.from') }}';
        var course_onlone = '{{ trans('frontend/users/modal.course_onlone') }}';
        var course_name_text = '{{ trans('frontend/users/modal.course_name_text') }}';
        var student_fullname = '{{ trans('frontend/users/modal.student_fullname') }}';
        var course_date = '{{ trans('frontend/users/modal.course_date') }}';

        var date = JSON.parse(date);
        var date_time = '';

        for(i=0; i<date.length; i++){
            var d = new Date(date[i]['classroom_date']);
            var formatted_date = d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear()
            date_time += '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+formatted_date+', '+date[i]['classroom_time_start'].substring(0, 5)+'-'+date[i]['classroom_time_end'].substring(0, 5)+'</p>'+
                        '</div>';
        }
        Swal.fire({
              html:
                '<div class="grid">'+
                    '<div class="row">'+
                        '<div class="col" align="left">'+
                            '<h4><b>'+someone_register+'</b></h4>'+
                            '<p>'+date_noti+'</b></p>'+
                        '</div>'+
                    '</div>'+
                    '<hr>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+from+'</b> '+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+course_onlone+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+course_name_text+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+course_name+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+student_fullname+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+student+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+course_date+'</b>'+
                        '</div>'+
                        date_time+
                    '</div>'+
                '</div>',
            //   showCloseButton: false,
              showCancelButton: false,
              focusConfirm: false,
              confirmButtonColor: '#003D99',
              showConfirmButton: true,
              confirmButtonText: close_window,
        })
    }
    function approve_topup_coins(type, coins, date, date_noti){


        if(type=='สำเร็จ' || type=='confirm'){
            var topup_status = '{{ trans('frontend/users/modal.topup_success') }}';
        }
        else{
            var topup_status = '{{ trans('frontend/users/modal.topup_failed') }}';
        }

        var topup_date = '{{ trans('frontend/users/modal.topup_date') }}';
        var account_number = '{{ trans('frontend/users/modal.account_number') }}';
        var topup_number = '{{ trans('frontend/users/modal.topup_number') }}';
        var paid_number = '{{ trans('frontend/users/modal.paid_number') }}';

        Swal.fire({
              html:
                '<div class="grid">'+
                    '<div class="row">'+
                        '<div class="col" align="left">'+
                            '<h4><b>'+topup_status+'</b></h4>'+
                            '<p>'+date_noti+'</b></p>'+
                        '</div>'+
                    '</div>'+
                    '<hr>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+topup_date+'</b> '+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+date+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+account_number+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">-</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+topup_number+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+coins+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+paid_number+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+coins+'</p>'+
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
    }
    function approve_withdraw_coins(type, coins, date, date_noti){

        if(type=='1'){
            var withdraw_status = '{{ trans('frontend/users/modal.withdraw_success') }}';
        }
        else{
            var withdraw_status = '{{ trans('frontend/users/modal.withdraw_failed') }}';
        }

        var withdraw_date = '{{ trans('frontend/users/modal.withdraw_date') }}';
        var account_number = '{{ trans('frontend/users/modal.account_number') }}';
        var withdraw_number = '{{ trans('frontend/users/modal.withdraw_number') }}';
        var receive_number = '{{ trans('frontend/users/modal.receive_number') }}';

        Swal.fire({
              html:
                '<div class="grid">'+
                    '<div class="row">'+
                        '<div class="col" align="left">'+
                            '<h4><b>'+withdraw_status+'</b></h4>'+
                            '<p>'+date_noti+'</b></p>'+
                        '</div>'+
                    '</div>'+
                    '<hr>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+withdraw_date+'</b> '+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+date+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+account_number+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">-</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+withdraw_number+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+coins+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-12" align="left">'+
                            '<b style="font-size:14px;">'+receive_number+'</b>'+
                        '</div>'+
                        '<div class="col-sm-12" align="left">'+
                            '<p style="font-size:14px;">'+coins+'</p>'+
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
    }
</script>
