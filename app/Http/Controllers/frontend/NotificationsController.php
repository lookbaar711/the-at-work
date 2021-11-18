<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\MemberNotification;

class NotificationsController extends Controller
{
    public function clearBadge(Request $request){
        
        //update noti status
        $member_noti = MemberNotification::where('member_id', $request->member_id)
                    ->where('noti_status', '0')
                    ->update(['noti_status' => '1']);

        echo $member_noti;
    }
}
