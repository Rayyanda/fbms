@extends('template')
@section('title','Inventaris')
@section('content')
    <div class="container-xxl" style="min-height:600px">
        <div class="d-flex justify-content-md-start flex-wrap">
            <div class="card mx-2 mb-2 card-hover" id="card_link" style="width:300px" onclick="card_link('inventaris/data')" >
                <img class ="card-img-top" src="{{asset('/image/calculator-1680905_1280.jpg')}}" alt="">
                <div class="card-body">
                    <h5 class="text-center card-title">Inventaris</h5>
                </div>
            </div>
        </div>
    </div>
@endsection