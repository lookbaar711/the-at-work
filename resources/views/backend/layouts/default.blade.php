<!DOCTYPE html>

<?php

    if(Auth::guard('web')->user()){
        $admin_noti = get_admin_noti();
        $count_noti = count_admin_noti();;
        $show_noti = 1;
    }
    else{
        $count_noti = 0;
    }

    //$count_noti = 3;

    //echo $_SERVER['HTTP_HOST'];
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>
        @if($count_noti > 0)
            ({{ $count_noti }})
        @endif

        ATWORK
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- global css -->

    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/js/sweetalert2@8.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <style>
        td, th {
            white-space: nowrap;
        }

        .overflow_dps {
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
          width: 20vw;
        }

    </style>
    <!-- font Awesome -->

    <!-- end of global css -->
    <!--page level css-->
    @yield('header_styles')
            <!--end of page level css-->

<body class="skin-josh">
<header class="header">
    <a href="{{ route('backend') }}" class="logo">
        <img src="{{ asset('assets/img/the_at_work_logo.png') }}" alt="logo">
        {{-- <h1>ATWORK</h1> --}}
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <div class="responsive_nav"></div>
            </a>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                {{-- @include('layouts._messages') --}}
                {{-- @include('backend.layouts._notifications') --}}

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        {{-- @if(Sentinel::getUser()->pic)
                            <img src="{!! url('/').'/uploads/users/'.Sentinel::getUser()->pic !!}" alt="img" height="35px" width="35px"
                                 class="img-circle img-responsive pull-left"/>
                        @else
                            <img src="{!! asset('assets/img/authors/avatar3.jpg') !!} " width="35"
                                 class="img-circle img-responsive pull-left" height="35" alt="riot">
                        @endif --}}
                        <div class="riot">
                            <div>
                                <p class="user_name_max">{{ Auth::guard('web')->user()->first_name }} {{ Auth::guard('web')->user()->last_name }}</p>
                                <i class="caret"></i>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <div>
                                <i class="livicon pull-right" data-name="user" data-l="true" data-c="#fff"
                                   data-hc="#fff" data-s="70"></i>
                            </div>
                            <div>
                            <p class="topprofiletext">{{ Auth::guard('web')->user()->first_name }} {{ Auth::guard('web')->user()->last_name }}</p>
                            </div>
                        </li>
                        <li class="user-footer">
                            {{-- <div class="pull-left">
                                <a href="">
                                    <i class="livicon" data-name="lock" data-size="16" data-c="#555555" data-hc="#555555" data-loop="true"></i>
                                    Lock
                                </a>
                            </div> --}}
                            <div class="pull-right">
                                <a href="{{ URL::to('backend/logout') }}">
                                    <i class="livicon" data-name="sign-out" data-s="18"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <section class="sidebar ">
            <div class="page-sidebar  sidebar-nav">
                {{-- <div class="nav_icons">
                    <ul class="sidebar_threeicons">
                        <li>
                            <a href="{{ URL::to('datatables') }}">
                                <i class="livicon" data-name="table" title="Advanced tables" data-loop="true"
                                   data-color="#418BCA" data-hc="#418BCA" data-s="25"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('tasks') }}">
                                <i class="livicon" data-name="list-ul" title="Tasks" data-loop="true"
                                   data-color="#e9573f" data-hc="#e9573f" data-s="25"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('admin/gallery') }}">
                                <i class="livicon" data-name="image" title="Gallery" data-loop="true"
                                   data-color="#F89A14" data-hc="#F89A14" data-s="25"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('users') }}">
                                <i class="livicon" data-name="user" title="Users" data-loop="true"
                                   data-color="#6CC66C" data-hc="#6CC66C" data-s="25"></i>
                            </a>
                        </li>
                    </ul>
                </div> --}}
                <div class="clearfix"></div>
                <!-- BEGIN SIDEBAR MENU -->
                @include('backend.layouts._left_menu')
                <!-- END SIDEBAR MENU -->
            </div>
        </section>
    </aside>
    <aside class="right-side">

        <!-- Notifications -->
       <!--  <div id="notific">
        </div> -->

                <!-- Content -->
        @include('backend.layouts.alert')
        <div style="padding-top: 5px; padding-left: 10px; padding-right: 10px;">
            @include('backend.layouts.flash-message')
        </div>
        @yield('content')

    </aside>
    <!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top"
   data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<!-- global js -->
<script src="{{ asset('assets/js/app.js') }}" type="text/javascript"></script>
<!-- end of global js -->


<script src="https://js.pusher.com/5.0/pusher.min.js"></script>

<script>
    var admin_id = $('#admin_id').val();

    if(admin_id != ''){
        var hostname = '{{ $_SERVER['HTTP_HOST'] }}';
        var my_channel = '';
        var my_event = '';
        var pusher_key = '';



        //if(location.hostname === "localhost" || location.hostname === "127.0.0.1"){

        if((hostname == "127.0.0.1:8000") || (hostname == "127.0.0.1") || (hostname == "localhost")){
            my_channel = 'localhost-backend-channel';
            my_event = 'localhost-backend-event';
            pusher_key = 'a147309e24da64d5e004';
        }
        else if(hostname == 'dev.suksa.online'){
            my_channel = 'dev-backend-channel';
            my_event = 'dev-backend-event';
            pusher_key = '8f39caacde1f81801fdd';
        }
        else{ ////suksa.online
            my_channel = 'production-backend-channel';
            my_event = 'production-backend-event';
            pusher_key = 'f7bb3cd5d97dc796dbdd';
        }

        //alert(hostname+' -- '+my_channel+' -- '+my_event);

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher(pusher_key, {
            cluster: 'ap1',
            forceTLS: true
        });

        var channel = pusher.subscribe(my_channel);
        channel.bind(my_event, function(data) {
            //JSON.stringify(data)
            //alert(JSON.stringify(data));

            var count_admin_noti = data.count_admin_noti;

            if((admin_id == data.admin_id) || (data.admin_id == 'all')){

                var badge = $('#badge').val();
                var new_badge = parseInt(badge)+1;

                if($('.header-icons-noti')[0]){
                    $('.header-icons-noti').text(new_badge);
                }
                else {
                    var add_noti = document.getElementById('add_noti');
                    add_noti.innerHTML += '<span class="label label-warning header-icons-noti" id="show_noti">'+new_badge+'</span>';
                }

                document.title = '('+new_badge+')'+' Suksa Online Backend';
                $('#badge').val(new_badge);

                var header_noti = document.getElementById('header_noti');
                var noti_box = '';
                var show_text = '';

                if(data.noti_type == 'register_teacher'){
                    show_text = data.member_fullname+' ได้ลงทะเบียนผู้สอนแล้ว';
                    noti_box = '<li><i class="danger"></i><a href="{{ URL::to('backend/members/new') }}">'+show_text.substring(0, 30)+'...</a><small class="pull-right">'+data.created_at+'</small></li>';
                }
                else if(data.noti_type == 'topup_coins'){
                    show_text = data.member_fullname+' ได้แจ้งเติม Coins เข้ามาในระบบ';
                    noti_box = '<li><i class="warning"></i><a href="{{ URL::to('backend/coins/fill') }}">'+show_text.substring(0, 30)+'...</a><small class="pull-right">'+data.created_at+'</small></li>';
                }
                else if(data.noti_type == 'withdraw_coins'){
                    show_text = data.member_fullname+' ได้แจ้งถอน Coins เข้ามาในระบบ';
                    noti_box = '<li><i class="info"></i><a href="{{ URL::to('backend/coins/revoke') }}">'+show_text.substring(0, 30)+'...</a><small class="pull-right">'+data.created_at+'</small></li>';
                }
                else if(data.noti_type == 'refund'){
                    show_text = data.member_fullname+' ได้แจ้งขอคืนเงิน เข้ามาในระบบ';
                    noti_box = '<li><i class="primary"></i><a href="{{ URL::to('backend/coins/refund') }}">'+show_text.substring(0, 30)+'...</a><small class="pull-right">'+data.created_at+'</small></li>';
                }

                header_noti.insertAdjacentHTML("afterbegin", noti_box);
            }
        });
    }

    $('.clear-badge').click(function() {
        $.ajax({
            url:"{{ route('backend.clear_badge') }}",
            method:"POST",
            data:{
                admin_id: $('#admin_id').val(),
                _token: $('input[name="_token"]').val()
            },
            success:function(result){
                if(result > 0){
                    var show_noti = document.getElementById('show_noti');
                    show_noti.innerHTML = '';

                    $('#badge').val('0');
                    document.title = 'Suksa Online Backend';
                }
            }
        });
    });

    $(function(){
      // console.log("4444");
      $('#input_file_img').on("click", ".browse", function() {
        var file = $(this).parents().find(".file");
        file.trigger("click");
      });

      $('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file").val(fileName);

        var reader = new FileReader();
        reader.onload = function(e) {
          // get loaded data and render thumbnail.
          document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
      });
    });
</script>
<!-- begin page level js -->
@yield('footer_scripts')
        <!-- end page level js -->
</body>
</html>
