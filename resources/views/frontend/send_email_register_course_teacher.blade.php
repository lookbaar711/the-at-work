<?php
    //$student_fullname = 'aaaa';
    //$course_name = 'ภาษาไทย';
    //$teacher_fullname = 'bbbb';
    //$course_date = '2019-10-09';
    //$course_time_start = '10:00';
    //$course_time_end = '11:00';

    $hostname = get_hostname();
?>

<div class="row">
    <div style="padding-left: -10px;">
        <img src="http://{{ $hostname }}/suksa/frontend/template/images/icons/favicon1.png" style="width: 110px; height: 110px;">
    </div>

    <div style="padding-bottom: 15px; font-size: 14px;">
        <label>สวัสดี <b>{{ $teacher_fullname }}</b></label><br>
        <label style="font-size: 16px;">เข้าร่วมประชุมสำเร็จ</label><br><br>
        <label>คุณ {{ $student_fullname }} เข้าร่วมประชุม {{ $course_name }}</label><br>
        <label>วันที่ประชุม {{ $course_date }} เวลา {{ $course_time_start }} - {{ $course_time_end }} น.</label><br><br>       

        <label>Thanks,</label><br>
        <label>ATWORK Team</label> <label><a href="http://{{ $hostname }}">www.{{ $hostname }}</a></label>
    </div>

    <div style="border-top: 1px solid #eee; padding-top: 13px;">
        <label style="font-size: 12px;">Customer Support (Mon-Fri 09:00-18:00) <b style="font-size: 16px;">02 982 9999</b></label><br>
        <label style="font-size: 12px;">Copyright © 2020 ATWORK. All rights reserved.</label>
    </div>   
</div>