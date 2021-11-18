<?php
    //$name = 'aaaa';
    //$course = 'bbbb';

    $hostname = 'theatwork.com';
?>

<div class="row">
    <div style="padding-left: -10px;">
        <img src="http://{{ $hostname }}/suksa/frontend/template/images/icons/favicon1.png" style="width: 110px; height: 110px;">
    </div>

    <div style="padding-bottom: 15px; font-size: 14px;">
        <label>สวัสดี <b>{{ $name }}</b></label><br>
		<label style="font-size: 16px;">เปิดห้องประชุม {{ $course }} ไม่สำเร็จ</label><br><br>
		<label>ไม่สามารถเปิดห้องประชุม Private ได้ เนื่องจากไม่มีผู้เข้าร่วมประชุม </label><br><br>

        <label>Thanks,</label><br>
        <label>ATWORK Team</label> <label><a href="http://{{ $hostname }}">www.{{ $hostname }}</a></label>
    </div>

    <div style="border-top: 1px solid #eee; padding-top: 13px;">
        <label style="font-size: 12px;">Customer Support (Mon-Fri 09:00-18:00) <b style="font-size: 16px;">02 982 9999</b></label><br>
        <label style="font-size: 12px;">Copyright © 2020 ATWORK. All rights reserved.</label>
    </div>   
</div>
