<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Models\AdminNotification;

class SendNotiBackend implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $admin_id;
    public $member_id;
    public $member_fullname;
    
    public $noti_type;
    public $noti_status;
    public $created_at;

    public $count_admin_noti;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct($admin_id)
    {
        $admin_noti = AdminNotification::where('noti_to', 'all')
                    ->orWhere('noti_to', $admin_id)
                    ->where('noti_status', '0')
                    ->orderby('created_at','desc')
                    ->first();

        $count_admin_noti = AdminNotification::where('noti_to', 'all')
                    ->orWhere('noti_to', $admin_id)
                    ->where('noti_status', '0')
                    ->orderby('created_at','desc')
                    ->count();

        if(isset($admin_noti)){

            if($admin_noti->noti_type == 'register_teacher'){
                $this->admin_id = $admin_id;
                $this->member_id = $admin_noti->member_id;
                $this->member_fullname = $admin_noti->member_fullname;
                $this->noti_type = $admin_noti->noti_type;
                $this->noti_status = $admin_noti->noti_status;
                $this->created_at = date('d/m/Y H:i', strtotime($admin_noti->created_at));
            }
            else if($admin_noti->noti_type == 'topup_coins'){
                $this->admin_id = $admin_id;
                $this->member_id = $admin_noti->member_id;
                $this->member_fullname = $admin_noti->member_fullname;
                $this->noti_type = $admin_noti->noti_type;
                $this->noti_status = $admin_noti->noti_status;
                $this->created_at = date('d/m/Y H:i', strtotime($admin_noti->created_at));
            }
            else if($admin_noti->noti_type == 'withdraw_coins'){
                $this->admin_id = $admin_id;
                $this->member_id = $admin_noti->member_id;
                $this->member_fullname = $admin_noti->member_fullname;
                $this->noti_type = $admin_noti->noti_type;
                $this->noti_status = $admin_noti->noti_status;
                $this->created_at = date('d/m/Y H:i', strtotime($admin_noti->created_at));
            }
            else if($admin_noti->noti_type == 'refund'){
                $this->admin_id = $admin_id;
                $this->member_id = $admin_noti->member_id;
                $this->member_fullname = $admin_noti->member_fullname;
                $this->noti_type = $admin_noti->noti_type;
                $this->noti_status = $admin_noti->noti_status;
                $this->created_at = date('d/m/Y H:i', strtotime($admin_noti->created_at));
            }

            $this->count_admin_noti = ($count_admin_noti)?$count_admin_noti:0;
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
        $my_channel = 'localhost-backend-channel';
        //$my_channel = 'production-backend-channel';

        return new Channel($my_channel);
    }

    public function broadcastAs()
    {
        $my_event = 'localhost-backend-event';
        //$my_event = 'production-backend-event';

        return $my_event;
    }
}
