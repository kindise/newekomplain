<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    
    public function print()
    {
        // where between june and sept
        $sql = "SELECT
            a.id,
            A.created_at tgl_tiket, A.nama, B.cnmunit, A.description, A.solution, A.pic, C.name as assign,
            (select D.updated_at from ticket_status D where A.id=D.ticket_id order by D.updated_at desc limit 1) as tgl_selesai
            FROM tickets A
            JOIN msunit B on A.ckdunit=B.ckdunit
            JOIN users C on A.assignto=C.id
            WHERE A.created_at BETWEEN '2022-06-01 00:00:00' AND '2022-09-30 23:59:59'
        ORDER BY A.created_at asc";

        $data = DB::select($sql);

        $pdf = Pdf::loadView('print', compact([
            'data'
        ]), [
            'paper'         => 'A4',
            'format'        => '0',
            'margin_left'   => 10,
            'margin_right'  => 10,
            'margin_top'    => 10,
            'margin_bottom' => 10,
        ]);

        return $pdf->stream('e_ticket.pdf');
    }

    public function logTicket()
    {
        $sql = "SELECT
            a.id,
            A.created_at tgl_tiket, A.nama, B.cnmunit, A.description, A.solution, A.pic, C.name as assign,
            (select D.updated_at from ticket_status D where A.id=D.ticket_id order by D.updated_at desc limit 1) as tgl_selesai
            FROM tickets A
            JOIN msunit B on A.ckdunit=B.ckdunit
            JOIN users C on A.assignto=C.id
            WHERE A.created_at BETWEEN '2022-06-01 00:00:00' AND '2022-09-30 23:59:59'
        ORDER BY A.created_at asc";

        $data = DB::select($sql);

        return view('log', compact([
            'data'
        ]));
    }

    public function refreshTicket()
    {
        $sql = "SELECT
            a.id,
            A.created_at tgl_tiket, A.nama, B.cnmunit, A.description, A.solution, A.pic, C.name as assign,
            (select D.updated_at from ticket_status D where A.id=D.ticket_id order by D.updated_at desc limit 1) as tgl_selesai
            FROM tickets A
            JOIN msunit B on A.ckdunit=B.ckdunit
            JOIN users C on A.assignto=C.id
            WHERE A.created_at BETWEEN '2022-06-01 00:00:00' AND '2022-09-30 23:59:59'
        ORDER BY A.created_at asc";

        $data = DB::select($sql);

        return view('refresh', compact([
            'data'
        ]));
    }
}
