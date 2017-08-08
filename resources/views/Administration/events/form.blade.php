<style>
    .btn-group, .btn-group-vertical{
        display:block;
    }
</style>
<div class="modal fade" tabindex="-1" role="dialog" id='modalNew'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Events</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frm']) !!}
                <input type="hidden" id="id" name="id" class="input-events">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Description</label>
                            <input type="text" class="form-control input-events" id="description" name='description' required="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Location</label>
                            <select class="form-control" id="location_id" name="location_id" required="">
                                <option value="0">Selection</option>
                                @foreach($locations as $val)
                                <option value="{{$val->id}}">{{$val->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Course</label>
                            <select class="form-control" id="course_id" name="course_id" required="">
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Date Event</label>
                            <input type="text" class="form-control input-events" id="dateevent" name='dateevent'>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Action</label>
                            <select class="form-control" id="action_id" name="action_id" required="">
                                @foreach($actions as $val)
                                <option value="{{$val->code}}">{{$val->description}}</option>
                                @endforeach
                            </select>
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