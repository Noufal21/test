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
                                        <strong>Owner Name: </strong>
                                        @foreach ($result["property"][0]["assessment"]["owner"]["owner1"] as $a)
                                            <span >{{$a}}</span>
                                        @endforeach
                                        <br>
                                        @if($result["property"][0]["assessment"]["owner"]["owner2"])
                                            <strong>Owner Name 2: </strong>
                                            @foreach ($result["property"][0]["assessment"]["owner"]["owner2"] as $a)
                                                <span>{{$a}}</span>
                                            @endforeach
                                        @endif
                                        <br>
                                        <strong>Address: </strong>
                                        <span >{{$result["property"][0]["assessment"]["owner"]["mailingAddressOneLine"]}}</span>
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
                                        <strong>Mortgage Title: </strong>
                                        @if($result["property"][0]["assessment"]["mortgage"]["title"])
                                            @foreach ($result["property"][0]["assessment"]["mortgage"]["title"] as $a)

                                                <span >{{$a}}</span>


                                            @endforeach
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
    </div>
    <div class="row">
        <div class="col-12">

                <div class="card">
                    <div class="card-heading">
                        <h4>AVM</h4>
                    </div>
                    <div class="card-body">
                        <table  cellspacing="0" style="border-collapse:collapse;">
                            <tbody>
                            <tr>
                                <td>
                                    <strong>scr: </strong>
                                    <span>{{$AVMResult["property"][0]["avm"]["amount"]["scr"]}}</span>
                                    <br>
                                    <strong>value: </strong>
                                    <span>{{$AVMResult["property"][0]["avm"]["amount"]["value"]}}</span>
                                    <br>
                                    <strong>high: </strong>
                                    <span>{{$AVMResult["property"][0]["avm"]["amount"]["high"]}}</span>
                                    <br>
                                    <strong>low: </strong>
                                    <span>{{$AVMResult["property"][0]["avm"]["amount"]["low"]}}</span>
                                    <br>
                                    <strong>fsd: </strong>
                                    <span>{{$AVMResult["property"][0]["avm"]["amount"]["fsd"]}}</span>
                                    <br>
                                    <strong>eventDate: </strong>
                                    @if(isset($AVMResult["property"][0]["avm"]["eventDate"]))
                                        <span>{{$AVMResult["property"][0]["avm"]["eventDate"]}}</span>
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
<div class="row">
<div class="col-4">
<div class="card">
<div class="card-heading">
<h4>AssessmentHistory</h4>
</div>
<div class="card-body">
<table class="table"  cellspacing="0" style="border-collapse:collapse;">
<thead>
<th>apprimprvalue</th>
<th>apprlandvalue</th>
<th>apprttlvalue</th>
</thead>
<tbody>
@foreach($AssessmentResult["property"][0]["assessmenthistory"] as $item)
<tr>
<td>{{ $item["appraised"]["apprimprvalue"] }}</td>
<td>{{ $item["appraised"]["apprlandvalue"] }}</td>
<td>{{ $item["appraised"]["apprttlvalue"] }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
<div class="col-4">
<div class="card">
<div class="card-body">
<table class="table"  cellspacing="0" style="border-collapse:collapse;">
<thead>
<th>assdimprvalue</th>
<th>assdimprvalue</th>
<th>assdimprvalue</th>
</thead>
<tbody>
@foreach($AssessmentResult["property"][0]["assessmenthistory"] as $item)
<tr>
<td>{{ $item["assessed"]["assdimprvalue"] }}</td>
<td>{{ $item["assessed"]["assdimprvalue"] }}</td>
<td>{{ $item["assessed"]["assdimprvalue"] }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
<div class="col-4">
<div class="card">
<div class="card-body">
<table class="table"  cellspacing="0" style="border-collapse:collapse;">
<thead>
<th>mktimprvalue</th>
<th>mktlandvalue</th>
<th>mktttlvalue</th>
</thead>
<tbody>
@foreach($AssessmentResult["property"][0]["assessmenthistory"] as $item)
<tr>
<td>{{ $item["market"]["mktimprvalue"] }}</td>
<td>{{ $item["market"]["mktlandvalue"] }}</td>
<td>{{ $item["market"]["mktttlvalue"] }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-6">
<div class="card">
<div class="card-body">
<table class="table"  cellspacing="0" style="border-collapse:collapse;">
<thead>
<th>calcimprind</th>
<th>calcimprvalue</th>
<th>calclandind</th>
<th>calclandvalue</th>
<th>calcttlind</th>
<th>calcttlvalue</th>
</thead>
<tbody>
@foreach($AssessmentResult["property"][0]["assessmenthistory"] as $item)
<tr>
<td>{{ $item["calculations"]["calcimprind"] }}</td>
<td>{{ $item["calculations"]["calcimprvalue"] }}</td>
<td>{{ $item["calculations"]["calclandind"] }}</td>
<td>{{ $item["calculations"]["calclandvalue"] }}</td>
<td>{{ $item["calculations"]["calcttlind"] }}</td>
<td>{{ $item["calculations"]["calcttlvalue"] }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
<div class="col-6">
<div class="card">
<div class="card-body">
<table class="table"  cellspacing="0" style="border-collapse:collapse;">
<thead>
<th>taxamt</th>
<th>taxyear</th>
</thead>
<tbody>
@foreach($AssessmentResult["property"][0]["assessmenthistory"] as $item)
<tr>
<td>{{ $item["tax"]["taxamt"] }}</td>
<td>{{ $item["tax"]["taxyear"] }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</div>

@endsection