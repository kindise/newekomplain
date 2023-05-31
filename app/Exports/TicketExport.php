<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TicketExport implements FromQuery, WithHeadings
{
    protected $tgl_awal;
    protected $tgl_akhir;
    
    public function __construct($tgl_awal, $tgl_akhir)
    {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function query()
    {
        return DB::table('tickets')
            ->select('tickets.created_at as tgl_tiket', 'tickets.nama', 'msunit.cnmunit', 'tickets.description', 'tickets.solution', 'tickets.pic', 'users.name as assign', DB::raw('(select updated_at from ticket_status where ticket_id = tickets.id order by updated_at desc limit 1) as tgl_selesai'))
            ->join('msunit', 'tickets.ckdunit', '=', 'msunit.ckdunit')
            ->join('users', 'tickets.assignto', '=', 'users.id')
            ->whereBetween('tickets.created_at', [$this->tgl_awal, $this->tgl_akhir])
            ->orderBy('tickets.created_at', 'asc');
    }

    public function headings(): array
    {
        return [
            'Tanggal Tiket',
            'Nama',
            'Unit',
            'Deskripsi',
            'Solusi',
            'PIC',
            'Assign',
            'Tanggal Selesai'
        ];
    }
}
