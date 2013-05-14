<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$title = $_POST['title'];

$sql = "insert into kemasan_pf values ('','$title')";
$exe = mysql_query($sql);

if ($exe) {
    header("location: ".app_base_url('pf/kemasan'));
}
