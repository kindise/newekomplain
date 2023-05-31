<?php

namespace App\Http\Controllers;

use App\Exports\TicketExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;

class ReportController extends Controller
{
    public function index ()
    {
        return view('report.index');
    }

    public function export(Request $request)
    {
        $tgl_awal = Carbon::parse($request->tgl_awal)->format('Y-m-d 00:00:00');
        $tgl_akhir = Carbon::parse($request->tgl_akhir)->format('Y-m-d 23:59:59');
        return Excel::download(new TicketExport($tgl_awal, $tgl_akhir), 'laporan-e-tiket.xlsx');
    }
}
