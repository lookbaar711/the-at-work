// เพิ่มแถวและลบ 1 input ++
$(function() {
    $(document).on('click', '.btn-add', function(e) {
        var txt1 = $('#member_HJPl').val();
        var txt2 = $('#member_HJPo').val();
        var txt3 = $('#member_HJExp').val();
        var current_lang = $('#current_lang').val();
        var remove_text = (current_lang=='en')?'Remove':'ลบ';
        var please_enter_all_field = (current_lang=='en')?'Please enter all require field.':'กรุณากรอกข้อมูลให้ครบ';

        if(txt1=='' || txt2=='' || txt3==''){
            Swal.fire({
              type: 'error',
              title: please_enter_all_field,
              //text: 'Something went wrong!',
            })
            return false;
        }else{
        e.preventDefault();
        var controlForm = $('#myRepeatingFields'),
            currentEntry = $(this).parents('.entry:first');

        $(currentEntry.clone()).appendTo(controlForm);
        currentEntry.find('input').val('');
        controlForm.find('.entry:not(:first) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html(remove_text);
    }}).on('click', '.btn-remove', function(e) {
        e.preventDefault();
        $(this).parents('.entry:first').remove();
        return false;
    });

    // เพิ่มแถวและลบ 2 input ++
    $(document).on('click', '.btn-add2', function(e) {
        var txt1 = $('#member_cong').val();
        var current_lang = $('#current_lang').val();
        var remove_text = (current_lang=='en')?'Remove':'ลบ';
        var please_enter_all_field = (current_lang=='en')?'Please enter all require field.':'กรุณากรอกข้อมูลให้ครบ';

        if(txt1=='' ){
            Swal.fire({
              type: 'error',
              title: please_enter_all_field,
              //text: 'Something went wrong!',
            })
            return false;
        }else{
        e.preventDefault();
        var controlForm = $('#myRepeatingFields2:first'),
            currentEntry = $(this).parents('.entry:first');

        $(currentEntry.clone()).appendTo(controlForm);
        currentEntry.find('input').val('');

        controlForm.find('.entry:not(:first) .btn-add2')
            .removeClass('btn-add2').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html(remove_text);
    }}).on('click', '.btn-remove2 ', function(e) {
        e.preventDefault();
        $(this).parents('.entry:first').remove();

        return false;
    });
});

// เช็คแล้วเปิด Textbox
$('#member_education1').change(function() {
    $("#member_institution1").prop("disabled", !$(this).is(':checked'));
});
$('#member_education2').change(function() {
    $("#member_major2").prop("disabled", !$(this).is(':checked'));
    $("#member_institution2").prop("disabled", !$(this).is(':checked'));
});
$('#member_education3').change(function() {
    $("#member_major3").prop("disabled", !$(this).is(':checked'));
    $("#member_institution3").prop("disabled", !$(this).is(':checked'));
});
$('#member_education4').change(function() {
    $("#member_major4").prop("disabled", !$(this).is(':checked'));
    $("#member_institution4").prop("disabled", !$(this).is(':checked'));
});


//alert( $('#wizardProfile').bootstrapWizard('currentIndex') );

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href");

    if(target == "#tab6"){
        //alert(target);

        //ถ้ามีการเลือกวิชาอย่างน้อย 1 วิชา ให้แสดงปุ่ม ถัดไป ให้สามารถกดได้
        if($('.subject-checkbox:checked').length > 0){
            $('#btnSubmit').prop('disabled', false);
        }
        //ถ้าไม่มีการเลือกวิชาเลย ให้ disabled ปุ่ม ถัดไป ให้ไม่สามารถกดได้
        else{
            $('#btnSubmit').prop('disabled', true);
        }

        //$('#btnSubmit').prop('disabled', true);
    }
    else{
        $('#btnSubmit').prop('disabled', false);
    }
});


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
            if($('.other-check-'+data_index).prop("checked") == true){
                //alert('select other');
                $('#other'+data_index).removeClass("in");
            }

            //เซ็ตค่าการไม่เลือกกลุ่มวิชาให้เป็นค่า default
            $(this).attr('data-select','0');

            //เซ็ตค่าวิชาทุกตัวที่เลือกให้เป็นค่าว่าง
            $('.sub-check-'+data_index+':checked').prop('checked', false);

            //ถ้ามีการเลือกวิชาอย่างน้อย 1 วิชา ให้แสดงปุ่ม ถัดไป ให้สามารถกดได้
            if($('.subject-checkbox:checked').length > 0){
                $('#btnSubmit').prop('disabled', false);
            }
            //ถ้าไม่มีการเลือกวิชาเลย ให้ disabled ปุ่ม ถัดไป ให้ไม่สามารถกดได้
            else{
                $('#btnSubmit').prop('disabled', true);
            }
        }
    });


    $('.subject-checkbox').click(function(){
        //ถ้ามีการเลือกวิชาอย่างน้อย 1 วิชา ให้แสดงปุ่ม ถัดไป ให้สามารถกดได้
        if($('.subject-checkbox:checked').length > 0){
            $('#btnSubmit').prop('disabled', false);
        }
        //ถ้าไม่มีการเลือกวิชาเลย ให้ disabled ปุ่ม ถัดไป ให้ไม่สามารถกดได้
        else{
            $('#btnSubmit').prop('disabled', true);
        }
    });
});


// เตือนรหัสผ่าน
// function Validate() {
//     var password = document.getElementById("member_password").value;
//     var confirmPassword = document.getElementById("password_confirmation").value;
//     if (password != confirmPassword) {
//         swal("รหัสผ่านไม่ตรง!", "กรอกรหัสผ่านอีกครั้ง", "warning");
//         // return false;
//     }
//     return true;
// }

// sweetalert
// function Validate2() {
//     var emailtxt = $("#inputGroupFile01").val();
//     if ($("#inputGroupFile01").val() == "" && $("#inputGroupFile02").val() == "" && $("#inputGroupFile03").val() == "" && $("#inputGroupFile04").val() == "") {
//         Swal.fire(
//             'กรุณาเลือกไฟล์' + emailtxt,
//             'question'
//         )
//     } else {
//         let timerInterval
//         Swal.fire({
//             title: 'กำลังทำการบันทึกข้อมูล!',
//             timer: 5000,
//             onBeforeOpen: () => {
//                 Swal.showLoading()
//                 timerInterval = setInterval(() => {
//                     Swal.getContent().querySelector('strong')
//                         .textContent = Swal.getTimerLeft()
//                 }, 100)
//             },
//             onClose: () => {
//                 clearInterval(timerInterval)
//             }
//         }).then((result) => {
//             if (
//                 /* Read more about handling dismissals below */
//                 result.dismiss === Swal.DismissReason.timer
//             ) {
//                 console.log('I was closed by the timer')
//             }
//         })
//     }
// }

function checkTextOnly(field_id) {
    var regex = /\d+/g;
    var string = $('#'+field_id).val();
    var matches = string.match(regex);  // creates array from matches
    var current_lang = $('#current_lang').val();
    var please_enter_text_only = (current_lang=='en')?'Please enter text only.':'กรุณากรอกตัวอักษรเท่านั้น';

    if(matches!=null){ //number
        $('#'+field_id).val('');
        $('#warning_text_'+field_id).text(please_enter_text_only);
        return false;
    }
    else{
        if(!isNaN(string)){ //number
            $('#'+field_id).val('');
            $('#warning_text_'+field_id).text(please_enter_text_only);
            return false;
        }
    }
    $('#warning_text_'+field_id).text('');
    return true;
}

function checkNumberOnly(field_id) {
    var regex = /\d+/g;
    var string = $('#'+field_id).val();
    var matches = string.match(regex);  // creates array from matches
    var current_lang = $('#current_lang').val();
    var please_enter_number_only = (current_lang=='en')?'Please enter number only.':'กรุณากรอกตัวเลขเท่านั้น';

    if(matches==null){ //not number
        $('#'+field_id).val('');

        if((field_id!='member_idCard') || (field_id!='member_rate_start') || (field_id!='member_rate_end')){
            $('#warning_text_'+field_id).text(please_enter_number_only);
        }

        return false;
    }
    else{
        if(isNaN(string)){ //not number
            $('#'+field_id).val('');

            if((field_id!='member_idCard') || (field_id!='member_rate_start') || (field_id!='member_rate_end')){
                $('#warning_text_'+field_id).text(please_enter_number_only);
            }
            return false;
        }
    }
    $('#warning_text_'+field_id).text('');
    return true;
}

// จำกัดการป้อน
function isNumber(evt) {
    if(evt==''){
        return false;
    }
    else{
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if(charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
}

function not_number(evt) {
    if(evt==''){
        return false;
    }
    else{
        if(window.event) { // IE
            keynum = evt.keyCode;
        }
        else if(evt.which) { // Netscape/Firefox/Opera
            keynum = evt.which;
        }

        alert(keynum);

        if((keynum == 13 || keynum == 110) && (keynum > 48) || (keynum < 59)) {
            return false;
        }
        return true;
    }
}

$(document).keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        return false;
    }
});

$(document).ready(function() {
    $("#member_email").keyup(checkEmail);
    $("#password_confirmation").keyup(checkPasswordMatch);
    $("#member_password").keyup(checkPasswordMatch);
});

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

var email = [];
function checkEmail() {
    var emailtxt = $("#member_email").val();
    var current_lang = $('#current_lang').val();
    var already_email_text = (current_lang=='en')?'Already E-mail':'อีเมลซ้ำ!';
    var email_invalid_format = (current_lang=='en')?'E-mail is invalid':'อีเมลไม่ถูกต้อง';

    if(validateEmail(emailtxt)) {
        $.ajax({
            method: 'GET',
            url: "checkEmail",
            dataType: 'json',
            //async: false,
            success: function(data) {
                email = data;

                //console.log(email);
                const result = email.find(fruit => fruit.member_email === emailtxt);
                //console.log(result);
                if(result) {
                    $("#divCheckEmail").html(already_email_text).css('color', 'red');
                    //console.log('email ซ้ำ');
                    $('#btnSubmit').prop('disabled', true);
                    return false;
                }
                else {
                    $("#divCheckEmail").html(" ").css('color', 'red');
                    //console.log('email ไม่ซ้ำ');
                    if(checkPasswordMatch() == 1){
                        $('#btnSubmit').prop('disabled', false);
                        return true;
                    }
                }

                $('#btnSubmit').prop('disabled', true);
                return false;
            },
            error: function(data) {
                //error
            }
        });
    }
    else {
        $("#divCheckEmail").html(email_invalid_format).css('color', 'red');
        //console.log('email ไม่ถูก format');
        $('#btnSubmit').prop('disabled', true);
        return false;
    }
}

function checkfullname() {
    var fname = $("#member_fname").val();
    var lname = $("#member_lname").val();
    var current_lang = $("#current_lang").val();
    var already_name_text = (current_lang=='en')?'name and lastname Someone is already using it':'ชื่อ-นามสกุลนี้มีคนใช้แล้ว';

    $.ajax({
        url: "checkFullname",
        method:'POST',
        data:{
            fname : fname,
            lname : lname,
            _token: $('input[name="_token"]').val()
        },
        success:function(data) {
            if(data == 'false'){
                $('#checkname').attr('datacheck','1');
                $('#onsubmit').prop('disabled', true);
                $('#btnSubmit').prop('disabled', true);
                $('#warning_text_member_fullname').text(already_name_text);
                // $('#warning_text_member_lname').text(already_name_text);
                return false;
            }else{
                $('#checkname').attr('datacheck','0');
                $('#warning_text_member_fullname').text('');
                $('#btnSubmit').prop('disabled', false);
                $('#onsubmit').prop('disabled', false);
                return true;
            }
        },
        error: function(data) {
            //error
        }
    });
}

function checkPasswordMatch() {
    var password = $("#member_password").val();
    var confirmPassword = $("#password_confirmation").val();
    var emailtxt = $("#member_email").val();

    var correct_password = $("#correct_password").val();
    var incorrect_password = $("#incorrect_password").val();

    const result = email.find(fruit => fruit.member_email === emailtxt);
    //console.log(confirmPassword);

    if(password != confirmPassword) {
        if (confirmPassword.length > 0) {
            $("#divCheckPasswordMatch").html(incorrect_password).css('color', 'red');
        }
        $('#btnSubmit').prop('disabled', true);
        return 0;
    }
    else {
        if(confirmPassword.length > 0) {
            $("#divCheckPasswordMatch").html(correct_password).css('color', 'green');

            if(validateEmail(emailtxt)) {
                if(!result) {
                    $('#btnSubmit').prop('disabled', false);
                }
                return 1;
            }
            else {
                $('#btnSubmit').prop('disabled', true);
                return 0;
            }
        }
    }
}

function checkMemberRate() {
    var rate_start = $("#member_rate_start").val();
    var rate_end = $("#member_rate_end").val();
    var current_lang = $('#current_lang').val();
    var please_enter_correct_rate = (current_lang=='en')?'Please enter the correct price range.':'กรุณากรอกช่วงราคาให้ถูกต้อง';
    var check_rate = rate_start-rate_end;

    if(check_rate >= 0){
        //alert(please_enter_correct_rate);

        $('#warning_text_member_rate_end').text(please_enter_correct_rate);
        $('#btnSubmit').prop('disabled', true);
        return false;
    }
    else{
        //alert('OK');

        $('#warning_text_member_rate_end').text('');
        $('#btnSubmit').prop('disabled', false);
        return true;
    }
}


// ล็อคปุ่ม
function success() {
    if (document.getElementById("textsend").value === "") {
        document.getElementById('btnSubmit').disabled = true;
    } else {
        document.getElementById('btnSubmit').disabled = false;
    }
}


// ----------------------------------------------------------------------------------------------------------------
$('#inputGroupFile02').on('change', function() {
    //get the file name
    var fileName = $(this).val();

    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName).css('color', 'green');

})
$('#inputGroupFile03').on('change', function() {
    //get the file name
    var fileName = $(this).val();

    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName).css('color', 'green');
})
$('#inputGroupFile04').on('change', function() {
    //get the file name
    var fileName = $(this).val();

    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName).css('color', 'green');
})
$('#inputGroupFile05').on('change', function() {
    //get the file name
    var fileName = $(this).val();

    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName).css('color', 'green');
})

// ------------------------------------------------------------------------------//s
// ------------------------------------------------------------------------------//


// var selDiv = "";

// //document.addEventListener("DOMContentLoaded", init, false);

// function init() {
//     //document.querySelector('#files').addEventListener('change', handleFileSelect, false);
//     //selDiv = document.querySelector("#selectedFiles");
// }

function handleFileSelect(e) {

    if (!e.target.files) return;

    selDiv.innerHTML = "";

    var files = e.target.files;
    for (var i = 0; i < files.length; i++) {
        var f = files[i];

        selDiv.innerHTML += f.name + "<br/>";

    }

}




// -------------------------------------------------------------------------------

$('#inputGroupFile02').on('change', function() {
    //get the file name
    var fileName = $(this).val();

    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName).css('color', 'green');

})
$('#inputGroupFile03').on('change', function() {
    //get the file name
    var fileName = $(this).val();

    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName).css('color', 'green'); //เปลี่ยนสีtext
})
$('#inputGroupFile04').on('change', function() {
    //get the file name
    var fileName = $(this).val();

    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName).css('color', 'green');
})
$('#inputGroupFile05').on('change', function() {
    //get the file name
    var fileName = $(this).val();

    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName).css('color', 'green');
})

// ------------------------------------------------------------------------------//


$.fn.fileUploader = function(filesToUpload, sectionIdentifier) {
    var fileIdCounter = 0;
    var current_lang = $('#current_lang').val();
    var remove_text = (current_lang=='en')?'Remove':'ลบ';

    this.closest(".files").change(function(evt) {
        var output = [];

        for (var i = 0; i < evt.target.files.length; i++) {
            fileIdCounter++;
            var file = evt.target.files[i];
            var fileId = sectionIdentifier + fileIdCounter;

            var image_size_over_text_1 = (current_lang=='en')?'Please select image with ':'กรุณาเลือกรูปที่มีขนาดไฟล์';
            var image_size_over_text_2 = (current_lang=='en')?'file size less than 10 mb.':'น้อยกกว่า 10 mb';

            console.log(filesToUpload);
            if (file.size / 1024 / 1024 > 10) {
                Swal.fire({
                    // title: "กรุณาเลือกรูปที่มีขนาดไฟลน้อยกกว่า 2 mb!",
                    html: image_size_over_text_1+'<br>'+image_size_over_text_2,
                    type: 'warning',
                    confirmButtonColor: "#569c37",

                })
            } else {
                filesToUpload.push({
                    id: fileId,
                    file: file
                });
            var removeLink = "<a class=\"removeFile\ href=\"#\" data-fileid=\"" + fileId + "\">"+remove_text+"</a>";
            // var file = "<input type=\"text\" name=\"fileUp[]\" value=\"c:\\fakepath\\" + file.name + "\"/>";
            output.push("<li><strong>", escape(file.name), "</strong> - ", file.size, " bytes. &nbsp; &nbsp; ", removeLink, "</li> ");
        }
        };

        $(this).children(".fileList")
            .append(output.join(""));

        //reset the input to null - nice little chrome bug!
        evt.target.value = null;
    });

    $(this).on("click", ".removeFile", function(e) {
        e.preventDefault();

        var fileId = $(this).parent().children("a").data("fileid");

        // loop through the files array and check if the name of that file matches FileName
        // and get the index of the match
        for (var i = 0; i < filesToUpload.length; ++i) {
            if (filesToUpload[i].id === fileId)
                filesToUpload.splice(i, 1);
        }

        $(this).parent().remove();
    });

    this.clear = function() {
        for (var i = 0; i < filesToUpload.length; ++i) {
            if (filesToUpload[i].id.indexOf(sectionIdentifier) >= 0)
                filesToUpload.splice(i, 1);
        }

        $(this).children(".fileList").empty();
    }

    return this;
};

var filesToUpload = [];

var files1Uploader = $("#files1").fileUploader(filesToUpload, "files1");
var files2Uploader = $("#files2").fileUploader(filesToUpload, "files2");
var files3Uploader = $("#files3").fileUploader(filesToUpload, "files3");
var files4Uploader = $("#files4").fileUploader(filesToUpload, "files4");

$("#uploadBtn").click(function(e) {
    e.preventDefault();

    $("#uploadBtn").attr('disabled',true);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var formData = new FormData();
    var data = [];
    var key = [];
    var chk1 = '';
    var chk2 = '';
    var chk3 = '';
    var chk4 = '';
    var txtfile1 = document.getElementById('txtfile1');
    var txtfile2 = document.getElementById('txtfile2');
    var txtfile3 = document.getElementById('txtfile3');
    var txtfile4 = document.getElementById('txtfile4');
    var txtfilename = "";

    var current_lang = $('#current_lang').val();
    var add_document_file_text = (current_lang=='en')?'Please add document file.':'กรุณาเพิ่มไฟล์เอกสาร';
    var saving_data_text = (current_lang=='en')?'Saving data':'กำลังทำการบันทึกข้อมูล';
    var please_wait_text = (current_lang=='en')?'Please wait':'กรุณารอซักครู่';
    var register_failed_text = (current_lang=='en')?'Teacher Register Failed':'การสมัครสมาชิกผู้สอนล้มเหลว';

    for (var i = 0, len = filesToUpload.length; i < len; i++) {

        formData.append('userpic[]', filesToUpload[i].file);
        //data.push(filesToUpload[i].file);
        console.log(filesToUpload[i].id.substring(0, 6));
        if (filesToUpload[i].id.substring(0, 6) == "files1") {
            key[i] = "files1";
            chk1 = "1";
            // txtfilename += '<input type="text" name="txtfile1[]" value="' + filesToUpload[i].file['name'] + '" />';
        } else if (filesToUpload[i].id.substring(0, 6) == "files2") {
            key[i] = "files2";
            chk2 = "2";

        } else if (filesToUpload[i].id.substring(0, 6) == "files3") {
            key[i] = "files3";
            chk3 = "3";

        } else {
            key[i] = "files4";
            chk4 = "4";
        }
    }

    if (key.length === 0 && txtfile1== null && txtfile2== null && txtfile3== null && txtfile4== null) {
        $("#uploadBtn").removeAttr('disabled');

        Swal.fire({
            title: add_document_file_text,
            type: 'warning',
            confirmButtonColor: "#569c37",
        })
    }
    else {
        let timerInterval
        Swal.fire({
            title: saving_data_text,
            html: please_wait_text,
            timer: 1000,
            onBeforeOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                    Swal.getContent().querySelector('strong')
                        //.textContent = Swal.getTimerLeft()
                }, 100)
            },
            onClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
        })
        if (key.length === 0 ){
            $('#form_id').submit();
        }
        else{
            //$('#form_id').submit();
            $.ajax({
                url: "/members/upFile",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                type: "POST",
                success: function(data) {
                    //alert(data);
                    console.log(data);
                    for (i = 0; i < data.length; i++) {
                        if (key[i] == "files1") {
                            txtfilename += '<input type="hidden" name="txtfile1[]" value="' + data[i] + '" />';
                        } else if (key[i] == "files2") {
                            txtfilename += '<input type="hidden" name="txtfile2[]" value="' + data[i] + '" />';
                        } else if (key[i] == "files3") {
                            txtfilename += '<input type="hidden" name="txtfile3[]" value="' + data[i] + '" />';
                        } else {
                            txtfilename += '<input type="hidden" name="txtfile4[]" value="' + data[i] + '" />';
                        }
                    }
                    $(txtfilename).appendTo( "#txtfilename" );
                    //txtfilename.appendTo(document.getElementById("txtfilename"));
                    $('#form_id').submit();
                    // return true;
                },
                error: function(data) {
                    //alert("ERROR - " + data.responseText);
                    // return false;

                    $("#uploadBtn").removeAttr('disabled');

                    Swal.fire({
                        title: register_failed_text,
                        type: 'warning',
                        confirmButtonColor: "#569c37",

                    })
                }
            });
        }
    }
});

/*
(function() {

    var filesToUpload = [];

    var files1Uploader = $("#files1").fileUploader(filesToUpload, "files1");
    var files2Uploader = $("#files2").fileUploader(filesToUpload, "files2");
    var files3Uploader = $("#files3").fileUploader(filesToUpload, "files3");
    var files4Uploader = $("#files4").fileUploader(filesToUpload, "files4");

    $("#uploadBtn").click(function(e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = new FormData();
        var data = [];
        var key = [];
        var chk1 = '';
        var chk2 = '';
        var chk3 = '';
        var chk4 = '';
        var txtfile1 = document.getElementById('txtfile1');
        var txtfile2 = document.getElementById('txtfile2');
        var txtfile3 = document.getElementById('txtfile3');
        var txtfile4 = document.getElementById('txtfile4');
        var txtfilename = "";

        var current_lang = $('#current_lang').val();
        var add_document_file_text = (current_lang=='en')?'Please add document file.':'กรุณาเพิ่มไฟล์เอกสาร';
        var saving_data_text = (current_lang=='en')?'Saving data':'กำลังทำการบันทึกข้อมูล';
        var please_wait_text = (current_lang=='en')?'Please wait':'กรุณารอซักครู่';
        var register_failed_text = (current_lang=='en')?'Teacher Register Failed':'การสมัครสมาชิกผู้สอนล้มเหลว';

        for (var i = 0, len = filesToUpload.length; i < len; i++) {

            formData.append('userpic[]', filesToUpload[i].file);
            //data.push(filesToUpload[i].file);
            console.log(filesToUpload[i].id.substring(0, 6));
            if (filesToUpload[i].id.substring(0, 6) == "files1") {
                key[i] = "files1";
                chk1 = "1";
                // txtfilename += '<input type="text" name="txtfile1[]" value="' + filesToUpload[i].file['name'] + '" />';
            } else if (filesToUpload[i].id.substring(0, 6) == "files2") {
                key[i] = "files2";
                chk2 = "2";

            } else if (filesToUpload[i].id.substring(0, 6) == "files3") {
                key[i] = "files3";
                chk3 = "3";

            } else {
                key[i] = "files4";
                chk4 = "4";
            }
        }
        if (key.length === 0 && txtfile1== null && txtfile2== null && txtfile3== null && txtfile4== null) {
            Swal.fire({
                title: add_document_file_text,
                type: 'warning',
                confirmButtonColor: "#569c37",

            })
        } else {
            let timerInterval
            Swal.fire({
                title: saving_data_text,
                html: please_wait_text,
                timer: 100000,
                onBeforeOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                        Swal.getContent().querySelector('strong')
                            //.textContent = Swal.getTimerLeft()
                    }, 100)
                },
                onClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                if (
                    //Read more about handling dismissals below
                    result.dismiss === Swal.DismissReason.timer
                ) {
                    console.log('I was closed by the timer')
                }
            })
            if (key.length === 0 ){
                $('#form_id').submit();
            }else{
                $('#form_id').submit();
            $.ajax({
                url: "/members/upFile",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                type: "POST",
                success: function(data) {
                    //alert(data);
                    console.log(data);
                    for (i = 0; i < data.length; i++) {
                        if (key[i] == "files1") {
                            txtfilename += '<input type="hidden" name="txtfile1[]" value="' + data[i] + '" />';
                        } else if (key[i] == "files2") {
                            txtfilename += '<input type="hidden" name="txtfile2[]" value="' + data[i] + '" />';
                        } else if (key[i] == "files3") {
                            txtfilename += '<input type="hidden" name="txtfile3[]" value="' + data[i] + '" />';
                        } else {
                            txtfilename += '<input type="hidden" name="txtfile4[]" value="' + data[i] + '" />';
                        }
                    }
                    $(txtfilename).appendTo( "#txtfilename" );
                    //txtfilename.appendTo(document.getElementById("txtfilename"));
                    $('#form_id').submit();
                    // return true;
                },
                error: function(data) {
                    //alert("ERROR - " + data.responseText);
                    // return false;
                    Swal.fire({
                        title: register_failed_text,
                        type: 'warning',
                        confirmButtonColor: "#569c37",

                    })
                }
            });
        }
        }

    });
})()
*/

function upfile(file){
    console.log('ss');
    document.getElementById('membet_img_file').src = window.URL.createObjectURL(file)
    if(document.getElementById("up")){
        document.getElementById("up").remove();
    }


}
// ---------------------------------------------------------------------เพิ่มไฟล์


//เวลา



// , ระหว่างตัวเลข
function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function chkNum(ele)
{
    var num = parseFloat(ele.value);
    ele.value = addCommas(num.toFixed(0));
}
// , ระหว่างตัวเลข
