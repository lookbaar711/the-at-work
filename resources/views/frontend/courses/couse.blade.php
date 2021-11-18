@@ -1,955 +0,0 @@
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>Suksa</title>

        <!-- fonts kanit -->
        <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
       
        <link rel="icon" type="image/png" href="{!! asset ('suksa/frontend/template/images/icons/favicon1.png') !!}"/>
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/fonts/font-awesome-4.7.0/css/font-awesome.min.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/fonts/themify/themify-icons.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/fonts/elegant-font/html-css/style.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/bootstrap/css/bootstrap.min.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/animate/animate.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/css-hamburgers/hamburgers.min.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/animsition/css/animsition.min.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/select2/select2.min.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/daterangepicker/daterangepicker.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/slick/slick.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/vendor/lightbox2/css/lightbox.min.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/util.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/main.css') !!}">
        <link rel="stylesheet" type="text/css" href="{!! asset ('suksa/frontend/template/css/buttons.css') !!}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        
  </head>
  <body class="animsition">
    {{-- @if(!@$success)
    
    @endif --}}
    @if(session('alert'))
        <script>
                Swal.fire({
                    title: '<strong>ได้รับข้อมูลการสมัครแล้ว</u></strong>',
                    imageUrl: '../suksa/frontend/template/images/logo1.png',
                    imageHeight: 100,
                    html:
                        'ระบบจะทำการตรวจสอบข้อมูลของคุณ<br>'+
                        'และแจ้งผลการสมัคร ไปที่อีเมลของคุณอีกครั้ง',
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonText: 'ปิดหน้าต่าง',
                })
        </script>
    @else
        <script>
            Swal.fire({
                title: '<strong>สมัครสมาชิกผู้สอน</u></strong>',
                imageUrl: '../suksa/frontend/template/images/20670-02.png',
                imageHeight: 250,
                html:
                    'Les"t start to be the teacher<br><br>'+
                  
                    '<a href="{!! route("members.create") !!}"><button  class="btn-hover color-5" <Object class="colorlink"> สมัครสมาชิกผู้สอน </Object></button></a>',
                showCloseButton: true,
                showCancelButton: false,
                focusConfirm: false,
                showConfirmButton: false,
                
            })
        </script>
    @endif
    <!-- Header -->
    <header class="header2">
        <!-- Header desktop -->
        <div class="container-menu-header-v2 p-t-26">
            <div class="topbar2">
                <!-- Logo2 -->
                <a href="index.html" class="logo2">
                    <!-- <img src="images/icons/logo.png" alt="IMG-LOGO"> -->
                    <img src="{{ asset ('suksa/frontend/template/images/logo1.png') }}">
                </a>

                <div class="topbar-child2 m-l-30">
                    <i class="fa fa-graduation-cap" aria-hidden="true" style="color: #569c37;"></i>&nbsp;
                <a class="topbar-email" href="{{ route('members.create') }}">
                        ลงทะเบียนเป็นผู้สอน
                    </a>

                    <span class="linedivide1"></span>
                    {{-- @if (Auth::guest()) --}}
                    <i class="fa fa-user-plus" aria-hidden="true" style="color: #569c37;"></i>&nbsp;
                    <a class="topbar-email" href="{{ url('register/user') }}">
                        สร้างบัญชี
                    </a>

                    <span class="linedivide1"></span>
                    <i class="fa fa-lock" aria-hidden="true" style="color: #569c37;"></i>&nbsp;
                    <a class="topbar-email" href="{{ url('login') }}">
                        เข้าสู่ระบบ
                    </a>
                    {{-- @else --}}
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle text-green1" data-toggle="dropdown" role="button" aria-expanded="false">
                           <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ url('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('logout') }}" method="GET">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul> 

                    </li>

                    {{-- @endif --}}
                </div>

            </div>

            <div class="wrap_header">
                <div class="wrap_menu">
                    <nav class="menu">
                        <ul class="main_menu">
                            <li class="main-menu-active">
                                <a href="">หน้าแรก</a>
                                 <ul class="sub_menu">
                                    <li><a href="index.html">Homepage V1</a></li>
                                    <li><a href="home-02.html">Homepage V2</a></li>
                                    <li><a href="home-03.html">Homepage V3</a></li>
                                </ul> 
                            </li>

                            <li>
                                <a href="product.html">ผู้สอนทั้งหมด</a>
                            </li>

                            <li>
                                <a href="product.html">คอร์สเรียนออนไลน์</a>
                            </li>

                            <li>
                                <a href="cart.html">คลังหนังสือ</a>
                            </li>

                            <li>
                                <a href="blog.html">เติม Coins</a>
                            </li>

                            <!-- <li>
                                <a href="about.html">แจ้งการชำระเงิน</a>
                            </li> -->

                            <li>
                                <a href="contact.html">ความช่วยเหลือ</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Header Icon -->
                <div class="header-icons">

                </div>
            </div>
        </div>

        <!-- Header Mobile -->
        <div class="wrap_header_mobile">
            <!-- Logo moblie -->
            <a href="index.html" class="logo-mobile">
                <!-- <img src="images/icons/logo.png" alt="IMG-LOGO"> -->
                 <img src="{{ asset ('suksa/frontend/template/images/logo1.png') }}">

            </a>

            <!-- Button show menu -->
            <div class="btn-show-menu">
                <!-- Header Icon mobile -->

                <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div class="wrap-side-menu" >
            <nav class="side-menu">
                <ul class="main-menu">
                    <li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
                        <span class="topbar-child1">
                            ลงทะเบียนเป็นผู้สอน
                        </span>
                    </li>

                     <li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
                        <span class="topbar-child1" data-toggle="modal" data-target="#myModal">
                           สร้างบัญชี
                        </span>
                    </li>

                     <li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
                        <span class="topbar-child1">
                            เข้าสู่ระบบ
                        </span>
                    </li>


                    <li class="item-menu-mobile">
                        <a href="index.html">Home</a>
                        <ul class="sub-menu">
                            <li><a href="index.html">Homepage V1</a></li>
                            <li><a href="home-02.html">Homepage V2</a></li>
                            <li><a href="home-03.html">Homepage V3</a></li>
                        </ul>
                        <i class="arrow-main-menu fa fa-angle-right" aria-hidden="true"></i>
                    </li>

                    <li class="item-menu-mobile">
                        <a href="product.html">Shop</a>
                    </li>

                    <li class="item-menu-mobile">
                        <a href="product.html">Sale</a>
                    </li>

                    <li class="item-menu-mobile">
                        <a href="cart.html">Features</a>
                    </li>

                    <li class="item-menu-mobile">
                        <a href="blog.html">Blog</a>
                    </li>

                    <li class="item-menu-mobile">
                        <a href="about.html">About</a>
                    </li>

                    <li class="item-menu-mobile">
                        <a href="contact.html">Contact</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    </body>
</html>
    <!-- Banner -->
    <section class="slide1">
        <div class="wrap-slick1">
            <div class="slick1">

                <div class="item-slick1 item1-slick1" style="background-image: url(suksa/frontend/template/images/banner008.jpg);">
                    <div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
                        <h2 class="caption1-slide1 t-center xl-text2-banner p-b-6 animated visible-false m-b-22" data-appear="fadeInUp">
                            Request บทเรียนได้ด้วยตนเอง
                        </h2>

                        <span class="caption2-slide1 t-center m-text1-banner animated visible-false m-b-33" data-appear="fadeInDown">
                            คุณอยากเรียนอะไร Request มาเลย เรามีผู้สอนมากมาย รอคุณอยู่
                        </span>
                         <!-- <span class="caption2-slide1 m-text1-banner animated visible-false m-b-33" data-appear="fadeInDown">
                            
                        </span> -->

                        <div class="wrap-btn-slide1 w-size1 animated visible-false" data-appear="zoomIn">
                            <a href="" class="flex-c-m size2 bo-rad-23 s-text2 bgwhite hov1 trans-0-4">
                                <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;
                                Request บทเรียน
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Group learning -->
    <section class="p-t-50 p-b-65">
        <div class="container">
            <div class="p-b-30">
                <h3 class="m-text5 t-left">
                    กลุ่มสาระการเรียนรู้
                </h3>
            </div>

            <table>
                <tr>
                    <td style="display: inline-block; padding: 15px;">
                        <div class="circle-grid">
                            <div class="circle-image">
                                <a href="#">
                                    <img src="{{ asset ('suksa/frontend/template/images/group_learning/GroupLearning_01.png') }}">
                                </a>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3 class="title t-center p-b-20"><a href="#">ภาษาไทย</a></h3>
                        </div>
                    </td>
                    <td style="display: inline-block; padding: 15px;">
                        <div class="circle-grid">
                            <div class="circle-image">
                                <a href="#">
                                    <img src="{{ asset ('suksa/frontend/template/images/group_learning/GroupLearning_02.png') }}">
                                </a>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3 class="title t-center p-b-20"><a href="#">คณิตศาสตร์</a></h3>
                        </div>
                    </td>
                    <td style="display: inline-block; padding: 15px;">
                        <div class="circle-grid">
                            <div class="circle-image">
                                <a href="#">
                                    <img src="{{ asset ('suksa/frontend/template/images/group_learning/GroupLearning_03.png') }}">
                                </a>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3 class="title t-center p-b-20"><a href="#">วิทยาศาสตร์</a></h3>
                        </div>
                    </td>
                    <td style="display: inline-block; padding: 15px;">
                        <div class="circle-grid">
                            <div class="circle-image">
                                <a href="#">
                                    <img src="{{ asset ('suksa/frontend/template/images/group_learning/GroupLearning_04.png') }}">
                                </a>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3 class="title t-center p-b-20"><a href="#">สังคม</a></h3>
                        </div>
                    </td>
                    <td style="display: inline-block; padding: 15px;">
                        <div class="circle-grid">
                            <div class="circle-image">
                                <a href="#">
                                    <img src="{{ asset ('suksa/frontend/template/images/group_learning/GroupLearning_05.png') }}">
                                </a>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3 class="title t-center p-b-20"><a href="#">สุขศึกษา</a></h3>
                        </div>
                    </td>
                    <td style="display: inline-block; padding: 15px;">
                        <div class="circle-grid">
                            <div class="circle-image">
                                <a href="#">
                                    <img src="{{ asset ('suksa/frontend/template/images/group_learning/GroupLearning_00.png') }}">
                                </a>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3 class="title t-center p-b-20"><a href="#">เพิ่มเติม</a></h3>
                        </div>
                    </td>
                </tr>
            </table>

        </div>
    </section>

    <!-- Teachers -->
    <section class="blog p-t-30 p-b-65" style="background-image: url(suksa/frontend/template/images/banner005.jpg); background-size: cover; width: 100%;">
        <!-- <section id="reviews" class="reviews"> -->
        <div class="container">
            <div class="t-center">
                <i class="fa fa-graduation-cap fa-3x" aria-hidden="true"></i>
            </div>
            <div class="p-b-30">
                <h3 class="m-text5 t-center">
                    ผู้สอนแนะนำ
                </h3>
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#">
                                <img class="pic-1" src="{{ asset ('suksa/frontend/template/images/teacher/img_teacher01.png') }}">
                            </a>
                            <ul class="social">
                                <li><a href="" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                            </ul>
                        </div>
                        <ul class="rating">
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star disable"></li>
                        </ul>
                        <div class="product-content">
                            <h3 class="title"><a href="#">700-3,500 Coins</a></h3>
                            <h3 class="title"><a href="#">นิรนาชญ์ กิ่งกล้า</a></h3>
                            <p class="title"><a href="#">คณิตศาสตร์, สังคม, ประวัติศาสตร์</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#">
                                <img class="pic-1" src="{{ asset ('suksa/frontend/template/images/teacher/img_teacher02.png') }}">
                            </a>
                        </div>
                        <ul class="rating">
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star disable"></li>
                        </ul>
                        <div class="product-content">
                            <h3 class="title"><a href="#">700-3,500 Coins</a></h3>
                            <h3 class="title"><a href="#">วีรพัฒน์ นาติยะ</a></h3>
                            <h5 class="title"><a href="#">ภาษาอังกฤษ, ภาษาฝรั่งเศษ, ภาษาญี่ปุ่น</a></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#">
                                <img class="pic-1" src="{{ asset ('suksa/frontend/template/images/teacher/img_teacher03.png') }}">
                            </a>
                        </div>
                        <ul class="rating">
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star disable"></li>
                        </ul>
                        <div class="product-content">
                            <h3 class="title"><a href="#">700-3,500 Coins</a></h3>
                            <h3 class="title"><a href="#">ตรีอัปสร อัมไฟลิน</a></h3>
                            <h5 class="title"><a href="#">คณิตศาสตร์, สังคม, ประวัติศาสตร์</a></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#">
                                <img class="pic-1" src="{{ asset ('suksa/frontend/template/images/teacher/img_teacher04.png') }}">
                            </a>
                        </div>
                        <ul class="rating">
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star disable"></li>
                        </ul>
                        <div class="product-content">
                            <h3 class="title"><a href="#">700-3,500 Coins</a></h3>
                            <h3 class="title"><a href="#">นิรนาชญ์ กิ่งกล้า</a></h3>
                            <h5 class="title"><a href="#">คณิตศาสตร์, สังคม, ประวัติศาสตร์</a></h5>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container">
                <div class="row p-t-20" style="text-align: right; float: right;">
                    <a href="" class="t-right">แสดงผู้สอนทั้งหมด&nbsp;<i class="fa fa-angle-right p-t-5" aria-hidden="true"></i></a>
                    <!-- <div class="t-right"> -->
                        
                    <!-- </div> -->
                </div>
            </div>

        </div>
    </section>

    <!-- Couses -->
    <section class="bgwhite p-t-45 p-b-70">
        <div class="container">
            <div class="sec-title p-b-22">
                <h3 class="m-text5 t-center">
                    คอร์สเรียนแนะนำ
                </h3>
            </div>

            <!-- Tab01 -->
            <div class="tab01">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#best-seller" role="tab">คอร์สเรียนฟรี</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#featured" role="tab">คอร์สเรียนมีค่าใช้จ่าย</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-t-35">
                    <!-- - -->
                    <div class="tab-pane fade show active" id="best-seller" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-40">
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative">
                                        <a href=""><img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c1.png') }}" alt="IMG-PRODUCT"></a>
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-40">
                                <!-- Block2 -->
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative">
                                        <img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c2.png') }}" alt="IMG-PRODUCT">
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-40">
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative">
                                        <img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c3.png') }}" alt="IMG-PRODUCT">
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-40">
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelsale">
                                        <img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c4.png') }}" alt="IMG-PRODUCT">
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-15">
                                <!-- Block2 -->
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative">
                                        <img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c5.png') }}" alt="IMG-PRODUCT">
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-15">
                                <!-- Block2 -->
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative">
                                        <img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c6.png') }}" alt="IMG-PRODUCT">
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-15">
                                <!-- Block2 -->
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative">
                                        <img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c7.png') }}" alt="IMG-PRODUCT">
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-15">
                                <!-- Block2 -->
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative">
                                        <img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c8.png') }}" alt="IMG-PRODUCT">
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                    <div class="tab-pane fade" id="featured" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-40">
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative">
                                        <a href=""><img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c1.png') }}" alt="IMG-PRODUCT"></a>
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-40">
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative">
                                        <img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c2.png') }}" alt="IMG-PRODUCT">
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-40">
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative">
                                        <img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c3.png') }}" alt="IMG-PRODUCT">
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-40">
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelsale">
                                        <img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c4.png') }}" alt="IMG-PRODUCT">
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-15">
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative">
                                        <img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c5.png') }}" alt="IMG-PRODUCT">
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-15">
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative">
                                        <img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c6.png') }}" alt="IMG-PRODUCT">
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-15">
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative">
                                        <img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c7.png') }}" alt="IMG-PRODUCT">
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-15">
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative">
                                        <img src="{{ asset ('suksa/frontend/template/images/couse_recommend/c8.png') }}" alt="IMG-PRODUCT">
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="" class="p-b-5">
                                            <p class="fs-18 text-black">3000 Coins</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-14 text-black">หัวข้อคอร์สเรียน โดยอาจารย์ตั้ง</p>
                                        </a>
                                        <a href="" class="p-b-5">
                                            <p class="fs-12">ชื่อหัวข้อ หมวดสังคมศาสตร์</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="container">
                <div class="row p-t-20" style="text-align: right; float: right;">
                    <a href="" class="t-right">แสดงผู้สอนทั้งหมด&nbsp;<i class="fa fa-angle-right p-t-5" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </section>


    <!-- Banner -->
    <section class="blog p-t-10">
        <img src="{{ asset ('suksa/frontend/template/images/banner3.png') }}" style="width: 100%; height: 100%;">
    </section>


    <!-- Footer -->
    <footer class="bg9 p-t-45 p-b-43">
        <div class="container">
            <div class="flex-w p-b-5">
                <div class="p-t-20 respon3">
                    <a href="" class="text-white">ผู้สอนทั้งหมด</a>
                </div>

                <div class="p-t-20 respon3">
                    <a href="" class="text-white">คอร์สเรียนออนไลน์</a>
                </div>

                <div class="p-t-20 respon3">
                    <a href="" class="text-white">คลังหนังสือ</a>
                </div>

                <div class="p-t-20 respon3">
                    <a href="" class="text-white">เติม Coins</a>
                </div>

                <div class="p-t-20 respon3">
                    <a href="" class="text-white">แจ้งการชำระเงิน</a>
                </div>

                 <div class="p-t-20 respon3">
                    <a href="" class="text-white">ความช่วยเหลือ</a>
                </div>
                <div class="p-t-20 p-l-15 p-r-30 respon3"></div>
                <div class="p-t-20 p-l-15 p-r-30 respon3"></div>
                <div class="p-t-20 p-l-15 p-r-30 respon3"></div>

                <div class="p-t-20 p-l-15 p-r-15 respon3">
                    <div class="w-size9 t-center">
                        <h3 class="fs-22 text-white p-b-5">Customer Support</h3>
                    </div>
                    <div class="w-size9 t-center">
                        <p class="fs-12 text-white p-b-5">Mon-Fri 09:00-18:00</p>
                    </div>

                    <div class="w-size3 t-center">
                        <h3 class="fs-22 text-white">02 982 9999</h3>
                    </div>
                </div>
            </div>

            <table border="0" style="text-align: left; margin-left: 0px;">
                <tr>
                    <td style="display: inline-block; margin-left: 10px;">
                        <p class="fs-14">Copyright © 2019 Education. All rights reserved.</p>
                    </td>
                </tr>
            </table>
            
        </div>
        
    </footer>



    <!-- Back to top -->
    <div class="btn-back-to-top bg0-hov" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="fa fa-angle-double-up" aria-hidden="true"></i>
        </span>
    </div>

    <!-- Container Selection1 -->
    <div id="dropDownSelect1"></div>

    <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/animsition/js/animsition.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/bootstrap/js/popper.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/select2/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/slick/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('suksa/frontend/template/js/slick-custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/countdowntime/countdowntime.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/lightbox2/js/lightbox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/sweetalert/sweetalert.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset ('suksa/frontend/template/vendor/parallax100/parallax100.js') }}"></script>
    <script src="{{ asset ('suksa/frontend/template/js/main.js') }}"></script>

    <!------modal------>
    

    <!--------------------------------------------slide------------------------------------------->
    <!--------------------------------------------slide------------------------------------------->

</body>
</html>