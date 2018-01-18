@extends('layouts.app')
@section('content')
<style>
    .row-center {
        display: flex;
        justify-content: center;
    }
    .thumbnail .caption  p.button-custom{
        padding: 0 !important;
        margin: 0;
    }
</style>
<div class="container-fluid">
    <div class="row row-space">
        <div class="col-lg-12">
            <h2 class="text-center">Driving</h2>
        </div>
    </div>
    <div class="row row-center">
        @foreach($schedule as $val)
        <div class="col-sm-4 col-md-3">
            <div class="thumbnail">
                <div class="caption">
                    <h3>{{$val->description}}</h3>
                    @foreach($val->detail as $value)
                    <p>{{$value->course}}</p>
                    @endforeach
                    <p class="text-center button-custom"><a href="#" class="btn btn-success" role="button" style="width: 100%">Buy</a></p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
{!!Html::script('js/Administration/schedules.js')!!}
@endsection