<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $data = collect(DB::table('ticket_status as t')
                    ->select(DB::raw('t.ticket_id as id, t.status_date, 
                    v.nama, w.cnmunit, v.description, u.status_name, v.pic'))
                    ->join(DB::raw('(select id, ticket_id, max(status_date) as MaxDate 
                    from ticket_status group by ticket_id) tm'), 
                        function($join)
                        {
                            $join->on('t.ticket_id', '=', 'tm.ticket_id')
                                 ->on('t.status_date', '=', 'tm.MaxDate');
                        })
                    ->join('statuses as u', 't.status_id', '=', 'u.id')
                    ->join('tickets as v', 't.ticket_id', '=', 'v.id')
                    ->join('msunit as w', 'v.ckdunit', '=', 'w.ckdunit')
->orWhere('t.status_date', 'like', "%{$request->q}%")
                    ->orWhere('v.nama', 'like', "%{$request->q}%")
                    ->orWhere('w.cnmunit', 'like', "%{$request->q}%")
                    ->orWhere('v.description', 'like', "%{$request->q}%")
                    ->orWhere('u.status_name', 'like', "%{$request->q}%")
                    ->orWhere('v.pic', 'like', "%{$request->q}%")
                    ->orderBy('v.created_at', 'desc')
                    ->get());
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentResults = $data->slice(($currentPage - 1) * 10,10)->all();
        $ticket = new LengthAwarePaginator($currentResults, $data->count(), 10);
        $ticket->setPath('/ticket');
        return view('ticket', compact('ticket'));
    }

    public function reqticket()
    {
        $unit = Unit::select('ckdunit', 'cnmunit')->get();
        return view('form', compact('unit'));
    }

    public function storeticket(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'unit' => 'required',
            'deskripsi' => 'required',
        ]);
        
        DB::beginTransaction();
        try{
            $ticket = new Ticket();
            $ticket->nama = $request->nama;
            $ticket->ckdunit = $request->unit;
            $ticket->description = $request->deskripsi;
            $ticket->pic =  Auth::user()->name;
            $ticket->save();

            if ($ticket){
                DB::table('ticket_status')->insert([
                    'ticket_id' => $ticket->id,
                    'status_date' => Carbon::now(),
                    'status_id' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            DB::commit();
        } catch(QueryException $ex){
            DB::rollback();
            return redirect()->back()->with('error', $ex->getMessage());
        }

        return redirect('/ticket')->with('success', 'Data berhasil ditambahkan');
    }

    public function taketicket(Request $request)
    {
        $ticket = Ticket::where('id', $request->id)->update([
            'updated_at' => Carbon::now()
        ]);

        if($ticket){
            DB::table('ticket_status')->insert([
                'ticket_id' => $request->id,
                'status_date' => Carbon::now(),
                'status_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        return 'ok';
    }

    public function finish($id)
    {
        $idticket = $id;
        return view('finish', compact('idticket'));
    }

    public function doneticket(Request $request)
    {
        $ticket = Ticket::where('id', $request->ticketid)->update([
            'solution' => $request->solusi,
            'updated_at' => Carbon::now()
        ]);


        if($ticket){
            DB::table('ticket_status')->insert([
                'ticket_id' => $request->ticketid,
                'status_date' => Carbon::now(),
                'status_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        return redirect('/ticket')->with('success', 'Ticket status menjadi done');
       
    }

    public function detail($id)
    {
        $detail = collect(DB::table('ticket_status as a')
        ->select(DB::raw('a.status_date, b.status_name'))
        ->join('statuses as b', 'a.status_id', '=', 'b.id')
        ->where('a.ticket_id', $id)
        ->orderBy('a.status_date')
        ->get());

        $data = collect(DB::table('tickets as a')
                ->select(DB::raw('a.nama, b.cnmunit, a.description, a.solution, a.pic, a.created_at'))
                ->join('msunit as b', 'a.ckdunit', '=', 'b.ckdunit')
                ->where('a.id', $id)
                ->get())->first();
        
        $tglreq = Carbon::parse($data->created_at)->isoFormat('dddd, D MMMM Y HH:mm:ss');
        $tglresolve = collect(DB::table('ticket_status')
                        ->select('status_date')
                        ->where('ticket_id', $id)
                        ->where('status_id', 3)
                        ->get())->first()->status_date ?? '';

        if($tglresolve != ""){
            $tglselesai = Carbon::parse($tglresolve)->isoFormat('dddd, D MMMM Y HH:mm:ss');

            $newDate = Carbon::createFromFormat('Y-m-d H:i:s', $tglresolve) ;
            $result = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->diffForHumans($newDate);
            $totaldurasi = $result;
            return view('detail', compact('id', 'detail', 'data', 'tglreq', 'tglselesai', 'totaldurasi'));
        }

        return view('detail', compact('id', 'detail', 'data', 'tglreq'));
    }
}