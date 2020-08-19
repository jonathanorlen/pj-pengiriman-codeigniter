<!DOCTYPE html>
<html>
<head>
	
	<style type="text/css">
		body{


		}
		.table1{
			border-collapse: collapse;
			width:100%;
			position: absolute;
			top: 0px;
			text-align: left;
			vertical-align: middle;
		}
		.right{
			text-align: right;
			margin-right: 5px;
		}
		.left{
			text-align: left;
		}
		.table2{
			width:100%; 
			text-align:center;
			border-collapse: collapse;
		}
		.table2 tr th{
			border: 0.5px solid #222;
		}
		.table2 tr td{
			border: 0.5px solid #222;
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
		div.page { page-break-after: always;
			position: relative;
			margin:10px 15px 0px 15px;
			padding:0px; 
		}
		.judul{
			font-size: 8px;
		}
		.ket{
			font-size: 6px;
		}

		.isi{
			font-size: 8px;
		}
	</style>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<br>	
<body onload="print()">
	<?php  
	$kode = $this->uri->segment(3);
	$this->db->group_by('kode_sopir');
	$opsi_pengiriman = $this->db->get_where('opsi_transaksi_pengiriman',array('kode_penjualan'=>$kode));
	$hasil_opsi_pengiriman = $opsi_pengiriman->result();
	foreach ($hasil_opsi_pengiriman as $value) {

		$produk1 = $this->db->query("SELECT Count(kode_penjualan) AS jumlah FROM opsi_transaksi_pengiriman WHERE kode_penjualan='$kode' and kode_sopir='$value->kode_sopir'");
		$list_produk1 = $produk1->row();
		
		$jumlah_page = 1;
		for($batas=7;$list_produk1->jumlah > $batas;$batas=$batas+7){
			$jumlah_page = $jumlah_page + 1;
		}
		
		$no = 0;
		$nomor = 1;
		for($page=1;$page<=$jumlah_page;$page++){

			$start = $no * 7;
			$end = $page * 7;
			$no++;

			?>

			<?php
			

			$transaksi_penjualan = $this->db->get_where('transaksi_penjualan',array('kode_penjualan'=>$kode));
			$hasil_transaksi_penjualan = $transaksi_penjualan->row();
			$pengiriman = $this->db->get_where('transaksi_pengiriman',array('kode_penjualan'=>$kode));
			$hasil_pengiriman = $pengiriman->row();

			


			?>
			<div class="page">
				<table class="isi" border="0"  width="100%" style="margin-top: -30px">
					<tr>
						<td width="50%">
							<p style="float: left; margin-top:5px;">SURAT JALAN</p>
							<br>
							<p style="text-align:left;float: left;font-size:10px;font-family:Andalus;margin-top:10px;margin-left: -30px;display:block;">
								<b><?php echo @$hasil_transaksi_penjualan->kode_penjualan; ?> <br>	
									<?php echo @$value->kode_surat_jalan; ?></b>
								</p>
							</td>
							<td align="left" style="position:relative;left:px;" colspan="2" class="isi">
								<br>
								<!-- <p style="margin-left: 200px;	"></p> -->
								Kepada Yth &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp  <?php echo TanggalIndo($hasil_transaksi_penjualan->tanggal_penjualan); ?> <br>
								Member &nbsp&nbsp<span style="margin-left:25px; ">:</span>&nbsp<?php echo $hasil_transaksi_penjualan->kode_member ?>&nbsp<?php echo @$hasil_transaksi_penjualan->nama_member ?><br>
								Nama Penerima   <span style="margin-left:2px;">:</span>&nbsp<?php echo $hasil_transaksi_penjualan->kode_member ?>&nbsp<?php echo @$hasil_transaksi_penjualan->nama_penerima ?><br>
								Alamat Penerima <span style="margin-left: ">:</span>&nbsp<?php echo $hasil_transaksi_penjualan->alamat_penerima; ?><br>
								No.Telp         <span style="margin-left:33px; ">:</span>&nbsp<?php echo $hasil_transaksi_penjualan->no_telp ;?>
							</td>
						</tr>
					</table>
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
						
						<br>
						<br>
						<table width="100%" border="0" style="border-collapse:collapse;">
							<tr>
								<td></td>
								<td>
									<table class="isi" width="100%" style="margin-top: px;">
								<!-- 		<tr>
											<td>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 

													<?php 
													$piutang = $this->db->get_where('transaksi_piutang',array('kode_transaksi'=>$kode));
													$list_piutang = $piutang->row();
													if(!empty($list_piutang)){
														?>
														Total Faktur ( Tgl Jatuh Tempo <?php echo @TanggalIndo($list_piutang->jatuh_tempo);?> )
														<?php
													}else{
														?>
														&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
														L U N A S
														<?php
													}
													?>
												</p>
												<p></p>
												<p style="margin-top: 40px;"></p>
											</td> -->
							<!-- 				<td>
												<p style="margin-top: 0px;"></p>

											</td>
											<td style=""><p style="position:relative;">Total Faktur (Tgl Jatuh Tempo 24 April 2017)</p></td>
										</tr> -->
										<br>

									</table>
								</td>

								<td>
									<table width="100%" border="0" class="isi" style="margin-top: 60px;">
										<tr>
											<td align="center">
												PENERIMA<br><br><br><br>

												<center><u><p><?php echo @$hasil_transaksi_penjualan->nama_penerima; ?></p></u></center>
											</td>
										</tr>
									</table>
								</td>
								<td>
									<table width="100%" border="0" class="isi" style="margin-top: 60px;">
										<tr>
											<td align="center">
												SUPIR<br><br><br><br>

												<center><u><p><?php echo @$value->nama_sopir; ?></p></u></center>
											</td>
										</tr>
									</table>
								</td>
								<td>
									<table width="100%" border="0" class="isi" style="margin-top: 60px;">
										<tr>
											<td align="center">
												CHECKER<br><br><br><br>

												<center><u><p> &nbsp;</p></u></center>
											</td>
										</tr>
									</table>
								</td>
								<td>
									<table width="100%" class="isi" style="margin-top: 60px;"	>
										<tr>
											<td align="center">
												KEPALA DISTRIBUSI<br><br><br><br>

												<center><u><p>&nbsp;</p></u></center>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

					</div>
					<?php
				}
			}?>
		</body>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		</html>