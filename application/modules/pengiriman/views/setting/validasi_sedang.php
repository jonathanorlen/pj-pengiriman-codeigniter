    <div class="row">      
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
      $('.btn-back').click(function(){
        $(".tunggu").show();
        window.location = "<?php echo base_url().'pengiriman/daftar_pengiriman'; ?>";
      });
      </script>
      <div class="col-xs-12">
        <!-- /.box -->
        <div class="portlet box blue">
          <div class="portlet-title">
            <div class="caption">
              Detail Pengiriman

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

            <?php
            $kode = $this->uri->segment(3);

            $transaksi_penjualan = $this->db->get_where('transaksi_penjualan',array('kode_penjualan'=>$kode));
            $hasil_transaksi_penjualan = $transaksi_penjualan->row();

            $pengiriman = $this->db->get_where('transaksi_pengiriman',array('kode_penjualan'=>$kode));
            $hasil_pengiriman = $pengiriman->row();
            ?>
            <div class="box-body">                   
              <div class="sukses" ></div>
              <form id="data_form" action="" method="post">
                <div class="box-body">
                  <div class="notif_nota" ></div>
                  <label><h3><b>Validasi</b></h3></label>

                  <div class="row">

                    <input type="hidden" id="hasil_kode_po" name="kode_po" >
                    <div class="col-md-6">
                      <div class="form-group">  
                        <label>Kode Penjualan</label>
                        <input readonly="true" type="text" value="<?php echo $hasil_transaksi_penjualan->kode_penjualan; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_penjualan" id="kode_pembelian" />
                      </div>
                      <div class="form-group">  
                        <label>Nama</label>
                        <input type="text" class="form-control" placeholder="Nota Referensi" name="nomor_nota" id="nomor_nota" value="<?php echo $hasil_transaksi_penjualan->nama_penerima; ?>" required="" readonly=""/>
                      </div>
                      <div class="form-group">  
                        <label class="gedhi">Alamat</label>
                        <textarea readonly="true" class="form-control" placeholder="Alamat" name="alamat" id="alamat"><?php echo $hasil_transaksi_penjualan->alamat_penerima; ?></textarea>
                      </div>
                     <!--  <div class="form-group">  
                        <label>Sopir</label>
                        <input readonly="" type="text" class="form-control" placeholder="Keterangan" name="supir" id="keterangan" value="<?php echo $hasil_pengiriman->nama_sopir; ?>"  required=""/>
                      </div> -->
                     <!--  <div class="form-group">  
                        <label>Jam Kembali</label>
                        <input type="text" class="form-control timepicker" placeholder="Keterangan" name="jam_kembali" id="jam_kembali" value=""  required=""/>
                      </div> -->
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="gedhi">Tanggal Penjualan</label>
                        <input type="text" value="<?php echo TanggalIndo($hasil_transaksi_penjualan->tanggal_penjualan); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" id="tanggal_pembelian" name="tanggal_pembelian"/>
                      </div>

                      <div class="form-group">
                        <label>No Hp</label>
                        <input type="text" name="no_hp" class="form-control" readonly="true" value="<?php echo $hasil_transaksi_penjualan->no_telp; ?>" />
                      </div>

                      <div class="form-group">
                        <label class="gedhi">Tgl Kirim</label>
                        <input class="form-control" placeholder="Tanggal barang datang" name="tanggal_pengiriman" value="<?php echo TanggalIndo($hasil_transaksi_penjualan->tanggal_pengiriman); ?>" readonly="true" id="tanggal_pengiriman"/>
                      </div>
                      <!-- <div class="form-group">
                        <label class="gedhi">No Kendaraan</label>
                        <input readonly="" type="text" value="<?php echo $hasil_pengiriman->no_kendaraan; ?>"  class="form-control" placeholder="Tanggal barang datang" name="no_kendaraan" id="no_kendaraan"/>
                      </div> -->
                    </div>
                  </div>
                </div> 

                <div class="sukses" ></div>


                <div id="list_transaksi_pembelian">
                  <div class="box-body">
                    <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama bahan</th>
                          <th>QTY</th>
                          <th>Qty Retur</th>
                          <th>Harga Satuan</th>
                          <th>Subtotal</th>
                          <th>Subtotal Retur</th>
                          <th>Diskon</th>
                          <th>Status</th>
                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody id="table_penjualan1">

                        <?php
                        if(@$kode){
                          $pembelian = $this->db->get_where('opsi_transaksi_penjualan',array('kode_penjualan'=>$kode));
                          $list_pembelian = $pembelian->result();
                          $nomor = 1;  $total = 0;

                          foreach($list_pembelian as $daftar){ 
                            @$satuan_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>@$daftar->kode_bahan));
                            @$hasil_satuan_bahan = $satuan_bahan->row();
                            @$satuan_barang = $this->db->get_where('master_barang',array('kode_barang'=>@$daftar->kode_bahan));
                            @$hasil_satuan_barang = $satuan_barang->row();
                            ?> 
                            <tr>
                              <td><?php echo $nomor; ?></td>
                              <td><?php echo @$daftar->nama_menu; ?></td>
                              <td><?php echo @$daftar->jumlah; ?></td>
                              <td><?php echo @$daftar->jumlah_retur; ?></td>
                              <td><?php echo format_rupiah(@$daftar->harga_satuan); ?></td>
                              <td><?php echo format_rupiah(@$daftar->subtotal); ?></td>
                              <td><?php echo format_rupiah(@$daftar->subtotal_retur); ?></td>
                              <td><?php echo format_rupiah(@$daftar->diskon_item); ?></td>
                              <td><?php echo @$daftar->status; ?></td>
                              <td>
                                <div class="btn-group">
                                  <?php if($daftar->status == '' OR $daftar->status == 'retur'){ ?>

                                  <a data-toggle="tooltip" onclick="actDelete(<?php echo $daftar->id; ?>)" id="<?php echo $daftar->id; ?>" title="Hapus" class="btn btn-small btn-info"><i class="fa fa-check"></i>  Sesuai</a>
                                  <?php } ?>

                                  <?php if($daftar->status == '' OR $daftar->status == 'sesuai'){ ?>

                                  <a data-toggle="tooltip" id="<?php echo $daftar->id; ?>" title="Validasi Penjualan" class="btn adetail btn-small btn-danger"><i class="fa fa-close"></i>Tidak</a>
                                  <?php } ?>
                                </div>
                              </td>

                            </tr>

                            <tr id="tr<?php echo $daftar->id; ?>"  style="display:none" class="detail">
                              <td colspan="10">
                                <span class="closedet pull-right"><strong><h3>X</h3></strong></span><div id="detail<?php echo $daftar->id; ?>" ></div>
                              </td>
                            </tr>

                            <?php 
                            @$total = $total + @$daftar->subtotal;
                            $nomor++; 
                          } 
                        }
                        ?>

                        <tr>
                          <td colspan="8"></td>
                          <td style="font-weight:bold;">Total</td>
                          <td><?php echo format_rupiah(@$total); ?></td>

                        </tr>

                        <tr>
                          <td colspan="8"></td>
                          <td style="font-weight:bold;">Diskon (%)</td>
                          <td id="tb_diskon"><?php echo @$diskon; ?></td></td>

                        </tr>

                        <tr>
                          <td colspan="8"></td>
                          <td style="font-weight:bold;">Diskon (Rp)</td>
                          <td id="tb_diskon_rupiah"></td>

                        </tr>

                        <tr>
                          <td colspan="8"></td>
                          <td style="font-weight:bold;">Grand Total</td>
                          <td id="tb_grand_total"><?php echo format_rupiah(@$total); ?>
                            <input id="grand_total" value="<?php echo @$total; ?>" name="grand_total" type="hidden"/>
                          </td>

                        </tr>
                      </tbody>
                      <tfoot>

                      </tfoot>
                    </table>
                  </div>
                </div>
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
                        <td><input type="text" class="form-control timepicker" placeholder="Jam Pulang" name="jam_kembali_<?php echo $value->kode_sopir; ?>" id="jam_kembali_<?php echo $value->kode_sopir; ?>"  value=""  required=""/></td>
                      </tr>
                      <?php 
                    }
                    ?>

                  </tbody>
                  <tfoot>

                  </tfoot>
                </table>
                <div class="box-body">
                  <div class="row">
    <!-- <div class="col-md-3">
    <label>Diskon (Rp)</label>
    <div class="input-group">
    <span class="input-group-addon"><i class="fa fa-money"></i></span>
    <input type="text" class="form-control" placeholder="Diskon (Rp)" name="diskon_rupiah" id="diskon_rupiah">
    </div>
  </div> -->

    <!-- <div class="col-md-3">
    <label>Pembayaran</label>
    <div class="form-group">
    <select class="form-control" name="proses_pembayaran" id="proses_pembayaran">
    <option value="cash">Cash</option>
    <option value="debet">Debet</option>
    <option value="credit">Credit</option>
    </select>
    <input type="hidden" class="form-control"  name="kode_sub" id="kode_sub">
    </div>
  </div> -->

  <div class="col-md-4" id="tgl_jatuh_tempo">
    <label>Nominal Retur</label>
    <div class="input-group">
      <span class="input-group-addon">Nominal Retur</span>
      <span>
        <input type="text" class="form-control" name="nominal_retur" id="nominal_retur">
      </span>
    </div>
  </div>
  <?php 
  if($hasil_transaksi_penjualan->jenis_transaksi == 'cod'){ ?>
  <div class="col-md-4" id="div_dibayar">
    <label>Dibayar</label>
    <div class="input-group">
      <span class="input-group-addon"><i class="fa fa-money"></i></span>
      <input type="text" class="form-control" placeholder="dibayar" name="dibayar" id="dibayar">
    </div>
  </div>
  <?php
}?>
<div class="col-md-4">
  <div class="input-group">
    <h3><div id="nilai_dibayar"></div></h3>
  </div>
</div>

</div>

</div>

<br>
<a onclick="confirm_bayar()"  class="btn btn-success pull-right"><i class="fa fa-save"></i>&nbsp;Simpan</a>
<a onclick="batal_kirim()"  class="btn btn-danger pull-right"><i class="fa fa-close"></i>&nbsp;Batal Kirim</a>
<div class="box-footer clearfix">

</div>
</form>
<!--  -->
</div>
</div>
</div>
</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<div id="modal-regular" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="cari_po" method="post">
        <div class="modal-header" style="background-color:grey">
          <button type="button" class="close" onclick="" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title" style="color:#fff;">Transaksi Pembelian</h4>
        </div>
        <div class="modal-body" >
          <div class="form-body">

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label">Kode PO</label>
                  <input type="text" id="kode_po" name="kode_po" class="form-control" placeholder="Kode PO" required="">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer" style="background-color:#eee">
          <button onclick="cancel()" class="btn blue" data-dismiss="modal" aria-hidden="true">Cancel</button>
          <button type="submit" class="btn green">Cari</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Status</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan mengganti status menjadi sesuai ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn red" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn green">Ya</button>
      </div>
    </div>
  </div>
</div>

<div id="modal-confirm-bayar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Pembayaran</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:12pt">Apakah anda yakin ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn red" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button id="simpan_transaksi" class="btn green">Ya</button>
      </div>
    </div>
  </div>
</div>
<div id="modal-batal-kirim" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Batal Kirim</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:12pt">Apakah anda yakin ingin membatalkan pengiriman ?</span>
        <input id="id-batal-kirim" type="hidden"><br>
        <label>Keterangan Batal Kirim</label>
        <textarea class="form-control" id="keterangan_batal" placeholder="Keterangan..."></textarea>
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn red" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button id="btn_batal_kirim" class="btn green">Ya</button>
      </div>
    </div>
  </div>
</div>

<div id="modal_setting" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog" style="width:1000px;">
    <div class="modal-content" >
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
        <label><b><i class="fa fa-gears"></i>Setting</b></label>
      </div>

      <form id="form_setting" >
        <div class="modal-body">
          <?php
          $setting = $this->db->get('setting_pembelian');
          $hasil_setting = $setting->row();
          ?>

          <div class="box-body">

            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label>Note</label>
                  <input type="text" name="keterangan"  class="form-control" />
                </div>

              </div>
            </div>

          </div>

          <div class="modal-footer" style="background-color:#eee">
            <button class="btn red" data-dismiss="modal" aria-hidden="true">Cancel</button>
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">
  function setting() {
    $('#modal_setting').modal('show');
  }
  function confirm_bayar(){
    var uang = $("#nilai_dibayar").text();
    $("#bayare").text(uang);
    $("#modal-confirm-bayar").modal('show');
  }
  function batal_kirim(){
    var kode = $("#kode_pembelian").val();
    $("#id-batal-kirim").val(kode);
    $("#modal-batal-kirim").modal('show');
    $('#keterangan_batal').css('border-color','#e5e5e5');
  }

  $(document).ready(function(){
    $('input.timepicker').timepicker({ 
      timeFormat: 'HH:mm',
      interval: 30,
      scrollbar:true 
    });

    $(".adetail").click(function(){
      $(".detail").fadeOut(); 
      var id = $(this).attr('id');
      if($("#detail"+id).html()!=""){
        $("#tr"+id).fadeIn("slow");
        return;
      }
      var url = "<?php echo base_url().'pengiriman/get_form_coba'?>";
      $.ajax({
        type: "POST",
        url: url,
        data: {id:id},
        success: function(html)
        {
          $("#detail"+id).html(html);
          $("#tr"+id).fadeIn("slow");
        }
      }); 
    });

    $(".closedet").click(function(){
      $(this).parent().parent().closest('tr').fadeOut();
    });


    $("#update").hide();

    var kode_pembelian = $('#kode_pembelian').val();
    $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/table_pembelian/'; ?>"+kode_pembelian);




    var kode_pembelian = $('#kode_pembelian').val() ;  
    $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/get_pembelian/'; ?>"+kode_pembelian);

    $(".tgl").datepicker();

    $("#kode_sub").val('2.1.1');


    $('#kode_bahan').on('change',function(){
      var jenis_bahan = $('#kategori_bahan').val();
      var kode_bahan = $('#kode_bahan').val();
      var url = "<?php echo base_url() . 'pembelian/get_satuan' ?>";
      $.ajax({
        type: 'POST',
        url: url,
        dataType:'json',
        data: {kode_bahan:kode_bahan,jenis_bahan:jenis_bahan},
        success: function(msg){
          if(msg.satuan_pembelian){
            $('#nama_satuan').val(msg.satuan_pembelian);
          }else if(msg.satuan_stok){
            $('#nama_satuan').val(msg.satuan_stok);
          }
          if(msg.id_satuan_pembelian){
            $("#kode_satuan").val(msg.id_satuan_pembelian);
          }else if(msg.kode_satuan_stok){
            $("#kode_satuan").val(msg.kode_satuan_stok);
          }
          if(msg.nama_bahan_baku){
            $("#nama_bahan").val(msg.nama_bahan_baku);
          }else if(msg.nama_bahan_jadi){
            $("#nama_bahan").val(msg.nama_bahan_jadi);
          }
          else if(msg.nama_barang){
            $("#nama_bahan").val(msg.nama_barang);
          }

        }
      });
    });

    $("#diskon_rupiah").keyup(function(){
      var temp_data = "<?php echo base_url().'pembelian/temp_data_transaksi/'?>";
      var kode_pembelian = $('#kode_pembelian').val() ;

      $.ajax({
        type: "POST",
        url: temp_data,
        data: {kode_pembelian:kode_pembelian},
        success: function(hasil) {              
          var diskon_rupiah = $('#diskon_rupiah').val() ;
          var diskon_persen = Math.round(diskon_rupiah/hasil*100);
          $('#diskon_persen').val(diskon_persen) ;
          $("#tb_diskon").text(diskon_persen+"%");

          var diskon_tabel = "<?php echo base_url().'pembelian/diskon_tabel/'?>" ;
          $.ajax({
            type: "POST",
            url: diskon_tabel,
            data: {diskon:diskon_persen},
            success: function(diskon) {      
              $('.diskon_value_rupiah').val(diskon) ;
              $("#tb_diskon").text(diskon+"%");
              $("#tb_diskon_rupiah").text(diskon_rupiah);
              var grand_diskon = $("#grand_total").val() - diskon_rupiah;
              $("#tb_grand_total").text(grand_diskon);     
            }
          });

        }
      });

    });

    $("#diskon_persen").keyup(function(){
      var temp_data = "<?php echo base_url().'pembelian/temp_data_transaksi/'?>";
      var kode_pembelian = $('#kode_pembelian').val() ;
      $.ajax({
        type: "POST",
        url: temp_data,
        data: {kode_pembelian:kode_pembelian},
        success: function(hasil) {              
          var diskon_persen = $('#diskon_persen').val() ;
          var diskon_rupiah = (diskon_persen / 100) * hasil ;
          $('#diskon_rupiah').val(diskon_rupiah) ;

          var diskon_tabel = "<?php echo base_url().'pembelian/diskon_tabel/'?>" ;
          $.ajax({
            type: "POST",
            url: diskon_tabel,
            data: {diskon:diskon_rupiah},
            success: function(diskon) {   
              $('.diskon_value_rupiah').val(diskon) ;
              $("#tb_diskon").text(diskon_persen+"%");
              $("#tb_diskon_rupiah").text(diskon);
              var grand_diskon = $("#grand_total").val() - diskon;
              $("#tb_grand_total").text(grand_diskon);
            }
          });

        }
      });

    });


    $("#dibayar").keyup(function(){
      var dibayar = $("#dibayar").val();
      var kode_pembelian = $('#kode_pembelian').val() ;
      var grand = $("#tb_grand_total").text();
      var proses_pembayaran = $('#proses_pembayaran').val() ;
      var url = "<?php echo base_url().'pembelian/get_rupiah'; ?>";
      var url_kredit = "<?php echo base_url().'pembelian/get_rupiah_kredit'; ?>";
      if(proses_pembayaran==''){
        alert('Pembayaran Harus Diisi');
      }
      else{
        if(proses_pembayaran=='cash' || proses_pembayaran=='debet'){
          $.ajax({
            type: "POST",
            url: url,
            data: {dibayar:dibayar,kode_pembelian:kode_pembelian,grand:grand},
            success: function(msg) {            
              var data = msg.split("|");  
              var nilai_dibayar = data[1];
              var nilai_kembali = data[0];
              $("#nilai_dibayar").html(nilai_dibayar);
            }
          });
        }
        else if(proses_pembayaran=='credit'){
          $.ajax({
            type: "POST",
            url: url_kredit,
            data: {dibayar:dibayar,kode_pembelian:kode_pembelian,grand:grand},
            success: function(msg) {            
              var data = msg.split("|");  
              var nilai_dibayar = data[1];
              var nilai_kembali = data[0];
              $("#nilai_dibayar").html(nilai_dibayar);
              $("#nilai_kembali").html(nilai_kembali);
            }
          });
        }
      }

    })

    $("#simpan_transaksi").click(function(){
      var simpan_transaksi = "<?php echo base_url().'pengiriman/simpan_pengiriman_terkirim/'?>";

      $.ajax({
        type: "POST",
        url: simpan_transaksi,
        data: $('#data_form').serialize(),  
        beforeSend:function(){
          $(".tunggu").show();  
        },
        success: function(msg)
        {
          $(".tunggu").hide();
          $("#modal-confirm-bayar").modal('hide');
          window.location = "<?php echo base_url() . 'pengiriman/daftar_pengiriman' ?>";  
        }
      });
      return false;

    });
    $("#btn_batal_kirim").click(function(){
      var batal_kirim = "<?php echo base_url().'pengiriman/simpan_batal_kirim/'?>";
      kode_penjualan = $('#id-batal-kirim').val();
      keterangan = $('#keterangan_batal').val();
      if(keterangan!=''){
        $.ajax({
          type: "POST",
          url: batal_kirim,
          data: {kode_penjualan:kode_penjualan, keterangan:keterangan},  
          beforeSend:function(){
            $(".tunggu").show();  
          },
          success: function(msg)
          {
            $(".tunggu").hide();
            $("#modal-batal-kirim").modal('hide');
            window.location = "<?php echo base_url() . 'pengiriman/daftar_pengiriman' ?>";  
          }
        });
      } else{
        $('#keterangan_batal').css('border-color','red');
      }
      return false;

    });

  });

    function add_item(){
      var kode_pembelian = $('#kode_pembelian').val();
      var nomor_nota = $('#nomor_nota').val();
      var kode_supplier = $('#kode_supplier').val();
      var kategori_bahan = $('#kategori_bahan').val();
      var kode_bahan = $('#kode_bahan').val();
      var jumlah = $('#jumlah').val();
      var kode_satuan = $('#kode_satuan').val();
      var nama_satuan = $("#nama_satuan").val();
      var harga_satuan = $('#harga_satuan').val();
      var nama_bahan = $("#nama_bahan").val();
      var url = "<?php echo base_url().'pembelian/simpan_item_temp/'?> ";
      if(nomor_nota == '' && kode_supplier == ''){
        $(".sukses").html('<div class="alert alert-danger">Nomor Nota dan Supplier harus diisi.</div>');   
        setTimeout(function(){
          $('.sukses').html('');     
        },1500);
      }
      else{
        $.ajax({
          type: "POST",
          url: url,
          data: { kode_pembelian:kode_pembelian,
            kategori_bahan:kategori_bahan,
            kode_bahan:kode_bahan,
            nama_bahan:nama_bahan,
            jumlah:jumlah,
            kode_satuan:kode_satuan,
            nama_satuan:nama_satuan,
            harga_satuan:harga_satuan,
            kode_supplier:kode_supplier
          },
          beforeSend:function(){
            $(".tunggu").show();  
          },
          success: function(data)
          {
            $(".tunggu").hide();
            if(data==1){
              $(".sukses").html('<div class="alert alert-danger">Selesaikan Transaksi Sesuai Jenis Barang Terlebih Dahulu</div>');

              setTimeout(function(){$('.sukses').html('');},1800); 
            }else{
              $('.sukses').html('');     
              $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/get_pembelian/'; ?>"+kode_pembelian);
              $('#kode_bahan').val('');
              $('#jumlah').val('');
              $("#nama_satuan").val('');
              $('#harga_satuan').val('');
              $("#nama_bahan").val('');
              $("#kode_satuan").val(''); 
            }
          }
        });
  }
}

function actDelete(Object) {
  $('#id-delete').val(Object);
  $('#modal-confirm').modal('show');
}

function cancel() {
  window.location = "<?php echo base_url() . 'pembelian/daftar_pembelian' ?>";
}

function actEdit(id) {
  var id = id;
  var kode_pembelian = $('#kode_pembelian').val();
  var url = "<?php echo base_url().'pembelian/get_temp_pembelian'; ?>";
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: {id:id},
    success: function(pembelian){
      $('#kategori_bahan').val(pembelian.kategori_bahan);

      $("#kode_bahan").val(pembelian.kode_bahan);
      $("#nama_bahan").val(pembelian.nama_bahan);
      $('#jumlah').val(pembelian.jumlah);
      $('#kode_satuan').val(pembelian.kode_satuan);
      $("#nama_satuan").val(pembelian.nama_satuan);
      $('#harga_satuan').val(pembelian.harga_satuan);
      $('#kode_supplier').val(pembelian.kode_supplier);
      $("#id_item").val(pembelian.id);
      $("#add").hide();
      $("#update").show();
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/get_pembelian/'; ?>"+kode_pembelian);
    }
  });
}

function update_item(){
  var kode_pembelian = $('#kode_pembelian').val();
  var kategori_bahan = $('#kategori_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var jumlah = $('#jumlah').val();
  var kode_satuan = $('#kode_satuan').val();
  var nama_satuan = $("#nama_satuan").val();
  var harga_satuan = $('#harga_satuan').val();
  var nama_bahan = $("#nama_bahan").val();
  var id_item = $("#id_item").val();
  var url = "<?php echo base_url().'pembelian/update_item_temp/'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { kode_pembelian:kode_pembelian,
      kategori_bahan:kategori_bahan,
      kode_bahan:kode_bahan,
      nama_bahan:nama_bahan,
      jumlah:jumlah,
      kode_satuan:kode_satuan,
      nama_satuan:nama_satuan,
      harga_satuan:harga_satuan,
      id:id_item
    },
    success: function(data)
    {
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/get_pembelian/'; ?>"+kode_pembelian);
      $('#kategori_bahan').val('');
      $('#kode_bahan').val('');
      $('#jumlah').val('');
      $("#nama_satuan").val('');
      $('#harga_satuan').val('');
      $("#nama_bahan").val('');
      $("#kode_satuan").val('');
      $("#id_item").val('');
      $("#add").show();
      $("#update").hide();
    }
  });
}

function delData() {
  var id = $('#id-delete').val();
  var kode_penjualan = "<?php echo $kode; ?>";
  var url = '<?php echo base_url().'pengiriman/update_pengiriman_sesuai'; ?>';
  var kode_penjualan
  $.ajax({
    type: "POST",
    url: url,
    data: {
      id:id,kode_penjualan:kode_penjualan
    },
    beforeSend:function(){
      $(".tunggu").show();  
    },
    success: function(msg) {
      $(".tunggu").hide();

      $('#modal-confirm').modal('hide');
      location.reload();
    }
  });
  return false;
}
</script>

