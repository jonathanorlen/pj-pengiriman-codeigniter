<!DOCTYPE html>
<html>
<head>
	<title>PRINT PENGIRIMAN</title>
	<style type="text/css">
		.isi{
			font-size: 5px;
		} 	

		@media print {
			html, body {


				display: block;
				font-family: "Dotrice";
				font-size: auto;
			}

			@page
			{
				size: 21cm 14cm;
				}

		}

	</style>
</head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<body onload="print()">
	<?php
	$kode = $this->uri->segment(3);
	$this->db->group_by('kode_sopir');
	$opsi_pengiriman = $this->db->get_where('opsi_transaksi_pengiriman',array('kode_penjualan'=>$kode));
	$hasil_opsi_pengiriman = $opsi_pengiriman->result();
	foreach ($hasil_opsi_pengiriman as $value) {

			//$produk1 = $this->db->query("SELECT Count(kode_penjualan) AS jumlah FROM opsi_transaksi_pengiriman WHERE kode_penjualan='$kode' and kode_sopir='$value->kode_sopir'");
		$this->db->select('count(kode_penjualan) as jumlah');  
		$produk1 = $this->db->get_where('opsi_transaksi_pengiriman',array('kode_penjualan'=>$kode,'kode_sopir'=>$value->kode_sopir));
		$list_produk1 = $produk1->row();



		$jumlah_page = 1;
		for($batas=7;$list_produk1->jumlah > $batas;$batas=$batas+7){
			$jumlah_page = $jumlah_page + 1;


			$transaksi_penjualan = $this->db->get_where('transaksi_penjualan',array('kode_penjualan'=>$kode));
			$hasil_transaksi_penjualan = $transaksi_penjualan->row();
			$pengiriman = $this->db->get_where('transaksi_pengiriman',array('kode_penjualan'=>$kode));
			$hasil_pengiriman = $pengiriman->row();
		}

		$no = 0;
		$nomor = 1;
		for($page=1;$page<=$jumlah_page;$page++){

			$start = $no * 7;
			$end = $page * 7;
			$no++;

			$kode_transaksi = $this->uri->segment(3);

			$transaksi_penjualan = $this->db->get_where('transaksi_penjualan',array('kode_penjualan'=>$kode_transaksi));
			$hasil_transaksi_penjualan = $transaksi_penjualan->row();

			$pengiriman = $this->db->get_where('opsi_transaksi_pengiriman',array('kode_penjualan'=>$kode_transaksi,'kode_sopir'=>$value->kode_sopir));
			$hasil_pengiriman = $pengiriman->row();
				//echo $this->db->last_query();
			?>
			<table width="100%"  >
				<tr>
					<th colspan="5">PATRIOT JAYA </th>
					<td rowspan="2">
						<h1 style="float: right; margin-top:-2px;"><b>SURAT JALAN</b></h1>
					</td>
				</tr>
				<tr>
					<th colspan="6">
						<?php 
						$identitas = $this->db->get('master_setting');
						$hasil_identitas = $identitas->row();
						?>
						<p style="font-weight:normal;"><?php echo $hasil_identitas->alamat_resto ?></p>
						<p style="margin-top: -15px;font-weight:normal;">Telp. <?php echo $hasil_identitas->telp_resto ?></p>
					</th>
				</tr>
				<tr >
					<td width="14%">Kepada Yth.</td>
					<td width="1%"></td>
					<td width="35%"></td>
					<td width="14%">Kode Penjualan</td>
					<td width="1%">:</td>
					<td width="35%"><?php echo $hasil_transaksi_penjualan->kode_penjualan; ?></td>
				</tr>
				<tr>
					<td>Member</td>
					<td>:</td>
					<td><?php echo $hasil_transaksi_penjualan->kode_member ?>&nbsp<?php echo @$hasil_transaksi_penjualan->nama_member ?></td>
					<td>No Surat Jalan</td>
					<td>:</td>
					<td><?php echo $hasil_pengiriman->kode_surat_jalan; ?></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td><?php echo $hasil_transaksi_penjualan->nama_penerima ?></td>
					<td>Tanggal</td>
					<td>:</td>
					<td><?php echo TanggalIndo($hasil_transaksi_penjualan->tanggal_penjualan) ?>	</td>
				</tr>
				<tr>
					<td>No. telp</td>
					<td>:</td>
					<td><?php echo $hasil_transaksi_penjualan->no_telp; ?></td>
					<td>Plat No</td>
					<td>:</td>
					<td><?php echo $hasil_pengiriman->no_kendaraan; ?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td><?php echo $hasil_transaksi_penjualan->alamat_penerima ;?></td>
					<td>Status</td>
					<td>:</td>
					<td><?php echo $hasil_transaksi_penjualan->jenis_transaksi; ?></td>
				</tr>
				<tr>
					<?php 

					$jam_pengiriman = $this->db->get_where('transaksi_pengiriman',array('kode_penjualan'=>$kode));
					$hasil_jam_pengiriman = $jam_pengiriman->row();
					?>

					<td>Jam Berangkat</td>
					<td>:</td>
					<td><?php echo $hasil_jam_pengiriman->jam ;?></td>
					<td>Jam Pulang</td>
					<td>:</td>
					<td><?php echo $hasil_jam_pengiriman->jam_kembali; ?></td>
				</tr>
				<tr>
					<td colspan="6">
						<br>
						<table class=""  border="1"  width="100%" class="table table-bordered">
							<tr>
								<th align="left">Jumlah Barang</th>
								<th align="left">Nama Barang</th>
								<th align="left">Keterangan</th>
							</tr>
							<?php
							$kode = $this->uri->segment(3);
								//$opsi_pengiriman_bahan =$this->db->query("SELECT * FROM opsi_transaksi_pengiriman WHERE kode_penjualan='$kode' and 
								//	kode_sopir='$value->kode_sopir'
								//	LIMIT 7 OFFSET $start");
							$this->db->limit(7, $start);
							$opsi_pengiriman_bahan = $this->db->get_where('opsi_transaksi_pengiriman',array('kode_penjualan'=>$kode,'kode_sopir'=>$value->kode_sopir));
							$list_opsi_pengiriman_bahan = $opsi_pengiriman_bahan->result();

							foreach($list_opsi_pengiriman_bahan as $daftar){ 

								$pembelian = $this->db->get_where('opsi_transaksi_penjualan',array('kode_penjualan'=>$kode,'kode_menu'=>$daftar->kode_produk));
								$list_pembelian = $pembelian->row();

								?>
								<tr>
									<td align="left" width="50%" ><?php echo $daftar->jumlah; ?>&nbsp;<?php echo $list_pembelian->nama_satuan; ?></td>
									<td align="left" style=""><?php echo $daftar->nama_produk;  ?></td>
									<td align="left" style=""></td>
								</tr>

								<?php } ?>
							</table>

						</td>
					</tr>
					<tr>
						<table width="100%" style="text-align: center;" >
							<br>
							<tr style="text-align: center;">
								<td>Penerima</td>
								<td>Supir</td>
								<td>Checker</td>
								<td>Kepala Distribusi</td>
							</tr>
							<tr style="text-align: center;">
								<td><br><br><br></td>
								<td><br><br><br></td>
								<td><br><br><br></td>
								<td><br><br><br></td>
							</tr>
							<tr style="text-align: center;">
								<td>(<b><u><?php echo @$hasil_transaksi_penjualan->nama_penerima; ?></u></b>)</td>
								<td>(<b><u><?php echo @$value->nama_sopir; ?></u></b>)</td>
								<td>(<b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</u></b>)</td>
								<td>(<b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b>)</td>
								</tr>

							</table>
						</tr>
						<br>
						<tr>
							<table width="100%" >
								<tr>
									<td>
										<p>
											Note : <br>
											Mohon di Cek Dulu Barang Yang Diterima. <br>
											Barang Tidak dapat ditukar <b><u>atau</u></b> dikembalikan apabila di acc <u>atau</u> ttd.
										</p>
									</td>
								</tr>
							</table>
						</tr>
					</table>
					<?php
				}
			}?>
		</body>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		</html>