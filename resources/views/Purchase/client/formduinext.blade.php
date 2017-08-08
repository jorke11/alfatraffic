@extends('layouts.app')

@section('content')
<style>
    .column-left {
        border: 1px solid #D2D2D2;
        float: right;
        /* para mantener visible un elemento en todo momento aunque se haga scroll en la página */
        position: fixed;
        overflow: hidden;
        text-align: center;
        width: 48%;
    }
</style>
<div class="container-fluid">
    {!! Form::open(['id'=>'frm','url' => 'paymentDui', 'method' => 'post']) !!}
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-6">
                    <label for="email">Calendar</label>
                    <input type="text" id="datetimepicker3" name='datetimepicker3' class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-lg-offset-4">
                    <button class="btn btn-success" id="complete">Complete Registration</button>
                </div>
            </div>
        </div>

        <div class="col-lg-6  " >
            <div class="panel panel-default column-left">
                <div class="panel-heading">
                    <h3 class="panel-title">Order Summary</h3>
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-lg-6 text-left"><label>Course Type</label></div>
                        <div class="col-lg-3"><label>Fee</label></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 text-left">{{$sche[0]["course"]}}</div>
                        <div class="col-lg-3">{{$sche[0]["value"]}}</div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6 text-left"><label>Course Schedule</label></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-left">
                            @foreach($sche as $val)
                            <div class="row">
                                <div class="col-lg-6">{{$val["day"]}}, {{$month}}/{{$val["dayweek"]}} .....{{$val["hour"]}} - {{$val["hour_end"]}}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6 text-left"><label>Location</label></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 text-left">{{$sche[0]["location"]}}<br>
                            {{$sche[0]["address"]}}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6 text-left"><label>AddOn</label></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-left">
                            @foreach($addon as $val)
                            <div class="row">
                                <div class="col-lg-6">{{$val->description}}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!!Form::close()!!}
</div>

{!!Html::script('js/Purchase/Registry.js')!!}
@endsection