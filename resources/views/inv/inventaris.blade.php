@extends('template')
@section('title','Inventaris')
@section('content')
<div class="container-xxl" style="min-height: 600px">
    <div class="row">
        <div class="col-md-12 order-md-1 order-last">
            @if ($inventaris == null)
            <div class="alert alert-primary" role="alert">
                Ada yang salah dengan Query URL Anda.
                <a href="/inventaris/data">kembali</a>
              </div>
            @else
                
            
            <div class="d-flex mb-2 justify-content-start align-items-center ">
                <div class="flex-grow-1">
                    <a href="/inventaris" class="btn btn-outline-primary btn-sm my-1" title="Back"><i class="bi bi-arrow-left"></i></a>
                    <a class="btn btn-outline-success btn-sm my-1" href="/inventaris/a" title="Tambah Data"><i class="bi bi-plus"></i></a>
                    <a href="#" class="btn btn-outline-info btn-sm my-1" title="Export Data Terkini"><i class="bi bi-box-arrow-down"></i></a>
                    <a href="/inventaris/data/refresh" class="btn my-1 btn-outline-warning btn-sm"><i class="bi bi-arrow-clockwise" data-bs-toggle="tooltip" data-bs-title="merfresh halaman" ></i></a>
                </div>
                <form id="formPilihTanggal" style="width: 150px" class="form d-flex flex-row mx-2" >
                    <input type="date" name="tanggal" value="{{ isset($tgl) ? $tgl : null }}" id="pilihTanggalPengeluaran" class="form-control form-control-sm" >
                </form>
                <form action="/keuangan/pengeluaran?q" method="GET" class="form d-flex flex-row frm-search">
                    <input class="form-control form-control-sm" type="search" name="q" placeholder="ID Pengeluaran, Tujuan Pengeluaran......" id="searchBar">
                    <button class="btn btn-sm"><i class="bi bi-search"></i></button>
                </form>
            </div>
            <div class="table-responsive small">
                <table class="table table-bordered table-striped table-sm">
                    <thead class="text-center">
                        <th>#</th>
                        <th>Kode Inventaris</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Stok Minimum</th>
                        <th>Stok Maksimum</th>
                        <th>Lokasi</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody class="text-center">
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($inventaris as $item)
                        <tr>
                            <td>{{ $count+=1 }}</td>
                            <td>{{ $item->id_inventaris }}</td>
                            <td>{{$item->nama_inventaris}}</td>
                            <td>{{$item->jenis_inventaris}}</td>
                            <td>{{$item->satuan}}</td>
                            <td>Rp. {{number_format($item->harga_satuan,0)}}</td>
                            <td>{{$item->stok_minimum}}</td>
                            <td>{{$item->stok_maksimum}}</td>
                            <td>{{$item->lokasi_penyimpanan}}</td>
                            <td>{{$item->kondisi}}</td>
                            <td>
                                <div class="d-flex justify-content-sm-between">
                                    <a href="/inventaris/edit/id/{{$item->id_inventaris}}" title="Edit Data"><i class="bi bi-pencil"></i></a>
                                    <a href="" title="Hapus Data"><i class="bi bi-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection