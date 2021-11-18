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
use App\Models\RatingQuestions;
use App\Models\StudentRating;
use App\Models\TeacherRating;
use App\Http\Controllers\frontend\MemberController;
use Auth;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class RatingController extends Controller
{
   public function index($course_id) {
      update_last_action();

      $teacher_rating = TeacherRating::where('course_id', '=', $course_id)
                        ->where('member_id', '=', Auth::guard('members')->user()->member_id)
                        ->first();

      //เป็นนักเรียนในคอร์ส
      if($teacher_rating){
         if($teacher_rating->rating_status == '0'){
            return view('frontend.rating.teacher_rating', compact('course_id'));
         }
         else{
            if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
               $lang = 'en';
               $error_text = "You can't assess this teaching. Because you have already assessed";
            }
            else{
               $lang = 'th';
               $error_text = "คุณไม่สามารถให้คะแนนการสอนนี้ได้ เนื่องจากคุณได้ให้คะแนนไปแล้ว";
            }

            return redirect()->back()->with('alerterror', $error_text);
         }
      }
      //ไม่ได้เป็นนักเรียนในคอร์ส
      else{
         if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            $lang = 'en';
            $error_text = "You don't have permission to assess this teaching.";
         }
         else{
            $lang = 'th';
            $error_text = "คุณไม่มีสิทธิ์ให้คะแนนการสอนนี้";
         }

         return redirect()->back()->with('alerterror', $error_text);
      }
   }

   public function sentTeacherRating($course_id) {
      update_last_action();

      $teacher_rating = TeacherRating::where('course_id', '=', $course_id)
                        ->where('member_id', '=', Auth::guard('members')->user()->member_id)
                        ->first();

      //เป็นนักเรียนในคอร์ส
      if($teacher_rating){
         if($teacher_rating->rating_status == '0'){
            $teaching_rating_questions = RatingQuestions::where('question_type', '=', 'teaching')
                                       ->where('question_status', '=', '1')
                                       ->orderby('question_order','asc')
                                       ->get();

            return view('frontend.rating.sent_teacher_rating', compact('course_id','teaching_rating_questions'));
         }
         else{
            if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
               $lang = 'en';
               $error_text = "You can't assess this teaching. Because you have already assessed";
            }
            else{
               $lang = 'th';
               $error_text = "คุณไม่สามารถให้คะแนนการสอนนี้ได้ เนื่องจากคุณได้ให้คะแนนไปแล้ว";
            }

            return redirect()->back()->with('alerterror', $error_text);
         }
      }
      //ไม่ได้เป็นนักเรียนในคอร์ส
      else{
         if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            $lang = 'en';
            $error_text = "You don't have permission to assess this teaching.";
         }
         else{
            $lang = 'th';
            $error_text = "คุณไม่มีสิทธิ์ให้คะแนนการสอนนี้";
         }

         return redirect()->back()->with('alerterror', $error_text);
      }
   }

   public function saveTeacherRating(Request $request) {
      update_last_action();

      $teacher_rating = TeacherRating::where('course_id', '=', $request->course_id)
                        ->where('member_id', '=', Auth::guard('members')->user()->member_id)
                        ->first();

      if($teacher_rating){
         if($teacher_rating->rating_status == '0'){
            $rating = array();
            $sum_rating = 0;

            for($i=1; $i<=count($request->rating_id); $i++) { 
               if(isset($request->rating_1)){
                  $rating_name = 'rating_'.$i;
               }
               else{
                  $rating_name = 'rating_m_'.$i;
               }

               $rating_value = isset($request->$rating_name)?$request->$rating_name:'5';
               $j = $i-1;

               $rate = array(
                           $request->rating_id[$j], //id
                           $rating_value, //value
                        );

               array_push($rating,$rate);

               $sum_rating = $sum_rating+$rating_value;
            }

            $average_rating = round($sum_rating / count($request->rating_id));


            $teacher_rating->rating = $rating;
            $teacher_rating->average_rating = ''.$average_rating.'';
            $teacher_rating->rating_status = '1';
            $teacher_rating->save();

            return redirect('/')->with('teaching_rating', 'success');
         }
         else{
            if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
               $lang = 'en';
               $error_text = "You can't assess this teaching. Because you have already assessed";
            }
            else{
               $lang = 'th';
               $error_text = "คุณไม่สามารถให้คะแนนการสอนนี้ได้ เนื่องจากคุณได้ให้คะแนนไปแล้ว";
            }

            return redirect()->back()->with('alerterror', $error_text);
         }
      }
      else{
         if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            $lang = 'en';
            $error_text = "You don't have permission to assess this teaching.";
         }
         else{
            $lang = 'th';
            $error_text = "คุณไม่มีสิทธิ์ให้คะแนนการสอนนี้";
         }

         return redirect()->back()->with('alerterror', $error_text);
      }
   }


   public function indexStudentRating($course_id) {
      update_last_action();

      $student_rating = StudentRating::where('course_id', '=', $course_id)
                        ->where('teacher_id', '=', Auth::guard('members')->user()->member_id)
                        ->first();

      //เป็นอาจารย์ในคอร์ส
      if($student_rating){
         $all_student_rating = StudentRating::where('course_id', '=', $course_id)
                              ->count();

         $count_sent_student_rating = StudentRating::where('course_id', '=', $course_id)
                                    ->where('rating_status', '=', '1')
                                    ->count();

         //เช็คจำนวนคนที่ให้คะแนนว่าให้ไปครบทุกคนแล้วหรือยัง 
         //ถ้ายังให้ไม่ครบ สามารถเข้าไปให้คะแนนอีกได้
         if($count_sent_student_rating < $all_student_rating){
            return view('frontend.rating.student_rating', compact('course_id'));
         }
         //แต่ถ้าให้ครบแล้ว จะไม่สามารถเข้าไปให้คะแนนอีกได้
         else{
            if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
               $lang = 'en';
               $error_text = "You can't assess this learning. Because you have already assessed";
            }
            else{
               $lang = 'th';
               $error_text = "คุณไม่สามารถให้คะแนนการเรียนนี้ได้ เนื่องจากคุณได้ให้คะแนนไปแล้ว";
            }

            return redirect()->back()->with('alerterror', $error_text);
         }
      }
      //ไม่ได้เป็นอาจารย์ในคอร์ส
      else{
         if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            $lang = 'en';
            $error_text = "You don't have permission to assess this learning.";
         }
         else{
            $lang = 'th';
            $error_text = "คุณไม่มีสิทธิ์ให้คะแนนการเรียนนี้";
         }

         return redirect()->back()->with('alerterror', $error_text);
      }
   }

   public function sentStudentRating($course_id) {
      update_last_action();

      $student_rating = StudentRating::where('course_id', '=', $course_id)
                        ->where('teacher_id', '=', Auth::guard('members')->user()->member_id)
                        ->first();

      //เป็นอาจารย์ในคอร์ส
      if($student_rating){
         $all_student_rating = StudentRating::where('course_id', '=', $course_id)
                              ->count();

         $count_sent_student_rating = StudentRating::where('course_id', '=', $course_id)
                                    ->where('rating_status', '=', '1')
                                    ->count();

         //เช็คจำนวนคนที่ให้คะแนนว่าให้ไปครบทุกคนแล้วหรือยัง 
         //ถ้ายังให้ไม่ครบ สามารถเข้าไปให้คะแนนอีกได้
         if($count_sent_student_rating < $all_student_rating){
            $learning_rating_questions = RatingQuestions::where('question_type', '=', 'learning')
                                       ->where('question_status', '=', '1')
                                       ->orderby('question_order','asc')
                                       ->get();

            // $classroom = Classroom::where('course_id', '=' ,$course_id)->first();

            // return view('frontend.rating.sent_student_rating', compact('course_id','learning_rating_questions','classroom'));


            $classroom = Classroom::where('course_id', '=' ,$course_id)->first();
            $rating_status = array();

            foreach ($classroom->classroom_student as $key => $item){
               $student = StudentRating::where('course_id', '=', $course_id)
                           ->where('member_id', '=', $item['student_id'])
                           ->first();

               $rating_status[$key]['student_id'] = $item['student_id'];
               $rating_status[$key]['student_fname'] = $item['student_fname'];
               $rating_status[$key]['student_lname'] = $item['student_lname'];
               $rating_status[$key]['rating_status'] = $student->rating_status;
            }

            return view('frontend.rating.sent_student_rating', compact('course_id','learning_rating_questions','rating_status'));
         }
         //แต่ถ้าให้ครบแล้ว จะไม่สามารถเข้าไปให้คะแนนอีกได้
         else{
            if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
               $lang = 'en';
               $error_text = "You can't assess this learning. Because you have already assessed";
            }
            else{
               $lang = 'th';
               $error_text = "คุณไม่สามารถให้คะแนนการเรียนนี้ได้ เนื่องจากคุณได้ให้คะแนนไปแล้ว";
            }

            return redirect()->back()->with('alerterror', $error_text);
         }
      }
      //ไม่ได้เป็นอาจารย์ในคอร์ส
      else{
         if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            $lang = 'en';
            $error_text = "You don't have permission to assess this learning.";
         }
         else{
            $lang = 'th';
            $error_text = "คุณไม่มีสิทธิ์ให้คะแนนการเรียนนี้";
         }

         return redirect()->back()->with('alerterror', $error_text);
      }
   }

   public function saveStudentRating(Request $request) {
      update_last_action();

      $student_rating = StudentRating::where('course_id', '=', $request->course_id)
                        ->where('teacher_id', '=', Auth::guard('members')->user()->member_id)
                        ->first();

      //เป็นอาจารย์ในคอร์ส
      if($student_rating){
         for($i=1; $i<=count($request->student_id); $i++) { 
            $rating = array();
            $sum_rating = 0;
            $x = $i-1;

            for($j=1; $j<=count($request->rating_id); $j++) {
               //$rating_value = 'rating_'.$j;
               if(isset($request->rating_1)){
                  $rating_name = 'rating_'.$j;
                  $recomment_name = 'recommend_web';
               }
               else{
                  $rating_name = 'rating_m_'.$j;
                  $recomment_name = 'recommend_mobile';
               }

               $rating_value = isset($request->$rating_name)?$request->$rating_name:'5';

               $y = $j-1;

               //$request->student_id[$x] student_id

               $rate = array(
                           $request->rating_id[$y], //id
                           $rating_value, //value
                        );

               array_push($rating,$rate);

               $sum_rating = $sum_rating+$rating_value;
            }

            $average_rating = round($sum_rating / count($request->rating_id));

            $save_student_rating = StudentRating::where('course_id', '=', $request->course_id)
                                 ->where('member_id', '=', $request->student_id[$x])
                                 ->first();

                                 

            $save_student_rating->rating = $rating;
            $save_student_rating->average_rating = ''.$average_rating.'';
            $save_student_rating->recommend = isset($request->$recomment_name)?$request->$recomment_name:'';
            $save_student_rating->rating_status = '1';
            $save_student_rating->save();
         }
         
         $all_student_rating = StudentRating::where('course_id', '=', $request->course_id)
                              ->count();

         $count_sent_student_rating = StudentRating::where('course_id', '=', $request->course_id)
                                    ->where('rating_status', '=', '1')
                                    ->count();

         //check student rating
         if($all_student_rating == $count_sent_student_rating){
            return redirect('/')->with('learning_rating', 'success');
         }
         else{
            return redirect()->back()->with('learning_rating', 'success');
         }
      }
      //ไม่ได้เป็นอาจารย์ในคอร์ส
      else{
         if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            $lang = 'en';
            $error_text = "You don't have permission to assess this learning.";
         }
         else{
            $lang = 'th';
            $error_text = "คุณไม่มีสิทธิ์ให้คะแนนการเรียนนี้";
         }

         return redirect()->back()->with('alerterror', $error_text);
      }
   }


   public function showStudentRating($rating_id) {
      update_last_action();

      //return $rating_id;

      $student_rating = StudentRating::where('_id', '=', $rating_id)->first();

      $learning_rating_questions = RatingQuestions::where('question_type', '=', 'learning')
                                    ->where('question_status', '=', '1')
                                    ->orderby('question_order','asc')
                                    ->get();

      $classroom = Classroom::where('course_id', '=' ,$student_rating->course_id)->first();
      $rating_detail = array();

      foreach ($classroom->classroom_student as $key => $item){

         if($item['student_id'] == $student_rating->member_id){
            $student = StudentRating::where('course_id', '=', $student_rating->course_id)
                        ->where('member_id', '=', $item['student_id'])
                        ->first();
            
            $rating_detail['course_name'] = $classroom->classroom_name;
            $rating_detail['teacher_name'] = $classroom->classroom_teacher['teacher_fname'].' '.$classroom->classroom_teacher['teacher_lname'];
            $rating_detail['student_name'] = $item['student_fname'].' '.$item['student_lname'];

            break;
         }
         else{
            continue;
         }

         
      }
      //return $student_rating->rating[0][0];

      return view('frontend.rating.show_student_rating', compact('student_rating','learning_rating_questions','rating_detail'));
   }
   
   
}
