@extends('template')
@section('title','Pengeluaran')
@section('content')
    <div class="container-xxl" style="min-height: 600px">
        @php
            date_default_timezone_set('Asia/Jakarta');
            $today = date('dmy');
        @endphp
        <!-- Page title -->
        <div class="row">
            @if ($pengeluaran != null)
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/keuangan">Keuangan</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Pengeluaran</li>
                </ol>
            </nav>
            <div class="col-md-12 order-md-1 order-last">
                <div class="d-flex mb-2 justify-content-start align-items-center ">
                    <div class="flex-grow-1">
                        <a href="/keuangan" class="btn btn-outline-primary btn-sm my-1" title="Back"><i class="bi bi-arrow-left"></i></a>
                        <a class="btn btn-outline-success btn-sm my-1" href="/keuangan/pengeluaran/add" title="Tambah Data"><i class="bi bi-plus"></i></a>
                        <a href="#" class="btn btn-outline-info btn-sm my-1" title="Export Data Terkini"><i class="bi bi-box-arrow-down"></i></a>
                        <a href="/keuangan/pengeluaran/refresh" class="btn my-1 btn-outline-warning btn-sm"><i class="bi bi-arrow-clockwise" data-bs-toggle="tooltip" data-bs-title="merfresh halaman" ></i></a>
                        <a href="/keuangan/laporan" class="btn btn-sm btn-outline-info" title="Laporan Keuangan"><i class="bi bi-file"></i></a>
                    </div>
                    <form id="formPilihTanggal" style="width: 150px" class="form d-flex flex-row mx-2" >
                        <input type="date" name="tanggal" value="{{ isset($tgl) ? $tgl : null }}" id="pilihTanggalPengeluaran" class="form-control form-control-sm" >
                    </form>
                    <form action="/keuangan/pengeluaran?q" method="GET" class="form d-flex flex-row frm-search">
                        <input class="form-control form-control-sm" type="search" name="q" placeholder="ID Pengeluaran, Tujuan Pengeluaran......" id="searchBar">
                        <button class="btn btn-sm"><i class="bi bi-search"></i></button>
                    </form>
                </div>
                <div class="mb-2">
                    @if (session('log'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{session('log')}}.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if (session('err'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal !</strong> {{session('err')}}.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                </div>
                <div class="table-responsive small">
                    <table class="table table-sm table-striped table-bordered" id="example">
                        <thead>
                            <th scope="row" >
                                <div class="d-flex justify-content-center align-items-center">
                                    <p class="mb-0">#</p>
                                </div>
                            </th>
                            <th class="" >
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0" >ID Pengeluaran</p>
                                    <button id="sortId" class="btn btn-sm" onclick="btn_sort('keuangan/pengeluaran/sort/id_pengeluaran')" ><i class="bi bi-arrow-down-up"></i></button>
                                </div>
                            </th>
                            <th  class="" >
                                <div class="d-flex justify-content-between align-items-center">

                                    <p class="mb-0">Tujuan Pengeluaran</p>
                                    <button class="btn btn-sm" onclick="btn_sort('keuangan/pengeluaran/sort/tujuan_pengeluaran')"><i class="bi bi-arrow-down-up"></i></button>
                                </div>
                            </th>
                            <th scope="row" >
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0">Tanggal</p>
                                    <button class="btn btn-sm" onclick="btn_sort('keuangan/pengeluaran/sort/tanggal')" ><i class="bi bi-arrow-down-up"></i></button>
                                </div>
                            </th>
                            <th scope="row" >
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0">Jumlah</p>
                                    <button class="btn btn-sm" onclick="btn_sort('keuangan/pengeluaran/sort/jumlah')" ><i class="bi bi-arrow-down-up"></i></button>
                                </div>
                            </th>
                            <th scope="row" >
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0">Keterangan</p>
                                    <button class="btn btn-sm" onclick="btn_sort('keuangan/pengeluaran/sort/keterangan')" ><i class="bi bi-arrow-down-up"></i></button>
                                </div>
                            </th>
                        </thead>
                        @php
                            $count=0;
                            $jml = 0;
                        @endphp
                        <tbody>
                            @foreach ($pengeluaran as $item)
                                <tr>
                                    <td class="text-center" >{{ $count+=1 }}</td>
                                    <td class="text-center" >
                                        <a href="#" href="#" data-bs-target="#myModal" data-bs-toggle="modal" 
                                        onclick="tampilModal('pengeluaran',['{{$item->id_pengeluaran}}',
                                        '{{$item->tujuan_pengeluaran}}','{{$item->tanggal}}','{{$item->jumlah}}','{{$item->keterangan}}','{{$item->id}}','Data Pengeluaran','Apa yang ingin anda lakukan dengan data ini?'])" 
                                        style="text-decoration: none">
                                            {{ $item->id_pengeluaran}}
                                        </a>
                                    </td>
                                    <td>{{ $item->tujuan_pengeluaran }}</td>
                                    <td class="text-center" >{{ $item->tanggal }}</td>
                                    <td class="text-center" >Rp. {{ number_format($item->jumlah) }}</td>
                                    <td class="text-center" >{{ $item->keterangan  }}</td>
                                    @php
                                        $jml += $item->jumlah;
                                    @endphp
                                </tr>
                            @endforeach
                            @if ($count > 0)
                            <tr>
                                <td colspan="4" class="text-center">Rata-Rata</td>
                                <td colspan="2">
                                    Rp. {{number_format($jml/$count)}}
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="4" class="text-center">
                                    Total Pengeluaran
                                </td>
                                <td colspan="2" class="text-center" >
                                    Rp. {{ number_format($jml) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                {{$pengeluaran->links("pagination::bootstrap-5")}}
            </div>
            <script>
                  document.getElementById('pilihTanggalPengeluaran').addEventListener('input',(e)=>{
                  var formData = new FormData(document.getElementById('formPilihTanggal'));
                  const inputed = formData.get('tanggal');
                  window.location.href = `/keuangan/pengeluaran/tanggal/${inputed}`;
                })
            </script>
            @elseif($edit != null)
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/keuangan">Keuangan</a></li>
                  <li class="breadcrumb-item"><a href="/keuangan/pengeluaran">Pengeluaran</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <div class="col-md-12 order-md-1 order-last">
                <h4> <i class="bi bi-setting"></i> Edit Data Pengeluaran</h4>
                <hr>
                <div class="table-responsive small">
                    <table class="table table-borderless table-sm">
                        <tbody>
                            <form action="/keuangan/pengeluaran/edit" method="POST" class="form">
                                @csrf                        
                                <tr>
                                    <th scope="row" >Id Pengeluaran</th>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="idPengeluaranLama" placeholder="contoh : ds_1023270001 " class="form-control form-control-sm" hidden value="{{$edit->id_pengeluaran}}" id="idPemasukanLama">
                                        <input type="text" name="idPengeluaran" placeholder="contoh : ds_1023270001 " class="form-control form-control-sm" value="{{$edit->id_pengeluaran}}" id="idPemasukan">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" >Tujuan Pengeluaran</th>
                                    <td>:</td>
                                    <td><input type="text" name="tujuan_pengeluaran" placeholder="Sumber Dana" value="{{$edit->tujuan_pengeluaran}}" class="form-control form-control-sm" id="sumberPemasukan"></td>
                                </tr>
                                <tr>
                                    <th scope="row" >Tanggal</th>
                                    <td>:</td>
                                    <td><input type="date" name="tanggal" value="{{$edit->tanggal}}" class="form-control form-control-sm" id="tanggalPemasukan"></td>
                                </tr>
                                <tr>
                                    <th scope="row" >Jumlah</th>
                                    <td>:</td>
                                    <td><input type="number" name="jumlah" placeholder="Rp. 5000000" value="{{$edit->jumlah}}" class="form-control form-control-sm" id="jumlahPemasukan"></td>
                                </tr>
                                <tr>
                                    <th scope="row" >Keterangan</th>
                                    <td>:</td>
                                    <td><input type="text" placeholder="catatan" name="keterangan" value="{{$edit->keterangan}}" class="form-control form-control-sm" id="keterangan"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <a href="/keuangan/pengeluaran" class="btn btn-outline-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-outline-success">Simpan</button>
                                    </td>
                                </tr>
                               
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/keuangan">Keuangan</a></li>
                  <li class="breadcrumb-item"><a href="/keuangan/pengeluaran">Pengeluaran</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                </ol>
            </nav>
            <div class="col-md-12 order-md-1 order-last">
                <h4>Tambah Data Pengeluaran</h4>
                <hr>
                <p class="fw-light"><i class="bi bi-info-circle"></i> Pastikan untuk tidak menginputkan <strong>ID</strong> yang duplikat</p>
                <div class="table-responsive small">
                    <table class="table table-borderless table-sm">
                        <tbody>
                            <form action="/keuangan/pengeluaran/add" method="POST" class="form">
                                @csrf                        
                                <tr>
                                    <th scope="row" >Id Pengeluaran</th>
                                    <td>:</td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1" >{{ auth()->user()->kode_cabang }}_{{ $today }}</span>
                                            <input type="text" name="idPengeluaran" aria-describedby="basic-addon1" placeholder="contoh : 0001 " class="form-control form-control-sm" id="idPengeluaran">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" >Tujuan Pengeluaran</th>
                                    <td>:</td>
                                    <td><input type="text" name="tujuan_pengeluaran" placeholder="Sumber Dana"  class="form-control form-control-sm" id="sumberPemasukan"></td>
                                </tr>
                                <tr>
                                    <th scope="row" >Tanggal</th>
                                    <td>:</td>
                                    <td><input type="date" name="tanggal" class="form-control form-control-sm" id="tanggalPemasukan"></td>
                                </tr>
                                <tr>
                                    <th scope="row" >Jumlah</th>
                                    <td>:</td>
                                    <td><input type="number" name="jumlah" placeholder="Rp. 5000000"  class="form-control form-control-sm" id="jumlahPemasukan"></td>
                                </tr>
                                <tr>
                                    <th scope="row" >Keterangan</th>
                                    <td>:</td>
                                    <td><input type="text" placeholder="catatan" name="keterangan"  class="form-control form-control-sm" id="keterangan"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <a href="/keuangan/pengeluaran" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Batal</a>
                                        <button type="submit" class="btn btn-outline-success btn-sm"><i class="bi bi-plus"></i> Tambah</button>
                                    </td>
                                </tr>
                               
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
            
            @endif
        </div>
        <!-- End of page title -->
        
                                                
    
    </div>

@endsection