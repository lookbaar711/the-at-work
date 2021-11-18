@extends('backend.layouts/default')

{{-- Web site Title --}}
@section('title')
    แก้ไขบัญชีธนาคาร
    @parent
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        แก้ไขบัญชีธนาคาร
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                @lang('Dashboard')
            </a>
        </li>
        <li>จัดการบัญชีธนาคาร</li>
        <li class="active">
            แก้ไขบัญชีธนาคาร
        </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="users-add" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        แก้ไขบัญชีธนาคาร
                    </h4>
                </div>
                <div class="panel-body">
                    {!! $errors->first('slug', '<span class="help-block">Another role with same slug exists, please choose another name</span> ') !!}
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="post" action="{{ route('banks.update', $bank->id) }}" enctype="multipart/form-data">
                        <!-- CSRF Token -->
                        <input name="_method" type="hidden" value="PUT">
                        {{ csrf_field() }}

                        {{-- <div class="form-group {{ $errors->
                            first('name', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                ธนาคาร
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="name" name="bank_type" class="form-control" placeholder="ชื่อบัญชี"
                                       value="{!! $bank->bank_type !!}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('name', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->
                            first('name', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                โลโก้ ธนาคาร
                            </label>
                            <div class="col-sm-2">
                                <img src="{{ asset('storage/bank_logo/'.$bank->bank_img) }}" style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                            <div class="col-sm-3">
                                <input type="file" id="name" name="bank_img" class="form-control" value="{!! $bank->bank_img !!}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('name', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div> --}}

                        <div class="form-group {{ $errors->
                            first('name', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                ชื่อธนาคาร
                                <span style="color: red; font-size: 15px;">* </span>
                            </label>
                            <div class="col-sm-5">
                                <select name="bank_id" id="bank_id" class="form-control" required>
                                  <option selected value="">เลือกธนาคาร</option>
                                      
                                  @foreach($bank_master as $index => $item)
                                    @if($bank->bank_id == $item->_id)
                                        <option value="{{ $item->_id }}" style="color:black;" selected>
                                    @else
                                        <option value="{{ $item->_id }}" style="color:black;">
                                    @endif
                                        {{$item->bank_name_th}}
                                    </option>
                                  @endforeach

                              </select>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('name', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->
                            first('name', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                ชื่อบัญชี
                                <span style="color: red; font-size: 15px;">* </span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="name" name="account_name" class="form-control" placeholder="ชื่อบัญชี" value="{!! $bank->account_name !!}" required>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('name', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->
                            first('name', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                หมายเลขบัญชี
                                <span style="color: red; font-size: 15px;">* </span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" name="bank_account_number" class="form-control" id="number" onkeypress="return isNumber(event)"    onkeyup="autoTab(this)" placeholder="หมายเลขบัญชี" value="{!! $bank->bank_account_number !!}" required>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('name', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('banks.index') }}">
                                    ยกเลิก
                                </a>
                                <button type="submit" class="btn btn-success">
                                    บันทึก
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>
<script type="text/javascript">
    function autoTab(obj){
    /* กำหนดรูปแบบข้อความโดยให้ _ แทนค่าอะไรก็ได้ แล้วตามด้วยเครื่องหมาย
    หรือสัญลักษณ์ที่ใช้แบ่ง เช่นกำหนดเป็น  รูปแบบเลขที่บัตรประชาชน
    4-2215-54125-6-12 ก็สามารถกำหนดเป็น  _-____-_____-_-__
    รูปแบบเบอร์โทรศัพท์ 08-4521-6521 กำหนดเป็น __-____-____
    หรือกำหนดเวลาเช่น 12:45:30 กำหนดเป็น __:__:__
    ตัวอย่างข้างล่างเป็นการกำหนดรูปแบบเลขบัตรประชาชน
    */
        var pattern=new String("___-_-_____-_"); // กำหนดรูปแบบในนี้
        var pattern_ex=new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้
        var returnText=new String("");
        var obj_l=obj.value.length;
        var obj_l2=obj_l-1;

        for(i=0;i<pattern.length;i++){
            if(obj_l2==i && pattern.charAt(i+1)==pattern_ex){
                returnText+=obj.value+pattern_ex;
                obj.value=returnText;
            }
        }
        if(obj_l>=pattern.length){
            obj.value=obj.value.substr(0,pattern.length);
        }
}

// จำกัดการป้อน
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
@stop
