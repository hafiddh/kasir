<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use DataTables;
use Session;
use Carbon\Carbon;

class KasirController extends Controller
{

	public function show_list()
	{
		$data = $this->Barang_model->TxTemp();
		echo json_encode($data);
	}

	public function edit_list()
	{
		$data = $this->Barang_model->update_list();
		echo json_encode($data);
	}
	public function delete_list()
	{
		$data = $this->Barang_model->delete_list();
		echo json_encode($data);
	}

	public function get_produk()
	{
		$data = DB::table('tb_produk')
			// ->offset(4)
			->limit(100)
			->where('stok', '>', '0')
			->orderby('nama_produk', 'ASC')
			->get();

		return response()->json($data);
	}

	public function tambah_barang(Request $request)
	{
		$id_produk = $request->id_produk;
		$hasil = DB::table('tb_transaksi_temp')->where('id_produk', $id_produk)->count();
		if ($hasil == 0) {
			$data = DB::table('tb_produk')->where('id_produk', $id_produk)->first();
			DB::table('tb_transaksi_temp')->insert([
				'id_produk' => $id_produk,
				'id_operator' => auth()->user()->id,
				'harga_jual' => $data->harga_jual,
				'harga_beli' => $data->harga_beli,
				'jumlah' => '1',
				'total_harga' => $data->harga_jual,
				'total_harga_beli' => $data->harga_beli,
			]);
		} else {

			$data = DB::table('tb_transaksi_temp')->where('id_produk', $id_produk)->first();

			$jml = $data->jumlah + 1;
			$total = $data->harga_jual * $jml;
			$total2 = $data->harga_beli * $jml;

			DB::table('tb_transaksi_temp')
				->where('id_produk', $id_produk)
				->update([
					'jumlah' => $jml,
					'total_harga' => $total,
					'total_harga_beli' => $total2,
				]);
		}
	}

	public function tambah_barang_barcode(Request $request)
	{
		$varcode = $request->id_produk;
		$hasil = DB::table('tb_transaksi_temp')
			->leftjoin('tb_produk', 'tb_produk.id_produk', 'tb_transaksi_temp.id_produk')
			->where('tb_produk.barcode', $varcode)
			->count();

		// dd($hasil);

		if ($hasil == 0) {
			$data = DB::table('tb_produk')->where('barcode', $varcode)->first();
			if ($data->stok > 0) {
				DB::table('tb_transaksi_temp')->insert([
					'id_produk' => $data->id_produk,
					'id_operator' => auth()->user()->id,
					'harga_jual' => $data->harga_jual,
					'harga_beli' => $data->harga_beli,
					'jumlah' => '1',
					'total_harga' => $data->harga_jual,
					'total_harga_beli' => $data->harga_beli,
				]);
			} else {
				header('HTTP/1.1 500 Stok Item Kosong!');
				header('Content-Type: application/json; charset=UTF-8');
				die(json_encode(array('message' => 'Stok item kosong!', 'code' => 1337)));
			}
		} else {

			$data = DB::table('tb_transaksi_temp')
				->leftjoin('tb_produk', 'tb_produk.id_produk', 'tb_transaksi_temp.id_produk')
				->where('tb_produk.barcode', $varcode)->first();

			if ($data->stok > 0) {
				$jml = $data->jumlah + 1;
				$total = $data->harga_jual * $jml;
				$total2 = $data->harga_beli * $jml;

				DB::table('tb_transaksi_temp')
					->where('id_produk', $data->id_produk)
					->update([
						'jumlah' => $jml,
						'total_harga' => $total,
						'total_harga_beli' => $total2,
					]);
			} else {
				header('HTTP/1.1 500 Stok Item Kosong!');
				header('Content-Type: application/json; charset=UTF-8');
				die(json_encode(array('message' => 'Stok item kosong!', 'code' => 1337)));
			}
		}
	}

	public function cari_kategori(Request $request)
	{
		$key = $request->key;
		$data = DB::table('tb_produk')
			->leftjoin('tb_kategorisub', 'tb_produk.id_kategorisub', 'tb_kategorisub.id_kategorisub')
			->leftjoin('tb_kategori', 'tb_kategori.id_kategori', 'tb_kategorisub.id_kategori')
			->where('tb_kategori.id_kategori', $key)
			->orderby('nama_produk', 'ASC')
			// ->offset(4)
			->limit(100)
			->get();

		echo json_encode($data);

		// $query = $this->db->query('SELECT tb_kategori.kategori, tb_kategorisub.subkat, tb_produk.id_produk, tb_produk.nama_produk, tb_produk.Hretail1
		// 	from (tb_produk left JOIN tb_kategorisub on tb_produk.id_kategorisub = tb_kategorisub.id_kategorisub )
		// 	LEFT JOIN tb_kategori on tb_kategorisub.id_kategori = tb_kategori.id_kategori WHERE tb_kategori.id_kategori='.$id);
		// $sql=$query->result_array();
		// return $sql;
	}

	public function cari_produk(Request $request)
	{
		$key = $request->key;
		$data = DB::table('tb_produk')
			->where('nama_produk', 'like', '%' . $key . '%')
			->orwhere('id_produk', 'like', $key . '%')
			->orderby('nama_produk', 'ASC')
			->get();

		return response()->json($data);
	}


	public function get_list()
	{
		$info = DB::table('tb_transaksi_temp')
			->leftjoin('tb_produk', 'tb_produk.id_produk', 'tb_transaksi_temp.id_produk')
			->select('tb_transaksi_temp.*', 'tb_produk.nama_produk as nama_produk')
			->where('id_operator', auth()->user()->id)
			->get();

		return Datatables::of($info)->make();
	}

	public function del_list(Request $request)
	{
		DB::table('tb_transaksi_temp')->where('id_transaksi_temp', $request->id)->delete();
		return response()->json();
	}

	public function ubah_qty(Request $request)
	{
		$data = DB::table('tb_transaksi_temp')->where('id_transaksi_temp', $request->id)->first();
		$tot = $data->harga_jual * $request->jml;

		$up = DB::table('tb_transaksi_temp')->where('id_transaksi_temp', $request->id)->update([
			'jumlah' => $request->jml,
			'total_harga' => $tot,
		]);

		return response()->json();
	}


	public function get_faktur_lama()
	{
		$data = DB::table('tb_faktur')->get();
		foreach ($data as $pos) {
			$id = $pos->id;
			$tempArray = json_decode($pos->data, true);
			array_push($tempArray, ['id' => $id]);
			$data_rel[] = $tempArray;
		}

		return Datatables::of($data_rel)->make();
	}

	public function kasbon_true(Request $request)
	{
		$hasil = DB::table('tb_transaksi_temp')
			->leftjoin('tb_produk', 'tb_produk.id_produk', 'tb_transaksi_temp.id_produk')
			->select(DB::raw('tb_transaksi_temp.*, tb_produk.harga_kasbon, (tb_produk.harga_kasbon * tb_transaksi_temp.jumlah) as total_kasbon'))
			->get();

		$hasil2 = DB::table('tb_transaksi_temp')
			->leftjoin('tb_produk', 'tb_produk.id_produk', 'tb_transaksi_temp.id_produk')
			->count();

		if ($hasil2 > 0) {
			$total_kas = 0;
			foreach($hasil as $has){
				$total_kas += $has->total_kasbon;
			}

			return response()->json($total_kas);
		} else {
			header('HTTP/1.1 500 List Barang Kosong!');
			header('Content-Type: application/json; charset=UTF-8');
			die(json_encode(array('message' => 'List Barang Kosong!', 'code' => 1337)));
		}
	}
}
