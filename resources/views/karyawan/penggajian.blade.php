@extends('template')
@section('title','Penggajian Karyawan')
@section('content')
<div class="container-xxl" style="min-height:600px">
    <div class="d-flex justify-content-start mb-2">
        <div class="flex-grow-1">
            <a href="/karyawan" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
            <a href="/karyawan/e/refresh" class="btn btn-warning btn-sm " title="Refresh"><i class="bi bi-arrow-clockwise"></i></a>
            <a href="/karyawan/a" class="btn btn-success btn-sm" title="Tambah Data"><i class="bi bi-plus"></i></a>
            <a href="/karyawan/d" class="btn btn-info btn-sm" title="Data Karyawan"><i class="bi bi-person"></i></a>
        </div>
    </div>
    <hr>
    <div class="d-flex justify-content-md-start mb-2">
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
</div>
@endsection