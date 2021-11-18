<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankMaster;
use Illuminate\Support\Str;

class BankController extends Controller
{
    public function index(){
    	$banks = Bank::where('bank_status','=','1')
                ->orderBy('created_at','desc')->get();

    	return view('backend.banks.bank-all',compact('banks'));
    }

    public function create(){
        $bank_master = BankMaster::where('bank_status','=','1')
                        ->orderBy('created_at','desc')->get();

    	return view('backend.banks.bank-create',compact('bank_master'));
    }

    public function store(Request $request){
    	request()->validate([
            'bank_id' => 'required',
            'account_name' => 'required',
            'bank_account_number' => 'required',
            //'bank_img' => 'required',
        ]);
        // $fielName =  Str::random(7).time().".".$request['bank_img']->getClientOriginalExtension();
        // $path = $request->bank_img->move(public_path("/storage/bank_logo"), $fielName);

        $bank_info = BankMaster::where('_id','=',$request['bank_id'])->first();
        $bank_name_th = $bank_info->bank_name_th;
        $bank_name_en = $bank_info->bank_name_en;
        $bank_code = $bank_info->bank_code;
        
        $data = ([
            'bank_id' => $request['bank_id'],
            'bank_name_th' => $bank_name_th,
            'bank_name_en' => $bank_name_en,
            'bank_code' => $bank_code,
            'account_name' => $request['account_name'],
            'bank_account_number' => $request['bank_account_number'],
            //'bank_img' => $fielName,
            'bank_status' => '1',
        ]);

        Bank::create($data);

		return redirect()->route('banks.index')
                        ->with('success','เพิ่มบัญชีธนาคารเรียบร้อย.');
    }

    public function destroy(Bank $bank){
    	$bank->bank_status = '0';
        $bank->save();
        return redirect()->route('banks.index')->with('success','ลบบัญชีธนาคารเรียบร้อย');
    }

    public function show(Bank $bank){
        $bank_master = BankMaster::where('bank_status','=','1')
                        ->orderBy('created_at','desc')->get();

        return view('backend.banks.bank-edit',compact('bank','bank_master'));
    }

    public function update(Request $request, Bank $bank){
    	request()->validate([
            'bank_id' => 'required',
            'account_name' => 'required',
            'bank_account_number' => 'required',
        ]);

        if(!is_null($request['bank_img'])){
            $fielName =  Str::random(7).time().".".$request['bank_img']->getClientOriginalExtension();
            $path = $request->bank_img->move(public_path("/storage/bank_logo"), $fielName);
            $bank->bank_img = $fielName;
        }

        $bank_info = BankMaster::where('_id','=',$request['bank_id'])->first();
        $bank_name_th = $bank_info->bank_name_th;
        $bank_name_en = $bank_info->bank_name_en;
        $bank_code = $bank_info->bank_code;
        
        $bank->bank_id = $request['bank_id'];
        $bank->bank_name_th = $bank_name_th;
        $bank->bank_name_en = $bank_name_en;
        $bank->bank_code = $bank_code;
        $bank->account_name = $request['account_name'];
        $bank->bank_account_number = $request['bank_account_number'];
        $bank->save();

		return redirect()->route('banks.index')
                        ->with('success','แก้ไขบัญชีธนาคารเรียบร้อย.');
    }
}
