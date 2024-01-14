@extends('template')
@section('title','Tambah Data Karyawan')
@section('content')
<div class="container-xxl" style="min-height: 600px">
        @php
            date_default_timezone_set('Asia/Jakarta');
            $today = date('Y');
        @endphp
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/karyawan">Karyawan</a></li>
          <li class="breadcrumb-item"><a href="/karyawan/d">Data Karyawan</a></li>
          <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-start mb-2">
        <div class="flex-grow-1">
            <a href="/karyawan" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
            <a href="/karyawan/a/refresh" class="btn btn-warning btn-sm "><i class="bi bi-arrow-clockwise"></i></a>
            <a href="/karyawan/d" class="btn btn-success btn-sm"><i class="bi bi-person"></i></a>
            <a href="/karyawan/e" class="btn btn-info btn-sm" title="Edit Data Karyawan"><i class="bi bi-pencil"></i></a>
        </div>
        @if (session('log'))
          <div class="alert alert-success alert-dimissible fade show" role="alert">
            {{session('log')}}
          </div>
        @endif
    </div>
    <form class="form" action="/karyawan/a/new" method="POST">
        @csrf
        <div class="row mb-3">
          <label for="idKaryawan" class="col-sm-2 col-form-label">ID Karyawan</label>
          <div class="col-sm-10">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">{{auth()->user()->kode_cabang}}-{{$today}}</span>
                <input type="text" class="form-control" id="idKaryawan" name="id_karyawan" placeholder="0001" aria-label="Username" aria-describedby="basic-addon1">
              </div>
          </div>
        </div>
        <div class="row mb-3">
          <label for="noTelp" class="col-sm-2 col-form-label">No. Telp</label>
          <div class="col-sm-10">
            <input type="text" name="no_telp" placeholder="(+62) 234 5678 9101" class="form-control" id="noTelp">
          </div>
        </div>
        <div class="row mb-3">
          <label for="namaLengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
          <div class="col-sm-10">
            <input type="text" name="nama" placeholder="Ray" class="form-control" id="namaLengkap">
          </div>
        </div>
        <div class="row mb-3">
          <label for="alamatKaryawan" class="col-sm-2 col-form-label">Alamat</label>
          <div class="col-sm-10">
            <textarea name="alamat" id="alamatKaryawan" class="form-control" ></textarea>
          </div>
        </div>
        <div class="row mb-3">
          <label for="posisi" class="col-sm-2 col-form-label">Posisi</label>
          <div class="col-sm-10">
            <select class="form-select" id="posisi" name="posisi" aria-label="Default select example">
                <option selected>Open this select menu</option>
                <option value="staff">Staff</option>
                <option value="Kepala Staff">Kepala Staff</option>
              </select>
          </div>
        </div>
        <a href="/karyawan" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Batal</a>
        <button type="submit" class="btn btn-success"><i class="bi bi-person-plus"></i> Simpan</button>
    </form>
</div>
@endsection