<?php
require_once 'app/lib/pf/kemasan.php';
require_once 'app/actions/admisi/pesan.php';

$kemasan = kemasan_muat_data();
$kemasan_id = kemasan_muat_data_by_id($_GET['id']);

?>
<h1 class="judul">Macam Kemasan</h1><?= isset ($pesan)?$pesan:NULL?>
<?
if ($_GET['do'] == 'edit') {
?>
<div class="data-input">
    <form action="<?= app_base_url('/pf/control/kemasan/edit') ?>" method="post">
        <? foreach($kemasan_id as $row): ?>
        <fieldset>
            <legend>Form edit data macam kemasan</legend>
            <input type="hidden" name="id" value="<?= $row['id_kemasan_pf'] ?>" />
            <label for="kemasan-title">Macam Kemasan</label>
            <input type="text" id="kemasan-title" name="title" value="<?= $row['kemasan_pf'] ?>" />
            <fieldset class="input-process">
                <input type="submit" value="Ubah" class="tombol" />
                <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?= app_base_url('pf/kemasan') ?>'"/>
            </fieldset>
        </fieldset>
        <? endforeach; ?>
    </form>
</div>
<? } else { ?>
<div class="data-input">
    <form action="<?= app_base_url('/pf/control/kemasan/add') ?>" method="post">
        <fieldset>
            <legend>Form data input macam kemasan</legend>
            <input type="hidden" name="id" value="" />
            <label for="kemasan-title">Macam Kemasan</label>
            <input type="text" id="kemasan-title" name="title" value="" />
            <fieldset class="input-process">
                <input type="submit" value="Simpan" class="tombol" />
                <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?= app_base_url('pf/kemasan') ?>'"/>
            </fieldset>
        </fieldset>
    </form>
</div>
<? } ?>
<div class="data-list">
    <table class="tabel">
        <caption>Tabel data macam kemasan</caption>
            <tr>
                <th>No</th>
                <!--th>Kode</th-->
                <th>Macam Kemasan</th>
                <th>Aksi</th>
            </tr>

            <? foreach ($kemasan as $num => $row): ?>
            <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ++$num ?></td>
                <!--td><?= $row['id'] ?></td-->
                <td><?= $row['kemasan_pf'] ?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('/pf/kemasan/?do=edit&id='.$row['id_kemasan_pf']) ?>" class="edit"><small>edit</small></a>
                    <a href="<?= app_base_url('/pf/control/kemasan/delete/?id='.$row['id_kemasan_pf']) ?>" class="delete">Hapus</a>
                </td>
            </tr>
            <? endforeach; ?>
    </table>
</div>