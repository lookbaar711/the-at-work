<?php 
namespace App\Http\Controllers\backend;

use App\Http\Requests\ConfirmPasswordRequest;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Mail;
use Reminder;
use Sentinel;
use URL;
use Validator;
use View;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ForgotRequest;
use stdClass;
use App\Mail\ForgotPassword;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Auth;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Account sign in.
     *
     * @return View
     */
    public function getSignin()
    {
        return view('backend.login');
    }

    /**
     * Account sign in form processing.
     * @param Request $request
     * @return Redirect
     */
    public function postSignin(Request $request)
    {

        $credentials = request(['email', 'password']);
        if (Auth::guard('web')->attempt($credentials)) {
            return redirect('/backend');
        }

        return Redirect::back()->withInput()->withErrors('account_not_found');
    }

    /**
     * Account sign up form processing.
     *
     * @return Redirect
     */
    public function postSignup(Request $request)
    {
        
        try {
            // Register the admin
            $data = ([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);
    
            Admin::create($data);
            return Redirect::route("backend")->with('success', trans('auth/message.signin.success'));

        } catch (UserExistsException $e) {
            $this->messageBag->add('email', trans('auth/message.account_already_exists'));
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
    }

    public function getLogout(){
        Auth::guard('web')->logout();
        return redirect('backend/signin')->with('success', 'You have successfully logged out!');
    }


}
