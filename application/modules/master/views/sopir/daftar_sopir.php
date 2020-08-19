
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Supir
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

        $supir = $this->db->get('master_supir');
        $hasil_supir = $supir->result();
        ?>


        <div class="box-body">            
          <div class="sukses" ></div>
          <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
           <thead>
            <tr>
              <th>No</th>
              <th>Nama Supir</th>
              <th>Alamat</th>
              <th>No. HP</th>
              <th>Status</th>
              
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
           <?php
           $nomor = 1;
           foreach($hasil_supir as $list){ ?> 
           <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $list->nama; ?></td>
            <td><?php echo $list->alamat; ?></td>
            <td><?php echo $list->no_hp; ?></td>
             <td><?php echo cek_status($list->status); ?></td>
      
            <td align="center"><?php echo get_detail_edit_delete_string($list->id); ?></td>
          </tr>
          <?php $nomor++; } ?>
        </tbody>
        <tfoot>
          <tr>
           <th>No</th>
              <th>Nama Supir</th>
              <th>Alamat</th>
              <th>No. HP</th>
              <th>Status</th>
              <th>Action</th>
          </tr>
        </tfoot>   
      </table>


    </div>

    <!------------------------------------------------------------------------------------------------------>

  </div>
</div>
</div><!-- /.col -->
</div>
</div>    
</div>  

<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data ini ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn red" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()"  class="btn green">Ya</button>
      </div>
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
                <img class="btn-back" src="<?php echo base_url().'component/img/back_icon.png'?>" style="width: 70px;height: 70px;">

        <script>
          $('.btn-back').click(function(){
$(".tunggu").show();
            window.location = "<?php echo base_url().'master/daftar/'; ?>";
          });
        </script>

<script>
function actDelete(Object) {
  $('#id-delete').val(Object);
  $('#modal-confirm').modal('show');
}

function delData() {
  var id = $('#id-delete').val();
  var url = '<?php echo base_url().'master/sopir/hapus'; ?>';
  $.ajax({
    type: "POST",
    url: url,
    data: {
      id: id
    },
    beforeSend:function(){
          $(".tunggu").show();  
        },
success: function(msg) {
      $('#modal-confirm').modal('hide');
            // alert(id);
            window.location.reload();
          }
        });
  return false;
}

$(document).ready(function(){

  $("#tabel_daftar").dataTable({
    "paging":   false,
    "ordering": true,
    "info":     false
  });
})

</script>