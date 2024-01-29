<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use PDF;

class TransaksiController extends Controller
{

	public function transaksi(Request $request)
	{

		// dd($request);

		if ($request->kasbon_stat != NULL) {

			if($request->no_id == NULL || $request->nama == NULL || $request->alamat == NULL || $request->no_telp == NULL){
				return redirect()->route('index')->with('tran_gagal', 'No Identitas, Nama, Alamat dan No Telepon wajib diisi pada transaksi kasbon!');
			}
			
			$cek = DB::table('tb_transaksi')->orderby('kd_transaksi', 'DESC')->first();

			if ($cek == null) {
				$string3 = 'TOKO-TR00-00000';
			} else {
				$string3 = $cek->kd_transaksi;
			}
			// dd($cek);

			$string1 = "TOKO-TR";
			$string2 = substr(date("Y"), 2) . "-";
			$string4 = (int) substr($string3, 10, 7);
			$string4++;
			$kd = $string1 . $string2 . sprintf("%05s", $string4);
			// dd($request, $kd, $string1 , $string2, substr($string3,10,7), $string4);

			$hbeli 				= $request->total_hbeli;
			$hjual 				= $request->total_hjual;
			$tunai				= $request->tunai;
			$kembali			= $request->kembalian;

			if ($request->potongan == NULL) {
				$potongan = 0;
			} else {
				$potongan = $request->potongan;;
			}

			$result_tunai = preg_replace("/[^0-9]/", "", $tunai);
			$result_kembali = preg_replace("/[^0-9]/", "", $kembali);
			$result_hjual = preg_replace("/[^0-9]/", "", $hjual);
			$result_hbeli = preg_replace("/[^0-9]/", "", $hbeli);
			$result_potong = preg_replace("/[^0-9]/", "", $potongan);


			$data2 = DB::table('tb_transaksi')->insert([
				'kd_transaksi' => $kd,
				'id_operator' => auth()->user()->id,
				'total_harga_jual' => $result_hjual,
				'total_harga_beli' => $result_hbeli,
				'kasbon' => '1',
				'date' => date('Y-m-d'),
				'time' => date('H:i:s')
			]);


			$data3 = DB::table('tb_user_kasbon')->insert([
				'id_transaksi' => $kd,
				'no_id' => $request->no_id,
				'nama' => $request->nama,
				'alamat' => $request->alamat,
				'no_telp' => $request->no_telp
			]);

			$this->transaksi_det_kasbon($kd);

			Session::flash('sess_id_trans', $kd);
			return redirect()->route('index')->with('tran_ok', 'Transaksi Berhasil!');

		} else {
			//No Kasbon

			$cek = DB::table('tb_transaksi')->orderby('kd_transaksi', 'DESC')->first();

			if ($cek == null) {
				$string3 = 'TOKO-TR00-00000';
			} else {
				$string3 = $cek->kd_transaksi;
			}
			// dd($cek);

			$string1 = "TOKO-TR";
			$string2 = substr(date("Y"), 2) . "-";
			$string4 = (int) substr($string3, 10, 7);
			$string4++;
			$kd = $string1 . $string2 . sprintf("%05s", $string4);
			// dd($request, $kd, $string1 , $string2, substr($string3,10,7), $string4);

			$hbeli 				= $request->total_hbeli;
			$hjual 				= $request->total_hjual;
			$tunai				= $request->tunai;
			$kembali			= $request->kembalian;

			if ($request->potongan == NULL) {
				$potongan = 0;
			} else {
				$potongan = $request->potongan;;
			}

			$result_tunai = preg_replace("/[^0-9]/", "", $tunai);
			$result_kembali = preg_replace("/[^0-9]/", "", $kembali);
			$result_hjual = preg_replace("/[^0-9]/", "", $hjual);
			$result_hbeli = preg_replace("/[^0-9]/", "", $hbeli);
			$result_potong = preg_replace("/[^0-9]/", "", $potongan);


			$data2 = DB::table('tb_transaksi')->insert([
				'kd_transaksi' => $kd,
				'id_operator' => auth()->user()->id,
				'total_harga_jual' => $result_hjual,
				'total_harga_beli' => $result_hbeli,
				'potongan' => $result_potong,
				'tunai' => $result_tunai,
				'kembalian' => $result_kembali,
				'kasbon' => '0',
				'date' => date('Y-m-d'),
				'time' => date('H:i:s')
			]);

			$this->transaksi_det($kd);

			Session::flash('sess_id_trans', $kd);
			return redirect()->route('index')->with('tran_ok', 'Transaksi Berhasil!');
		}
	}


	public function transaksi_det($id)
	{
		$datya = DB::table('tb_transaksi_temp')->where('id_operator', auth()->user()->id)->get();

		foreach ($datya as $hasil) {
			$data = DB::table('tb_transaksi_det')->insert([
				'id_transaksi' => $id,
				'id_produk' => $hasil->id_produk,
				'id_operator' => auth()->user()->id,
				'harga_jual' => $hasil->harga_jual,
				'jumlah' => $hasil->jumlah,
				'total_hjual' => $hasil->total_harga
			]);
		}
		$del = DB::table('tb_transaksi_temp')->where('id_operator', auth()->user()->id)->delete();
	}
	
	public function transaksi_det_kasbon($id)
	{
		// $datya = DB::table('tb_transaksi_temp')->where('id_operator', auth()->user()->id)->get();
		$datya = DB::table('tb_transaksi_temp')
		->leftjoin('tb_produk', 'tb_produk.id_produk', 'tb_transaksi_temp.id_produk')
		->select(DB::raw('tb_transaksi_temp.*, tb_produk.harga_kasbon, (tb_produk.harga_kasbon * tb_transaksi_temp.jumlah) as total_kasbon'))
		->where('id_operator', auth()->user()->id)
		->get();

		// dd($datya);
		foreach ($datya as $hasil) {
			$data = DB::table('tb_transaksi_det')->insert([
				'id_transaksi' => $id,
				'id_produk' => $hasil->id_produk,
				'id_operator' => auth()->user()->id,
				'harga_jual' => $hasil->harga_kasbon,
				'jumlah' => $hasil->jumlah,
				'total_hjual' => $hasil->total_kasbon
			]);
		}
		$del = DB::table('tb_transaksi_temp')->where('id_operator', auth()->user()->id)->delete();
	}


	public function cetak_struk(Request $request)
	{
		// dd($request);
		Session::forget('sess_id_trans');

		$data = DB::table('tb_transaksi')->where('kd_transaksi', $request->id)->first();
		$data_detail = DB::table('tb_transaksi_det')
			->leftjoin('tb_produk', 'tb_transaksi_det.id_produk', 'tb_produk.id_produk')
			->where('id_transaksi', $request->id)
			->select('tb_transaksi_det.*', 'tb_produk.nama_produk', 'tb_produk.satuan')
			->get();
		$data_jumlah = DB::table('tb_transaksi_det')->where('id_transaksi', $request->id)->sum('jumlah');

		$tinggi = 567 + (20 * $data_jumlah);
		// dd($tinggi, $data_jumlah);

		$kop = DB::table('tb_toko')->where('id', $request->id_kop)->first();

		$customPaper = array(0, 0, $tinggi, 283.80);

		$nama_file = $request->id . "_" . date('d-m-Y') . "_struk.pdf";

		$pdf = PDF::loadview('kasir.cetak_struk', [
			'data' => $data,
			'data_detail' => $data_detail,
			'jum' => $data_jumlah,
			'kop' => $kop
		])->setPaper($customPaper, 'landscape');

		return $pdf->download($nama_file);
	}

	public function cetak_faktur(Request $request)
	{
		// dd($request);
		Session::forget('sess_id_trans');

		$data_tr = DB::table('tb_transaksi')->where('kd_transaksi', $request->id)->first();
		$kasir = auth()->user()->nama;

		$data_det_tr = DB::table('tb_transaksi_det')
			->leftjoin('tb_produk', 'tb_transaksi_det.id_produk', 'tb_produk.id_produk')
			->where('id_transaksi', $data_tr->kd_transaksi)
			->select('tb_transaksi_det.*', 'tb_produk.nama_produk', 'tb_produk.satuan')
			->get();

		$data_jumlah = DB::table('tb_transaksi_det')->where('id_transaksi', $data_tr->kd_transaksi)
			->sum('jumlah');

		$kop = DB::table('tb_toko')->where('id', $request->id_kop)->first();

		$string1 = "INV-";
		$string2 = substr(date("Y"), 2) . "-";
		$string4 = (int) substr($data_tr->kd_transaksi, 10, 7);
		$kd = $string1 . $string2 . sprintf("%05s", $string4);

		$data_enc = json_encode([
			'transakasi' => $data_tr,
			'transakasi_detail' => $data_det_tr,
			'kasir' => $kasir,
			'nama' => $request->nama,
			'no_telp' => $request->no_telp,
			'alamat' => $request->alamat,
			'jum' => $data_jumlah,
			'id_trans' => $request->id,
			'kd' => $kd,
			'kop' => $kop
		]);

		$data2 =  DB::table('tb_faktur')->insert([
			'data' => $data_enc
		]);

		$pdf = PDF::loadview('kasir.cetak_faktur', [
			'transakasi' => $data_tr,
			'transakasi_detail' => $data_det_tr,
			'kasir' => $kasir,
			'nama' => $request->nama,
			'no_telp' => $request->no_telp,
			'alamat' => $request->alamat,
			'jum' => $data_jumlah,
			'id_trans' => $request->id,
			'kd' => $kd,
			'kop' => $kop
		]);

		DB::delete('delete tb_faktur from tb_faktur inner join ( select max(id) as lastId, data from tb_faktur group by data having count(*) > 1) duplic on duplic.data = tb_faktur.data where tb_faktur.id < duplic.lastId');

		$nama_file = $request->id . "_" . date('d-m-Y') . "_faktur.pdf";
		return $pdf->download($nama_file);
	}

	public function buat_faktur(Request $request)
	{
		// dd($request);
		Session::forget('sess_id_trans');

		$data_tr = DB::table('tb_transaksi')->where('kd_transaksi', $request->id_transaksi)->first();
		$kasir = auth()->user()->nama;

		$data_det_tr = DB::table('tb_transaksi_det')
			->leftjoin('tb_produk', 'tb_transaksi_det.id_produk', 'tb_produk.id_produk')
			->where('id_transaksi', $data_tr->kd_transaksi)
			->select('tb_transaksi_det.*', 'tb_produk.nama_produk', 'tb_produk.satuan')
			->get();

		$data_jumlah = DB::table('tb_transaksi_det')->where('id_transaksi', $data_tr->kd_transaksi)
			->sum('jumlah');

		$kop = DB::table('tb_toko')->where('id', $request->id_kop)->first();

		$string1 = "INV-";
		$string2 = substr(date("Y"), 2) . "-";
		$string4 = (int) substr($data_tr->kd_transaksi, 10, 7);
		$kd = $string1 . $string2 . sprintf("%05s", $string4);

		$data_enc = json_encode([
			'transakasi' => $data_tr,
			'transakasi_detail' => $data_det_tr,
			'kasir' => $kasir,
			'nama' => $request->nama,
			'no_telp' => $request->no_telp,
			'alamat' => $request->alamat,
			'jum' => $data_jumlah,
			'id_trans' => $request->id_transaksi,
			'kd' => $kd,
			'kop' => $kop
		]);

		$data2 =  DB::table('tb_faktur')->insert([
			'data' => $data_enc
		]);

		$pdf = PDF::loadview('kasir.cetak_faktur', [
			'transakasi' => $data_tr,
			'transakasi_detail' => $data_det_tr,
			'kasir' => $kasir,
			'nama' => $request->nama,
			'no_telp' => $request->no_telp,
			'alamat' => $request->alamat,
			'jum' => $data_jumlah,
			'id_trans' => $request->id_transaksi,
			'kd' => $kd,
			'kop' => $kop
		]);

		DB::delete('delete tb_faktur from tb_faktur inner join ( select max(id) as lastId, data from tb_faktur group by data having count(*) > 1) duplic on duplic.data = tb_faktur.data where tb_faktur.id < duplic.lastId');

		$nama_file = $request->id . "_" . date('d-m-Y') . "_faktur.pdf";
		return $pdf->download($nama_file);
	}

	public function cetak_ulang_faktur(Request $request)
	{
		// dd($request);
		Session::forget('sess_id_trans');

		$data_tr = DB::table('tb_transaksi')->where('kd_transaksi', $request->id)->first();
		$kasir = auth()->user()->nama;

		$data_det_tr = DB::table('tb_transaksi_det')
			->leftjoin('tb_produk', 'tb_transaksi_det.id_produk', 'tb_produk.id_produk')
			->where('id_transaksi', $data_tr->kd_transaksi)
			->select('tb_transaksi_det.*', 'tb_produk.nama_produk', 'tb_produk.satuan')
			->get();

		$data_jumlah = DB::table('tb_transaksi_det')->where('id_transaksi', $data_tr->kd_transaksi)
			->sum('jumlah');

		$kop = DB::table('tb_toko')->where('id', $request->id_kop)->first();

		$string1 = "INV-";
		$string2 = substr(date("Y"), 2) . "-";
		$string4 = (int) substr($data_tr->kd_transaksi, 10, 7);
		$kd = $string1 . $string2 . sprintf("%05s", $string4);

		$data_enc = json_encode([
			'transakasi' => $data_tr,
			'transakasi_detail' => $data_det_tr,
			'kasir' => $kasir,
			'nama' => $request->nama,
			'no_telp' => $request->no_telp,
			'alamat' => $request->alamat,
			'jum' => $data_jumlah,
			'id_trans' => $request->id,
			'kd' => $kd,
			'kop' => $kop
		]);

		$data2 =  DB::table('tb_faktur')->insert([
			'data' => $data_enc
		]);

		$pdf = PDF::loadview('kasir.cetak_faktur', [
			'transakasi' => $data_tr,
			'transakasi_detail' => $data_det_tr,
			'kasir' => $kasir,
			'nama' => $request->nama,
			'no_telp' => $request->no_telp,
			'alamat' => $request->alamat,
			'jum' => $data_jumlah,
			'id_trans' => $request->id,
			'kd' => $kd,
			'kop' => $kop
		]);

		DB::delete('delete tb_faktur from tb_faktur inner join ( select max(id) as lastId, data from tb_faktur group by data having count(*) > 1) duplic on duplic.data = tb_faktur.data where tb_faktur.id < duplic.lastId');

		$nama_file = $request->id . "_" . date('d-m-Y') . "_faktur.pdf";
		return $pdf->download($nama_file);
	}

	public function cetak_ulang_faktur_2(Request $request)
	{

		$data2 = DB::table('tb_faktur')->where('data', 'like', '%' . $request->id . '%')->first();

		$data3 = json_decode($data2->data);

		$pdf = PDF::loadview('kasir.cetak_faktur', [
			'transakasi' => $data3->transakasi,
			'transakasi_detail' => $data3->transakasi_detail,
			'kasir' => $data3->kasir,
			'nama' => $data3->nama,
			'no_telp' => $data3->no_telp,
			'alamat' => $data3->alamat,
			'jum' => $data3->jum,
			'id_trans' => $data3->id_trans,
			'kd' => $data3->kd,
			'kop' => $data3->kop
		]);


		$nama_file = $request->id . "_" . date('d-m-Y') . "_faktur.pdf";
		return $pdf->download($nama_file);
	}



	public function cetak_ulang_struk(Request $request)
	{
		// dd($request);
		Session::forget('sess_id_trans');

		$data = DB::table('tb_transaksi')->where('kd_transaksi', $request->id_transaksi)->first();
		$data_detail = DB::table('tb_transaksi_det')
			->leftjoin('tb_produk', 'tb_transaksi_det.id_produk', 'tb_produk.id_produk')
			->where('id_transaksi', $request->id_transaksi)
			->select('tb_transaksi_det.*', 'tb_produk.nama_produk', 'tb_produk.satuan')
			->get();
		$data_jumlah = DB::table('tb_transaksi_det')->where('id_transaksi', $request->id_transaksi)->sum('jumlah');

		$tinggi = 567 + (20 * $data_jumlah);
		// dd($tinggi, $data_jumlah);

		$kop = DB::table('tb_toko')->where('id', $request->id_kop)->first();

		$customPaper = array(0, 0, $tinggi, 283.80);

		$nama_file = $request->id_transaksi . "_" . date('d-m-Y') . "_struk.pdf";

		$pdf = PDF::loadview('kasir.cetak_struk', [
			'data' => $data,
			'data_detail' => $data_detail,
			'jum' => $data_jumlah,
			'kop' => $kop
		])->setPaper($customPaper, 'landscape');

		return $pdf->download($nama_file);
	}


	public function return()
	{
		$id_operator = $this->session->userdata('id_operator');
		$id_transaksi = $this->input->post('id');
		$query = $this->Transaksi_model->getReturn($id_transaksi);

		foreach ($query as $hasil) {
			$data = array(
				'id_produk' => $hasil['id_produk'],
				'id_operator' => $id_operator,
				'Hretail' => $hasil['Hretail'],
				'jumlah' => -$hasil['jumlah'],
				'total_Hretail' => -$hasil['total_Hretail']
			);
			$input = $this->Transaksi_model->input_transaksi_temp($data);
		}

		redirect(base_url(""));
	}


	public function re_print()
	{
		$id_transaksi = $this->input->post('no_struk1');
		$trans = $this->Transaksi_model->getTra($id_transaksi);
		$trans_det = $this->Transaksi_model->getDet($id_transaksi);

		$lol = $trans['id_operator'];
		$id_opr = $this->Transaksi_model->getOpr($lol);
		$opr = $id_opr['nama'];

		$result_kembali = $trans['kembalian'];
		$result_tunai = $trans['tunai'];
		$result_total = $trans['total_Hretail'];

		$debit = $trans['debit'];
		$tgl = $trans['date'];
		$wkt = $trans['time'];

		$date = date_create($tgl);

		function rupiah($angka)
		{
			$hasil_rupiah = "Rp " . number_format($angka);
			return $hasil_rupiah;
		}

		function buatBaris4Kolom($kolom1, $kolom2, $kolom3)
		{
			$lebar_kolom_1 = 17;
			$lebar_kolom_2 = 5;
			$lebar_kolom_3 = 15;
			$kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
			$kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
			$kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);
			$kolom1Array = explode("\n", $kolom1);
			$kolom2Array = explode("\n", $kolom2);
			$kolom3Array = explode("\n", $kolom3);
			$jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array));
			$hasilBaris = array();
			for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {
				$hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
				$hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ", STR_PAD_BOTH);
				$hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);
				$hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3;
			}
			return implode("\n", $hasilBaris) . "\n";
		}

		$connector = new WindowsPrintConnector("epsonlol");

		$logo = EscposImage::load(dirname('C:\xampp\htdocs\KASIR_MB\vendor\mike42\escpos-php\src\Mike42\Escpos\resources\ ') . "/tux.png", false);
		$printer = new Printer($connector);

		$printer->initialize();
		$printer->setJustification(Printer::JUSTIFY_CENTER);
		$printer->bitImageColumnFormat($logo, Printer::IMG_DOUBLE_WIDTH | Printer::IMG_DOUBLE_HEIGHT);
		$printer->text("DEPO MEGA BAJA\n");
		$printer->text("Jl. R. SUPRAPTO No.30A\n");
		$printer->text("Kasir : " . $opr);
		$printer->text("\n");
		$printer->initialize();
		$printer->setJustification(Printer::JUSTIFY_LEFT);
		$printer->text("========================================\n");
		$jum_item = 0;
		$jum_harga = 0;
		foreach ($trans_det as $out) {
			$nama_prod = $this->Transaksi_model->getNamaProduk($out['id_produk']);
			$printer->initialize();
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->text($nama_prod['nama_produk'] . "\n");
			$printer->text(buatBaris4Kolom("   " . $out['jumlah'] . " X @" . number_format($nama_prod['Hretail1']), ":", number_format($out['total_Hretail'])));
			$jum_item = $jum_item + 1;
		}

		$printer->initialize();
		$printer->text("----------------------------------------\n");
		$printer->text(buatBaris4Kolom("Total Item", $jum_item, rupiah($result_total)));
		$printer->text(buatBaris4Kolom("Tunai", '', rupiah($result_tunai)));
		$printer->text(buatBaris4Kolom("Debit", '', rupiah($debit)));
		$printer->text(buatBaris4Kolom("Kembalian", '', rupiah($result_kembali)));
		$printer->text("========================================\n");
		$printer->text(buatBaris4Kolom(date_format($date, "d/m/Y"), '', $wkt));
		$printer->text("----------------------------------------\n");
		$printer->text(buatBaris4Kolom("No. Transaksi", '', $id_transaksi));
		$printer->text("========================================\n");

		$printer->initialize();
		$printer->setJustification(Printer::JUSTIFY_CENTER);
		$printer->text("-= TERIMA KASIH ATAS KUNJUNGAN ANDA =-");
		$printer->feed(2);
		$printer->cut();
		$printer->close();


		redirect(base_url(""));
	}
}
