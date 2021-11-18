<?php
    //$name = 'aaaa';
    //$username = 'bbbb';
    //$password = 'cccc';

    $hostname = get_hostname();
?>

<div class="row">
    <div style="padding-left: -10px;">
        <img src="http://{{ $hostname }}/suksa/frontend/template/images/icons/favicon1.png" style="width: 110px; height: 110px;">
    </div>

    <div style="padding-bottom: 15px; font-size: 14px;">
        <label>สวัสดี <b>{{ $name }}</b></label><br>
        <label style="font-size: 16px;">ขอต้อนรับสมาชิกใหม่เข้าสู่ <b>ATWORK</b></label><br><br>
        <label><b>อีเมล์</b></label><label style="padding-left: 33px;">: {{ $username }}</label><br>
        <label><b>รหัสผ่าน</b></label><label style="padding-left: 15px;">: {{ $password }}</label><br><br>     

        <label>Thanks,</label><br>
        <label>ATWORK Team</label> <label><a href="http://{{ $hostname }}">www.{{ $hostname }}</a></label>
    </div>

    <div style="border-top: 1px solid #eee; padding-top: 13px;">
        <label style="font-size: 12px;">Customer Support (Mon-Fri 09:00-18:00) <b style="font-size: 16px;">02 982 9999</b></label><br>
        <label style="font-size: 12px;">Copyright © 2020 ATWORK. All rights reserved.</label>
    </div>   
</div>
