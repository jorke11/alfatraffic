<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <div class="panel panel-default">
                <div class="page-title" style="">
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <button class="btn btn-success btn-sm" id='btnNew'>
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"> New</span>
                            </button>
                            <button class="btn btn-success btn-sm" id='btnSave'>
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"> Save</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    {!! Form::open(['id'=>'frm']) !!}
                    <div class="row">
                        <input type="hidden" id="id" name="id" class="input-schedules">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="email">Description</label>
                                <input class="form-control input-schedules" id="description" name="description">
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="page-title" style="">
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <button class="btn btn-info btn-sm" id='btnNewDetail' disabled="">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"> Detail</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-condensed table-bordered" id="tblDetail">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Day</th>
                                        <th>Duration</th>
                                        <th>Hour</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="frmModalDetail">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria                                                                        -label="Close"><span aria-hidden="true">&times;</span></                                                                        button>
                    <h4 class="modal-title">Add Deta                                                                              il</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        {!! Form::open(['id'=>'frmDetail']) !!}
                        <input id="id" type="hidden" name="id">
                        <input id="schedule_id" type="hidden" name="schedule_id">                                                                                                                    

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="email">Courses</label>
                                    <select class="form-control input-det                                                                                                                                                                ail" name="course_id" id="course_id" required>                                                                                                                                                            
                                        <option value="0">Selection</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Day</label>

                                    <select class="form-control input-detail" name="day" id="day" required>
                                        <option value="0">Selection</option>
                                        @foreach($days as $i=>$val)
                                        <option value="{{$val->code}}">{{$val->description}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Hour</label>
                                    <input id="hour" name="hour" class="form-control input-detail" value="{{date("H:i")}}" required>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Duration</label>
                                    <input id="duration" name="duration" class="form-control input-detail" value="1" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnAddDetail">Save changes</button>
            </div>
        </div>
    </div>
</div>