<?php
require_once "app/lib/common/functions.php";
set_time_zone();
include_css_excel_report();
header_excel("laporan-pivot.xls");

include_once "app/actions/admisi/informasi/per-pivot-return.php";
exit;
