@extends('master')
@section('title','MyPage Title')
@section('content')



    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="card-heading">
                        <h4>Owner</h4>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table cellspacing="0" style="border-collapse:collapse;">
                                <tbody>
                                <tr>
                                    <td>

                                        @foreach ($AVMResult["property"][0]["owner"] as $key => $value)
                                            @if(gettype($value) == "array")
                                                <strong>{{$key}} </strong>
                                            <br/>
                                                @foreach ($value as $k => $v)
                                                    <strong>{{$k}} : </strong>
                                                    <span >{{$v}}</span>
                                                    <br/>
                                                @endforeach
                                                <hr/>
                                            @else
                                                <strong>{{$key}} : </strong>
                                                <span >{{$value}}</span>
                                                <br>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card-heading">
                        <h4>Mortgage</h4>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table  cellspacing="0" style="border-collapse:collapse;">
                                <tbody>
                                <tr>
                                    <td>
                                        <strong>LENDER INFORMATION </strong>
                                        <br>
                                        @if($AVMResult["property"][0]["mortgage"]["lender"])
                                            @foreach ($AVMResult["property"][0]["mortgage"]["lender"] as $key => $value)
                                                <strong>{{$key}} : </strong>
                                                <span >{{$value}}</span>
                                                <br>
                                            @endforeach
                                        <hr>
                                            <strong>TITLE </strong>
                                            <br>
                                            @if($AVMResult["property"][0]["mortgage"]["title"])
                                                @foreach ($AVMResult["property"][0]["mortgage"]["title"] as $key => $value)
                                                    <strong>{{$key}} : </strong>
                                                    <span >{{$value}}</span>
                                                    <br>
                                                    @endforeach
                                                @endif
                                                <hr/>
                                                @if($AVMResult["property"][0]["mortgage"])
                                                    @foreach ($AVMResult["property"][0]["mortgage"] as $key => $value)
                                                        @if(gettype($value) != "array")
                                                            <strong>{{$key}} : </strong>
                                                            <span >{{$value}}</span>
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                @endif
                                        @else
                                            <span>NA</span>
                                        @endif
                                        <br>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div></div>
                </div>
            </div>
        </div>
    </div>


@endsection