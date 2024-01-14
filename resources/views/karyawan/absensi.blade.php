@extends('template')
@section('title','Absensi Karyawan')
@section('content')
<div class="container-xxl" style="min-height: 600px">
    <div class="d-flex justify-content-start mb-2">
        <div class="flex-grow-1">
            <a href="/karyawan" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
            <a href="/karyawan/absensi/refresh" class="btn btn-warning btn-sm " title="Refresh"><i class="bi bi-arrow-clockwise"></i></a>
            <a href="/karyawan/a" class="btn btn-success btn-sm" title="Tambah Data"><i class="bi bi-plus"></i></a>
            <a href="/karyawan/d" class="btn btn-info btn-sm" title="Data Karyawan"><i class="bi bi-person"></i></a>
        </div>
        <div class="date">
            <p class="mb-0">{{ date("d-M-Y")}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3 shadow">
                <div class="card-header">
                    <h5><i class="bi bi-database-gear"></i> Data</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <p class="col-md-3 fw-bold mb-0 text-info">Nama Pengguna</p>
                        <div class="col-md-3 mb-2">{{ auth()->user()->name }}</div>
                        <p class="col-md-3 fw-bold mb-0 text-info">Cabang</p>
                        <div class="col-md-3 mb-2">{{ auth()->user()->cabang }}</div>
                    </div>
                    <div class="row">
                        <p class="col-md-3 fw-bold mb-0 text-info">Email</p>
                        <div class="col-md-3 mb-2">{{ auth()->user()->email }}</div>
                        <p class="col-md-3 fw-bold mb-0 text-info">Total Karyawan</p>
                        <div class="col-md-3 mb-2">{{ auth()->user()->kode_cabang }}</div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="/karyawan/absensi/rekap" title="Rekap Absensi" class="btn btn-primary btn-sm"><i class="bi bi-database"></i></a>
                    <a href="/karyawan/absensi/i" class="btn btn-success btn-sm"><i class="bi bi-person-add"></i></a>
                    <a href="/karyawan/absensi/persentase" title="Lihat Persentase" class="btn btn-warning btn-sm"><i class="bi bi-person-check-fill"></i></a>
                </div>
            </div>
        </div>
    </div>
    @if (session('log'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bi bi-info-circle-fill"></i> {{session('log')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if ($data != null)
    <div class="table-responsive small">
        <table class="table table-sm table-bordered table-striped">
            <thead>
                <th>#</th>
                <th>ID Karyawan</th>
                <th>Nama Lengkap</th>
                <th>Posisi</th>
                <th>Tanggal Absen</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
            </thead>
            <tbody>
                @php
                    $count = 0;
                @endphp
                @if (count($data) > 0)
                    @foreach ($data as $item)
                        <tr>
                            <td>{{$count+=1}}</td>
                            <td>{{$item->id_karyawan}}</td>
                            <td>{{$item->nama}}</td>
                            <td>{{$item->posisi}}</td>
                            <td>{{$item->tanggal}}</td>
                            <td>{{$item->jam_masuk}}</td>
                            <td>{{$item->jam_keluar}}</td>
                            <td>{{$item->status}}</td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td class="text-center" colspan="8">Belum ada yang mengisi absensi hari ini</td>
                </tr>
                @endif
            </tbody>
        </table>        
    </div>
    @elseif($rekap != null)
    <div class="d-flex mb-2 justify-content-start align-items-center ">
        <div class="flex-grow-1">
            <p class="fw-light"><i class="bi bi-info-circle"></i> Anda bisa kembali ke halaman absensi hari ini dengan mengklik tombol refresh</p>
        </div>
        <form action="" id="formPilihBulan" class="mx-1">
            <input type="month" placeholder="Pilih Bulan" value="{{isset($tgl) ? $tgl : null}}" name="bulan" id="pilihBulan" class="form-control form-control-sm">
        </form>
        <form action="" class="form" style="width: 180px" id="formPilihNamaKaryawan">
            <select name="nama" required aria-label="Small select example" id="pilihNamaKaryawan" class="form-control form-control-sm">
                <option selected >{{ isset($nama) ? $nama : "Pilih Karyawan...." }}</option>
                @foreach ($data_kr as $item)
                <option value="{{$item->nama}}">{{$item->nama}}</option>
                @endforeach
            </select>
        </form>
        <form id="formPilihTanggalAbsen" style="width: 250px" title="Tanggal Absen" class="form d-flex flex-row mx-2" >
            <input type="date" name="tanggal" value="{{isset($tgl) ? $tgl : null}}" id="pilihTanggalAbsen" class="form-control form-control-sm" >
        </form>
    </div>
    <div class="table-responsive small">
        <table class="table table-sm table-bordered table-striped">
            <thead class="text-center">
                <th>#</th>
                <th>ID Karyawan</th>
                <th>Nama Lengkap</th>
                <th>Posisi</th>
                <th>Tanggal Absen</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                @php
                    $count = 0;
                    date_default_timezone_set('Asia/Jakarta');
                    $today = date('Y-m-d');
                    $token = request()->cookie('XSRF-TOKEN');
                @endphp
                @foreach ($rekap as $item)
                <tr>
                    <td>{{$count+=1}}</td>
                    <td>{{$item->id_karyawan}}</td>
                    <td>{{$item->nama}}</td>
                    <td>{{$item->posisi}}</td>
                    <td>{{$item->tanggal}}</td>
                    <td>{{$item->jam_masuk}}</td>
                    <td>{{$item->jam_keluar}}</td>
                    <td>{{$item->status}}</td>
                    <td>
                        <div class="d-flex justify-content-{{$item->jam_keluar == "" ? "between" : "center"}} align-items-center">
                            @if ($item->jam_keluar == "")
                            <a href="/karyawan/absensi/rekap/{{$item->id_absensi}}" title="Edit" 
                                
                                class="text-decoration-none "><i class="bi bi-pencil"></i></a>
                            @endif
                            <a data-bs-toggle="modal" data-bs-target="#mySecondModal" onclick="tampilSecondModal('hapusRekapAbs',['{{$item->id_absensi}}','{{$item->nama}}-{{$item->tanggal}}'])"  title="Hapus" class="text-decoration-none"><i class="bi bi-trash"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>        
    </div>
    @if (count($rekap) > 9)
        
    @endif
    {{$rekap->links("pagination::bootstrap-5")}}
    <script>
        document.getElementById('pilihTanggalAbsen').addEventListener('input',(e)=>{
        var formData = new FormData(document.getElementById('formPilihTanggalAbsen'));
        const inputed = formData.get('tanggal');
        window.location.href = `/karyawan/absensi/rekap/${inputed}`;
      });
        document.getElementById('pilihNamaKaryawan').addEventListener('input',(e)=>{
        var formData = new FormData(document.getElementById('formPilihNamaKaryawan'));
        const inputed = formData.get('nama');
        window.location.href = `/karyawan/absensi/rekap/${inputed}`;
      });
        document.getElementById('pilihBulan').addEventListener('input',(e)=>{
        var formData = new FormData(document.getElementById('formPilihBulan'));
        const inputed = formData.get('bulan');
        window.location.href = `/karyawan/absensi/rekap/${inputed}`;
      });
  </script>
    @elseif($persentase != null)
    <div class="d-flex mb-2 justify-content-start align-items-center ">
        <div class="flex-grow-1">
            <p class="fw-light"><i class="bi bi-info-circle"></i> Anda bisa kembali ke halaman absensi hari ini dengan mengklik tombol refresh</p>
        </div>
        <form action="" id="formPilihBulan" class="mx-1">
            <input type="month" placeholder="Pilih Bulan" value="{{isset($tgl) ? $tgl : null}}" name="bulan" id="pilihBulan" class="form-control form-control-sm">
        </form>
    </div>
    <div class="responsive-table">
        <table class="table table-bordered table-striped">
            <thead>
                <th>#</th>
                <th>ID Karyawan</th>
                <th>Nama Lengkap</th>
                <th>Posisi</th>
                <th>Jumlah Kehadiran</th>
                <th>Persentase Kehadiran</th>
            </thead>
            <tbody>
                @php
                    $count = 0;
                    $jml_bulan = cal_days_in_month(CAL_GREGORIAN, date('m'),date('Y'));
                @endphp
                @foreach ($persentase as $item)
                <tr>
                    <td>{{$count+=1}}</td>
                    <td>{{$item->id_karyawan}}</td>
                    <td>{{$item->nama}}</td>
                    <td>{{$item->posisi}}</td>
                    <td class="text-center" >{{ round(($item->JumlahAbsensi * $jml_bulan)/100)}} / {{$jml_bulan}}</td>
                    <td>
                        <div class="progress" role="progressbar" aria-label="Info example" aria-valuenow="{{$item->JumlahAbsensi}}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-info text-white" style="width: {{  round($item->JumlahAbsensi)}}%">{{ round($item->JumlahAbsensi)}}%</div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <p class="d-inline-flex gap-1">
        <a class="btn btn-primary btn-sm" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
            <i class="bi bi-question-circle"></i>
        </a>
    </p>
    <div class="collapse mb-3" id="collapseExample">
        <div class="card card-body">
            <p class="fw-bold mb-0">Info</p>
            <hr>
            <p class="fw-light"><i class="bi bi-info-circle"></i> Anda bisa kembali ke halaman absensi hari ini dengan mengklik tombol refresh</p>
            <p class="fw-light"><i class="bi bi-info-circle"></i> Anda juga bisa mengklik kembali tombol <code>persentase</code> untu me refresh halaman ini.</p>
        </div>
    </div>
    <script>
        document.getElementById('pilihBulan').addEventListener('input',(e)=>{
        var formData = new FormData(document.getElementById('formPilihBulan'));
        const inputed = formData.get('bulan');
        window.location.href = `/karyawan/absensi/persentase/${inputed}`;
      });
    </script>
    @elseif($edit != null)
    <form action="/karyawan/abs/rekap/{{$edit->id_absensi}}" method="POST" class="form">
        @csrf
        <div class="mb-1">
            <label for="idAbsensi" class="form-label">ID Absensi</label>
            <input type="text" name="id_absensi" disabled id="idAbsensi" value="{{$edit->id_absensi}}" class="form-control">
        </div>
        <div class="mb-1">
            <label for="idKaryawan" class="form-label">ID Karyawan</label>
            <input type="text" disabled name="id_karyawan" id="idKaryawan" value="{{$edit->id_karyawan}}" class="form-control">
        </div>
        <div class="mb-1">
            <label for="namaLengkap" class="form-label">Nama Lengkap</label>
            <input type="text" disabled name="nama_lengkap" id="namaLengkap" value="{{$edit->nama}}" class="form-control">
        </div>
        <div class="mb-1">
            <label for="jabatan" class="form-label">Posisi</label>
            <select name="posisi" disabled id="jabatan" class="form-select">
                <option selected >{{$edit->posisi}}</option>
                <option value="Staff">Staff</option>
            </select>
        </div>
        <div class="mb-1">
            <label for="tanggalMasuk" class="form-label">Tanggal Masuk</label>
            <input type="date" disabled name="tgl_masuk" id="tanggalMasuk" value="{{$edit->tanggal}}" class="form-control">
        </div>
        <div class="mb-1">
            <label for="jamMasuk" class="form-label">Jam Masuk</label>
            <input type="text" disabled name="jam_masuk" id="jamMasuk" value="{{$edit->jam_masuk}}" class="form-control">
        </div>
        <div class="mb-1">
            <label for="jamPulang" class="form-label">Jam Pulang</label>
            <input type="time" name="jam_keluar" id="jamPulang" value="{{$edit->jam_keluar}}" class="form-control">
        </div>
        <div class="mb-1">
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>
    @endif
                
</div>
@endsection