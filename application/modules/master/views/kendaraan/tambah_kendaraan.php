<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Tambah Kendaraan

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
        $kendaraan = $this->db->get_where('master_kendaraan',array('id'=>$param));
        $hasil_kendaraan= $kendaraan->row();
      }

      $this->db->select_max('id');
      $get_max_member = $this->db->get('master_kendaraan');
      $max_member = $get_max_member->row();

      $this->db->where('id', $max_member->id);
      $get_kendaraan = $this->db->get('master_kendaraan');
      $kendaraan = $get_kendaraan->row();
      $nomor = substr(@$kendaraan->kode_kendaraan, 4);
      $nomor = $nomor + 1;
      $string = strlen($nomor);
      if($string == 1){
        $kode_kendaraan ='000'.$nomor;
      } else if($string == 2){
        $kode_kendaraan ='00'.$nomor;
      } else if($string == 3){
        $kode_kendaraan ='0'.$nomor;
      } else if($string == 4){
        $kode_kendaraan =''.$nomor;
      } 
      ?>
      <div class="box-body">                   
        <div class="sukses" ></div>
        <form id="data_form">
          <div class="box-body">            
            <div class="row">
              <div class="form-group  col-xs-6">
                <label><b>Kode Kendaraan</label>
                <input type="hidden" name="id" value="<?php echo @$hasil_kendaraan->id; ?>" />
                <input readonly="" <?php if(!empty($param)){ } ?> type="text" class="form-control" value="<?php if(!empty($param)){ echo @$hasil_kendaraan->kode_kendaraan;}else{echo "KDR_".$kode_kendaraan;} ?>" name="kode_kendaraan" id="kode_kendaraan"/>
              </div>

              <div class="form-group col-xs-6">
                <label class="gedhi"><b>Nama Kendaraan</label>
                <input  type="text" value="<?php echo @$hasil_kendaraan->nama_kendaraan; ?>" class="form-control" name="nama_kendaraan" />

              </div>
              <div class="form-group col-xs-6">
                <label class="gedhi"><b>No. Kendaraan</label>
                <input  type="text" value="<?php echo @$hasil_kendaraan->no_kendaraan; ?>" class="form-control" name="no_kendaraan" />
              </div>
              <div class="form-group col-xs-4">
                <label class="gedhi"><b>STNK</label>
                <input  type="text" value="<?php echo @$hasil_kendaraan->stnk; ?>" class="form-control" name="stnk" />
              </div>
              <div class="form-group col-xs-2">
                <label class="gedhi"><b>Status</label>
                <select name="status"  class="form-control">
                  <option <?php if(@$hasil_kendaraan->status=='1'){echo 'selected';} ?> value="1" class="form-control">Aktif</option>
                  <option <?php if(@$hasil_kendaraan->status=='0'){echo 'selected';} ?> value="0" class="form-control">Tidak Aktif</option>
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
    window.location = "<?php echo base_url().'master/kendaraan/'; ?>";
  });

</script>



<script>
  $(function(){

    $("#data_form").submit( function() {

     <?php if(!empty($param)){ ?>
      var url = "<?php echo base_url(). 'master/kendaraan/simpan_edit_kendaraan'; ?>";  
      <?php }else{ ?>
        var url = "<?php echo base_url(). 'master/kendaraan/simpan_kendaraan'; ?>";
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
         setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'master/kendaraan/' ?>";},1000);  


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