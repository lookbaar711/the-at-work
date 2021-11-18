<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\QueueEmail;
use Sentinel;
use Mail;
use DB;

class QueueSendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:QueueSendEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email every 1 minute using cron job';

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
        $queues = QueueEmail::where('queue_status', '0')
                    ->offset(0)
                    ->limit(40)
                    ->get();

        foreach ($queues as $queue) {
            
            if($queue->email_type == 'send_email_classroom'){
                //send email to teacher 
                $email_type = $queue->email_type;
                $subject = $queue->subject;
                $from_name = $queue->from_name;
                $from_email = $queue->from_email;
                $to_name = $queue->to_name;
                $to_email = $queue->to_email;
                $data = array(
                    'name' => $queue->data['name'], 
                    "course" => $queue->data['course'], 
                    "teacher_fullname" => $queue->data['teacher_fullname'], 
                    "url" => $queue->data['url'],
                    "start_date" => $queue->data['start_date'],
                    "start_time" => $queue->data['start_time'],
                    "end_time" => $queue->data['end_time']
                );
                    
                Mail::send('frontend.'.$email_type, $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
                    $message->from($from_email, $from_name);
                    $message->to($to_email, $to_name);
                    $message->subject($subject);
                });
            }
            else if($queue->email_type == 'send_email_cancel_private_classroom'){
                //send email to teacher 
                $email_type = $queue->email_type;
                $subject = $queue->subject;
                $from_name = $queue->from_name;
                $from_email = $queue->from_email;
                $to_name = $queue->to_name;
                $to_email = $queue->to_email;
                $data = array(
                    'name' => $queue->data['name'], 
                    "course" => $queue->data['course']
                );
                    
                Mail::send('frontend.'.$email_type, $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
                    $message->from($from_email, $from_name);
                    $message->to($to_email, $to_name);
                    $message->subject($subject);
                });
            }
            else if($queue->email_type == 'send_email_unread_chat'){
                //send email to member 
                $email_type = $queue->email_type;
                $subject = $queue->subject;
                $from_name = $queue->from_name;
                $from_email = $queue->from_email;
                $to_name = $queue->to_name;
                $to_email = $queue->to_email;
                $data = array(
                    'from_fullname' => $queue->data['from_fullname'], 
                    'from_email' => $queue->data['from_email'],
                    'to_fullname' => $queue->data['to_fullname'], 
                    'to_email' => $queue->data['to_email'], 
                    "send_date" => $queue->data['send_date'],
                    "send_time" => $queue->data['send_time']
                );
                    
                Mail::send('frontend.'.$email_type, $data, function($message) use ($subject, $from_name, $from_email, $to_name, $to_email) {
                    $message->from($from_email, $from_name);
                    $message->to($to_email, $to_name);
                    $message->subject($subject);
                });
            }

            $set_queue = QueueEmail::where('_id', '=' ,$queue->_id)
                        ->first();

            $set_queue->queue_status = '1';
            $set_queue->update();     
        }
    }
}
