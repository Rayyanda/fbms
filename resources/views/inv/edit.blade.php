@extends('template')
@section('title','Edit Data Inventaris')
@section('content')
    <div class="container-xxl" style="min-height:600px">
        <div class="row">
            <div class="col-md-12">
                <a href="/inventaris/data" class="btn btn-outline-primary"><i class="bi bi-arrow-left"></i> Kembali</a>
                @if ($edit != null)
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="card-title bg-auto mb-0 d-flex align-items-center">
                            <svg class="bi" ><use xlink:href="#pencil-square"/></svg>  
                            Edit Data
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="" class="form row p-3">
                            <div class="col-md-12">
                                <h4 class="fw-bold">Detail Inventaris</h4>
                                <div class="row mb-2">
                                    <label for="namaInv" class="col-form-label col-sm-3 fw-bold">Nama Inventaris</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="nama_inventaris" value="{{$edit->nama_inventaris}}" id="namaInv" class="form-control">
                                    </div>
                                    <label for="jenisInv" class="col-form-label col-sm-3 fw-bold">Jenis Inventaris</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="jenis_inventaris" value="{{$edit->jenis_inventaris}}" id="jenisInv" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="satuanInv" class="col-form-label col-sm-3 fw-bold">Satuan</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="satuan" id="satuanInv" value="{{$edit->satuan}}" class="form-control">
                                    </div>
                                    <label for="hargaInv" class="col-form-label col-sm-3 fw-bold">Harga Satuan</label>
                                    <div class="col-sm-3">
                                        <input type="number" name="harga_satuan" id="hargaInv" value="{{ $edit->harga_satuan}}" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="stokMinimum" class="col-form-label col-sm-3 fw-bold">Stok Minimum</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="stok_minimum" id="stokMinimum" value="{{$edit->stok_minimum}}" class="form-control">
                                    </div>
                                    <label for="stokMaksimum" class="col-form-label col-sm-3 fw-bold">Stok Maksimum</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="stok_maksimum" id="stokMaksimum" value="{{$edit->stok_maksimum}}" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-success"> <i class="bi bi-save"></i> Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                <div class="alert alert-primary" role="alert">
                    Data Tidak Ditemukan, Silahkan kembali
                    <a href="/inventaris">Kembali</a>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection