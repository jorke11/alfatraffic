@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-3">Schedules</div>
                        <div class="col-lg-9 text-right">
                            <button class="btn btn-success btn-sm" type="button" id="btnNew">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"> New</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    {!! Form::open(['id'=>'frm']) !!}
                    <input id="id" type="hidden" name="id">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="email">Courses</label>
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="0">Selection</option>
                                            @foreach($courses as $i=>$val)
                                            <option value="{{$val->id}}">{{$val->description}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="email">Locations</label>
                                        <select class="form-control" name="location_id" id="location_id">
                                            <option value="0">Selection</option>
                                            @foreach($locations as $i=>$val)
                                            <option value="{{$val->id}}">{{$val->description}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="email">Hour</label>
                                        <input id="hour" name="hour" class="form-control" value="{{date("H:i")}}">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <ul class="list-group">
                                @foreach($day as $i=>$val)
                                <li class="list-group-item">
                                    <input type="radio" name="day" id="day" <?php echo ($today == $i) ? "checked" : '' ?> value="{{$i}}" onclick="obj.loadDay({{$i}})"> {{$val}}</li>
                                @endforeach
                            </ul>
                        </div>


                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-3">List Schedules</div>
                    </div>
                </div>
                <div class="panel-body">

                    <table class="table table-bordered table-condensed" id="tbl">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Location</th>
                                <th>Course</th>
                                <th>Hour</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{!!Html::script('js/Administration/schedules.js')!!}
@endsection