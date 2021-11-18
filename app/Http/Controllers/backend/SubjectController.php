<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\Subject;

use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    public function index(){
        $subject = Subject::all();
        return view('backend.subjects.subject-all',compact('subject'));
    }

    public function create(){
        return view('backend.subjects.subject-create');
    }

    public function store(Request $request){
        request()->validate([
            'subject_name_th' => 'required',
            'subject_name_en' => 'required',
        ]);
        $data = ([
            'subject_name_th' => $request['subject_name_th'],
            'subject_name_en' => $request['subject_name_en']
        ]);
        Subject::create($data);
        //return $subject;
        return redirect()->route('subjects.index')
                        ->with('success','เพิ่มรายวิชาเรียบร้อย.');
    }

    public function show(Subject $subject){
        //return $subject;
        return view('backend.subjects.subject-edit',compact('subject'));
    }

    public function update(Request $request, Subject $subject){
        //$subject = Subject::first();
        request()->validate([
            'subject_name_th' => 'required',
            'subject_name_en' => 'required',
        ]);
        
        $subject->subject_name_th = $request->subject_name_th;
        $subject->subject_name_en = $request->subject_name_en;
        $subject->save();

        return redirect()->route('subjects.index')
                        ->with('success','แก้ไขรายวิชาเรียบร้อย');
    }

    public function destroy(Subject $subject) {
        //return $subject;
        $subject->delete();
        
        return redirect()->route('subjects.index')
                        ->with('success','ลบรายวิชาเรียบร้อย');
    }
}
