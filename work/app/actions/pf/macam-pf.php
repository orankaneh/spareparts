<?php
require_once 'app/lib/pf/macam-pf.php';

$macamPF = macam_pf_muat_data();

?>
<h1 class="judul">Macam Perbekalan Farmasi</h1>
<div class="data-input">
    <form action="<?= app_base_url('/pf/control/macam-pf/add') ?>" method="post">
        <fieldset>
            <legend>Form data macam perbekalan farmasi</legend>
            <input type="hidden" name="id" value="" />
            <label for="macam-pf-title">Macam PF</label>
            <input type="text" id="macam-pf-title" name="title" value="" />
            
            <fieldset class="field-group">
                <legend>Tipe</legend>&nbsp;
                <label for="macam-pf-obat" class="field-option"><input type="radio" id="macam-pf-obat" name="tipe" value="1" /> obat</label>
                <label for="macam-pf-nonobat" class="field-option"><input type="radio" id="macam-pf-nonobat" name="tipe" value="2" > non-obat</label>
            </fieldset>
            <fieldset class="input-process">
                <input type="submit" value="Simpan" class="tombol" />
            </fieldset>
        </fieldset>
    </form>
</div>
<div class="data-list">
    <table class="tabel">
        <caption>Tabel data macam perbekalan farmasi</caption>
            <tr>
                <th>No</th>
                <!--th>Kode</th-->
                <th>Macam PF</th>
                <th>Tipe</th>
                <th>Aksi</th>
            </tr>
            <? foreach ($macamPF as $num => $row): ?>
            <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ++$num ?></td>
                <!--td><?= $row['id'] ?></td-->
                <td><?= $row['title'] ?></td>
                <td><?= ($row['tipe'] == 'obat')?'Obat':'Non-obat' ?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('/pf/macam-pf/?do=edit&id='.$row['id']) ?>" class="edit"><small>edit</small></a>
                    <a href="<?= app_base_url('/pf/macam-pf/?do=delete&id='.$row['id']) ?>" class="delete">hapus</a>
                </td>
            </tr>
            <? endforeach; ?>
    </table>
</div>