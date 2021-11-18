<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Auth;
use Hash;
use Illuminate\Support\Facades\Redirect;
use Session;

class AuthController extends Controller
{
    public function postSignin(Request $request)
    {

        $member_info = Member::where('member_email', '=', $request->member_email)
                        ->where('member_status', '1')
                        ->first();

        if(isset($member_info)){
            if(Hash::check($request->member_password, $member_info->member_password)) {
                //offline
                if($member_info->online_status == '0'){
                    //check authen
                    if (Auth::guard('members')->attempt( [ 'member_email' => $request->member_email , 'password' => $request->member_password, 'member_status' => '1'] )) {

                        $member_update = Member::where('_id', '=', Auth::guard('members')->user()->_id)->first();
                        $member_update->online_status = '1';

                        if($member_update->member_type == 'teacher'){
                            $member_update->member_role = 'teacher';
                        }
                        
                        $member_update->last_action_at = date('Y-m-d H:i:s');
                        $member_update->save();

                        Session::forget('lang');

                        return redirect('/')->with('login', 'success');
                    }
                }
                //online
                else{
                    if(($member_info->online_status == '1') && ($member_info->remember_token == $request->_token)){
                        return redirect('/')->with('login', 'success');
                    }

                    return Redirect::back()->with('already_login', 'fales');
                }
            }
            else{
                return Redirect::back()->with('login', 'fales');
            }
        }
        else{
            return Redirect::back()->with('login', 'fales');
        }

        


        // if (Auth::guard('members')->attempt( [ 'member_email' => $request->member_email , 'password' => $request->member_password, 'member_status' => '1'] )) {

        //     $member_update = Member::where('_id', '=', Auth::guard('members')->user()->_id)->first();
        //     $member_update->online_status = '1';

        //     if($member_update->member_type == 'teacher'){
        //         $member_update->member_role = 'teacher';
        //     }
            
        //     $member_update->last_action_at = date('Y-m-d H:i:s');
        //     $member_update->save();

        //     Session::forget('lang');

        //     return redirect('/')->with('login', 'success');
        // }

        // return Redirect::back()->with('login', 'fales');
    }

    public function getLogout(){

        $member_update = Member::where('_id', '=', Auth::guard('members')->user()->_id)->first();
        $member_update->online_status = '0';
        $member_update->last_action_at = date('Y-m-d H:i:s');
        $member_update->save();

        Auth::guard('members')->logout();
        
        return redirect('/')->with('logout', 'success');
    }

    public function setLangTH(){
        if(isset(Auth::guard('members')->user()->_id)){
            $member_update = Member::where('_id', '=', Auth::guard('members')->user()->_id)->first();
            $member_update->member_lang = 'th';
            $member_update->last_action_at = date('Y-m-d H:i:s');
            $member_update->save();
        }
        else{
            Session::put('lang','th');
        }
        
        return redirect()->back();
    }

    public function setLangEN(){
        if(isset(Auth::guard('members')->user()->_id)){
            $member_update = Member::where('_id', '=', Auth::guard('members')->user()->_id)->first();
            $member_update->member_lang = 'en';
            $member_update->last_action_at = date('Y-m-d H:i:s');
            $member_update->save();
        }
        else{
            Session::put('lang','en');
        }

        return redirect()->back();
    }
}
