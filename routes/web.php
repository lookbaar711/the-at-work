<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//-------------- test view send email
Route::get('/email/send_email_forgot_password', function () {
    return view('frontend/send_email_forgot_password');
});

use App\Events\SendNotiFrontend;
use App\Events\SendNotiBackend;

Route::get('/clear', function() {
    return view('frontend.clear');
});
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return redirect('/clear')->with('success', 'Routes cache cleared');
});
//Clear config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return 'Config cache cleared';
});

// Clear application cache:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return redirect('/clear')->with('success', 'Application cache cleared');
});

// Clear view cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return redirect('/clear')->with('success', 'View cache cleared');
});

Route::get('/info', function () {
    return response()->json(phpinfo());
});

Route::get('/languageTH', 'frontend\AuthController@setLangTH');
Route::get('/languageEN', 'frontend\AuthController@setLangEN');

//Frontend index
Route::get('/', 'MainController@getFrontend');

//Frontend after login
Route::group(['namespace'=>'frontend','middleware' => ['frontend']], function () {

    Route::post('/imgprofile', 'MemberController@imgprofile');
    Route::get('logout', 'AuthController@getLogout');
    Route::get('/changeaccount', 'MemberController@changeaccount');

    Route::get('download_student_doc', 'MemberController@downloadStudentDoc');
    Route::get('download_teacher_doc', 'MemberController@downloadTeacherDoc');



    # Member Management
    Route::group([ 'prefix' => 'members'], function () {
        ////Route::get('create', 'MemberController@create')->name('members.create');

        Route::get('all', 'MemberController@all');
        Route::post('/all/search', 'MemberController@search')->name('all.search');

        //Route::get('/all/fetch_data', 'MemberController@fetch_data')->name('all.fetch_data');
        Route::post('/all/fetch_data', 'MemberController@fetch_data')->name('all.fetch_data');

        Route::get('profile', 'MemberController@profile')->name('members.profile');
        Route::get('edit', 'MemberController@edit')->name('members.edit');
        Route::get('detail/{id}', 'MemberController@detail')->name('members.detail');
        Route::post('members_course', 'MemberController@member_course')->name('members.member_course');
        Route::get('updatedata/checkEmail', 'MemberController@checkEmail');
        Route::get('checkEmail', 'MemberController@checkEmail');
        Route::get('get_email_student', 'MemberController@get_email_student');
        Route::post('/upFile', 'MemberController@upFile');
        Route::get('imgprofile', 'MemberController@imgprofilereload')->name('members.imgprofile');
        ////Route::get('updatedata/{members}', 'MemberController@updatedata')->name('members.updatedata');
        Route::post('list_student', 'MemberController@list_student');
        Route::get('student_status/{course_id}', 'MemberController@student_status');
        Route::get('/active_course', function () {
            return redirect('members/profile')->with('active', 'course');
        });

        Route::get('/check_password_member/password_member/{pass}', 'MemberController@check_password');
        Route::post('update_password_member', 'MemberController@update_password_member');


    });
    Route::resource('members', 'MemberController');

    # User Management
    Route::group([ 'prefix' => 'users'], function () {
        ////Route::get('create', 'UserController@create')->name('users.create');
        ////Route::post('store', 'UserController@store')->name('users.store');
        Route::get('checkEmail', 'MemberController@checkEmail');
        Route::get('imgprofile', 'UserController@imgprofile')->name('users.imgprofile');
        Route::get('profile', 'UserController@profile')->name('users.profile');
        Route::get('/active_course', function () {
            return redirect('users/profile')->with('active', 'course');
        });
    });

    Route::get('calendar', 'CalendarController@index');
    Route::post('calendar/page/{name?}', 'CalendarController@show');
    Route::get('getCourse', 'CalendarController@schedule');
    Route::post('teacher/course', 'CalendarController@getTeacherCourse');

    Route::resource('users', 'UserController');
    Route::post('/users/update_profile', 'UserController@update');
    //teacher
    Route::group([ 'prefix' => 'teacher'], function () {
        Route::get('/', 'TeacherController@index');
        Route::post('/searach', 'TeacherController@getTeacher');
        Route::post('/searach/course', 'TeacherController@teacherCourse');

    });
    # Course Management
    // Route::get('getsubject/{id}', 'CourseController@subject');
    // Route::get('getSubject/{id}', 'CourseController@getSubject');

    Route::group([ 'prefix' => 'courses'], function () {
        Route::get('all', 'CourseController@all')->name('courses.all');

        // paginate
        Route::post('/all/page_course_free', 'CourseController@page_course_free')->name('all.page_course_free');

        // search
        Route::post('/all/actionCourseFree', 'CourseController@actionCourseFree')->name('all.actionCourseFree');
        Route::post('/all/actionCourseNotFree', 'CourseController@actionCourseNotFree')->name('all.actionCourseNotFree');

        Route::get('getsubject/{id}', 'CourseController@subject')->name('courses.subject');
        Route::get('{id}/edit', 'CourseController@edit');//แก้ไข
        Route::put('course_edit', 'CourseController@store');//แก้ไขคอร์ส
        Route::get('opencourse/{course}', 'CourseController@opencourse')->name('courses.opencourse');
        Route::get('status_create/{status}', 'CourseController@status_create')->name('courses.status_create');

        Route::get('/', 'CourseController@getIndex')->name('courses.getIndex');

        Route::get('/update/{id}', 'CourseController@getUpdate')->name('courses.getUpdate');

        Route::post('/update/{id}', 'CourseController@postUpdate')->name('courses.postUpdate');

        Route::post('getSubject', 'CourseController@getSubject')->name('courses.getSubject');

        Route::get('delete/{id}', 'CourseController@delete')->name('courses.delete');

    });
    Route::post('/get_data/Course_coursetFree', 'CourseController@search_coursetFree');
    Route::post('/get/Course_coursetFree', 'CourseController@search_coursetFree');

    Route::post('/get_data/Course_course_not_free', 'CourseController@search_course_not_free');
    Route::post('/get/Course_course_not_free', 'CourseController@search_course_not_free');

    Route::resource('courses', 'CourseController');

    # Classroom Management

    Route::group([ 'prefix' => 'classroom'], function () {
        Route::get('save/{courses}/{request_id}', 'ClassroomController@store')->name('classroom.save');

        Route::get('check/{noti_id}', 'ClassroomController@check')->name('classroom.check');
    });

    # Coin Management
    Route::group([ 'prefix' => 'coins'], function () {
        Route::get('add', 'CoinsController@add')->name('coins.add');
        Route::post('add', 'CoinsController@save')->name('coins.save');
        Route::get('revoke', 'CoinsController@revoke')->name('coins.revoke');
        Route::post('revoke', 'CoinsController@saverevoke')->name('coins.saverevoke');

        Route::get('refund', 'CoinsController@refund')->name('coins.refund');
        Route::post('saverefund', 'CoinsController@saverefund')->name('coins.saverefund');
    });
    Route::resource('coins', 'CoinsController');

    # Rating
    Route::group([ 'prefix' => 'rating'], function () {
        Route::get('teacher_rating/{course_id}', 'RatingController@index');
        Route::get('sent_teacher_rating/{course_id}', 'RatingController@sentTeacherRating');
        Route::post('save_teacher_rating', 'RatingController@saveTeacherRating')->name('rating.save_teacher_rating');

        Route::get('student_rating/{course_id}', 'RatingController@indexStudentRating');
        Route::get('sent_student_rating/{course_id}', 'RatingController@sentStudentRating');
        Route::post('save_student_rating', 'RatingController@saveStudentRating')->name('rating.save_student_rating');

        Route::get('show_student_rating/{rating_id}', 'RatingController@showStudentRating');
    });

    // test view email

    Route::get('test_sendmail', function() {
        return view('frontend.send_email_approve_teacher');
    });


    //test pusher
    Route::get('/counter', function(){
        //return view('frontend.counter');
        return view('frontend.default');
    });

    Route::get('/sender', function(){
        return view('frontend.sender');
    });

    Route::post('/sender', function(){
        $member_id = request()->member_id;
        echo 'member_id : '.$member_id;

        event(new SendNotiFrontend($member_id));

    })->name('frontend.sender');

    //set clear badge
    Route::post('/clear_badge', 'NotificationsController@clearBadge')->name('frontend.clear_badge');


    Addchat::routes();

    // ------------- request
    Route::get('search_study_group', 'RequestController@search_study_group')->name('search_study_group');
    Route::post('/search_subjects/get_data', 'RequestController@search_subjects');
    Route::resource('request', 'RequestController');
    Route::get('/get_request', 'RequestController@get_request');

    // ------------- profile member
    Route::post('/get_date/profile_contact', 'MemberController@profile_cousres');
    Route::post('/get/profile_contact', 'MemberController@profile_cousres');

    Route::post('/get_date/profile_coins', 'MemberController@profile_coins');
    Route::post('/get/profile_coins', 'MemberController@profile_coins');

    Route::post('/get_date/profile_alerts', 'MemberController@profile_alerts');
    Route::post('/get/profile_alerts', 'MemberController@profile_alerts');

    Route::post('/get_date/profile_request', 'MemberController@profile_request');
    Route::post('/get/profile_request', 'MemberController@profile_request');
    Route::get('/get/open_modal_request/{id}', 'MemberController@open_modal_request');

    //function not found
    Route::post('get_data/ged_all_instructors', 'MemberController@get_data_menber');

    //--------------- profile user
    Route::post('/get_date/user_profile_contact', 'UserController@user_profile_cousres');
    Route::post('/get/user_profile_contact', 'UserController@user_profile_cousres');
    //
    Route::post('/get_date/user_profile_coins', 'UserController@user_profile_coins');
    Route::post('/get/user_profile_coins', 'UserController@user_profile_coins');

    Route::post('/get_date/user_profile_alerts', 'UserController@user_profile_alerts');
    Route::post('/get/user_profile_alerts', 'UserController@user_profile_alerts');
    //
    Route::post('/get_date/user_profile_request', 'UserController@user_profile_request');
    Route::post('/get/user_profile_request', 'UserController@user_profile_request');
    Route::get('/get_user/open_modal_request/{id}', 'MemberController@open_modal_request');

    Route::get('/request/user_profile/{id}', 'RequestController@get_user_profile');
    Route::post('/get_date/request_profile_contact', 'RequestController@request_profile_cousres');
    Route::post('/get/request_profile_contact', 'RequestController@request_profile_cousres');


    Route::get('get_study_group', 'frontend\CourseController@get_study_group');
    Route::post('get_subjects', 'frontend\CourseController@get_subjects');

});

//Frontend before login
Route::group(['namespace'=>'frontend'], function () {

    Route::post('login', 'AuthController@postSignin')->name('login');
    Route::get('download_student_doc', 'MemberController@downloadStudentDoc');
    Route::get('download_teacher_doc', 'MemberController@downloadTeacherDoc');

    Route::post('/get_data/forgot_password', 'MemberController@check_email_forgot_password');

    # Member Management
    Route::group([ 'prefix' => 'members'], function () {
        Route::get('create', 'MemberController@create')->name('members.create');
        Route::post('store', 'MemberController@store')->name('members.store');
        Route::get('all', 'MemberController@all');
        Route::post('/all/search', 'MemberController@search')->name('all.search');
        Route::post('/all/fetch_data', 'MemberController@fetch_data')->name('all.fetch_data');
        Route::get('edit', 'MemberController@edit')->name('members.edit');
        Route::get('detail/{id}', 'MemberController@detail')->name('members.detail');
        Route::get('updatedata/checkEmail', 'MemberController@checkEmail');
        Route::get('checkEmail', 'MemberController@checkEmail');
        Route::post('/upFile', 'MemberController@upFile');
        Route::get('imgprofile', 'MemberController@imgprofilereload')->name('members.imgprofile');
        Route::get('updatedata/{members}', 'MemberController@updatedata')->name('members.updatedata');

        Route::get('/get_profile_member/{id}', 'MemberController@get_profile_member');
        Route::post('/data_profile_member_edit', 'MemberController@update_profile_member');
        // Route::get('profile', 'MemberController@profile')->name('members.profile');
        // Route::post('members_course', 'MemberController@member_course')->name('members.member_course');
        // Route::get('get_email_student', 'MemberController@get_email_student');
        // Route::post('list_student', 'MemberController@list_student');
        // Route::get('student_status/{course_id}', 'MemberController@student_status');
        // Route::get('/active_course', function () {
        //     return redirect('members/profile')->with('active', 'course');
        // });
    });

    # User Management
    Route::group([ 'prefix' => 'users'], function () {
        Route::get('create', 'UserController@create')->name('users.create');
        Route::post('store', 'UserController@store')->name('users.store');
        Route::get('checkEmail', 'MemberController@checkEmail');
        Route::post('checkFullname', 'MemberController@checkFullname');
        Route::get('imgprofile', 'UserController@imgprofile')->name('users.imgprofile');
        Route::get('/get_user_profiler/{id}', 'MemberController@get_profile_member');

        // Route::get('profile', 'UserController@profile')->name('users.profile');
        // Route::get('/active_course', function () {
        //     return redirect('users/profile')->with('active', 'course');
        // });
    });

    //teacher
    Route::group([ 'prefix' => 'teacher'], function () {
        Route::get('/', 'TeacherController@index');
        Route::post('/searach', 'TeacherController@getTeacher');
        Route::post('/searach/course', 'TeacherController@teacherCourse');
    });

    # Course Management
    Route::group([ 'prefix' => 'courses'], function () {
        Route::get('all', 'CourseController@all')->name('courses.all');

        // paginate
        Route::post('/all/page_course_free', 'CourseController@page_course_free')->name('all.page_course_free');

        // search
        Route::post('/all/actionCourseFree', 'CourseController@actionCourseFree')->name('all.actionCourseFree');
        Route::post('/all/actionCourseNotFree', 'CourseController@actionCourseNotFree')->name('all.actionCourseNotFree');

        Route::get('getsubject/{id}', 'CourseController@subject')->name('courses.subject');
        //Route::get('{id}/edit', 'CourseController@edit');//แก้ไข
        //Route::put('course_edit', 'CourseController@store');//แก้ไขคอร์ส
        Route::get('opencourse/{course}', 'CourseController@opencourse')->name('courses.opencourse');
        Route::get('status_create/{status}', 'CourseController@status_create')->name('courses.status_create');

        Route::get('/', 'CourseController@getIndex')->name('courses.getIndex');

        //Route::get('/update/{id}', 'CourseController@getUpdate')->name('courses.getUpdate');

        //Route::post('/update/{id}', 'CourseController@postUpdate')->name('courses.postUpdate');

        Route::post('getSubject', 'CourseController@getSubject')->name('courses.getSubject');

        //Route::get('delete/{id}', 'CourseController@delete')->name('courses.delete');

    });
    Route::post('/get_data/Course_coursetFree', 'CourseController@search_coursetFree');
    Route::post('/get/Course_coursetFree', 'CourseController@search_coursetFree');

    Route::post('/get_data/Course_course_not_free', 'CourseController@search_course_not_free');
    Route::post('/get/Course_course_not_free', 'CourseController@search_course_not_free');

    Route::resource('courses', 'CourseController');


    //set clear badge
    Route::post('/clear_badge', 'NotificationsController@clearBadge')->name('frontend.clear_badge');

    Route::get('get_study_group', 'CourseController@get_study_group');
    Route::post('get_subjects', 'CourseController@get_subjects');
});




//Backend index
Route::group(['middleware' => ['admin']], function () {
    Route::get('backend', 'MainController@backend')->name('backend');
});

//Backend before login
Route::group(['namespace'=>'backend', 'prefix' => 'backend'], function () {
    Route::get('signin', 'AuthController@getSignin')->name('signin');
    Route::post('signin', 'AuthController@postSignin')->name('postSignin');
    Route::post('signup', 'AuthController@postSignup')->name('signup');
    Route::get('logout', 'AuthController@getLogout')->name('logout');
});

//Backend after login
Route::group(['namespace'=>'backend', 'middleware' => ['admin'], 'prefix' => 'backend'], function () {

    # Members Management
    Route::group([ 'prefix' => 'members'], function () {
        Route::get('new', 'MemberController@membersNew')->name('members.membersNew');
        Route::get('all', 'MemberController@membersAll')->name('members.membersAll');
        Route::post('approve/{id}', 'MemberController@approve')->name('members.approve');
        Route::post('notallowed', 'MemberController@notallowed')->name('members.notallowed');
        Route::get('show/{id}', 'MemberController@show')->name('members.show');
        Route::get('destroy/{id}', 'MemberController@destroy')->name('members.destroy');
        Route::post('menber', 'MemberController@all')->name('members.all');
        Route::get('get_email_student/{member_id}', 'MemberController@get_email_student');

        Route::post('update/member', 'MemberController@update_teacher')->name('members.update_member');
    });

    # User Management
    Route::group([ 'prefix' => 'users'], function () {
        Route::get('index', 'UserController@index')->name('users.index');
        Route::DELETE('destroy/{users}', 'UserController@destroy')->name('users.destroy');
        Route::post('serverside', 'UserController@serverside')->name('users.serverside');
    });

    # Subjects Management
    Route::group([ 'prefix' => 'subjects'], function () {
        Route::get('create', 'SubjectController@create')->name('subjects.create');
        Route::post('destroy', 'SubjectController@destroy')->name('subjects.destroy');
        Route::get('show', 'SubjectController@show')->name('subjects.show');
        Route::post('store', 'SubjectController@store')->name('subjects.store');
    });
    Route::resource('subjects', 'SubjectController');

    # Groups Management
    Route::resource('groups', 'GroupsController');
    Route::get('groups/detail/{aptitude}', 'GroupsController@detail')->name('groups.detail');

    # Coins Management
    Route::group([ 'prefix' => 'coins'], function () {
        Route::get('fill', 'CoinsController@fill');
        Route::get('confirm/{coins}', 'CoinsController@confirm')->name('coins.confirm');
        Route::post('notconfirm/', 'CoinsController@notconfirm')->name('coins.notconfirm');
        Route::get('get_description/{id}', 'CoinsController@get_description');
        Route::get('get_description_revoke/{id}', 'CoinsController@get_description_revoke');

        Route::get('revoke', 'CoinsController@revoke');
        Route::get('confirmrevoke/{withdraw}', 'CoinsController@confirmrevoke')->name('coins.confirmrevoke');
        Route::post('notconfirmrevoke/', 'CoinsController@notconfirmrevoke')->name('coins.notconfirmrevoke');

        Route::get('refund', 'CoinsController@refund')->name('coins.refund');
        Route::post('confirmrefund', 'CoinsController@confirmrefund')->name('coins.confirmrefund');
        Route::post('notconfirmrefund', 'CoinsController@notconfirmrefund')->name('coins.notconfirmrefund');
        Route::get('get_description_refund/{id}', 'CoinsController@get_description_refund');
    });

    #classroom
    Route::group([ 'prefix' => 'classroom'], function () {
        Route::get('open_class_room/{id}', 'ClassroomController@openClassRoom')->name('open_class_room');
        Route::get('confirm_open_class_room/{id}', 'ClassroomController@getModalOpenClassRoom')->name('confirm_open_class_room');

        Route::get('logout/{id}', 'ClassroomController@logout')->name('logout_class_room');
        Route::get('test', 'ClassroomController@checkPrivateClassRoomCronJob');
    });
    Route::resource('classroom', 'ClassroomController', ['only'=> [
        'index'
    ]]);

    // Route::get('subject/{id}', 'CourseController@subject');

    #courses
    Route::group([ 'prefix' => 'courses'], function () {

       Route::get('/', 'CourseController@getIndex')->name('courses.getIndex');

       Route::get('/update/{id}', 'CourseController@getUpdate')->name('courses.getUpdate');

       Route::post('/update/{id}', 'CourseController@postUpdate')->name('courses.postUpdate');

       Route::post('getSubject', 'CourseController@getSubject')->name('courses.getSubject');

       Route::get('delete/{id}', 'CourseController@delete')->name('courses.delete');

   });

    #bank
    Route::group([ 'prefix' => 'banks'], function () {

    });
    Route::resource('banks', 'BankController');

    Route::resource('events', 'EventsController');

    //test pusher
    Route::get('/counter', function(){
        return view('backend.default');
    });

    Route::get('/sender', function(){
        return view('backend.sender');
    });

    Route::post('/sender', function(){
        $admin_id = request()->admin_id;
        echo 'admin_id : '.$admin_id;

        event(new SendNotiBackend($admin_id));

    })->name('backend.sender');

    //set clear badge
    Route::post('/clear_badge', 'NotificationsController@clearBadge')->name('backend.clear_badge');
});


Route::get('request_subjects', function(){
    return view('frontend.request_subjects');
});
