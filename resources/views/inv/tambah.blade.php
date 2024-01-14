@extends('template')
@section('title','Data Bahan Baku')
@section('content')
<div class="container-xxl" style="min-height: 600px">
    <div class="d-flex justify-content-start mb-2">
        <div class="flex-grow-1">
            <a href="/persediaan" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
            <a href="/persediaan/bahan/refresh" class="btn btn-warning btn-sm " title="Refresh"><i class="bi bi-arrow-clockwise"></i></a>
            <a href="/persediaan/a" class="btn btn-success btn-sm" title="Tambah Data"><i class="bi bi-plus"></i></a>
            <a href="/persediaan/e" class="btn btn-info btn-sm" title="Data Karyawan"><i class="bi bi-person"></i></a>
        </div>
        <div class="date">
            <p class="mb-0">{{ date("d-M-Y")}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-5 shadow">
                <div class="card-body">
                    <h3><strong>Tambah Data Persediaan</strong></h3>
                    <form action="" method="POST" class="form">
                        @csrf
                        <div class="flex flex-row justify-content-between align-items-center">
                            <label for="namaBahan" class="form-label">Bahan Baku</label>
                            <input type="text" name="nama_bahan_baku" id="namaBahan" class="form-control">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection