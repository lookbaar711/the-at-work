<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Aptitude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;
use App\Models\Subject;
use App\Models\Other_subject;
use App\Models\Course;
use App\Models\Coin;
use App\Models\MemberNotification;
use App\Models\Withdraw;
use App\Models\Classroom;
use App\Models\RequestSubjects;
use App\Models\MapTeacherSubject;
use App\Models\CoinsLog;
use App\Models\Event;
use App\Models\BankMaster;
use App\Models\MemberBank;
use Illuminate\Support\Str;
use Session;
use Auth;
use Mail;
use App\Models\AdminNotification;
use App;
use Lang;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function all() {
        $members = Member::where('member_status', '1')
            ->whereNotNull('member_Bday')
            ->orderby('created_at','desc')
            ->paginate(8);

             // ->get();

        $total_row = $members->count();
        if($total_row > 0) {
            foreach($members as $member) {

                // Check Image
                if($member->member_img!="") {
                    $img = asset ('storage/memberProfile/'.$member->member_img);
                } else {
                    $img = asset ('suksa/frontend/template/images/icons/blank_image.jpg');
                }

                $data_apptitude = '';
                $subject        = '';

                // Check subject for teacher
                foreach (array_keys($member->member_aptitude) as $key) {

                    if (count($member->member_aptitude[$key]) > 0) {

                        foreach ($member->member_aptitude[$key] as $items) {
                            $data_apptitude++;
                            if ($data_apptitude > 3) {
                                continue;
                            // } else {
                            //     $subject_detail = Subject::where('_id', $items)->first();
                            //     if(session('lang') == 'th'){
                            //         $subject .= $subject_detail->subject_name_th.' '.'';
                            //     }else{
                            //         $subject .= $subject_detail->subject_name_en.' '.'';
                            //     }

                            }
                        }
                    }
                }
            }
        }

        $view['members'] = $members;

        update_last_action();

        return view('frontend.members.member-all', $view);
    }

    public function get_profile_member($id) {
        $members = Member::where('member_status', '1')
            ->where('member_id',$id)
            ->whereNotNull('member_Bday')
            ->orderby('created_at','desc')
            ->get();

        $bank_master = BankMaster::orderBy('bank_name_th','asc')->get();

        //ข้อมูลธนาคารของ user
        $member_bank = MemberBank::where('member_id', $id)
                      ->orderby('created_at','asc')
                      ->get();

        $members->member_bank = $member_bank;

        // dd($member_bank);
        $events = Event::orderBy('created_at','asc')->get();

        // $aptitude = array();
        $i = 0;
        $aptitude = Aptitude::orderBy('created_at','asc')->get();
        foreach ($aptitude as $key => $value) {
            $subject = [];
            foreach ($value['aptitude_subject'] as $ke => $val) {

                $check_subject = Subject::where('_id', $val)->first();

                if(isset($check_subject)){
                    if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
                        App::setLocale('en');
                        $subject[] = Subject::select('subject_name_en')->where('_id', $val)->first();
                    }
                    else{
                        App::setLocale('th');
                        $subject[] = Subject::select('subject_name_th')->where('_id', $val)->first();
                    }
                }
            }

            //get other subject by member
            if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
                $subject_other = Subject::select('subject_name_en')
                                ->where('member_id', Auth::guard('members')->user()->id)
                                ->where('aptitude_id', $value['_id'])
                                ->where('is_master', '0')
                                ->get();

                foreach ($subject_other as $key_other => $value_other) {
                    $subject[] = $value_other;
                }
            }
            else{
                $subject_other = Subject::select('subject_name_th')
                                ->where('member_id', Auth::guard('members')->user()->id)
                                ->where('aptitude_id', $value['_id'])
                                ->where('is_master', '0')
                                ->get();

                foreach ($subject_other as $key_other => $value_other) {
                    $subject[] = $value_other;
                }
            }

            $value['aptitude_subject'] = $subject;
        }

        if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            App::setLocale('en');
            $lang = 'en';
        }
        else{
            App::setLocale('th');
            $lang = 'th';
        }

        // $y = 0;
        // foreach ($aptitude as $key => $value) {
        //   $subject_list = [];
        //   foreach ($value->subject as $ke => $subject) {
        //         $Subject = Subject::select('_id AS id','subject_name_th','subject_name_en')->where('_id', $subject)->first();
        //         $subject_list[] = $Subject;
        //     }
        //     $aptitude[$y++]['subject'] = $subject_list;
        // }


        $data = array(
            'members' => $members,
            'member_bank' => $member_bank,
            'events' => $events,
            'aptitude' => $aptitude,
            'bank_master' => $bank_master,
            'lang' => $lang,
        );

        return json_encode($data);

    }

    public function fetch_data_menber(Request $request) {
        if($request->page) {
            $members = Member::where('member_status', '1')
                ->whereNotNull('member_Bday')
                ->orderby('created_at','desc')
                ->paginate(8);

            //$members['request_page'] = $request->paginate;

            update_last_action();

            return view('frontend.members.paginate_data', compact('members'))->render();
        }
    }

    public function search (Request $request) {
        if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            App::setLocale('en');
        }
        else{
            App::setLocale('th');
        }

        $output = '';

        $query = $request->keyword;
        if($query != '') {
            $members = Member::where('member_status', '1')->whereNotNull('member_Bday')
                ->orWhere('member_fname', 'like', '%'.$query.'%')
                ->orWhere('member_lname', 'like', '%'.$query.'%')
                ->orWhere('member_rate_start', 'like', '%'.$query.'%')
                ->orWhere('member_rate_end', 'like', '%'.$query.'%')
                ->orderby('created_at','desc')
                ->get();

        } else {

            $members = Member::where('member_status', '1')
                ->whereNotNull('member_Bday')
                ->orderby('created_at','desc')
                ->paginate(8);
                // ->get();

            $view['members'] = $members;

        }

        $total_row = $members->count();
        if($total_row > 0) {
            foreach($members as $member) {

                // Check Image
                if($member->member_img!="") {
                    $img = asset ('storage/memberProfile/'.$member->member_img);
                } else {
                    $img = asset ('suksa/frontend/template/images/icons/blank_image.jpg');
                }

                $data_apptitude = '';
                $subject        = '';
                $subject_all = [];
                // Check subject for teacher
                foreach (array_keys($member->member_aptitude) as $key) {

                    if (count($member->member_aptitude[$key]) > 0) {
                        foreach ($member->member_aptitude[$key] as $i => $items) {

                            if(in_array($items, $subject_all)){

                            }else{
                                $data_apptitude++;
                                if ($data_apptitude > 3) {
                                    continue;
                                } else {
                                    $subject .= $items.' ';
                                }
                            }
                            $subject_all[] = $items;
                        }
                    }
                }

                $output .= '

                <div class="col-md-3 col-sm-6">
                    <div class="product-grid">

                        <div class="product-image">
                          <a href="'.url('members/detail/'.$member->id).'">
                            <img class="pic-1" src="'.$img.'" onerror="this.onerror=null;this.src='."'".'http://localhost:8000/suksa/frontend/template/images/icons/blank_image.jpg'."'".';" style="background-size: cover; height:300px; object-fit: cover">
                          </a>
                          <ul class="social">
                              <li>
                                <a href="'.url('members/detail/'.$member->id).'" data-tip="'.trans('frontend/members/title.detail').'"><i class="fa fa-search"></i></a>
                              </li>
                          </ul>
                        </div>

                        <div class="product-content">
                            <div class="title">
                                <a style="font-size: 14px;" href="'.url('members/detail/'.$member->id).'">'.$member->member_rate_start.' - '.$member->member_rate_end.' '.trans('frontend/members/title.coins_per_hour').'</a>
                            </div>
                            <div class="title">
                                <a href="'.url('members/detail/'.$member->id).'">'.$member->member_fname.' '.$member->member_lname.'</a>
                            </div>
                             <div class="title">
                                <a href="'.url('members/detail/'.$member->id).'">
                                '.$subject.'
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                ';
            }
        } else {
            $output = '
            <div class="product-content">
                <div class="title">
                    <label style="text-align: center;">ไม่พบข้อมูลผู้สอน</label>
                </div>
            </div

           ';
        }

        echo $output;
    }

    public function create(){
        if(Auth::guard('members')->user()){
            return redirect('/');
        }
        else{
            $subject_list = array();
            $aptitude = Aptitude::orderBy('created_at','asc')->get();

            foreach($aptitude as $i => $item) {
                foreach ($item->aptitude_subject as $key => $subject_id) {
                    $Subject = Subject::where('_id', $subject_id)->first();

                    if(isset($Subject)){
                        $subject_list[] = $Subject;
                    }
                }
                $aptitude[$i]->subject_detail = $subject_list;
                $subject_list = [];
            }
            //dd($aptitude);
            $month = array("มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ","กรกฎาคม ","สิงหาคม ","กันยายน ","ตุลาคม ","พฤศจิกายน ","ธันวาคม ");

            $events = Event::where('event_status', '1')
                            ->where('event_start_date', '<=', date('Y-m-d'))
                            ->where('event_end_date', '>=', date('Y-m-d'))
                            ->orderBy('created_at','asc')
                            ->get();

            update_last_action();

            return view('frontend.members.member-create', compact('aptitude','month','events'));
        }
    }

    public function store(Request $request) {
        if(Auth::guard('members')->user()){
            return redirect('/');
        }
        else{
            $check_member = Member::where('_id', '=', $request->member_update)->where('member_status', '=', '4')->first();
            if($check_member){
                return view('backend.404');
            }

            $last_member = Member::orderBy('mid','desc')->first();
            $mid = ((isset($last_member->mid)&&($last_member->mid!=null)))?$last_member->mid+1:1;

            $education = array();
            $member_Exp = array();
            $member_cong = array();
            $subject_prathom1 = array();
            $subject_prathom2 = array();
            $subject_matthayom1 = array();
            $subject_matthayom2 = array();
            $subject_highere = array();
            $subject_language = array();
            $subject_inter = array();
            $subject_admission = array();
            $fileName = array(); $fileName2 = array(); $fileName3 = array(); $fileName4 = array();

            if($request['member_education1']){
                $education['มัธยมศึกษา'] = $request['member_institution1'];
            }
            if($request['member_education2']){
                $education['ปริญญาตรี'] = [$request['member_major2'],$request['member_institution2']];
            }
            if($request['member_education3']){
                $education['ปริญญาโท'] = [$request['member_major3'],$request['member_institution3']];
            }
            if($request['member_education4']){
                $education['ปริญญาเอก'] = [$request['member_major4'],$request['member_institution4']];
            }

            foreach ($request['member_HJPl'] as $i => $value) {
                if($i!='0'){
                    if($value){
                        $member_Exp[] = [$request['member_HJPl'][$i],$request['member_HJPo'][$i],$request['member_HJExp'][$i]];
                    }
                }
            }

            foreach ($request['member_cong'] as $i => $value) {
                if($i!='0'){
                    if($value){
                        $member_cong[] = $value;
                    }
                }
            }

            if($request['txtfile1']){
                foreach ($request['txtfile1'] as $value) {
                    $fileName1[] = $value;
                }
                $fileName['บัตรประชาชน'] = $fileName1;
            }if($request['txtfile2']){
                foreach ($request['txtfile2'] as $value) {
                    $fileName2[] = $value;
                }
                $fileName['สำเนาศึกษา'] = $fileName2;
            }if($request['txtfile3']){
                foreach ($request['txtfile3'] as $value) {
                    $fileName3[] = $value;
                }
                $fileName['ใบผลการเรียน'] = $fileName3;
            }if($request['txtfile4']){
                foreach ($request['txtfile4'] as $value) {
                    $fileName4[] = $value;
                }
                $fileName['วุฒิบัตรอื่นๆ'] = $fileName4;
            }
            //อัพรูปประจำตัว
            if($request['member_img']){
                $member_img =  Str::random(7).time().".jpg";
                $url = public_path("/storage/memberProfile/".$member_img);
                $file = compress_image($request['member_img'], $url, 80);
            }elseif($request['update_img']){
                $member_img = $request['update_img'];
            }else{
                $member_img = "";
            }

            $birthday = explode("/",$request->member_Bday);
            $date = $birthday[2].'-'.$birthday[1].'-'.$birthday[0];

            $data = ([
                'member_email' => $request['member_email'],
                'member_password' => Hash::make($request['member_password']),
                'member_real_password' => $request['member_password'],
                'member_sername' => $request['member_sername'],
                'member_fname' => $request['member_fname'],
                'member_lname' => $request['member_lname'],
                'member_fullname' => $request['member_fname']." ".$request['member_lname'],
                'member_nickname' => $request['member_nickname'],
                'member_Bday' => $date,
                'member_tell' => $request['member_tell'],
                'member_idLine' => $request['member_idLine'],
                'member_address' => $request['member_address'],
                'member_idCard' => $request['member_idCard'],
                'member_rate_start' => intval(preg_replace("/[,]/", "", $request['member_rate_start'])),
                'member_rate_end' => intval(preg_replace("/[,]/", "", $request['member_rate_end'])),
                'member_education' => $education,
                'member_exp' => $member_Exp,
                'member_cong' => $member_cong,
                'member_img' => $member_img,
                'member_file' => $fileName,
                'member_strlenPass' => strlen($request['member_password']),
                'member_status' => '0',
                'member_coins' => '0',
                'member_type' => 'teacher',
                'member_role' => 'teacher',
                'member_teacher' => '1',
                'online_status' => '0',
                'event_id' => (isset($request['member_event']))?$request['member_event']:null,
                //'promotion_code' => (isset($request['promotion_code']))?$request['promotion_code']:null,
                'mid' => intval($mid),
                'member_lang' => 'th'
            ]);
            Member::create($data);

            //get last insert data
            $member = Member::orderBy('mid','desc')->first();
            $members_id = $member->_id;
            $members_name = $member->member_fullname;

            //insert other subject
            $group = [];
            $count_group = Aptitude::count();
            $aptitude_list = Aptitude::get();
            $idex_group = "0";
            for($i = 0; $i<$count_group; $i++){

                $group[$aptitude_list[$i]->_id] = array();

                if(isset($request['subject_'.$i]) || $request['chk_other'.$i]){
                    //ใส่ aptitude_id master เป็น key
                    $group[$aptitude_list[$i]->_id] = get_subject($request['subject_'.$i] , $request['other'.$i] , $request['chk_other'.$i] , $aptitude_list[$i]->_id, $member->_id);

                    //ใส่ aptitude_id ที่เลือกเป็น key
                    //$group[$request->group[$idex_group]] = get_subject($request['subject_'.$i] , $request['other'.$i] , $request['chk_other'.$i] , $aptitude_list[$i]->_id, $member->_id);
                    $idex_group = $idex_group+1;
                }
            }

            $member->member_id = $member->_id;
            $member->member_aptitude = $group;
            $member->save();

            if($request->member_update!=""){
                $member_update = Member::where('_id', '=', $request->member_update)->first();
                $member_update->member_status = '4';
                $member_update->save();
            }

            if($members_id!="") {
                foreach ($group as $key => $aptitude) {
                    foreach ($aptitude as $aptitude_id => $subject) {
                        $map_teacher_data = ([
                            'members_id' => $members_id,
                            'members_name' => $members_name,
                            'aptitude_id' => $key,
                            'subject_id' => $subject
                        ]);

                        MapTeacherSubject::create($map_teacher_data);
                    }
                }
            }

            //insert noti to admin
            $admin_noti = new AdminNotification();
            $admin_noti->member_id = $member->member_id;
            $admin_noti->member_fullname = $member->member_fname.' '.$member->member_lname;
            $admin_noti->noti_to = 'all';
            $admin_noti->noti_type = 'register_teacher';
            $admin_noti->noti_status = '0';
            $admin_noti->save();

            //send noti
            sendAdminNoti($admin_noti->noti_to);

            return redirect('/')->with('alert', 'member');
        }
    }

    public function checkEmail(Request $request){
        $members = Member::select('member_email','member_status')
        ->where('member_status', '!=', '2')
        ->where('member_status', '!=', '3')
        ->Where('member_status', '!=', '4')
        ->get();
        return $members;
    }

    public function checkFullName(Request $request)
    {
        $check_member_name = Member::where('member_fname', '=', $request->fname)
                            ->where('member_lname', '=', $request->lname)
                            ->where('member_status', '!=', '2')
                            ->where('member_status', '!=', '3')
                            ->Where('member_status', '!=', '4')
                            ->count();

        if($check_member_name > 0){
            $status = 'false';
            return $status;
        }else{
            $status = 'true';
            return $status;
        }
    }

    public function get_email_student(Request $request){
        $members = Member::select('member_email','member_status')
        ->where('member_status', '=', '1')
        ->Where('_id', '<>', Auth::guard('members')->user()->id)
        ->get();
        return $members;
    }

    public function upFile(Request $request){
        foreach($request->userpic as $i => $item){
            $fielName =  Str::random(7).time().".jpg";

            $url = public_path("/storage/fileUpload/".$fielName);
            $filename = compress_image($item, $url, 50);

            $save[] = $fielName;
        }
        return $save;
    }

    public function profile_cousres(Request $request){
        $cousres = Course::where('member_id', Auth::guard('members')->user()->id)
            ->orderBy('created_at','desc')
            ->paginate(3);

        foreach ($cousres as $key => $value) {
            $count_date = count($value->course_date);
            $classroom = Classroom::where('course_id', $value->_id)->first();

            $classroom_status = 2;

            if($classroom){
                $cousres[$key]->student = count($classroom->classroom_student);
                $cousres[$key]->student_name = $classroom->classroom_student;

                $check_classroom = Classroom::where('course_id', $value->_id)
                                    ->where('classroom_date', date('Y-m-d'))
                                    ->first();
                $classroom_status = (isset($check_classroom->classroom_status))?$check_classroom->classroom_status:2;
            }

            $cousres[$key]->classroom_status = $classroom_status;

            $aptitude = Aptitude::where('_id', $value->course_group)->first();
            $subject = Subject::where('_id', $value->course_subject)->first();

            if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
                $cousres[$key]->course_group = $aptitude->aptitude_name_en;
                $cousres[$key]->course_subject = $subject->subject_name_en;
            }
            else{
                $cousres[$key]->course_group = $aptitude->aptitude_name_th;
                $cousres[$key]->course_subject = $subject->subject_name_th;
            }


            $link_open = MemberNotification::where('course_id', $value->_id)
                      ->where('classroom_date', date('Y-m-d'))
                      ->where('noti_type', 'open_course_teacher')
                      ->first();
            if($link_open){
                $cousres[$key]->link_open = $link_open->_id;
            }
            else{
                $cousres[$key]->link_open = '';
            }
        }

        if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            App::setLocale('en');
        }
        else {
            App::setLocale('th');
        }

        $course_edit = Lang::get('frontend/members/title.edit_button');
        $free_course = Lang::get('frontend/members/title.free_course');
        $course_document = Lang::get('frontend/members/title.course_document');
        $download_button = Lang::get('frontend/members/title.download_button');
        $close_register = Lang::get('frontend/members/title.close_register');
        $openning_register = Lang::get('frontend/members/title.openning_register');
        $waiting_register = Lang::get('frontend/members/title.waiting_register');
        $course_detail = Lang::get('frontend/members/title.course_detail');
        $student_number = Lang::get('frontend/members/title.student_number');

        $data = array(
            'cousres' => $cousres,
            'free_course' => $free_course,
            'course_document' => $course_document,
            'download_button' => $download_button,
            'close_register' => $close_register,
            'openning_register' => $openning_register,
            'waiting_register' => $waiting_register,
            'course_detail' => $course_detail,
            'student_number' => $student_number,
            'course_edit' => $course_edit,
        );
        return json_encode($data);
    }

    public function profile_coins(Request $request){
        // $data_coins =[];
        // $count = 0;
        $coins = CoinsLog::where('member_id', '=', Auth::guard('members')->user()->id)
                ->orderBy('created_at','desc')->paginate(3);

        if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            App::setLocale('en');
        }
        else {
            App::setLocale('th');
        }

        $topup = Lang::get('frontend/members/title.topup');
        $withdraw = Lang::get('frontend/members/title.withdraw');

        $pay = Lang::get('frontend/members/title.pay');
        $get = Lang::get('frontend/members/title.get');
        $return = Lang::get('frontend/members/title.return');
        $deduct = Lang::get('frontend/members/title.deduct');
        $refund = Lang::get('frontend/coins/title.refund');

        $waiting_approve = Lang::get('frontend/members/title.waiting_approve');
        $approved = Lang::get('frontend/members/title.approved');
        $not_approved = Lang::get('frontend/members/title.not_approved');
        $success = Lang::get('frontend/members/title.success');
        $course_detail = Lang::get('frontend/members/title.course_detail');

        $data = array(
            // 'data_coins' => $coins,
            'coins' => $coins,
            'topup' => $topup,
            'withdraw' => $withdraw,

            'pay' => $pay,
            'get' => $get,
            'return' => $return,
            'deduct' => $deduct,
            'refund' => $refund,

            'waiting_approve' => $waiting_approve,
            'approved' => $approved,
            'not_approved' => $not_approved,
            'success' => $success,
            'course_detail' => $course_detail,
        );
        return json_encode($data);
    }

    public function profile_alerts(Request $request){

      if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
          $lang = 'en';
      }else{
          $lang = 'th';
      }

      $member_id = Auth::guard('members')->user()->member_id;
      $member_noti = MemberNotification::where('member_id', $member_id)
                      ->orderby('created_at','desc')
                      ->paginate(3);

      foreach ($member_noti as $noti) {
          if($noti->noti_type=="open_course_student" || $noti->noti_type=="open_course_teacher"){
              $price = Course::where('_id', '=', $noti->course_id)
                  ->select('course_price')
                  ->first();
          }


          if(isset($noti->classroom_time_start) || isset($noti->classroom_time_end)){
              $noti->classroom_time_start = substr($noti->classroom_time_start,0,5);
              $noti->classroom_time_end = substr($noti->classroom_time_end,0,5);
          }
      }


      if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
          App::setLocale('en');
          $lang = "en";
      }
      else{
        App::setLocale('th');
          $lang = "th";
      }

      $data = array(
        'alerts' => $member_noti,
        'lang' => $lang,

      );
      return json_encode($data);

    }

    public function profile_request(Request $request){

      $request = RequestSubjects::where('teacher_id', Auth::guard('members')->user()->id)
          ->orderBy('created_at','desc')
          ->paginate(3);

      foreach ($request as $key => $value) {
        $member = Member::where('_id', Auth::guard('members')->user()->id)->first();
        $request[$key]->member_rate_start = number_format($member->member_rate_start);
        $request[$key]->member_rate_end = number_format($member->member_rate_end);

        $aptitude = Aptitude::where('_id', $value->request_group_id)->first();
        $subject = Subject::where('_id', $value->request_subject_id)->first();

        if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            $request[$key]->course_group = $aptitude->aptitude_name_en;
            $request[$key]->course_subject = $subject->subject_name_en;
        }
        else {
            $request[$key]->course_group = $aptitude->aptitude_name_th;
            $request[$key]->course_subject = $subject->subject_name_th;
        }
      }

        if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
          App::setLocale('en');
        }
        else {
          App::setLocale('th');
        }

        $data = array(
          'request' => $request,
        );
      return json_encode($data);
    }

    public function open_modal_request($id){

        $request = RequestSubjects::where('_id', $id)
            ->orderBy('created_at','desc')
            ->get();

        foreach ($request as $key => $value) {
          $member = Member::where('_id', Auth::guard('members')->user()->id)->first();
          $request[$key]->member_rate_start = $member->member_rate_start;
          $request[$key]->member_rate_end = $member->member_rate_end;

          $aptitude = Aptitude::where('_id', $value->request_group_id)->first();
          $subject = Subject::where('_id', $value->request_subject_id)->first();

          if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            $request[$key]->course_group = $aptitude->aptitude_name_en;
            $request[$key]->course_subject = $subject->subject_name_en;
          }
          else{
            $request[$key]->course_group = $aptitude->aptitude_name_th;
            $request[$key]->course_subject = $subject->subject_name_th;
          }

        }

      return json_encode($request);
    }

    public function profile(){
        $members = Member::where('_id', '=', Auth::guard('members')->user()->id)->first();

        //ข้อมูลธนาคาร
        $bank_master = BankMaster::orderBy('bank_name_th','asc')->get();
        // $data_bank = [];
        // for ($i=0; $i < count($members->member_bank); $i++) {
        //   foreach ($bank_master as $key_bank => $value_bank) {
        //     if ($value_bank->_id == $members->member_bank[$i][0]) {
        //       $data_bank_arr = array(
        //         'bank_name_th' => $value_bank->bank_name_th,
        //         'bank_name_en' => $value_bank->bank_name_en,
        //         'bank_id' => $value_bank->_id,
        //         'bank_account_number' => $members->member_bank[$i][1],
        //       );
        //       $data_bank[$i] = $data_bank_arr;

        //     }
        //   }
        // }
        //return $data_bank;

        //ข้อมูลธนาคารของ user
        $member_bank = MemberBank::where('member_id', Auth::guard('members')->user()->_id)
                      ->orderby('created_at','asc')
                      ->get();

        $members->member_bank = $member_bank;

        //return $member_bank;

        $members->detail_aptitude = [];
        if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            foreach (array_keys($members->member_aptitude) as $key => $aptitude_id) {
                $aptitude = Aptitude::where('_id', $aptitude_id)->first();
                if($aptitude){
                    $detail_subject[$aptitude->aptitude_name_en] = [];
                    foreach ($members->member_aptitude[$aptitude_id] as $key => $subject_id) {
                        $subject = Subject::where('_id', $subject_id)->first();
                        if($subject){
                            $detail_subject[$aptitude->aptitude_name_en][] = $subject->subject_name_en;
                        }
                    }
                }
            }
        }
        else{
            foreach (array_keys($members->member_aptitude) as $key => $aptitude_id) {
                $aptitude = Aptitude::where('_id', $aptitude_id)->first();
                if($aptitude){
                    $detail_subject[$aptitude->aptitude_name_th] = [];
                    foreach ($members->member_aptitude[$aptitude_id] as $key => $subject_id) {
                        $subject = Subject::where('_id', $subject_id)->first();
                        if($subject){
                            $detail_subject[$aptitude->aptitude_name_th][] = $subject->subject_name_th;
                        }
                    }
                }
            }
        }
        if(isset($detail_subject)){
            $members->detail_aptitude = $detail_subject;
        }else{
            $members->detail_aptitude = [];
        }

        $cousres = Course::where('member_id', Auth::guard('members')->user()->id)
            ->orderBy('created_at','desc')
            ->get();

        foreach ($cousres as $key => $value) {
            $count_date = count($value->course_date);
            $classroom = Classroom::where('course_id', $value->id)->first();
            if($classroom){
                $cousres[$key]->student = count($classroom->classroom_student);
                $cousres[$key]->student_name = $classroom->classroom_student;
            }

            $link_open = MemberNotification::where('course_id', $value->id)
                        ->where('classroom_date', date('Y-m-d'))
                        ->where('noti_type', 'open_course_teacher')
                        ->first();
            if($link_open){
                if(date('H:i:s') > date("H:i:s",strtotime($link_open->classroom_time_start." -10 minutes")) &&
                date('H:i:s') < $link_open->classroom_time_end){
                    $cousres[$key]->link_open = $link_open->id;
                }elseif(date('H:i:s') > $link_open->classroom_time_end) {
                    $cousres[$key]->status_show = "false";
                }
            }else{
                if(date('Y-m-d H:i:s') > $value->course_date[0]['date']." ".$value->course_date[0]['time_start']){
                    $cousres[$key]->status_show = "false";
                }
            }
            if(date('Y-m-d') > $value->course_date[$count_date-1]['date']){
                $cousres[$key]->status_show = "false";
            }

            if($value->course_status == "close" && date('Y-m-d H:i:s') > $value->course_date[0]['date']." ".$value->course_date[0]['time_start']
            ){
                $cousres[$key]->status_show = "false";
            }

        }

        //dd($cousres);
        //ประวัติ Coins
        $data_coins =[];
        $count = 0;
        $coins = Coin::where('member_id', '=', Auth::guard('members')->user()->id)->get();
        foreach ($coins as $key => $value) {
            $data_coins[$key]['type'] = "เติม";
            $data_coins[$key]['number'] = $value->coin_number;
            $data_coins[$key]['date'] = date('d/m/Y', strtotime($value->coin_date));
            $data_coins[$key]['time'] = date('H:i', strtotime($value->coin_time));
            $data_coins[$key]['bank'] = $value->coin_bank;
            $data_coins[$key]['status'] = $value->coin_status;
            $data_coins[$key]['date_time'] = date('Y-m-d', strtotime($value->coin_date))." ".$value->coin_time;
            $count = $key;
        }
        $withdraw = Withdraw::where('member_id', '=', Auth::guard('members')->user()->id)->get();
        foreach ($withdraw as $key => $value) {
            $data_coins[$count+$key+1]['type'] = "ถอน";
            $data_coins[$count+$key+1]['number'] = $value->withdraw_coin_number;
            $data_coins[$count+$key+1]['date'] = date('d/m/Y', strtotime($value->withdraw_date));
            $data_coins[$count+$key+1]['time'] = date('H:i', strtotime($value->withdraw_time));
            $data_coins[$count+$key+1]['bank'] = $value->withdraw_bank;
            $data_coins[$count+$key+1]['status'] = $value->withdraw_status;
            $data_coins[$count+$key+1]['date_time'] = date('Y-m-d', strtotime($value->withdraw_date))." ".$value->withdraw_time;
        }
        $keys  = array_column($data_coins, 'date_time');
        array_multisort($keys , SORT_DESC, $data_coins);

        //ประวัติการแจ้งเตือน
        $member_noti = MemberNotification::where('member_id', '=', Auth::guard('members')->user()->id)->get();
        foreach ($member_noti as $noti) {
            $noti->classroom_date = $noti->classroom_date;
            $noti->classroom_time_start = substr($noti->classroom_time_start,0,5);
            $noti->classroom_time_end = substr($noti->classroom_time_end,0,5);
        }



        update_last_action();

        return view('frontend.members.member-profile', compact('members','cousres', 'data_coins'));
    }

    public function detail($id){
        $members = Member::where('_id', $id)->first();

        $members->detail_aptitude = [];
        if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            foreach (array_keys($members->member_aptitude) as $key => $aptitude_id) {
                $aptitude = Aptitude::where('_id', $aptitude_id)->first();
                if($aptitude){
                    $detail_subject[$aptitude->aptitude_name_en] = [];
                    foreach ($members->member_aptitude[$aptitude_id] as $key => $subject_id) {
                        $subject = Subject::where('_id', $subject_id)->first();
                        if($subject){
                            $detail_subject[$aptitude->aptitude_name_en][] = $subject->subject_name_en;
                        }
                    }
                }
            }
        }
        else{
            foreach (array_keys($members->member_aptitude) as $key => $aptitude_id) {
                $aptitude = Aptitude::where('_id', $aptitude_id)->first();
                if($aptitude){
                    $detail_subject[$aptitude->aptitude_name_th] = [];
                    foreach ($members->member_aptitude[$aptitude_id] as $key => $subject_id) {
                        $subject = Subject::where('_id', $subject_id)->first();
                        if($subject){
                            $detail_subject[$aptitude->aptitude_name_th][] = $subject->subject_name_th;
                        }
                    }
                }
            }
        }
        $members->detail_aptitude = $detail_subject;

        $course = Course::where('member_id', $id)->get();
        foreach ($course as $key => $value) {
            $classroom = Classroom::where('course_id', $value->id)
            ->first();
            if($classroom){
                $course[$key]->student = count($classroom->classroom_student);
                $course[$key]->student_name = $classroom->classroom_student;
            }
            if(Auth::guard('members')->user()){
                $classroom_register = Classroom::where('course_id', $value->id)
                ->where('classroom_student.student_id', '=',  Auth::guard('members')->user()->id)
                ->first();
                if($classroom_register){
                    $course[$key]->register = "register";
                }
            }
            $aptitude = Aptitude::where('_id', $value->course_group)->first();
            $course[$key]->aptitude_detail = $aptitude;

            $subject = Subject::where('_id', $value->course_subject)->first();
            $course[$key]->subject_detail = $subject;
        }

        // $members_id = $id;

        update_last_action();

        return view('frontend.members.member-detail', compact('members', 'course'));
    }

    public function member_course(Request $request){
        $members = Member::where('_id', $request->id)->first();
        $course = Course::where('member_id', $request->id)->paginate(4);
        $members_id = $request->id;

        foreach ($course as $key => $value) {
            $classroom = Classroom::where('course_id', $value->id)
            ->first();
            if($classroom){
                $course[$key]->student = count($classroom->classroom_student);
                $course[$key]->student_name = $classroom->classroom_student;
            }
            if(Auth::guard('members')->user()){
                $classroom_register = Classroom::where('course_id', $value->id)
                ->where('classroom_student.student_id', '=',  Auth::guard('members')->user()->id)
                ->first();
                if($classroom_register){
                    $course[$key]->register = "register";
                }
            }
        }

        if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            App::setLocale('en');
        }
        else{
            App::setLocale('th');
        }

        $free_course = Lang::get('frontend/members/title.free_course');
        $course_document = Lang::get('frontend/members/title.course_document');
        $download_button = Lang::get('frontend/members/title.download_button');
        $course_detail = Lang::get('frontend/members/title.course_detail');

        $data = array(
          'course' => $course,
          'free_course' => $free_course,
          'course_document' => $course_document,
          'download_button' => $download_button,
          'course_detail' => $course_detail,
        );

        // update_last_action();

        return json_encode($data);

        // return view('frontend.members.member-detail',  compact('members', 'course', 'members_id'));
    }

    public function edit(){
        $members = Member::where('_id', '=', Auth::guard('members')->user()->id)->first();
        $month = array("มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ","กรกฎาคม ","สิงหาคม ","กันยายน ","ตุลาคม ","พฤศจิกายน ","ธันวาคม ");
        $chk = '';
        foreach(array_keys($members->member_aptitude) as $i => $item) {
            if($members->member_aptitude[$item]){
                    $Subject = Subject::whereIn('subject_id', $members->member_aptitude[$item])->get();
                    $chk .= $Subject;
                    $value[get_aptitude_level($item)] = $Subject;
            }
        }
        if($chk){
            $members['subject_detail'] = $value;
        }else{
            $members['subject_detail'] = [];
        }


        $aptitude = Aptitude::all();
        foreach($aptitude as $i => $item) {
            if($aptitude[$i]->aptitude_subject){
                    $Subject = Subject::whereIn('subject_id', $aptitude[$i]->aptitude_subject)->get();
                    $data[$item->aptitude_name] = $Subject;
            }
        }
        $aptitude['subject_detail'] = $data;

        $events = Event::where('event_status', '1')
                            ->where('event_start_date', '<=', date('Y-m-d'))
                            ->where('event_end_date', '>=', date('Y-m-d'))
                            ->orderBy('created_at','asc')
                            ->get();

        update_last_action();

        return view('frontend.members.member-edit', compact('members','month','aptitude','events'));
    }

    public function imgprofile(Request $request){
        $fielName =  Str::random(7).time().".jpg";

        $url = public_path("/storage/memberProfile/".$fielName);
        $file = compress_image($request->img, $url, 80);

        $members = Member::where('_id', Auth::guard('members')->user()->id)->first();
        $path = public_path("/storage/memberProfile/".$members->member_img);
        File::delete($path);

        $members->member_img = $fielName;
        $members->save();

        return $fielName;
    }

    public function imgprofilereload() {
        return redirect('members/profile/')->with('imgprofile', 'success');
    }

    public function changeaccount() {
        if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            App::setLocale('en');
        }
        else{
            App::setLocale('th');
        }

        $members = Member::where('_id', '=',  Auth::guard('members')->user()->id)->first();
        if($members->member_role == "teacher"){
            $members->member_role = "student";
            $members->save();
            return redirect('/')->with('changeaccount', trans('frontend/layouts/modal.student_role'));
        } else{
            $members->member_role = "teacher";
            $members->save();
            return redirect('/')->with('changeaccount', trans('frontend/layouts/modal.teacher_role'));
        }
    }

    public function updatedata(Member $members){
        if($members->member_status=='2'){
            $subject_list = array();
            $aptitude = Aptitude::orderBy('created_at','asc')->get();;

            foreach($aptitude as $i => $item) {
                foreach ($item->aptitude_subject as $key => $subject_id) {
                    $Subject = Subject::where('_id', $subject_id)->first();
                    $subject_list[] = $Subject;
                }
                $aptitude[$i]->subject_detail = $subject_list;
                $subject_list = [];
            }
            $members->detail_aptitude = [];
            foreach (array_keys($members->member_aptitude) as $key => $aptitude_id) {
                $aptitude_detail = Aptitude::where('_id', $aptitude_id)->first();
                if($aptitude_detail){
                    $detail_subject[$aptitude_detail->aptitude_name_en] = [];
                    foreach ($members->member_aptitude[$aptitude_id] as $key => $subject_id) {
                        $subject = Subject::where('_id', $subject_id)->first();
                        if($subject){
                            $detail_subject[$aptitude_detail->aptitude_name_en][] = $subject->subject_name_en;
                        }
                    }
                }
            }
            $members->detail_aptitude = $detail_subject;
            //dd($members->detail_aptitude["primary school 1"]);
                // $subject = Subject::where('_id', '5d64aab8108c191ca400234d');
                // $subject->orderby('created_at','desc');
                // $res = $subject->get();
                // dd($res);

                //$aptitude['subject_detail'] = $data;

            $events = Event::where('event_status', '1')
                            ->where('event_start_date', '<=', date('Y-m-d'))
                            ->where('event_end_date', '>=', date('Y-m-d'))
                            ->orderBy('created_at','asc')
                            ->get();

            update_last_action();
            return view('frontend.members.member-update', compact('members', 'aptitude', 'events'));
        }
        else{
            update_last_action();
            return view('backend.404');
        }
    }

    public function list_student(Request $request){

        $classroom = Classroom::where('course_id', '=', $request->course_id)
            ->select('classroom_student')
            ->groupBy('course_id')->first();
        $students = $classroom->classroom_student;

        update_last_action();

        //return $students;
        return view('frontend.members.list_student', compact('students'));
    }

    public function student_status($course_id){
        $course = Course::where('_id', '=', $course_id)->first();
        $i = '0';
        // dd($course->_id);
        // $list_student = [];
        if ($course->course_category == "Public") {
          $classroom = Classroom::where('course_id', $course->_id)->first();
          foreach ($classroom->classroom_student as $key => $value) {

                $list_student[$i]['student_name'] = $value['student_fname']." ".$value['student_lname'];
                $list_student[$i]['student_email'] = $value['student_email'];
                $list_student[$i]['student_tell'] = $value['student_tell'];
                $list_student[$i]['student_date'] = date('d/m/Y', strtotime($value['student_date_regis']));
                $list_student[$i]['category'] = "Public";
                $list_student[$i]['student_id'] = $value['student_id'];
                $i = $i+1;
          }
        }else {
          foreach ($course->course_student as $value) {
              $student = Member::where('member_email', '=', $value)->first();

              if($student){
                $list_student[$i]['student_name'] = $student->member_fname." ".$student->member_lname;
                $list_student[$i]['student_email'] = $student->member_email;
                $list_student[$i]['student_tell'] = $student->member_tell;
                $list_student[$i]['category'] = "Private";
                $list_student[$i]['student_id'] = $student->_id;
                $status = Classroom::where('course_id', '=', $course_id)
                    ->where('classroom_student.student_id', '=', $student->id)
                    ->first();

                if($status){
                    $list_student[$i]['student_status'] = "1";
                    $list_student[$i]['student_date'] = date('d/m/Y', strtotime($status->created_at));
                }else{
                    $list_student[$i]['student_status'] = "0";
                }
                $i = $i+1;
              }else {
                // dd("0000");
                $list_student[$i] = [
                  'student_email' => "-",
                  'student_name' => "-",
                  'student_status' => "0",
                  'student_tell' => "-",
                  'student_date' => "-",
                  'category' => "Private",
                  'student_id' => ''
                ];
              }
          }
        }


        return json_encode($list_student);
    }

    public function update_profile_member(Request $request){
        $update_aptitude = array();
        $aptitude = Aptitude::orderBy('created_at','asc')->get();
        foreach ($aptitude as $key1 => $value1) {
            $check_same = 0;
            $update_aptitude[$value1['_id']] = array();

            foreach ($request['data']['member_aptitude'] as $key2 => $value2) {
                //$value1['_id'] = aptitude_id ทั้งหมด
                //$key2 = aptitude_id ที่เลือก

                if($value1['_id'] == $key2){
                    $check_same = 1;
                    $update_aptitude[$value1['_id']] = $value2;
                }
            }
        }
        //dd($update_aptitude);
        //dd($request['data']['member_aptitude']);
        //dd($request['data']['member_aptitude']['5dc9f4d1108c1930d800560e']);

        $input =  $request['data'];
        // dd($input['member_bank']);
        $origDate = $input['member_Bday'];
        $date = str_replace('/', '-', $origDate );
        $member_Bday = date("Y-m-d", strtotime($date));

        $member_update = Member::where('member_id', '=', $input['member_id'])->first();
        $member_update->member_Bday = $member_Bday;
        $member_update->member_email = $input['member_email'];
        $member_update->member_tell = $input['member_tell'];
        $member_update->member_idLine = $input['member_idLine'];
        $member_update->member_sername = $input['member_sername'];
        $member_update->member_fname = $input['member_fname'];
        $member_update->member_lname = $input['member_lname'];
        $member_update->member_nickname = $input['member_nickname'];
        $member_update->member_rate_start = intval(preg_replace("/[,]/", "", $input['member_rate_start']));
        $member_update->member_rate_end = intval(preg_replace("/[,]/", "", $input['member_rate_end']));
        $member_update->member_address = $input['member_address'];
        $member_update->member_exp = ($input['member_exp']=='')?array():$input['member_exp'];
        $member_update->member_cong = ($input['member_cong']=='')?array():$input['member_cong'];
        $member_update->member_aptitude = $update_aptitude;
        $member_update->save();

        $del = MemberBank::where('member_id',Auth::guard('members')->user()->id)->delete();
        foreach ($input['member_bank'] as $key => $value) {
            $bank_master = BankMaster::where('_id',$value[0])->first();

            $data = ([
                'member_id' => Auth::guard('members')->user()->_id,
                'bank_id' => $value[0],
                'bank_name_en' => $bank_master->bank_name_en,
                'bank_name_th' => $bank_master->bank_name_th,
                'bank_account_number' => $value[1],
            ]);
            // dd($data);
            MemberBank::create($data);
        }

        if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            App::setLocale('en');
            $text = [
                'success' => "success",
            ];
        }
        else{
            App::setLocale('th');
            $text = [
                'success' => "บันทึกสำเร็จ",
            ];
        }

        return $text;
    }

    public function downloadStudentDoc(){
        return response()->download(storage_path("app/public/document/Student_Document_Suksa_Online.pdf"));
    }

    public function downloadTeacherDoc(){
        return response()->download(storage_path("app/public/document/Teacher_Document_Suksa_Online.pdf"));
    }

    public function check_email_forgot_password(Request $request){
        $input =  $request['data'];

        $check_email = "false";
        $email_all = Member::where('member_email', $input)->first();

        if ($email_all) {
          $check_email = "true";

          srand((double)microtime()*10000000);
        	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        	$ret_str = "";
        	$num = strlen($chars);
        	for($i = 0; $i < 8; $i++)
        	{
        		$ret_str.= $chars[rand()%$num];
        		$ret_str.="";
        	}
          // Hash::make($email_all['member_password']);
        	// dd($ret_str,$email_all['member_email'],$email_all['member_id'],$email_all['member_fname'].' '.$email_all['member_lname']);

          $member_update = Member::where('member_email', $input)->first();
          $member_update->member_password = Hash::make($ret_str);
          $member_update->save();

          //send email
          $titel = 'Reset Password';
          $subject = 'ระบบได้ทำการ Reset Password ให้เรียบร้อย';
          $from_name = 'ATWORK';
          $from_email = 'noreply@suksa.online';
          $to_name = $email_all['member_fname'].' '.$email_all['member_lname'];
          $to_email = $email_all['member_email'];
          $description = '';
          $data = array(
              'titel' => $titel,
              'subject'=> $subject,
              'username' => $email_all['member_email'],
              'password' => $ret_str,
              'description' => $description
          );

          Mail::send('frontend.send_email_forgot_password', $data, function($message) use ($titel, $from_name, $from_email, $to_name, $to_email) {
              $message->from($from_email, $from_name);
              $message->to($to_email, $to_name);
              $message->subject($titel);
          });

        }
        // dd($email_all,$check_email);
        if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            App::setLocale('en');
            if ($check_email == "true") {
              $text = [
                  'success' => "The system has sent a new password to the registered email",
              ];
            }else {
              $text = [
                  'false' => "Data not found. Please make a transaction again",
              ];
            }
        }
        else{
            App::setLocale('th');
            if ($check_email == "true") {
              $text = [
                  'success' => "ระบบได้ทำการส่งรหัสผ่านใหม่".'<br>'."ไปทางอีเมลที่ลงทะเบียนไว้",
              ];
            }else {
              $text = [
                  'false' => "ไม่พบข้อมูลในระบบ".'<br>'."กรุณาทำรายการใหม่อีกครั้ง",
              ];
            }

        }

        if ($check_email == "true") {
          return $text;
        }else {
          return $text;
        }

    }

    public function check_password($pass){
        // $input =  $request['data'];
        $check_password_member = Member::where('member_id', Auth::guard('members')->user()->id)->first();
        // dd($check_password_member['member_password']);
        if(Hash::check($pass, $check_password_member['member_password'])) {
          $pass = "true";
        }else {
          $pass = "false";
        }

        return $pass;
    }
    public function update_password_member(Request $request){
        $input =  $request['data'];
        $password_member = Member::where('member_id', Auth::guard('members')->user()->id)->first();
        // dd($input,$password_member);
        if ($password_member) {
          $member_update = Member::where('member_id', $password_member['member_id'])->first();
          $member_update->member_password = Hash::make($input['input_confirm_password']);
          $member_update->save();

          if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
              App::setLocale('en');
                $text = [
                    'success' => "Password changed successfully",
                ];
          }
          else{
              App::setLocale('th');
                $text = [
                    'success' => "เปลี่ยนรหัสผ่านสำเร็จ",
                ];
          }
        }
        else {
          if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
              App::setLocale('en');

                $text = [
                    'false' => "Password change unsuccessful",
                ];

          }
          else{
              App::setLocale('th');

                $text = [
                    'false' => "เปลี่ยนรหัสผ่านไม่สำเร็จ",
                ];

          }
        }

        return $text;
    }

    public function show(){

    }


}
