<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengiriman extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();		
		if ($this->session->userdata('astrosession') == FALSE) {
			redirect(base_url('authenticate'));			
		}
		$this->load->library('form_validation');
		$this->load->library('session');
	}	

    //------------------------------------------ View Data Table----------------- --------------------//
	public function index()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function daftar_pengiriman()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);	
	}
	public function detail()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);	
	}
	public function input_pengiriman()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_validasi', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);	
	}
	public function cari_pengiriman()
	{
		$data['tanggal_awal'] = $this->input->post("tgl_awal");
		$data['tanggal_akhir'] = $this->input->post("tgl_akhir");
		$this->load->view('setting/hasil_cari', $data);
	}
	public function validasi_sedang()
	{
		$data['aktif']='coba';
		$data['konten'] = $this->load->view('setting/validasi_sedang', NULL, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);
	}
	public function coba()
	{
		$data['aktif']='coba';
		$data['konten'] = $this->load->view('setting/pengiriman/coba', NULL, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);
	}
	public function print_pengiriman()
	{
		$this->load->view('setting/pengiriman_print');
	}
	public function tabel_temp_muatan()
	{
		$this->load->view('setting/tabel_opsi_temp');
	}
	public function get_form_coba(){
		@$id = $this->input->post('id');
		@$data['id'] = @$id ;
		$this->load->view('setting/pengiriman/form_penyesuaian',$data);
	}
	public function hapus_muatan_temp(){
		$id = $this->input->post('id');
		$this->db->delete('opsi_transaksi_pengiriman_temp',array('id'=>$id));
	}
	public function cek_qty_pengiriman(){
		$kode_produk = $this->input->post('kode_produk');
		$kode_penjualan = $this->input->post('kode_penjualan');
		
		$this->db->select_sum('jumlah');
		$get_jumlah_temp = $this->db->get_where('opsi_transaksi_pengiriman_temp', array('kode_penjualan' => $kode_penjualan,'kode_produk' => $kode_produk ));
		$hasil_jumlah_temp=$get_jumlah_temp->row();
		//echo $this->db->last_query();
		$get_jumlah_opsi = $this->db->get_where('opsi_transaksi_penjualan', array('kode_penjualan' => $kode_penjualan,'kode_menu' => $kode_produk ));
		$hasil_jumlah_opsi=$get_jumlah_opsi->row();
		$jml_sisa=@$hasil_jumlah_opsi->jumlah - @$hasil_jumlah_temp->jumlah;
		$data=array('jml_penjualan' => @$hasil_jumlah_opsi->jumlah,'jml_kirim'=>@$hasil_jumlah_temp->jumlah,'jml_sisa'=>$jml_sisa );
		echo json_encode($data);

	}
	public function simpan_muatan()
	{
		$kode_penjualan = $this->input->post("kode_penjualan");
		$kode_supir = $this->input->post("kode_supir");
		$kode_kendaraan = $this->input->post("kode_kendaraan");
		$kode_produk = $this->input->post("kode_produk");
		$jam_kirim = $this->input->post("jam_kirim");
		$jumlah = $this->input->post("jumlah");
		
		

		$get_pengiriman = $this->db->get_where('transaksi_pengiriman', array("kode_penjualan" => $kode_penjualan));
		$hasil_pengiriman = $get_pengiriman->result();
		$cek_pengiriman = count($hasil_pengiriman);

		$get_transaksi_penjualan = $this->db->get_where('transaksi_penjualan', array("kode_penjualan" => $kode_penjualan));
		$hasil_transaksi_penjualan = $get_transaksi_penjualan->row();
		
		$get_supir = $this->db->get_where('master_supir', array("kode_supir" => $kode_supir));
		$hasil_supir = $get_supir->row();
		$get_kendaraan = $this->db->get_where('master_kendaraan', array("kode_kendaraan" => $kode_kendaraan));
		$hasil_kendaraan = $get_kendaraan->row();

		$cek_temp_kendaraan = $this->db->get_where('opsi_transaksi_pengiriman_temp', array("kode_penjualan" => $kode_penjualan,"kode_kendaraan" => $kode_kendaraan,"kode_sopir" => $kode_supir));
		$hasil_temp_kendaraan = $cek_temp_kendaraan->row();

		$cek_temp = $this->db->get_where('opsi_transaksi_pengiriman_temp', array("kode_penjualan" => $kode_penjualan));
		$hasil_temp = $cek_temp->result();
		//echo $this->db->last_query();
		
		if(!empty($hasil_temp)){
			$this->db->select_max('id');
			$get_max_order = $this->db->get('opsi_transaksi_pengiriman_temp');
		}else{
			$this->db->select_max('id');
			$get_max_order = $this->db->get('opsi_transaksi_pengiriman');	
		}
		
		$max_order = $get_max_order->row();

		
		if(!empty($hasil_temp)){
			$this->db->where('id', $max_order->id);
			$get_order = $this->db->get('opsi_transaksi_pengiriman_temp');
		}else{
			$this->db->where('id', $max_order->id);
			$get_order = $this->db->get('opsi_transaksi_pengiriman');	
		}
		$order = $get_order->row();
		$tahun = substr(@$order->kode_surat_jalan, 3,4);
		
		if(date('Y')==$tahun){
			$nomor = substr(@$order->kode_surat_jalan, 9);
			
			$nomor = $nomor + 1;
			$string = strlen($nomor);
			if($string == 1){
				$kode_surat_jalan = 'SJ_'.date('Y').'_00000'.$nomor;
			} else if($string == 2){
				$kode_surat_jalan = 'SJ_'.date('Y').'_0000'.$nomor;
			} else if($string == 3){
				$kode_surat_jalan = 'SJ_'.date('Y').'_000'.$nomor;
			} else if($string == 4){
				$kode_surat_jalan = 'SJ_'.date('Y').'_00'.$nomor;
			} else if($string == 5){
				$kode_surat_jalan = 'SJ_'.date('Y').'_0'.$nomor;
			} else if($string == 6){
				$kode_surat_jalan = 'SJ_'.date('Y').'_'.$nomor;
			}
		} else {
			$kode_surat_jalan = 'SJ_'.date('Y').'_000001';
		}
		if(!empty($hasil_temp_kendaraan)){
			$kode_surat_jalan=$hasil_temp_kendaraan->kode_surat_jalan;
		}
		// @$produk = implode(",", $this->input->post("kode_produk"));
		// $kode_produk=explode(",", $produk);
		
		// foreach ($kode_produk as $data_produk) {
		// 	if(!empty($data_produk)){

		$opsi = $this->db->get_where('opsi_transaksi_penjualan',array('kode_penjualan'=>$kode_penjualan,'kode_menu'=>$kode_produk));
		$list_opsi = $opsi->row();

		$data['kode_penjualan'] = $kode_penjualan;
		$data['kode_surat_jalan'] = $kode_surat_jalan;
		$data['tanggal_kirim'] = $hasil_transaksi_penjualan->tanggal_pengiriman;
		$data['kode_sopir'] = $kode_supir;
		$data['nama_sopir'] = $hasil_supir->nama;
		$data['kode_kendaraan'] = $kode_kendaraan;
		$data['no_kendaraan'] = $hasil_kendaraan->no_kendaraan;
		$data['jam'] = $jam_kirim;
		$data['kode_produk'] = $kode_produk;
		$data['nama_produk'] = $list_opsi->nama_menu;
		$data['jumlah'] = $jumlah;
		$this->db->insert("opsi_transaksi_pengiriman_temp", $data);
		//	}
		//}
		
	}
	public function simpan_pengiriman()
	{
		$kode_penjualan = $this->input->post("kode_penjualan");
		$kode_supir = $this->input->post("supir");
		$kode_kendaraan = $this->input->post("kode_kendaraan");
		$get_transaksi_penjualan = $this->db->get_where('transaksi_penjualan', array("kode_penjualan" => $kode_penjualan));

		$get_pengiriman = $this->db->get_where('transaksi_pengiriman', array("kode_penjualan" => $kode_penjualan));
		$hasil_pengiriman = $get_pengiriman->result();
		$cek_pengiriman = count($hasil_pengiriman);

		$hasil_transaksi_penjualan = $get_transaksi_penjualan->row();
		$get_supir = $this->db->get_where('master_supir', array("kode_supir" => $kode_supir));
		$hasil_supir = $get_supir->row();
		$get_kendaraan = $this->db->get_where('master_kendaraan', array("kode_kendaraan" => $kode_kendaraan));
		$hasil_kendaraan = $get_kendaraan->row();


		$cek_temp = $this->db->get_where('opsi_transaksi_pengiriman_temp', array("kode_penjualan" => $kode_penjualan));
		$hasil_temp = $cek_temp->result();
		foreach ($hasil_temp as $temp) {
			$data_opsi['kode_penjualan'] = $temp->kode_penjualan;
			$data_opsi['kode_surat_jalan'] = $temp->kode_surat_jalan;
			$data_opsi['tanggal_kirim'] = $temp->tanggal_kirim;
			$data_opsi['kode_sopir'] = $temp->kode_sopir;
			$data_opsi['nama_sopir'] = $temp->nama_sopir;
			$data_opsi['kode_kendaraan'] = $temp->kode_kendaraan;
			$data_opsi['no_kendaraan'] = $temp->no_kendaraan;
			$data_opsi['jam'] = $temp->jam;
			$data_opsi['kode_produk'] = $temp->kode_produk;
			$data_opsi['nama_produk'] = $temp->nama_produk;
			$data_opsi['jumlah'] = $temp->jumlah;
			$this->db->insert("opsi_transaksi_pengiriman", $data_opsi);
		}
		$data['kode_penjualan'] = $kode_penjualan;
		$data['tanggal_kirim'] = $hasil_transaksi_penjualan->tanggal_pengiriman;
		// $data['kode_sopir'] = $kode_supir;
		// $data['nama_sopir'] = $hasil_supir->nama;
		// $data['kode_kendaraan'] = $kode_kendaraan;
		// $data['no_kendaraan'] = $hasil_kendaraan->no_kendaraan;
		$data['jam'] = $hasil_transaksi_penjualan->jam_pengiriman;
		$data['status_pengiriman'] = "sedang dikirim";
		if($cek_pengiriman<=0){
			$this->db->insert("transaksi_pengiriman", $data);
		} else{
			$this->db->update("transaksi_pengiriman", $data, array("kode_penjualan" => $kode_penjualan));
		}
		
		$data_trans_penjualan['status'] = "sedang dikirim";
		$this->db->update( "transaksi_penjualan", $data_trans_penjualan, array("kode_penjualan" => $kode_penjualan));
		$this->db->delete('opsi_transaksi_pengiriman_temp', array("kode_penjualan" => $kode_penjualan));
	}

	public function update_pengiriman()
	{
		$kode = $this->input->post("id");
		$get_jumlah = $this->db->get_where('opsi_transaksi_penjualan',array('id'  =>  $kode));
		$hasil_jumlah = $get_jumlah->row();
		$jumlah =  $hasil_jumlah->jumlah;
		$harga = $hasil_jumlah->harga_satuan;
		$data['jumlah_retur'] = $this->input->post("qty_retur");
		$data['jumlah'] = $jumlah - $this->input->post("qty_retur");
		$diskon_sub = (($jumlah - $this->input->post("qty_retur")) * $harga) * $hasil_jumlah->diskon_item/100;
		$data['subtotal'] = (($jumlah - $this->input->post("qty_retur")) * $harga) - $diskon_sub;
		$dikon_retur = ($this->input->post("qty_retur") * $harga) * $hasil_jumlah->diskon_item/100;
		$data['subtotal_retur'] = ($this->input->post("qty_retur") * $harga) - $dikon_retur;
		$data['status'] = 'retur';
		$this->db->update( "opsi_transaksi_penjualan", $data, array('id' => $kode));

		
		$masukan['kode_retur'] = 'RT'.$hasil_jumlah->kode_penjualan;
		$masukan['kode_penjualan'] = $hasil_jumlah->kode_penjualan;
		$masukan['kode_produk'] = $hasil_jumlah->kode_menu;
		$masukan['nama_produk'] = $hasil_jumlah->nama_menu;
		$masukan['jumlah'] = $this->input->post("qty_retur");
		$masukan['kode_satuan'] = $hasil_jumlah->kode_satuan;
		$masukan['nama_satuan'] = $hasil_jumlah->nama_satuan;
		$masukan['harga_satuan'] = $hasil_jumlah->harga_satuan;
		$masukan['diskon_item'] = $hasil_jumlah->diskon_item;
		$total = $this->input->post("qty_retur") * $hasil_jumlah->harga_satuan;
		$diskon = $total * $hasil_jumlah->diskon_item/100;
		$masukan['subtotal'] = $total - $diskon;
		$masukan['status'] = 'retur_produk';
		$this->db->insert('opsi_transaksi_retur_penjualan_temp',$masukan);
		echo "sukses";

	}

	public function update_pengiriman_sesuai()
	{
		$kode = $this->input->post("id");
		$get_jumlah = $this->db->get_where('opsi_transaksi_penjualan',array('id'  =>  $kode));
		$hasil_jumlah = $get_jumlah->row();

		if($hasil_jumlah->status == 'retur'){
			$kode_retur = 'RT'.$hasil_jumlah->kode_penjualan;
			$kode_produk = $hasil_jumlah->kode_menu;
			$kode_satuan = $hasil_jumlah->kode_satuan;
			$jumlah_qty =  $hasil_jumlah->jumlah;
			$qty_retur =  $hasil_jumlah->jumlah_retur;
			$harga = $hasil_jumlah->harga_satuan;
			
			$data['jumlah'] = $jumlah_qty + $qty_retur;
			$data['subtotal'] = ($jumlah_qty + $qty_retur) * $harga;
			$data['subtotal_retur'] = '';
			$data['jumlah_retur'] = '';
			$data['status'] = 'sesuai';
			$this->db->update( "opsi_transaksi_penjualan", $data, array('id' => $kode));
			$this->db->delete('opsi_transaksi_retur_penjualan_temp', array('kode_retur' => $kode_retur, 'kode_produk' => $kode_produk, 'kode_satuan' => $kode_satuan));

		}else{
			$data['status'] = 'sesuai';
			$this->db->update( "opsi_transaksi_penjualan", $data, array('id' => $kode));
		}
	}

	public function get_pengiriman()
	{
		$this->load->view('setting/pengiriman/table_coba');
	}
	public function simpan_pengiriman_terkirim()
	{
		$masukan = $this->input->post();

		$get_id_petugas = $this->session->userdata('astrosession');
		$id_petugas = $get_id_petugas->id;
		$nama_petugas = $get_id_petugas->uname;

		$this->db->group_by('kode_sopir');
		$pembelian = $this->db->get_where('opsi_transaksi_pengiriman',array('kode_penjualan'=>$masukan['kode_penjualan']));
		$list_pembelian = $pembelian->result();
		foreach ($list_pembelian as $value) {
			$jam_kembali['jam_kembali']=$this->input->post('jam_kembali_'.$value->kode_sopir);
			$this->db->update('opsi_transaksi_pengiriman',$jam_kembali,array('kode_penjualan'=>$masukan['kode_penjualan'],'kode_sopir'=>$value->kode_sopir));
		}
		$cek_cod = $this->db->get_where('transaksi_penjualan',array('kode_penjualan'=>$masukan['kode_penjualan']));
		$hasil_cod = $cek_cod->row();
		if($hasil_cod->jenis_transaksi == 'cod'){
			$data_cod['bayar'] = $masukan['dibayar'];
			$ubah_pembayaran = $this->db->update('transaksi_penjualan', $data_cod, array('kode_penjualan'=>$masukan['kode_penjualan']));
			$keuangan['kode_jenis_keuangan'] = '1';
			$keuangan['nama_jenis_keuangan'] = 'Pemasukan';
			$keuangan['kode_kategori_keuangan'] = '1.1';
			$keuangan['nama_kategori_keuangan'] = 'Penjualan';
			$kode_sub = '1.1.5';
			$keuangan['kode_sub_kategori_keuangan'] = $kode_sub;
			$this->db->select('nama_sub_kategori_akun');
			$kategori = $this->db->get_where('keuangan_sub_kategori_akun', array('kode_sub_kategori_akun' =>
				$kode_sub));
			$hasil_kategori = $kategori->row();
			$keuangan['nama_sub_kategori_keuangan'] = $hasil_kategori->nama_sub_kategori_akun;
			$keuangan['nominal'] = $data_cod['bayar'];
			$keuangan['tanggal_transaksi'] = date('Y-m-d');
			$keuangan['id_petugas'] = $id_petugas;
			$keuangan['petugas'] = $nama_petugas;
			$keuangan['kode_referensi'] = $masukan['kode_penjualan'];
			$this->db->insert('keuangan_masuk', $keuangan);
		}

		$kode_ada_retur = 0;

		$transaksi_penjualan_retur = $this->db->get_where('opsi_transaksi_penjualan',array('kode_penjualan'=>$masukan['kode_penjualan']));
		$hasil_transaksi_penjualan_retur = $transaksi_penjualan_retur->result();
		foreach($hasil_transaksi_penjualan_retur as $cari_retur){
			if($cari_retur->status == 'retur'){
				$kode_ada_retur = 1;
			}
		}

		if($kode_ada_retur == 1){
			$get_id_petugas = $this->session->userdata('astrosession');
			$id_petugas = $get_id_petugas->id;
			$nama_petugas = $get_id_petugas->uname;

			$retur_produk = $this->db->get_where('opsi_transaksi_retur_penjualan_temp',array('kode_penjualan'=>$masukan['kode_penjualan']));
			$hasil_retur_produk = $retur_produk->result();

			$total_retur_penjualan = 0;
			foreach ($hasil_retur_produk as $daftar) {
				$opsi_retur['kode_retur'] = "RT".$masukan['kode_penjualan'];
				$opsi_retur['kode_produk'] = $daftar->kode_produk;
				$opsi_retur['nama_produk'] = $daftar->nama_produk;
				$opsi_retur['jumlah'] = $daftar->jumlah;
				$opsi_retur['harga_satuan'] = $daftar->harga_satuan;
				$opsi_retur['diskon_item'] = $daftar->diskon_item;

				$opsi_retur['subtotal'] = $daftar->subtotal;
				$opsi_retur['status'] = $daftar->status;
				$opsi_retur['kode_penjualan'] = $daftar->kode_penjualan;

				$total_retur_penjualan += $daftar->subtotal;

				$tabel_opsi_retur = $this->db->insert('opsi_transaksi_retur_penjualan',$opsi_retur);
			}

			if (count($hasil_retur_produk) > 0) {

				foreach ($hasil_retur_produk as $item) {
					$produk = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$item->kode_produk));
					$hasil_produk = $produk->row();
					$stok['real_stock'] = $hasil_produk->real_stock + $item->jumlah;
					$this->db->update('master_bahan_baku',$stok,array('kode_bahan_baku'=>$item->kode_produk));

					$hpp_produk = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$item->kode_produk));
					$hasil_hpp_produk = $hpp_produk->row();

					$transaksi_stok['jenis_transaksi'] = 'retur penjualan';
					$transaksi_stok['kode_transaksi'] = "RT".$masukan['kode_penjualan'];
					$transaksi_stok['kode_bahan'] = $item->kode_produk;
					$transaksi_stok['nama_bahan'] = $item->nama_produk;
					$transaksi_stok['stok_masuk'] = $item->jumlah;
					$transaksi_stok['sisa_stok'] = $item->jumlah;
					$transaksi_stok['hpp'] = @$hasil_hpp_produk->hpp;
					$transaksi_stok['id_petugas'] = $id_petugas;
					$transaksi_stok['nama_petugas'] = $nama_petugas;
					$transaksi_stok['tanggal_transaksi'] = date("Y-m-d");
					$transaksi_stok['posisi_awal'] = 'supplier';
					$transaksi_stok['posisi_akhir'] = 'gudang';


					$this->db->insert('transaksi_stok',$transaksi_stok);

					$stok_produk = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$item->kode_produk));
					$hasil_stok_produk = $stok_produk->row();
					$stok_in['sisa_stok'] = $hasil_stok_produk->sisa_stok + $item->jumlah;
					$this->db->update('transaksi_stok',$stok_in,array('kode_bahan'=>$item->kode_produk));

					$trx_penjualan = $this->db->get_where('opsi_transaksi_penjualan',array('kode_penjualan'=>$item->kode_penjualan));
					$hasil_trx_penjualan = $trx_penjualan->result();

					$total_trx_penjualan = 0;
					foreach ($hasil_trx_penjualan as $value) {
						$total_trx_penjualan += $value->subtotal;

						$trx_jual = $this->db->get_where('transaksi_penjualan',array('kode_penjualan'=>$item->kode_penjualan));
						$hasil_trx_jual = $trx_jual->row();

						$subtotal_trx_penjualan['nominal_retur'] = $masukan['nominal_retur'];

						$subtotal_trx_penjualan['status_retur'] = 'retur';

						$this->db->update('transaksi_penjualan',$subtotal_trx_penjualan,array('kode_penjualan'=>$item->kode_penjualan));


						$nominal_masuk['nominal'] = $hasil_trx_jual->grand_total - $masukan['nominal_retur'];
						$this->db->update('keuangan_masuk',$nominal_masuk,array('kode_referensi'=>$item->kode_penjualan));

					}
				}
			}

			$nominal_retur['kode_jenis_keuangan'] = '2';
			$nominal_retur['nama_jenis_keuangan'] = 'Pengeluaran';
			$nominal_retur['kode_kategori_keuangan'] = '2.4';
			$nominal_retur['nama_kategori_keuangan'] = 'Retur Penjualan';
			$nominal_retur['kode_sub_kategori_keuangan'] = '2.4.1';
			$this->db->select('nama_sub_kategori_akun');
			$kategori = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>'2.4.1'));
			$hasil_kategori = $kategori->row();
			$nominal_retur['nama_sub_kategori_keuangan'] = $hasil_kategori->nama_sub_kategori_akun;
			$nominal_retur['nominal'] = $masukan['nominal_retur'];
			$nominal_retur['tanggal_transaksi'] = date('Y-m-d');
			$nominal_retur['id_petugas'] = $id_petugas;
			$nominal_retur['petugas'] = $nama_petugas;
			$nominal_retur['kode_referensi'] = "RT".$masukan['kode_penjualan'];
			$this->db->insert('keuangan_keluar',$nominal_retur);


			$transaksi['kode_retur'] = "RT".$masukan['kode_penjualan'];
			$transaksi['kode_penjualan'] = $masukan['kode_penjualan'];
			$transaksi['tanggal_retur'] = date("Y-m-d");
			$transaksi['total_nominal'] = $total_retur_penjualan;
			$transaksi['grand_total'] = $total_retur_penjualan;
			$transaksi['id_petugas'] = $id_petugas;
			$transaksi['petugas'] = $nama_petugas;
			$transaksi['keterangan'] = '';
			$this->db->insert('transaksi_retur_penjualan',$transaksi);

			$kode_keuangan = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>'2.4.1'));
			$hasil_kode = $kode_keuangan->row();

			$this->db->delete('opsi_transaksi_retur_penjualan_temp',array('kode_penjualan'=>$masukan['kode_penjualan']));
		}
		$data_pengiriman['jam_kembali'] = @$masukan['jam_kembali'];
		$data_pengiriman['status_pengiriman'] = "sudah dikirim";

		$insert_pengiriman = $this->db->update('transaksi_pengiriman', $data_pengiriman, array('kode_penjualan' => $masukan['kode_penjualan']));

		$data_transak_penjualan['status'] = "sudah dikirim";

		$insert_pengiriman = $this->db->update('transaksi_penjualan', $data_transak_penjualan, array('kode_penjualan' => $masukan['kode_penjualan']));


	}

	function simpan_batal_kirim(){
		$input = $this->input->post();

		$kode_penjualan = $input['kode_penjualan'];
		$data['keterangan_batal'] = $input['keterangan'];
		$data['status_pengiriman'] = 'pending';
		$this->db->update('transaksi_pengiriman', $data, array("kode_penjualan" => $kode_penjualan));
		$data_trans_penjualan['status'] = "pending";
		$this->db->update( "transaksi_penjualan", $data_trans_penjualan, array("kode_penjualan" => $kode_penjualan));
	}
}
