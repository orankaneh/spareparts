<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset ($_GET['id'])){
?>
  <h2 class="judul">Master Data Wilayah</h2>
<?
  delete_list_data($_GET['id'], 'kelurahan', 'admisi/data-wilayah2?msg=2',null,NULL,null,'kel');
}
?>
