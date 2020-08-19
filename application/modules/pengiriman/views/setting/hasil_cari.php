<table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
  <thead>

    <tr>
      <th width="50px;">No. Nota</th>
      <th>Tanggal Pengiriman</th>
      <th>Nama Customer</th>
      <th>Jenis Transaksi</th>
      <th>Status</th>
      <th width="300px;">Action</th>
    </tr>
  </thead>
  <tbody>


    <?php
    $this->db->where('tanggal_penjualan >=', $tanggal_awal);
    $this->db->where('tanggal_penjualan <=', $tanggal_akhir);
    $po = $this->db->get_where('transaksi_penjualan', array('status_penerimaan' => 'dikirim'));
    $hasil_po = $po->result_array();
    $no=0;
    foreach ($hasil_po as $list) {
      $no++;
      if($list['jenis_transaksi'] == "cod"){
        echo "<tr style='background-color: #ffd6d6'>";
      } else if($list['jenis_transaksi'] == "kredit"){
        echo "<tr style='background-color: #d6e3ff'>";
      } else if($list['jenis_transaksi'] == "tunai"){
        echo "<tr style='background-color: #d6ffd9'>";
      }
      ?>
      <td><?php echo $list['kode_penjualan']; ?></td>
      <td><?php echo TanggalIndo($list['tanggal_penjualan']);?></td>
      <td><?php echo $list['nama_penerima']; ?></td>
      <td><?php echo cek_jenis_transaksi($list['jenis_transaksi']); ?></td>
      <td><?php echo cek_status_pengiriman($list['status']); ?></td>
      <td>
        <?php
        if($list['status'] == "belum terkirim"){ 
          ?>
          <a href="<?php echo base_url().'pengiriman/detail/'.$list['kode_penjualan']; ?>" style="width: 148px" class="btn btn-info pull-middle" id="detail"><i class="fa fa-search"></i> Detail</a>
          <a href="<?php echo base_url().'pengiriman/validasi/'.$list['kode_penjualan']; ?>" style="width: 148px" class="btn btn-success pull-middle" id="belum_validasi"><i class="fa fa-check"></i> Validasi</a>
          <?php 
        } else if($list['status'] == "sedang dikirim"){ 
          ?>
          <a href="<?php echo base_url().'pengiriman/detail/'.$list['kode_penjualan']; ?>" style="width: 148px" class="btn btn-info pull-middle" id="detail"><i class="fa fa-search"></i> Detail</a>
          <a href="<?php echo base_url().'pengiriman/validasi_sedang/'.$list['kode_penjualan']; ?>" style="width: 148px" class="btn btn-success pull-middle" id="belum_validasi"><i class="fa fa-check"></i> Validasi</a>
          <?php 
        } else if($list['status'] == "sudah dikirim"){ 
          ?>
          <a href="<?php echo base_url().'pengiriman/detail/'.$list['kode_penjualan']; ?>" style="width: 148px" class="btn btn-info pull-middle" id="detail"><i class="fa fa-search"></i> Detail</a>
          <?php 
        }?>
      </td></tr>
      <?php  } ?>
    </tbody>                
  </table>
  <script type="text/javascript">
    $('#tabel_daftar').dataTable();
  </script>
