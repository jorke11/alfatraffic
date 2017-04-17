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
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">First name</label>
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
                        <label for="email">Address</label>
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
                                <input type="text" class="form-control input-category input-sm" id="state" name='state' required>
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
                        <input type="text" class="form-control input-category input-sm" id="telephone" name='telephone' required>
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
                        <input type="text" class="form-control input-category input-sm" id="license_issuing" name='license_issuing' required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control input-category input-sm" id="email" name='email' required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">Confirm Email</label>
                        <input type="text" class="form-control input-category input-sm" id="confirm_email" name='confirm_email' required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="email">Reason for Attending</label>
                        <input type="text" class="form-control input-category input-sm" id="reason" name='reason' required>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <label for="email">BUILDING INFORMATION</label>
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
                    <input type="checkbox" id="copy_address"> <label>Copy address from Student Informaiont</label>
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
                                <input type="text" class="form-control input-category input-sm" id="state_building" name='state_building' required>
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
                        <label for="email">Card</label>
                        <input type="text" class="form-control input-category input-sm" id="card_building" name='card_building' required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">Expires</label>
                        <input type="text" class="form-control input-category input-sm" id="date_expired_building" name='date_expired_building' required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">Security Code</label>
                        <input type="text" class="form-control input-category input-sm" id="security_code_building" name='security_code_building' required>
                    </div>
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
                </div>
            </div>
        </div>
    </div>
</div>

{!!Html::script('js/Purchase/Registry.js')!!}
@endsection