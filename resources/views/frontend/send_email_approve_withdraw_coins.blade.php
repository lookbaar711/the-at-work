<?php
    //$name = 'aaaa';
    //$coins = '100';
    //$sum_coins = '1100';
    //$withdraw_date = '2019-10-09';
    //$withdraw_time = '10:00';

    $hostname = get_hostname();
?>

<div class="row">
    <div style="padding-left: -10px;">
        <img src="http://{{ $hostname }}/suksa/frontend/template/images/icons/favicon1.png" style="width: 110px; height: 110px;">
    </div>

    <div style="padding-bottom: 15px; font-size: 14px;">
        <label>สวัสดี <b>{{ $name }}</b></label><br>
        <label style="font-size: 16px;">คุณถอน Coins สำเร็จ</label><br><br>
        <label>คุณถอน Coins จำนวน {{ $coins }} Coins สำเร็จ</label><br>
        <label>จำนวน Coins ล่าสุดของคุณคือ {{ $sum_coins }} Coins</label><br>
        <label>เมื่อวันที่ {{ $withdraw_date }} เวลา {{ $withdraw_time }} น.</label><br><br>       

        <label>Thanks,</label><br>
        <label>Suksa Team</label> <label><a href="http://{{ $hostname }}">www.{{ $hostname }}</a></label>
    </div>

    <div style="border-top: 1px solid #eee; padding-top: 13px;">
        <label style="font-size: 12px;">Customer Support (Mon-Fri 09:00-18:00) <b style="font-size: 16px;">02 982 9999</b></label><br>
        <label style="font-size: 12px;">Copyright © 2019 Education. All rights reserved.</label>
    </div>   
</div>