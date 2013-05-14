<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';

$jenisTransaksi = jenis_transaksi_muat_data(NULL);
?>
<h2 class="judul">Master Data Jenis Transaksi</h2>
<?
if (isset($_GET['do'])) {
    if ($_GET['do'] == 'add') {
            require_once 'app/actions/inventory/add-jenis-transaksi.php';
    }
    else if ($_GET['do'] == 'edit') {
            require_once 'app/actions/inventory/edit-jenis-transaksi.php';
    }
}
?>
<div class="data-list">
    <a href="<?= app_base_url('/inventory/jenis-transaksi/?do=add') ?>" class="add"><div class="icon button-add"></div>tambah</a><br/>
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel" style="width:430px;">
            <tr>
                <th>No</th>
                <th>Jenis Transaksi</th>
                <th>Aksi</th>
                <?
                foreach ($jenisTransaksi as $num => $row){
                ?>
                  <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                      <td align="center"><?= ++$num?></td>
                      <td class="no-wrap"><?= $row['nama']?></td>
                      <td align="center" class="aksi">
                        <a href="<?= app_base_url('inventory/jenis-transaksi/?do=edit&id='.$row['id'].'') ?>" class="edit"><small>edit</small></a>
                        <a href="<?= app_base_url('inventory/control/jenis-transaksi/?id='.$row['id'].'') ?>" class="delete"><small>delete</small></a>
                      </td>
                  </tr>
                <?
                }
                ?>
            </tr>
        </table>    
</div>    
