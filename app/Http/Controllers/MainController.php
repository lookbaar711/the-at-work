<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Member;
use App\Models\Subject;
use App\Models\MemberNotification;
use Auth;

class MainController extends Controller {


	/**
	 * Message bag.
	 *
	 * @var Illuminate\Support\MessageBag
	 */
	protected $messageBag = null;

    /**
     * Initializer.
     *
     */
	public function __construct()
	{
		$this->messageBag = new MessageBag;

	}

    public function getFrontend()
    {
			$members = Member::where('member_status', '1')->whereNotNull('member_Bday')->take(3)->orderBy('created_at','asc')->get();
    	// $members = Member::where('member_status', '1')->whereNotNull('member_Bday')->orderBy('created_at', 'desc')->take(4)->get();

    	update_last_action();

    	return view('frontend.index', compact('members'));
	}

	public function backend()
    {
		// $members_new = Member::where('member_status', '=', '0')->get();
		// $members_old = Member::where('member_status', '=', '1')->where('member_type', '=', 'teacher')->get();
		// $subject = Subject::all();
		// $data = [count($members_new), count($members_old), count($subject)];

		// update_last_action();
		// //return $data;
		// return view('backend.index', compact('data'));

		$classroom = Classroom::orderBy('classroom_date','desc')->get();
		
        return view('backend.classroom.classroom-index', compact('classroom'));
    }

    public function showView($name=null)
    {
		$members = Member::all();
		update_last_action();

        return view($name,compact('members'));
	}
}
