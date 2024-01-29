<!DOCTYPE html>
<html>

<head>
    <title>FAKTUR</title>
    <link href="{{ asset('/') }}assets/css/bootstrap_print.min.css" rel="stylesheet" />

</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }

        h4 {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 20px;

        }

        h5 {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 18px;

        }

        h3 {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;

        }

        h6 {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: normal;
            font-size: 13px;
            font-weight: bold
        }

        .table-atas {
            border-collapse: separate;
            border-spacing: 0 -25px;
        }

        hr {
            background-color: white;
            margin: 5px 0 15px 0;
            max-width: 100%;
            border-width: 0;
        }

        hr.s1 {
            height: 5px;
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

    </style>

    @if ($kop->id == '1')
        <table width="100%">
            <tr>
                <td width="20%" align="right"><img src="{{ asset('/') }}assets/images/brand/logo-2.png"
                        style="width: 100px" alt="logo"></td>
                <td width="80%" align="center">
                    <h3 style="margin-left: -50px;"><u>{{ $kop->nama }}</u></h3>
                    <h6 style="margin-left: -50px;">{!! $kop->alamat !!}</h6>
                    <h6 style="margin-left: -50px;">{{ $kop->no_telp }}</h6>
                </td>
            </tr>
        </table>
    @else
        <table width="100%">
            <tr>
                <td width="100%" align="center">
                    <h3><u>{{ $kop->nama }}</u></h3>
                    <h6>{!! $kop->alamat !!}</h6>
                    <h6>{{ $kop->no_telp }}</h6>
                </td>
            </tr>
        </table>
    @endif

    <hr class="s1">

    <center style="margin-top: 10px">
        <h5><u>FAKTUR</u></h5>
        <h6>No : {{ $kd }}</h6>
    </center>

    <table class="table table-borderless table-atas" style="margin-top: 20px">
        <thead>
            <tr>
                <th style="width: 20%"><b>Nama Pelanggan</b> </th>
                <th>:&nbsp;&nbsp; {{ $nama }}</th>
            </tr>
            <tr>
                <th><b>No. Telp</b> </th>
                <th>:&nbsp;&nbsp; {{ $no_telp }}</th>
            </tr>
            <tr>
                <th><b>Alamat</b> </th>
                <th>:&nbsp;&nbsp; {{ $alamat }}</th>
            </tr>
            <tr>
                <th><b>Tanggal</b></th>
                @php
                    $date = date_create($transakasi->date);
                @endphp

                <th>: &nbsp;&nbsp;{{ date_format($date, 'd/m/Y') . ' | ' . $transakasi->time }}</th>
            </tr>
            <tr>
                <th><b>No Transaksi</b></th>
                <th>:&nbsp;&nbsp; {{ $id_trans }}</th>
            </tr>
        </thead>
    </table>

    <table  class="table table-bordered table-striped" style="margin-top: 20px">
        <thead>
            <tr>
                <th style="text-align: center; width: 2%">No</th>
                <th style="text-align: center; width: 35%">Nama Barang</th>
                <th style="text-align: center; width: 3%">qty</th>
                <th style="text-align: center; width: 10%">Satuan</th>
                <th style="text-align: center; width: 20%">Harga</th>
                <th style="text-align: center; width: 25%">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($transakasi_detail as $p)
                <tr>
                    <td style="text-align: center">{{ $i++ }}</td>
                    <td>{{ $p->nama_produk }}</td>
                    <td style="text-align: center">{{ $p->jumlah }}</td>
                    <td style="text-align: center">{{ $p->satuan }}</td>
                    <td>Rp. {{ number_format($p->harga_jual, 0, '.', '.') }}</td>
                    <td>Rp. {{ number_format($p->total_hjual, 0, '.', '.') }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2" style="text-align: center;"> Jumlah</td>
                <td style="text-align: center"><b>{{ $jum }}</b> </td>
                <td style="border-bottom : hidden!important;"></td>
                <td style="text-align: right">Total :</td>
                <td>Rp. {{ number_format($transakasi->total_harga_jual, 0, '.', '.') }}</td>
            </tr>
            <tr>
                <td style="border-left : hidden!important;"></td>
                <td style="border-left : hidden!important;"></td>
                <td style="border-left : hidden!important;"></td>
                <td style="border-left : hidden!important;"></td>
                <td style="text-align: right">Diskon :</td>
                <td>Rp. {{ number_format($transakasi->potongan, 0, '.', '.') }}</td>
            </tr>
            <tr>
                <td colspan="4"
                    style="text-align: left; border-left : hidden!important; border-bottom : hidden!important; border-top : hidden!important;">
                    <b>{{ ucwords(terbilang($transakasi->total_harga_jual - $transakasi->potongan)) . ' Rupiah' }}</b>
                </td>
                <td style="text-align: right"><b>Grand Total :</b> </td>
                <td><b>Rp.
                        {{ number_format($transakasi->total_harga_jual - $transakasi->potongan, 0, '.', '.') }}</b>
                </td>
            </tr>
        </tfoot>
    </table>

    <table class="table" style="margin-top: 40px">
        <thead>
            <tr>
                <th style="border-style : hidden!important; width: 75%"><b></b> </th>
                <th style="border-style : hidden!important; text-align: center;"><b>{{ $kop->nama }}</b> </th>
            </tr>
            <tr>
                <th style="border-bottom : hidden!important;width: 75%"><b></b> </th>
                <th style="border-bottom : inset!important;border-color: rgb(38, 38, 38); height: 50px;"><b></b> </th>
            </tr>
        </thead>
    </table>
    @php
        function penyebut($nilai)
        {
            $nilai = abs($nilai);
            $huruf = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
            $temp = '';
            if ($nilai < 12) {
                $temp = ' ' . $huruf[$nilai];
            } elseif ($nilai < 20) {
                $temp = penyebut($nilai - 10) . ' belas';
            } elseif ($nilai < 100) {
                $temp = penyebut($nilai / 10) . ' puluh' . penyebut($nilai % 10);
            } elseif ($nilai < 200) {
                $temp = ' seratus' . penyebut($nilai - 100);
            } elseif ($nilai < 1000) {
                $temp = penyebut($nilai / 100) . ' ratus' . penyebut($nilai % 100);
            } elseif ($nilai < 2000) {
                $temp = ' seribu' . penyebut($nilai - 1000);
            } elseif ($nilai < 1000000) {
                $temp = penyebut($nilai / 1000) . ' ribu' . penyebut($nilai % 1000);
            } elseif ($nilai < 1000000000) {
                $temp = penyebut($nilai / 1000000) . ' juta' . penyebut($nilai % 1000000);
            } elseif ($nilai < 1000000000000) {
                $temp = penyebut($nilai / 1000000000) . ' milyar' . penyebut(fmod($nilai, 1000000000));
            } elseif ($nilai < 1000000000000000) {
                $temp = penyebut($nilai / 1000000000000) . ' trilyun' . penyebut(fmod($nilai, 1000000000000));
            }
            return $temp;
        }
        
        function terbilang($nilai)
        {
            if ($nilai < 0) {
                $hasil = 'minus ' . trim(penyebut($nilai));
            } else {
                $hasil = trim(penyebut($nilai));
            }
            return $hasil;
        }
    @endphp
</body>

</html>
