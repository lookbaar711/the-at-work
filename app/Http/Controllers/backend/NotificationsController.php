<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\AdminNotification;

class NotificationsController extends Controller
{
    public function clearBadge(Request $request){
        
        //update noti status
        $admin_noti = AdminNotification::where('noti_to', 'all')
                    ->orWhere('noti_to', $request->admin_id)
                    ->where('noti_status', '0')
                    ->update(['noti_status' => '1']);

        echo $admin_noti;
    }
}
