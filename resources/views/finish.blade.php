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
                <div class="card-header"><b>{{ $flag ?? 'Resolve ' }} ticket</b></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('doneticket') }}">
                        @csrf
                        <div class="mb-3 row">
                            <label for="solusi" class="col-sm-4 col-form-label text-md-end">Tanggal / Jam Selesai</label>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" name="tgl_selesai" id="tgl_selesai" max="{{ date('Y-m-d') }}" value="{{ empty(old('tgl_selesai')) ? date('Y-m-d') : old('tgl_selesai') }}">
                                        @error('tgl_selesai')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="time" class="form-control" name="jam_selesai" id="jam_selesai" value="{{ empty(old('jam_selesai')) ? date('H:i') : old('jam_selesai') }}">
                                        @error('jam_selesai')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="solusi" class="col-sm-4 col-form-label text-md-end">{{ __('Solusi') }}</label>
                            <div class="col-sm-6">
                                <textarea class="form-control @error('solusi') is-invalid @enderror" id="solusi" name="solusi" rows="3" required>{{ old('solusi') }}</textarea>
                                @error('solusi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-0 row">
                            <div class="col-md-8 offset-md-4">
                                <a class="btn btn-danger bi bi-x" href="{{ url('/ticket') }}">
                                    Cancel
                                </a>

                                <button type="submit" class="btn btn-primary bi bi-check">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="ticketid" value="{{ $idticket }}"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection