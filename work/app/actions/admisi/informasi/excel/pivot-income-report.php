<?php
        require_once "app/lib/common/functions.php";
        require_once 'app/actions/admisi/informasi/pivot-income-table.php';
        set_time_zone();
        header_excel("laporan-pivot.xls");
        $awal = isset($_GET['awal'])?date2mysql($_GET['awal']):null;
	$akhir= isset($_GET['akhir'])?date2mysql($_GET['akhir']):null;
        $content=getPivotIncomeTable($awal, $akhir, $_GET['period']);
        $title='Laporan';
        echo app_core_render(APP_APP_PATH.'/views/report.php',array(
            'content'=>$content,
            'title'=>$title,
            'excel'=>true

        ));
        
        exit;
?>