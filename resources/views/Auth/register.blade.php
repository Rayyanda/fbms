@extends('template')
@section('title','Menambahkan Karyawan Baru')
@section('content')

    <div class="container-xxl" style="min-height: 600px" >
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
        <div class="card shadow">
            <div class="card-header">
                <h3>Karyawan Baru <i class="bi bi-person-plus"></i></h3>
            </div>

            <div class="card-body">
                <form action="{{ route('user.register') }}" method='post'>
                    @csrf
                    @method('POST')

                    <div class="row mb-3">
                        <div class="col-md-7">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="userName" name="name" placeholder="name@example.com">
                                <label for="userName">Name</label>
                            </div>
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="emailUser" placeholder="name@example.com">
                                <label for="emailUser">Email address</label>
                            </div>
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="form-floating">
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat" id="alamatKaryawan"></textarea>
                                <label for="alamatKaryawan">Alamat</label>
                            </div>
                            @error('alamat')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" name="no_telp" id="noTelp" class="form-control @error('no_telp') is-invalid @enderror" required placeholder="896xxxxx">
                                <label for="noTelp">Phone Number</label>
                            </div>
                            @error('no_telp')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <hr class="my-3">

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" name="posisi" required id="posisiKaryawan" class="form-control @error('posisi') is-invalid @enderror" placeholder="HR">
                                <label for="posisiKaryawan">Position</label>
                            </div>
                            @error('posisi')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating">
                                <select class="form-select @error('id_cabang') is-invalid @enderror" id="cabang" name="id_cabang" aria-label="Floating label select example">
                                  <option selected>Open this select menu</option>
                                  @foreach ($cabang as $item)
                                  <option value="{{ $item->id_cabang }}">{{ $item->nama_cabang }}</option>
                                  @endforeach
                                </select>
                                <label for="cabang">Works with selects</label>
                            </div>
                            @error('id_cabang')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary">Submit form</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

@endsection
