<!DOCTYPE html>
<html>
<head>
	<title>PRINT PENGIRIMAN</title>
</head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<body onload="print()">
	<?php
	$kode = $this->uri->segment(3);

	$transaksi_penjualan = $this->db->get_where('transaksi_penjualan',array('kode_penjualan'=>$kode));
	$hasil_transaksi_penjualan = $transaksi_penjualan->row();
	$pengiriman = $this->db->get_where('transaksi_pengiriman',array('kode_penjualan'=>$kode));
	$hasil_pengiriman = $pengiriman->row();
	?>
	<table width="100%">
		<tr>
			<th colspan="6"><center>PATRIOT JAYA<center></th>
		</tr>
		<tr>
			<td width="14%">Kode Penjualan</td>
			<td width="1%">:</td>
			<td width="35%"><?php echo $hasil_transaksi_penjualan->kode_penjualan; ?></td>
			<td width="14%">Nama</td>
			<td width="1%">:</td>
			<td width="35%"><?php echo $hasil_transaksi_penjualan->nama_penerima; ?></td>
		</tr>
		<tr>
			<td>Tanggal Penjualan</td>
			<td>:</td>
			<td><?php echo TanggalIndo($hasil_transaksi_penjualan->tanggal_penjualan) ?></td>
			<td>No. Handphone</td>
			<td>:</td>
			<td><?php echo $hasil_transaksi_penjualan->no_telp ?></td>
		</tr>
		<tr>
			<td>Tanggal / Jam Kirim</td>
			<td>:</td>
			<td><?php echo TanggalIndo($hasil_transaksi_penjualan->tanggal_pengiriman)." / ".$hasil_transaksi_penjualan->jam_pengiriman ?></td>
			<td>Alamat</td>
			<td>:</td>
			<td><?php echo $hasil_transaksi_penjualan->alamat_penerima; ?></td>
		</tr>
		<tr>
			<td>Sopir / No.Kendaraan</td>
			<td>:</td>
			<td><?php echo $hasil_pengiriman->nama_sopir." / ".$hasil_pengiriman->no_kendaraan ?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="6">
				<table class="isi"  border="1"  width="100%" class="table table-bordered">
					<tr>
						<th align="left">Jumlah Barang</th>
						<th align="left">Nama Barang</th>
					</tr>
					<?php
					$kode = $this->uri->segment(3);


					$opsi_pengiriman_bahan =$this->db->query("SELECT * FROM opsi_transaksi_pengiriman WHERE kode_penjualan='$kode' and 
						kode_sopir='$value->kode_sopir'
						LIMIT 7 OFFSET $start");;
					$list_opsi_pengiriman_bahan = $opsi_pengiriman_bahan->result();
					

					foreach($list_opsi_pengiriman_bahan as $daftar){ 

						$pembelian = $this->db->get_where('opsi_transaksi_penjualan',array('kode_penjualan'=>$kode,'kode_menu'=>$daftar->kode_produk));
						$list_pembelian = $pembelian->row();

						?>
						<tr>
							<td align="left" width="50%" ><?php echo $daftar->jumlah; ?>&nbsp<?php echo $list_pembelian->nama_satuan; ?></td>
							<td align="left" style=""><?php echo $daftar->nama_produk;  ?></td>
						</tr>

						<?php } ?>
					</table>
				</table>
			</td>
		</tr>
	</table>
</body>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</html>