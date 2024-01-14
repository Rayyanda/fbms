@extends('template')
@section('title','Edit Data Karyawan')
@section('content')
<div class="container-xxl" style="min-height: 600px;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/karyawan">Karyawan</a></li>
          <li class="breadcrumb-item"><a href="/karyawan/d">Data Karyawan</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
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
        <form action="" id="formSelectKaryawan" class="form">
            <label for="selectKaryawan" class="form-label">Pilih Data Karyawan</label>
            <select name="id_karyawan" required class="form-select form-select-sm" id="selectKaryawan" aria-label="Small select example">
                @if ($selected != null)    
                <option selected>{{$selected->id_karyawan}}-{{ $selected->nama }}</option>
                @else
                <option selected>Pilih</option>
                @endif
                @foreach ($data as $item)
                <option value="{{$item->id_karyawan}}">{{$item->id_karyawan}}-{{ $item->nama }}</option>
                @endforeach
            </select>
        </form>
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
        <table class="table table-borderless table-sm">
            <tbody>
                @if ($selected != null)
                <form action="/karyawan/e/id/{{$selected->id_karyawan}}" method="post">
                    @csrf
                    <tr>
                        <th scope="row"><label for="id_karyawan" class="form-label">Id Karyawan</label></th>
                        <td>:</td>
                        <td>
                            <input type="text" name="id_karyawan_lama" id="id_karyawan" value="{{$selected->id_karyawan}}" hidden class="form-control form-control-sm">
                            <input type="text" value="{{$selected->id_karyawan}}"  name="id_karyawan" class="form-control form-control-sm" id="id_karyawan">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="nam_karyawan" class="form-label">Nama Lengkap</label></th>
                        <td>:</td>
                        <td><input type="text" value="{{$selected->nama}}" name="nama" class="form-control form-control-sm" id="nama_karyawan"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="alamatKaryawan" class="form-label">Alamat</label></th>
                        <td>:</td>
                        <td>
                            <textarea name="alamat" id="alamatKaryawan" class="form-control" >{{$selected->alamat}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="no_telp" class="form-label">No. Telp</label></th>
                        <td>:</td>
                        <td><input type="text" value="{{$selected->no_telp}}" name="no_telp" class="form-control form-control-sm" id="no_telp"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="posisi_karyawan" class="form-label">Posisi</label></th>
                        <td>:</td>
                        <td><input type="text" value="{{$selected->posisi}}" name="posisi" class="form-control form-control-sm" id="posisi_karyawan"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <a href="/karyawan/e" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Batalkan</a>
                            <button type="submit" class="btn btn-outline-success btn-sm"><i class="bi bi-arrow-right"></i> Simpan</button>
                        </td>
                    </tr>
                </form>
                @else
                <form action="" method="post">
                    <tr>
                        <th scope="row"><label for="id_karyawan" class="form-label">Id Karyawan</label></th>
                        <td>:</td>
                        <td><input type="text" disabled readonly name="id_karyawan" class="form-control form-control-sm" id="id_karyawan"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="nam_karyawan" class="form-label">Nama Lengkap</label></th>
                        <td>:</td>
                        <td><input type="text" disabled readonly name="nama" class="form-control form-control-sm" id="nama_karyawan"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="alamat_karyawan" class="form-label">Alamat</label></th>
                        <td>:</td>
                        <td><input type="text" disabled readonly name="alamat" class="form-control form-control-sm" id="alamat_karyawan"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="no_telp" class="form-label">No. Telp</label></th>
                        <td>:</td>
                        <td><input type="text" disabled readonly name="no_telp" class="form-control form-control-sm" id="no_telp"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="posisi_karyawan" class="form-label">Posisi</label></th>
                        <td>:</td>
                        <td><input type="text" name="posisi" disabled readonly class="form-control form-control-sm" id="posisi_karyawan"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <a href="/karyawan/e" class="btn btn-outline-secondary btn-sm disabled"><i class="bi bi-arrow-left"></i> Batalkan</a>
                            <button type="submit" class="btn btn-outline-success btn-sm disabled"><i class="bi bi-arrow-right"></i> Simpan</button>
                        </td>
                    </tr>
                </form>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection