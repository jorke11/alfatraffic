<div class="modal fade" tabindex="-1" role="dialog" id='modalNew'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Courses</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frm']) !!}
                <input type="hidden" id="id" name="id" class="input-courses">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Course Description / Type of Course (ex. Defensive Driving)</label>
                            <input type="text" class="form-control input-courses" id="description" name='description' required="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Check HERE If DUI Course Selected</label>
                            <input type="checkbox" class="input-courses" id="dui" name='dui'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Cost (ex. 95.00) <i>no need to use "$" symbol</i></label>
                            <input type="text" class="form-control input-courses" id="value" name='value' required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Order</label>
                            <input type="text" class="form-control" id="order" name='order' required value="1" disabled>
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