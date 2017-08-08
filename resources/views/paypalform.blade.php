@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    {!! Form::open(['id'=>'frm','url'=>'paypal/payment']) !!}
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Amount</label>
                                <input class="form-control" name="amount" id="amount">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <button type="submit">Payment</button>
                        </div>
                    </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
