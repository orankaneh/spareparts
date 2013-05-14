<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$title = $_POST['title'];
$tipe  = $_POST['tipe'];

$sql = "insert into macam_pf values ('','$title','$tipe')";

$exe = mysql_query($sql);
if ($exe) {
    header("location: ".app_base_url('pf/macam-pf')."");
}
