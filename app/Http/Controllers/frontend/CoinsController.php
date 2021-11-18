<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Bank;
use App\Models\BankMaster;
use App\Models\Classroom;
use App\Models\Coin;
use App\Models\CoinsLog;
use App\Models\Course;
use App\Models\Member;
use App\Models\MemberBank;
use App\Models\Refund;
use App\Models\Withdraw;
use Auth;

use App\Models\AdminNotification;
use Mail;

class CoinsController extends Controller
{
    public function add(){
        if((Auth::guard('members')->user()->member_type == 'student') || (Auth::guard('members')->user()->member_role == 'student')){
            $bank = Bank::where('bank_status', '1')
                    ->orderby('created_at','asc')
                    ->get();

            $member_bank = MemberBank::where('member_id', Auth::guard('members')->user()->_id)
                        ->orderby('created_at','asc')
                        ->get();

            update_last_action();

            if(count($member_bank) > 0){
                return view('frontend.coins.coin-add', compact('bank','member_bank'));
            }
            else{
                return redirect()->back()->with('add_member_bank', 'fales');
            }
        }
        else{
            return redirect('/');
        }
    }

    public function save(Request $request){
        //return $request->upload_slip;
        //$date = date('Y-m-d', strtotime($request->coin_date));

        $coin_date = explode("/",$request->coin_date);
        $date = $coin_date[2].'-'.$coin_date[1].'-'.$coin_date[0];

        $time = $request->h.":".$request->m.":00";
        $fielName =  Str::random(7).time().".jpg";

        //$slip_path = public_path("/storage/slip/");

        $slip_path = Storage::disk('public')->path('slip/');
        if (!file_exists($slip_path)) {
            mkdir($slip_path, 0777, true);
        }

        $url = public_path("/storage/slip/".$fielName);
        $file = compress_images($request->upload_slip, $url, 80);


        $bank = Bank::where('_id', $request->coin_bank)->first();
        $coin_bank_name_th = $bank->bank_name_th;
        $coin_bank_name_en = $bank->bank_name_en;
        $coin_account_number = $bank->bank_account_number;

        $member_bank = MemberBank::where('_id', $request->member_bank)->first();
        $member_bank_name_th = $member_bank->bank_name_th;
        $member_bank_name_en = $member_bank->bank_name_en;
        $member_account_number = $member_bank->bank_account_number;
        //$api_bank_id = ($member_bank->api_bank_id)?$member_bank->api_bank_id:'';
        
        $check_bank_master = BankMaster::where('_id',$bank->bank_id)->first();
        $api_bank_id = $check_bank_master->api_bank_id;

        $data = ([
            'member_id' => Auth::guard('members')->user()->_id,
            'member_fname' => Auth::guard('members')->user()->member_fname,
            'member_lname' => Auth::guard('members')->user()->member_lname,
            //'coin_bank' => $request->coin_bank, //ชื่อธนาคาร (โอนเงินเข้าธนาคารไหน)

            'coin_bank_id' => $request->coin_bank, 
            'coin_bank_name_th' => $coin_bank_name_th,
            'coin_bank_name_en' => $coin_bank_name_en, 
            'coin_account_number' => $coin_account_number, 
            'api_bank_id' => $api_bank_id,
            'coin_date' => $date,
            'coin_time' => $time,
            'member_bank_id' => $request->member_bank, //id ของ bank ที่ผูกกับ member (โอนเงินจากธนาคารไหน)
            'member_bank_name_th' => $member_bank_name_th,
            'member_bank_name_en' => $member_bank_name_en,
            'member_account_number' => $member_account_number,
            //'api_bank_id' => $api_bank_id,

            'coin_number' => $request->coin_number,
            'coin_slip' => $fielName,
            'coin_status' => '0',
            'coin_approve' => '',
            'coin_type' => 'add',
        ]);
        Coin::create($data);
        $coin = Coin::orderBy('created_at','desc')->first();
        $topup_id = $coin->_id;

        $data_log = ([
            'member_id' => Auth::guard('members')->user()->_id,
            'member_fname' => Auth::guard('members')->user()->member_fname,
            'member_lname' => Auth::guard('members')->user()->member_lname,
            'event' => 'topup_coins',
            'ref_id' => $topup_id,

            'bank_id' => $request->coin_bank, 
            'bank_name_th' => $coin_bank_name_th,
            'bank_name_en' => $coin_bank_name_en, 
            'bank_account_number' => $coin_account_number, 
            'api_bank_id' => $api_bank_id, 
            'coin_date' => $date,
            'coin_time' => $time,
            'member_bank_id' => $request->member_bank, //id ของ bank ที่ผูกกับ member (โอนเงินจากธนาคารไหน)
            'member_bank_name_th' => $member_bank_name_th,
            'member_bank_name_en' => $member_bank_name_en,
            'member_account_number' => $member_account_number,

            'coin_number' => $request->coin_number,
            'coin_slip' => $fielName,
            'coin_status' => '0',
            'approve_by' => '',
        ]);
        CoinsLog::create($data_log);

        //send email
        $subject = 'Suksa Online : เติม Coins';
        $from_name = 'Suksa Online';
        $from_email = 'noreply@suksa.online';
        $to_name = 'Suksa Admin';
        $to_email_1 = 'alisa@edispro.com';
        $to_email_2 = 'Act151751@hotmail.com';
        $to_email_3 = 'pornpimon@edispro.com';
        $description = '';
        $fullname = Auth::guard('members')->user()->member_fname.' '.Auth::guard('members')->user()->member_lname;
        $data = array('name'=>$to_name, "fullname" => $fullname, "coin_number" => $request->coin_number, "coin_date" => $date, "coin_time" => $time, "description" => $description);

        Mail::send('frontend.send_email_topup_coins', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email_1) {
            $message->from($from_email, $from_name);
            $message->to($to_email_1, $to_name);
            $message->subject($subject);
        });

        Mail::send('frontend.send_email_topup_coins', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email_2) {
            $message->from($from_email, $from_name);
            $message->to($to_email_2, $to_name);
            $message->subject($subject);
        });

        Mail::send('frontend.send_email_topup_coins', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email_3) {
            $message->from($from_email, $from_name);
            $message->to($to_email_3, $to_name);
            $message->subject($subject);
        });
        

        //insert noti to admin
        $admin_noti = new AdminNotification(); 
        $admin_noti->member_id = Auth::guard('members')->user()->member_id;
        $admin_noti->member_fullname = Auth::guard('members')->user()->member_fname.' '.Auth::guard('members')->user()->member_lname;
        $admin_noti->noti_to = 'all';
        $admin_noti->noti_type = 'topup_coins';
        $admin_noti->noti_status = '0';
        $admin_noti->save();

        //send noti 
        sendAdminNoti($admin_noti->noti_to);

        return redirect('/')->with('coins', 'success');
    }

    public function revoke(){
        $members = Member::where('_id', '=', Auth::guard('members')->user()->id)->first();

        $member_bank = MemberBank::where('member_id', Auth::guard('members')->user()->_id)
                    ->orderby('created_at','asc')
                    ->get();

        update_last_action();

        if(count($member_bank) > 0){
            return view('frontend.coins.coin-revoke', compact('members','member_bank'));
        }
        else{
            return redirect()->back()->with('add_member_bank', 'fales');
        }
    }

    public function show(){

    }

    public function saverevoke(Request $request){
        $member_coins = Auth::guard('members')->user()->member_coins;
        //เช็ค coins ว่าเพียงพอไหม
        if(str_replace(",","",$member_coins) < str_replace(",","",$request->withdraw_coin_number)){
            return redirect()->back()->with('saverevoke', 'fail');
        }
        //หัก coins นักเรียน
        $coins = str_replace(",","",$member_coins) - 
            str_replace(",","",$request->withdraw_coin_number);
        $student = Member::where('_id', '=', Auth::guard('members')->user()->id)->first();
        $student->member_coins = number_format($coins);
        $student->save();

        $member_bank = MemberBank::where('_id', $request->member_bank)->first();
        $member_bank_name_th = $member_bank->bank_name_th;
        $member_bank_name_en = $member_bank->bank_name_en;
        $member_account_number = $member_bank->bank_account_number;
        //$api_bank_id = ($member_bank->api_bank_id)?$member_bank->api_bank_id:'';

        $data = ([
            'member_id' => Auth::guard('members')->user()->_id,
            'member_fname' => Auth::guard('members')->user()->member_fname,
            'member_lname' => Auth::guard('members')->user()->member_lname,
            'withdraw_bank_id' => '',
            'withdraw_bank_name_en' => '',
            'withdraw_bank_name_th' => '',
            'withdraw_account_number' => '',
            'withdraw_coin_number' => $request->withdraw_coin_number,
            'withdraw_date' => date('Y-m-d'),
            'withdraw_time' => date('H:i:s'),

            'member_bank_id' => $request->member_bank, //id ของ bank ที่ผูกกับ member (โอนเงินเข้าธนาคารไหน)
            'member_bank_name_th' => $member_bank_name_th,
            'member_bank_name_en' => $member_bank_name_en,
            'member_account_number' => $member_account_number,
            //'api_bank_id' => $api_bank_id,

            'withdraw_status' => '0', 
            'withdraw_approve' => '',
            'withdraw_type' => '',
        ]);
        Withdraw::create($data);
        $withdraw = Withdraw::orderBy('created_at','desc')->first();
        $withdraw_id = $withdraw->_id;

        $data_log = ([
            'member_id' => Auth::guard('members')->user()->_id,
            'member_fname' => Auth::guard('members')->user()->member_fname,
            'member_lname' => Auth::guard('members')->user()->member_lname,
            'event' => 'withdraw_coins',
            'ref_id' => $withdraw_id,

            'bank_id' => '',
            'bank_name_th' => '',
            'bank_name_en' => '',
            'bank_account_number' => '',

            'coin_date' => date('Y-m-d'),
            'coin_time' => date('H:i:s'),

            'member_bank_id' => $request->member_bank, //id ของ bank ที่ผูกกับ member (โอนเงินเข้าธนาคารไหน)
            'member_bank_name_th' => $member_bank_name_th,
            'member_bank_name_en' => $member_bank_name_en,
            'member_account_number' => $member_account_number,
            //'api_bank_id' => $api_bank_id,
            
            'coin_number' => $request->withdraw_coin_number,
            'account_number' => $request->withdraw_account_number,
            'coin_status' => '0',
            'approve_by' => '',
        ]);
        CoinsLog::create($data_log);

        
        //send email
        $subject = 'Suksa Online : ถอน Coins';
        $from_name = 'Suksa Online';
        $from_email = 'noreply@suksa.online';
        $to_name = 'Suksa Admin';
        $to_email_1 = 'alisa@edispro.com';
        $to_email_2 = 'Act151751@hotmail.com';
        $to_email_3 = 'pornpimon@edispro.com';
        $description = '';
        $fullname = Auth::guard('members')->user()->member_fname.' '.Auth::guard('members')->user()->member_lname;
        $data = array('name'=>$to_name, "fullname" => $fullname, "coin_number" => $request->withdraw_coin_number, "coin_date" => date('Y-m-d'), "coin_time" => date('H:i:s'), "description" => $description);

        Mail::send('frontend.send_email_withdraw_coins', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email_1) {
            $message->from($from_email, $from_name);
            $message->to($to_email_1, $to_name);
            $message->subject($subject);
        });

        Mail::send('frontend.send_email_withdraw_coins', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email_2) {
            $message->from($from_email, $from_name);
            $message->to($to_email_2, $to_name);
            $message->subject($subject);
        });
        
        Mail::send('frontend.send_email_withdraw_coins', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email_3) {
            $message->from($from_email, $from_name);
            $message->to($to_email_3, $to_name);
            $message->subject($subject);
        });
        

        //insert noti to admin
        $admin_noti = new AdminNotification(); 
        $admin_noti->member_id = Auth::guard('members')->user()->member_id;
        $admin_noti->member_fullname = Auth::guard('members')->user()->member_fname.' '.Auth::guard('members')->user()->member_lname;
        $admin_noti->noti_to = 'all';
        $admin_noti->noti_type = 'withdraw_coins';
        $admin_noti->noti_status = '0';
        $admin_noti->save();

        //send noti 
        sendAdminNoti($admin_noti->noti_to);
        
        return redirect('/')->with('coinsrevoke', 'success');
    }

    public function refund(){
        update_last_action();

        $today = date('Y-m-d');
        //$now = date('H:i:s');
        //$min_refund_time = date('H:i:00', time() - 3540);
        //$max_refund_time = date('H:i:00', time() + 3600);

        $classrooms = Classroom::where('classroom_date', '=', $today)
                        //->where('classroom_time_end', '>=', $min_refund_time)
                        //->where('classroom_time_end', '<', $max_refund_time)
                        ->where('classroom_student.student_id', '=', Auth::guard('members')->user()->id)
                        ->where('classroom_status', '=', '2')
                        ->orderBy('created_at','asc')
                        ->get();

        $member_courses = array();
        $i = 0;

        foreach ($classrooms as $classroom) {
            $now = date('H:i:s');
            $min_refund_time = date('H:i:s', strtotime($classroom->classroom_time_end . "+60 seconds")); 
            $max_refund_time = date('H:i:s', strtotime($classroom->classroom_time_end . "+3600 seconds")); 

            // $courses[]['classroom_time_end'] = $member_course->classroom_time_end;
            // $courses[]['min_refund_time'] = $min_refund_time;
            // $courses[]['max_refund_time'] = $max_refund_time;

            if(($now >= $min_refund_time) && ($now < $max_refund_time)){ 
                $member_courses[] = $classroom;
            }
        }

        //return $member_courses;
        


        return view('frontend.coins.coin-refund', compact('member_courses'));

        // if(count($member_bank) > 0){
        //     return view('frontend.coins.coin-refund', compact('members','member_bank'));
        // }
        // else{
        //     return redirect('/');
        // }
    }

    public function saverefund(Request $request){
        
        $refund = Refund::where('course_id', $request->refund_course)
                    ->where('member_id', Auth::guard('members')->user()->_id)
                    ->first();

        //ถ้าเจอคนและคอร์สซ้ำ ให้ฟ้องว่า ไม่สามารถขอคืนเงินได้ เนื่องจากคุณเคยขอไปแล้ว 
        if(isset($refund)){
            return redirect()->back()->with('already_refund', 'false');
        }
        //ถ้าไม่เจอคนและคอร์สซ้ำ ให้ insert ข้อมูลใหม่
        else{
            $course = Course::where('_id', '=', $request->refund_course)->first();
            
            $refund_data = ([
                'member_id' => Auth::guard('members')->user()->_id,
                'member_fullname' => Auth::guard('members')->user()->member_fname.' '.Auth::guard('members')->user()->member_lname,
                'course_id' => $request->refund_course,
                'course_name' => $course->course_name,

                'teacher_id' => $course->member_id,
                'teacher_fullname' => $course->member_fname.' '.$course->member_lname,
                'course_price' => $course->course_price,
                
                'refund_reason' => $request->refund_reason,
                'refund_status' => '0',
                'refund_approve' => '',
                'refund_description' => '',
            ]);
            Refund::create($refund_data);

            //แก้ไขสถานะการจ่าย coins เป็น 2 
            $coins_log = CoinsLog::where('event', '=', 'pay_coins')
                        ->where('member_id', Auth::guard('members')->user()->_id)
                        ->where('ref_id', $request->refund_course)
                        ->update([
                          'coin_status' => '2'
                        ]);

            //send email
            $subject = 'Suksa Online : ขอคืนเงิน';
            $from_name = 'Suksa Online';
            $from_email = 'noreply@suksa.online';
            $to_name = 'Suksa Admin';
            $to_email_1 = 'alisa@edispro.com';
            $to_email_2 = 'Act151751@hotmail.com';
            $to_email_3 = 'pornpimon@edispro.com';
            //$to_email_4 = 'lookbaar@gmail.com';

            $description = '';
            $fullname = Auth::guard('members')->user()->member_fname.' '.Auth::guard('members')->user()->member_lname;
            $data = array(
                'name'=>$to_name, 
                "fullname" => $fullname, 
                "coin_number" => $course->course_price, 
                "course_name" => $course->course_name, 
                "refund_date" => date('Y-m-d'), 
                "refund_time" => date('H:i:s'), 
                "description" => $description
            );

            Mail::send('frontend.send_email_refund', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email_1) {
                $message->from($from_email, $from_name);
                $message->to($to_email_1, $to_name);
                $message->subject($subject);
            });

            Mail::send('frontend.send_email_refund', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email_2) {
                $message->from($from_email, $from_name);
                $message->to($to_email_2, $to_name);
                $message->subject($subject);
            });
            
            Mail::send('frontend.send_email_refund', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email_3) {
                $message->from($from_email, $from_name);
                $message->to($to_email_3, $to_name);
                $message->subject($subject);
            });
            
            // Mail::send('frontend.send_email_refund', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email_4) {
            //     $message->from($from_email, $from_name);
            //     $message->to($to_email_4, $to_name);
            //     $message->subject($subject);
            // });

            //insert noti to admin
            $admin_noti = new AdminNotification(); 
            $admin_noti->member_id = Auth::guard('members')->user()->member_id;
            $admin_noti->member_fullname = Auth::guard('members')->user()->member_fname.' '.Auth::guard('members')->user()->member_lname;
            $admin_noti->noti_to = 'all';
            $admin_noti->noti_type = 'refund';
            $admin_noti->noti_status = '0';
            $admin_noti->save();

            //send noti 
            sendAdminNoti($admin_noti->noti_to);

            return redirect('/')->with('refund', 'success');
        }
        
    }
}
