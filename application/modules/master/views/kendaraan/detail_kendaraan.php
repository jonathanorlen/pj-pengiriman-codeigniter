<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Detail Kendaraan

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
      ?>
      <div class="box-body">                   
        <div class="sukses" ></div>
        <form id="data_form">
          <div class="box-body">            
            <div class="row">
              <div class="form-group  col-xs-6">
                <label><b>Kode Kendaraan</label>
                <input type="hidden" name="id" value="<?php echo @$hasil_kendaraan->id; ?>" />
                <input <?php if(!empty($param)){ echo "readonly='true'"; } ?> type="text" class="form-control" value="<?php echo @$hasil_kendaraan->kode_kendaraan; ?>" name="kode_kendaraan" id="kode_kendaraan"/>
              </div>

              <div class="form-group col-xs-6">
                <label class="gedhi"><b>Nama Kendaraan</label>
                <input disabled type="text" value="<?php echo @$hasil_kendaraan->nama_kendaraan; ?>" class="form-control" name="nama_kendaraan" />

              </div>
               <div class="form-group col-xs-6">
                <label class="gedhi"><b>No. Kendaraan</label>
                <input disabled type="text" value="<?php echo @$hasil_kendaraan->no_kendaraan; ?>" class="form-control" name="no_kendaraan" />
              </div>
              <div class="form-group col-xs-4">
                <label class="gedhi"><b>STNK</label>
                <input disabled type="text" value="<?php echo @$hasil_kendaraan->stnk; ?>" class="form-control" name="no_hp" />
              </div>
               <div class="form-group col-xs-2">
                <label class="gedhi"><b>Status</label>
                <select name="status" disabled class="form-control">
                 <option <?php if(@$hasil_kendaraan->status=='1'){echo 'selected';} ?> value="1" class="form-control">Aktif</option>
                  <option <?php if(@$hasil_kendaraan->status=='0'){echo 'selected';} ?> value="0" class="form-control">Tidak Aktif</option>
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
            window.location = "<?php echo base_url().'master/kendaraan/'; ?>";
          });

          $('#ok').click(function(){
$(".tunggu").show();
            window.location = "<?php echo base_url().'master/kendaraan/'; ?>";
          });
        </script>

<script>