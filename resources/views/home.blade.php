@extends('master')
@section('title','MyPage Title')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-xs-12 col-md-offset-3">
                <div class="input-group mb-3 search search-reduce" id="searchByPropForm">
                    <input class="form-control" id="search" name="address" type="text" placeholder="By Property"  onFocus="geolocate()" required="true" value="" aria-describedby="searchByProperty"/>
                    <div class="input-group-append">
                        <input class="btn btn-primary" type="button" value="Search" id="searchByProperty">
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-xs-12 mt-30 ">
                <div class="col-xs-12 mt-30 map" id="map">
                </div>
            </div>
            <div class="col-md-8 col-xs-12  ">
                <ul id="listpro">

                </ul>
            </div>
        </div>
    </div>

@endsection