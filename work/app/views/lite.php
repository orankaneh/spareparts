<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv='expires' content='-1' />
<meta http-equiv='pragma' content='no-cache' />
<link rel="shortcut icon" href="<?= app_base_url('/assets/favicon.ico') ?>" >
<title>Morbis Tablet Edition. Selamat Datang</title>

<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/barcode.css') ?>" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/jquery.flipflopfolding.css') ?>" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/jquery.partsselector.css') ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/workspace.lite.css') ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css') ?>" media="all" /> <!-- Keterangan Form -->
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tipsy.css') ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/jquery.ui.css') ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/jquery.autocomplete.css') ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/jquery.multiselect.css') ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/ui.slider.css') ?>" media="all" />

<script type="text/javascript" src="<?= app_base_url('/assets/js/jquery-latest.js') ?>"></script>
<script type="text/javascript" src="<?= app_base_url('/assets/js/jquery-ui-1.8.6.custom.min.js') ?>"></script>
<script type="text/javascript" src="<?= app_base_url('/assets/js/config.js') ?>"></script>
<script type="text/javascript" src="<?= app_base_url('/assets/js/jquery.tipsy.js') ?>"></script>
<script type="text/javascript" src="<?= app_base_url('/assets/js/jquery.flipflopfolding.js') ?>"></script>
<script type="text/javascript" src="<?= app_base_url('/assets/js/jquery.autocomplete.js') ?>"></script>
<script type="text/javascript" src="<?= app_base_url('/assets/js/jquery.cookies.js') ?>"></script>
<script type="text/javascript" src="<?= app_base_url('/assets/js/jquery.multiselect2side.js') ?>"></script>
<script type="text/javascript" src="<?= app_base_url('/assets/js/jquery.partsselector.js') ?>"></script>
<script type="text/javascript" src="<?= app_base_url('/assets/js/jquery.uniquedatacheck.js') ?>"></script>
<script type="text/javascript" src="<?= app_base_url('/assets/js/jquery.fusioncharts.js')?>"></script>
<script type="text/javascript" src="<?= app_base_url('/assets/js/library.js')?>"></script>
<script type="text/javascript" src="<?= app_base_url('/assets/js/workspace.lite.js')?>"></script>
<script type="text/javascript" src="<?= app_base_url('assets/js/jquery.watermark.js') ?>"></script>
<script type="text/javascript" src="<?= app_base_url('assets/js/jquery-ui-timepicker-addon.js') ?>"></script>

<script type="text/javascript">
//@idPacking id packing barang
//@el elemen yang akan menampung nilai

function hitung_ROP(idPacking,el){
         $.ajax({
                url: '<?=  app_base_url('/inventory/search')?>',
                cache: false,
                data:'idPacking='+idPacking+'&opsi=hitung_rop',
                dataType: 'json',
                success: function(msg){
                    var hasil=Math.ceil(msg.rop);
                    if(hasil==null){
                        hasil=0;
                    }
                    $(el).html(hasil);
					
                }
         });
}

$(document).ready(function(){
longwidth=($(window).width()-200)/2;
longheight=($(window).height()-275)/2;

$('#load').css('top',longheight);
$('#load').css('left',longwidth);
    $('.main').delegate('.datetimepicker','focusin',function(){
        $('.datetimepicker').datetimepicker({
           dateFormat: 'dd/mm/yy',
           timeFormat: 'hh:mm:ss',
           changeMonth: true,
           changeYear: true,
           showSecond: true
        })
    })
    $('#hidegrid').click(function(){
        $('#openribbon').slideUp();
	$('#showgrid').show();
	$(this).hide();
	
	
      });
    
      
      $('#showgrid').click(function(){
	 $('#maincontent').hide();
         $('#openribbon').slideDown();
	 $('#hidegrid').show();
	$(this).hide();
      });
      /*
    if(getCookies('menu')=='tutup'){
        $('.leafribbon').hide();
         $('.showleaf').show();
         $('.main').css('margin-top','35px');
    }else{
        $('.leafribbon').show();
         $('.showleaf').hide();
         var leafheight=($(".leafribbon").height())+40;
         $(".main").css('margin-top',leafheight+'px');
    }*/
});


</script>

</head>
<?php flush(); ?>

<body onLoad="showTime();">

<div class="watermark">&nbsp;</div>
<?php
set_time_zone();
ob_start();
@set_time_limit(5);
@ini_set('memory_limit', '64M');

	 $row=array();
	 $date = time();
	 $day = date("d", $date);
	 $month = date("m", $date);
	 $year = date("Y", $date);
	 $month2= date("F", $date);
	 
	 $row[]= "<h3 style='margin-left: 10px'>$month2 $year </h3>
	 
	 <div align='center'>
	 ";
	 $first_day = mktime(0,0,0,$month, 1, $year);
	 $title = date("F", $first_day);
	 $day_of_week = date("D", $first_day);
	 
	 switch($day_of_week) {
	 case "Sun": $blank = 0; break;
	 case "Mon": $blank = 1; break;
	 case "Tue": $blank = 2; break;
	 case "Wed": $blank = 3; break;
	 case "Thu": $blank = 4; break;
	 case "Fri": $blank = 5; break;
	 case "Sat": $blank = 6; break;
	 }
	 
	 $days_in_month = cal_days_in_month(0, $month, $year);
	  $row[]="<table border='0' cellspacing='0' width='155'>
	  <tr><td><table border=\"0\" cellpadding=\"0\" cellspacing=\"1\" style=\" color: #000; text-align: center\">
	 <tr class='stdheaderCalendar'>
		 <td>Mng</td>
		 <td>Sen</td>
		 <td>Sel&nbsp;</td>
		 <td>Rab</td>
		 <td>Kam</td>
		 <td>Jum</td>
		 <td>Sab</td>
	 </tr>
	 <tr>	";
	 $day_count = 1;
	 $day_number = 1;
	 while($blank > 0) {
	  $row[]="	<td style='background: #ccc'></td>";
	 $blank = $blank-1;
	 $day_count++;
	 }
	 while($day_number <= $days_in_month) {
	 if($day_number < $day) {
	  $row[]="	<td style='border: 1px solid #C9C6B3; color: #000; padding: 3px'>$day_number</td>	";
	 }
	 elseif($day_number == $day) {
	  $row[]="	<td style='background: #aed2ec; border: 1px solid #555; color: #fff; padding: 3px'>$day_number</td>	";
	 }
	 else {
	  $row[]="	<td style='border: 1px solid #C9C6B3; color: #000; padding: 3px'>$day_number</td>	";
	 }
	 $day_number++;
	 $day_count++;
	 
	 if($day_count > 7) {
	  $row[]="</tr><tr>	";
	 $day_count = 1;
	 }
	 }
	 
	 while($day_count > 1 && $day_count <= 7) {
	 $row[]="<td></td>	"; 
	 $day_count++;
	 }
	 $row[]="</tr></table></td></tr></table></div>";
		
	 $showcal=implode("",$row);
	 
	 $role=User::$id_role;
         
	 $cuturl=str_replace("index.php","",$_SERVER['PHP_SELF']);
         if ($cuturl=="/") $url_mirror=substr($_SERVER['REDIRECT_URL'],1,strlen($_SERVER['REDIRECT_URL']));
	 else $url_mirror=str_replace($cuturl,"",$_SERVER['REDIRECT_URL']);
         
         
	 $navmenu=array();
	 
	 $obj_submodule=mysql_query("select r.*,p.* from role_permission r
		   join privileges p on (p.id=r.id_privileges)
		   where r.id_role = '$_SESSION[id_role]'");
	 while ($map_sub=mysql_fetch_array($obj_submodule)) {
		 if ($map_sub['status_module']==1) $status_mod=app_base_url();
		 else $status_mod="http://localhost/agile/";
		 
		 
		 $cekslash=preg_match('~^'.$map_sub['url'].'/$~', $url_mirror);
		 if ($cekslash==1) {
		    $urlcut=substr($url_mirror,0,-1);
		    $pos=preg_match('~^'.$map_sub['url'].'$~', $urlcut);
		 } else {
		    $pos=preg_match('~^'.$map_sub['url'].'$~', $url_mirror);
		 }
       
		    
		 if(!empty($map_sub['icon_extra'])) {
		    $exicon=explode('-',$map_sub['icon_extra']);
		    $xaxis=($exicon[0]>1)?(($exicon[0]-1)*-128): 0;
		    $yaxis=($exicon[1]>1)?(($exicon[0]-1)*-128): 0;
		    
		    
		    $icon=$xaxis."px ".$yaxis."px";
		 } else {
		    $icon="";
		 }
		 
		 $navmenu[]=array(
			 'icon'=> $icon,
			 'title'=>$map_sub['nama'],
			 'url'=>$map_sub['url'],
			 'base'=>$status_mod,
			
			 );	 
	 }
?>


<div class="ribbon">
        <div class="mainribbon">
				
                <div class="x16 exit" onclick="window.location='<?php echo app_base_url("/?logout=1"); ?>'"></div>
				<div id="showgrid"><div class="x16 grid-show"></div></div>
				<div id="hidegrid"><div class="x16 grid-hide"></div></div>
				<ul id="mainpanel"> 	
					<li id="timepanel">
						<a href="#" id="maxtime">&nbsp;</a>
						<div class="subpanel"><?php
						echo $showcal;
						?></div>
					</li>
				
				
					<li id="userpanel">
					        
						</div>
					</li>
					
				</ul>   
				
         
                <div class="clear"></div>
        </div>

        <div id="openribbon">
        <div class="leafribbon">
	 
	 <img src="<?= app_base_url('/assets/uploads/avatar/doctor.gif') ?>" class="avatar" align="left">

	 <?php
	 
	 
		  $id = User::$id_user;
		  $sql = "select u.username,p.nama as penduduk,r.nama_role as role,un.nama as unit,k.nama as kategori from users u
		  left join penduduk p on u.id = p.id
		  left join unit un on u.id_unit = un.id
		  join role r on u.id_role = r.id_role
		  join kategori_barang k on r.id_kategori_barang_pemesanan_role = k.id where u.id = '$id'";
		  
		  $data = _select_unique_result($sql);
	 
	    
		  echo "
		  <h1>$data[penduduk]</h1> <br />
		  Username : <b>$data[username]</b> <br />
		  Unit : <b>$data[unit]</b> <br />
		  Role : <b>$data[role]</b><br />
		  Kategori Barang : <b>$data[kategori]</b>
						      ";
						      ?>
	 
                <div class="mainlogo floright"></div>
                <div class="clear"></div>
        </div>
	
	 <center>

        <div class="navigation-grid">
	 
	  <ul class='asseticon'><?php
		  foreach($navmenu as $submodule): ?>
		  <li><center>
			<div url="<?php echo $submodule['base']."/".$submodule['url']; ?>" class='x128' style='background-position: <?php echo $submodule['icon']; ?>'/></div>
			<?php echo $submodule['title']; ?>
		  </center></li>
		  <?php endforeach; ?>
		  <div class="clear"></div>
          </ul>
	 </div>
	 </center>
	 </div>
</div>
<div class="main clear" id="maincontent">
    <?php echo $_content ?>
</div>
        







<div class="processing" id="load">
<img src="<?php echo app_base_url("assets/images/process.gif"); ?>" align="left"><h1>&nbsp; Mohon Tunggu ...</h1></div>	
</body>
</html>
<noscript><div class="windowsjavascript"><div>Maaf Javascript pada browser anda tidak aktif.<br>mohon aktifkan untuk menggunakan sistem ini.</div></div></noscript>
