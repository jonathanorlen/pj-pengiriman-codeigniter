<?php

$kode = $this->uri->segment(3);
$pembelian = $this->db->get_where('opsi_transaksi_pengiriman_temp',array('kode_penjualan'=>$kode));
$list_pembelian = $pembelian->result();
$nomor=1;
foreach ($list_pembelian as  $value) {
	?> 
	<tr>
		<td><?php echo $nomor++; ?></td>
		<td><?php echo $value->kode_surat_jalan ?></td>
		<td><?php echo $value->nama_sopir; ?></td>
		<td><?php echo $value->no_kendaraan; ?></td>
		<td><?php echo $value->nama_produk ?></td>
		<td><?php echo $value->jumlah ?></td>
		<td><?php echo $value->jam ?></td>
		<td><a style="padding:3.5px;" onclick="actDelete(<?php echo $value->id;?>)" data-toggle="tooltip" title="Delete" class="btn btn-icon-only btn-circle red"><i class="fa fa-trash"></i> </a></td>
	</tr>
	<?php 
}
?>