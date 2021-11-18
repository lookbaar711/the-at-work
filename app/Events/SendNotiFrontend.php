<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\MemberNotification;
use App\Models\Aptitude;
use App\Models\Subject;

class SendNotiFrontend implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $member_id;
    public $member_fullname;
    public $classroom_name;
    public $classroom_date;
    public $classroom_datetime;
    public $classroom_time_start;
    public $classroom_time_end;
    public $classroom_url;
    public $teacher_fullname;
    public $noti_type;
    public $noti_status;
    public $created_at;

    public $count_member_noti;
    public $count_badge_member_noti;

    public $coins;
    public $sum_coins;
    public $topup_date;
    public $topup_time;
    public $withdraw_date;
    public $withdraw_time;
    public $get_date;
    public $get_time;

    public $student_fullname;

    public $course_name;
    public $course_datetime;
    public $course_start_date;
    public $course_id;
    public $course_price;
    public $noti_course_type;

    /////---- request -----------------------------------------
    public $request_id;
    public $request_name;
    public $request_date;
    public $request_time;
    public $request_member_id;
    public $request_full_name;
    public $request_member_email;

    public $student_id;
    public $request_topic;
    public $request_group_th;
    public $request_group_en;
    public $request_subject_th;
    public $request_subject_en;
    public $request_datetime;

    public $coins_description;
    public $refund_description;

    public $noti_id;
    /////---- request -----------------------------------------
    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct($member_id)
    {
        $member_noti = MemberNotification::where('member_id', $member_id)
                    ->where('noti_status', '0')
                    ->orderby('created_at','desc')
                    ->first();

        $count_badge_member_noti = MemberNotification::where('member_id', $member_id)
                    ->where('noti_status', '0')
                    ->orderby('created_at','desc')
                    ->count();

        $count_member_noti = MemberNotification::where('member_id', $member_id)
                    ->orderby('created_at','desc')
                    ->count();

        if(isset($member_noti)){

            if($member_noti->noti_type == 'open_course_teacher'){
                $this->noti_id = $member_noti->_id;
                $this->member_id = $member_id;
                $this->member_fullname = $member_noti->member_fullname;
                $this->course_id = $member_noti->course_id;
                $this->classroom_name = $member_noti->classroom_name;
                //$this->classroom_date = changeDate($member_noti->classroom_date, 'full_date', $lang);
                $this->classroom_date = date('d/m/Y', strtotime($member_noti->classroom_date));
                $this->classroom_time_start = substr($member_noti->classroom_time_start,0,5);
                $this->classroom_time_end = substr($member_noti->classroom_time_end,0,5);
                $this->classroom_url = $member_noti->classroom_url;
                $this->teacher_fullname = $member_noti->teacher_fullname;
                $this->noti_type = $member_noti->noti_type;
                $this->noti_status = $member_noti->noti_status;
                $this->created_at = date('d/m/Y H:i', strtotime($member_noti->created_at));
            }
            else if($member_noti->noti_type == 'open_course_student'){
                $this->noti_id = $member_noti->_id;
                $this->member_id = $member_id;
                $this->member_fullname = $member_noti->member_fullname;
                $this->course_id = $member_noti->course_id;
                $this->classroom_name = $member_noti->classroom_name;
                //$this->classroom_date = changeDate($member_noti->classroom_date, 'full_date', $lang);
                $this->classroom_date = date('d/m/Y', strtotime($member_noti->classroom_date));
                $this->classroom_time_start = substr($member_noti->classroom_time_start,0,5);
                $this->classroom_time_end = substr($member_noti->classroom_time_end,0,5);
                $this->classroom_url = $member_noti->classroom_url;
                $this->teacher_fullname = $member_noti->teacher_fullname;
                $this->noti_type = $member_noti->noti_type;
                $this->noti_status = $member_noti->noti_status;
                $this->created_at = date('d/m/Y H:i', strtotime($member_noti->created_at));
            }
            else if($member_noti->noti_type == 'register_course_teacher'){
                if($member_noti->classroom_start_date != $member_noti->classroom_end_date){
                    $date_time = date('d/m/Y', strtotime($member_noti->classroom_start_date)).' - '.date('d/m/Y', strtotime($member_noti->classroom_end_date));
                }
                else{
                    $date_time = date('d/m/Y', strtotime($member_noti->classroom_start_date));
                }
                $this->member_id = $member_id;
                $this->member_fullname = $member_noti->member_fullname;
                $this->course_id = $member_noti->course_id;
                $this->classroom_name = $member_noti->classroom_name;
                $this->classroom_datetime = $date_time;
                $this->classroom_time_start = substr($member_noti->classroom_time_start,0,5);
                $this->classroom_time_end = substr($member_noti->classroom_time_end,0,5);
                $this->student_fullname = $member_noti->student_fullname;
                $this->noti_type = $member_noti->noti_type;
                $this->noti_status = $member_noti->noti_status;
                $this->created_at = date('d/m/Y H:i', strtotime($member_noti->created_at));
            }
            else if($member_noti->noti_type == 'register_course_private_teacher'){
                if($member_noti->classroom_start_date != $member_noti->classroom_end_date){
                    $date_time = date('d/m/Y', strtotime($member_noti->classroom_start_date)).' - '.date('d/m/Y', strtotime($member_noti->classroom_end_date));
                }
                else{
                    $date_time = date('d/m/Y', strtotime($member_noti->classroom_start_date));
                }
                $this->member_id = $member_id;
                $this->member_fullname = $member_noti->member_fullname;
                $this->course_id = $member_noti->course_id;
                $this->classroom_name = $member_noti->classroom_name;
                //$this->classroom_date = changeDate($member_noti->classroom_date, 'full_date', $lang);
                $this->classroom_date = $date_time;
                $this->classroom_time_start = substr($member_noti->classroom_time_start,0,5);
                $this->classroom_time_end = substr($member_noti->classroom_time_end,0,5);
                $this->student_fullname = $member_noti->student_fullname;
                $this->noti_type = $member_noti->noti_type;
                $this->noti_status = $member_noti->noti_status;
                $this->created_at = date('d/m/Y H:i', strtotime($member_noti->created_at));
            }
            else if($member_noti->noti_type == 'register_course_student'){
                if($member_noti->classroom_start_date != $member_noti->classroom_end_date){
                    $date_time = date('d/m/Y', strtotime($member_noti->classroom_start_date)).' - '.date('d/m/Y', strtotime($member_noti->classroom_end_date));
                }
                else{
                    $date_time = date('d/m/Y', strtotime($member_noti->classroom_start_date));
                }
                $this->member_id = $member_id;
                $this->member_fullname = $member_noti->member_fullname;
                $this->course_id = $member_noti->course_id;
                $this->classroom_name = $member_noti->classroom_name;
                $this->classroom_datetime = $date_time;
                $this->classroom_time_start = substr($member_noti->classroom_time_start,0,5);
                $this->classroom_time_end = substr($member_noti->classroom_time_end,0,5);
                $this->teacher_fullname = $member_noti->teacher_fullname;
                $this->noti_type = $member_noti->noti_type;
                $this->noti_status = $member_noti->noti_status;
                $this->created_at = date('d/m/Y H:i', strtotime($member_noti->created_at));
            }
            else if($member_noti->noti_type == 'register_course_private_student'){
                if($member_noti->classroom_start_date != $member_noti->classroom_end_date){
                    $date_time = date('d/m/Y', strtotime($member_noti->classroom_start_date)).' - '.date('d/m/Y', strtotime($member_noti->classroom_end_date));
                }
                else{
                    $date_time = date('d/m/Y', strtotime($member_noti->classroom_start_date));
                }
                $this->member_id = $member_id;
                $this->member_fullname = $member_noti->member_fullname;
                $this->course_id = $member_noti->course_id;
                $this->classroom_name = $member_noti->classroom_name;
                //$this->classroom_date = changeDate($member_noti->classroom_date, 'full_date', $lang);
                $this->classroom_date = $date_time;
                $this->classroom_time_start = substr($member_noti->classroom_time_start,0,5);
                $this->classroom_time_end = substr($member_noti->classroom_time_end,0,5);
                $this->teacher_fullname = $member_noti->teacher_fullname;
                $this->noti_type = $member_noti->noti_type;
                $this->noti_status = $member_noti->noti_status;
                $this->created_at = date('d/m/Y H:i', strtotime($member_noti->created_at));
            }
            else if($member_noti->noti_type == 'invite_course_student'){
                if($member_noti->classroom_start_date != $member_noti->classroom_end_date){
                    $date_time = date('d/m/Y', strtotime($member_noti->course_start_date)).' - '.date('d/m/Y', strtotime($member_noti->course_end_date));
                }
                else{
                    $date_time = date('d/m/Y', strtotime($member_noti->course_start_date));
                }
                $this->member_id = $member_id;
                $this->member_fullname = $member_noti->member_fullname;
                $this->course_id = $member_noti->course_id;
                $this->course_name = $member_noti->course_name;
                $this->course_datetime = $date_time;
                $this->teacher_fullname = $member_noti->teacher_fullname;
                $this->noti_type = $member_noti->noti_type;
                $this->noti_status = $member_noti->noti_status;
                $this->created_at = date('d/m/Y H:i', strtotime($member_noti->created_at));
            }
            else if($member_noti->noti_type == 'cancel_course_teacher_not'){
                if($member_noti->classroom_start_date != $member_noti->classroom_end_date){
                    $date_time = date('d/m/Y', strtotime($member_noti->classroom_time_start)).' - '.date('d/m/Y', strtotime($member_noti->classroom_time_end));
                }
                else{
                    $date_time = date('d/m/Y', strtotime($member_noti->classroom_time_start));
                }
                $this->member_id = $member_id;
                $this->member_fullname = $member_noti->member_fullname;
                $this->course_id = $member_noti->course_id;
                $this->classroom_name = $member_noti->classroom_name;
                $this->classroom_date = $date_time;;
                $this->classroom_time_start = substr($member_noti->classroom_time_start,0,5);
                $this->classroom_time_end = substr($member_noti->classroom_time_end,0,5);
                $this->classroom_url = $member_noti->classroom_url;
                $this->teacher_fullname = $member_noti->teacher_fullname;
                $this->noti_type = $member_noti->noti_type;
                $this->noti_status = $member_noti->noti_status;
                $this->created_at = date('d/m/Y H:i', strtotime($member_noti->created_at));
            }

            $this->count_member_noti = $count_member_noti;
            $this->count_badge_member_noti = $count_badge_member_noti;
        }
        else{

        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $my_channel = 'localhost-frontend-channel';
        //$my_channel = 'production-frontend-channel';

        return new Channel($my_channel);
    }

    public function broadcastAs()
    {
        $my_event = 'localhost-frontend-event';
        //$my_event = 'production-frontend-event';

        return $my_event;
    }
}
