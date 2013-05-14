<?php
require_once 'app/lib/admisi/admisi-models.php';
$new_number= create_medical_record_number();
$new_number=$new_number['new_number'];
if ($new_number == NULL) {
    $new_number = 1;
}
$length=strlen($new_number);
for($i=$length;$i<8;$i++){
    $new_number='0'.$new_number;
}
echo ''."$new_number";
exit;

?>
