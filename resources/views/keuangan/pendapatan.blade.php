@extends('template')
@section('title','Pendapatan')
@section('content')
    <div class="container-xxl" style="min-height:600px">
        @php
            date_default_timezone_set('Asia/Jakarta');
            $today = date('dmy');
        @endphp
        @if ($pemasukan != null)
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/keuangan">Keuangan</a></li>
              <li class="breadcrumb-item active" aria-current="page">Pendapatan</li>
            </ol>
          </nav>
        <div class="row">
            <div class="col-md-12 order-md-1 order-last">
                <div class="d-flex mb-2 justify-content-start align-items-center ">
                    <div class="flex-grow-1">
                        <a href="/keuangan" class="btn btn-outline-primary btn-sm my-1" title="Back"><i class="bi bi-arrow-left"></i></a>
                        <a class="btn btn-outline-success btn-sm my-1" href="/keuangan/pendapatan/add" title="Tambah Data"><i class="bi bi-plus"></i></a>
                        <a href="#" class="btn btn-outline-info btn-sm my-1" title="Export Data Terkini"><i class="bi bi-box-arrow-down"></i></a>
                        <a href="/keuangan/pendapatan/refresh" class="btn my-1 btn-outline-warning btn-sm"><i class="bi bi-arrow-clockwise" data-bs-toggle="tooltip" data-bs-title="merfresh halaman" ></i></a>
                    </div>
                    <form id="formPilihTanggalPemasukan" style="width: 150px" class="form d-flex flex-row mx-2" >
                        <input type="date" name="tanggal_masuk" value="{{isset($tgl) ? $tgl : null}}" id="pilihTanggalPemasukan" class="form-control form-control-sm" >
                    </form>
                    <form id="formPencarian" class="form d-flex flex-row frm-search">
                        <input class="form-control form-control-sm" type="search" name="q" placeholder="ID Pengeluaran, Tujuan Pengeluaran......" id="searchBar">
                    </form>
                    <button class="btn btn-sm" id="btn-search"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('btn-search').addEventListener('click',(e)=>{
                var formData = new FormData(document.getElementById('formPencarian'));
                const query = formData.get('q');
                window.location.href = `/keuangan/pendapatan/q/${query}`
            });
            document.getElementById('pilihTanggalPemasukan').addEventListener('input',(e)=>{
            var formData = new FormData(document.getElementById('formPilihTanggalPemasukan'));
            const inputed = formData.get('tanggal_masuk');
            window.location.href = `/keuangan/pendapatan/tanggal_masuk/${inputed}`;
          })
      </script>
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
        
        
        <div class="table-responsive small">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <th scope="col" >#</th>
                    <th scope="col" >Id Pemasukan</th>
                    <th scope="col" >Sumber Pemasukan</th>
                    <th scope="col" >Tanggal Masuk</th>
                    <th scope="col" >Jumlah</th>
                    <th scope="col" >Keterangan</th>
                </thead>
                <tbody>
                        @php
                            $jml = 0;
                            $count = 0;
                        @endphp
                        @foreach ($pemasukan as $item)
                            <tr>
                                <td>{{$count+=1}}</td>
                                <td>
                                    <a href="#" data-bs-target="#myModal" data-bs-toggle="modal" 
                                    onclick="tampilModal('pendapatan',['{{$item->id_pemasukan}}',
                                    '{{$item->sumber_pemasukan}}','{{$item->tanggal_masuk}}','{{$item->jumlah}}','{{$item->keterangan}}','{{$item->id}}','Data Pemasukan','Apa yang ingin anda lakukan dengan data ini?'])" 
                                    style="text-decoration: none">{{$item->id_pemasukan}}
                                </a>
                                </td>
                                <td>{{$item->sumber_pemasukan}}</td>
                                <td>{{$item->tanggal_masuk}}</td>
                                <td>Rp. {{ number_format($item->jumlah)}}</td>
                                <td>{{$item->keterangan}}</td>
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
                            <td colspan="4" >Total Pemasukan</td>
                            <td colspan="2" >Rp. {{ number_format($jml)}}</td>
                        </tr>
                </tbody>
            </table>
        </div>
        @if ($tgl == null)
            {{$pemasukan->links("pagination::bootstrap-5")}}
        @endif
        @elseif ($edit != null)
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/keuangan">Keuangan</a></li>
              <li class="breadcrumb-item"><a href="/keuangan/pendapatan">Pendapatan</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
        <h4>Edit Data</h4>
        <hr>
        <div class="table-responsive small">
            <table class="table table-borderless table-sm">
                <tbody>
                    <form action="/keuangan/pendapatan/edit" method="POST" class="form">
                        @csrf                        
                        <tr>
                            <th scope="row" >Id Pendapatan</th>
                            <td>:</td>
                            <td>
                                <input type="text" name="idPemasukanLama" placeholder="contoh : ds_1023270001 " class="form-control form-control-sm" hidden value="{{$edit->id_pemasukan}}" id="idPemasukanLama">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">{{substr($edit->id_pemasukan, 0, -4)}}</span>
                                    <input type="text" name="idPemasukan" placeholder="0001 " id="idPemasukan" value="{{substr($edit->id_pemasukan, -4)}}" class="form-control form-control-sm" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" >Sumber Pemasukan</th>
                            <td>:</td>
                            <td><input type="text" name="sumberPemasukan" placeholder="Sumber Dana" value="{{$edit->sumber_pemasukan}}" class="form-control form-control-sm" id="sumberPemasukan"></td>
                        </tr>
                        <tr>
                            <th scope="row" >Tanggal Masuk</th>
                            <td>:</td>
                            <td><input type="date" name="tanggalPemasukan" value="{{$edit->tanggal_masuk}}" class="form-control form-control-sm" id="tanggalPemasukan"></td>
                        </tr>
                        <tr>
                            <th scope="row" >Jumlah</th>
                            <td>:</td>
                            <td><input type="number" name="jumlahPemasukan" placeholder="Rp. 5000000" value="{{$edit->jumlah}}" class="form-control form-control-sm" id="jumlahPemasukan"></td>
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
                                <a href="/keuangan/pendapatan" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-outline-success">Simpan</button>
                            </td>
                        </tr>
                       
                    </form>
                </tbody>
            </table>
        </div>
        
        @else
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/keuangan">Keuangan</a></li>
              <li class="breadcrumb-item"><a href="/keuangan/pendapatan">Pendapatan</a></li>
              <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
            <h4>Tambah Data</h4>
            <hr>
            <div class="table-responsive small">
                <table class="table table-borderless table-sm">
                    <tbody>
                        <form action="/keuangan/pendapatan/add" method="POST" class="form">
                            @csrf
                            <tr>
                                <th scope="row" >Id Pendapatan</th>
                                <td>:</td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1" >{{ auth()->user()->kode_cabang }}_{{ $today }}</span>
                                        <input type="text" name="idPemasukan" aria-describedby="basic-addon1" placeholder="contoh : 0001 " class="form-control form-control-sm" id="idPemasukan">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" >Sumber Pemasukan</th>
                                <td>:</td>
                                <td><input type="text" name="sumberPemasukan" placeholder="Sumber Dana" class="form-control form-control-sm" id="sumberPemasukan"></td>
                            </tr>
                            <tr>
                                <th scope="row" >Tanggal Masuk</th>
                                <td>:</td>
                                <td><input type="date" name="tanggalPemasukan" class="form-control form-control-sm" id="tanggalPemasukan"></td>
                            </tr>
                            <tr>
                                <th scope="row" >Jumlah</th>
                                <td>:</td>
                                <td><input type="number" name="jumlahPemasukan" placeholder="Rp. 5000000" class="form-control form-control-sm" id="jumlahPemasukan"></td>
                            </tr>
                            <tr>
                                <th scope="row" >Keterangan</th>
                                <td>:</td>
                                <td><input type="text" placeholder="catatan" name="keterangan" class="form-control form-control-sm" id="keterangan"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href="/keuangan/pendapatan" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Batal</a>
                                    <button type="submit" class="btn btn-outline-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                            <path d="M11 2H9v3h2V2Z"/>
                                            <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0ZM1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5Zm3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4v4.5ZM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5V15Z"/>
                                          </svg>
                                          Simpan
                                    </button>
                                </td>
                            </tr>
                        </form>
                    </tbody>
                </table>
            </div>
            @if (session('log'))
                {{session('log')}}
            @endif
        @endif
    </div>
@endsection