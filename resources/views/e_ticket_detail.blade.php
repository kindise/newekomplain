<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Print E-Ticket</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
            /* set font family to roboto */
            body {
                font-family: 'Roboto', sans-serif;
            }
        </style>
    </head>
    <body>
        {{-- @dd($data) --}}
        @foreach ($data as $item)
            <h3 style="text-align: center; margin-top: 100px">FORM TINDAK LANJUT<br/>PERBAIKAN SIM RSUD PASAR REBO</h3>
            <table width="100%" cellpadding="5" style="border-spacing: 0; margin-bottom: 50px; font-size: 14px">
                <tr>
                    <td style="border-left: 1px solid; border-top: 1px solid;">NO. TIKET</td>
                    <td style="border-top: 1px solid; border-right: 1px solid;" colspan="4">
                        {{-- create no_ticket with str_pad --}}
                        {{ 'TK' . str_pad($item->id, 8, '0', STR_PAD_LEFT) }}
                    </td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid;">RUANGAN</td>
                    <td style="border-right: 1px solid;" colspan="4">{{ $item->cnmunit }}</td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid;">TANGGAL / JAM LAPOR</td>
                    <td style="border-right: 1px solid;" colspan="4">{{ date_format(date_create($item->tgl_tiket), 'Y-m-d / H:i') }}</td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid;">PELAPOR</td>
                    <td style="border-right: 1px solid;" colspan="4">{{ $item->nama }}</td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid;">MASALAH</td>
                    <td style="border-right: 1px solid;" colspan="4">{{ $item->description }}</td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid;">TANGGAL / JAM SELESAI</td>
                    <td style="border-right: 1px solid;" colspan="4">{{ empty($item->solution) ? '-' : date_format(date_create($item->tgl_selesai), 'Y-m-d / H:i') }}</td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid;">PETUGAS</td>
                    <td style="border-right: 1px solid;" colspan="4">{{ $item->assign }}</td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid;">ISI PENYELESAIAN</td>
                    <td style="border-right: 1px solid;" colspan="4">{{ $item->solution ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid; border-right: 1px solid;" colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid; text-align: center;" colspan="3">PARAF PETUGAS :</td>
                    <td style="border-right: 1px solid;" colspan="2">PARAF PELAPOR :</td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;" colspan="5">&nbsp;</td>
                </tr>
            </table>
            @if ($loop->iteration % 2 == 0)
                <div style="page-break-after: always"></div>
            @endif
        @endforeach
    </body>
</html>