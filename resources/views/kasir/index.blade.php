<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/') }}assets/images/brand/favicon.ico" />

    <!-- TITLE -->
    <title>Kasir</title>

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{ asset('/') }}assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="{{ asset('/') }}assets/js/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('/') }}assets/css/style.css" rel="stylesheet" />
    <link href="{{ asset('/') }}assets/css/dark-style.css" rel="stylesheet" />
    <link href="{{ asset('/') }}assets/css/transparent-style.css" rel="stylesheet">
    <link href="{{ asset('/') }}assets/css/skin-modes.css" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="{{ asset('/') }}assets/css/icons.css" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('/') }}assets/colors/color1.css" />

    <style>
        body,
        html {
            height: 100%;
        }

        #loading {
            position: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0.7;
            background-color: #fff;
            z-index: 99;
        }

        #loading-image {
            z-index: 100;
        }

        input.largerCheckbox {
            width: 25px;
            height: 25px;
        }

    </style>


</head>

<body class="app ltr horizontal">

    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src="{{ asset('/') }}assets/images/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /GLOBAL-LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">

            <div id="loading">
                <img id="loading-image" src="{{ asset('/') }}assets/images/ajax.gif" alt="Loading..." />
            </div>


            <!-- app-Header -->
            <div class="app-header header sticky mt-3" style="margin-left: 1%">
                <div class="container-fluid main-container">
                    <div class="d-flex">
                        <!-- sidebar-toggle-->
                        <a class="logo-horizontal " href="index.html">
                            <img src="{{ asset('/') }}assets/images/brand/logo.png"
                                class="header-brand-img desktop-logo" alt="logo">
                            <img src="{{ asset('/') }}assets/images/brand/logo-3.png"
                                class="header-brand-img light-logo1" alt="logo">
                        </a>
                        <!-- LOGO -->
                        <div class="main-header-center ms-3 d-none d-lg-block">
                            @php
                                function hari_ini()
                                {
                                    $hari = date('D');
                                    $tanggal = date('d-m-Y');
                                
                                    switch ($hari) {
                                        case 'Sun':
                                            $hari_ini = 'Minggu';
                                            break;
                                
                                        case 'Mon':
                                            $hari_ini = 'Senin';
                                            break;
                                
                                        case 'Tue':
                                            $hari_ini = 'Selasa';
                                            break;
                                
                                        case 'Wed':
                                            $hari_ini = 'Rabu';
                                            break;
                                
                                        case 'Thu':
                                            $hari_ini = 'Kamis';
                                            break;
                                
                                        case 'Fri':
                                            $hari_ini = 'Jumat';
                                            break;
                                
                                        case 'Sat':
                                            $hari_ini = 'Sabtu';
                                            break;
                                
                                        default:
                                            $hari_ini = 'Tidak di ketahui';
                                            break;
                                    }
                                
                                    return $hari_ini . ', ' . $tanggal;
                                }
                            @endphp
                            <input class="form-control" value="{{ hari_ini() }}" disabled>
                        </div>
                        <div class="d-flex order-lg-2 ms-auto header-right-icons">

                            <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                                aria-controls="navbarSupportedContent-4" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                            </button>
                            <div class="navbar navbar-collapse responsive-navbar p-0">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                                    <div class="d-flex order-lg-2">

                                        <!-- SEARCH -->
                                        <div class="dropdown  d-flex">
                                            <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                                <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                                <span class="light-layout"><i class="fe fe-sun"></i></span>
                                            </a>
                                        </div>
                                        <!-- Theme-Layout -->
                                        <div class="dropdown d-flex">
                                            <a class="nav-link icon full-screen-link nav-link-bg">
                                                <i class="fe fe-minimize fullscreen-button"></i>
                                            </a>
                                        </div>
                                        <!-- SIDE-MENU -->
                                        <div class="dropdown d-flex profile-1">
                                            <a href="javascript:void(0)" data-bs-toggle="dropdown"
                                                class="nav-link leading-none d-flex">
                                                <img src="{{ asset('/') }}assets/images/users/44.png"
                                                    alt="profile-user" class="avatar  profile-user brround cover-image">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <div class="drop-heading">
                                                    <div class="text-center">
                                                        @php
                                                            
                                                            if (Auth::check() == false) {
                                                                $nam = '';
                                                            } else {
                                                                $nam = auth()->user()->nama;
                                                            }
                                                            
                                                        @endphp
                                                        <h5 class="text-dark mb-0 fs-14 fw-semibold">
                                                            {{ $nam }}
                                                        </h5>
                                                        <small class="text-muted">Kasir</small>
                                                    </div>
                                                </div>
                                                <a class="dropdown-item" href="{{ route('logout') }}">
                                                    <i class="dropdown-icon fe fe-alert-circle"></i> Logout
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /app-Header -->

            <!--app-content open-->
            <div class="main-content app-content mt-0">
                <div class="side-app">

                    <!-- CONTAINER -->
                    <div class="mt-5 mb-5" style="margin-left: 1%">
                        <!-- ROW-1 OPEN -->
                        <div class="row">
                            <div class="col-5">
                                <div class="card cart" style="height: 600px;">
                                    <div class="card-header bg-primary" style="color: white">
                                        <input type="text" id="barcode" class="form-control" value=""
                                            placeholder="Barcode ..">
                                    </div>
                                    <div class="card-body" style="overflow-y: scroll;">
                                        <div class="table-responsive">
                                            <table id="tabel_list" class="table table-bordered table-vcenter "
                                                style="width: 100%">
                                                <thead>
                                                    <tr class="border-top bg-primary" style="color: white">
                                                        <th style="color: white; text-align:center; width:5%;">#</th>
                                                        <th style="color: white; text-align:center; width:40%;">Produk
                                                        </th>
                                                        <th style="color: white; text-align:center; width:15%;">Harga
                                                        </th>
                                                        <th style="color: white; text-align:center; width:15%;">Jumlah
                                                        </th>
                                                        <th style="color: white; text-align:center; width:15%;">Total
                                                            Harga</th>
                                                        <th style="color: white; text-align:center; width:1%;">Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group mb-1" id="total_belanja">

                                                    @php
                                                        
                                                        if (Auth::check() == false) {
                                                            $tot_bel = 0;
                                                        } else {
                                                            $tot_bel = DB::table('tb_transaksi_temp')
                                                                ->where('id_operator', auth()->user()->id)
                                                                ->count();
                                                        }
                                                        
                                                    @endphp
                                                    <button disabled class="input-group-text btn btn-dark btn-lg"
                                                        style="text-align: right; font-weight:bold;">Total
                                                        Belanja</button>
                                                    <button disabled class="input-group-text btn btn-dark btn-lg"
                                                        style="text-align: center; font-weight:bold;">{{ $tot_bel }}</button>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="text-align: right;">
                                                <div id="total_harga">
                                                    @php
                                                        if (Auth::check() == false) {
                                                            $tot_har = 0;
                                                            $tot_har_bel = 0;
                                                        } else {
                                                            $tot_har = DB::table('tb_transaksi_temp')
                                                                ->where('id_operator', auth()->user()->id)
                                                                ->sum('total_harga');
                                                            $tot_har_bel = DB::table('tb_transaksi_temp')
                                                                ->where('id_operator', auth()->user()->id)
                                                                ->sum('total_harga_beli');
                                                        }
                                                    @endphp
                                                    <span class=""
                                                        style="text-align: right; font-weight:bold; font-size:30px;">Rp.
                                                        {{ number_format($tot_har, 0, ',', ',') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card cart">
                                    <div class="card-body" style="text-align: right">

                                        {{-- <button style="font-weight: bold; color:black;" class="btn btn-warning "
                                            title="Return Barang"><i class="fa fa-undo"></i></button> --}}
                                        <button style="font-weight: bold;" class="btn btn-info" id="cetak_ulang"
                                            title="Cetak Ulang Faktur/Struk"><i class="fa fa-print"></i></button>
                                        {{-- <button style="font-weight: bold;" class="btn btn-success " id="faktur"
                                            title="Buat Faktur"><i class="fa fa-file"></i></button> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="card cart">
                                    <div class="card-header bg-primary" style="color: white">
                                        <div class="row" style="width: 100%">
                                            <div class="col-6">
                                                @php
                                                    $kat = DB::table('tb_kategori')->get();
                                                @endphp

                                                <select class="form-control select2" name="" id="select-kategori"
                                                    onblur='this.size=1;'
                                                    onchange='this.size=1; this.blur(); show_kat(this)'>

                                                    <option value="" disabled selected>Kategori Barang ..</option>
                                                    @foreach ($kat as $ka)
                                                        <option value="{{ $ka->id_kategori }}">{{ $ka->kategori }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" value=""
                                                    onkeyup="show_search(this)" placeholder="Nama Barang ..">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="overflow-y: scroll; height:65vh;">
                                        <div class="row" id="show_produk">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-12">
                                                <button style="width: 100%;font-weight: bold;" id="bayar"
                                                    class="btn btn-primary btn-lg">BAYAR</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW-1 CLOSED -->
                    </div>
                    <!-- CONTAINER CLOSED -->
                </div>
            </div>
            <!--app-content closed-->
        </div>

        <!-- MODAL EFFECTS -->
        <div class="modal fade" id="modalLogin" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered  modal-sm text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="container" style="text-align: center; margin-top:-40%;">
                        <img src="{{ asset('/') }}assets/images/brand/logo-2.png" width="150px;" alt="Logo">
                    </div>
                    <div class="modal-body">

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-hidden="true">×</button>
                                <i class="fa fa-check-circle-o me-2" aria-hidden="true"></i> {{ $message }}.
                            </div>
                        @endif

                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-hidden="true">×</button>
                                <i class="fa fa-frown-o me-2" aria-hidden="true"></i>{{ $message }}
                            </div>
                        @endif

                        <div class="container">
                            <form action="{{ route('postlogin') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="text" class="form-control" name="email" placeholder="Username"
                                        required="required">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Password"
                                        required="required">
                                </div>
                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-primary btn-lg btn-block login-btn">Masuk</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="modalBayar" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="container" style="text-align: center;">
                            <img src="{{ asset('/') }}assets/images/brand/logo-2.png" width="50px;" alt="Logo">
                            <h3 class="mt-1"><b>PEMBAYARAN</b> </h3>
                        </div>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="background:#6C5FFC; padding-top:15px;">
                            <div class="col-6">
                                <h2 style="color: white; font-size: 30px;">Total Bayar :</h2>
                            </div>
                            <div class="col-6">
                                <h2 style="color: white">
                                    <span class="" style="text-align: right;">
                                        <h2 style="font-size: 40px; font-weight:bold"><b>Rp. </b><b
                                                id="total_harga2">{{ number_format($tot_har, 0, ',', ',') }}</b>
                                        </h2>
                                    </span>
                                </h2>
                            </div>
                        </div>
                        <form action="{{ route('kasir.transaksi') }}" method="post">
                            {{ csrf_field() }}

                            <div class="row my-4">
                                <label class="col-md-3 form-label" style="font-size: 16px;">Transaksi Kasbon</label>
                                <div class="col-md-9">
                                    <span class="" style="text-align: left;">
                                        <input type="checkbox" class="form-check-input largerCheckbox"
                                            name="kasbon_stat" style="margin-left: 1px;" id="kasbon_chk"></label>
                                    </span>
                                </div>
                            </div>

                            
                            <div id="with_kasbon">


                                <div class="row my-4">
                                    <label class="col-md-3 form-label" style="font-size: 16px;">No Identitas</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="no_id">
                                    </div>
                                </div>

                                <div class="row my-4">
                                    <label class="col-md-3 form-label" style="font-size: 16px;">Nama</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="nama">
                                    </div>
                                </div>
                                
                                <div class="row my-4">
                                    <label class="col-md-3 form-label" style="font-size: 16px;">Alamat</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="alamat">
                                    </div>
                                </div>
                                
                                <div class="row my-4">
                                    <label class="col-md-3 form-label" style="font-size: 16px;">No Telepon</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="no_telp">
                                    </div>
                                </div>
                            </div>                            

                            <div id="no_kasbon">
                                <div id="texttunai" class="row my-4">
                                    <label class="col-md-3 form-label" style="font-size: 16px;">Pembayaran
                                        Tunai</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control money"
                                            style="font-size: 30px; font-weight:bold; text-align:right;" id="tunai"
                                            name="tunai" placeholder="0" onkeyup="showKembali(this.value); "
                                            onchange="showKembali(this);">
                                    </div>
                                </div>

                                {{-- <div id="btntunai" class="row my-4">
                            <label class="col-md-3 form-label"></label>
                            <div class="col-md-9">
                                <button type="button" name="button" id="btn_pas" class="btn mr-2"
                                    onclick="btnPrice(this.value);" style="background: #0f4c75; color: white;"><span
                                        id="tot_pas"></span></button>
                                <button type="button" name="button" class="btn mr-2" value="100000"
                                    onclick="btnPrice(this.value);"
                                    style="background: #0f4c75; color: white;">Rp.100.000</button>
                                <button type="button" name="button" class="btn mr-2" value="50000"
                                    onclick="btnPrice(this.value);"
                                    style="background: #0f4c75; color: white;">Rp.50.000</button>
                                <button type="button" name="button" class="btn mr-2" value="20000"
                                    onclick="btnPrice(this.value);"
                                    style="background: #0f4c75; color: white;">Rp.20.000</button>
                                <button type="button" name="button" class="btn mr-2" value="10000"
                                    onclick="btnPrice(this.value);"
                                    style="background: #0f4c75; color: white;">Rp.10.000</button>
                                <div class="col-sm-10 mt-2" style="text-align: center">
                                    <button type="button" name="button" class="btn btn-danger mr-2"
                                        onclick="btnClear();" style="width:100px;" text-align="center"><i
                                            class="fa fa-trash"> </i> Clear</button>

                                </div>
                            </div>
                        </div> --}}

                                <div class="row my-4">
                                    <label class="col-md-3 form-label" style="font-size: 16px;">Tambah Potongan</label>
                                    <div class="col-md-9">
                                        <span class="" style="text-align: left;">
                                            <input type="checkbox" class="form-check-input largerCheckbox"
                                                style="margin-left: 1px;" id="pot_chk"></label>
                                        </span>
                                    </div>
                                </div>

                                <div id="potongan_div" class="row my-4">
                                    <label class="col-md-3 form-label" style="font-size: 16px;">Potongan</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control money"
                                            style="font-size: 30px; font-weight:bold; text-align:right;"
                                            id="potongan_ins" name="potongan" placeholder="0">
                                    </div>
                                </div>

                                <div id="textkembalian" class="row my-4">
                                    <label class="col-md-3 form-label" style="font-size: 16px;">Kembalian</label>
                                    <div class="col-md-9">
                                        <span class="" style="text-align: right;">
                                            <h2 id="kembalian" style="font-size: 30px;font-weight:bold"></h2>
                                        </span>
                                    </div>
                                </div>



                                <div id="total_harga3" hidden>
                                    <input id="total_hjual" name="total_hjual"
                                        value="{{ number_format($tot_har, 0, ',', ',') }}">
                                    <input id="total_hbeli" name="total_hbeli"
                                        value="{{ number_format($tot_har_bel, 0, ',', ',') }}">
                                    <input id="kembalian2" name="kembalian">
                                </div>


                                <button class="btn btn-primary btn-lg" type="submit" style="width: 100%"
                                    id="btn_bayar"><b>BAYAR</b>
                                </button>
                            </div>
                            <div id="kasbon_sub">
                                <button class="btn btn-primary btn-lg" type="submit" style="width: 100%"
                                    id="btn_kasbon_sub"><b>Proses
                                        Kasbon</b>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalfaktur" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="container" style="text-align: center;">
                            <img src="{{ asset('/') }}assets/images/brand/logo-2.png" width="50px;" alt="Logo">
                            <h3 class="mt-1"><b>Buat Faktur</b> </h3>
                        </div>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('kasir.buat.faktur') }}" method="post">
                            {{ csrf_field() }}

                            <div class="row my-4">
                                <label class="col-md-3 form-label">Nama</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="nama" required
                                        placeholder="Nama .. ">
                                </div>
                            </div>

                            <div class="row my-4">
                                <label class="col-md-3 form-label">No. Telp</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="no_telp" required
                                        placeholder="Nomor Telepon .. ">
                                </div>
                            </div>

                            <div class="row my-4">
                                <label class="col-md-3 form-label">Alamat</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="alamat" required
                                        placeholder="Alamat .. ">
                                </div>
                            </div>


                            <div class="row my-4">
                                <label class="col-md-3 form-label">Pilih No Transaksi</label>
                                <div class="col-md-9">

                                    @php
                                        $kat = DB::table('tb_transaksi')
                                            ->orderby('id_transaksi', 'desc')
                                            ->get();
                                    @endphp

                                    <select class="form-control" name="id_transaksi" id="pilih_id_transaksi"
                                        required>

                                        <option value="" disabled selected>No Transaksi</option>
                                        @foreach ($kat as $ka)
                                            <option value="{{ $ka->kd_transaksi }}">{{ $ka->kd_transaksi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-primary btn-lg" type="submit" style="width: 100%"><b>Print
                                    Faktur</b>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modal_tran" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document" style="margin-top: -5%;">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="cetak_main">
                            <div class="container" style="text-align: center; ">
                                <img style="margin-top: 20px;" src="{{ asset('/') }}assets/images/brand/success.png"
                                    width="60px;" alt="Logo">
                                <h3 class="mt-1" style="font-weight: bold">Transaksi Berhasil!</h3>
                                <h5 class="mt-2" style="margin-bottom: 10px;">Cetak Struk/Faktur?</h5>
                                <div class="row mt-3" style="margin-bottom: 20px;">
                                    <div class="col-4">
                                        <button class="btn btn-success btn-lg" id="cetak_struk"><i
                                                class="fa fa-align-justify"></i> Struk</button>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-danger btn-lg" id="cetak_batal"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-primary btn-lg" id="cetak_faktur"><i
                                                class="fa fa-file"></i> Faktur</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="cetak_main_faktur">
                            <div class="row">
                                <div class="col-10">

                                    <h3 class="mt-1 text-center" style="font-weight: bold; margin-left:60px;"><i
                                            class="fa fa-print"></i> Cetak
                                        Faktur</h3>
                                </div>
                                <div class="col-2">

                                    <button id="cetak_main_faktur_batal" class="btn btn-danger btn-sm"
                                        style="margin-left:30px;"><i class="fa fa-times"></i></button>
                                </div>
                            </div>

                            <form id="form_faktur" action="{{ route('kasir.buat.faktur') }}" method="post"
                                target="_blank">
                                {{ csrf_field() }}

                                <input type="text" class="form-control" name="id" id="id_main_faktur" hidden>

                                <div class="row my-4">
                                    <label class="col-md-3 form-label">Nama</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="nama" required
                                            placeholder="Nama .. ">
                                    </div>
                                </div>

                                <div class="row my-4">
                                    <label class="col-md-3 form-label">No. Telp</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="no_telp" required
                                            placeholder="Nomor Telepon .. ">
                                    </div>
                                </div>

                                <div class="row my-4">
                                    <label class="col-md-3 form-label">Alamat</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="alamat" required
                                            placeholder="Alamat .. ">
                                    </div>
                                </div>


                                <div class="row my-4">
                                    <label class="col-md-3 form-label">Pilih Kop</label>
                                    <div class="col-md-9">

                                        @php
                                            $kat = DB::table('tb_toko')
                                                ->orderby('id', 'desc')
                                                ->get();
                                        @endphp

                                        <select class="form-control" name="id_kop" id="pilih_id_kop" required>

                                            <option value="" disabled selected>Pilih Kop</option>
                                            @foreach ($kat as $ka)
                                                <option value="{{ $ka->id }}">{{ $ka->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-primary btn-lg" id="faktur_submit" type="button"
                                    style="width: 100%"><b><i class="fa fa-print"></i> Cetak Faktur</b>
                                </button>
                            </form>
                        </div>

                        <div id="cetak_main_struk">
                            <div class="row">
                                <div class="col-10">

                                    <h3 class="mt-1 text-center" style="font-weight: bold; margin-left:60px;"><i
                                            class="fa fa-print"></i> Cetak
                                        Struk</h3>
                                </div>
                                <div class="col-2">

                                    <button id="cetak_main_struk_batal" class="btn btn-danger btn-sm"
                                        style="margin-left:30px;"><i class="fa fa-times"></i></button>
                                </div>
                            </div>

                            <form id="form_struk" action="{{ route('kasir.buat.struk') }}" method="post"
                                target="_blank">
                                {{ csrf_field() }}

                                <input type="text" class="form-control" name="id" id="id_main_struk" hidden
                                    placeholder="">

                                <div class="row my-4">
                                    <label class="col-md-3 form-label">Pilih Kop</label>
                                    <div class="col-md-9">

                                        @php
                                            $kat = DB::table('tb_toko')
                                                ->orderby('id', 'desc')
                                                ->get();
                                        @endphp

                                        <select class="form-control" name="id_kop" id="pilih_id_kop2" required>

                                            <option value="" disabled selected>Pilih Kop</option>
                                            @foreach ($kat as $ka)
                                                <option value="{{ $ka->id }}">{{ $ka->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-primary btn-lg" id="struk_submit" type="button"
                                    style="width: 100%"><b><i class="fa fa-print"></i> Cetak Struk</b>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modal_cetak_ulang" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document" style="margin-top: -5%;">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="cetak_ulang_main">
                            <div class="container" style="text-align: center; ">
                                {{-- <img style="margin-top: 20px;" src="{{ asset('/') }}assets/images/brand/success.png" width="60px;" alt="Logo"> --}}
                                <div class="row">
                                    <div class="col-11">
                                        <h3 class="mt-1" style="font-weight: bold; margin-left: 60px;">Cetak
                                            Ulang Struk/Faktur
                                        </h3>

                                    </div>
                                    <div class="col-1">

                                        <button class="btn btn-danger btn-sm float-right" id="btn_cetak_ulang_batal"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="row mt-3" style="margin-bottom: 20px;">
                                    <div class="col-6">
                                        <button class="btn btn-success btn-lg" id="btn_cetak_ulang_struk"><i
                                                class="fa fa-align-justify"></i> Struk</button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-primary btn-lg" id="btn_cetak_ulang_faktur"><i
                                                class="fa fa-file"></i> Faktur</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="cetak_ulang_faktur">
                            <div class="row">
                                <div class="col-9">

                                    <h3 class="mt-1 text-center" style="font-weight: bold; margin-left:60px;"><i
                                            class="fa fa-print"></i> Cetak
                                        Faktur</h3>
                                </div>
                                <div class="col-3">

                                    <button title="Cetak Faktur Lama" id="cetak_ulang_faktur_lama"
                                        class="btn btn-success btn-sm" style="margin-left:30px;"><i
                                            class="fa fa-print"></i></button>
                                    <button title="Batal" id="cetak_ulang_faktur_batal"
                                        class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                                </div>
                            </div>

                            <form id="form_buat_faktur" action="{{ route('buat.faktur') }}" method="post"
                                target="_blank">
                                {{ csrf_field() }}

                                <div class="row my-4">
                                    <label class="col-md-3 form-label">Nama</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="nama" required
                                            placeholder="Nama .. ">
                                    </div>
                                </div>

                                <div class="row my-4">
                                    <label class="col-md-3 form-label">No. Telp</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="no_telp" required
                                            placeholder="Nomor Telepon .. ">
                                    </div>
                                </div>

                                <div class="row my-4">
                                    <label class="col-md-3 form-label">Alamat</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="alamat" required
                                            placeholder="Alamat .. ">
                                    </div>
                                </div>

                                <div class="row my-4">
                                    <label class="col-md-3 form-label">Pilih No Transaksi</label>
                                    <div class="col-md-9">

                                        @php
                                            $kat = DB::table('tb_transaksi')
                                                ->orderby('id_transaksi', 'desc')
                                                ->get();
                                        @endphp

                                        <select class="form-control" name="id_transaksi" id="pilih_id_transaksi_1"
                                            required>

                                            <option value="" disabled selected>No Transaksi</option>
                                            @foreach ($kat as $ka)
                                                <option value="{{ $ka->kd_transaksi }}">{{ $ka->kd_transaksi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row my-4">
                                    <label class="col-md-3 form-label">Pilih Kop</label>
                                    <div class="col-md-9">

                                        @php
                                            $kat = DB::table('tb_toko')
                                                ->orderby('id', 'desc')
                                                ->get();
                                        @endphp

                                        <select class="form-control" name="id_kop" id="pilih_id_kop3" required>

                                            <option value="" disabled selected>Pilih Kop</option>
                                            @foreach ($kat as $ka)
                                                <option value="{{ $ka->id }}">{{ $ka->nama }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-primary btn-lg" id="faktur_buat_submit" type="button"
                                    style="width: 100%"><b><i class="fa fa-print"></i> Cetak Faktur</b>
                                </button>
                            </form>
                        </div>

                        <div id="cetak_ulang_struk">
                            <div class="row">
                                <div class="col-10">

                                    <h3 class="mt-1 text-center" style="font-weight: bold; margin-left:60px;"><i
                                            class="fa fa-print"></i> Cetak
                                        Struk</h3>
                                </div>
                                <div class="col-2">

                                    <button id="cetak_ulang_struk_batal" class="btn btn-danger btn-sm"
                                        style="margin-left:30px;"><i class="fa fa-times"></i></button>
                                </div>
                            </div>

                            <form id="form_ulang_struk" action="{{ route('kasir.ulang.struk') }}" method="post"
                                target="_blank">
                                {{ csrf_field() }}

                                <div class="row my-4">
                                    <label class="col-md-3 form-label">Pilih No Transaksi</label>
                                    <div class="col-md-9">

                                        @php
                                            $kat = DB::table('tb_transaksi')
                                                ->orderby('id_transaksi', 'desc')
                                                ->get();
                                        @endphp

                                        <select class="form-control" name="id_transaksi" id="pilih_id_transaksi_2"
                                            required>

                                            <option value="" disabled selected>No Transaksi</option>
                                            @foreach ($kat as $ka)
                                                <option value="{{ $ka->kd_transaksi }}">{{ $ka->kd_transaksi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <label class="col-md-3 form-label">Pilih Kop</label>
                                    <div class="col-md-9">

                                        @php
                                            $kat = DB::table('tb_toko')
                                                ->orderby('id', 'desc')
                                                ->get();
                                        @endphp

                                        <select class="form-control" name="id_kop" id="pilih_id_kop4" required>

                                            <option value="" disabled selected>Pilih Kop</option>
                                            @foreach ($kat as $ka)
                                                <option value="{{ $ka->id }}">{{ $ka->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-primary btn-lg" id="struk_ulang_submit" type="button"
                                    style="width: 100%"><b><i class="fa fa-print"></i> Cetak Struk</b>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modal_cetak_ulang_faktur_lama" data-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="margin-top: -5%;">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-11">
                                <h3 class="mt-1 text-center" style="font-weight: bold; margin-left: 60px;">Cetak Ulang
                                    Faktur Lama</h3>

                            </div>
                            <div class="col-1">

                                <button class="btn btn-danger btn-sm float-right" id="btn_cetak_ulang_lama_batal"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tabel_faktur_lama" class="table table-bordered table-vcenter "
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No.Faktur</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No Telp</th>
                                        <th>Kode Transaksi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <!-- JQUERY JS -->
    <script src="{{ asset('/') }}assets/js/jquery.min.js"></script>

    <!-- BOOTSTRAP JS -->
    <script src="{{ asset('/') }}assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="{{ asset('/') }}assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- SPARKLINE JS-->
    <script src="{{ asset('/') }}assets/js/jquery.sparkline.min.js"></script>

    <!-- CHART-CIRCLE JS-->
    <script src="{{ asset('/') }}assets/js/circle-progress.min.js"></script>

    <!-- INPUT MASK JS-->
    <script src="{{ asset('/') }}assets/plugins/input-mask/jquery.mask.min.js"></script>

    <!-- SIDE-MENU JS -->
    <script src="{{ asset('/') }}assets/plugins/sidemenu/sidemenu.js"></script>

    <!-- CHARTJS JS -->
    <script src="{{ asset('/') }}assets/plugins/chart/Chart.bundle.js"></script>
    <script src="{{ asset('/') }}assets/plugins/chart/utils.js"></script>

    <!-- SIDEBAR JS -->
    <script src="{{ asset('/') }}assets/plugins/sidebar/sidebar.js"></script>

    <!-- Perfect SCROLLBAR JS-->
    {{-- <script src="{{ asset('/') }}assets/plugins/p-scroll/perfect-scrollbar.js"></script> --}}
    {{-- <script src="{{ asset('/') }}assets/plugins/p-scroll/pscroll.js"></script> --}}
    {{-- <script src="{{ asset('/') }}assets/plugins/p-scroll/pscroll-1.js"></script> --}}

    <!-- Handle Counter js -->
    <script src="{{ asset('/') }}assets/js/handlecounter.js"></script>

    <!-- Color Theme js -->
    <script src="{{ asset('/') }}assets/js/themeColors.js"></script>

    <!-- Sticky js -->
    <script src="{{ asset('/') }}assets/js/sticky.js"></script>

    <!-- CUSTOM JS -->
    <script src="{{ asset('/') }}assets/js/custom.js"></script>
    <script src="{{ asset('/') }}assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/') }}assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
    <script src="{{ asset('/') }}assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/') }}assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
    <script src="{{ asset('/') }}assets/plugins/datatable/js/jszip.min.js"></script>
    <script src="{{ asset('/') }}assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('/') }}assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('/') }}assets/plugins/datatable/js/buttons.html5.min.js"></script>
    <script src="{{ asset('/') }}assets/plugins/datatable/js/buttons.print.min.js"></script>
    <script src="{{ asset('/') }}assets/plugins/datatable/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('/') }}assets/plugins/datatable/dataTables.responsive.min.js"></script>
    <script src="{{ asset('/') }}assets/plugins/datatable/responsive.bootstrap5.min.js"></script>
    <script src="{{ asset('/') }}assets/js/table-data.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/js/jquery.mask.js"></script>
    <script src="{{ asset('/') }}assets/plugins/sweet-alert/sweetalert.min.js"></script>
    <script src="{{ asset('/') }}assets/js/sweet-alert.js"></script>


    <script src="{{ asset('/') }}assets/js/select2.min.js"></script>
    <script src="{{ asset('/') }}assets/js/main.js"></script>

    @if ($message = Session::get('tran_ok'))
        <script>
            $(document).ready(function() {
                link = "{{ Session::get('sess_id_trans') }}";
                // console.log(link);
                // window.open(window.location.href + "kasir/cetak-struk/" + link);
                $('#modal_tran').modal('show');
                $('#cetak_main').show(200);
                $('#id_main_struk').val(link);
                $('#id_main_faktur').val(link);
                // swal('{{ $message }}', '', 'success');
            })
        </script>
    @endif

    @if ($message = Session::get('tran_gagal'))
        <script>
            $(document).ready(function() {
                link = "{{ $message }}";
                // console.log(link);
                // alert(link);
                swal('{{ $message }}', '', 'error');
                $('#modalBayar').modal('show');
            })
        </script>
    @endif

    <script>
        $(document).ready(function() {
            show_produk();

            $('#cetak_main_faktur').hide(200);
            $('#cetak_main_struk').hide(200);
            $('#cetak_ulang_faktur').hide(200);
            $('#cetak_ulang_struk').hide(200);
            $("#kasbon_sub").hide(200);
            $("#with_kasbon").hide(200);

            $('#modal_tran').modal({
                backdrop: 'static',
                keyboard: false
            })

            $('#modalLogin').modal({
                backdrop: 'static',
                keyboard: false
            })

            $('#modalfaktur').modal({
                backdrop: 'static',
                keyboard: false
            })

            $("#cetak_faktur").click(function() {
                $('#cetak_main').hide(200);
                $('#cetak_main_faktur').show(200);
            });

            $("#cetak_struk").click(function() {
                $('#cetak_main').hide(200);
                $('#cetak_main_struk').show(200);
            });

            $("#cetak_ulang").click(function() {
                $('#modal_cetak_ulang').modal('show');
                $('#cetak_ulang_main').show(200);
            });

            $("#btn_cetak_ulang_faktur").click(function() {
                $('#cetak_ulang_main').hide(200);
                $('#cetak_ulang_faktur').show(200);
            });

            $("#btn_cetak_ulang_struk").click(function() {
                $('#cetak_ulang_main').hide(200);
                $('#cetak_ulang_struk').show(200);
            });

            $("#cetak_main_faktur_batal").click(function() {
                $('#cetak_main_faktur').hide(200);
                $('#cetak_main').show(200);
            });

            $("#cetak_main_struk_batal").click(function() {
                $('#cetak_main_struk').hide(200);
                $('#cetak_main').show(200);
            });

            $("#cetak_ulang_faktur_batal").click(function() {
                $('#cetak_ulang_faktur').hide(200);
                $('#cetak_ulang_main').show(200);
            });

            $("#cetak_ulang_struk_batal").click(function() {
                $('#cetak_ulang_struk').hide(200);
                $('#cetak_ulang_main').show(200);
            });


            $("#cetak_batal").click(function() {
                $('#cetak_main').hide(200);
                $('#cetak_main_struk').hide(200);
                $('#cetak_main_faktur').hide(200);
                $('#modal_tran').modal('hide');

                @php
                Session::forget('sess_id_trans');
                @endphp
            });


            $("#btn_cetak_ulang_batal").click(function() {
                $('#cetak_ulang_main').hide(200);
                $('#cetak_ulang_struk').hide(200);
                $('#cetak_ulang_faktur').hide(200);
                $('#modal_cetak_ulang').modal('hide');
            });



            $("#faktur_submit").click(function() {
                $('#form_faktur').submit();
                $('#form_faktur').trigger("reset");
                $('#cetak_main').hide(200);
                $('#cetak_main_faktur').hide(200);
                $('#modal_tran').modal('hide');
            });

            $("#struk_submit").click(function() {
                $('#form_struk').submit();
                $('#form_struk').trigger("reset");
                $('#cetak_main').hide(200);
                $('#cetak_main_struk').hide(200);
                $('#modal_tran').modal('hide');
            });


            $("#struk_ulang_submit").click(function() {
                $('#form_ulang_struk').submit();
                $('#form_ulang_struk').trigger("reset");
                $('#cetak_ulang_main').hide(200);
                $('#cetak_ulang_struk').hide(200);
                $('#modal_cetak_ulang').modal('hide');
            });


            $("#faktur_buat_submit").click(function() {
                $('#form_buat_faktur').submit();
                $('#form_buat_faktur').trigger("reset");
                $('#cetak_ulang_main').hide(200);
                $('#cetak_ulang_faktur').hide(200);
                $('#modal_cetak_ulang').modal('hide');
            });


            $("#faktur_ulang_submit").click(function() {
                $('#form_ulang_faktur').submit();
                $('#form_ulang_faktur').trigger("reset");
                $('#cetak_ulang_main').hide(200);
                $('#cetak_ulang_faktur').hide(200);
                $('#modal_cetak_ulang').modal('hide');
            });

            $("#cetak_ulang_faktur_lama").click(function() {
                $('#cetak_ulang_main').hide(200);
                $('#cetak_ulang_faktur').hide(200);
                $('#modal_cetak_ulang').modal('hide');

                $('#tabel_faktur_lama').DataTable({
                    paging: true,
                    destroy: true,
                    "ordering": false,
                    "info": false,
                    searching: true,
                    autoWidth: false,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "/kasir/get_faktur_lama",
                        type: 'GET'
                    },
                    columns: [{
                            "data": null,
                            "sortable": false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'kd'
                        },
                        {
                            data: 'nama'
                        },
                        {
                            data: 'alamat'
                        },
                        {
                            data: 'no_telp'
                        },
                        {
                            data: 'id_trans'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `<button id="` + data.kd +
                                    `" class="btn text-danger bg-danger-transparent btn-icon" onClick="print_ulang_ini(this.id)"><span class="fa fa-print"></span></button>`;
                            }
                        },
                    ],
                });

                $('#modal_cetak_ulang_faktur_lama').modal('show');
            });


            $("#btn_cetak_ulang_lama_batal").click(function() {
                $('#tabel_faktur_lama').DataTable().destroy();
                $('#modal_cetak_ulang_faktur_lama').modal('hide');
                $('#cetak_ulang_main').hide(200);
                $('#cetak_ulang_faktur').show(200);
                $('#modal_cetak_ulang').modal('show');
            });

            $('.select2').select2();

            $("#pilih_id_transaksi").select2({
                dropdownParent: $("#modalfaktur")
            });

            $("#pilih_id_transaksi_1").select2({
                dropdownParent: $("#modal_cetak_ulang")
            });

            $("#pilih_id_transaksi_2").select2({
                dropdownParent: $("#modal_cetak_ulang")
            });

            $("#pilih_id_kop").select2({
                dropdownParent: $("#modal_tran")
            });

            $("#pilih_id_kop2").select2({
                dropdownParent: $("#modal_tran")
            });
            $("#pilih_id_kop3").select2({
                dropdownParent: $("#modal_cetak_ulang")
            });

            $("#pilih_id_kop4").select2({
                dropdownParent: $("#modal_cetak_ulang")
            });

            $("#barcode").focus();

            $("#bayar").click(function() {
                $('#modalBayar').modal('show');
            });

            $("#faktur").click(function() {
                $('#modalfaktur').modal('show');
            });

            $('.money').mask('000,000,000,000,000', {
                reverse: true
            });

            $("#potongan_div").hide(200);
        });

        $("#pot_chk").change(function() {
            if (this.checked) {
                $("#potongan_div").show(200);
            } else {
                $("#potongan_div").hide(200);
            }
        });


        $("#kasbon_chk").change(function() {
            if (this.checked) {
                harga_temp = $("#total_harga2").text();
                $("#no_kasbon").hide(200);
                $("#with_kasbon").show(200);
                $("#kasbon_sub").show(200);

                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/kasir/kasbon_true',
                    success: function(data) {
                        $("#total_harga2").unmask();
                        $("#total_harga2").text(data).mask('000,000,000,000,000', {
                            reverse: true
                        });

                        $("#total_hjual").unmask();
                        $("#total_hjual").val(data).mask('000,000,000,000,000', {
                            reverse: true
                        });

                        // console.log(harga_temp, data);
                        $('#btn_kasbon_sub').removeAttr("disabled");
                    },
                    error: function(request, status, error) {
                        alert(error);
                        $('#btn_kasbon_sub').attr("disabled", "disabled");
                    }
                });
            } else {
                $("#kasbon_sub").hide(200);
                $("#no_kasbon").show(200);
                $("#with_kasbon").hide(200);
                $("#total_harga2").text(harga_temp);
                $("#total_hjual").unmask();
                $("#total_hjual").val(harga_temp).mask('000,000,000,000,000', {
                    reverse: true
                });
            }
        });

        $("#potongan_ins").keyup(function() {
            var harga = $("#tunai").val();
            showKembali(harga);
        });
    </script>


    @if (Auth::check() == false)
        <script>
            $(document).ready(function() {
                $('#modalLogin').modal('show');
            });
        </script>
    @else
        <script>
            $(document).ready(function() {
                $('#modalLogin').modal('hide');
                show_list(); //funggsi menampilkan list belanjaan
                show_produk(); //menampilkan list produk
            });
        </script>
    @endif


    <script>
        $.extend(true, $.fn.dataTable.defaults, {

        });
    </script>

    <script>
        var $loading = $('#loading').hide(200);
        $(document)
            .ajaxStart(function() {
                $loading.show(200);
            })
            .ajaxStop(function() {
                $loading.hide(200);
            });

        $('#btn_bayar').attr("disabled", "disabled");
    </script>

    <script>
        window.onafterprint = function() {
            console.log("Printing completed...");
        }
    </script>
</body>

</html>
