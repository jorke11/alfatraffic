@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Tangerine" rel="stylesheet">
<style>
    .pacifico{
        font-family: 'Pacifico', cursive;font-size: 28px
    }
    .indie{
        font-family: 'Indie Flower', cursive;font-size: 28px
    }
    .dancing{
        font-family: 'Dancing Script', cursive;font-size: 28px
    }
    .tangerine{
        font-family: 'Tangerine', cursive;;font-size: 28px
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8" >
            <iframe width="100%" src="http://localhost:8080/clients/pdf/{{$row_id}}" height="100%">

            </iframe>
        </div>
        <div class="col-lg-4">
            <div class="row row-space">
                <div class="col-lg-12">
                    <button class="btn btn-success">Add Sign</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="radio" id="sign" name="digital">Sign
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12" >
                                    <canvas style="border: 1px solid #000;width: 100%" id="canvas" style="display:block;" disabled>
                                        Problemas
                                    </canvas>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="radio" id="digital" name="digital" >Digital
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Font</label>
                                        <select id="type_form" class="form-control" disabled="">
                                            <option value="0">Selection</option>
                                            <option value="1" class="pacifico">your Sign ex 1</option>
                                            <option value="2" class="indie">your Sign ex 2</option>
                                            <option value="3" class="dancing">your Sign ex 3</option>
                                            <option value="4" class="tangerine">your Sign ex 4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Preview</label>
                                        <input type="text" id="name_preview" name="name_preview" class="form-control input-lg" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{!!Html::script('js/Purchase/Receipt.js')!!}
@endsection