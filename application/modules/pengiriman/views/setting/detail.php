<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Detail Penjualan

        </div>
        <div class="tools">
          <a href="javascript:;" class="collapse">
          </a>
          <a href="javascript:;" class="reload">
          </a>

        </div>
      </div>
      <div class="portlet-body">
        <!------------------------------------------------------------------------------------------------------>



        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form" action="" method="post">
            <div class="box-body">
              <label><h3><b>Detail Transaksi Penjualan</b></h3></label>
              <div class="row">
                <div class="col-md-6">
                  <?php
                  $kode = $this->uri->segment(3);

                  $transaksi_penjualan = $this->db->get_where('transaksi_penjualan',array('kode_penjualan'=>$kode));
                  $hasil_transaksi_penjualan = $transaksi_penjualan->row();

                  $pengiriman = $this->db->get_where('transaksi_pengiriman',array('kode_penjualan'=>$kode));
                  $hasil_pengiriman = $pengiriman->row();
                  ?>

                  <div class="form-group">
                    <label class="gedhi">Kode Penjualan</label>
                    <input type="text" value="<?php echo $hasil_transaksi_penjualan->kode_penjualan; ?>" readonly="true" class="form-control" placeholder="Kode Penjualan" name="kode_penjualan" id="kode_penjualan"/>
                  </div>
                  <div class="form-group">
                    <label class="gedhi">Nama Penerima</label>
                    <input type="text" value="<?php echo $hasil_transaksi_penjualan->nama_penerima; ?>" readonly="true" class="form-control" placeholder="Nama Penerima" name="nama_penerima" id="nama_penerima"/>
                  </div>
                  <div class="form-group">
                    <label class="gedhi">Alamat</label>
                    <textarea readonly="true" class="form-control" placeholder="Alamat" name="alamat" id="alamat"><?php echo $hasil_transaksi_penjualan->alamat_penerima; ?></textarea>
                  </div>
                  <?php
                  if($hasil_transaksi_penjualan->status!="belum terkirim"){
                    ?>
                    <div class="form-group" hidden>
                      <label class="gedhi">Supir</label>
                      <?php
                      $supir = $this->db->get('master_supir');
                      $supir = $supir->result();
                      ?>
                      <select disabled="disabled" class="form-control select2" name="supir" id="supir" required="">
                        <option selected="true" value="">--Pilih Supir--</option>
                        <?php foreach($supir as $sup){ ?>
                        <option <?php if($hasil_pengiriman->kode_sopir == $sup->kode_supir){ echo "selected"; } ?> value="<?php echo $sup->kode_supir ?>"><?php echo $sup->nama ?></option>
                        <?php 
                      } ?>
                    </select> 
                  </div>
                  <?php 
                } ?>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal Penjualan</label>
                  <input readonly="true" type="text" value="<?php echo TanggalIndo($hasil_transaksi_penjualan->tanggal_penjualan) ?>" class="form-control" placeholder="Tanggal Penjualan" name="tanggal_penjualan" id="tanggal_penjualan" />
                </div>
                <div class="form-group">
                  <label>Nomor Telepon</label>
                  <input readonly="true" type="text" value="<?php echo $hasil_transaksi_penjualan->no_telp ?>" class="form-control" placeholder="Nomor Telepon" name="no_telp" id="no_telp" />
                </div>
                <div class="form-group">
                  <label>Tanggal / Jam Kirim</label>
                  <input readonly="true" type="text" value="<?php echo TanggalIndo($hasil_transaksi_penjualan->tanggal_pengiriman)." / ".$hasil_transaksi_penjualan->jam_pengiriman ?>" class="form-control" placeholder="Tanggal Kirim" name="tanggal_pengiriman" id="tanggal_pengiriman" />
                </div>
                <?php
                if($hasil_transaksi_penjualan->status!="belum terkirim"){
                  ?>
                  <div class="form-group" hidden>
                    <label>No Kendaraan</label>
                    <?php
                    $kendaraan = $this->db->get('master_kendaraan');
                    $kendaraan = $kendaraan->result();
                    ?>
                    <select disabled="disabled" class="form-control select2" name="kode_kendaraan" id="kode_kendaraan" required="">
                      <option selected="true" value="">--Pilih Kendaraan--</option>
                      <?php foreach($kendaraan as $item){ ?>
                      <option <?php if($hasil_pengiriman->kode_kendaraan == $item->kode_kendaraan){ echo "selected"; } ?> value="<?php echo $item->kode_kendaraan ?>"><?php echo $item->no_kendaraan ?></option>
                      <?php 
                    } ?>
                  </select> 
                </div>
                <div class="form-group">
                  <label class="gedhi">Alamat</label>
                  <textarea readonly="true" class="form-control" placeholder="Alamat" name="alamat" id="alamat"><?php echo $hasil_pengiriman->keterangan_batal; ?></textarea>
                </div>
                <?php
              }
              ?>
            </div>

          </div>
        </div>
      </div> 

      <div id="list_transaksi_pembelian">
        <div class="box-body">
          <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>QTY</th>
                <th>Harga</th>
                <th>Sub Total</th>
                <th>Diskon</th>
              </tr>
            </thead>
            <tbody id="tabel_temp_data_transaksi">

              <?php
              $kode = $this->uri->segment(3);
              $pembelian = $this->db->get_where('opsi_transaksi_penjualan',array('kode_penjualan'=>$kode));
              $list_pembelian = $pembelian->result();
              $nomor = 1;  $total = 0;

              foreach($list_pembelian as $daftar){ 
                ?> 
                <tr>
                  <td><?php echo $nomor; ?></td>
                  <td><?php echo $daftar->nama_menu ?></td>
                  <td><?php echo $daftar->jumlah; ?> <?php echo $daftar->nama_satuan; ?></td>
                  <td><?php echo format_rupiah($daftar->harga_satuan); ?></td>
                  <td><?php echo format_rupiah($daftar->subtotal); ?></td>
                  <td><?php echo $daftar->diskon_item.' %'; ?></td>
                </tr>
                <?php 
                $total = $total + $daftar->subtotal;
                $nomor++; 
              } 
              ?>

              <tr>
                <td colspan="4"></td>
                <td style="font-weight:bold;">Total</td>
                <td><?php echo format_rupiah($total); ?></td>
              </tr>

              <tr>
                <td colspan="4"></td>
                <td style="font-weight:bold;">Diskon (%)</td>
                <td id="tb_diskon"><?php echo $hasil_transaksi_penjualan->diskon_persen; ?></td></td>

              </tr>

              <tr>
                <td colspan="4"></td>
                <td style="font-weight:bold;">Diskon (Rp)</td>
                <td id="tb_diskon_rupiah"><?php echo format_rupiah($hasil_transaksi_penjualan->diskon_rupiah); ?></td>

              </tr>

              <tr>
                <td colspan="4"></td>
                <td style="font-weight:bold;">Grand Total</td>
                <td id="tb_grand_total"><?php echo format_rupiah($total-$hasil_transaksi_penjualan->diskon_rupiah); ?></td>

              </tr>
            </tbody>
            <tfoot>

            </tfoot>
          </table>
          <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>No. Surat Jalan</th>
                      <th>Sopir</th>
                      <th>No. Kendaraan</th>
                      <th>Jam Berangkat</th>
                      <th>Jam Pulang</th>
                    </tr>
                  </thead>
                  <tbody id="">
                    <?php

                    $kode = $this->uri->segment(3);
                    $this->db->group_by('kode_sopir');
                    $pembelian = $this->db->get_where('opsi_transaksi_pengiriman',array('kode_penjualan'=>$kode));
                    $list_pembelian = $pembelian->result();
                    $nomor=1;
                    foreach ($list_pembelian as  $value) {
                      ?> 
                      <tr>
                        <td><?php echo $nomor++; ?></td>
                        <td><?php echo $value->kode_surat_jalan ?></td>
                        <td><?php echo $value->nama_sopir; ?></td>
                        <td><?php echo $value->no_kendaraan; ?></td>
                        <td><?php echo $value->jam ?></td>
                        <td><?php echo $value->jam_kembali ?></td>
                      </tr>
                      <?php 
                    }
                    ?>

                  </tbody>
                  <tfoot>

                  </tfoot>
                </table>
          <br>
          <div style="cursor: default;" class="btn green btn-lg"><i class="fa fa-tags">&nbsp;</i><?php echo strtoupper($hasil_transaksi_penjualan->status) ; ?>
          </div>
          <!-- <button type="submit" style="width: 148px" class="btn btn-success pull-right" id="dikirim"><i class="fa fa-check"></i> Kirim</button> -->
          <?php
          if($hasil_transaksi_penjualan->status!="belum terkirim"){
            ?>
            <a href="<?php echo base_url().'pengiriman/print_pengiriman/'.$hasil_transaksi_penjualan->kode_penjualan;; ?>" target="blank" style="width: 148px" class="btn btn-info pull-right" id="detail"><i class="fa fa-print"></i> Print</a>
            <?php
          }
          ?>
        </div>
      </div>
    </form>
  </div>
</div>
</div>
</div>
</div>
<div id="modal-validasi-menunggu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <form id="sesuai_modal" method="post">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color:grey">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title" style="color:#fff;">Notifikasi</h4>
        </div>
        <div class="modal-body">
          <span style="font-weight:bold; font-size:14pt" id="text-notif">Apakah anda ingin mencetak ?</span>
          <input id="id-validasi" name="kode_pembelian" type="hidden">
        </div>
        <div class="modal-footer" style="background-color:#eee">
          <a href="<?php echo base_url().'pengiriman/print_pengiriman/'.$hasil_transaksi_penjualan->kode_penjualan;; ?>" target="blank" style="width: 148px" class="btn btn-info pull-right" id="kembali_daftar"><i class="fa fa-print"></i> Ya</a>
          <button class="btn red" data-dismiss="modal" aria-hidden="true" id="kembali_daftar2">Tidak</button>
        </div>
      </div>
    </div>
  </form>
</div>
<style type="text/css" media="screen">
  .btn-back
  {
    position: fixed;
    bottom: 10px;
    left: 10px;
    z-index: 999999999999999;
    vertical-align: middle;
    cursor:pointer
  }
</style>
<img class="btn-back" src="<?php echo base_url().'component/img/back_icon.png'?>" style="width: 70px;height: 70px;">

<script>
  $(function(){
    $(".select2").select2();
    $('.btn-back').click(function(){
      $(".tunggu").show();
      window.location = "<?php echo base_url().'pengiriman/daftar_pengiriman'; ?>";
    });
    $('#kembali_daftar').click(function(){
      $(".tunggu").show();
      window.location = "<?php echo base_url().'pengiriman/daftar_pengiriman'; ?>";
    });
    $('#kembali_daftar').click(function(){
      $(".tunggu").show();
      window.location = "<?php echo base_url().'pengiriman/daftar_pengiriman'; ?>";
    });
    $('#data_form').submit(function(){
      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url() . 'pengiriman/simpan_pengiriman' ?>",  
        cache :false,
        beforeSend:function(){
          $(".tunggu").show();  
        },
        data :$(this).serialize(),
        success : function(data) {
          $(".tunggu").hide();   
          $("#modal-validasi-menunggu").modal("show");
        },  
        error : function() {  
          $(".tunggu").hide();   
          alert("Data gagal dimasukkan.");  
        }  
      });
      return false;
    });
  });
</script>

