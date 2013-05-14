<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
include 'app/actions/admisi/pesan.php';

$charity = charity_muat_data(NULL,isset($_GET['sort'])?$_GET['sort']:NULL);
?>
<h2 class="judul">Master Data Charity</h2><? echo isset($pesan)?$pesan:NULL; ?>
<div class="data-input">
<?php
if (isset($_GET['id'])) {
$charity_id = charity_muat_data(isset($_GET['id']) ? $_GET['id']:null);
foreach($charity_id as $row);
?>
<fieldset><legend>Form Edit Data Charity</legend>
    <form action="<?= app_base_url('admisi/control/charity') ?>" method="post">
        <label for="jenis-charity">Jenis Charity</label><input type="text" name="jenisCharity" value="<?= $row['jenis_charity'] ?>" />
        <input type="hidden" name="id_charity" value="<?= $row['id_jenis_charity'] ?>" />
        <fieldset class="input-process">
        <input type="submit" name="edit" value="Simpan" class="tombol" /> <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/data-charity/') ?>'" />
        </fieldset>
    </form>
</fieldset>
<?php }
else if (isset($_GET['do'])) {
?>
<fieldset><legend>Form Tambah Data Charity</legend>
    <form action="<?= app_base_url('admisi/control/charity') ?>" method="post">
        <label for="jenis-charity">Jenis Charity</label><input type="text" name="jenisCharity" value=""/>
        <fieldset class="input-process">
        <input type="submit" name="add" value="Simpan" class="tombol" /> <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/data-charity/') ?>'" />
        </fieldset>
    </form>
</fieldset>
<?php } ?>
    </div>
<div class="data-list">
    <a href="<?= app_base_url('/admisi/data-charity/?do=add') ?>" class="add"><div class="icon button-add"></div>tambah</a>
<table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel" style="width:35%">

    <tr>
    <th>No</th>
    <th style="width:70px"><a href="<?= app_base_url('/admisi/data-charity') ?>?sort=1" class="sorting">Nama Charity</a></th>
    <th>Aksi</th>
    </tr>

    <? foreach($charity as $num => $row): ?>
    <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
    <td align=center><?= ++$num ?></td>
    <td class="no-wrap"><?= $row['jenis_charity'] ?></td>
    <td align=center class="aksi">
    <a href="<?= app_base_url('/admisi/data-charity/?do=edit&id='.$row['id_jenis_charity']) ?>" class="edit"><small>edit</small></a>
    <a href="<?= app_base_url('/admisi/control/charity?id='.$row['id_jenis_charity']) ?>" class="delete"><small>delete</small></a>
    </td>
    </tr>
    <? endforeach ?>

</table>
</div>