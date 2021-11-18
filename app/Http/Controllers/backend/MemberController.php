<?php
namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use View;
use App\Models\Member;
use App\Models\Other_subject;
use App\Models\Subject;
use App\Models\Aptitude;
use App\Models\Event;
use App\Models\BankMaster;
use App\Models\MemberBank;
use Auth;

use App\Http\Controllers\Controller;
use Mail;

class MemberController extends Controller
{

    /**
     * Show a list of all the users.
     *
     * @return View
     */

    public function membersNew()
    {
        $members = Member::where('member_status', '=', '0')
                    ->orWhere('member_status', '=', '2')
                    ->orWhere('member_status', '=', '4')
                    ->orderBy('created_at','desc')
                    ->get();

        foreach ($members as $i => $member) {
            $member->detail_aptitude = [];
            $detail_subject = [];
            $count_aptitude = 0;
            foreach (array_keys($member->member_aptitude) as $key => $aptitude_id) {
                $aptitude = Aptitude::where('_id', $aptitude_id)->first();
                if(isset($aptitude->_id)){
                    foreach ($member->member_aptitude[$aptitude_id] as $key => $subject_id) {
                        $subject = Subject::where('_id', $subject_id)->first();
                        if(isset($subject->_id)){
                            $detail_subject[$aptitude->aptitude_name_th][] = $subject->subject_name_th;
                        }
                    }
                }
                $count_aptitude++;
            }
            if(isset($detail_subject)){
                $member->detail_aptitude = $detail_subject;
                $member->count_aptitude = $count_aptitude;
            }

            $event_name = Event::select('event_name')->where('_id', $member->event_id)->first();
            $member->event_name = $event_name['event_name'];
        }

        return view('backend.members.member-new', compact('members'));
    }

    public function membersAll()
    {
        $members = Member::where('member_status', '=', '1')->whereNotNull('member_Bday')->orderBy('created_at','desc')->get();
        return view('backend.members.member-all', compact('members'));
    }

    public function show($id)
    {
        $member =  Member::where('_id', '=', $id)->first();
        // Show the page
        if($member->member_sername == 'mr'){
            $member->member_sername = 'นาย';
            $member['gender'] = 'ชาย';
        }
        else if($member->member_sername == 'mrs'){
            $member->member_sername = 'นาง';
            $member['gender'] = 'หญิง';
        }
        else if($member->member_sername == 'miss'){
            $member->member_sername = 'นางสาว';
            $member['gender'] = 'หญิง';
        }

        $member->detail_aptitude = [];
        foreach (array_keys($member->member_aptitude) as $key => $aptitude_id) {
          $aptitude = Aptitude::where('_id', $aptitude_id)->first();
          if($aptitude){
          $detail_subject[$aptitude->aptitude_name_th] = [];
              foreach ($member->member_aptitude[$aptitude_id] as $key => $subject_id) {
                  $subject = Subject::where('_id', $subject_id)->first();
                  if($subject){
                      $detail_subject[$aptitude->aptitude_name_th][] = $subject->subject_name_th;
                  }
              }
          }
        }

        $event_name = Event::select('event_name')->where('_id', $member->event_id)->first();
        $member->event_name = $event_name['event_name'];
        $member->detail_aptitude = $detail_subject;

        // ข้อมูลธนาคาร
        $bank_master = BankMaster::orderBy('bank_name_th','asc')->get();
        $member->bank_master = $bank_master;
        $member_bank = MemberBank::where('member_id', $id)->orderby('created_at','asc')->get();
        $member->member_bank = $member_bank;

        return view('backend.members.member-show', compact('member'));

    }

    public function approve($id, Request $request)
    {


        $members = Member::where('_id', '=', $id)->first();
        $members->member_status = '1';


        //send email
        $subject = 'Suksa Online : สมัครสมาชิกผู้สอนสำเร็จ';
        $from_name = 'Suksa Online';
        $from_email = 'noreply@suksa.online';
        $to_name = $members->member_fname.' '.$members->member_lname;
        $to_email = $members->member_email;
        $description = '';
        $data = array(
            'name'=>$to_name,
            'username' => $members->member_email,
            'password' => $members->member_real_password,
            'description' => $description
        );

        Mail::send('frontend.send_email_approve_teacher', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
            $message->from($from_email, $from_name);
            $message->to($to_email, $to_name);
            $message->subject($subject);
        });


        $members->unset('member_real_password');
        $members->save();

        return redirect('backend/members/new')
                        ->with('success','อนุมัติอาจารย์เรียบร้อย');  //อนุมัติ
    }

    public function notallowed(Request $request){
        $members = Member::where('_id', '=', $request->id)->first();
        $members->member_status = '2';
        $members->member_note = $request->comment;

        $hostname = get_hostname();

        //send email
        $subject = 'Suksa Online : สมัครสมาชิกผู้สอนไม่สำเร็จ';
        $from_name = 'Suksa Online';
        $from_email = 'noreply@suksa.online';
        $to_name = $members->member_fname.' '.$members->member_lname;
        $to_email = $members->member_email;
        $comment = $request->comment;
        $url = 'http://'.$hostname.'/members/updatedata/'.$request->id;
        $data = array(
            'name'=>$to_name,
            'comment'=>$comment,
            'url'=>$url
        );

        Mail::send('frontend.send_email_not_approve_teacher', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
            $message->from($from_email, $from_name);
            $message->to($to_email, $to_name);
            $message->subject($subject);
        });

        //$members->unset('member_real_password');
        $members->save();

        return redirect('backend/members/new')
                        ->with('success','ไม่ได้รับการอนุมัติ');
    }

    public function create()
    {
        return view('userregister');
    }

    public function destroy($id)
    {
        $members = Member::where('_id', '=', $id)->first();
        $members->member_status = '3';
        $members->save();
        return redirect('backend/members/all')
                        ->with('success','ลบผู้สอนเรียบร้อย');
    }

    public function get_email_student(Request $request, $member_id){
        $members = Member::select('member_email','member_status')
        ->where('member_status', '=', '1')
        ->Where('_id', '<>', $member_id)
        ->get();
        return $members;
    }

    public function update_teacher(Request $request){
      $input =  $request['data'];
      //dd($input['member_id']);

      $member_update = Member::where('_id', '=', $input['member_id'])->first();
      $member_update->member_email = $input['member_email'];
      $member_update->member_idCard = $input['member_idCard'];
      $member_update->save();

      $del = MemberBank::where('member_id',$input['member_id'])->delete();
      foreach ($input['member_bank'] as $key => $value) {
        $bank_master = BankMaster::where('_id',$value[0])->first();

        $data = ([
          'member_id' => $input['member_id'],
          'bank_id' => $value[0],
          'bank_name_en' => $bank_master->bank_name_en,
          'bank_name_th' => $bank_master->bank_name_th,
          'bank_account_number' => $value[1],
        ]);
        // dd($data);
        MemberBank::create($data);
      }

      $text = [
        'success' => "บันทึกสำเร็จ"
      ];

      return $text;

    }
}
