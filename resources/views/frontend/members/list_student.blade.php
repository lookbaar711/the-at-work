<?php 
    if((isset(Auth::guard('members')->user()->member_lang) && (Auth::guard('members')->user()->member_lang=='en')) || (session('lang')=='en')){
        App::setLocale('en');
    }
    else{
        App::setLocale('th'); 
    }
?>

		<table class="customers" border="0">
		  	<tr>
			    <th>#</th>
			    <th>@lang('frontend/members/title.student_course_register_date')</th>
			    <th>@lang('frontend/members/title.student_fullname')</th>
			    <th>@lang('frontend/members/title.student_email')</th>
			    <th>@lang('frontend/members/title.student_mobile_no')</th>
		  	</tr>

			@foreach($students as $i => $student)
			  	<tr>
				    <td>{{ ++$i }}</td>
				    <td>{{ date('d/m/Y', strtotime($student['student_date_regis'])) }}</td>
				    <td>{{ $student['student_fname']." ".$student['student_lname'] }}</td>
				    <td>{{ $student['student_email'] }}</td>
				    <td>{{ $student['student_tell'] }}</td>
			  	</tr>
			@endforeach
		</table>