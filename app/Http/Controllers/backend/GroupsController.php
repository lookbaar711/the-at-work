<?php 

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\Aptitude;
use App\Models\Subject;

use App\Http\Controllers\Controller;

class GroupsController extends Controller
{
    /**
     * Show a list of all the groups.
     *
     * @return View
     */
    public function index()
    {
        $aptitudes = Aptitude::all();
        // Show the page
        foreach($aptitudes as $i => $item){
            $subject = Subject::whereIn('subject_id', $aptitudes[$i]->aptitude_subject)->get();
            $aptitudes[$i]['subject_name'] = $subject;
        }
        
        //return $aptitudes[0]->subject_name;
        return view('backend.groups.group-all', compact('aptitudes'));
    }

    public function show($id)
    {
        $aptitudes = Aptitude::where('_id', $id)->first();
        $subjects = Subject::where('is_master','=','1')->get();
        //return $aptitudes->aptitude_subject;
        return view('backend.groups.group-edit', compact('aptitudes','subjects'));
    }
    /**
     * Group create.
     *
     * @return View
     */
    public function create()
    {
        $subjects = Subject::where('is_master','=','1')->get();
        // Show the page
        return view ('backend.groups.group-create', compact('subjects'));
    }

    /**
     * Group create form processing.
     *
     * @return Redirect
     */
    public function store(Request $request)
    {   
        foreach($request['aptitude_subject'] as $value){
            $aptitude_subject[] = $value;
        }
        
        $data = ([
            'aptitude_name_th' => $request['aptitude_name_th'],
            'aptitude_name_en' => $request['aptitude_name_en'],
            'aptitude_subject' => $aptitude_subject,
        ]);
        Aptitude::create($data);
            
        return redirect()->route('groups.index')
                        ->with('success','บันทึกกลุ่มความถนัดเรียบร้อย.');
    }

    public function update(Request $request, Aptitude $aptitude, $id){
        $aptitude = Aptitude::where('_id', $id)->first();
        foreach($request['aptitude_subject'] as $value){
            $aptitude_subject[] = $value;
        }
        $data = ([
            'aptitude_name_th' => $request['aptitude_name_th'],
            'aptitude_name_en' => $request['aptitude_name_en'],
            'aptitude_subject' => $aptitude_subject
        ]);
        //return $aptitude;
        $aptitude->update($data);
        return redirect()->route('groups.index')
                        ->with('success','แก้ไขกลุ่มความถนัดเรียบร้อย.');
    }
    
    public function destroy(Request $request) {
        $aptitude = Aptitude::where('_id', $request->id)->first();
        //return $aptitude;
        $aptitude->delete();
        
        return redirect()->route('groups.index')
                        ->with('success','ลบรายวิชาเรียบร้อย');
    }
    public function detail(Aptitude $aptitude){
        //dd($aptitude);
        foreach ($aptitude->aptitude_subject as $key => $value) {
        $subjects = Subject::where('_id', '=', $value)->first();
        if($subjects){
            $detail[] = $subjects->subject_name_th;
        }
        }
        if(isset($detail)){
            $aptitude->detail = $detail;
        }else{
            $aptitude->detail = [];
        }
        return view('backend.groups.group-detail', compact('aptitude'));
        return $aptitude;
        }

}
