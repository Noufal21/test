@extends('master')
@section('title','MyPage Title')
@section('content')
    <div class="pt-3">
        <div class="row">
            <div class="col-md-7 col-xs-12 col-md-offset-3">
                <div class="input-group mb-3 search search-reduce" id="searchByPropForm">
                    <input class="form-control" id="search" name="address" type="text" placeholder="By Property"  onFocus="geolocate()" required="true" value="" aria-describedby="searchByProperty"/>
                    <div class="input-group-append">
                        <input class="btn btn-primary" type="button" value="Search" id="searchByProperty">
                    </div>
                </div>
                <div class=" map" id="map">                </div>

                <div class="chart_bar" style="position: relative; margin:0 auto;width:80%; height:150px;" >
                    <div id="chart-1" ></div>
                </div>
            </div>


            <div class="col-md-4 col-xs-12 col-xs-12 mt-30" id="poiContent">
                <div class="swiper-container">
                    <div class="swiper-wrapper">


                    </div>
                    <!-- Add Arrows -->
                    <!-- Add Pagination -->
                </div>
                <!--<div class="swiper-button-next"><img src="images/icons/right.png" alt="right"></div>
                <div class="swiper-button-prev"><img src="images/icons/left.png" alt="left"></div>-->
                <div class="next-slide"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i></div>
                <div class="prev-slide"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></div>




            </div>
        </div>
    </div>

@endsection
@section('script')
    <style>
        #chart-1 {
            width		: 100%;
            height		: 150px;
            font-size	: 12px;
        }
        #chart-1 a {
            display: none !important;
        }
        .next-slide{
            width: 2%;
            margin: 0;
            padding: 0;
            position: absolute;
            right: 0;
            top: 0;
            cursor:pointer;
        }
        .prev-slide{
            width: 2%;
            margin: 0;
            padding: 0;
            right: 0;
            position: absolute;
            top: 25px;
            cursor:pointer;
        }
    </style>
@endsection