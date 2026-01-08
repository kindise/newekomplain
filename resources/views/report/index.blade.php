@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card-header"><b>Buat Laporan Tiket</b></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('report.export') }}">
                        @csrf
                        <div class="row">
                            <label for="unit" class="col-2 col-form-label text-md-end fw-bold">Pilih Tanggal :</label>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <input id="tgl_awal" type="date" class="form-control @error('tgl_awal') is-invalid @enderror" name="tgl_awal" value="{{ old('tgl_awal') ?? date('Y-m-d') }}" />
                                    </div>
                                    <div class="col-6">
                                        <input id="tgl_akhir" type="date" class="form-control @error('tgl_akhir') is-invalid @enderror" name="tgl_akhir" value="{{ old('tgl_akhir') ?? date('Y-m-d') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary">Export Excel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection