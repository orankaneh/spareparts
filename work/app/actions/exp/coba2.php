<?php
//include 'app/lib/common/functions.php';
//echo date('d M Y h:m:s');
echo "1 ".app_request_get_base_path().'<br/>';
echo "2 ".app_request_get_base_url().'<br/>';
echo "3 ".app_request_get_http_host().'<br/>';
echo "4 ".app_request_get_method().'<br/>';
echo "5 ".app_request_get_path_info().'<br/>';
echo "6 ".app_request_get_raw_body().'<br/>';
echo "7 ".app_request_get_request_uri().'<br/>';
echo "8 ".app_request_get_scheme().'<br/>';

print_r(get_url_parameter($_GET));
?>
