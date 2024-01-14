@extends('template')
@section('title','Laporan Keuangan')
@section('content')

<div class="container-xxl" style="min-height: 600px">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/keuangan">Keuangan</a></li>
          <li class="breadcrumb-item active" aria-current="page">Laporan Laba Rugi</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-start mb-2">
        <div class="flex-grow-1">
            <a href="/keuangan" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
            <a href="/keuangan/laporan/refresh" class="btn btn-warning btn-sm " title="Refresh"><i class="bi bi-arrow-clockwise"></i></a>
            <a href="/keuangan/laporan/add/today" class="btn btn-success btn-sm" title="Tambah Data"><i class="bi bi-plus"></i></a>
            <a href="/keuangan/pendapatan" class="btn btn-info btn-sm" title="Data Pendapatan"><i class="bi bi-cash-coin"></i></a>
            <a href="/keuangan/pengeluaran" class="btn btn-info btn-sm" title="Data Pengeluaran"><i class="bi bi-cash-stack"></i></a>
        </div>
        <form id="formPilihTanggalLaporan" style="width: 150px" class="form d-flex flex-row mx-2" >
            <input type="date" name="tanggal" value="{{isset($tgl) ? $tgl : null}}" id="pilihTanggalLaporan" class="form-control form-control-sm" >
        </form>
        <form action="" id="formPilihBulan" class="mx-1">
            <input type="month" placeholder="Pilih Bulan" value="{{isset($tgl) ? $tgl : null}}" name="bulan" id="pilihBulan" class="form-control form-control-sm">
        </form>
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
    @if ($laporan != null)
    <div class="table-responsive small">
        <table class="table table-sm table-bordered table-striped">
            <thead class="text-center">
                <th>#</th>
                <th>Tgl. Transaksi</th>
                <th title="Pendapatan" >Debet</th>
                <th>Beban Operasional</th>
                <th>Beban Non-Operasional</th>
                <th>Laba Kotor</th>
                <th>Laba Bersih</th>
                <th>Keterangan</th>
                <th>Opsi</th>
            </thead>
            <tbody class="text-center">
                @php
                    $count = 0;
                    $pendapatan = 0;
                    $pengeluaran = 0;
                    $beban_non_op = 0;
                    $laba_kotor = 0;
                    $laba_bersih = 0;
                @endphp
                @if (count($laporan) >= 1)
                @foreach ($laporan as $item)
                    <tr>
                        <td>{{$count+=1}}</td>
                        <td>{{$item->tanggal}}</td>
                        <td>Rp. {{number_format($item->pendapatan)}}</td>
                        <td>Rp. {{number_format($item->pengeluaran)}}</td>
                        <td>Rp. {{number_format($item->beban_non_operasional)}}</td>
                        <td>Rp. {{number_format($item->laba_kotor)}}</td>
                        <td>Rp. {{number_format($item->laba_bersih)}}</td>
                        <td>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#myModal" class="text-decoration-none">
                                {{substr($item->keterangan,0,20)}}...
                            </a>
                        </td>
                        <td><a title="Edit Data" href="/keuangan/laporan/edit/{{$item->tanggal}}"><i class="bi bi-pencil"></i></a></td>
                        @php
                            $pendapatan += $item->pendapatan;
                            $pengeluaran += $item->pengeluaran;
                            $beban_non_op += $item->beban_non_operasional;
                            $laba_kotor += $item->laba_kotor;
                            $laba_bersih += $item->laba_bersih;
                        @endphp
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="2">Total</td>
                        <td>Rp. {{number_format($pendapatan)}}</td>
                        <td>Rp. {{number_format($pengeluaran)}}</td>
                        <td>Rp. {{number_format($beban_non_op)}}</td>
                        <td>Rp. {{number_format($laba_kotor)}}</td>
                        <td>Rp. {{number_format($laba_bersih)}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @else
                    <tr>
                        <td colspan="9">
                            <h5><i>Data tidak ditemukan.</i></h5>
                            <a href="/keuangan/laporan/add/{{$tgl}}" class="btn btn-large btn-success">Masukkan laporan pada tanggal {{ $tgl }}</a>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    @if ($tgl == null)
        {{$laporan->links("pagination::bootstrap-5")}}
    @endif
    <script>
        document.getElementById('pilihBulan').addEventListener('input',(e)=>{
        var formData = new FormData(document.getElementById('formPilihBulan'));
        const inputed = formData.get('bulan');
        window.location.href = `/keuangan/laporan/bulan/${inputed}`;
      });
        document.getElementById('pilihTanggalLaporan').addEventListener('input',(e)=>{
        var formData = new FormData(document.getElementById('formPilihTanggalLaporan'));
        const inputed = formData.get('tanggal');
        window.location.href = `/keuangan/laporan/tanggal/${inputed}`;
      })
  </script>
    @elseif($edit != null)
    <div class="table-responsive small">
        <table class="table table-sm table-borderless">
            <form action="/keuangan/laporan/update" method="POST" class="form">
                @csrf
                <tbody>
                    <tr>
                        <th scope="row">Tanggal Transaksi</th>
                        <td>:</td>
                        <td>
                            <input type="date" name="tanggal" disabled id="" value="{{$edit->tanggal}}" class="form-control form-control-sm">
                            <input type="date" name="tanggal" hidden id="" value="{{$edit->tanggal}}" class="form-control form-control-sm">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">pendapatan</th>
                        <td>:</td>
                        <td>
                            <input type="text" name="pendapatan" disabled id="" value="Rp. {{number_format($edit->pendapatan)}}" class="form-control form-control-sm">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Pengeluaran</th>
                        <td>:</td>
                        <td>
                            <input type="text" name="tanggal" disabled id="" value="Rp. {{number_format($edit->pengeluaran)}}" class="form-control form-control-sm">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Beban Non Operasional</th>
                        <td>:</td>
                        <td>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">Rp.</span>
                                <input type="number" class="form-control form-control-sm" name="beban_non_operasional" value="{{$edit->beban_non_operasional}}" placeholder="5000000" aria-label="Username" aria-describedby="addon-wrapping">
                              </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Laba Kotor</th>
                        <td>:</td>
                        <td>
                            <input type="text" name="laba_kotor" disabled id="" value="Rp. {{number_format($edit->laba_kotor)}}" class="form-control form-control-sm">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Laba Bersih</th>
                        <td>:</td>
                        <td>
                            <input type="text" name="laba_kotor" disabled id="" value="Rp. {{number_format($edit->laba_bersih)}}" class="form-control form-control-sm">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Keterangan</th>
                        <td>:</td>
                        <td>
                            <textarea class="form-control" name="keterangan"id="exampleFormControlTextarea1" rows="3">{{$edit->keterangan}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <a href="/keuangan/laporan" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-left"></i> Batal</a>
                            <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-save"></i> Simpan</button>
                        </td>
                    </tr>
                </tbody>
            </form>
        </table>
    </div>
    @endif
</div>
@endsection