<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';

$unit = unit_muat_data();
?>
<h2 class="judul">Master Data Unit</h2><?= isset($pesan)?$pesan:NULL?>
<?
if (isset($_GET['do']) && $_GET['do'] == "add") {
    require_once 'app/actions/admisi/add-unit.php';
}
?>
<div class="data-list">
    <a href="<?= app_base_url('/admisi/data-unit/?do=add') ?>" class="add"><div class="icon button-add"></div>tambah</a><br/>
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel" style="width:430px;">
            <tr>
                <th>No</th>
                <th>Nama Unit</th>
                <?
                foreach ($unit as $key => $row){
                ?>
                  <tr class="<?= ($key%2) ? 'even' : 'odd' ?>">
                      <td align="center"><?= ++$key?></td>
                      <td class="no-wrap"><?= $row['nama']?></td>
                  </tr>
                <?
                }
                ?>
            </tr>    
        </table>
</div>    