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
                <div class="card-header"><b>{{ $flag ?? 'Tambah data' }} ticket</b></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('storeticket') }}">
                        @csrf
                        <div class="mb-3 row">
                            <label for="nama" class="col-sm-4 col-form-label text-md-end">{{ __('Nama pengkomplain') }}</label>
                            <div class="col-sm-6">
                                <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}{{ ($ticket->nama ?? '') }}" />
                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="unit" class="col-sm-4 col-form-label text-md-end">{{ __('Bagian / Unit') }}</label>
                            <div class="col-sm-6">
                                <select id="unit" type="text" class="form-select @error('unit') is-invalid @enderror" name="unit">
                                    <option value="">-- Select --</option>
                                    @foreach($unit as $obj)
                                    <option value="{{ $obj->ckdunit }}">{{ $obj->cnmunit }}</option>
                                    @endforeach
                                </select>
                                @error('unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="unit" class="col-sm-4 col-form-label text-md-end">{{ __('Deskripsi') }}</label>
                            <div class="col-sm-6">
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}{{ ($ticket->deskripsi ?? '') }}</textarea>
                                @error('deskripsi')
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#unit').select2({
                  width: 'resolve'
            });

            $(document).on("select2:open", () => {
                document.querySelector(".select2-container--open .select2-search__field").focus()
            })
        });
    </script>
@endsection