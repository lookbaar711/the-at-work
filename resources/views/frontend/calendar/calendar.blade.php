@extends('frontend/default')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('css')
    <link href="{{ asset ('suksa/frontend/packages/core/main.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset ('suksa/frontend/packages/daygrid/main.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset ('suksa/frontend/packages/timegrid/main.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset ('suksa/frontend/packages/list/main.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/profile.css') !!}">
    
    <style>
        .page-item.active .page-link {
            background-color: #000 !important;
            border-color: #000 !important;
            color: #fff !important;
        }
        .page-link {
            color: #000;
        }
        .modal-lg {
            max-width: 650px;
        }
        td, th {
            white-space: nowrap;
        }
        .page-item {
            cursor: pointer;
        }
    </style>
@endsection

@php
    if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
        App::setLocale('en');
    }
    else{
        App::setLocale('th');
    }
@endphp

@section('content')
    <div class="container">
        <h2 class="pt-4">@lang('frontend/members/title.my_schedul')</h2>
        <hr>
        <div class="pb-4">
            <div id='calendar' class="pt-2"></div>
        </div>
        <div class="pt-4 pb-4">
            <h4 class="pb-2 course-coming-soon">@lang('frontend/members/title.schedule_coming_soo')</h4>
            <div id="pagination"></div>
        </div>
    </div>

   <!-- modal list student -->
   <div class="modal fade" id="modal_student" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('frontend/members/title.student_list')</h5>
                </div>

                <div class="modal-body p-3">
                    <div  style="overflow-x: auto;">
                        <table class="table table-striped" border="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('frontend/members/title.student_course_register_date')</th>
                                    <th>@lang('frontend/members/title.student_fullname')</th>
                                    <th>@lang('frontend/members/title.student_email')</th>
                                    <th>@lang('frontend/members/title.student_mobile_no')</th>
                                </tr>
                            </thead>
                            <tbody id="student">

                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-success" data-dismiss="modal">@lang('frontend/members/title.close_button')</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script src="{{ asset ('suksa/frontend/packages/core/main.js') }}"></script>
    <script src="{{ asset ('suksa/frontend/packages/interaction/main.js') }}"></script>
    <script src="{{ asset ('suksa/frontend/packages/daygrid/main.js') }}"></script>
    <script src="{{ asset ('suksa/frontend/packages/timegrid/main.js') }}"></script>
    <script src="{{ asset ('suksa/frontend/packages/list/main.js') }}"></script>
    <script src="/suksa/frontend/template/js/pagination-bt4.js"></script>
    <script>
        let students = [];
        const events = [];
        $.get(window.location.origin+"/getCourse", function( data ) {
            students = [...data];
            data.forEach((element, i) => {
                events.push({
                    title: element.course_name,
                    start: element.date+' '+element.time_start,
                    end: element.date+' '+element.time_end,
                });

                if (i+1 == data.length) {
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                    height: 'parent',
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    defaultView: 'dayGridMonth',
                    defaultDate: new Date(),
                    navLinks: true, // can click day/week names to navigate views
                    editable: true,
                    eventLimit: true, // allow "more" link when too many events
                    events: events
                    });
                    calendar.render();
                }
            });

            if(data.length == 0){
                $('.course-coming-soon').text('');

                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                height: 'parent',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                defaultView: 'dayGridMonth',
                defaultDate: new Date(),
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                //events: events
                });
                calendar.render();
            }
        });

        let data = {'page': 1};
        pagination(data, '/teacher/course', 'teacherCourse');

        async function search_page(page = 1) {
            let data = {
                'page': page,
            };

            await pagination(data, '/teacher/course', 'teacherCourse');
        }


        function showStudent(course_id) {
            STR = '';
            let result = students.find((student) => {
                return student.course_id == course_id;
            })
            let i = 1;
            for (const student of result.student) {
                STR += '<tr><td>'+ i++ +'</td><td>'+moment(student.student_date_regis).format('DD/MM/Y')+'</td><td>'+student.student_fname +" "+student.student_lname+'</td>';
                STR += '<td>'+student.student_email+'</td><td>'+student.student_tell+'</td><tr>'
            }
            $('#student').html(STR);
            $('#modal_student').modal('show');
        }
</script>
@endpush
