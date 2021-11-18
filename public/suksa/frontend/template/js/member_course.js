var members_course = {

  page_members_course:(data) => {
    $.ajax({
      url: window.location.origin + '/members/members_course',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
        'data': data,
        'id': $('#member_id').val(),
      },
      dataType: "json",
      success: function(data) {
        // console.log(data);
         members_course.get_new_page(data);
      }
    });
  },

  get_new_page:(data) => {
    // console.log(data);
      var member_course = '';
    $.each(data.course.data, function(key, value) {

      var course_img = `storage/course/`+value.course_img;

      var course_price = '';
      if(value.course_price){
        course_price = `<p class="notfree">`+value.course_price+` Coins</p>`;
      }else{
        course_price = `<p class="free">`+data.free_course+`</p>`;
      }

      var count_date = '';
        $.each(value.course_date, function(index, el) {
          if(index == 0){
            count_date = moment(value.course_date[0]['date']).format('DD/MM/Y');
          }else {
            count_date = moment(value.course_date[0]['date']).format('DD/MM/Y')+` - `+moment(value.course_date[index]['date']).format('DD/MM/Y');
          }
        });

        var student = '';
        if (value.student > 0) {
          student = value.student;
        }else {
          student = 0;
        }

        var register = '' ;
        if (value.course_file) {
          if (value.register) {
            register = `<p style=" color: black;"><i class="fa fa-file" style="font-size:16px;"></i>&nbsp;1 `+data.course_document+`<a style="color: #3990F2; border-bottom: 1px solid #3990F2;" href="`+value.course_file+`" download>`+data.download_button+`</a></p>`;
          }else {
            register = `<p style=" color: black;"><i class="fa fa-file" style="font-size:16px;"></i>&nbsp;1 `+data.course_document+`</p>`;
          }
        }


         member_course += `
         <div class="form-row">
             <div class="container">
               <div class="row">
                 <div class="col-sm-4">
                   <img src="`+ course_img +`" class="img-responsive" >
                 </div>
                 <div class="col-sm-4">
                   <p class="color7">`+value.course_name+`</p>
                   `+course_price+`

                   <p>`+value.course_group+` `+value.course_subject+`</p>

                   <label><i style="font-size:16px" class="fa">&#xf073;</i>&nbsp;
                    `+count_date+`
                   </label>
                   <p style=" color: black;"><i class="fa fa-users" style="font-size:16px;"></i>&nbsp;
                     `+student+`
                    </p>
                   `+register+`
                 </div>

               <div class="col-sm-4" style="align-self: center; text-align-last: right;">
                 <a href="'courses.show/`+value.id+`" class="btn btn-outline-dark  " style="border-radius: 20px; font-size: 14px">`+data.course_detail+`</a>
               </div>
             </div>
           </div>
         </div>
         <hr/>
           `;

    });
    $('#members_course').html(member_course);
   //

   var pagina = '';
     if (data.course.current_page == 1) {
       pagina += `<li class="page-item disabled"><span class="page-link"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></span></li>`;
     }else {
       pagina += `<li class="page-item"><a class="page-link" href="`+ data.course.prev_page_url +`"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></span></a></li>`;
     }

     for (var i = 1; i < data.course.last_page+1; i++) {
       if (i == data.course.current_page) {
         pagina += `<li class="page-item active"><span class="page-link">`+i+`<span class="sr-only">(current)</span></span></li>`;
       }else {
         pagina += `<li class="page-item"><a class="page-link" href="`+ data.course.path+`/?page=`+i+`">`+i+`</a></li>`;
       }
     }

     if (data.course.current_page == data.course.last_page) {
       pagina += `<li class="page-item disabled"><span class="page-link"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></span></li>`
     }else {
       pagina += `<li class="page-item"><a class="page-link" href="`+ data.course.next_page_url +`"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>`
     }

    $('#members_course_page_num').html(pagina);


    ///////---------------------------------------------------------------------

  },
}



$(function() {
  var d = "";
  $( ".members_course" ).click(function() {
    members_course.page_members_course(d);
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
});
