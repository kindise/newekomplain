@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <h2>New Tickets</h2>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="d-flex justify-content-end">
                <div class="me-auto">
                    <a class="btn-icon btn-sm bi bi-file-earmark-plus" href="{{ route('reqticket') }}" title="Tambah ticket">Tambah ticket</a>
                </div>
                <form class="search-box" method="get" action="/ticket">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="Search...">
                        <div class="input-group-append">
                        <button type="submit" class="btn-icon btn-search"></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive-sm mt-2">
                <table class="table table-borderless" id="dataTable">
                    <thead class="thead-biru">
                        <tr>
                            <th scope="col">Nama Pelapor</th>
                            <th scope="col">Bagian / Unit</th>
							<th scope="col">Tanggal Mulai</th>
                            <th scope="col">Deskripsi</th>
			                <th scope="col">Tanggal Selesai</th>
                            <th scope="col">Petugas</th>
                            <th scope="col">Status</th>
                            <th scope="col" colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ticket as $obj)
                            <tr>
                                <th scope="row">{{ $obj->nama }}</th>
                                <td>{{ $obj->cnmunit }}</td>
								<td>{{ date('d-M-y H:i:s', strtotime($obj->created_at)) }}</td>
                                <td>{{ $obj->description }}</td>
      				            <td>{{ ($obj->status_name ==  'Done' ? date('d-M-y H:i:s', strtotime($obj->status_date)) : mb_convert_encoding('&#10005;', 'UTF-8', 'HTML-ENTITIES') ) }}</td>
                                <td>{{ $obj->petugas ?? mb_convert_encoding('&#10005;', 'UTF-8', 'HTML-ENTITIES') }}</td>
								<td style="width: 0.1rem;"><span class="badge {{ ($obj->status_name ==  'Open' ? 'bg-danger' : ($obj->status_name ==  'On-Process' ? 'bg-warning' : 'bg-success') )}} ">{{ $obj->status_name }}</span></td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-outline-primary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </a>

                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            @if($obj->status_name ==  'Open')
                                                <li><a class="dropdown-item" href="/setpetugas/{{ $obj->id }}">Proses ticket</a></li>
                                            @elseif($obj->status_name ==  'On-Process')
                                                <li><a class="dropdown-item" href="/finish/{{ $obj->id }}">Selesaikan ticket</a></li>
                                            @endif
											@if($obj->status_name !=  'Open')
                                                <li><a class="dropdown-item" href="{{ route('detail', $obj->id) }}">Detail</a></li>
                                                <li><a class="dropdown-item" href="{{ route('detailprint', $obj->id) }}" target="_blank">Cetak ticket</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                {{$ticket->withQueryString()->links()}}
            </div>
            <!-- The Modal -->
        </div>
    </div>
</div>
<script>
function confirm_take(id) {
   /*  if(confirm('Apa kamu yakin ingin mengambil ticket ini ?')){
    fetch("{{ route('taketicket') }}", {
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type':'application/x-www-form-urlencoded'
        },
        method: 'POST',
        body: `id=${id}`
    })
    .then(res => res.text()) // or res.json()
    .then(res => location.reload(true))
    } */
}
function confirm_done(id) {
    if(confirm('Apa kamu yakin ingin menyelesaikan ticket ini ?')){
    fetch("{{ route('doneticket') }}", {
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type':'application/x-www-form-urlencoded'
        },
        method: 'POST',
        body: `id=${id}`
    })
    .then(res => res.text()) // or res.json()
    .then(res => location.reload(true))
    }
}
</script>
@endsection
