@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-3">List Events</div>
                    <div class="col-lg-9 text-right">
                        <button class="btn btn-success btn-sm" type="button" id="btnNew">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"> New</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <table class="table table-bordered table-condensed" id="tbl" style="width: 100% ">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Description</th>
                            <th>Course</th>
                            <th>Location</th>
                            <th>Latitude</th>
                            <th>Date Event</th>
                            <th>Action</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('Administration.events.form')

{!!Html::script('js/Administration/events.js')!!}
@endsection