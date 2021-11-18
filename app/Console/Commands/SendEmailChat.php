<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ACUsersMessages;
use App\Models\Member;
use App\Models\Test;
use App\Models\QueueEmail;
use Sentinel;
use Mail;

class SendEmailChat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:SendEmailChat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to unread chat every 1 minute using cron job';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $today = date('Y-m-d');
        $time = date('H:i:s');
        $before_time = date('Y-m-d H:i:s',strtotime('-5 minutes'));

        $message_info = ACUsersMessages::where('updated_at', '<' , $before_time)
                        ->where('is_send','=',1)
                        ->offset(0)
                        ->limit(20)
                        ->get();
        
        foreach ($message_info as $message) {
            $updated_at = explode(" ",$message->updated_at);
            $update_date = $updated_at[0];
            $update_time = $updated_at[1];

            $member_from = Member::where('mid', '=', $message->users_id)->first();
            $member_to = Member::where('mid', '=', $message->buddy_id)->first();

            // Test::insert([
            //     'member_from' => $member_from->member_fullname,
            //     'member_to' => $member_to->member_fullname,
            //     'update_date' => $update_date,
            //     'update_time' => $update_time
            // ]);
            
            //send email to member 
            $subject = 'Suksa Online : มีสมาชิกส่งข้อความหาคุณ';
            $from_name = 'Suksa Online';
            $from_email = 'noreply@suksa.online';
            $to_name = $member_to->member_fullname;
            $to_email = $member_to->member_email;
            $data = array(
                'from_fullname' => $member_from->member_fullname, 
                'from_email' => $member_from->member_email,
                'to_fullname' => $member_to->member_fullname, 
                'to_email' => $member_to->member_email, 
                "send_date" => $update_date,
                "send_time" => $update_time
            );

            //insert queue send email to member
            $queue_email_teacher = new QueueEmail(); 
            $queue_email_teacher->email_type = 'send_email_unread_chat';
            $queue_email_teacher->data = $data;
            $queue_email_teacher->subject = $subject;
            $queue_email_teacher->from_name = $from_name;
            $queue_email_teacher->from_email = $from_email;
            $queue_email_teacher->to_name = $to_name;
            $queue_email_teacher->to_email = $to_email;
            $queue_email_teacher->queue_status = '0';
            $queue_email_teacher->save();
                
            // Mail::send('frontend.send_email_unread_chat', $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
            //     $message->from($from_email, $from_name);
            //     $message->to($to_email, $to_name);
            //     $message->subject($subject);
            // });
            
        }
        
        
        //update read status
        $queues = ACUsersMessages::where('updated_at', '<' , $before_time)
                    ->where('is_send','=',1)
                    ->update(['is_send' => 0,'updated_at' => date('Y-m-d H:i:s')]);
                    
    }
}
