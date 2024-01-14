@extends('template')
@section('title','Data Bahan Baku')
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
            <div class="d-flex justify-content-start mb-2 align-items-center">
                <div class="flex-grow-1">
                    <a href="/persediaan/" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
                    <a href="/persediaan/bahan" class="btn btn-warning btn-sm " title="Refresh"><i class="bi bi-arrow-clockwise"></i></a>
                    <a href="/persediaan/bahan/a" class="btn btn-success btn-sm" title="Tambah Data"><i class="bi bi-plus"></i></a>
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
                    <div class="d-flex mb-3">
                        <div class="flex-grow-1">
                            <form id="formPilihTanggalDataBahan" style="width: 150px" class="form d-flex flex-row mx-2" >
                                <input type="date" name="terakhir_update" value="{{isset($tgl) ? $tgl : null}}" id="pilihTanggalDataBahan" class="form-control form-control-sm" >
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                         <thead>
                             <th>#</th>
                             <th>Nama Bahan</th>
                             <th>Jumlah Stok</th>
                             <th>Harga Satuan</th>
                             <th>Total</th>
                             <th>Terakhir Update</th>
                             <th>Jam</th>
                             <th>Aksi</th>
                         </thead>
                         <tbody>
                             @php
                                 $count = 0;
                                 $total_cost =0;
                             @endphp
                             @if ($data != null)
                                 @foreach ($data as $item)
                                     <tr>
                                         <td>{{$count+=1}}</td>
                                         <td>{{$item->nama_bahan_baku}}</td>
                                         <td>{{$item->stok}} {{$item->satuan}}</td>
                                         <td>Rp. {{number_format($item->harga_satuan)}}</td>
                                         <td>Rp. {{number_format($item->total)}}</td>
                                         <td>{{$item->terakhir_update}}</td>
                                         <td>{{$item->jam}}</td>
                                         <td>
                                             <a class="p-1" href="/persediaan/bahan/e/{{$item->nama_bahan_baku}}"><i class="bi bi-pencil"></i></a>
                                             <a class="p-1" data-bs-toggle="modal" data-bs-target="#myModal" onclick="tampilModal('hapusDataBahan',['{{$item->nama_bahan_baku}}','{{$item->id_bahan_baku}}'])" href="#"><i class="bi bi-trash"></i></a>
                                         </td>
                                         @php
                                             $total_cost += $item->total;
                                         @endphp
                                     </tr>
                                 @endforeach
                                     <tr>
                                        <td class="text-center fw-bold" colspan="4" >Total</td>
                                        <td colspan="4" >Rp. {{number_format($total_cost)}}</td>
                                     </tr>
                             @endif
                         </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            @if ($tgl == null)
                {{$data->links("pagination::bootstrap-5")}}
            @else
                <a href="/persediaan/bahan/ajukan/{{$tgl}}" class="btn btn-success"><i class="bi bi-arrow-right"></i> Ajukan</a>
            @endif
        </div>
    </div>
    
    <script>
        document.getElementById('pilihTanggalDataBahan').addEventListener('input',(e)=>{
            var formData = new FormData(document.getElementById('formPilihTanggalDataBahan'));
            const inputed = formData.get('terakhir_update');
            window.location.href = `/persediaan/bahan/tgl/${inputed}`;
          })
    </script>
                                            
</div>

@endsection