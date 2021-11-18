@extends('frontend/default')

@section('content')
    <div align="center"><i class="fa fa-graduation-cap fa-3x" style="color: aquamarine;"></i><br><h3>ผู้สอนทั้งหมด</h3></div>
    <section class="p-t-50 p-b-65">
        <div class="container">
            <div class="form-row">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="ค้นหา...">
                    </div>
                    <div class="col-md-2">
                        <select class="form-control">
                            <option>-สถานะทั้งหมด-</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control">
                            <option>-ประเภทคอร์สทั้งหมด-</option>
                        </select>
                    </div>
            </div>
            <hr>
            <div class="row">
                @for ($i=0; $i<12; $i++)
                <div class="col-md-3">
                    <div class="product-grid" >
                        <div class="product-image">
                            <a href="#">
                                <img class="pic-1" src="{{ asset ('suksa/frontend/template/images/teacher/img_teacher01.png') }}">
                            </a>
                            <ul class="social">
                                <li><a href="#" data-tip="รายละเอียด"><i class="fa fa-search"></i></a></li>
                            </ul>
                        </div>
                        <div class="card-content">
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
                </div>
                @endfor
            </div>
            
        </div>
    </section>
@stop