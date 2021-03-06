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
    {!! Form::open(['id'=>'frm','url' => 'payment', 'method' => 'post']) !!}
    <input type="hidden" name="programation_id" value="{{$programation_id}}">
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">First Name</label>
                        <input type="text" class="form-control input-category input-sm" id="name" name='name' required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">Last Name</label>
                        <input type="text" class="form-control input-category input-sm" id="last_name" name='last_name' required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="email">Street Address</label>
                        <input type="text" class="form-control input-category input-sm" id="address" name='address' required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">City</label>
                        <input type="text" class="form-control input-category input-sm" id="city_id" name='city_id' required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">State</label>
                                <select id="state_id" name="state_id" class="form-control input-category input-sm" required="">
                                    <option value="0">Selection</option>
                                    @foreach($states as $val)
                                    <option value="{{$val->id}}">{{$val->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Zip code</label>
                                <input type="text" class="form-control input-category input-sm" id="zip_code" name='zip_code' required>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">Date of Birth</label>
                        <input type="text" class="form-control input-category input-sm" id="date_birth" name='date_birth' required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">Telephone</label>
                        <input type="text" class="form-control input-category input-sm" id="telephone" name='telephone' data-type="number" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">License</label>
                        <input type="text" class="form-control input-category input-sm" id="license" name='license' required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">License Issuing State</label>
                        <select id="license_issuing" name="license_issuing" class="form-control input-category input-sm" required="">
                            <option value="0">Selection</option>
                            @foreach($states as $val)
                            <option value="{{$val->id}}">{{$val->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control input-category input-sm" id="email" name='email' data-type="email" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">Confirm Email</label>
                        <input type="text" class="form-control input-category input-sm" id="confirm_email" name='confirm_email' data-type="email" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <label for="email">BILLING INFORMATION</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <input type="checkbox" id="btnCopy"> <label>Copy address from Student Information</label>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">First name</label>
                        <input type="text" class="form-control input-category input-sm" id="name_building" name='name_building' required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">Last Name</label>
                        <input type="text" class="form-control input-category input-sm" id="last_name_building" name='last_name_building' required>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="email">Address</label>
                        <input type="text" class="form-control input-category input-sm" id="address_building" name='address_building' required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">City</label>
                        <input type="text" class="form-control input-category input-sm" id="city_id_building" name='city_id_building' required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">State</label>
                                <select id="state_id_building" name="state_id_building" class="form-control input-category input-sm" required="">
                                    <option value="0">Selection</option>
                                    @foreach($states as $val)
                                    <option value="{{$val->id}}">{{$val->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Zip code</label>
                                <input type="text" class="form-control input-category input-sm" id="zip_code_building" name='zip_code_building' required>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="email">Card Number</label>
                        <input type="text" class="form-control input-category input-sm" id="card_building" name='card_building' required placeholder="Card Number">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">Expiration</label>
                        <input type="text" class="form-control input-category input-sm" id="date_expired_building" name='date_expired_building' required placeholder="MM / YY">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">Card Security Code</label>
                        <input type="text" class="form-control input-category input-sm" id="security_code_building" name='security_code_building' required>
                    </div>
                </div>

                <input type="hidden" class="input-category" id="date_selected" name='date_selected'>

            </div>
            <div class="row">
                <div class="col-lg-3 col-lg-offset-4">
                    <button type="button" class="btn btn-primary" id="complete">Continue Registration <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>
                </div>
            </div>
            <br>
        </div>

        <div class="col-lg-6" >
            <div class="panel panel-yellow column-left">
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
                            @foreach($schedule as $val)
                            <div class="row">
                                <div class="col-lg-12">{{$val["dateFormated"]}} ....{{$val["hour"]}} - {{$val["hour_end"]}}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6 text-left"><label>Location</label></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-left">{{$sche[0]["location"]}}<br>
                            {{$sche[0]["address"]}}
                        </div>
                    </div>
                    <br>
                    <!--                    <div class="row">
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
                                        </div>-->
                </div>
            </div>
        </div>
    </div>
    {!!Form::close()!!}
</div>

<div class="modal fade" role="dialog" id="modaldui">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Calendar</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <input type="text" id="datetimepicker3" name='datetimepicker3' class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="saveDate">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div><!-- /.modal -->


{!!Html::script('js/Purchase/Registry.js')!!}
@endsection