@extends('template')
@section('title','Karyawan')
@section('content')
    <div class="container-xxl" style="min-height:600px">
        <div class="d-flex flex-wrap justify-content-md-start">
            <div class="card mx-2 mb-4 card-hover" id="card_link"  onclick="card_link('karyawan/d')" >
                <img class ="card-img-top" src="{{asset('/image/freelance-4071263_1280.png')}}" alt="">
                <div class="card-body">
                    <h5 class="card-title text-center">Data Karyawan</h5>
                </div>
            </div>
            <div class="card mx-2 mb-4 card-hover" id="card_link"  onclick="card_link('karyawan/a')" >
                <img class="card-img-top " src="{{asset('/image/career-3478983_1280.jpg')}}" alt="">
                <div class="card-body">
                    <h5 class="card-title text-center">Tambah Karyawan</h5>
                </div>
            </div>
            <div class="card mx-2 mb-4 card-hover" id="card_link" onclick="card_link('karyawan/e')" >
                <img class="card-img-top " src="{{asset('/image/laptop-3196481_1280.jpg')}}" alt="">
                <div class="card-body">
                    <h5 class="card-title text-center">Edit Data Karyawan</h5>
                </div>
            </div>
            <div class="card mx-2 mb-4 card-hover" id="card_link" onclick="card_link('karyawan/absensi')" >
                <img class="card-img-top " src="{{asset('/image/survey-3957027_1280.jpg')}}" alt="">
                <div class="card-body">
                    <h5 class="card-title text-center">Absensi Karyawan</h5>
                </div>
            </div>
            <div class="card mx-2 mb-4 card-hover" id="card_link" onclick="card_link('karyawan/penggajian')" >
                <img class="card-img-top " src="{{asset('/image/survey-3957027_1280.jpg')}}" alt="">
                <div class="card-body">
                    <h5 class="card-title text-center">Penggajian Karyawan</h5>
                </div>
            </div>
        </div>
    </div>
@endsection