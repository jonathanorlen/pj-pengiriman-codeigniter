<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Detail Supir

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
      ?>
      <div class="box-body">                   
        <div class="sukses" ></div>
        <form id="data_form">
          <div class="box-body">            
            <div class="row">
              <div class="form-group  col-xs-6">
                <label><b>Kode Supir</label>
                <input type="hidden" name="id" value="<?php echo @$hasil_supir->id; ?>" />
                <input <?php if(!empty($param)){ echo "readonly='true'"; } ?> type="text" class="form-control" value="<?php echo @$hasil_supir->kode_supir; ?>" name="kode_supir" id="kode_supir"/>
              </div>

              <div class="form-group col-xs-6">
                <label class="gedhi"><b>Nama</label>
                <input disabled type="text" value="<?php echo @$hasil_supir->nama; ?>" class="form-control" name="nama" />

              </div>
               <div class="form-group col-xs-6">
                <label class="gedhi"><b>Alamat</label>
                <input disabled type="text" value="<?php echo @$hasil_supir->alamat; ?>" class="form-control" name="alamat" />
              </div>
              <div class="form-group col-xs-4">
                <label class="gedhi"><b>Telepon</label>
                <input disabled type="text" value="<?php echo @$hasil_supir->no_hp; ?>" class="form-control" name="no_hp" />
              </div>
               <div class="form-group col-xs-2">
                <label class="gedhi"><b>Status</label>
                <select name="status" disabled class="form-control">
                   <option <?php if (@$hasil_supir->status=='1'){ echo 'selected';} ?> value="1" class="form-control">Aktif</option>
                  <option  <?php if (@$hasil_supir->status=='0'){ echo 'selected';} ?> value="0" class="form-control">Tidak Aktif</option>
                </select>
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
            window.location = "<?php echo base_url().'master/sopir/'; ?>";
          });

          $('#ok').click(function(){
$(".tunggu").show();
            window.location = "<?php echo base_url().'master/sopir/'; ?>";
          });
        </script>


