
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Daftar Pengiriman
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
          <div class="row">
            <div class="col-md-5" id="">
              <div class="input-group">
                <span class="input-group-addon">Tanggal Awal</span>
                <input type="text" class="form-control tgl" id="tgl_awal">
              </div>
            </div>

            <div class="col-md-5" id="">
              <div class="input-group">
                <span class="input-group-addon">Tanggal Akhir</span>
                <input type="text" class="form-control tgl" id="tgl_akhir">
              </div>
            </div>                        
            <div class="col-md-2 pull-left">
              <button style="width: 148px" type="button" class="btn btn-warning pull-right" id="cari"><i class="fa fa-search"></i> Cari</button>
            </div>
          </div>
          <br><br>
          <div id="cari_transaksi">
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
                $tanggal_saiki=date("m");
                $where = "MONTH(tanggal_penjualan) = $tanggal_saiki"; 
                $this->db->where($where);
                $po = $this->db->get_where('transaksi_penjualan', array('status_penerimaan' => 'dikirim'));
                $hasil_po = $po->result_array();
                $no=0;
               // echo $this->db->last_query();
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
                  <!-- <td><?php echo $no ?></td> -->
                  <td><?php echo $list['kode_transaksi']; ?></td>
                  <td><?php echo TanggalIndo($list['tanggal_penjualan']);?></td>
                  <td><?php echo $list['nama_penerima']; ?></td>
                  <td><?php echo cek_jenis_transaksi($list['jenis_transaksi']); ?></td>
                  <td><?php echo cek_status_pengiriman($list['status']); ?></td>
                  <td>
                    <?php
                    if($list['status'] == "belum terkirim" or $list['status'] == "pending"){ 
                      ?>
                      <a href="<?php echo base_url().'pengiriman/detail/'.$list['kode_penjualan']; ?>" style="width: 148px" class="btn btn-info pull-middle" id="detail"><i class="fa fa-search"></i> Detail</a>
                      <a href="<?php echo base_url().'pengiriman/input_pengiriman/'.$list['kode_penjualan']; ?>" style="width: 148px" class="btn btn-warning pull-middle" id="belum_validasi"><i class="fa fa-edit"></i> Pengiriman</a>

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

            </div>

          </div>

          <!------------------------------------------------------------------------------------------------------>

        </div>
      </div>
    </div><!-- /.col -->
  </div>
</div>    
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
<!-- <img class="btn-back" src="<?php echo base_url().'component/img/back_icon.png'?>" style="width: 70px;height: 70px;"> -->

<script>
  $('.btn-back').click(function(){
    window.location = "<?php echo base_url().'order/daftar/'; ?>";
  });
</script>  
<script src="<?php echo base_url().'component/lib/jquery.min.js'?>"></script>
<script src="<?php echo base_url().'component/lib/zebra_datepicker.js'?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'component/lib/css/default.css'?>"/>
<script type="text/javascript">

 $('.tgl').Zebra_DatePicker({});


 $('#cari').click(function(){

  var tgl_awal =$("#tgl_awal").val();
  var tgl_akhir =$("#tgl_akhir").val();

  if (tgl_awal=='' || tgl_akhir==''){ 
    alert('Masukan Tanggal Awal & Tanggal Akhir..!')
  }
  else{
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url().'pengiriman/cari_pengiriman'; ?>",  
      cache :false,

      data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir},
      beforeSend:function(){
        $(".tunggu").show();  
      },
      success : function(data) {
       $(".tunggu").hide();  
       $("#cari_transaksi").html(data);
     },  
     error : function(data) {  
         // alert("das");  
       }  
     });
  }

  $('#tgl_awal').val('');
  $('#tgl_akhir').val('');

});
</script>

<script>
  $(document).ready(function() {
    $("#tabel_daftar").dataTable({
      "paging":   false,
      "ordering": true,
      "info":     false
    });
    setTimeout(function(){
      $("#lalal").fadeIn('slow');
    }, 1000);
    $("a#hapus").click( function() {    
      var r =confirm("Anda yakin ingin menghapus data ini ?");
      if (r==true)  
      {
        $.ajax( {  
          type :"post",  
          url :"<?php echo base_url() . 'anggota/hapus' ?>",  
          cache :false,  
          data :({key:$(this).attr('key')}),
          beforeSend:function(){
            $(".tunggu").show();  
          },
          success : function(data) { 
            $(".sukses").html(data);   
            setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'anggota/daftar' ?>";},1500);              
          },  
          error : function() {  
            alert("Data gagal dimasukkan.");  
          }  
        });
        return false;
      }
      else {}        
    });

    $('#tabel_daftar').dataTable();
  });
  setTimeout(function(){
    $("#lalal").css("background-color", "white");
    $("#lalal").css("transition", "all 3000ms linear");
  }, 3000);
  $('#belum_validasi').click(function(){
    $("#modal-validasi-menunggu").modal("show");
    $("#id-validasi").val($(this).attr("key"));
  });
  $('#sesuai').click(function(){
    $(".tunggu").show();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'validasi_po/simpan_pembelian_sesuai' ?>",  
      cache :false,
      beforeSend:function(){
        $(".tunggu").show();  
      },
      data :$("#sesuai_modal").serialize(),
      success : function(data) {  
        $(".sukses").html(data);   
        setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'validasi_po/daftar_validasi' ?>";},1);              
      },  
      error : function() {  
        alert("Data gagal dimasukkan.");  
      }  
    });
  });
  $('#hapus_transaksi').click(function(){
    $(".tunggu").show();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url() . 'validasi_po/hapus_transaksi_pembelian' ?>",  
      cache :false,
      beforeSend:function(){
        $(".tunggu").show();  
      },
      data :$("#sesuai_modal").serialize(),
      success : function(data) {  
        $(".sukses").html(data);   
        setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'validasi_po/daftar_validasi' ?>";},1);              
      },  
      error : function() {  
        alert("Data gagal dimasukkan.");  
      }  
    });
  });
</script>


