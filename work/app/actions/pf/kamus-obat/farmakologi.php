<?php
$tab=(isset($_GET['tab']))?$_GET['tab']:'tab1';
$page = isset($_GET['page'])?$_GET['page']:1;
if($tab == "tab1"){
    $page_induk = $page;
    $page_gol = 1;
    $page_sub_gol = 1;
}else if($tab == "tab2"){
    $page_induk = 1;
    $page_gol = $page;
    $page_sub_gol = 1;
}else if($tab == "tab3"){
    $page_induk = 1;
    $page_gol = 1;
    $page_sub_gol = $page;
}
?>
<h2 class="judul"><a href="<?= app_base_url('pf/kamus-obat/farmakologi')."?tab=$tab"?>">Master Data Farmakologi</a></h2><?= $pesan = isset($pesan)?$pesan:null; ?>
<script type="text/javascript">
$(document).ready(function() {
	//When page loads...
	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});
});
</script>
<br />
<ul class="tabs">
    <li class="<?=($tab=='tab1')?'active':''?>"><a href="#tab1">Farmakologi</a></li>
    <li class="<?=($tab=='tab2')?'active':''?>"><a href="#tab2">Sub Farmakologi</a></li>
    <li class="<?=($tab=='tab3')?'active':''?>"><a href="#tab3">Sub Sub Farmakologi</a></li>
</ul>
<div class="tab_container">
    <?php
       echo "<div id='tab1' class='tab_content ".(($tab==null)?'active':'')."'>";
         require_once 'app/actions/pf/kamus-obat/farmakologi/induk.php';
       echo '</div>';
       
       echo "<div id='tab2' class='tab_content ".(($tab==null)?'active':'')."'>";
         require_once 'app/actions/pf/kamus-obat/farmakologi/golongan.php';
       echo '</div>';
       
       echo "<div id='tab3' class='tab_content ".(($tab==null)?'active':'')."'>";
         require_once 'app/actions/pf/kamus-obat/farmakologi/sub-golongan.php';
       echo '</div>';
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.active').fadeIn();
        window.onload=cekTab();
        function cekTab(){
            $(".tab_content").hide();
            $('#<?=$tab?>').fadeIn();
        }
    })
</script>