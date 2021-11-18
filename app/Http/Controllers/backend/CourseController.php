<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Member;
use App\Models\Aptitude;
use App\Models\Subject;
use App\Models\MemberNotification;
use Illuminate\Support\Str;
use Auth;

class CourseController extends Controller
{
    public function getIndex() {

        $courses = Course::orderby('created_at', 'desc')->get();

        foreach ($courses as $key => $value) {
            $aptitude = Aptitude::where('_id', '=', $value['course_group'])->first();
            $subject = Subject::where('_id', '=', $value['course_subject'])->first();

            if(isset($aptitude) && isset($subject)){
                $courses[$key]['aptitude_name_en'] = $aptitude->aptitude_name_en;
                $courses[$key]['aptitude_name_th'] = $aptitude->aptitude_name_th;

                $courses[$key]['subject_name_en'] = $subject->subject_name_en;
                $courses[$key]['subject_name_th'] = $subject->subject_name_th;
            }
        }

        $view['courses'] = $courses;

        return view('backend.courses.index', $view);
    }

    public function getUpdate(Request $request, $id) {

        $course = Course::orderby('created_at', 'desc')
            ->where('_id', $id)
            ->first();
        if(date('Y-m-d H:i:s', strtotime($course->course_date_start." ".$course->course_time_start)) < date('Y-m-d H:i:s', strtotime('+10 minutes'))){
            return redirect()->back()->with('alerterror', 'คอร์สเรียนปิดการสมัครแล้ว');
        }
        // Get subject
        $members = Member::where('_id', $course->member_id)->first();

        $subjects = $members->member_aptitude;
        $subjects_info = $subjects[$course->course_group];
        $subjects_list = array();

        foreach ($subjects_info as $key){
            $subject = Subject::where('_id', '=', $key)->first();

            //$subjects_list[$key]['subject_name_en'] = $subject->subject_name_en;
            $subjects_list[$key]['subject_name_th'] = $subject->subject_name_th;
        }


        $subject_detail = array();

        foreach (array_keys($subjects) as $key){
            if(count($subjects[$key]) > 0){
                $aptitude = Aptitude::where('_id', '=', $key)->first();

                // $subject_detail[$key]['aptitude_name_en'] = $aptitude->aptitude_name_en;
                $subject_detail[$key]['aptitude_name_th'] = $aptitude->aptitude_name_th;
            }
        }

        $view['subjects'] = $subject_detail;
        $view['course']  = $course;
        $view['subjects_list'] = $subjects_list;


        return view('backend.courses.edit', $view);
    }

    public function postUpdate(Request $request){
        /*
        // check date ที่น้องเขียนเช็คไว้ ตอนนี้ไม่ได้ใช้แล้ว
        $newTime = date('Y-m-d H:i:s', strtotime('+0 minutes'));
        $day_chk = "";
        foreach ($request->course_date as $key => $day) {
            if($key=="0"){
                if(date('Y-m-d H:i:s', strtotime($day." ".$request->time_start[$key])) < $newTime ){
                    return redirect()->back()->with('alerterror', 'กรุณาเลือกวันเวลาให้ถูกต้อง');
                }else{
                    if($request->time_start[$key] > $request->time_end[$key] ){
                        return redirect()->back()->with('alerterror', 'กรุณาเลือกวันเวลาให้ถูกต้อง');
                    }
                }
                $day_chk = date('Y-m-d', strtotime($day));
            }else{
                if(date('Y-m-d', strtotime($day)) < $day_chk  ){
                    return redirect()->back()->with('alerterror', 'กรุณาเลือกวันเวลาให้ถูกต้อง');
                }else{
                    if($request->time_start[$key] > $request->time_end[$key]){
                        return redirect()->back()->with('alerterror', 'กรุณาเลือกวันเวลาให้ถูกต้อง');
                    }
                }
                $day_chk = date('Y-m-d', strtotime($day));
            }
        }

        $check_date = explode("/",$request->course_date[1]);
        $format_check_date = $check_date[2].'-'.$check_date[1].'-'.$check_date[0];

        $first_date = date('Y-m-d', strtotime($format_check_date));
        $first_time = date('H:i:s', strtotime($request->time_start[1].":00"));
        $first_datetime = date('Y-m-d H:i:s', strtotime($first_date.' '.$first_time));

        if($first_datetime < $newTime){
            return redirect()->back()->with('alerterror', 'กรุณาตรวจวันเเละเวลาที่จะสร้างคอร์สเรียน ให้มากกว่าเวลาปัจจุบัน');
        }
        */

        $check_date = explode("/",$request->course_date[1]);
        $format_check_date = $check_date[2].'-'.$check_date[1].'-'.$check_date[0];

        $first_date = date('Y-m-d', strtotime($format_check_date));
        $first_time = date('H:i:s', strtotime($request->time_start[1].":00"));
        $first_datetime = date('Y-m-d H:i:s', strtotime($first_date.' '.$first_time));

        if($request->course_img){

            //อัพรูปปกคอร์สเรียน
            $fielName =  Str::random(7).time().".".$request->course_img->getClientOriginalExtension();
            //$path = $request->course_img->move(public_path("/storage/course"), $fielName);
            $course_path = public_path("/storage/course/");
            $course_file_path = public_path("/storage/coursefile/");
            if (!file_exists($course_path)) {
                mkdir($course_path, 0777, true);
            }
            if (!file_exists($course_file_path)) {
                mkdir($course_file_path, 0777, true);
            }
            $url = public_path("/storage/course/".$fielName);
            $path = compress_images($request->course_img, $url, 80);

        }else{
            $fielName=$request->img2;
        }


        if($request->course_file){

            //อัพไฟล์
            $course_file =  Str::random(7).time().".".$request->course_file->getClientOriginalExtension();
            $file = $request->course_file->move(public_path("/storage/coursefile"), $course_file);

        }else{
            $course_file=$request->file2;
        }

        $course_date = [];
        //order course date
        foreach ($request->course_date as $i => $value) {
            if($i!="0"){
                $select_date = explode("/",$value);
                $date = $select_date[2].'-'.$select_date[1].'-'.$select_date[0];

                $course_date[] = ([
                    'date' => $date,
                    'time_start' => $request->time_start[$i].":00",
                    'time_end' => $request->time_end[$i].":00",
                ]);
            }
        }

        sort($course_date);

        //ราคา คอร์สเรียน / ฟรี
        if(!empty($request->course_price)){
            $course_price = str_replace(",","",$request->course_price); //ลบเครื่องหมาย ,
        }else{$course_price="0";}
        //สถานะคอร์ส
        if(isset($request->course_status)){
            $status = $request->course_status;
        }else{
            $status = "close";
        }
        $course_student = [];
        if($request->course_category=="Private"){
            $course_student_limit = count($request->course_student)-1;
            foreach ($request->course_student as $key => $value) {
                if($key!="0"){
                    $course_student[] = $value;
                }
            }
        }else{
            $course_student_limit = intval($request->course_student_limit);
        }
        $course = Course::where('_id', $request->id)->first();
        $data = ([
            'member_id' => $course->member_id,
            'member_fname' => $course->member_fname,
            'member_lname' => $course->member_lname,
            'member_email' => $course->member_email,
            'course_name' => $request->course_name,
            'course_detail' => $request->course_detail,
            'course_group' => $request->course_group,
            'course_subject' => $request->course_subject,
            'course_date' => $course_date,
            'course_type' => $request->course_type,
            'course_price' =>  intval($course_price), //เก็บเป็นตัวเลข
            'course_img' => $fielName,
            'course_file' => $course_file,
            'course_student_limit' => $course_student_limit,
            'course_status' => $status,
            'course_category' => $request->course_category,
            'course_student' => $course_student,
            'course_date_start' => $format_check_date,
            'course_time_start' => $request->time_start[1].":00",
            'course_time_end' => $request->time_end[1].":00",
        ]);
        if($request->id) {
            Course::where('_id',$request->id)->update($data);
        }
        $course_id = Course::where('member_id', '=', $course->member_id)
            ->orderby('created_at','desc')
            ->first();
        $count_datetime = count($course_date)-1;
        $teacher_fullname = $course->member_fname." ".$course->member_lname;

        if($request->course_category=="Private"){
            //insert noti to teacher
            $teacher_noti = new MemberNotification();
            $teacher_noti->course_id = $course_id->id;
            $teacher_noti->course_name = $request->course_name;
            $teacher_noti->course_datetime = $course_date;
            $teacher_noti->course_start_date = $course_date[0]['date'];
            $teacher_noti->course_end_date = $course_date[$count_datetime]['date'];
            $teacher_noti->member_id = $course->member_id;
            $teacher_noti->member_email = $course->member_email;
            $teacher_noti->teacher_id = $course->member_id;
            $teacher_noti->teacher_fullname = $teacher_fullname;
            $teacher_noti->noti_course_type = $request->course_category;
            $teacher_noti->noti_type = 'invite_course_teacher';
            $teacher_noti->noti_status = '0';
            $teacher_noti->save();

            sendMemberNoti($course->member_id);
        }

        if($request->course_category=="Private"){
                //insert noti to student
                foreach ($request->course_student as $key => $value) {
                    if($key!="0"){
                    $member_id = Member::where('member_email', '=', $value)
                                    ->where('member_status', '=', '1')
                                    ->first();
                        if($member_id){
                            $student_noti = new MemberNotification();
                            $student_noti->course_id = $course_id->id;
                            $student_noti->course_name = $request->course_name;
                            $student_noti->course_datetime = $course_date;
                            $student_noti->course_start_date = $course_date[0]['date'];
                            $student_noti->course_end_date = $course_date[$count_datetime]['date'];
                            $student_noti->member_id = $member_id->id;
                            $student_noti->member_email = $value;
                            $student_noti->teacher_id = $course->member_id;
                            $student_noti->teacher_fullname = $teacher_fullname;
                            $student_noti->noti_type = 'invite_course_student';
                            $student_noti->noti_status = '0';
                            $student_noti->save();

                            sendMemberNoti($member_id->id);
                        }
                    }
            }

        }
        // Alert แก้ไขคอร์ส กับ สร้างคอร์สสำเร็จ
        if($request->id){
            return redirect()->route('courses.getIndex')->with('success','แก้ไขข้อมูลคอร์สเรียนเรียบร้อย');
      
        }


    }
    public function delete ($id) {
        $course = Course::find($id);
        $course->delete();

        return redirect()->route('courses.getIndex')->with('success','ลบข้อมูลคอร์สเรียนเรียบร้อย');

    }
    
    public function getSubject(Request $request) {

        $course = Course::where('_id', $request->course_id)
                    ->first();

        $members = Member::where('_id', $course->member_id)->first();
        $member_aptitude = $members->member_aptitude[$request->aptitude_id];

        $datas = array();
        $i = 0;
        foreach ($member_aptitude as $key => $value) {
            
            $subject = Subject::where('_id',$value)->first();

            // if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
            //     $datas[$i]['subject_id'] = $value;
            //     $datas[$i]['subject_name'] = $subject->subject_name_en;
            // }
            // else{
            //     $datas[$i]['subject_id'] = $value;
            //     $datas[$i]['subject_name'] = $subject->subject_name_th;
            // }
            $datas[$i]['subject_id'] = $value;
            $datas[$i]['subject_name'] = $subject->subject_name_th;
            $i++;
        }

        return $datas;
    }
}
