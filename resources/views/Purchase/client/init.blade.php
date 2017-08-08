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
                                <input type="checkbox" {{($val->code==(int)date('m'))?'checked':''}} name="dates[]" value="{{$val->code}}" class="input-dates"> {{$val->description}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        @if(Session::has('success'))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-success"><strong>Successfull Purchase!</strong></div>
            </div>
        </div>
        @endif
        <div id="content-list">

        </div>

    </div>
</div>
{!!Html::script('js/Purchase/Clients.js')!!}
@endsection