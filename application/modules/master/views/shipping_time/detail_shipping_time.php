<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Shipping Time

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
        $jadwal_shipping = $this->db->get_where('master_shipping',array('id'=>$param));
        $hasil_jadwal_shipping= $jadwal_shipping->row();
      }
      ?>
      <div class="box-body">                   
        <div class="sukses" ></div>
        <form id="data_form" action="<?php echo base_url('admin/master/simpan_rak'); ?>" method="post">
          <div class="box-body">            
            <div class="row">
              <div class="form-group  col-xs-6">
             
                <label><b>Nama Jadwal</label>
                <input type="hidden" name="id" value="<?php echo @$hasil_jadwal_shipping->id; ?>" />
                <input <?php if(!empty($param)){ echo "readonly='true'"; } ?> type="text" class="form-control" value="<?php echo @$hasil_jadwal_shipping->nama_jadwal; ?>" name="nama_jadwal" id="nama_jadwal"/>
              </div>

              <div class="form-group col-xs-3">
                <label class="gedhi"><b>Jam Mulai</label>
                <input disabled type="text" value="<?php echo @$hasil_jadwal_shipping->jam_1; ?>" class="form-control" name="jam_1" />

              </div>
               <div class="form-group col-xs-3">
                <label class="gedhi"><b>Jam Selesai</label>
                <input disabled type="text" value="<?php echo @$hasil_jadwal_shipping->jam_2; ?>" class="form-control" name="jam_2" />
              </div>
           
            </div>
            <div class="form-group">
              <a id="ok" class="btn btn-primary">OK</a>
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
            window.location = "<?php echo base_url().'master/shipping_time/'; ?>";
          });
          $('#ok').click(function(){
            $(".tunggu").show();
            window.location = "<?php echo base_url().'master/shipping_time/'; ?>";
          });
        </script>

