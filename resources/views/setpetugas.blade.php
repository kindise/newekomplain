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
                <div class="card-header"><b>Setting petugas</b></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('taketicket') }}">
                        @csrf
                        <div class="mb-3 row">
                            <label for="petugas" class="col-sm-4 col-form-label text-md-end">{{ __('Pilih petugas') }}</label>
                            <div class="col-sm-6">
                                <select id="petugas" type="text" class="form-select @error('petugas') is-invalid @enderror" name="petugas">
                                    <option value="">-- Select --</option>
                                    @foreach($petugas as $obj)
                                    <option value="{{ $obj->id }}">{{ $obj->name }}</option>
                                    @endforeach
                                </select>
                                @error('petugas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{ $id }}" />
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection