$(document).on('click', '.btn-other-0', function(e) {
    var current_lang = $('#current_lang').val();
    var remove_text = (current_lang=='en')?'Remove':'ลบ';
    var txt = $('#other_chk0').val();
        if(txt=='' ){
            Swal.fire({
              type: 'error',
              title: 'กรุณาป้อนข้อมูล',
              //text: 'Something went wrong!',
            })
            return false;
        }else{
    e.preventDefault();
    var controlForm = $('#other_0_input:first'),
        currentEntry = $(this).parents('.entry:first');

    $(currentEntry.clone()).appendTo(controlForm);
    currentEntry.find('input').val('');
    controlForm.find('.entry:not(:first) .btn-other-0')
        .removeClass('btn-other-0').addClass('btn-remove')
        .removeClass('btn-success').addClass('btn-danger')
        .html(remove_text);
}}).on('click', '.btn-remove', function(e) {
    e.preventDefault();
    $(this).parents('.entry:first').remove();
    return false;
});

$(document).on('click', '.btn-other-1', function(e) {
    var current_lang = $('#current_lang').val();
    var remove_text = (current_lang=='en')?'Remove':'ลบ';
    var txt = $('#other_chk1').val();
        if(txt=='' ){
            Swal.fire({
              type: 'error',
              title: 'กรุณาป้อนข้อมูล',
              //text: 'Something went wrong!',
            })
            return false;
        }else{
    e.preventDefault();
    var controlForm = $('#other_1_input:first'),
        currentEntry = $(this).parents('.entry:first');

    $(currentEntry.clone()).appendTo(controlForm);
    currentEntry.find('input').val('');
    controlForm.find('.entry:not(:first) .btn-other-1')
        .removeClass('btn-other-1').addClass('btn-remove')
        .removeClass('btn-success').addClass('btn-danger')
        .html(remove_text);
}}).on('click', '.btn-remove', function(e) {
    e.preventDefault();
    $(this).parents('.entry:first').remove();
    return false;
});

$(document).on('click', '.btn-other-2', function(e) {
    var current_lang = $('#current_lang').val();
    var remove_text = (current_lang=='en')?'Remove':'ลบ';
    var txt = $('#other_chk2').val();
        if(txt=='' ){
            Swal.fire({
              type: 'error',
              title: 'กรุณาป้อนข้อมูล',
              //text: 'Something went wrong!',
            })
            return false;
        }else{
    e.preventDefault();
    var controlForm = $('#other_2_input:first'),
        currentEntry = $(this).parents('.entry:first');

    $(currentEntry.clone()).appendTo(controlForm);
    currentEntry.find('input').val('');
    controlForm.find('.entry:not(:first) .btn-other-2')
        .removeClass('btn-other-2').addClass('btn-remove')
        .removeClass('btn-success').addClass('btn-danger')
        .html(remove_text);
}}).on('click', '.btn-remove', function(e) {
    e.preventDefault();
    $(this).parents('.entry:first').remove();
    return false;
});

$(document).on('click', '.btn-other-3', function(e) {
    var current_lang = $('#current_lang').val();
    var remove_text = (current_lang=='en')?'Remove':'ลบ';
    var txt = $('#other_chk3').val();
        if(txt=='' ){
            Swal.fire({
              type: 'error',
              title: 'กรุณาป้อนข้อมูล',
              //text: 'Something went wrong!',
            })
            return false;
        }else{
    e.preventDefault();
    var controlForm = $('#other_3_input:first'),
        currentEntry = $(this).parents('.entry:first');

    $(currentEntry.clone()).appendTo(controlForm);
    currentEntry.find('input').val('');
    controlForm.find('.entry:not(:first) .btn-other-3')
        .removeClass('btn-other-3').addClass('btn-remove')
        .removeClass('btn-success').addClass('btn-danger')
        .html(remove_text);
}}).on('click', '.btn-remove', function(e) {
    e.preventDefault();
    $(this).parents('.entry:first').remove();
    return false;
});

$(document).on('click', '.btn-other-4', function(e) {
    var current_lang = $('#current_lang').val();
    var remove_text = (current_lang=='en')?'Remove':'ลบ';
    var txt = $('#other_chk4').val();
        if(txt=='' ){
            Swal.fire({
              type: 'error',
              title: 'กรุณาป้อนข้อมูล',
              //text: 'Something went wrong!',
            })
            return false;
        }else{
    e.preventDefault();
    var controlForm = $('#other_4_input:first'),
        currentEntry = $(this).parents('.entry:first');

    $(currentEntry.clone()).appendTo(controlForm);
    currentEntry.find('input').val('');
    controlForm.find('.entry:not(:first) .btn-other-4')
        .removeClass('btn-other-4').addClass('btn-remove')
        .removeClass('btn-success').addClass('btn-danger')
        .html(remove_text);
}}).on('click', '.btn-remove', function(e) {
    e.preventDefault();
    $(this).parents('.entry:first').remove();
    return false;
});

$(document).on('click', '.btn-other-5', function(e) {
    var current_lang = $('#current_lang').val();
    var remove_text = (current_lang=='en')?'Remove':'ลบ';
    var txt = $('#other_chk5').val();
        if(txt=='' ){
            Swal.fire({
              type: 'error',
              title: 'กรุณาป้อนข้อมูล',
              //text: 'Something went wrong!',
            })
            return false;
        }else{
    e.preventDefault();
    var controlForm = $('#other_5_input:first'),
        currentEntry = $(this).parents('.entry:first');

    $(currentEntry.clone()).appendTo(controlForm);
    currentEntry.find('input').val('');
    controlForm.find('.entry:not(:first) .btn-other-5')
        .removeClass('btn-other-5').addClass('btn-remove')
        .removeClass('btn-success').addClass('btn-danger')
        .html(remove_text);
}}).on('click', '.btn-remove', function(e) {
    e.preventDefault();
    $(this).parents('.entry:first').remove();
    return false;
});

$(document).on('click', '.btn-other-6', function(e) {
    var current_lang = $('#current_lang').val();
    var remove_text = (current_lang=='en')?'Remove':'ลบ';
    var txt = $('#other_chk6').val();
        if(txt=='' ){
            Swal.fire({
              type: 'error',
              title: 'กรุณาป้อนข้อมูล',
              //text: 'Something went wrong!',
            })
            return false;
        }else{
    e.preventDefault();
    var controlForm = $('#other_6_input:first'),
        currentEntry = $(this).parents('.entry:first');

    $(currentEntry.clone()).appendTo(controlForm);
    currentEntry.find('input').val('');
    controlForm.find('.entry:not(:first) .btn-other-6')
        .removeClass('btn-other-6').addClass('btn-remove')
        .removeClass('btn-success').addClass('btn-danger')
        .html('ลบ');
}}).on('click', '.btn-remove', function(e) {
    e.preventDefault();
    $(this).parents('.entry:first').remove();
    return false;
});

$(document).on('click', '.btn-other-7', function(e) {
    var current_lang = $('#current_lang').val();
    var remove_text = (current_lang=='en')?'Remove':'ลบ';
    var txt = $('#other_chk7').val();
        if(txt=='' ){
            Swal.fire({
              type: 'error',
              title: 'กรุณาป้อนข้อมูล',
              //text: 'Something went wrong!',
            })
            return false;
        }else{
    e.preventDefault();
    var controlForm = $('#other_7_input:first'),
        currentEntry = $(this).parents('.entry:first');
        
    $(currentEntry.clone()).appendTo(controlForm);
    currentEntry.find('input').val('');
    controlForm.find('.entry:not(:first) .btn-other-7')
        .removeClass('btn-other-7').addClass('btn-remove')
        .removeClass('btn-success').addClass('btn-danger')
        .html(remove_text);
}}).on('click', '.btn-remove', function(e) {
    e.preventDefault();
    $(this).parents('.entry:first').remove();
    return false;
});

