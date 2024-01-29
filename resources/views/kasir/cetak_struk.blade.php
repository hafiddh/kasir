<!DOCTYPE html>
<html>

<head>
    <link href="{{ asset('/') }}assets/css/bootstrap_print.min.css" rel="stylesheet" />
</head>

<body>
    <style type="text/css">
        body {
            line-height: 0.8;
        }

        table tr td,
        table tr th {
            font-size: 9pt;
        }

        table tr {
            border-top: hidden !important;
            border-bottom: hidden !important;
        }

        h4 {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 16px;

        }

        h6 {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: normal;
            font-size: 12px;
            font-weight: bold
        }

        table {
            border: none;
        }

    </style>

    <center>
        @if ($kop->id == '1')
            <img src="{{ asset('/') }}assets/images/brand/logo 2.png" style="width: 150px" alt="logo">
        @endif
    </center>


    <center style="margin-top: 10px">
        <h4><u>{{ $kop->nama }}</u></h4>
        <h6>{!! $kop->alamat !!}</h6>
        <h6>{{ $kop->no_telp }}</h6>
    </center>

    <table class="table" style="margin-top: 20px">
        <thead>
            <tr>
                <td>Kasir</td>
                <td>:&nbsp;&nbsp; {{ auth()->user()->nama }}</td>
            </tr>
        </thead>
    </table>

    <hr
        style="margin-left: 10px ;margin-right: 10px;margin-top: -12px;margin-bottom: -12px; border-top: 1px solid rgb(0, 0, 0);">

    <table class='table' cellspacing="0" cellpadding="0" style="margin-top: 20px">

        <tbody>
            @php $i=1 @endphp
            @foreach ($data_detail as $p)
                <tr style="border-top : hidden!important;">
                    <td style="width: 60%">{{ $p->nama_produk }}</td>
                    <td style="text-align: center; width: 5%">x{{ $p->jumlah }}</td>
                    <td style="width: 35%; text-align:right; ">{{ number_format($p->total_hjual, 0, '.', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr
        style="margin-left: 10px ;margin-right: 10px;margin-top: -12px;margin-bottom: -12px; border-top: 1px solid rgb(0, 0, 0);">

    <table class='table' cellspacing="0" cellpadding="0" style="margin-top: 20px">

        <tfoot>
            <tr style="border-top : hidden!important;">
                <td colspan="2" style="width: 60%"> SubTotal </td>
                <td style="width: 5%"></td>
                <td style="width: 35%; text-align:right; ">{{ number_format($data->total_harga_jual, 0, '.', '.') }}
                </td>
            </tr>
            <tr style="border-top : hidden!important;">
                <td colspan="2" style="width: 60%"> Potongan </td>
                <td style="width: 5%"></td>
                <td style="width: 35%; text-align:right; ">- {{ number_format($data->potongan, 0, '.', '.') }}</td>
            </tr>
            <tr style="border-top : hidden!important;">
                <td colspan="2" style="width: 60%"><b>Total</b> </td>
                <td style="width: 5%"></td>
                <td style="width: 35%; text-align:right; "> <b>
                        {{ number_format($data->total_harga_jual - $data->potongan, 0, '.', '.') }}</b></td>
            </tr>
        </tfoot>
    </table>

    <hr
        style="margin-left: 10px ;margin-right: 10px; margin-top: -12px; margin-bottom: -12px; border-top: 1px solid black;">

    <table class='table' cellspacing="0" cellpadding="0" style="margin-top: 20px">

        <tfoot>
            <tr style="border-top : hidden!important;">
                <td colspan="2" style="width: 60%"> Tunai </td>
                <td style="width: 5%"></td>
                <td style="width: 35%; text-align:right; ">{{ number_format($data->tunai, 0, '.', '.') }}
                </td>
            </tr>
            <tr style="border-top : hidden!important;">
                <td colspan="2" style="width: 60%"> Kembali </td>
                <td style="width: 5%"></td>
                <td style="width: 35%; text-align:right; ">{{ number_format($data->kembalian, 0, '.', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <hr
        style="margin-left: 10px ;margin-right: 10px; margin-top: -12px; margin-bottom: -12px; border-top: 1px solid black;">

    <table class="table" style="margin-top: 20px">
        <tbody>
            <tr>
                <td>Tanggal</td>
                @php
                    $date = date_create($data->date);
                @endphp

                <td>: &nbsp;&nbsp;{{ date_format($date, 'd/m/Y') . ' | ' . $data->time }}</td>
            </tr>
            <tr>
                <td>No Transaksi</td>
                <td>:&nbsp;&nbsp; {{ $data->kd_transaksi }}</td>
            </tr>
        </tbody>
    </table>

    <hr style="margin-left: 10px ;margin-right: 10px; margin-top: -12px;border-top: 1px solid black;">

    <center>
        <h6 style="font-size: 11px;">== TERIMA KASIH ATAS KUNJUNGAN ANDA ==</h6>
    </center>

</body>


</html>
