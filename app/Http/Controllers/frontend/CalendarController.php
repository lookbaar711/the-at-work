<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Member;
use App\Models\Classroom;
use App\Models\Aptitude;
use App\Models\Subject;
use Auth;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class CalendarController extends Controller
{
   public function index(Request $request) {
      if(Auth::guard('members')->user()->member_role !='teacher'){
         return redirect('/');
      }
      $course = $this->getCourse();
      $data = array();
        //Get current page form url e.g. &page=6
      $currentPage = LengthAwarePaginator::resolveCurrentPage();

      //Create a new Laravel collection from the array data
      $collection = Collect($course)->sortBy('sort_date')->values();
      //Define how many items we want to be visible in each page
      $per_page = 2;

      //Slice the collection to get the items to display in current page
      $currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
      //Create our paginator and add it to the data array
      $data['coursies'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);

      //Set base url for pagination links to follow e.g custom/url?page=6
      $data['coursies']->setPath($request->url());
      // dd($data['coursies']);

      update_last_action();

      return view('frontend.calendar.calendar', $data);
      // return view('frontend.calendar.calendar', ['coursies' => $course]);

      //return $data
   }

   public function show(Request $request) {
      if(Auth::guard('members')->user()->member_type !='teacher' && $request->page){
         return;
      }
      $course = $this->getCourse();
      $data = array();
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $collection = Collect($course)->sortBy('time_start')->sortBy('date');
      $per_page = 2;
      $currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
      $data['coursies'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);
      $data['coursies']->setPath($request->url());
      update_last_action();
      return view('frontend.calendar.calendar', $data);
   }

   public function getCourse()
   {
      $course= Course::where('member_id', '=', Auth::guard('members')->user()->id)->where('course_date.date', '>=', date('Y-m-d'))->get();
      // $course = Course::where('course_date.date', '>=', date('Y-m-d'))->get();
      $course_id = collect();
      $aptitude_id = collect();
      $subject_id = collect();
      foreach ($course as $key => $value) {
         $course_id->push($value->_id);
         $aptitude_id->push($value->course_group);
         $subject_id->push($value->course_subject);
      }
      $classroom = Classroom::whereIn('course_id', $course_id)->get();
      $aptitude = Aptitude::whereIn('_id', $aptitude_id)->get();
      $subject = Subject::whereIn('_id', $subject_id)->get();
      $data = collect();
      foreach ($course as $key => $value) {
         $students = [];
         foreach ($classroom->where('course_id', $value->_id)->values() as $key1 => $student) {
            $students = $student->classroom_student;
         }
         $dt = date('Y-m-d');
         foreach (collect($value->course_date)->where('date', '>=', $dt)->sortBy('date')->sortBy('time_start') as $key2 => $date) {
            $course_aptitude = $aptitude->where('_id', $value->course_group)->values();
            $course_subject = $subject->where('_id', $value->course_subject)->values();

            $data->push([
               'member_id' => Auth::guard('members')->user()->id,
               'course_id' => $value->_id,
               'course_name' =>  $value->course_name,
               'subject_name_th' => $course_subject[0]['subject_name_th'],
               'subject_name_en' => $course_subject[0]['subject_name_en'],
               'aptitude_name_th' => $course_aptitude[0]['aptitude_name_th'],
               'aptitude_name_en' => $course_aptitude[0]['aptitude_name_en'],
               'course_price' => $value->course_price,
               'course_img' => $value->course_img,
               'student' => $students,
               'date' => $date['date'],
               'time_start' => $date['time_start'],
               'time_end' => $date['time_end'],
               'course_file' => $value->course_file,
               'course_category' => $value->course_category,
               'course_student_limit' => $value->course_student_limit,
               'sort_date' => Carbon::createFromFormat('Y-m-d H:i:s', $date['date']." ".$date['time_start'])
            ]);
         }
      }
      return $data;
   }

   public function schedule()
   {
      $course= Course::where('member_id', '=', Auth::guard('members')->user()->id)->get();
      $course_id = collect();
      foreach ($course as $key => $value) {
         $course_id->push($value->_id);
      }

      $data = collect();
      foreach ($course as $key => $value) {
         foreach (collect($value->course_date)->sortBy('date')->sortBy('time_start') as $key2 => $date) {
            $data->push([
               'member_id' => Auth::guard('members')->user()->id,
               'course_id' => $value->_id,
               'course_name' => $value->course_name,
               'date' => $date['date'],
               'time_start' => $date['time_start'],
               'time_end' => $date['time_end'],
            ]);
         }
      }
      return $data;
   }

   public function getTeacherCourse(Request $request)
   {
      $courses = Course::where('member_id', '=', Auth::guard('members')->user()->id)->where('course_date.date', '>=', date('Y-m-d'))->get();
      // $course = Course::where('course_date.date', '>=', date('Y-m-d'))->get();
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
         foreach ($classroom->where('course_id', $value->_id)->values() as $key1 => $student) {
            $students = $student->classroom_student;
         }
         $dt = date('Y-m-d');
         foreach (collect($value->course_date)->where('date', '>=', $dt)->sortBy('date')->sortBy('time_start') as $key2 => $date) {
            $course_aptitude = $aptitude->where('_id', $value->course_group)->values();
            $course_subject = $subject->where('_id', $value->course_subject)->values();

            $course->push([
               'member_id' => Auth::guard('members')->user()->id,
               'teacher_id' => Auth::guard('members')->user()->id,
               'member_status' => Auth::guard('members')->user()->member_type,
               'course_id' => $value->_id,
               'course_name' =>  $value->course_name,
               'subject_name_th' => $course_subject[0]['subject_name_th'],
               'subject_name_en' => $course_subject[0]['subject_name_en'],
               'aptitude_name_th' => $course_aptitude[0]['aptitude_name_th'],
               'aptitude_name_en' => $course_aptitude[0]['aptitude_name_en'],
               'course_price' => $value->course_price,
               'course_img' => $value->course_img,
               'student' => $students,
               'date' => $date['date'],
               'date_start' => '',
               'date_end' => '',
               'time_start' => substr($date['time_start'], 0, 5),
               'time_end' => substr($date['time_end'], 0, 5),
               'course_file' => $value->course_file,
               'course_category' => $value->course_category,
               'course_student_limit' => $value->course_student_limit,
               'sort_date' => Carbon::createFromFormat('Y-m-d H:i:s', $date['date']." ".$date['time_start'])
            ]);
         }
      }

      $data = array();
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $collection = Collect($course)->sortBy('sort_date')->values();;
      $per_page = 2;
      $currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
      $data['paginator'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);
      $data['paginator']->setPath($request->url());

      return $data;
   }
}
