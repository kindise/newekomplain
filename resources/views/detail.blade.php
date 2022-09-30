@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title ms-1">{{ $data->cnmunit }}</h5>
                    <table  style="border-spacing: 4px; border-collapse : separate;" >
                        <tr>
                            <td style="vertical-align: top;">Nama Pelapor</td>
                            <td style="vertical-align: top;">:</td>
                            <td style="vertical-align: top;">{{ $data->nama }}
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">Deskripsi</td>
                            <td style="vertical-align: top;">:</td>
                            <td style="vertical-align: top;">{{ $data->description }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">Tanggal Permintaan</td>
                            <td style="vertical-align: top;">:</td>
                            <td style="vertical-align: top;">{{ $tglreq }}
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">Tanggal Selesai</td>
                            <td style="vertical-align: top;">:</td>
                            <td style="vertical-align: top;">{{ $tglselesai ?? '-' }}
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">Durasi Selesai</td>
                            <td style="vertical-align: top;">:</td>
                            <td style="vertical-align: top;">{{ $totaldurasi ?? '-' }}</td>
                        </tr>
			            <tr>
                            <td style="vertical-align: top;">PIC</td>
                            <td style="vertical-align: top;">:</td>
                            <td style="vertical-align: top;">{{ $data->pic ?? '-' }}</td>
                        </tr>
						<tr>
                            <td style="vertical-align: top;">Petugas</td>
                            <td style="vertical-align: top;">:</td>
                            <td style="vertical-align: top;">{{ $data->petugas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">Petugas</td>
                            <td style="vertical-align: top;">:</td>
                            <td style="vertical-align: top;">{{ $data->petugas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">Solusi</td>
                            <td style="vertical-align: top;">:</td>
                            <td style="vertical-align: top;">{{ $data->solution ?? '-' }}</td>
                        </tr>
                    </table>
                    <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <p class="card-text"></p> -->
                </div>
            </div>
            <div class="table-responsive-sm mt-2">
                <table class="table table-borderless" id="dataTable">
                    <thead class="thead-biru">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tanggal Status</th>
                            <th scope="col">Jenis Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detail as $obj)
                            <tr>
                                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                <td class="text-center">{{ date('d-M-Y H:i:s', strtotime($obj->status_date)) }}</td>
                                <td class="text-center"><span class="badge {{ ($obj->status_name == 'Open' ? 'bg-danger' : ($obj->status_name == 'On-Process' ? 'bg-warning' : 'bg-success' )) }}">{{ $obj->status_name }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
