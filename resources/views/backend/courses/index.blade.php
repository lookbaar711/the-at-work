@extends('backend.layouts/default')

@section('title')
จัดการหัวข้อประชุม
@parent
@stop

@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1 style="padding-left: 8px;">จัดการหัวข้อประชุม</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">จัดการหัวข้อประชุม</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        จัดการหัวข้อประชุม
                    </h4>
                </div>
                <div class="panel-body">
                        <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th style="width: 2px;">ลำดับ</th>
                                    <th style="width: 10px;">ชื่อการประชุม</th>
                                    <th style="width: 10px;">วัน/เวลา</th>
                                    <th style="width: 10px;">สถานะหัวข้อ</th>
                                    <th style="width: 10px;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($courses->count())
                                    @foreach ($courses as $index => $course)
                                   
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $course->course_name }}</td>

                                            <td>{!! date('d/m/Y', strtotime($course->course_date_start))."  ".substr($course->course_time_start,0,5)!!}</td>
                                       
                                            <td>                                            
                                            @if(date('Y-m-d H:i:s', strtotime($course->course_date_start." ".$course->course_time_start)) < date('Y-m-d H:i:s', strtotime('+10 minutes')))
                                                <p style="color:red;">&#9679; ปิดเข้าร่วม</p>
                                            @else                                       
                                                @if($course->course_status == 'close')  
                                                    <p style="color: #FC8600;">&#9679; กำลังจะเปิดเข้าร่วม</p>      
                                                @else($course->course_status > 'cancel') 
                                                    <p style="color: #3990F2;">&#9679; เปิดเข้าร่วม</p>
                                                @endif
                                            @endif
                                            </td>
                                            
                                            <td align="center">
                                                @if(date('Y-m-d H:i:s', strtotime($course->course_date_start." ".$course->course_time_start)) < date('Y-m-d H:i:s', strtotime('+10 minutes')))
                                                {{-- <button class="btn btn-secondary" disabled><i class="fa fa-pencil-square-o"></i>แก้ไข</button> --}}   
                                                <button class="btn btn-secondary" disabled><i class="fa fa-times"></i>ลบ</button>
                                                @else                                       
                                                    @if($course->course_status == 'close')  
                                                        {{-- <a href="{{ route('courses.getUpdate', $course->id) }}" class="btn btn-responsive button-alignment btn-success"><i class="fa fa-pencil-square-o"></i>แก้ไข</a> --}}
                                                        <a href="{{ route('courses.delete', $course->id) }}" class="btn btn-responsive button-alignment btn-danger" id="delete"><i class="fa fa-times"></i>ลบ</a>
                                                    @else($course->course_status > 'cancel') 
                                                       {{-- <button class="btn btn-secondary" disabled><i class="fa fa-pencil-square-o"></i>แก้ไข</button>    --}}
                                                       <button class="btn btn-secondary" disabled><i class="fa fa-times"></i>ลบ</button>
                                                    @endif
                                                @endif     
                                            </td>
                                        </tr>

                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                      
                </div>
            </div>
        </div>
    </div>    <!-- row-->
</section>


@stop

{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>
    <script>
        $(document).ready(function() {
                $('#table').DataTable({                   
                    // Definition of filter to display                  
                    filterDropDown: {                                       
                        columns: [
                            {
                                idx: 6
                            }
                        ],
                        bootstrap: true
                    }
                } );
            } );
    </script>  

@stop
