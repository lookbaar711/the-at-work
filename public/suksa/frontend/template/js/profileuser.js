// เพิ่มแถวและลบ 1 input ++
// เพิ่มแถวและลบ 2 input ++
$(document).on('click', '.btn-add3', function(e) {
    e.preventDefault();
    var controlForm = $('#myRepeatingFields3:first'),
        currentEntry = $(this).parents('.entry:first'),
        newEntry = $(currentEntry.clone()).appendTo(controlForm);

    newEntry.find('input').val('');
    controlForm.find('.entry:not(:first) .btn-add3')
        .removeClass('btn-add3').addClass('btn-remove')
        .removeClass('btn-dark').addClass('btn-danger')
        .html('ลบ');
}).on('click', '.btn-remove ', function(e) {
    e.preventDefault();
    $(this).parents('.entry:first').remove();

    return false;
});
// เพิ่มแถวและลบ 3 input ++
$(document).on('click', '.btn-add4', function(e) {
    e.preventDefault();
    var controlForm = $('#myRepeatingFields4:first'),
        currentEntry = $(this).parents('.entry:first'),
        newEntry = $(currentEntry.clone()).appendTo(controlForm);

    newEntry.find('input').val('');
    controlForm.find('.entry:not(:first) .btn-add4')
        .removeClass('btn-add4').addClass('btn-remove')
        .removeClass('btn-dark').addClass('btn-danger')
        .html('ลบ');
}).on('click', '.btn-remove ', function(e) {
    e.preventDefault();
    $(this).parents('.entry:first').remove();

    return false;
});




// แสดงข้อมูลไฟล์ Upload
// ------------------------------------------------------------------------------//


$.fn.fileUploader = function(filesToUpload, sectionIdentifier) {
    var fileIdCounter = 0;

    this.closest(".files").change(function(evt) {
        var output = [];

        for (var i = 0; i < evt.target.files.length; i++) {
            fileIdCounter++;
            var file = evt.target.files[i];
            var fileId = sectionIdentifier + fileIdCounter;

            filesToUpload.push({
                id: fileId,
                file: file
            });
            console.log(filesToUpload);
            var removeLink = "<a class=\"removeFile\ href=\"#\" data-fileid=\"" + fileId + "\"><label style='color: red'>ลบ</a>";
            // var file = "<input type=\"text\" name=\"fileUp[]\" value=\"c:\\fakepath\\" + file.name + "\"/>";
            output.push("<li><strong>", escape(file.name), "</strong> - ", file.size, " bytes. &nbsp; &nbsp; ", removeLink, "</li> ");

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
        var txtfilename = "";
        var key = [];
        var chk1 = '';
        var chk2 = '';
        var chk3 = '';
        var chk4 = '';
        for (var i = 0, len = filesToUpload.length; i < len; i++) {

            formData.append('userpic[]', filesToUpload[i].file);
            //data.push(filesToUpload[i].file);
            console.log(filesToUpload[i].id.substring(0, 6));
            if (filesToUpload[i].id.substring(0, 6) == "files1") {
                key[i] = "files1";
                chk1 = "1";
                // txtfilename += '<input type="hidden" name="txtfile1[]" value="' + filesToUpload[i].file['name'] + '" />';
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
        if (key.length === 0) {
            Swal.fire({
                title: "กรุณาเพิ่มไฟล์เอกสาร!",
                type: 'warning',
                confirmButtonColor: "#569c37",

            })
        } else {
            let timerInterval
            Swal.fire({
                title: 'กำลังทำการบันทึกข้อมูล!',
                timer: 10000,
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
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.timer
                ) {
                    console.log('I was closed by the timer')
                }
            })

            $.ajax({
                url: "/users/upFile",
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
                    document.getElementById("txtfilename").innerHTML = txtfilename;
                    $('#form_id').submit();
                    // return true;
                },
                error: function(data) {
                    //alert("ERROR - " + data.responseText);
                    // return false;
                }
            });

        }

    });
})()


// ---------------------------------------------------------------------เพิ่มไฟล์
$('#file-upload').change(function() {
    var i = $(this).prev('label').clone();
    var file = $('#file-upload')[0].files[0].name;
    $(this).prev('label').text(file);
});

// ---------------------------------------------------------------------เพิ่มไฟล์
$('#course_file').change(function() {
    var i = $(this).prev('label').clone();
    var file = $('#course_file')[0].files[0].name;
    $(this).prev('label').text(file);
});

// ---------------------------------------------------------------------อัพโปรไฟล์
$('#upload-profile').change(function() {
    var file = $('#upload-profile')[0].files[0].name;
});


// จำกัดการป้อน
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
