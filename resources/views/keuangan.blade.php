@extends('template')
@section('title','Keuangan')
@section('content')
    <div class="container-xxl" style="min-height:600px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">Keuangan</li>
            </ol>
          </nav>
        <div class="d-flex justify-content-md-start flex-wrap">
            <div class="card mx-2 mb-2 card-hover" id="card_link" style="width:300px" onclick="card_link('keuangan/pendapatan')" >
                <img class ="card-img-top" src="{{asset('/image/calculator-1680905_1280.jpg')}}" alt="">
                <div class="card-body">
                    <h5 class="text-center card-title">Pendapatan</h5>
                </div>
            </div>
            <div class="card mx-2 mb-2 card-hover" id="card_link" style="width:300px" onclick="card_link('keuangan/pengeluaran')" >
                <img class="card-img-top " src="{{asset('/image/receipts-4542292_1280.jpg')}}" alt="">
                <div class="card-body">
                    <h5 class="card-title text-center">Pengeluaran</h5>
                </div>
            </div>
            <div class="card mx-2 mb-2 card-hover" id="card_link" style="width:300px" onclick="card_link('keuangan/laporan')" >
                <img class="card-img-top " src="{{asset('/image/accounting-761599_1280.jpg')}}" alt="">
                <div class="card-body">
                    <h5 class="card-title text-center">Laporan Laba / Rugi</h5>
                </div>
            </div>
        </div>
    </div>
@endsection