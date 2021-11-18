var forgot_password = {
  check_mail:() => {
    $("#forgot_password" ).click(function() {
      $('#myModal').modal('hide');
      setTimeout(function () {
        $('#modal_forgot_password').modal('show');
        $("input[name$='email_forgot_password']").val("");
      }, 500);
    });



    $("#btn_post_forgot_password" ).click(function() {


      var email_forgot_password = $('#email_forgot_password').val();
      var text_swal = $('#text_swal').val();

      if (email_forgot_password == "") {
        Swal.fire({
            title: '<strong>'+text_swal+'</strong>',
            type: 'warning',
            imageHeight: 100,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonColor: '#003D99',
            confirmButtonText: close_window,
        });
      }else {
        $.ajax({
          url: window.location.origin + '/get_data/forgot_password/',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: {
            'data': email_forgot_password,
          },
          dataType: "json",
          success: function(data) {
            if (data.false) {
              Swal.fire({
                  title: '<strong>'+data.false+'</strong>',
                  type: 'warning',
                  imageHeight: 5000,
                  showCancelButton: false,
                  focusConfirm: false,
                  confirmButtonColor: '#003D99',
                  confirmButtonText: close_window,
              });
            }else {
              Swal.fire({
                  title: '<strong>'+data.success+'</strong>',
                  type: 'success',
                  imageHeight: 5000,
                  showCancelButton: false,
                  focusConfirm: false,
                  confirmButtonColor: '#003D99',
                  confirmButtonText: close_window,
              });

              setTimeout(function () {
                $('#modal_forgot_password').modal('hide');
              }, 500);
            }

          }
        });
      }
    });
  },

  check_password:() =>{

      $("#Current_password").keyup(function(){
        var dInput = this.value;
        console.log(dInput);
        $.ajax({
          url: window.location.origin + '/members/check_password_member/password_member/' +dInput ,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'get',
          dataType: "json",
          success: function(data) {

            if (data == true) {
              $("#check_password").val('1');
              $('.current_password_is_valid').removeClass('is-invalid');
              $('.current_password_is_valid').addClass('is-valid');
              //$('#btn_confirm_password').prop( "disabled", false );
              $('#btn_confirm_password').prop( "disabled", true );
              //$('#New_password').prop( "disabled", false );
              //$('#Confirm_password').prop( "disabled", false );


              $('.current_invalid').removeClass('invalid-feedback');
              $('.current_invalid').addClass('valid-feedback');
              $("input[name$='Confirm_password']").val()
              $('textalert').text($("input[name$='text_Confirm_password']").val());
            }

            if (data == false) {
              $("#check_password").val('0');
              $('.current_password_is_valid').addClass('is-invalid');
              $('#btn_confirm_password').prop( "disabled", true );
              //$('#New_password').prop( "disabled", true );
              //$('#Confirm_password').prop( "disabled", true );

              $('.current_invalid').addClass('invalid-feedback');

              $('textalert').text($("input[name$='text_Current_password']").val());
            }


          }
        });
      });

      $("#New_password").keyup(function(){
        var new_password = this.value;
        var confirm_password = $('#Confirm_password').val();

        if ((new_password == confirm_password) && ($("#check_password").val() == '1')){
          $('.confirm_password_is_valid').removeClass('is-invalid');
          $('.confirm_password_is_valid').addClass('is-valid');
          $('#btn_confirm_password').prop( "disabled", false );
        }else {
          $('.confirm_password_is_valid').addClass('is-invalid');
          $('#btn_confirm_password').prop( "disabled", true );
        }

      });

      $("#Confirm_password").keyup(function(){
        var confirm_password = this.value;
        var new_password = $('#New_password').val();

        if ((new_password == confirm_password) && ($("#check_password").val() == '1')){
          $('.confirm_password_is_valid').removeClass('is-invalid');
          $('.confirm_password_is_valid').addClass('is-valid');
          $('#btn_confirm_password').prop( "disabled", false );
        }else {
          $('.confirm_password_is_valid').addClass('is-invalid');
          $('#btn_confirm_password').prop( "disabled", true );
        }

      });

  },

  confirm_password:() =>{

    // console.log("1111");
    var data_ajax = {
      "input_current_password" : $("input[name$='Current_password']").val(),
      "input_new_password" : $("input[name$='New_password']").val(),
      "input_confirm_password" : $("input[name$='Confirm_password']").val(),
    };
    var input_current_password = $("input[name$='Current_password']").val();
    var input_new_password = $("input[name$='New_password']").val();
    var input_confirm_password = $("input[name$='Confirm_password']").val();
    var ck = "y" ;
    var text = "";

    if (input_current_password == "") {
      ck = "n";
      text = $("input[name$='text_Current_password']").val();
    }

    if (input_new_password == "") {
      ck = "n";
      text = $("input[name$='text_New_password']").val();
    }

    if (input_confirm_password == "") {
      ck = "n";
      text = $("input[name$='text_Confirm_password']").val();
    }

    if (ck == "n") {
      Swal.fire({
          title: '<strong>'+text+'</strong>',
          type: 'warning',
          imageHeight: 1000,
          showCancelButton: false,
          focusConfirm: false,
          confirmButtonColor: '#003D99',
          confirmButtonText: close_window,
      });
    }else {
      $.ajax({
          url: window.location.origin + '/members/update_password_member' ,
          method:"POST",
          data:{
              'data': data_ajax,
              _token: $('input[name="_token"]').val()
          },
          success:function(data){
              if (data.false) {
                Swal.fire({
                    title: '<strong>'+data.false+'</strong>',
                    type: 'warning',
                    imageHeight: 100,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonColor: '#003D99',
                    confirmButtonText: close_window,
                });
              }
              else {
                Swal.fire({
                    title: '<strong>'+data.success+'</strong>',
                    type: 'success',
                    imageHeight: 100,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonColor: '#003D99',
                    confirmButtonText: close_window,
                });

                $("input[name$='Current_password']").val(""),
                $("input[name$='New_password']").val(""),
                $("input[name$='Confirm_password']").val(""),

                $('#modal_change_password').modal('hide');

                setTimeout(function () {
                  //$('#modal_change_password').modal('hide');
                }, 500);

                setTimeout(function () {
                  location.reload();
                }, 2500);
              }
          }
      });

    }

  },

}



$(function() {
  forgot_password.check_mail();
  $(".btn_modal_change_password" ).click(function() {
    $('#modal_change_password').modal('show');
    forgot_password.check_password();
  });

});
