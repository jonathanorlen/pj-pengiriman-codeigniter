<div class="">
  <div class="page-content">

    <div class="box-footer clearfix">
      <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url() . 'master/shipping_time/tambah/' ?>"><i class="fa fa-edit"></i> Tambah </a>
      <a style="padding:13px; margin-bottom:10px;" class="btn btn-app blue" href="<?php echo base_url() . 'master/shipping_time/' ?>"><i class="fa fa-list"></i> Daftar </a>
    </div>


<div id="box_load">
 <?php echo @$konten; ?>
 </div>
</div>
</div>

<script>
 $(document).ready(function(){

  $("#tambah").click(function(){
    window.location = "<?php echo base_url() . 'shipping_time/tambah' ?>";                
  });

  $("#daftar").click(function(){
    window.location = "<?php echo base_url() . 'shipping_time/' ?>";            
  });

});
</script>
