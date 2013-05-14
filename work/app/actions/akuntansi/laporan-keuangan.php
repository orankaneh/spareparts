<?php
require_once 'app/actions/admisi/pesan.php';
require_once "app/lib/common/functions.php";
require_once "app/lib/common/master-akuntansi.php";
$tab=(isset($_GET['tab']))?$_GET['tab']:'lr';
$array_bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Augustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$urlN = app_base_url("akuntansi/report/neraca?N=true");
?>
<h2 class="judul"><a href="#">Laporan Keuangan</a></h2><?= isset($pesan) ? $pesan : NULL ?>
<script type="text/javascript">
$(document).ready(function() {
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); 
		$(this).addClass("active");
		$(".tab_content").hide(); 
		var activeTab = $(this).find("a").attr("href"); 
		$(activeTab).fadeIn(); 
		return false;
	});
	
});
var go = function(val,alrt,content,urll){
	$('#load').show();
		if(val=='ya'){
			$('#'+alrt).html('');
			$.ajax({
				url: urll,
				cache: false,
				dataType: 'html',
				success: function(data){
					$('#load').hide();
					$('#'+content).html(data);
				},
				error:function(error){
					$('#load').hide();
					alert("ERROR : "+error);
				}
			});  
		}else{
			$('#load').hide();
			$('#'+alrt).html('');
			 $('#'+content).html('');
		}
	}
</script>
<ul class="tabs">
    <li class="<?=($tab=='lr')?'active':''?>"><a href="#lr">Laporan Laba Rugi</a></li>
    <li class="<?=($tab=='pm')?'active':''?>"><a href="#pm">Laporan Perubahan Modal</a></li>
    <li class="<?=($tab=='n')?'active':''?>"><a href="#n">Neraca</a></li>
</ul>
<div id="loading"></div>
<div class="tab_container">
    <?php
			echo "<div id='lr' class='tab_content ".(($tab==NULL)?'active':'')."'>";
				require_once 'app/actions/akuntansi/laporan-laba-rugi.php';
				echo"<div id='contentLR' ></div>";
			echo '</div>';

			echo "<div id='pm' class='tab_content ".(($tab==NULL)?'active':'')."'>";
				require_once 'app/actions/akuntansi/laporan-perubahan-modal.php';
				echo"<div id='contentPM' ></div>";
			echo '</div>';

			echo "<div id='n' class='tab_content ".(($tab==NULL)?'active':'')."'>";
				require_once 'app/actions/akuntansi/laporan-neraca.php';
				echo"<div id='contentN' ></div>";
			echo '</div>';
    ?>
</div>
<script type="text/javascript">
	function cekTab(){
            $(".tab_content").hide();
            $('#<?=$tab?>').fadeIn();
    }

    $(document).ready(function(){
        $('.active').fadeIn();
        cekTab();
        
    })
</script>