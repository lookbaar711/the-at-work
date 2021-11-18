<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Str;

class EventsController extends Controller
{
    public function index(){
    	$events = Event::where('event_status','=','1')
                ->orderBy('created_at','desc')->get();

    	return view('backend.events.index',compact('events'));
    }

    public function create(){
    	return view('backend.events.create');
    }

    public function store(Request $request){
    	request()->validate([
            'event_name' => 'required',
            'event_start_date' => 'required',
            'event_end_date' => 'required',
        ]);

        $start_date = explode("/",$request['event_start_date']);
        $event_start_date = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];

        $end_date = explode("/",$request['event_end_date']);
        $event_end_date = $end_date[2].'-'.$end_date[1].'-'.$end_date[0];

        $data = ([
            'event_name' => $request['event_name'],
            'event_detail' => $request['event_detail'],
            'event_location' => $request['event_location'],
            'event_start_date' => $event_start_date,
            'event_end_date' => $event_end_date,
            'event_status' => '1',
        ]);

        Event::create($data);

		return redirect()->route('events.index')
                        ->with('success','เพิ่มข้อมูลอีเว้นส์เรียบร้อย');
    }

    public function destroy(Event $event){
    	$event->event_status = '0';
        $event->save();
        return redirect()->route('events.index')->with('success','ลบข้อมูลอีเว้นส์เรียบร้อย');
    }

    public function edit(Event $event){
        return view('backend.events.edit',compact('event'));
    }

    public function update(Request $request, Event $event){
    	request()->validate([
            'event_name' => 'required',
            'event_start_date' => 'required',
            'event_end_date' => 'required',
        ]);

        $start_date = explode("/",$request['event_start_date']);
        $event_start_date = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];

        $end_date = explode("/",$request['event_end_date']);
        $event_end_date = $end_date[2].'-'.$end_date[1].'-'.$end_date[0];
        
        $event->event_name = $request['event_name'];
        $event->event_detail = $request['event_detail'];
        $event->event_location = $request['event_location'];
        $event->event_start_date = $event_start_date;
        $event->event_end_date = $event_end_date;
        $event->save();

		return redirect()->route('events.index')
                        ->with('success','แก้ไขข้อมูลอีเว้นส์เรียบร้อย.');
    }
}
