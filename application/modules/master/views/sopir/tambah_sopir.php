<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Tambah Supir

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
    
      $param = $this->uri->segment(4);
      if(!empty($param)){
        $supir = $this->db->get_where('master_supir',array('id'=>$param));
        $hasil_supir= $supir->row();
      }

       $this->db->select_max('id');
      $get_max_member = $this->db->get('master_supir');
      $max_member = $get_max_member->row();

      $this->db->where('id', $max_member->id);
      $get_supir = $this->db->get('master_supir');
      $supir = $get_supir->row();
      $nomor = substr(@$supir->kode_supir, 4);
      $nomor = $nomor + 1;
      $string = strlen($nomor);
      if($string == 1){
        $kode_supir ='000'.$nomor;
      } else if($string == 2){
        $kode_supir ='00'.$nomor;
      } else if($string == 3){
        $kode_supir ='0'.$nomor;
      } else if($string == 4){
        $kode_supir =''.$nomor;
      } 
      ?>
      <div class="box-body">                   
        <div class="sukses" ></div>
        <form id="data_form">
          <div class="box-body">            
            <div class="row">
              <div class="form-group  col-xs-6">
                <label><b>Kode Supir</label>
                <input type="hidden" name="id" value="<?php echo @$hasil_supir->id; ?>" />
                <input readonly="" <?php if(!empty($param)){  } ?> type="text" class="form-control" value="<?php if(!empty($param)){echo @$hasil_supir->kode_supir;}else{echo "SUP_".$kode_supir;} ?>" name="kode_supir" id="kode_supir"/>
              </div>

              <div class="form-group col-xs-6">
                <label class="gedhi"><b>Nama</label>
                <input  type="text" value="<?php echo @$hasil_supir->nama; ?>" class="form-control" name="nama" />

              </div>
               <div class="form-group col-xs-6">
                <label class="gedhi"><b>Alamat</label>
                <input  type="text" value="<?php echo @$hasil_supir->alamat; ?>" class="form-control" name="alamat" />
              </div>
              <div class="form-group col-xs-4">
                <label class="gedhi"><b>Telepon</label>
                <input  type="text" value="<?php echo @$hasil_supir->no_hp; ?>" class="form-control" name="no_hp" />
              </div>
               <div class="form-group col-xs-2">
                <label class="gedhi"><b>Status</label>
                <select name="status"  class="form-control">
                  <option <?php if (@$hasil_supir->status=='1'){ echo 'selected';} ?> value="1" class="form-control">Aktif</option>
                  <option  <?php if (@$hasil_supir->status=='0'){ echo 'selected';} ?> value="0" class="form-control">Tidak Aktif</option>
                </select>
              </div>
           
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<!------------------------------------------------------------------------------------------------------>


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
                    window.location = "<?php echo base_url().'master/sopir/'; ?>";
                  });
                </script>



<script>
$(function(){

  $("#data_form").submit( function() {

   <?php if(!empty($param)){ ?>
    var url = "<?php echo base_url(). 'master/sopir/simpan_edit_supir'; ?>";  
    <?php }else{ ?>
      var url = "<?php echo base_url(). 'master/sopir/simpan_tambah_sopir'; ?>";
      <?php } ?>
      $.ajax( {
       type:"POST", 
       url : url,  
       cache :false,  
       data :$(this).serialize(),
       beforeSend: function(){
         $(".loading").show(); 
       },
       beforeSend:function(){
        $(".tunggu").show();  
      },
      success : function(data) {  

       $(".sukses").html('<div class="alert alert-success">Data Berhasil Disimpan</div>');
       setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'master/sopir/' ?>";},1000);  


       $(".loading").hide();             
     },  
     error : function(data) {  
      alert(data);  
    }  
  });
      return false;                    
    });
})

</script>