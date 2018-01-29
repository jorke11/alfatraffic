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
            <iframe id="iframe" width="100%" src="{{url("clients/pdf/".$row_id)}}" height="800px">

            </iframe>
            <input type="hidden" id="purchase_id" value="{{$row_id}}">
        </div>
        <div class="col-lg-4">
            <div class="row row-space">
                <div class="col-lg-3">
                    <button class="btn btn-info" type="button" id="btnAdd">Preview</button>
                </div>
                <div class="col-lg-4">
                    <button class="btn btn-success" type="button" id="btnSend">Send Receipt</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="radio" id="sign" name="digital"><a href="#"  onclick="obj.selectedOption('sign');return false;">Sign</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1" >
                                    <canvas style="border: 1px solid #000;width: 100%" id="canvas" style="display:block;" disabled>
                                        Problemas
                                    </canvas>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="radio" id="digital" name="digital" ><a href="#" onclick="obj.selectedOption('digital');return false;">Digital</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" id="text_sign" name="text_sign" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Font</label>
                                        <select id="type_font" class="form-control" disabled="">
                                            <option value="0">Selection</option>
                                            <option value="pacifico" class="pacifico">your Sign ex 1</option>
                                            <option value="indie" class="indie">your Sign ex 2</option>
                                            <option value="dancing" class="dancing">your Sign ex 3</option>
                                            <option value="tangerine" class="tangerine">your Sign ex 4</option>
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