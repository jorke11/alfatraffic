@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            
            <div class="panel-body">

                <table class="table table-bordered table-condensed" id="tbl">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Description</th>
                            <th>Code</th>
                            <th>Value</th>
                            <th>Group</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-3">Parameter</div>
                    <div class="col-lg-9 text-right">
                        <button class="btn btn-success btn-sm" type="button" id="btnNew">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button class="btn btn-success btn-sm" type="button" id="btnSave" >
                            <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                {!! Form::open(['id'=>'frm']) !!}
                <input type="hidden" id="id" name="id" class="input-parameters">
                <div class="row"> 
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Description:</label>
                            <input class="form-control input-parameters" id="description" name="description" placeholder="Description">
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Value:</label>
                            <input class="form-control input-parameters" id="value" name="value" placeholder="Value">
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Group:</label>
                            <input class="form-control input-parameters" id="group" name="group" placeholder="Group">
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Code:</label>
                            <input class="form-control input-parameters" id="code" name="code" placeholder="code">
                        </div>
                    </div>
                </div>

                {!!Form::close()!!}
            </div>

        </div>

    </div>
</div>
{!!Html::script('js/Administration/Parameters.js')!!}
@endsection