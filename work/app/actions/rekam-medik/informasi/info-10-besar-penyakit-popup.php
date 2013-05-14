<?php
require_once "app/lib/common/functions.php";
set_time_zone();
?>
<html>
    <head>
        <title>Laporan</title>
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css') ?>" media="all" />
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tabel.css') ?>" media="screen" />
        <script type="text/javascript" src="<?= app_base_url('/assets/js/jquery-1.4.2.min.js') ?>"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('a').attr('href','#');
                $(document).removeData('input');
            })
        </script>
    </head>
    <body>
        <?include_once "app/actions/rekam-medik/informasi/info-10-besar-penyakit-return.php";?>
    </body>
</html>

<?php
exit;