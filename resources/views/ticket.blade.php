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
                            <th scope="col">Nama Pengkomplain</th>
                            <th scope="col">Bagian / Unit</th>
                            <th scope="col">Deskripsi</th>
			                <th scope="col">PIC</th>
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
                                <td>{{ $obj->description }}</td>
      				            <td>{{ $obj->pic }}</td>
                                <td>{{ $obj->petugas ?? mb_convert_encoding('&#10005;', 'UTF-8', 'HTML-ENTITIES') }}</td>
                                @if($obj->status_name ==  'Open')
                                    <td style="width: 0.1rem;"><span class="badge bg-danger">{{ $obj->status_name }}</span></td>
                                    <td  style="width: 0.1rem;"><button class="btn btn-lg btn-image btn-take" name="{{ $obj->id }}" onclick="window.location='/setpetugas/{{ $obj->id }}'"></button></td>
                                @elseif($obj->status_name ==  'On-Process')
                                    <td style="width: 0.1rem;"><span class="badge bg-warning">{{ $obj->status_name }}</span></td>
                                    <td style="width: 0.1rem;"><button class="btn btn-lg btn-image btn-done" name="{{ $obj->id }}" onclick="window.location='/finish/{{ $obj->id }}'"></button></td>
                                @else
                                    <td style="width: 0.1rem;"><span class="badge bg-success">{{ $obj->status_name }}</span></td>
                                @endif
                                <td style="width: 0.1rem;"><button class="btn btn-lg btn-image btn-detail" onclick="window.location='{{ route("detail", $obj->id) }}'"></button></td>
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
