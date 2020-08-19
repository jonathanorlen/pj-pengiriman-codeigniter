<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
  <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="images/apple-touch-startup-image-640x1096.png">
  <meta name="author" content="SINDEVO.COM" />
  <meta name="description" content="biotic - mobile and tablet web app template" />
  <meta name="keywords" content="mobile css template, mobile html template, jquery mobile template, mobile app template, html5 mobile design, mobile design" />
  <title>PATRIOTJAYA-PENGIRIMAN</title>>
  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700,900' rel='stylesheet' type='text/css'>
  <script src="<?php echo base_url() . 'template/js/jquery.min.js' ?>"></script> 
  <link rel="stylesheet" href="<?php echo base_url() . 'template/css/themes/default/jquery.mobile-1.4.5.css' ?>">
  <link type="text/css" rel="stylesheet" href="<?php echo base_url() . 'template/style.css' ?>">
  <link type="text/css" rel="stylesheet" href="<?php echo base_url() . 'template/css/colors/yellow.css' ?>">
  <link type="text/css" rel="stylesheet" href="<?php echo base_url() . 'template/css/swipebox.css' ?>">
  <link href="<?php echo base_url() . 'component/admin/assets/global/plugins/bootstrap/css/bootstrap.min.css '?> " rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url() . 'component/admin/assets/global/plugins/bootstrap/css/bootstrap.min.css '?> " rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'template/css/AdminLTE.min.css' ?>">
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  



  
</head>
<body>

  <div class="tunggu" style="z-index:9999999999999999; background:rgba(51, 50, 50, 0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display: none;" >
    <img src="<?php echo base_url() . '/public/images/loading1.gif' ?>" style="width:72px; height: 72px;"/>
  </div>
  <div data-role="page" id="homepage" data-theme="b">
   <!--  <div data-role="header" data-position="fixed" role="banner" class="ui-header ui-bar-inherit ui-header-fixed slidedown ui-panel-fixed-toolbar ui-panel-animate ui-panel-page-content-position-left ui-panel-page-content-display-reveal ui-panel-page-content-open">
      <div class="nav_left_button"><a href="#" class="nav-toggle ui-link navtoggleon"><span></span></a></div>
      <div class="nav_center_logo">Kasir</div>
     
      <div class="clear"></div>
    </div> -->
    <div role="main" class="ui-content" style="padding: 40px;">


      <div style="border-top: 3px solid #29d8ff; background-color: #FFF;padding: 10px;margin-right: 110px;margin-left: 70px;
      padding-bottom: 10px; height: 600px;">

       <h2 style="font-size: 30px;
    font-weight: bold;
    font-family: -webkit-pictograph;
    color: #ca2c2c;"><p align="center">SELAMAT DATANG DI PATRIOT JAYA - PENGIRIMAN</p></h2>
      <div id="omset2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


      

    </div>
  </div><!-- /content -->
  <?php
  $jam=date('H:i');
  $hari=date('Y-m-d');
  $cek_time = $this->db->get_where('master_shipping', array('jam_1 <=' => $jam,'jam_2 >=' => $jam));
  $hasil_cek_time=$cek_time->num_rows();
  $data_cek_time=$cek_time->row();
  if($hasil_cek_time==1){

    $penjualan = $this->db->get_where('transaksi_penjualan', array('status_penerimaan' => 'dikirim','tanggal_pengiriman' => $hari,'jam_pengiriman >=' => $data_cek_time->jam_1,'jam_pengiriman <=' => $data_cek_time->jam_2));
    
    $hasil_penjualan = $penjualan->result();  
  }
  
  //echo $this->db->last_query();
  
  $notif_pengiriman=count($hasil_penjualan);
  ?>
  <div data-role="panel" id="left-panel" data-display="reveal" data-position="left">

    <nav class="main-nav">
      <ul>
        <li style="background-color: rgb(203, 32, 37);cursor: pointer;" class="hoveren">
          <a style="text-decoration: none;" id="das" data-transition="slidefade">
            <img src="<?php echo base_url().'template/images/icons/white/team.png' ?>" alt="" title="" /><span>Dashboard</span>
          </a>
        </li>
        <li style="background-color: rgb(248, 179, 52);cursor: pointer;" class="hoveren">
          <a style="text-decoration: none;" id="master" data-transition="slidefade">
            <img src="<?php echo base_url().'template/images/icons/white/settings.png' ?>" alt="" title="" /><span>Master</span>
          </a>
        </li>
        <li style="background-color: rgb(48, 79, 200);cursor: pointer;" class="hoveren">
          <a style="text-decoration: none;" id="list_pengiriman" data-transition="slidefade">
            <img src="<?php echo base_url().'template/images/icons/white/map.png' ?>" alt="" title="" /><span>List Pengiriman</span>
          </a>
          <?php if($notif_pengiriman > 0){
            ?>
            <span style="    background-color: red;
            width: 30px;
            vertical-align: middle;
            border-radius: 20px;
            margin-left: 90px;
            margin-top:-50px;
            position:absolute;
            "><?php  echo $notif_pengiriman; ?></span>
            <?php } ?>
          </li>
          <li style="background-color:  #28156e;cursor: pointer;" class="hoveren">
            <a style="text-decoration: none;" id="logout" data-transition="slidefade">
              <img src="<?php echo base_url().'template/images/icons/white/lock.png' ?>" alt="" title="" /><span>Logout</span>
            </a>
          </li>

        </ul>
      </nav> 

    </div><!-- /panel -->

         <!--  <div data-role="panel" id="right-panel" data-display="reveal" data-position="right">

            <div class="user_login_info">

              <div class="user_thumb_container">
                <img src="images/profile.jpg" alt="" title="" /> 
                <div class="user_thumb">
                  <img src="images/author.jpg" alt="" title="" />     
                </div>  
              </div>

              <div class="user_details">
                <p>Sarah Williams</p>
                <ul class="user_social">
                  <li><a href="social.html"><img src="images/icons/white/twitter.png" alt="" title="" /></a></li>
                  <li><a href="social.html"><img src="images/icons/white/facebook.png" alt="" title="" /></a></li> 
                  <li><a href="social.html"><img src="images/icons/white/dribbble.png" alt="" title="" /></a></li>               
                </ul> 
              </div>  


              <nav class="user-nav">
                <ul>
                  <li><a href="features.html"><img src="images/icons/white/settings.png" alt="" title="" /><span>Settings</span></a></li>
                  <li><a href="features.html"><img src="images/icons/white/briefcase.png" alt="" title="" /><span>Account</span></a></li>
                  <li><a href="features.html"><img src="images/icons/white/message.png" alt="" title="" /><span>Messages</span><strong class="yellow">12</strong></a></li>
                  <li><a href="features.html"><img src="images/icons/white/download.png" alt="" title="" /><span>Downloads</span><strong class="yellow">5</strong></a></li>
                  <li><a href="index.html"><img src="images/icons/white/lock.png" alt="" title="" /><span>Logout</span></a></li>
                </ul>
              </nav>
            </div>
            <div class="close_loginpopup_button"><a href="#" data-rel="close"><img src="images/icons/white/menu_close.png" alt="" title="" /></a></div>

  </div> --><!-- /panel

</div><!-- /page -->

<script src="<?php echo base_url() . 'template/js/jquery.mobile-1.4.5.min.js' ?>"></script>
<script src="<?php echo base_url() . 'template/js/jquery.validate.min.js' ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() . 'template/js/email.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'template/js/jquery.swipebox.js' ?>"></script>
<script src="<?php echo base_url() . 'template/js/jquery.mobile-custom.js' ?>"></script>
<style type="text/css" media="screen">
.hoveren{

}
.hoveren:hover
{
  transition: all 200ms ease-in;
  box-shadow: 2px 3px 5px #6f6f6f;
  transform: scale(1.2);
}



/* Let's get this party started */
::-webkit-scrollbar {
  width: 4px;
}

/* Track */
::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
  -webkit-border-radius: 10px;
  border-radius: 10px;
}

/* Handle */
::-webkit-scrollbar-thumb {
  -webkit-border-radius: 10px;
  border-radius: 10px;
  background: rgba(255,0,0,0.8); 
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
}
::-webkit-scrollbar-thumb:window-inactive {
  background: rgba(255,0,0,0.4); 
}
</style>
<script>
$(function () {


 /*  $('#omset2').highcharts({
    chart: {
      backgroundColor: '#FFFFFF'
    },
    title: {
      text: 'Grafik Omset Kasir',
            x: -20 //center
          },
          subtitle: {
            text: 'Sift 2',
            x: -20
          },
          xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']

          },
          xAxis: {
            alternateGridColor: '#FFFFFF',
          },
          yAxis: {
            alternateGridColor: '#FDFFD5',
            title: {
              text: 'Jumlah Omset'
            },
            plotLines: [{
              value: 0,
              width: 1,
              color: '#FFFFFF'
            }]
          },
          tooltip: {
            valueSuffix: 'Rp'
          },
          legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
          },
          series: [{
            name: 'Omset',
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
          },]
        }); */
});
</script>
<script>

$('#das').click(function(){
  $(".tunggu").show();
  window.location = "<?php echo base_url().'admin' ?>";

});
$('#master').click(function(){
      //$('body').fadeOut();
      $(".tunggu").show();
      window.location = "<?php echo base_url().'master/daftar/' ?>";
    });
$('#list_pengiriman').click(function(){
      //$('body').fadeOut();
      $(".tunggu").show();
      window.location = "<?php echo base_url().'pengiriman/daftar_pengiriman' ?>";
    });

$('#validasi').click(function(){
  $(".tunggu").show();
  window.location = "<?php echo base_url().'validasi_request_order/' ?>";
});

$('#daftar_po').click(function(){
  $(".tunggu").show();
  window.location = "<?php echo base_url().'pre_order/daftar' ?>";
});
$('#stok').click(function(){
  $(".tunggu").show();
  window.location = "<?php echo base_url().'stok/gudang' ?>";
});
$('#transaksional').click(function(){
  $(".tunggu").show();
  window.location = "<?php echo base_url().'transaksional' ?>";
});
$('#keuangan').click(function(){
  $(".tunggu").show();
  window.location = "<?php echo base_url().'keuangan' ?>";
});

$('#analisa').click(function(){
  $(".tunggu").show();
  window.location = "<?php echo base_url().'analisa' ?>";
});
$('#laporan').click(function(){
  $(".tunggu").show();
  window.location = "<?php echo base_url().'laporan' ?>";
});
$('#logout').click(function(){
  $(".tunggu").show();
  window.location = "<?php echo base_url() . 'admin/logout' ?>";
});

</script>
<script type="text/javascript">
$(document).ready(function(){  
  $('.master_setup').hide();
});
</script>


</body>
</html>
