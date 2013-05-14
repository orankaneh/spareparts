<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$title  = $_POST['title'];
$id     = $_POST['id'];

$sql = "update kemasan_pf set kemasan_pf = '$title' where id_kemasan_pf = '$id'";
$exe = mysql_query($sql);

if ($exe) {
    header("location: ".app_base_url('pf/kemasan'));
}

