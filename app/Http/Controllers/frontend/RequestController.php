<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aptitude;
use App\Models\Member;
use App\Models\Subject;
use App\Models\Other_subject;
use App\Models\Course;
use App\Models\Coin;
use App\Models\Withdraw;
use App\Models\Classroom;
use App\Models\RequestSubjects;
use App\Models\MemberNotification;
use App\Models\StudentRating;
use App;
use Auth;
use Lang;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
// use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

    }

    public function search_study_group(Request $request){
      $data = Aptitude::orderBy('created_at','asc')->get();
      $datas = [];
      foreach ($data as $key => $value) {
          if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
              App::setLocale('en');
              $datas[] = [
                  'id_aptitude' => $value['_id'],
                  'id' => $value['aptitude_subject'],
                  'name' => $value['aptitude_name_en'],
              ];
          }else{
              App::setLocale('th');
              $datas[] = [
                  'id_aptitude' => $value['_id'],
                  'id' => $value['aptitude_subject'],
                  'name' => $value['aptitude_name_th'],
              ];
          }

      }

      return json_encode(array(
          'results' => $datas,
      ));

    }


    public function search_subjects(Request $request)
    {

      //$new_id = explode(",",$request->id);

      $data = Aptitude::where('_id',$request->id)->first();

      // dd($data);
      $datas = [];
      foreach ($data->aptitude_subject as $key => $subject_id) {
        $subject = Subject::where('_id', $subject_id)->first();
        if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            App::setLocale('en');
            $datas[] = [
                'id' => $subject->id,
                'subject_id' => $subject->id,
                'subject_name' => $subject->subject_name_en,
            ];
        }else{
            App::setLocale('th');
            $datas[] = [
                'id' => $subject->id,
                'subject_id' => $subject->id,
                'subject_name' => $subject->subject_name_th,
            ];
        }


      }

      return json_encode(array(
          'results' => $datas,
      ));

    }

    public function get_user_profile($id){
      //ข้อมูลนักเรียน
      $members = Member::where('_id', $id)->first();
      return view('frontend.request.user-profile-request', compact('members'));
    }

    public function request_profile_cousres(Request $request){
      //ประวัติการสมัคร
      $classroom = Classroom::where('classroom_student.student_id', $request->id)
      ->select('classroom_student', 'created_at')
      ->orderBy('created_at','desc')
      ->groupBy('course_id')
      ->get();

      $courses = [];
      // dd($classroom);
      foreach ($classroom as $key => $value) {
          $course = Course::where('_id', '=', $value->course_id)->first();
          $aptitude = Aptitude::where('_id', $course->course_group)->first();
          $subject = Subject::where('_id', $course->course_subject)->first();    

          if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
              $course->course_group = $aptitude->aptitude_name_en;
              $course->course_subject = $subject->subject_name_en;
          }
          else{
              $course->course_group = $aptitude->aptitude_name_th;
              $course->course_subject = $subject->subject_name_th;
          }

          $course->student = count($value->classroom_student);

          $link_open = MemberNotification::where('course_id', $value->course_id)
                      ->where('classroom_date', date('Y-m-d'))
                      ->where('noti_type', 'open_course_student')
                      ->first();
          if($link_open){
              if(date('H:i:s') > date("H:i:s",strtotime($link_open->classroom_time_start." -10 minutes")) &&
              date('H:i:s') < $link_open->classroom_time_end){
                  $course->link_open = $link_open->id;
                  $course->status_show = "true";
              }elseif(date('H:i:s') > $link_open->classroom_time_end) {
                  $course->status_show = "false";
              }
          }

          $student_rating = StudentRating::where('course_id', '=', $value->course_id)
                            ->where('member_id', '=', $request->id)
                            ->first();

          if($student_rating){
            $course->check_assess = $student_rating->rating_status;
            $course->rating_id = $student_rating->_id;
          }
          else{
            $course->check_assess = '0';
            $course->rating_id = '';
          }

          $courses[] = $course;
      }

      $currentPage = LengthAwarePaginator::resolveCurrentPage();

      //Create a new Laravel collection from the array data
      $collection = Collect($courses);

      //Define how many items we want to be visible in each page
      $per_page = 3;

      //Slice the collection to get the items to display in current page
      $currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();

      //Create our paginator and add it to the data array
      $data['courses'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);

      //Set base url for pagination links to follow e.g custom/url?page=6
      $data['courses']->setPath($request->url());


      if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
        App::setLocale('en');
        $course_create = "Edit";
        $student = "Student";
      }else {
        App::setLocale('th');
        $course_create = "แก้ไข";
        $student = "ผู้เรียน";
      }

      $free_course = Lang::get('frontend/members/title.free_course');
      $course_document = Lang::get('frontend/members/title.course_document');
      $download_button = Lang::get('frontend/members/title.download_button');
      $close_register = Lang::get('frontend/members/title.close_register');
      $openning_register = Lang::get('frontend/members/title.openning_register');
      $waiting_register = Lang::get('frontend/members/title.waiting_register');
      $course_detail = Lang::get('frontend/members/title.course_detail');
      $student_number = Lang::get('frontend/members/title.student_number');
      $review_button = Lang::get('frontend/members/title.review_button');



      $data = array(
        'cousres' => $data,
        'free_course' => $free_course,
        'course_document' => $course_document,
        'download_button' => $download_button,
        'close_register' => $close_register,
        'openning_register' => $openning_register,
        'waiting_register' => $waiting_register,
        'course_detail' => $course_detail,
        'student_number' => $student_number,
        'review_button' => $review_button,
        'course_create' => $course_create,
        'student' => $student,
      );
      return json_encode($data);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $dt = new Carbon($request->data['day_study']." ".$request->data['start_time']);
      $courses = Course::where('member_id', '=', Auth::guard('members')->user()->id)
      ->where('course_date.date', '=', $dt->format('Y-m-d'))
      ->get();

      $teacher_id = collect();
      foreach ($courses as $key => $course) {
        $dates = collect($course->course_date)->where('date', $dt->format('Y-m-d'))->all();
        foreach ($dates as $key1 => $date) {
          $dt_start = new Carbon($dt->format('Y-m-d')." ".$date['time_start']);
          $dt_end = new Carbon($dt->format('Y-m-d')." ".$date['time_end']);
          if ($dt >= $dt_start && $dt <= $dt_end) {
            $teacher_id->push($course->member_id);
          }
        }
      }

      $teachers = Member::where('member_status', '=', '1')
        ->whereNotIn('_id', $teacher_id)
        ->where('member_id', "!=", Auth::guard('members')->user()->id)
        ->where('member_teacher', '=', '1')
        ->where('member_rate_end', '>=', intval(preg_replace("/[,]/", "", $request->data['price_range'])))
        ->where('member_rate_start', '<=', intval(preg_replace("/[,]/", "", $request->data['price_range'])))
        ->where('member_aptitude.'.$request->data['study_group_id'], '=', $request->data['subjects_id'])
        ->get();
      $teachers_id = [];
      // dd($teachers);
      foreach ($teachers as $key => $teacher) {
        //insert noti to teacher
        $aptitude = Aptitude::where('_id', $request->data['study_group_id'])->first();
        $subject = Subject::where('_id', $request->data['subjects_id'])->first();

        $teacher_noti = new MemberNotification;
        $teacher_noti->student_id = Auth::guard('members')->user()->id;
        $teacher_noti->student_fullname = Auth::guard('members')->user()->member_fname." ".Auth::guard('members')->user()->member_lname;
        $teacher_noti->request_topic = $request->data['topic'];
        $teacher_noti->request_group_id = $request->data['study_group_id'];
        $teacher_noti->request_group_name_th= $aptitude->aptitude_name_th;
        $teacher_noti->request_group_name_en = $aptitude->aptitude_name_en;
        $teacher_noti->request_subject_id = $request->data['subjects_id'];
        $teacher_noti->request_subject_name_th = $subject->subject_name_th;
        $teacher_noti->request_subject_name_en = $subject->subject_name_en;
        $teacher_noti->request_date = date('Y-m-d', strtotime($request->data['day_study']));
        $teacher_noti->request_time = $request->data['start_time'];
        $teacher_noti->member_id =  $teacher->id;
        $teacher_noti->noti_type = "request_to_teacher";
        $teacher_noti->noti_status = '0';
        $teacher_noti->save();

        //send noti
        sendMemberNoti($teacher->id);

        $teachers_id[] = $teacher->id;
      }
      $request_id = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,40);
      $data = ([
          'request_id' => $request_id,
          'request_type' => $request->data['study_now'],
          'request_date' => $request->data['day_study'],
          'request_time' => $request->data['start_time'],
          'request_group_id' => $request->data['study_group_id'],
          'request_subject_id' => $request->data['subjects_id'],
          'request_topic' => $request->data['topic'],
          'request_detail' => $request->data['details_study'],
          'request_price' => intval(preg_replace("/[,]/", "", $request->data['price_range'])),
          'request_member_id' => Auth::guard('members')->user()->id,
          'request_member_fname' => Auth::guard('members')->user()->member_fname,
          'request_member_lname' => Auth::guard('members')->user()->member_lname,
          'request_teachers' => $teachers_id,
          'request_status' => '0',
      ]);
      RequestSubjects::create($data);
      if(count($teachers_id)>0){

        return json_encode($request_id);
      } else{

        return json_encode("false");
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $request_detail = RequestSubjects::where('request_id', '=', $id)->first();
        // foreach ($request_detail->request_teachers as $key => $value) {
        //   $teacher = Member::where('_id', '=', $value)->first();
        //   $teacher_detail[] = $teacher;
        // }

        $request_detail = RequestSubjects::where('request_id', '=', $id)->first();

        $teachers = Member::whereIn('_id', $request_detail->request_teachers)
                  ->where('member_status', '=', '1')
                  ->where('member_id', '!=', Auth::guard('members')->user()->id)
                  ->orderby('online_status','desc')
                  ->orderby('member_fname','asc')
                  ->get();

        $teacher_detail = $teachers;

        update_last_action();

        return view('frontend.request.request-all', compact('teacher_detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_request()
    {
      $request = RequestSubjects::where('request_member_id', Auth::guard('members')->user()->id)
                ->where('request_status', '0')
                ->where('request_date', '>=', date('Y-m-d'))
                ->get();

      return json_encode(array(
          'results' => $request,
      ));

    }
}
