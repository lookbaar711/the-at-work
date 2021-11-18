
var members_all_data = {

  page_members_all_data : (data) => {
    $.ajax({
      url: window.location.origin +'/get_data/ged_all_instructors',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        'data': data,
      },
      dataType: "json",
      success: function(data) {
        // console.log(data);
         members_all_data.get_members_all_page(data);
      }
    });
  },

  get_members_all_page:(data) => {
    // console.log(data);
      var member_all = '';
    $.each(data.member.data, function(key, value) {
      var member_id_url = `<a href="`+window.location.origin+`/members/detail/`+value._id+`">`;

      var img = '';
      if (value.member_img) {
        img = `<img class="pic-1" src="`+window.location.origin+`/storage/memberProfile/`+value.member_img+`" style="background-size: cover; height:300px; object-fit: cover"></a>`;
      }else {
        img = `<img class="pic-1" src="`+window.location.origin+`/suksa/frontend/template/images/icons/blank_image.jpg" style="background-size: cover; height:300px; object-fit: cover"></a>`;
      }

         member_all += `
         <div class="col-md-3 col-sm-6">
     	        <div class="product-grid">

     	            <div class="product-image">
                      `+member_id_url+`
     	              	`+img+`
     	              	<ul class="social">
     	                  <li>
     	                    <a href="`+window.location.origin+`/members/detail/`+value._id+`" data-tip="`+data.teacher_detail+`><i class="fa fa-search"></i></a>
     	                  </li>
     	              	</ul>
     	            </div>

     	            <div class="product-content">
     	                <div class="title">
     	                    <a style="font-size: 14px;" href="`+window.location.origin+`/members/detail/`+value._id+`">`+value.member_rate_start+` - `+value.member_rate_end+` `+data.coins_per_hour+`</a>
     	                </div>
     	                <div class="title">
     	                    <a href="`+window.location.origin+`/members/detail/`+value._id+`">`+value.member_fname+` `+value.member_lname+`</a>
     	                </div>
     	                 <div class="title">
     	                    <a href="`+window.location.origin+`/members/detail/`+value._id+`">
     	                    
     	                    </a>
     	                </div>
     	            </div>

     	        </div>
     	    </div>

         <hr/>
           `;

    });
    $('#result').html(member_all);
   //

   var pagina = '';
     if (data.member.current_page == 1) {
       pagina += `<li class="page-item disabled"><span class="page-link"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></span></li>`;
     }else {
       pagina += `<li class="page-item"><a class="page-link" href="`+ data.member.prev_page_url +`"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></span></a></li>`;
     }

     for (var i = 1; i < data.member.last_page+1; i++) {
       if (i == data.member.current_page) {
         pagina += `<li class="page-item active"><span class="page-link">`+i+`<span class="sr-only">(current)</span></span></li>`;
       }else {
         pagina += `<li class="page-item"><a class="page-link" href="`+ data.member.path+`/?page=`+i+`">`+i+`</a></li>`;
       }
     }

     if (data.member.current_page == data.member.last_page) {
       pagina += `<li class="page-item disabled"><span class="page-link"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></span></li>`
     }else {
       pagina += `<li class="page-item"><a class="page-link" href="`+ data.member.next_page_url +`"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>`
     }

    $('#members_course_page_num').html(pagina);


    ///////---------------------------------------------------------------------

  },

  get_subjects_id_member : (id) => {
     ////////----------------------------------------------------- ค้นหา คอร์ส กลุ่มการศึกษา
    var option = {
      course : $('#text_search').val(),
      study_group : $("#get_study_group_member option:selected").text() == "- กลุ่มการศึกษา -" ? "":$("#get_study_group_member option:selected").text(),
      subjects : $("#get_subjects_member option:selected").text() == "- รายวิชา -" ? "":$("#get_subjects_member option:selected").text(),
    }
    members_all_data.page_members_all_data(option);
     ////////----------------------------------------------------- ค้นหา คอร์ส กลุ่มการศึกษา
    $('#get_subjects_member').prop('disabled', false);
    $.ajax({
      url: window.location.origin + '/get_subjects',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      data: {
        'id': id,
      },
      dataType: "json",
      success: function(data) {
          var STR = '';
            STR += '<option value="">- รายวิชา -</option>';
            for (var subjects of data.results) {
              STR += '<option value="' + subjects.id + '">' + subjects.subject_name + '</option>';
            }
          $('#get_subjects_member').html(STR);
          ////////----------------------------------------------------- ค้นหา คอร์ส กลุ่มการศึกษา รายวิชา
          $( "#get_subjects_member" ).click(function() {
            var option = {
              course : $('#text_search').val(),
              study_group : $("#get_study_group_member option:selected").text() == "- กลุ่มการศึกษา -" ? "":$("#get_study_group_member option:selected").text(),
              subjects : $("#get_subjects option:selected").text() == "- รายวิชา -" ? "":$("#get_subjects option:selected").text(),
            }

              members_all_data.page_members_all_data(option);
           });
          ////////----------------------------------------------------- ค้นหา คอร์ส กลุ่มการศึกษา รายวิชา

      }
    });
  },

}

$(function() {
  var d = "";
  members_all_data.page_members_all_data(d);
  $("#text_search").keyup(function(){
    var query = {
      course : $(this).val(),
      study_group : $("#get_study_group_member option:selected").text() == "- กลุ่มการศึกษา -" ? "":$("#get_study_group_member option:selected").text(),
      subjects : $("#get_subjects_member option:selected").text() == "- รายวิชา -" ? "":$("#get_subjects_member option:selected").text(),
    }
    members_all_data.page_members_all_data(query);
  });

    $(document).on('click', '.page_members_course a', function(e){
      e.preventDefault();
      var page = $(this).attr('href').split('page=')[1];
      fetch_data_member_all(page);
     });

    function fetch_data_member_all(page) {
      $.ajax({
        url: "/members/members_course",
        method:'post',
        data:{
            page: page,
            id: $('input[name="member_id"]').val(),
            _token: $('input[name="_token"]').val()
        },
        success:function(data) {
          // console.log(data);
          members_course.get_new_page(JSON.parse(data));
        },
      });
    }
    ////////--------------------------------------
    $.ajax({
      url: window.location.origin + '/get_study_group',
      headers: {
        "X-CSRF-TOKEN": $('[name="_token"]').val()
      },
      type: 'get',
      dataType: "json",
      success: function(data) {

          var STR = '';
           STR += '<option value="">- กลุ่มการศึกษา -</option>';
            for (var study of data.results) {
              STR += '<option value="' + study.id + '">' + study.name + '</option>';
            }
            $('#get_study_group_member').html(STR);
            $('#get_subjects_member').prop('disabled', true);
            $('#get_subjects_member').html('<option value="">- รายวิชา -</option>');

      }
    });
    ////////--------------------------------------

});
