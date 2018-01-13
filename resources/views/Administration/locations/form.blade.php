<style>
    .btn-group, .btn-group-vertical{
        display:block;
    }
</style>
<div class="modal fade" role="dialog" id='modalNew'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Locations</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frm']) !!}
                <input type="hidden" id="id" name="id" class="input-locations">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Location Description (ex. Midtown Atlanta)</label>
                            <input type="text" class="form-control input-locations input-sm" id="description" name='description' required="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Street Address (ex. 123 Main Street, Atlanta, GA 30305)</label>
                            <input type="text" class="form-control input-locations input-sm" id="address" name='address' required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Phone</label>
                            <input type="text" class="form-control input-locations input-sm" id="phone" name='phone' required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Latitude</label>
                            <input type="text" class="form-control input-locations input-sm" id="latitude" name='latitude'>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Longitude</label>
                            <input type="text" class="form-control input-locations input-sm" id="longitude" name='longitude'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Order</label>
                            <input type="text" class="form-control input-locations input-sm" id="order" name='order' required>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="email">Courses</label>
                            <select class="form-control input-locations input-sm" id='courses' name="courses[]" multiple style="width:100%">
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
                            <label for="email">Customer Service Hours</label>
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Open</th>
                                        <th>Closed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($day as $i=>$val)
                                    <tr>
                                        <td>{{$val->description}}</td>
                                        <td><input type="text" class="form-control input-locations input-sm hours" name="init[]" id='init_{{$val->code}}'></td>
                                        <td><input type="text" class="form-control input-locations input-sm hours" name="end[]" id='end_{{$val->code}}'></td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id='new'>Save</button>
            </div>
        </div>
    </div>
</div>