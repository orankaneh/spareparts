<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h1 class="judul">Macam Kemasan</h1>
<?
require_once 'app/lib/common/functions.php';

delete_list_data($_GET['id'], 'pf/kemasan?msg=2', 'pf/kemasan?msr=7');
