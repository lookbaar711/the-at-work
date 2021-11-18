<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Coin;
use App\Models\CoinsLog;
use App\Models\Course;
use App\Models\Withdraw;
use App\Models\Member;
use App\Models\BankTransaction;
use App\Models\MemberNotification;
use App\Models\Refund;
use App\Models\SaleCommission;
use App\Events\SendNotiFrontend;
use Sentinel;
use Auth;
use Mail;

class CoinsController extends Controller
{
    public function fill(){
        $coins = Coin::orderBy('created_at', 'desc')->get();

        return view('backend.coins.coins-fill', compact('coins'));
    }

    public function get_description($id){
        $coins = Coin::where('_id',$id)->orderBy('created_at', 'desc')->get();

        return $coins;
    }

    public function confirm(Request $request, Coin $coins){
        // เพิ่ม coins ให้นักเรียน
        $members = Member::where('_id', $coins->member_id)->first();
        $number = str_replace(",","",$members->member_coins) + str_replace(",","",$coins->coin_number);
        $members->member_coins = number_format($number);
        $members->save();
        // เปลี่ยนสถานะการเติม coins
        $coins->coin_status = '1';
        $coins->coin_approve = Auth::guard('web')->user()->first_name;
        $coins->save();

        $coins_log = CoinsLog::where('ref_id', $coins->_id)
                    ->update(['coin_status' => '1','approve_by' => Auth::guard('web')->user()->first_name]);

        //send email
        $subject = 'Suksa Online : เติม Coins สำเร็จ';
        $from_name = 'Suksa Online';
        $from_email = 'noreply@suksa.online';
        $to_name = $members->member_fname.' '.$members->member_lname;
        $to_email = $members->member_email;
        $description = '';
        $data = array(
            'name'=>$to_name,
            'coins' => $coins->coin_number,
            'sum_coins' => number_format($number),
            'topup_date' => changeDate($coins->created_at, 'full_date', 'th'),
            'topup_time' => date('H:i', strtotime($coins->created_at))
        );

        Mail::send('frontend.send_email_approve_topup_coins', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
            $message->from($from_email, $from_name);
            $message->to($to_email, $to_name);
            $message->subject($subject);
        });

        //insert noti
        $coins_noti = new MemberNotification();
        $coins_noti->coins = $coins->coin_number;
        $coins_noti->sum_coins = number_format($number);
        $coins_noti->topup_date = $coins->created_at;
        $coins_noti->topup_time = date('H:i', strtotime($coins->created_at));
        $coins_noti->member_id = $coins->member_id;
        $coins_noti->member_fullname = $to_name;
        $coins_noti->noti_type = 'approve_topup_coins';
        $coins_noti->noti_status = '0';
        $coins_noti->save();

        //send noti
        sendMemberNoti($coins->member_id);

        return redirect('backend/coins/fill')->with('alert', 'อนุมัติ Coins เรียบร้อย');
    }

    public function notconfirm(Request $request){
        $data = $request['data']['data'];
        // dd($data);
        $members = Member::where('_id', $data['memberid'])->first();

        // $coins = new Coin();
        // $coins->coin_status = '2';
        // $coins->coin_approve = Auth::guard('web')->user()->first_name;
        // $coins->save();

        $coins = Coin::where('_id', $data['coinid'])
                    ->update([
                      'coin_status' => '2',
                      'coins_description' => $request['input'],
                      'coin_approve' => Auth::guard('web')->user()->first_name
                    ]);

        $coins_log = CoinsLog::where('ref_id', $data['coinid'])
                    ->update([
                      'coin_status' => '2',
                      'coins_description' => $request['input'],
                      'approve_by' => Auth::guard('web')->user()->first_name
                    ]);

         //send email
        $subject = 'Suksa Online : เติม Coins ไม่สำเร็จ';
        $from_name = 'Suksa Online';
        $from_email = 'noreply@suksa.online';
        $to_name = $members->member_fname.' '.$members->member_lname;
        $to_email = $members->member_email;
        $coins_description = $request['input'];
        $description = '';

        $member = $data['number'];
        $memberid = $data['memberid'];

        $data = array(
            'name'=> $to_name,
            'coins' => $member
        );

        Mail::send('frontend.send_email_not_approve_topup_coins', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
            $message->from($from_email, $from_name);
            $message->to($to_email, $to_name);
            $message->subject($subject);
        });

        //insert noti
        $coins_noti = new MemberNotification();
        $coins_noti->coins = $member;
        $coins_noti->member_id = $memberid;
        $coins_noti->member_fullname = $to_name;
        $coins_noti->noti_type = 'not_approve_topup_coins';
        $coins_noti->noti_status = '0';
        $coins_noti->coins_description = $request['input'];
        $coins_noti->save();

        //send noti
        sendMemberNoti($memberid);

        // return redirect('backend/coins/fill')->with('alerterror', 'ไม่ได้รับการอนุมัติการเติม Coins ');
        return 'alert_error' ;
    }

    public function revoke(){
      $withdraws = Withdraw::orderBy('created_at', 'desc')->get();

      return view('backend.coins.coins-revoke', compact('withdraws'));
    }

    public function get_description_revoke($id){
      $withdraws = Withdraw::where('_id',$id)->orderBy('created_at', 'desc')->get();

      return $withdraws;
    }

    public function confirmrevoke(Request $request, Withdraw $withdraw){
        // เปลี่ยนสถานะการถอน
        $members = Member::where('_id', $withdraw->member_id)->first();
        $withdraw->withdraw_status = '1';
        $withdraw->withdraw_approve = Auth::guard('web')->user()->first_name;
        $withdraw->save();

        $coins_log = CoinsLog::where('ref_id', $withdraw->_id)
                    ->update(['coin_status' => '1','approve_by' => Auth::guard('web')->user()->first_name]);

        //send email
        $subject = 'Suksa Online : ถอน Coins สำเร็จ';
        $from_name = 'Suksa Online';
        $from_email = 'noreply@suksa.online';
        $to_name = $members->member_fname.' '.$members->member_lname;
        $to_email = $members->member_email;
        $description = '';
        $data = array(
            'name'=>$to_name,
            'coins' => $withdraw->withdraw_coin_number,
            'sum_coins' => $members->member_coins,
            'withdraw_date' => changeDate($withdraw->withdraw_date, 'full_date', 'th'),
            'withdraw_time' => substr($withdraw->withdraw_time,0,5)
        );

        Mail::send('frontend.send_email_approve_withdraw_coins', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
            $message->from($from_email, $from_name);
            $message->to($to_email, $to_name);
            $message->subject($subject);
        });

        //insert noti
        $coins_noti = new MemberNotification();
        $coins_noti->coins = $withdraw->withdraw_coin_number;
        $coins_noti->sum_coins = $members->member_coins;
        $coins_noti->topup_date = changeDate($withdraw->withdraw_date, 'full_date', 'th');
        $coins_noti->topup_time = substr($withdraw->withdraw_time,0,5);
        $coins_noti->member_id = $withdraw->member_id;
        $coins_noti->member_fullname = $to_name;
        $coins_noti->noti_type = 'approve_withdraw_coins';
        $coins_noti->noti_status = '0';
        $coins_noti->save();

        //send noti
        sendMemberNoti($withdraw->member_id);

        return redirect('backend/coins/revoke')->with('alert', 'อนุมัติการถอน Coins เรียบร้อย');
    }

    public function notconfirmrevoke(Request $request, Withdraw $withdraw){
        // เปลี่ยนสถานะการถอน
        // dd($request);
        // $withdraw->withdraw_status = '2';
        // $withdraw->coins_description = $request['input'];
        // $withdraw->withdraw_approve = Auth::guard('web')->user()->first_name;
        //
        // $withdraw->save();

        $coins_log = Withdraw::where('_id', $request['id'])
                    ->update([
                      'withdraw_status' => '2',
                      'coins_description' => $request['input'],
                      'withdraw_approve' => Auth::guard('web')->user()->first_name]
                    );

        $coins_log = CoinsLog::where('ref_id', $request['id'])
                    ->update([
                      'coin_status' => '2',
                      'coins_description' => $request['input'],
                      'approve_by' => Auth::guard('web')->user()->first_name]
                    );

        // เพิ่ม coins ให้นักเรียน เพราะถอนไม่สำเร็จ
        $members = Member::where('_id', $request['member_id'])->first();
        $member_coins = str_replace(",","",$members->member_coins) + str_replace(",","",$request['withdraw_coin_number']);
        $members->member_coins = number_format($member_coins);
        $members->save();

        //send email
        $subject = 'Suksa Online : ถอน Coins ไม่สำเร็จ';
        $from_name = 'Suksa Online';
        $from_email = 'noreply@suksa.online';
        $to_name = $members->member_fname.' '.$members->member_lname;
        $to_email = $members->member_email;
        $coins_description = $request['input'];
        $description = '';
        $data = array(
            'name'=>$to_name,
            'coins' => $request['withdraw_coin_number']
        );

        Mail::send('frontend.send_email_not_approve_withdraw_coins', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
            $message->from($from_email, $from_name);
            $message->to($to_email, $to_name);
            $message->subject($subject);
        });

        //insert noti
        $coins_noti = new MemberNotification();
        $coins_noti->coins = $request['withdraw_coin_number'];
        $coins_noti->sum_coins = $members->member_coins;
        $coins_noti->member_id = $request['member_id'];
        $coins_noti->member_fullname = $to_name;
        $coins_noti->noti_type = 'not_approve_withdraw_coins';
        $coins_noti->noti_status = '0';
        $coins_noti->coins_description = $request['input'];
        $coins_noti->save();

        //send noti
        sendMemberNoti($request['member_id']);

        return 'alert_error';
    }

    public function getBankTransection(){   
        set_time_limit(3000);
      
        $bank_transaction = BankTransaction::orderby('report_id','desc')->first();

        if(isset($bank_transaction->report_id)){
            $report_id = $bank_transaction->report_id;
        }
        else{
            $report_id = '12000';
        }
      
        //get bank transection
        $url = 'https://www.checkbookbank.com/api/member/get/';
        $post_data = array(
           'access_token' => 'etgcuw7iatlkmx162oz6x8u6tnn57z16e3anoa8u8fwm8lpd0z',
           'limit' => '1000',
           'last_id' => $report_id,
        );
      
        $curl = curl_init();

        curl_setopt_array($curl, array(
           CURLOPT_URL => $url,
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => "",
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 30000,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => "POST",
           CURLOPT_POSTFIELDS => $post_data,
           CURLOPT_HTTPHEADER => array(
              //Set here requred headers
              "Accept: application/json",
              //"Content-Type: application/json", //set แล้วมองไม่เห็นตัวแปร post 
           ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if($err){
           return $err;
        } 
        else{
            $response_data = json_decode($response, true);

            $time_start = microtime(true);
            //sleep(5);

            $over_time = 0;

            foreach($response_data['report'] as $report) {
            
                //do something
                //sleep(20);

                $time_end = microtime(true);
                $time = $time_end - $time_start;

                if($time > 58){ //58
                    $over_time = 1;
                    break;
                    //echo "Process Time: over 58 sec";
                }

                //check report_id ใน tb bank_transaction ถ้าไม่ซ้ำให้ insert ข้อมูลลง tb bank_transaction
                $check = BankTransaction::where('report_id', $report['report_id'])->first();

                if(empty($check->report_id)){
                    $data = ([
                        'report_id' => $report['report_id'],
                        'bank_id' => $report['bank_id'], 
                        'account_id' => $report['account_id'],
                        'member_id' => $report['member_id'], 
                        'bank_number' => $report['bank_number'], 
                        'way' => $report['way'],
                        'type' => $report['type'],
                        'withdraw' => $report['withdraw'],
                        'deposit' => $report['deposit'],
                        'detail' => $report['detail'],
                        'amount' => $report['amount'],
                        'status' => $report['status'],
                        'caption' => $report['caption'],
                        'timestamp' => $report['timestamp'],
                        'current_time' => $report['current_time'],
                        'ref_id' => '',
                    ]);
                    $last_data = BankTransaction::create($data);

                    //ถ้าเป็นการโอน ไปเช็คข้อมูลการแจ้งโอนจาก tb coins
                    if($report['withdraw'] == ''){ 
                        $bank_number_1 = str_replace("x","",$report['bank_number']);
                        $bank_number_2 = str_replace("-","",$bank_number_1);

                        $timestamp = explode(" ",$report['timestamp']);
                        $bank_date = $timestamp[0];
                        $bank_time = substr($timestamp[1],0,5);

                        //select ข้อมูลเพื่อเช็คว่ามีข้อมูลตรงกันหรือไม่
                        $check_topup_coins = Coin::where('coin_number',number_format($report['amount']))
                                           ->where('coin_date',$bank_date)
                                           ->where('coin_time',$bank_time.':00')
                                           ->where('coin_status','0')
                                           ->first();

                        //if(isset($check_topup_coins->_id) && isset($check_topup_coins->api_bank_id)){

                        if(isset($check_topup_coins->_id)){

                            //ถ้าข้อมูลถูกต้อง ให้เติม coins ให้ member
                            // เพิ่ม coins ให้นักเรียน
                            $members = Member::where('_id', $check_topup_coins->member_id)->first();
                            $number = str_replace(",","",$members->member_coins) + str_replace(",","",$check_topup_coins->coin_number);
                            $members->member_coins = number_format($number);
                            $members->save();

                            // เปลี่ยนสถานะการเติม coins
                            $check_topup_coins->coin_status = '1';
                            $check_topup_coins->coin_approve = 'Admin';
                            $check_topup_coins->save();

                            $coins_log = CoinsLog::where('ref_id', $check_topup_coins->_id)
                                       ->update(['coin_status' => '1','approve_by' => 'Admin']);

                            //send email
                            $subject = 'Suksa Online : เติม Coins สำเร็จ';
                            $from_name = 'Suksa Online';
                            $from_email = 'noreply@suksa.online';
                            $to_name = $members->member_fname.' '.$members->member_lname;
                            $to_email = $members->member_email;
                            $description = '';
                            $data = array(
                               'name'=>$to_name,
                               'coins' => $check_topup_coins->coin_number,
                               'sum_coins' => number_format($number),
                               'topup_date' => changeDate($check_topup_coins->created_at, 'full_date', 'th'),
                               'topup_time' => date('H:i', strtotime($check_topup_coins->created_at))
                            );

                            Mail::send('frontend.send_email_approve_topup_coins', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
                               $message->from($from_email, $from_name);
                               $message->to($to_email, $to_name);
                               $message->subject($subject);
                            });

                            //insert noti
                            $coins_noti = new MemberNotification();
                            $coins_noti->coins = $check_topup_coins->coin_number;
                            $coins_noti->sum_coins = number_format($number);
                            $coins_noti->topup_date = $check_topup_coins->created_at;
                            $coins_noti->topup_time = date('H:i', strtotime($check_topup_coins->created_at));
                            $coins_noti->member_id = $check_topup_coins->member_id;
                            $coins_noti->member_fullname = $to_name;
                            $coins_noti->noti_type = 'approve_topup_coins';
                            $coins_noti->noti_status = '0';
                            $coins_noti->save();

                            //send noti
                            sendMemberNoti($check_topup_coins->member_id);

                            //อัพเดตสถานะว่าเติมสำเร็จ
                            $transaction = BankTransaction::where('_id',$last_data->id)->first();
                            $transaction->ref_id = $check_topup_coins->_id;
                            $transaction->save();
                        }

                    }
                }
            }
        }


        /*
        //get master bank code
        $url = 'https://www.checkbookbank.com/api/member/get_master_bank/';
        $post_data = array(
            'access_token' => '813oxl4m1di2v8303lri4yyuoztwv7i8wc2ddanpzj1rzhuuxb',
        );
      
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => array(
                //Set here requred headers
                "Accept: application/json",
                //"Content-Type: application/json", //set แล้วมองไม่เห็นตัวแปร post 
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if($err){
            return $err;
        } 
        else{
            //return $response;

            $response_data = json_decode($response, true);

            //return $response_data['data'][0]['bank_name'];

            return $response_data['data'];
        }
        */


        /*
        //get bank account status
        $url = 'https://www.checkbookbank.com/api/member/get_bank_status/';
        $post_data = array(
            'access_token' => '813oxl4m1di2v8303lri4yyuoztwv7i8wc2ddanpzj1rzhuuxb',
        );
      
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => array(
                //Set here requred headers
                "Accept: application/json",
                //"Content-Type: application/json", //set แล้วมองไม่เห็นตัวแปร post 
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if($err){
            return $err;
        } 
        else{
            return $response;
        }
        */

        /*
        //set bank acount status
        $url = 'https://www.checkbookbank.com/api/member/set_bank_status/';
        $post_data = array(
            'access_token' => '813oxl4m1di2v8303lri4yyuoztwv7i8wc2ddanpzj1rzhuuxb',
            'account_id' => '26',
            'status' => '01',
        );
      
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => array(
                //Set here requred headers
                "Accept: application/json",
                //"Content-Type: application/json", //set แล้วมองไม่เห็นตัวแปร post 
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if($err){
            return $err;
        } 
        else{
            return $response;
        }
        */

        /*
        set_time_limit(3000);
      
        $bank_transaction = BankTransaction::orderby('report_id','desc')->first();

        if(isset($bank_transaction->report_id)){
            $report_id = $bank_transaction->report_id;
        }
        else{
            $report_id = '000';
        }
      
        //get bank transection
        $url = 'https://www.checkbookbank.com/api/member/get/';
        $post_data = array(
            'access_token' => '813oxl4m1di2v8303lri4yyuoztwv7i8wc2ddanpzj1rzhuuxb',
            'limit' => '1000',
            'last_id' => $report_id,
        );
      
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => array(
                //Set here requred headers
                "Accept: application/json",
                //"Content-Type: application/json", //set แล้วมองไม่เห็นตัวแปร post 
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if($err){
            return $err;
        } 
        else{
            //return $response;

            $response_data = json_decode($response, true);
            //return $response_data['report'][0]['report_id'];



            $time_start = microtime(true);
            //sleep(5);

            $aaa = 0;
            $bbb = array();

            foreach ($response_data['report'] as $report) {
            
                //do something
                sleep(20);

                $time_end = microtime(true);
                $time = $time_end - $time_start;

                if($time > 58){ //58
                    $aaa = 1;
                    break;
                    //echo "Process Time: over 58 sec";
                }

                $bbb[] = $report['report_id'];
            }

            return $bbb;
        }
        */
    }

    public function setAutoApproveTopupCoins(){   
        $time_start = microtime(true);
        $over_time = 0;

        $bank_transaction = BankTransaction::where('ref_id', '')
                            ->where('report_id', '>', '12446')
                            ->orderby('report_id','asc')
                            ->offset(0)
                            ->limit(30)
                            ->get();

        if(count($bank_transaction) > 0){
            foreach ($bank_transaction as $key => $value) { 
                $time_end = microtime(true);
                $time = $time_end - $time_start;

                if($time > 58){ //58
                    $over_time = 1;
                    break;
                    //echo "Process Time: over 58 sec";
                }

                //ถ้าเป็นการโอน ไปเช็คข้อมูลการแจ้งโอนจาก tb coins
                if($value->withdraw == ''){ 
                    $bank_number_1 = str_replace("x","",$value->bank_number);
                    $bank_number_2 = str_replace("-","",$bank_number_1);

                    $timestamp = explode(" ",$value->timestamp);
                    $bank_date = $timestamp[0];
                    $bank_time = substr($timestamp[1],0,5);

                    //select ข้อมูลเพื่อเช็คว่ามีข้อมูลตรงกันหรือไม่
                    $check_topup_coins = Coin::where('coin_number',number_format($value->amount))
                                       ->where('coin_date',$bank_date)
                                       ->where('coin_time',$bank_time.':00')
                                       ->where('coin_status','0')
                                       ->first();

                    if(isset($check_topup_coins->_id)){
                        //ถ้าข้อมูลถูกต้อง ให้เติม coins ให้ member
                        // เพิ่ม coins ให้นักเรียน
                        $members = Member::where('_id', $check_topup_coins->member_id)->first();
                        $number = str_replace(",","",$members->member_coins) + str_replace(",","",$check_topup_coins->coin_number);
                        $members->member_coins = number_format($number);
                        $members->save();

                        // เปลี่ยนสถานะการเติม coins
                        $check_topup_coins->coin_status = '1';
                        $check_topup_coins->coin_approve = 'Admin';
                        $check_topup_coins->save();

                        $coins_log = CoinsLog::where('ref_id', $check_topup_coins->_id)
                                   ->update(['coin_status' => '1','approve_by' => 'Admin']);

                        //send email
                        $subject = 'Suksa Online : เติม Coins สำเร็จ';
                        $from_name = 'Suksa Online';
                        $from_email = 'noreply@suksa.online';
                        $to_name = $members->member_fname.' '.$members->member_lname;
                        $to_email = $members->member_email;
                        $description = '';
                        $data = array(
                           'name'=>$to_name,
                           'coins' => $check_topup_coins->coin_number,
                           'sum_coins' => number_format($number),
                           'topup_date' => changeDate($check_topup_coins->created_at, 'full_date', 'th'),
                           'topup_time' => date('H:i', strtotime($check_topup_coins->created_at))
                        );

                        Mail::send('frontend.send_email_approve_topup_coins', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
                           $message->from($from_email, $from_name);
                           $message->to($to_email, $to_name);
                           $message->subject($subject);
                        });

                        //insert noti
                        $coins_noti = new MemberNotification();
                        $coins_noti->coins = $check_topup_coins->coin_number;
                        $coins_noti->sum_coins = number_format($number);
                        $coins_noti->topup_date = $check_topup_coins->created_at;
                        $coins_noti->topup_time = date('H:i', strtotime($check_topup_coins->created_at));
                        $coins_noti->member_id = $check_topup_coins->member_id;
                        $coins_noti->member_fullname = $to_name;
                        $coins_noti->noti_type = 'approve_topup_coins';
                        $coins_noti->noti_status = '0';
                        $coins_noti->save();

                        //send noti
                        sendMemberNoti($check_topup_coins->member_id);

                        //อัพเดตสถานะว่าเติมสำเร็จ
                        $transaction = BankTransaction::where('_id',$value->_id)->first();
                        $transaction->ref_id = $check_topup_coins->_id;
                        $transaction->save();
                    }

                }
            }
        }
    }

    public function getCoinsCourse(){
        //ดึงคอร์สที่มี end_time >= 2 ชม. 
        //select * from classroom where classroom_date = date('Y-m-d') and classroom_time_end > date('H:i:s')-2 

        $today = date('Y-m-d');
        $now = date('H:i:s');
        $min_get_time = date('H:i:00', time() - 7200);
        $max_get_time = date('H:i:00', time() - 7140);

        //return $now.' -- '.$min_get_time.' -- '.$max_get_time;

        // $today = '2020-02-10';
        // $min_get_time = '12:00:00';
        // $max_get_time = '12:01:00';
      
        $classrooms = Classroom::where('classroom_date', '=', $today)
                    ->where('classroom_time_end', '>=', $min_get_time)
                    ->where('classroom_time_end', '<', $max_get_time)
                    ->where('classroom_status', '=', '2')
                    ->orderBy('created_at','asc')
                    ->get();

        //$sum_coins = array();

        $sale_commission = SaleCommission::first();
        $commission_percent = $sale_commission->commission_percent;

        foreach ($classrooms as $key => $value) {
            $course = Course::where('_id', '=', $value->course_id)->first();
            $course_id = $value->course_id;
            $course_name = $course->course_name;
            $course_price = $course->course_price;
            $teacher_id = $course->member_id;
            $teacher_fname = $course->member_fname;
            $teacher_lname = $course->member_lname;
            $teacher_fullname = $course->member_fname.' '.$course->member_lname;
         
            $last_date = $course->course_date[count($course->course_date)-1]['date'];

            //เช็คแต่ละคอร์สว่าเป็นวันที่เปิดสอนวันสุดท้ายหรือไม่
            //ถ้าใช่ ให้ดึง coins จาก tb coins_log มาเพิ่มให้อาจารย์
            if($today == $last_date){
                $get_coins = CoinsLog::where('event', '=', 'pay_coins')
                           ->where('ref_id', '=', $value->course_id)
                           ->where('coin_status', '=', '1')
                           ->get();

                $sum_get_coins = 0;

                //ลูป sum coin_number แล้วเอาไปเพิ่ม coins ให้กับอาจารย์ 
                foreach ($get_coins as $key2 => $value2) {
                    //$commission_percent = 15
                    $coin_number = intval(preg_replace("/[,]/", "", $value2->coin_number));

                    $commission_coin_number = ($coin_number * $commission_percent) / 100;
                    $total_coin_number = $coin_number - $commission_coin_number;

                    $sum_get_coins = $sum_get_coins + $total_coin_number;

                    //เพิ่ม coins ให้กับอาจารย์
                    $teacher = Member::where('_id', '=', $teacher_id)->first();
                    $teacher_coins = str_replace(",","",$teacher->member_coins) + str_replace(",","",$total_coin_number);
                    $teacher->member_coins = number_format($teacher_coins);
                    $teacher->save();

                    $data_log = ([
                        'member_id' => $teacher_id,
                        'member_fname' => $teacher_fname,
                        'member_lname' => $teacher_lname,
                        'event' => 'get_coins',
                        'ref_id' => $course_id,
                        'ref_name' => $course_name,

                        'coin_date' => date('Y-m-d'),
                        'coin_time' => date('H:i:s'),
                        'coin_number' => number_format($total_coin_number),
                        'coin_status' => '1',
                    ]);
                    CoinsLog::create($data_log);
                }

                //insert noti
                $coins_noti = new MemberNotification();
                $coins_noti->coins = number_format($sum_get_coins);
                $coins_noti->sum_coins = number_format($teacher_coins);
                $coins_noti->course_name = $course_name;
                $coins_noti->get_date = date('Y-m-d');
                $coins_noti->get_time = date('H:i');
                $coins_noti->member_id = $teacher_id;
                $coins_noti->member_fullname = $teacher_fullname;
                $coins_noti->noti_type = 'get_coins_course';
                $coins_noti->noti_status = '0';
                $coins_noti->save();

                //send noti
                sendMemberNoti($teacher_id);

                //$sum_coins[] = $sum_get_coins;
            }
        }

        //return $sum_coins;
    }

    public function refund(){
      $refunds = Refund::orderBy('created_at', 'desc')->get();

      return view('backend.coins.coins-refund', compact('refunds'));
    }

    public function get_description_refund($id){
      $refund = Refund::where('_id', $id)->first();

      return $refund;
    }

    public function confirmrefund(Request $request, Refund $refund){
        //แก้ไขสถานะเป็นอนุมัติการขอคืนเงิน
        $refund = Refund::where('_id', $request['refund_id'])
                    ->update([
                      'refund_status' => '1',
                      'refund_description' => $request['refund_description'],
                      'refund_approve' => Auth::guard('web')->user()->first_name]
                    );

        //คืน coins ให้กับนักเรียน
        $student = Member::where('_id', '=', $request['member_id'])->first();
        $student_coins = str_replace(",","",$student->member_coins) + str_replace(",","",$request['course_price']);
        $student->member_coins = number_format($student_coins);
        $student->save();

        $sale_commission = SaleCommission::first();
        $commission_percent = $sale_commission->commission_percent;

        $refund_data = Refund::where('_id', $request['refund_id'])->first();
        $teacher = Member::where('_id', '=', $refund_data->teacher_id)->first();

        $commission_coin_number = ($request['course_price'] * $commission_percent) / 100;
        $total_coin_number = $request['course_price'] - $commission_coin_number;

        //ส่ง email หาอาจารย์
        $subject = 'Suksa Online : การขอคืนเงินสำเร็จ';
        $from_name = 'Suksa Online';
        $from_email = 'noreply@suksa.online';
        $to_name = $refund_data->teacher_fullname;
        $to_email = $teacher->member_email;
        $refund_description = $request['refund_description'];
        $description = '';
        $data = array(
            'name' => $to_name,
            'coins' => number_format($total_coin_number),
            'student_fullname' => $refund_data->member_fullname,
            'course_name' => $request['course_name'],
            'refund_description' => $refund_description,
            'refund_date' => date('Y-m-d'),
            'refund_time' => date('H:i')
        );

        Mail::send('frontend.send_email_approve_refund_teacher', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
            $message->from($from_email, $from_name);
            $message->to($to_email, $to_name);
            $message->subject($subject);
        });

        //ส่ง email หานักเรียน
        $subject = 'Suksa Online : การขอคืนเงินสำเร็จ';
        $from_name = 'Suksa Online';
        $from_email = 'noreply@suksa.online';
        $to_name = $refund_data->member_fullname;
        $to_email = $student->member_email;
        $refund_description = $request['refund_description'];
        $description = '';
        $data = array(
            'name' => $to_name,
            'coins' => number_format($request['course_price']),
            'sum_coins' => $student->member_coins,
            'course_name' => $request['course_name'],
            'refund_description' => $refund_description,
            'refund_date' => date('Y-m-d'),
            'refund_time' => date('H:i')
        );

        Mail::send('frontend.send_email_approve_refund_student', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
            $message->from($from_email, $from_name);
            $message->to($to_email, $to_name);
            $message->subject($subject);
        });

        //ส่ง noti หาอาจารย์
        $refund_noti = new MemberNotification();
        $refund_noti->coins = number_format($total_coin_number);
        $refund_noti->member_id = $teacher->member_id;
        $refund_noti->member_fullname = $refund_data->teacher_fullname;
        $refund_noti->student_id = $student->member_id;
        $refund_noti->student_fullname = $refund_data->member_fullname;
        $refund_noti->course_id = $request['course_id'];
        $refund_noti->course_name = $request['course_name'];
        $refund_noti->noti_type = 'approve_refund_teacher';
        $refund_noti->noti_status = '0';
        $refund_noti->refund_description = $refund_description;
        $refund_noti->refund_date = date('Y-m-d');
        $refund_noti->refund_time = date('H:i');
        $refund_noti->save();
        sendMemberNoti($teacher->member_id);

        //ส่ง noti หานักเรียน
        $refund_noti = new MemberNotification();
        $refund_noti->coins = number_format($request['course_price']);
        $refund_noti->sum_coins = $student->member_coins;
        $refund_noti->member_id = $student->member_id;
        $refund_noti->member_fullname = $refund_data->member_fullname;
        $refund_noti->course_id = $request['course_id'];
        $refund_noti->course_name = $request['course_name'];
        $refund_noti->noti_type = 'approve_refund_student';
        $refund_noti->noti_status = '0';
        $refund_noti->refund_description = $refund_description;
        $refund_noti->refund_date = date('Y-m-d');
        $refund_noti->refund_time = date('H:i');
        $refund_noti->save();
        sendMemberNoti($request['member_id']);

        return 'success';
    }

    public function notconfirmrefund(Request $request, Refund $refund){
        
        //แก้ไขสถานะเป็นไม่อนุมัติการขอคืนเงิน
        $refund = Refund::where('_id', $request['refund_id'])
                    ->update([
                      'refund_status' => '2',
                      'refund_description' => $request['refund_description'],
                      'refund_approve' => Auth::guard('web')->user()->first_name]
                    );

        //เมื่อไม่อนุมัติ ให้แก้ไขสถานะการจ่าย coins จาก 2 เป็น 1 
        $coins_log = CoinsLog::where('event', '=', 'pay_coins')
                    ->where('member_id', $request['member_id'])
                    ->where('ref_id', $request['course_id'])
                    ->update([
                      'coin_status' => '1'
                    ]);

        $sale_commission = SaleCommission::first();
        $commission_percent = $sale_commission->commission_percent;

        $refund_data = Refund::where('_id', $request['refund_id'])->first();
        $teacher = Member::where('_id', '=', $refund_data->teacher_id)->first();
        $student = Member::where('_id', '=', $request['member_id'])->first();

        $commission_coin_number = ($request['course_price'] * $commission_percent) / 100;
        $total_coin_number = $request['course_price'] - $commission_coin_number;
        
        //เพิ่ม coins ให้กับอาจารย์
        $teacher_coins = str_replace(",","",$teacher->member_coins) + str_replace(",","",$total_coin_number);
        $teacher->member_coins = number_format($teacher_coins);
        $teacher->save();

        //ส่ง email หาอาจารย์
        $subject = 'Suksa Online : การขอคืนเงินไม่สำเร็จ';
        $from_name = 'Suksa Online';
        $from_email = 'noreply@suksa.online';
        $to_name = $refund_data->teacher_fullname;
        $to_email = $teacher->member_email;
        $refund_description = $request['refund_description'];
        $description = '';
        $data = array(
            'name' => $to_name,
            'coins' => number_format($total_coin_number),
            'student_fullname' => $refund_data->member_fullname,
            'course_name' => $request['course_name'],
            'refund_description' => $refund_description,
            'refund_date' => date('Y-m-d'),
            'refund_time' => date('H:i')
        );

        Mail::send('frontend.send_email_not_approve_refund_teacher', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
            $message->from($from_email, $from_name);
            $message->to($to_email, $to_name);
            $message->subject($subject);
        });

        //ส่ง email หานักเรียน
        $subject = 'Suksa Online : การขอคืนเงินไม่สำเร็จ';
        $from_name = 'Suksa Online';
        $from_email = 'noreply@suksa.online';
        $to_name = $refund_data->member_fullname;
        $to_email = $student->member_email;
        $refund_description = $request['refund_description'];
        $description = '';
        $data = array(
            'name' => $to_name,
            'coins' => number_format($request['course_price']),
            'sum_coins' => $student->member_coins,
            'course_name' => $request['course_name'],
            'refund_description' => $refund_description,
            'refund_date' => date('Y-m-d'),
            'refund_time' => date('H:i')
        );

        Mail::send('frontend.send_email_not_approve_refund_student', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
            $message->from($from_email, $from_name);
            $message->to($to_email, $to_name);
            $message->subject($subject);
        });

        //ส่ง noti หาอาจารย์
        $refund_noti = new MemberNotification();
        $refund_noti->coins = number_format($total_coin_number);
        $refund_noti->sum_coins = $teacher->member_coins;
        $refund_noti->member_id = $teacher->member_id;
        $refund_noti->member_fullname = $refund_data->teacher_fullname;
        $refund_noti->student_id = $student->member_id;
        $refund_noti->student_fullname = $refund_data->member_fullname;
        $refund_noti->course_id = $request['course_id'];
        $refund_noti->course_name = $request['course_name'];
        $refund_noti->noti_type = 'not_approve_refund_teacher';
        $refund_noti->noti_status = '0';
        $refund_noti->refund_description = $refund_description;
        $refund_noti->refund_date = date('Y-m-d');
        $refund_noti->refund_time = date('H:i');
        $refund_noti->save();
        sendMemberNoti($teacher->member_id);

        //ส่ง noti หานักเรียน
        $refund_noti = new MemberNotification();
        $refund_noti->coins = number_format($request['course_price']);
        $refund_noti->member_id = $student->member_id;
        $refund_noti->member_fullname = $refund_data->member_fullname;
        $refund_noti->course_id = $request['course_id'];
        $refund_noti->course_name = $request['course_name'];
        $refund_noti->noti_type = 'not_approve_refund_student';
        $refund_noti->noti_status = '0';
        $refund_noti->refund_description = $refund_description;
        $refund_noti->refund_date = date('Y-m-d');
        $refund_noti->refund_time = date('H:i');
        $refund_noti->save();
        sendMemberNoti($request['member_id']);

        return 'success';
    }
}
