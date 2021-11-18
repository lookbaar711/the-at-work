<?php

    use App\Models\Course;
    use App\Models\Subject;
    use App\Models\AdminNotification;
    use App\Models\MemberNotification;
    use App\Models\Member;
    use App\Events\SendNotiFrontend;
    use App\Events\SendNotiBackend;
    

    function get_aptitude_level($aptitude_level){
        if($aptitude_level=='prathom1'){
            return 'ประถมศึกษาตอนต้น';
        }elseif ($aptitude_level=='prathom2') {
            return 'ประถมศึกษาตอนปลาย';
        }elseif ($aptitude_level=='matthayom1') {
            return 'มัธยมศึกษาตอนต้น';
        }elseif ($aptitude_level=='matthayom2') {
            return 'มัธยมศึกษาตอนปลาย';
        }elseif ($aptitude_level=='higherE') {
            return 'อุดมศึกษา';
        }elseif ($aptitude_level=='language') {
            return 'ภาษา';
        }elseif ($aptitude_level=='inter') {
            return 'อินเตอร์';
        }elseif ($aptitude_level=='admission') {
            return 'Admission';
        }
    }

    

    function get_subject($subject, $other_subject, $other_chk, $aptitude_id, $member_id){ 
        $value = [];
        if(isset($subject[0])){
            foreach ($subject as $i => $item) {
                $value[] = $item;
            }
        }
        if($other_chk){
            foreach($other_subject as $i => $items){
                if($i!='0'){
                    if($items){
                        $data = ([
                            'subject_name_th' => $items,
                            'subject_name_en' => $items,
                            'is_master' => '0',
                            'aptitude_id' => $aptitude_id,
                            'member_id' => $member_id
                        ]);
                        Subject::create($data);
                        //dd($data);
                        $subject_other = Subject::where('subject_name_th', '=', $items)
                                        ->orderby('created_at', 'DESC')
                                        ->first();
                        $value[] = $subject_other->id;
                    }
                }
            }
        }
        return $value;
    }
    function compress_images($source_url, $destination_url, $quality) {
        ini_set('memory_limit', '256M');

        $info = getimagesize($source_url);
            if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source_url);
  
            elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source_url);
  
            elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source_url);
            
            imagejpeg($image, $destination_url, $quality);
            return $destination_url;
          }
    
    function compress_image($filename, $destination_url, $quality) {
        ini_set('memory_limit', '256M');
        $info = getimagesize($filename);
        if($info['mime'] == 'image/png'){
            $img = imagecreatefrompng($filename);

            imagejpeg($img, $destination_url, $quality);
            return $destination_url;
        }
        if (function_exists('exif_read_data')) {
        $exif = exif_read_data($filename);
        if($exif && isset($exif['Orientation'])) {
          $orientation = $exif['Orientation'];
          if($orientation != 1){
            //$img = imagecreatefromjpeg($filename);
            if ($info['mime'] == 'image/jpeg')
            $img = imagecreatefromjpeg($filename);
  
            elseif ($info['mime'] == 'image/gif')
            $img = imagecreatefromgif($filename);
  
            elseif ($info['mime'] == 'image/png')
            $img = imagecreatefrompng($filename);
            $deg = 0;
            switch ($orientation) {
              case 3:
                $deg = 180;
                break;
              case 6:
                $deg = 270;
                break;
              case 8:
                $deg = 90;
                break;
            }
            if ($deg) {
              $img = imagerotate($img, $deg, 0);        
            }
            // then rewrite the rotated image back to the disk as $filename 
            imagejpeg($img, $destination_url, $quality);
            return $destination_url;
          } // if there is some rotation necessary

        } // if have the exif orientation info
        else{
            if ($info['mime'] == 'image/jpeg')
            $img = imagecreatefromjpeg($filename);
  
            elseif ($info['mime'] == 'image/gif')
            $img = imagecreatefromgif($filename);
  
            elseif ($info['mime'] == 'image/png')
            $img = imagecreatefrompng($filename);

            imagejpeg($img, $destination_url, $quality);
            return $destination_url;
          }
      } // if function exists      
      
    }

    function get_member_noti(){
        if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            $lang = 'en';
        }
        else{
            $lang = 'th';
        }

        $member_id = Auth::guard('members')->user()->member_id;
        $member_noti = MemberNotification::where('member_id', $member_id)
                        ->orderby('created_at','desc')
                        ->get();

        foreach ($member_noti as $noti) {
            //$noti->classroom_start_date = changeDate($noti->classroom_start_date, 'full_date', $lang);
            //$noti->classroom_end_date = changeDate($noti->classroom_end_date, 'full_date', $lang);   

            if($noti->noti_type=="open_course_student" || $noti->noti_type=="open_course_teacher"){
                $price = Course::where('_id', '=', $noti->course_id)
                    ->select('course_price')
                    ->first();
                //$noti->price = $price->course_price;
            }

            if(isset($noti->classroom_time_start)){
                //$noti->classroom_date = changeDate($noti->classroom_date, 'full_date', $lang);  
            }

            if(isset($noti->classroom_time_start) || isset($noti->classroom_time_end)){
                $noti->classroom_time_start = substr($noti->classroom_time_start,0,5);
                $noti->classroom_time_end = substr($noti->classroom_time_end,0,5);
            }
        }

        return $member_noti;
    }

    function count_badge_member_noti(){
        $member_id = Auth::guard('members')->user()->member_id;
        $count_noti = MemberNotification::where('member_id', $member_id)
                    ->where('noti_status', '0')
                    ->orderby('created_at','desc')
                    ->count();

        return $count_noti;
    }

    function count_member_noti(){
        $member_id = Auth::guard('members')->user()->member_id;
        $count_noti = MemberNotification::where('member_id', $member_id)
                    ->orderby('created_at','desc')
                    ->count();

        return $count_noti;
    }

    function get_admin_noti(){
        $admin_id = Auth::guard('web')->user()->admin_id;
        $admin_noti = AdminNotification::where('noti_to', 'all')
                    ->orWhere('noti_to', $admin_id)
                    ->orderby('created_at','desc')
                    ->get();

        return $admin_noti;
    }

    function count_admin_noti(){
        $admin_id = Auth::guard('web')->user()->admin_id;
        $count_noti = AdminNotification::where('noti_to', 'all')
                    ->orWhere('noti_to', $admin_id)
                    ->where('noti_status', '0')
                    ->orderby('created_at','desc')
                    ->count();

        return $count_noti;
    }

    function update_last_action(){
        if(Auth::guard('members')->user()){
            $member_id = Auth::guard('members')->user()->member_id;
            $update_action = Member::where('member_id', $member_id)
                        ->update(['last_action_at' => date('Y-m-d H:i:s')]);
            return true;
        }
    }

    function changeDate($datetime, $format, $lang)
    {
        if($lang == 'en'){
            $year = date("Y",strtotime($datetime));
        }
        else{
            $year = date("Y",strtotime($datetime))+543;
        }
        
        $month = date("n",strtotime($datetime));
        $day = date("j",strtotime($datetime));
        $hour = date("H",strtotime($datetime));
        $minute = date("i",strtotime($datetime));
        $seconds = date("s",strtotime($datetime));
        $short_month_th = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $full_month_th = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

        $short_month_en = array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
        $full_month_en = array("","January","February","March","April","May","June","July","August","September","October","November","December");

        //$show_date = "$day $short_month $year, $hour:$minute";
        
        if($format == "full_date"){
            $show_month = ($lang=='th')?$full_month_th[$month] : $full_month_en[$month];
            $show = $day." ".$show_month." ".$year;
        }
        else if($format == "short_date"){
            $show_month = ($lang=='th')?$short_month_th[$month] : $short_month_en[$month];
            $show = $day." ".$show_month." ".$year;
        }
        else if($format == "full_month"){
            $show = ($lang=='th')?$full_month_th[$month] : $full_month_en[$month];
        }
        else if($format == "short_month"){
            $show = ($lang=='th')?$short_month_th[$month] : $short_month_en[$month];
        }
        else if($format == "day"){
            $show = $day;
        }
        
        return $show;
    }

    function get_hostname(){
        $host = $_SERVER['HTTP_HOST'];

        if(($host == "127.0.0.1:8000") || ($host == "127.0.0.1") || ($host == "localhost")){
            $hostname = '127.0.0.1:8000';
        }
        else{ ////theatwork.com
            $hostname = 'theatwork.com';
        }

        return $hostname;
    }

    function sendMemberNoti($member_id){
        event(new SendNotiFrontend($member_id));
    }

    function sendAdminNoti($admin_id){
        event(new SendNotiBackend($admin_id));
    }