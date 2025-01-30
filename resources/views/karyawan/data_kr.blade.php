@extends('template')
@section('title','Data Karyawan')
@section('content')
    <div class="container-xxl" style="min-height:600px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/karyawan">Karyawan</a></li>
              <li class="breadcrumb-item active" aria-current="page">Data Karyawan</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-start mb-2">
            <div class="flex-grow-1">
                <a href="/karyawan" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
                <a href="/karyawan/d/refresh" class="btn btn-warning btn-sm " title="Refresh"><i class="bi bi-arrow-clockwise"></i></a>
                <a href="/karyawan/e" class="btn btn-success btn-sm" title="Edit Data Karyawan" ><i class="bi bi-pencil"></i></a>
                <a href="/karyawan/a" class="btn btn-info btn-sm" title="Tambah Data Karyawan"><i class="bi bi-plus"></i></a>
            </div>
            <form action="/karyawan/d?q" method="GET" class="form d-flex flex-row frm-search">
                <input class="form-control form-control-sm" type="search" name="q" placeholder="ID Karyawan, Nama......" id="searchBar">
                <button type="submit" class="btn btn-sm"><i class="bi bi-search"></i></button>
            </form>
        </div>
        @if (session('log'))
            <div class="alert alert-warning alert-dismissible fade show">
                {{session('log')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="table-responsive small">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <th scope="col" >
                        <div class="d-flex justify-content-md-center align-items-center">
                            <p class="mb-0">#</p>
                        </div>
                    </th>
                    <th scope="col" >
                        <div class="d-flex justify-content-md-between align-items-center p-1">
                            <p class="mb-0">ID Karyawan</p>
                            <button class="btn btn-sm" onclick="btn_sort('karyawan/d/sort/id_karyawan')" ><i class="bi bi-arrow-down-up"></i></button>
                        </div>
                    </th>
                    <th scope="col" >
                        <div class="d-flex justify-content-md-between align-items-center p-1">
                            <p class="mb-0">Nama Lengkap</p>
                            <button class="btn btn-sm" onclick="btn_sort('karyawan/d/sort/nama')" ><i class="bi bi-arrow-down-up"></i></button>
                        </div>
                    </th>
                    <th scope="col" >
                        <div class="d-flex justify-content-md-between align-items-center p-1">
                            <p class="mb-0">Alamat</p>
                            <button class="btn btn-sm" onclick="btn_sort('karyawan/d/sort/alamat')" ><i class="bi bi-arrow-down-up"></i></button>
                        </div>
                    </th>
                    <th scope="col" >
                        <div class="d-flex justify-content-md-between align-items-center p-1">
                            <p class="mb-0">No. Telp</p>
                            <button class="btn btn-sm" onclick="btn_sort('karyawan/d/sort/no_telp')"><i class="bi bi-arrow-down-up"></i></button>
                        </div>
                    </th>
                    <th scope="col" >
                        <div class="d-flex justify-content-md-between align-items-center p-1">
                            <p class="mb-0">Posisi</p>
                            <button class="btn btn-sm" onclick="btn_sort('karyawan/d/sort/posisi')" ><i class="bi bi-arrow-down-up"></i></button>
                        </div>
                    </th>
                    <th scope="col" >
                        <div class="d-flex justify-content-md-between align-items-center p-1">
                            <p class="mb-0">Cabang</p>
                            <button class="btn btn-sm" ><i class="bi bi-arrow-down-up"></i></button>
                        </div>
                    </th>
                </thead>
                <tbody>
                    @php
                        $count = 0;
                    @endphp
                    @foreach ($data as $person)
                        <tr>
                            <td id="idCol" class="text-center" >
                                {{$count+=1}}
                            </td>
                            <td id="idKaryawan" ><a href="#" data-bs-toggle="modal" data-bs-target="#myModal" onclick="tampilModal('kr',['{{$person->id_karyawan}}','{{$person->nama}}'])" class="text-decoration-none" >{{$person->id_karyawan}}</a></td>
                            <td>{{$person->nama}}</td>
                            <td>
                                <a href="#" title="Klik untuk detail alamat" data-bs-target="#myModal" data-bs-toggle="modal" onclick="tampilModal('detailAlamat',['{{$person->alamat}}'])" class="text-decoration-none text-white">{{ substr($person->alamat,0,20)}}...</a>
                            </td>
                            <td>{{$person->no_telp}}</td>
                            <td>{{$person->posisi}}</td>
                            <td>{{ $person->cabang->nama_cabang }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
