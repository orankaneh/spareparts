<html>
    <head>
        <title><?=$title?></title>
        <?if(empty($excel)){?>
            <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css') ?>" media="all" />
            <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tabel.css') ?>" media="screen" />
            <link rel='stylesheet' href='<?=app_base_url('assets/js/sorter/style.css')?>' />
            <script type="text/javascript" src="<?= app_base_url('/assets/js/jquery-1.4.2.min.js') ?>"></script>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('a').attr('href','#');
                })
            </script>
        <?}else{
            require_once "app/lib/common/functions.php";
            include_css_excel_report();
        }?>
    </head>
    <body>
        <?=$content?>
    </body>
</html>

<?php
exit;
?>
