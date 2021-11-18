<?php
    //$from_fullname = 'Anat Rakhungsomboon';
    //$from_email = 'anat@edispro.com';
    //$to_fullname = 'ประยุทธ จันทร์อังคารพุธ';
    //$to_email = 'lookbaar@gmail.com';
    //$send_date = '2019-11-26';
    //$send_time = '12:00';

    $hostname = 'suksa.online';
?>

<div class="row">
    <div style="padding-left: -10px;">
        <img src="http://{{ $hostname }}/suksa/frontend/template/images/icons/favicon1.png" style="width: 110px; height: 110px;">
    </div>

    <div style="padding-bottom: 15px; font-size: 14px;">
        <label>สวัสดี <b>{{ $to_fullname }}</b></label><br>
        <label style="font-size: 16px;">คุณ {{ $from_fullname }} ส่งข้อความถึงคุณ</label><br><br>
        <label>วันที่ {{ changeDate($send_date, 'full_date', 'th') }} เวลา {{ substr($send_time,0,5) }} น.</label><br><br>      

        <label>Thanks,</label><br>
        <label>Suksa Team</label> <label><a href="http://{{ $hostname }}">www.{{ $hostname }}</a></label>
    </div>

    <div style="border-top: 1px solid #eee; padding-top: 13px;">
        <label style="font-size: 12px;">Customer Support (Mon-Fri 09:00-18:00) <b style="font-size: 16px;">02 982 9999</b></label><br>
        <label style="font-size: 12px;">Copyright © 2019 Education. All rights reserved.</label>
    </div>   
</div>
