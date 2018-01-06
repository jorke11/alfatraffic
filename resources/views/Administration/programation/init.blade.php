@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">Months</label>
                <select class="form-control" id="month_id" name="month_id">
                    @foreach($months as $val)
                    <option value="{{$val["month"]}}" <?php echo ($mont == (int) $val["month"]) ? "selected" : '' ?>>{{$val["literal"]}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered" id='table-calendar'>
                <thead>
                    <tr>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miercoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sabado</th>
                        <th>Domingo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    foreach ($daysf as $val) {
//                        dd($val);
                        ?>
                        <tr align='center'>
                            <?php
                            $quit = "";
                            for ($i = 1; $i <= 7; $i++) {
                                $cont = 0;

                                foreach ($val["week"] as $value) {
                                    if ($value["number_week"] == $i) {
                                        $cont++;
                                        ?>
                                        <td style="padding-top: 4%;padding-bottom: 4%;cursor: pointer">
                                            <?php
                                            if (($value["day"] < $day) && $day != 0) {
                                                ?>
                                                <span class="badge">
                                                    {{$value["day"]}}
                                                </span>
                                                <?php
                                            } else {
                                                ?>
                                                <span style="background-color: green" class="badge" onclick="obj.add({{$value["id"]}},{{$value["day"]}},{{$value["year"]}},{{$value["month"]}})">
                                                    {{$value["day"]}} <span class="glyphicon glyphicon-plus"  aria-hidden="true"></span>
                                                </span>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if (isset($value["detail"])) {
                                                ?>
                                                <ul class="list-group">
                                                    <?php
                                                    foreach ($value["detail"] as $val2) {
                                                        $node = ($val2["node_id"] == null) ? '' : "(" . $val2["node_id"] . ") ";
                                                        ?>
                                                        <li class="list-group-item" style="font-size: 10px">
                                                            #{{$val2["id"]}} <strong style="color:green">{{$node}}</strong>{{$val2["location"]}}<br>{{$val2["course"]}} 

                                                            <span class="badge" onclick="obj.delete({{$val2["id"]}})">X</span>
                                                            <span class="badge" onclick="obj.addMessage({{$val2["id"]}})">
                                                                <span class="glyphicon glyphicon-comment"  aria-hidden="true"></span>
                                                            </span></li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <?php
                                    }
                                }

                                if ($cont == 0) {
                                    ?>
                                    <td></td>
                                    <?php
                                }
                                ?>

                                <?php
                            }
                            ?>
                            <?php
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" id="modalCourse">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['id'=>'frm','url'=>'programation']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Course</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="day_id" id='day_id'>
                    <input type="hidden" name="mount_id" id='mount_id'>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Date</label>
                                <input type="text" name="date" id='date' value="0" class="form-control input-programation">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Hour</label>
                                <input type="text" name="hour" id='hour' value="<?php echo date("H:i") ?>" class="form-control input-programation">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Locations</label>
                                <select class="form-control input-programation" id="location_id" name="location_id">
                                    <option value="0">Seleccione</option>
                                    @foreach($locations as $val)
                                    <option value="{{$val->id}}">{{$val->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Courses</label>
                                <select class="form-control input-programation" id="course_id" name="course_id">
                                    <option value="0">Seleccione</option>
                                    @foreach($courses as $val)
                                    <option value="{{$val->id}}">{{$val->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Duration</label>
                                <input type="text" name="duration" id='duration' class="form-control input-programation">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Linked</label>
                                <input type="text" name="node_id" id='node_id' class="form-control input-programation">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnAdd">Save changes</button>
                </div>
                {!!Form::close()!!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="modalMessage">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['id'=>'frmMessage']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Message</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="row_id" id='row_id'>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="email">Message</label>
                                <textarea id="message" name="message" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnAddMessage">Save changes</button>
                </div>
                {!!Form::close()!!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    {!!Html::script('js/Administration/programation.js')!!}
    @endsection