@extends('frontend.default')
@section('css')
    <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/profile.css') !!}">
@stop
@section('content')  
<!-- Group learning -->
<section class="p-t-30 p-b-30">
    <div class="container">
        <div class="row">
          <div class="col-md-9">
              <label style="font-size: 40px; font-weight: bold;" >แก้ไขโปรไฟล์</label>
          </div>
          <div class="col-md-3">
            <label style="text-align: right;" ><a href="{{ url('members/profile/') }}">หน้าโปรไฟล์ / </a><label style="color: darkgray;">แก้ไขโปรไฟล์</label>
          </div>
        </div>
      </div>
</section>
<!-- Group learning -->
<section class="p-t-10 p-b-65">
<div class="container">
<div class="tab-content" id="myTabContent">
              <form class="box1">
                      <div class="form-row">
                          <label class="profile01 col-md->" style="font-size: 30px; font-weight: bold;">ข้อมูลส่วนตัว</label>
                          <div class="form-group col-12">
                             <label for="inputAddress">เลขบัตรประชาชน :</label>
                            <input type="text" class="form-control col-md-4" id="idcard" value="{{$members->member_idCard}}" disabled>
                        </div>

                        <div class="form-group col-md-4">
                          <label for="inputEmail4">อีเมล :</label>
                          <input type="email" class="form-control" id="inputEmail4" value="{{$members->member_email}}">
                        </div>

                        <div class="form-group col-md-2">
                          <label for="inputPassword4">เบอร์โทรศัพท์ :</label>
                          <input type="text" class="form-control" id="phone"  maxlength="10" value="{{$members->member_tell}}">
                        </div>
                        <div class="form-group col-md-2">
                              <label for="inputPassword4">Line ID :</label>
                              <input type="text" class="form-control" id="phone" value="{{$members->member_idLine}}">
                            </div>
                        </div>
                    
                  <div class="form-row">

                      <div class="form-group col-md-2">
                          <label for="inputAddress">คำนำหน้า:</label>
                          <select id="fname" class="form-control">
                              <option value="{{$members->member_sername}}" @if($members->member_sername=='นาย') selected @endif >นาย</option>
                              <option value="{{$members->member_sername}}" @if($members->member_sername=='นาง') selected @endif >นาง</option>
                              <option value="{{$members->member_sername}}" @if($members->member_sername=='นางสาว') selected @endif >นางสาว</option>
                          </select>
                      </div>

                      <div class="form-group col-md-2">
                      <label for="inputEmail4">ชื่อ :</label>
                      <input type="email" class="form-control" id="inputEmail4" value="{{$members->member_fname}}">
                      </div>

                      <div class="form-group col-md-2">
                      <label for="inputPassword4">นามสกุล :</label>
                      <input type="text" class="form-control" id="phone" value="{{$members->member_lname}}">
                      </div>
                      <div class="form-group col-md-2">
                          <label for="inputPassword4">ชื่อเล่น :</label>
                          <input type="text" class="form-control" id="phone" value="{{$members->member_nickname}}">
                          </div>
                  </div>

                  <div class="form-row">

                      <div class="form-group col-md-2">
                          <label for="inputAddress">วัน :</label>
                          <select id="fname" class="form-control">
                            @for ($i=1; $i<32; $i++)
                              <option value="{{sprintf( '%02d', $i )}}"
                              @if(substr($members->member_Bday,-2)==sprintf( '%02d', $i ))
                                selected
                              @endif
                              >{{sprintf( '%02d', $i )}}</option>
                            @endfor
                          </select>
                      </div>
                      <div class="form-group col-md-2">
                          <label for="inputAddress">เดือน : </label>
                          <select id="fname" class="form-control ">
                            @foreach ($month as $i =>  $item)
                              <option 
                              @if(substr($members->member_Bday, -5, -3)==sprintf( '%02d', ++$i ))
                              selected
                              @endif
                              >{{$item}}</option>
                            @endforeach
                          </select>
                      </div>
                      <div class="form-group col-md-2">
                          <label for="inputAddress">ปีเกิด :</label>
                          <select id="fname" class="form-control">
                            @for($i=1970; $i < 2019; $i++)
                              <option
                              @if(substr($members->member_Bday, 0, 4)==$i)
                              selected
                              @endif
                              >{{$i}}</option>
                            @endfor
                              </select>
                          </div>       
                  </div>
              <hr/><!--เส้นฟอร์ม1-->
              <div class="form-row">
                      <div class="col-sm-12">
                      <label class="profile01">ประวัติการศึกษา</label>
                     </div>
                    <div class="form-group col-md-2">                                  
                      <label><input type="checkbox" class="option-input checkbox" value=""
                        @if(!empty($members->member_education[0]))
                          checked
                        @endif
                        >&nbsp;</label>
                        <label>มัธยมศึกษา</label>
                    </div>
                    <div class="form-group col-md-4">                                 
                        <input class="form-control" 
                        @if(!empty($members->member_education[0][0]))
                          value="{{$members->member_education[0][0]}}"
                        @endif
                        >
                    </div>
                  </div>
                  <div class="form-row">                          

                      <div class="form-group col-md-2">                                  
                        <label><input type="checkbox" class="option-input checkbox" 
                          @if(!empty($members->member_education[1]))
                          checked
                          @endif
                          >&nbsp;</label>
                          <label>ปริญญาตรี</label>
                      </div>

                      <div class="form-group col-md-2">
                                <input class="form-control" placeholder="กรอกชื่อมหาวิทยาลัย..."
                                @if(!empty($members->member_education[1][0]))
                                  value="{{$members->member_education[1][0]}}"
                                @endif
                                >
                      </div>
                      <div class="form-group col-md-2">
                          <input class="form-control"  placeholder="กรอกชื่อคณะ/สาขาวิชา..."
                          @if(!empty($members->member_education[1][1]))
                            value="{{$members->member_education[1][1]}}"
                          @endif
                          >
                          </div>
                    </div>
             
                     <div class="form-row">                          

                    <div class="form-group col-md-2">                                  
                      <label><input type="checkbox" class="option-input checkbox"
                        @if(!empty($members->member_education[2]))
                          checked
                        @endif
                        >&nbsp;</label>
                        <label>ปริญญาโท</label>
                    </div>

                    <div class="form-group col-md-2">                                 
                        <input class="form-control" placeholder="กรอกชื่อมหาวิทยาลัย..."
                        @if(!empty($members->member_education[2][0]))
                          value="{{$members->member_education[2][0]}}"
                        @endif
                        >
                    </div>
                    <div class="form-group col-md-2">
                        <input class="form-control"  placeholder="กรอกชื่อคณะ/สาขาวิชา..."
                        @if(!empty($members->member_education[2][1]))
                          value="{{$members->member_education[2][1]}}"
                        @endif
                        >
                        </div>
                  </div>
     
                     <div class="form-row">
              

                    <div class="form-group col-md-2">                                  
                      <label><input type="checkbox"class="option-input checkbox" value="" 
                        @if(!empty($members->member_education[3]))
                          checked
                        @endif></label>
                        <label>ปริญญาเอก</label>
                    </div>

                    <div class="form-group col-md-2">                                 
                        <input class="form-control" placeholder="กรอกชื่อมหาวิทยาลัย..."
                        @if(!empty($members->member_education[3][0]))
                          value="{{$members->member_education[3][0]}}"
                        @endif
                        >
                    </div>
                    <div class="form-group col-md-2">
                        <input class="form-control" placeholder="กรอกชื่อคณะ/สาขาวิชา..."
                        @if(!empty($members->member_education[3][1]))
                          value="{{$members->member_education[3][1]}}"
                        @endif
                        >
                        </div>
                  </div>
            
                  <hr/><!--เส้นฟอร์ม2-->

                 
                  
               <label class="profile01">ประวัติการทำงาน</label>
                      <div class="form-group ">
                              <div id="myRepeatingFields3">
                                  <div class="entry form-group  ">
                                      @if(!empty($members->member_exp))
                                         @foreach ($members->member_exp as $item)
                                              <div class="form-row">
                                                  <div class="form-group col-md-4">   
                                                      <label>สถานที่ทำงาน:</label>
                                                      <input class="form-control" name="member_HJPl[]" type="text" value="{{$item[0]}}" />  
                                                  </div>
                                                  <div class="form-group col-md-4">
                                                          <label>ตำแหน่ง:</label>        
                                                      <input class="form-control" name="member_HJPo[]" type="text" value="{{$item[1]}}" />
                                                  </div>
                                                  <div class="form-group col-md-3">
                                                      <label >ประสบการณ์ทำงาน:</label>
                                                      <input class="form-control" name="member_HJExp[]" type="text" value="{{$item[2]}}" />
                                                  </div>
                                                      <div class="form-group col-md-1">
                                                  <span class="input-group-btn">                   
                                              <button type="button" class="btn btn-dark btn-md btn-add3" style="margin-top: 30px;" >เพิ่ม</button>
                                          </span>
                                      </div>
                                  </div>
                                  @endforeach
                                  @endif
                          </div>
                      </div>
                  </div>
                  <hr/><!--เส้นฟอร์ม3-->
                  <label class="profile01">ความสำเร็จด้านการสอน</label>
                      <div class="form-group ">
                              <div id="myRepeatingFields4">
                                  <div class="entry form-group  ">
                                    @if(!empty($members->member_cong))
                                      @foreach ($members->member_cong as $item)
                                        <div class="form-row">
                                            <div class="form-group col-md-11">              
                                                <input class="form-control" name="member_HJPl[]" type="text" value="{{$item}}" />
                                            </div>
                                            <div class="form-group col-md-1">
                                                <span class="input-group-btn">
                                            <button type="button" class="btn btn-dark btn-md btn-add4"  >เพิ่ม</button>
                                            </span>
                                            </div>
                                        </div>
                                      @endforeach
                                  @endif
                          </div>
                      </div>
                  </div>
                  <hr/><!--เส้นฟอร์ม4-->
                  <div class="form-row">
                          <label class="profile01">ความถนัด</label>
                          <div class="form-group col-md-12">   
                          <input type="checkbox" name="interE" value="prathom1" class="option-input checkbox"
                          @if(!empty($members->subject_detail['ประถมศึกษาตอนต้น']))
                            checked 
                          @endif
                            data-toggle="collapse" data-target="#inter02"
                          >&nbsp;<object>กลุ่มการศึกษาระดับ ประถมตอนต้น</object></input>       
                          </div>
                          <div id="inter02" class="collapse
                          @if(!empty($members->subject_detail['ประถมศึกษาตอนต้น']))
                            show 
                          @endif
                          "> 
                          <div class="button-group-pills text-left" data-toggle="buttons">
                              @foreach($aptitude['subject_detail']['ประถมศึกษาตอนต้น'] as $item)
                                <button style="margin-bottom: 5px;"  class="btn btn-default
                                @if(!empty($members->subject_detail['ประถมศึกษาตอนต้น']))
                                @foreach($members->subject_detail['ประถมศึกษาตอนต้น'] as $value)
                                @if($item==$value)
                                  active
                                @endif
                                @endforeach
                                @endif
                                ">
                                    <input type="checkbox" name="options" value="{{$item->subject_name}}" 
                                    @if(!empty($members->subject_detail['ประถมศึกษาตอนต้น']))
                                    @if($item==$value)
                                      checked
                                    @endif
                                    @endif
                                    >
                                    <div>{{$item->subject_name}}</div>
                                </button>
                              @endforeach
                                </div>
                          </div>
                      </div>

                      <div class="form-row">
                          <div class="form-group col-md-12">   
                          <input type="checkbox" name="interE" value="prathom1" class="option-input checkbox"
                          @if(!empty($members->subject_detail['ประถมศึกษาตอนปลาย']))
                            checked 
                            @endif
                           data-toggle="collapse" data-target="#inter03"
                           
                          > &nbsp;<object>กลุ่มการศึกษาระดับ ประถมตอนปลาย</object></input>       
                          </div>
                          <div id="inter03" class="collapse
                          @if(!empty($members->subject_detail['ประถมศึกษาตอนปลาย']))
                            show 
                            @endif
                          "> 
                          <div class="button-group-pills text-left" data-toggle="buttons">
                              @foreach($aptitude['subject_detail']['ประถมศึกษาตอนปลาย'] as $item)
                                <button style="margin-bottom: 5px;"  class="btn btn-default
                                @if(!empty($members->subject_detail['ประถมศึกษาตอนปลาย']))
                                @foreach($members->subject_detail['ประถมศึกษาตอนปลาย'] as $value)
                                @if($item==$value)
                                  active
                                @endif
                                @endforeach
                                @endif
                                ">
                                    <input type="checkbox" name="options" value="{{$item->subject_name}}" 
                                    @if(!empty($members->subject_detail['ประถมศึกษาตอนปลาย']))
                                    @if($item==$value)
                                      checked
                                    @endif
                                    @endif
                                    >
                                    <div>{{$item->subject_name}}</div>
                                </button>
                              @endforeach
                                </div>
                          </div>
                      </div>


                      <div class="form-row">
                          <div class="form-group col-md-12">   
                          <input type="checkbox" name="interE" value="prathom1" class="option-input checkbox"
                          @if(!empty($members->subject_detail['มัธยมศึกษาตอนต้น']))
                            checked 
                            @endif
                           data-toggle="collapse" data-target="#inter04"
                           
                          > &nbsp;<object>กลุ่มการศึกษาระดับ มัธยมตอนต้น</object></input>       
                          </div>
                          <div id="inter04" class="collapse
                          @if(!empty($members->subject_detail['มัธยมศึกษาตอนต้น']))
                            show 
                            @endif
                          "> 
                          <div class="button-group-pills text-left" data-toggle="buttons">
                              @foreach($aptitude['subject_detail']['มัธยมศึกษาตอนต้น'] as $item)
                                <button style="margin-bottom: 5px;"  class="btn btn-default
                                @if(!empty($members->subject_detail['มัธยมศึกษาตอนต้น']))
                                @foreach($members->subject_detail['มัธยมศึกษาตอนต้น'] as $value)
                                @if($item==$value)
                                  active
                                @endif
                                @endforeach
                                @endif
                                ">
                                    <input type="checkbox" name="options" value="{{$item->subject_name}}" 
                                    @if(!empty($members->subject_detail['มัธยมศึกษาตอนต้น']))
                                    @if($item==$value)
                                      checked
                                    @endif
                                    @endif
                                    >
                                    <div>{{$item->subject_name}}</div>
                                </button>
                              @endforeach
                                </div>
                          </div>
                      </div>

                      <div class="form-row">
                          <div class="form-group col-md-12">   
                          <input type="checkbox" name="interE" value="prathom1" class="option-input checkbox"
                          @if(!empty($members->subject_detail['มัธยมศึกษาตอนปลาย']))
                            checked 
                            @endif
                           data-toggle="collapse" data-target="#inter05"
                           
                          > &nbsp;<object>กลุ่มการศึกษาระดับ มัธยมตอนปลาย</object></input>       
                          </div>
                          <div id="inter05" class="collapse
                          @if(!empty($members->subject_detail['มัธยมศึกษาตอนปลาย']))
                            show 
                            @endif
                          "> 
                          <div class="button-group-pills text-left" data-toggle="buttons">
                              @foreach($aptitude['subject_detail']['มัธยมศึกษาตอนปลาย'] as $item)
                                <button style="margin-bottom: 5px;" class="btn btn-default
                                @if(!empty($members->subject_detail['มัธยมศึกษาตอนปลาย']))
                                @foreach($members->subject_detail['มัธยมศึกษาตอนปลาย'] as $value)
                                @if($item==$value)
                                  active
                                @endif
                                @endforeach
                                @endif
                                ">
                                    <input type="checkbox" name="options" value="{{$item->subject_name}}"
                                    @if(!empty($members->subject_detail['มัธยมศึกษาตอนปลาย'])) 
                                    @if($item==$value)
                                      checked
                                    @endif
                                    @endif
                                    >
                                    <div>{{$item->subject_name}}</div>
                                </button>
                              @endforeach
                                </div>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-12">   
                          <input type="checkbox" name="interE" value="prathom1" class="option-input checkbox"
                          @if(!empty($members->subject_detail['อุดมศึกษา']))
                            checked 
                            @endif
                           data-toggle="collapse" data-target="#inter06"
                           
                          > &nbsp;<object>กลุ่มการศึกษาอิ่นๆ อุดมศึกษา</object></input>       
                          </div>
                          <div id="inter06" class="collapse
                          @if(!empty($members->subject_detail['อุดมศึกษา']))
                            show 
                            @endif
                          "> 
                          <div class="button-group-pills text-left" data-toggle="buttons">
                              @foreach($aptitude['subject_detail']['อุดมศึกษา'] as $item)
                                <button style="margin-bottom: 5px;"  class="btn btn-default
                                @if(!empty($members->subject_detail['อุดมศึกษา']))
                                @foreach($members->subject_detail['อุดมศึกษา'] as $value)
                                @if($item==$value)
                                  active
                                @endif
                                @endforeach
                                @endif
                                ">
                                    <input type="checkbox" name="options" value="{{$item->subject_name}}" 
                                    @if(!empty($members->subject_detail['อุดมศึกษา']))
                                    @if($item==$value)
                                      checked
                                    @endif
                                    @endif
                                    >
                                    <div>{{$item->subject_name}}</div>
                                </button>
                              @endforeach
                                </div>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-12">   
                          <input type="checkbox" name="interE" value="prathom1" class="option-input checkbox"
                          @if(!empty($members->subject_detail['ภาษา']))
                            checked 
                            @endif
                           data-toggle="collapse" data-target="#inter07"
                           
                          > &nbsp;<object>กลุ่มการศึกษาอื่นๆ ภาษา</object></input>       
                          </div>
                          <div id="inter07" class="collapse
                          @if(!empty($members->subject_detail['ภาษา']))
                            show 
                            @endif
                          "> 
                          <div class="button-group-pills text-left" data-toggle="buttons">
                              @foreach($aptitude['subject_detail']['ภาษา'] as $item)
                                <button style="margin-bottom: 5px;"  class="btn btn-default
                                @if(!empty($members->subject_detail['ภาษา']))
                                @foreach($members->subject_detail['ภาษา'] as $value)
                                @if($item==$value)
                                  active
                                @endif
                                @endforeach
                                @endif
                                ">
                                    <input type="checkbox" name="options" value="{{$item->subject_name}}" 
                                    @if(!empty($members->subject_detail['ภาษา']))
                                    @if($item==$value)
                                      checked
                                    @endif
                                    @endif
                                    >
                                    <div>{{$item->subject_name}}</div>
                                </button>
                              @endforeach
                                </div>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-12">   
                          <input type="checkbox" name="interE" value="prathom1" class="option-input checkbox"
                          @if(!empty($members->subject_detail['อินเตอร์']))
                            checked 
                            @endif
                           data-toggle="collapse" data-target="#inter08"
                           
                          > &nbsp;<object>กลุ่มการศึกษาอื่นๆ อินเตอร์</object></input>       
                          </div>
                          <div id="inter08" class="collapse
                          @if(!empty($members->subject_detail['อินเตอร์']))
                            show 
                            @endif
                          "> 
                          <div class="button-group-pills text-left" data-toggle="buttons">
                              @foreach($aptitude['subject_detail']['อินเตอร์'] as $item)
                                <button style="margin-bottom: 5px;"  class="btn btn-default
                                @if(!empty($members->subject_detail['อินเตอร์']))
                                @foreach($members->subject_detail['อินเตอร์'] as $value)
                                @if($item==$value)
                                  active
                                @endif
                                @endforeach
                                @endif
                                ">
                                    <input type="checkbox" name="options" value="{{$item->subject_name}}" 
                                    @if(!empty($members->subject_detail['อินเตอร์']))
                                    @if($item==$value)
                                      checked
                                    @endif
                                    @endif
                                    >
                                    <div>{{$item->subject_name}}</div>
                                </button>
                              @endforeach
                                </div>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-12">   
                          <input type="checkbox" name="interE" value="prathom1" class="option-input checkbox"
                          @if(!empty($members->subject_detail['แอดมิสชั่น']))
                            checked 
                            @endif
                           data-toggle="collapse" data-target="#inter09"
                           
                          > &nbsp;<object>กลุ่มการศึกษาอื่นๆ Admission</object></input>       
                          </div>
                          <div id="inter09" class="collapse
                          @if(!empty($members->subject_detail['แอดมิสชั่น']))
                            show 
                            @endif
                          "> 
                          <div  class="button-group-pills text-left" data-toggle="buttons">
                              @foreach($aptitude['subject_detail']['Admission'] as $item)
                                <button style="margin-bottom: 5px;" class="btn btn-default
                                @if(!empty($members->subject_detail['แอดมิสชั่น']))
                                @foreach($members->subject_detail['แอดมิสชั่น'] as $value)
                                @if($item==$value)
                                  active
                                @endif
                                @endforeach
                                @endif
                                ">
                                    <input type="checkbox" name="options" value="{{$item->subject_name}}" 
                                    @if(!empty($members->subject_detail['แอดมิสชั่น']))
                                    @if($item==$value)
                                      checked
                                    @endif
                                    @endif
                                    >
                                    <div>{{$item->subject_name}}</div>
                                </button>
                              @endforeach
                                </div>
                          </div>
                      </div>

                              <hr/><!--เส้นฟอร์ม4-->



                              <label class="profile01">แนบไฟล์เอกสาร</label>
                              <div class="col-sm-6 col-sm-offset-1">
                                  <p class="oxide456" style="text-align: left;">แนบไฟล์บัตร ประชาชน:</p>
                                      <div class="input-group col-sm-12">
                                          <div class="form-group label-floating">
                                            
                                            <!-- ---------------------------------------------------------------------- -->
                                        
                                          
                                            <div class="input-group mb-12 ">                                                          
                                              
                                                  <div class="row files" id="files1">
                                                    
                                                      <span  class="inputfiles-img ">
                                                          <i class="fa fa-upload" aria-hidden="true"></i> Upload file <input  class="inputfiles-img" type="file" name="files1" id="inputGroupFile01" multiple  />
                                                      </span>
                                                      <br />
                                                      @if(!empty($members->member_file['บัตรประชาชน']))
                                                      @foreach ($members->member_file['บัตรประชาชน'] as $item)
                                                        <p class="col-12"><a href="{{ URL::asset('/storage/fileUpload/'.$item) }}" target="_blank" style="color:black;">{{$item}}</a></p>
                                                      @endforeach
                                                      @endif
                                                      <label class="fileList col-12"  for="inputGroupFile01"></label>
                                                  </div>
      
                                              </div>
      
                                            
                                             <!-- ---------------------------------------------------------------------- -->
                                          </div>
                                      </div>
                                  </div>


                                  <hr>

                                  
                              <div class="col-sm-6 col-sm-offset-1">
                                  <p class="oxide456" style="text-align: left;">แนบไฟล์บัตร สำเราการศึกษา:</p>
                                      <div class="input-group col-sm-12">
                                          <div class="form-group label-floating">
                                          
                                          <!-- ---------------------------------------------------------------------- -->
                                      
                                         
                                          <div class="input-group mb-3 ">
                                                  <div class="custom-file"  align="center"></div>
                                                  
                                                  <div class="row files" id="files2">
                                                    
                                                    <span  class="inputfiles-img ">
                                                        <i class="fa fa-upload" aria-hidden="true"></i> Upload file <input  class="inputfiles-img" type="file" name="files1" id="inputGroupFile02" multiple  />
                                                    </span>
                                                    <br />
                                                    @if(!empty($members->member_file['สำเนาศึกษา']))
                                                    @foreach ($members->member_file['สำเนาศึกษา'] as $item)
                                                      <p class="col-12"><a href="#">{{$item}}</a></p>
                                                    @endforeach
                                                    @endif
                                                    <label class="fileList col-10"  for="inputGroupFile02"></label>
                                                </div>

                                              </div>
      
                                          
                                          <!-- ---------------------------------------------------------------------- -->
                                          </div>
                                      </div>
                                  </div>

                              <hr>
                                      
                                  <div class="col-sm-6 col-sm-offset-1">
                                      <p class="oxide456" style="text-align: left;">แนบไฟล์บัตร ใบผลการศึกษา:</p>
                                          <div class="input-group col-sm-12">
                                              <div class="form-group label-floating">
                                              
                                              <!-- ---------------------------------------------------------------------- -->
                                          
                                           
                                              <div class="input-group mb-3 ">
                                                      <div class="custom-file"  align="center"></div>
                                                      
                                                      <div class="row files" id="files3">
                                                    
                                                        <span  class="inputfiles-img ">
                                                            <i class="fa fa-upload" aria-hidden="true"></i> Upload file <input  class="inputfiles-img" type="file" name="files1" id="inputGroupFile03" multiple  />
                                                        </span>
                                                        <br />
                                                        @if(!empty($members->member_file['ใบผลการเรียน']))
                                                        @foreach ($members->member_file['ใบผลการเรียน'] as $item)
                                                          <p class="col-12"><a href="#">{{$item}}</a></p>
                                                        @endforeach
                                                        @endif
                                                        <label class="fileList col-10"  for="inputGroupFile03"></label>
                                                    </div>
                                                              
                                                  </div>
          
                                              
                                              <!-- ---------------------------------------------------------------------- -->
                                              </div>
                                          </div>
                                      </div>
                  
                               <hr>

                              
                          <div class="col-sm-6 col-sm-offset-1">
                              <p class="oxide456" style="text-align: left;">แนบไฟล์บัตร วุฒิบัตรอื่นๆ:</p>
                                  <div class="input-group col-sm-12">
                                      <div class="form-group label-floating">
                                      
                                      <!-- ---------------------------------------------------------------------- -->
                                  
                                    
                                      <div class="input-group">

                                              <div class="row files" id="files4">
                                                    
                                                <span  class="inputfiles-img ">
                                                    <i class="fa fa-upload" aria-hidden="true"></i> Upload file <input  class="inputfiles-img" type="file" name="files1" id="inputGroupFile04" multiple  />
                                                </span>
                                                <br />
                                                @if(!empty($members->member_file['วุฒิบัตรอื่นๆ']))
                                                @foreach ($members->member_file['วุฒิบัตรอื่นๆ'] as $item)
                                                  <p class="col-12"><a href="{{ URL::asset('/storage/fileUpload/'.$item) }}">{{$item}}</a></p>
                                                @endforeach
                                                @endif
                                                <label class="fileList col-10 " for="inputGroupFile04" ></label>
                                            </div>
  
                                          </div>

                                      <!-- ---------------------------------------------------------------------- -->
                                      </div>
                                  </div>
                              </div>
                  
                            <hr>


               </form>

                 <div class="col-md-12">
                   
                  <div class="container">
                    <div class="row"> 
                      <div class="col-sm">
                      
                      </div>
                      <div class="col-sm">
                          <label class="flex-c-m size2 bo-rad-23 s-text3 bgwhite hov1 trans-0-5 col-12"><object class="colorz">บันทึกข้อมูล</object></label>
                      </div>
                      <div class="col-sm">
                        
                      </div>
                    </div>
                  </div>
                   
      
                  
                 </div>
                        
                       
         

      </div>




       </form>
 
      </div>
    </div>

</section>

<!-- Teachers -->
<section class="blog p-t-30 p-b-65" style="background-image: url(suksa/frontend/template/images/banner005.jpg); background-size: cover; width: 100%;">
<!-- <section id="reviews" class="reviews"> -->
<div class="container">

</div>
</section>



<!-- Banner -->
<section class="blog p-t-10">

</section>
@stop