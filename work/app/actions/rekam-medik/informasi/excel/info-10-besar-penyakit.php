<?php
set_time_zone();
include_css_excel_report();
header_excel("10-besar-penyakit.xls");

include_once "app/actions/rekam-medik/informasi/info-10-besar-penyakit-return.php";
exit;
