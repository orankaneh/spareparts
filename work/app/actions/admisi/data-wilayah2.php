<?php
require_once 'app/actions/admisi/pesan.php';
$sort = isset($_GET['sort'])?$_GET['sort']:NULL;  
$page = isset($_GET['page'])?$_GET['page']:1;
$tab=(isset($_GET['tab']))?$_GET['tab']:'prov';
if ($tab)
{
    $_SESSION['tab_wilayah'] = $tab;
}
if ($tab == "prov")
{
    $page_prov = $page;
    $page_kab  = 1;
    $page_kec  = 1;
    $page_kel  = 1;
} else if ($tab == "kab")
{
    $page_prov = 1;
    $page_kab  = $page;
    $page_kec  = 1;
    $page_kel  = 1;
} else if ($tab == "kec")
{
    $page_prov = 1;
    $page_kab  = 1;
    $page_kec  = $page;
    $page_kel  = 1;
} else if ($tab == "kel")
{
    $page_prov = 1;
    $page_kab  = 1;
    $page_kec  = 1;
    $page_kel  = $page;
}
?>
<h2 class="judul"><a href="<?= app_base_url('admisi/data-wilayah2')."?tab=$tab"?>">Master Data Wilayah</a></h2>
<script type="text/javascript">
$(document).ready(function() {
	//When page loads...
	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
//                $.cookie('tab',activeTab,{ expires: 7 });
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});
        
        $('#searchKab').watermark('Nama Kabupaten');
        $('#searchKec').watermark('Nama Kecamatan');
        $('#searchKel').watermark('Nama Kelurahan');
});
</script>
<br />
<ul class="tabs">
    <li class="<?=($tab=='prov')?'active':''?>"><a href="#prov">Provinsi</a></li>
    <li class="<?=($tab=='kab')?'active':''?>"><a href="#kab">Kabupaten</a></li>
    <li class="<?=($tab=='kec')?'active':''?>"><a href="#kec">Kecamatan</a></li>
    <li class="<?=($tab=='kel')?'active':''?>"><a href="#kel">Kelurahan</a></li>
</ul>
<div class="tab_container">
    <?
        echo "<div id='prov' class='tab_content ".(($tab==NULL)?'active':'')."'>";
            require_once 'app/actions/admisi/data-provinsi.php';
        echo '</div>';

        echo "<div id='kab' class='tab_content ".(($tab==NULL)?'active':'')."'>";
            require_once 'app/actions/admisi/data-kabupaten.php';
        echo '</div>';

        echo "<div id='kec' class='tab_content ".(($tab==NULL)?'active':'')."'>";
            require_once 'app/actions/admisi/data-kecamatan.php';
        echo '</div>';
        
        echo "<div id='kel' class='tab_content ".(($tab==NULL)?'active':'')."'>";
            require_once 'app/actions/admisi/data-kelurahan.php';
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