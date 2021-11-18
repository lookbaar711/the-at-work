
var request = {
  make_data_request : () => {

      var ck = "y";
      if ($("[name=study_now]:checked").val() == "") {
        ck = "n";
      }
      if ($("input[name$='day_study[]']").val() == "" && $('.study_now').val() == 2) {
        ck = "n";
      }
      if ($("input[name$='start_time']").val() == "" && $('.study_now').val() == 2) {
        ck = "n";
      }
      if ($( "#study_group" ).val() == "") {
        ck = "n";
      }
      if ($( "#topic" ).val() == "") {
        ck = "n";
      }
      if ($( "#subjects" ).val() == "") {
        ck = "n";
      }
      if ($( "#price_range" ).val() == "") {
        ck = "n";
      }


      if (ck != "y") {
        var lang_request = $('#lang_request').val();
        Swal.fire({
          type: 'warning',
          title: lang_request,
          confirmButtonText : 'ปิด'
        })
        // swal("หมายเหตุ", "กรุณาระบุข้อมูลให้ครบ", "warning");
      }else {
        if ($('.study_now:checked').val() == 2) {
          // var text_date = $("input[name='day_study[]']").val();
          var day_studys = $("input[name='day_study[]']").val();
          var start_times = $("#start_time").val();
        }else {
          var day_studys = moment(Date.now()).format('DD/MM/YYYY');
          var start_times = moment(Date.now()).format('HH:mm');
        }
        var member = '' ;
        if ($( "#data_members" ).val()) {
          member =  JSON.parse($( "#data_members" ).val());
        }


        request.data = {
          study_now : $("[name=study_now]:checked").val(),
          day_study : day_studys.split("/")[2]+'-'+day_studys.split("/")[1]+'-'+day_studys.split("/")[0],
          start_time : start_times,
          study_group : $( "#study_group option:selected" ).text(),
          study_group_id : $( "#study_group option:selected" ).val(),
          subjects : $( "#subjects option:selected" ).text(),
          subjects_id : $( "#subjects option:selected" ).val(),
          details_study : $('textarea#details_study').val(),
          price_range : $( "#price_range" ).val(),
          topic : $( "#topic" ).val(),
          member_id : member.member_id,
          member_fname : member.member_fname,
          member_lname : member.member_lname,

        }


        setTimeout(function() {
          $('#modal_request').modal('toggle');
        }, 100);

        setTimeout(function() {
          // console.log(request.data);
          $('#modal_request_2').modal('show');
        }, 500);

        if (request.data) {
          $(".study_now2").html(request.data.day_study == "-" ? "เรียนทันที":moment(request.data.day_study+" "+request.data.start_time).format('DD/MM/Y HH:mm'));
          $(".price_range2").html(request.data.price_range);
          $(".study_group2").html(request.data.study_group);
          $(".topic2").html(request.data.topic);
          $(".subjects2").html(request.data.subjects);
          $(".details_study2").html(request.data.details_study);
        }





      }
  },

  subjects : (id) => {
      $('#subjects').prop('disabled', false);

      $.ajax({
        url: window.location.origin + '/search_subjects/get_data',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        data: {
          'id': id,
        },
        dataType: "json",
        success: function(data) {
          // console.log(data);
            var lang = $('#current_lang').val();
            var select_subject = (lang=='en')?'- Select subject -':'- เลือกวิชา -';
            var STR = '';
              STR += '<option value="">'+ select_subject +'</option>';
              for (var subjects of data.results) {
                STR += '<option value="' + subjects.id + '">' + subjects.subject_name + '</option>';
              }
              $('#subjects').html(STR);

        }
      });

  },

  confirm_request : () => {
    var lang = $('#current_lang').val();
    var teacher_not_found = (lang=='en')?'Can\'t find teacher matching your request.':'ไม่พบผู้สอนที่ตรงตาม Request ของคุณ';
    var close_window = (lang=='en')?'Close':'ปิดหน้าต่าง';

    console.log( request.data);
    $("#modal_request_2").modal('toggle');
    Swal.fire({
        title: 'Loading..',
        timer: 5000,
        onBeforeOpen: () => {
          Swal.showLoading()
        },
      });

    $.ajax({
      url: window.location.origin + '/request',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      data: {
        'data': request.data,
      },
      dataType: "json",
      success: function(data) {
        if (data=="false") {
          Swal.fire({
            type: 'info',
            title: teacher_not_found,
            confirmButtonText : close_window
          })
        } else{
          // alert(data);
          location.href = 'request/'+data;
        }

      }
    });

  },

}

$(function() {

  $( "#disabled_request" ).click(function() {
    if ($('#subjects_request').val() == "") {
      var lang = $('#current_lang').val();
      var please_login = (lang=='en')?'Please Login':'กรุณาเข้าสู่ระบบ';
      var close_window = (lang=='en')?'Close':'ปิดหน้าต่าง';

      Swal.fire({
        type: 'info',
        title: please_login,
        confirmButtonColor: '#003D99',
        confirmButtonText : close_window
      })
    }
  });

  if ($("[name=study_now]:checked").val() == "1") {
    $('.time_study').prop('disabled', true);
    $('textarea#details_study').val("");
    $( "#price_range" ).val("");
  }else {
    $('.time_study').prop('disabled', false);
  }


  $( ".study_now" ).click(function() {
    if ($("[name=study_now]:checked").val() == "1") {
      var today = $( "#current_date" ).val();
      $('.time_study').prop('disabled', true);
      $( "#start_Date" ).val(today);
      $( "#start_time" ).val("");
    }

    if ($("[name=study_now]:checked").val() == "2") {
      $('.time_study').prop('disabled', false);
    }

  });


  $( "#request_subjects" ).click(function() {
     $("#modal_request").modal('show');
     $('textarea#details_study').val("");
     $( "#price_range" ).val("");
     $('.time_study').prop('disabled', true);
     $("input[name=study_now][value=1]").prop("checked", true);

     $.ajax({
       url: window.location.origin + '/search_study_group/',
       headers: {
         "X-CSRF-TOKEN": $('[name="_token"]').val()
       },
       type: 'get',
       dataType: "json",
       success: function(data) {
         // console.log(data);
            var lang = $('#current_lang').val();
            var select_group = (lang=='en')?'- Select study group -':'- เลือกกลุ่มการศึกษา -';
            var select_subject = (lang=='en')?'- Select subject -':'- เลือกวิชา -';

            var STR = '';
            STR += '<option value="">'+ select_group +'</option>';
             for (var study of data.results) {
               STR += '<option value="' + study.id_aptitude + '">' + study.name + '</option>';
             }
             $('#study_group').html(STR);
             $('#subjects').prop('disabled', true);
             $('#subjects').html('<option value="">'+ select_subject +'</option>');

       }
     });


  });





});
