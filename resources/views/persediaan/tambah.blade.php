@extends('template')
@section('title','Tambah Data Bahan Baku')
@section('content')
<div class="container-xxl" style="min-height: 600px">
    <div class="d-flex justify-content-md-start mb-2">
        @if (session('log'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ session('log') }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if (session('err'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal !</strong> {{ session('err') }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>
    <div class="card shadow">
        <div class="card-header">
            <div class="d-flex justify-content-start mb-2">
                <div class="flex-grow-1">
                    <a href="/persediaan/bahan" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
                    <a href="/persediaan/bahan/a" class="btn btn-warning btn-sm " title="Refresh"><i class="bi bi-arrow-clockwise"></i></a>
                    
                    <a href="/persediaan/e" class="btn btn-info btn-sm" title="Data Karyawan"><i class="bi bi-person"></i></a>
                </div>
                <div class="date">
                    <p class="mb-0">{{ date("d-M-Y")}}</p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="card-title mb-2 text-center " ><strong>Tambah Data Persediaan</strong></h3>
                    <form action="/persediaan/bahan/a" id="formTambahBahan" method="POST" class="form">
                        @csrf
                        <div class="mb-3">
                            <label for="namaBahan" class="form-label">Bahan Baku</label>
                            <input type="text" name="nama_bahan_baku" id="namaBahan" placeholder="nama bahan baku" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <select name="satuan" class="form-select" id="satuan">
                                <option selected>...Pilih Satuan...</option>
                                <option value="Kg">Kg</option>
                                <option value="Buah">Buah</option>
                                <option value="Lusin">Lusin</option>
                                <option value="Gram">Gram</option>
                                <option value="Liter">Liter</option>
                                <option value="Dus">Dus</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="hargaSatuan" class="form-label">Harga Satuan</label>
                            <div class="input-group">
                                <span class="input-group-text" id="text-harga" >Rp. </span>
                                <input type="number" name="harga_satuan" id="hargaSatuan" aria-describedby="text-harga" placeholder="200.000" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="jumlahBahan" class="form-label">Jumlah / Stok</label>
                            <div class="input-group">
                                <span class="input-group-text" id="text-jumlah-satuan" >Per Satuan</span>
                                <input type="number" name="stok" id="jumlahBahan" aria-describedby="text-jumlah-satuan" placeholder="20" class="form-control">
                            </div>
                        </div>
                        <div class="mb-2">
                            <a href="/persediaan/bahan" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Batalkan</a>
                            <button type="submit" class="btn btn-outline-success">Ajukan Perbelanjaan <i class="bi bi-arrow-right"></i> </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        ddocument.getElementById('jumlahBahan').addEventListener('input',(e)=>{
            var formData = new FormData(document.getElementById('formTambahBahan'));
            const valStok = formData.get('jumlahBahan');
            const valPrice = formData.get('hargaSatuan');
            const valTotal = document.getElementById('hargaBelanja').value = valPrice * valStok;
            
        });
    </script>
</div>

@endsection