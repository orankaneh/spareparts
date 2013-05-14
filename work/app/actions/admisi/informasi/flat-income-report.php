<?php
        require_once "app/lib/common/functions.php";
        require_once 'app/actions/admisi/informasi/flat-income-table.php';
        $awal = date2mysql($_GET['awal']);
	$akhir= date2mysql($_GET['akhir']);
        $content=getFlatIncomeTable($awal,$akhir);
        echo app_core_render(APP_APP_PATH.'/views/report.php',array(
            'content'=>$content,
            'title'=>'Laporan Flat'
        ));
        exit;
?>
