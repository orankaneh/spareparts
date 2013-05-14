<?php
require_once 'app/lib/pf/kamus-obat.php';
require_once 'app/lib/pf/farmakologi.php';

$kamusObatBrand = kamus_obat_muat_data_obat_brand();

$kamusObatGenerik = kamus_obat_muat_data_obat_generik();
$dataVEN = kamus_obat_muat_data_ven();
$dataUU = kamus_obat_muat_data_uu();

$farmakologi = farmakologi_muat_data_farmakologi();
$farmakologiGolongan = farmakologi_muat_data_golongan();
$farmakologiSubgolongan = farmakologi_muat_data_subgolongan();

?>
<div class="judul">Kamus obat (brand)</div>
<div class="data-input">
    <form action="<?= app_base_url('/pf/kamus-obat/brand') ?>" method="post">
        <fieldset>
            <legend>Form kamus obat (brand)</legend>
            <input type="hidden" name="id" value="" />
            <label for="kamus-obat-brand-nama" class="field-title">Nama brand</label>
            <input type="text" id="kamus-obat-brand-nama" name="nama" value="" />
            <label for="kamus-obat-brand-generik" class="field-title">Nama generik</label>
            <select id="kamus-obat-brand-generik" name="generik[]" multiple="multiple">
                <? foreach ($kamusObatGenerik as $g): ?>
                <option value="<?= $g['id'] ?>"><?= $g['nama'] ?></option>
                <? endforeach ?>
            </select>
            <fieldset class="field-group">
                <legend>Formularium</legend>
                <label class="field-option">
                    <input id="kamus-obat-formularium" type="radio" name="formularium" value="1" /> formularium
                </label>
                <label class="field-option">
                    <input id="kamus-obat-nonformularium" type="radio" name="formularium" value="0" /> non formularium
                </label>
            </fieldset>
            <fieldset>
                <legend>Farmakologi</legend>
                <label for="kamus-obat-brand-farmakologi" class="field-title">Farmakologi</label>
                <select id="kamus-obat-brand-farmakologi" name="farmakolgi">
                    <option value="">Pilih...</option>
                    <? foreach ($farmakologi as $f): ?>
                    <option value="<?= $f['id'] ?>"><?= $f['nama'] ?></option>
                    <? endforeach ?>
                </select>
                <label for="kamus-obat-brand-golongan" class="field-title">Golongan</label>
                <select id="kamus-obat-brand-golongan" name="golongan">
                    <option value="">Pilih...</option>
                    <? foreach ($farmakologiGolongan as $g): ?>
                    <option value="<?= $g['id'] ?>"><?= $g['nama'] ?></option>
                    <? endforeach ?>
                </select>
                <label for="kamus-obat-brand-subgolongan" class="field-title">Sub-golongan</label>
                <select id="kamus-obat-brand-subgolongan" name="subgolongan">
                    <option value="">Pilih...</option>
                    <? foreach ($farmakologiSubgolongan as $s): ?>
                    <option value="<?= $s['id'] ?>"><?= $s['nama'] ?></option>
                    <? endforeach ?>
                </select>
            </fieldset>
            <fieldset>
                <legend>V.E.N</legend>
                <label for="kamus-obat-brand-ven" class="field-title">Penggolongan V.E.N</label>
                <select id="kamus-obat-brand-ven" name="ven">
                    <option value="">Pilih...</option>
                    <? foreach ($dataVEN as $ven): ?>
                    <option value="<?= $ven['id'] ?>"><?= $ven['label'] ?></option>
                    <? endforeach ?>
                </select>
            </fieldset>
            <fieldset>
                <legend>Undang-undang</legend>
                <label for="kamus-obat-brand-uu" class="field-title">Penggolongan UU</label>
                <select id="kamus-obat-brand-uu" name="uu">
                    <option value="">Pilih...</option>
                    <? foreach ($dataUU as $uu): ?>
                    <option value="<?= $uu['id'] ?>"><?= $uu['label'] ?></option>
                    <? endforeach ?>
                </select>
            </fieldset>
            <fieldset class="input-process">
                <input type="submit" value="Simpan" />
            </fieldset>
        </fieldset>
    </form>
</div>
<div class="data-list">
    <table class="tabel">
        <caption>Table data kamus obat (brand)</caption>
        
            <tr>
                <th>No</th>
                <th>Nama brand</th>
                <th>Nama generik</th>
                <th>Farmakologi</th>
                <th>Golongan</th>
                <th>Sub-golongan</th>
                <th>Penggolongan V.E.N</th>
                <th>Penggolongan UU</th>
                <th>Aksi</th>
            </tr>
        
            <? foreach ($kamusObatBrand as $num => $row): ?>
            <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ++$num ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['generik'] ?></td>
                <td><?= $row['farmakologi'] ?></td>
                <td><?= $row['golongan'] ?></td>
                <td><?= $row['subgolongan'] ?></td>
                <td><?= $row['ven'] ?></td>
                <td><?= $row['uu'] ?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('/pf/kamus-obat/brand/?do=edit&id='.$row['id']) ?>" class="edit"><small>edit</small></a>
                    <a href="<?= app_base_url('/pf/kamus-obat/brand/?do=delete&id='.$row['id']) ?>" class="delete">hapus</a>
                </td>
            </tr>
            <? endforeach ?>
        
    </table>
</div>
<script type="text/javascript">
(function($){$(document).ready(function(){
    $('#kamus-obat-brand-generik').partsSelector({enableMoveControls:false});
});})(jQuery);
</script>