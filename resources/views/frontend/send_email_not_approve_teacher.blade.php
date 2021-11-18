<?php
    //$name = 'aaaa';
    //$comment = 'เอกสารไม่ครบ';
    //$url = 'http://suksa.online/members/updatedata/5d89eaaf9aa4ce0d45149f32';

    $hostname = get_hostname();
?>
<style type="text/css">
    .pre {
    font-size: .7rem;
    margin: 0;
}
</style>
<div class="row">
    <div style="padding-left: -10px;">
        <img src="http://{{ $hostname }}/suksa/frontend/template/images/icons/favicon1.png" style="width: 110px; height: 110px;">
    </div>

    <div style="padding-bottom: 15px; font-size: 14px;">
        <label>สวัสดี <b>{{ $name }}</b></label><br>
        <label style="font-size: 16px;">ขออภัย ข้อมูลหรือคุณสมบัติของคุณไม่เพียงพอ เนื่องจาก</label>
        &nbsp;&nbsp;<pre style="font-size: 14px;margin-left: 30px;color: #500050;">{{ $comment }}</pre>
        <label>กรุณา <a href="{{ $url }}">คลิกที่ลิงค์นี้</a> เพื่อทำการแก้ไขข้อมูลให้ถูกต้อง</label><br><br>

        <label>Thanks,</label><br>
        <label>Suksa Team</label> <label><a href="http://{{ $hostname }}">www.{{ $hostname }}</a></label>
    </div>

    <div style="border-top: 1px solid #eee; padding-top: 13px;">
        <label style="font-size: 12px;">Customer Support (Mon-Fri 09:00-18:00) <b style="font-size: 16px;">02 982 9999</b></label><br>
        <label style="font-size: 12px;">Copyright © 2019 Education. All rights reserved.</label>
    </div>   
</div>