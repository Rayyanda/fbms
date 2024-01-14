@extends('template')
@section('title','Persediaan')
@section('content')
    <div class="container-xxl" style="min-height:600px">
        <div class="d-flex justify-content-md-start flex-wrap">
            <div class="card mx-2 mb-2 card-hover" id="card_link" style="width:300px" onclick="card_link('persediaan/bahan')" >
                <img class="card-img-top " src="{{asset('/image/receipts-4542292_1280.jpg')}}" alt="">
                <div class="card-body">
                    <h5 class="card-title text-center">Bahan Baku</h5>
                </div>
            </div>
        </div>
    </div>
@endsection