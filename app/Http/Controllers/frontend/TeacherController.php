<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Member;
use App\Models\Aptitude;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\MapTeacherSubject;
use App\Http\Controllers\frontend\MemberController;
use Auth;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class TeacherController extends Controller
{
   public function index(Request $request) {
      update_last_action();
      $data = [
          'aptitude' => Aptitude::get(),
          'subject' => Subject::where('is_master', '1')->get(),
      ];
      return view('frontend.members.member-all', $data);
   }

   public function show(Request $request) {
      // dd($request->all());
      if(Auth::guard('members')->user()->member_type !='teacher' && $request->page){
         return;
      }
      $course = $this->getCourse();
      $data = array();
        //Get current page form url e.g. &page=6
      $currentPage = LengthAwarePaginator::resolveCurrentPage();

      //Create a new Laravel collection from the array data
      $collection = Collect($course)->sortBy('time_start')->sortBy('date');

      //Define how many items we want to be visible in each page
      $per_page = 2;

      //Slice the collection to get the items to display in current page
      $currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();

      //Create our paginator and add it to the data array
      $data['coursies'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);

      //Set base url for pagination links to follow e.g custom/url?page=6
      $data['coursies']->setPath($request->url());
      // dd($data);

      update_last_action();

      return view('frontend.calendar.carlendar', $data);
   }

   public function getTeacher(Request $request)
   {
      if ($request->teacher_name && $request->aptitude && $request->subject) {
         $map = MapTeacherSubject::where('aptitude_id', $request->aptitude)->where('subject_id', $request->subject)->get();
         $members_id = collect();
         foreach ($map->groupBy('members_id') as $key => $value) {
            $members_id->push($key);
         }
         $teachers = Member::whereNotNull('member_Bday')->where('member_status', '1')->whereIn('_id', $members_id)->where('member_fullname', 'like', '%'.$request->teacher_name.'%')->orderBy('created_at','asc')->get();
      } else if ($request->teacher_name && $request->aptitude) {
         $map = MapTeacherSubject::where('aptitude_id', $request->aptitude)->get();
         $members_id = collect();
         foreach ($map->groupBy('members_id') as $key => $value) {
            $members_id->push($key);
         }
         $teachers = Member::whereNotNull('member_Bday')->where('member_status', '1')->whereIn('_id', $members_id)->orderBy('created_at','asc')->get();
      } else if ($request->teacher_name && $request->subject) {
         $map = MapTeacherSubject::where('subject_id', $request->subject)->get();
         $members_id = collect();
         foreach ($map->groupBy('members_id') as $key => $value) {
            $members_id->push($key);
         }
         $teachers = Member::whereNotNull('member_Bday')->where('member_status', '1')->whereIn('_id', $members_id)->orderBy('created_at','asc')->get();
      } else if ($request->aptitude && $request->subject) {
         $map = MapTeacherSubject::where('aptitude_id', $request->aptitude)->where('subject_id', $request->subject)->get();
         $members_id = collect();
         foreach ($map->groupBy('members_id') as $key => $value) {
            $members_id->push($key);
         }
         $teachers = Member::whereNotNull('member_Bday')->where('member_status', '1')->whereIn('_id', $members_id)->orderBy('created_at','asc')->get();
      } else if ($request->teacher_name) {
         $teachers = Member::whereNotNull('member_Bday')->where('member_status', '1')->where('member_fullname', 'like', '%'.$request->teacher_name.'%')->orderBy('created_at','asc')->get();
      } else if ($request->aptitude) {
         $map = MapTeacherSubject::where('aptitude_id', $request->aptitude)->get();
         $members_id = collect();
         foreach ($map->groupBy('members_id') as $key => $value) {
            $members_id->push($key);
         }
         $teachers = Member::whereNotNull('member_Bday')->where('member_status', '1')->whereIn('_id', $members_id)->orderBy('created_at','asc')->get();
      } else if ($request->subject) {
         $map = MapTeacherSubject::where('subject_id', $request->subject)->get();
         $members_id = collect();
         foreach ($map->groupBy('members_id') as $key => $value) {
            $members_id->push($key);
         }
         $teachers = Member::whereNotNull('member_Bday')->where('member_status', '1')->whereIn('_id', $members_id)->orderBy('created_at','asc')->get();
      } else {
         $teachers = Member::whereNotNull('member_Bday')->where('member_status', '1')->orderBy('created_at','asc')->get();
      }

      $teacher = collect();
      foreach ($teachers as $key => $value) {
         $aptitude = collect();

         $teacher->push([
               'member_id' => $value->_id,
               'member_img' => $value->member_img,
               'member_name' => $value->member_fullname,
               'member_rate_end' => $value->member_rate_end,
               'member_rate_start' => $value->member_rate_start,
               'member_aptitude' => ""
         ]);
      }

      $data = array();
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $collection = Collect($teacher);
      $per_page = 6;
      $currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
      $data['paginator'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);
      $data['paginator']->setPath($request->url());

      return $data;
   }

   public function teacherCourse (Request $request) {
      if ($request->teacher_id) {
         $courses = Course::where('member_id', '=', $request->teacher_id)->orderBy('created_at','desc')->get();
         $teacher_id = $request->teacher_id;
      }else {
         $courses = Course::where('member_id', '=', Auth::guard('members')->user()->id)->orderBy('created_at','desc')->get();
         $teacher_id = Auth::guard('members')->user()->id;
      }

      $course_id = collect();
      $aptitude_id = collect();
      $subject_id = collect();

      foreach ($courses as $key => $value) {
         $course_id->push($value->_id);
         $aptitude_id->push($value->course_group);
         $subject_id->push($value->course_subject);
      }
      $classroom = Classroom::whereIn('course_id', $course_id)->get();
      $aptitude = Aptitude::whereIn('_id', $aptitude_id)->get();
      $subject = Subject::whereIn('_id', $subject_id)->get();
      $course = collect();

      foreach ($courses as $key => $value) {
         $students = [];

         if ($value->course_category != 'Private') {
            foreach ($classroom->where('course_id', $value->_id)->values() as $key1 => $student) {
               $students = $student->classroom_student;
            }
         }else {
            $courses_status = new MemberController;
            $students = json_decode($courses_status->student_status($value->_id));
         }

         $dt = date('Y-m-d');

         $course_aptitude = $aptitude->where('_id', $value->course_group)->values();
         $course_subject = $subject->where('_id', $value->course_subject)->values();

         if (count($value->course_date) > 1) {
            $date_start = $value->course_date[0]['date'];
            $date_end = $value->course_date[count($value->course_date)-1]['date'];
            if ( $value->course_date[0]['date'] == $value->course_date[count($value->course_date)-1]['date']) {
               $date_start = $value->course_date[0]['date'];
               $date_end = '';
            }
         } else {
            $date_start = !empty($value->course_date[0]['date']) ? $value->course_date[0]['date'] : '';
            $date_end = '';
         }

         if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            $lang = 'en';
         }
         else{
            $lang = 'th';
         }

         $course->push([
            'member_id' => $teacher_id,
            'teacher_id' => !empty(Auth::guard('members')->user()) ? Auth::guard('members')->user()->member_type == 'teacher' || $teacher_id == Auth::guard('members')->user()->id ? Auth::guard('members')->user()->id : '' : '',
            'student_id' => !empty(Auth::guard('members')->user()) ? Auth::guard('members')->user()->id : '',
            'member_status' => !empty(Auth::guard('members')->user()) ? Auth::guard('members')->user()->member_type : '',
            'course_id' => $value->_id,
            'course_name' =>  $value->course_name,
            'subject_name_th' => $course_subject[0]['subject_name_th'],
            'subject_name_en' => $course_subject[0]['subject_name_en'],
            'aptitude_name_th' => $course_aptitude[0]['aptitude_name_th'],
            'aptitude_name_en' => $course_aptitude[0]['aptitude_name_en'],
            'course_price' => $value->course_price,
            'course_img' => $value->course_img,
            'student' => $students,
            'date' => '',
            'date_start' => $date_start,
            'date_end' => $date_end,
            'time_start' => '',
            'time_end' => '',
            'course_file' => $value->course_file,
            'course_category' => $value->course_category,
            'course_student_limit' => $value->course_student_limit,
            'lang' => $lang
         ]);
      }

      $data = array();
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $collection = Collect($course);
      $per_page = 3;
      $currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
      $data['paginator'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);
      $data['paginator']->setPath($request->url());

      return $data;
   }

}
