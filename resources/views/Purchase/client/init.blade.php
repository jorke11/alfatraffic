@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="col-lg-3">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-condensed" id="tbl">
                    <thead>
                        <tr>
                            <th>Locations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($locations as $i=>$val)
                        <tr>
                            <td>
                                <input type="checkbox" name="locations[]" value="{{$val->id}}" class="input-locations"> {{$val->description}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-condensed" id="tbl">
                    <thead>
                        <tr>
                            <th>Courses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $i=>$val)
                        <tr>
                            <td>
                                <input type="checkbox" name="courses[]" value="{{$val->id}}" class="input-courses"> {{$val->description}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-condensed" id="tbl">
                    <thead>
                        <tr>
                            <th>Start Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($start as $i =>$val)
                        <tr>
                            <td>
                                <input type="checkbox" name="locations[]" value="{{$val->code}}"> {{$val->description}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-5">Course</div>
                    <div class="col-lg-4">Course</div>
                </div>
            </div>

            <!-- Table -->
            <table class="table" style='wdth:100%'>
                <tr align='center'>
                    <td>Data</td>
                    <td >Hour</td>
                    <td>
                        <button class="btn btn-success">Register</button>
                    </td>
                </tr>
            </table>
        </div>
        <div id="content-list">

        </div>

    </div>
</div>
{!!Html::script('js/Purchase/Clients.js')!!}
@endsection