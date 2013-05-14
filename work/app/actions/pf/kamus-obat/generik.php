<?php
require_once 'app/lib/pf/kamus-obat.php';
require_once 'app/lib/pf/farmakologi.php';

$kamusObatGenerik = kamus_obat_muat_data_obat_generik();

$dataVEN = kamus_obat_muat_data_ven();
$dataUU = kamus_obat_muat_data_uu();

$farmakologi = farmakologi_muat_data_farmakologi();
$farmakologiGolongan = farmakologi_muat_data_golongan();
$farmakologiSubgolongan = farmakologi_muat_data_subgolongan();

?>
<div class="judul">Kamus obat (generik)</div>
<div class="data-input">
    <form action="<?= app_base_url('/pf/kamus-obat/generik') ?>" method="post">
        <fieldset>
            <legend>Form kamus obat (generik)</legend>
            <input type="hidden" name="id" value="" />
            <label for="kamus-obat-generik-nama">Nama obat generik</label>
            <input type="text" id="kamus-obat-generik-nama" name="nama" value="" />
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
                <label for="kamus-obat-generik-farmakologi">Farmakologi</label>
                <select id="kamus-obat-generik-farmakologi" name="farmakolgi">
                    <option value="">Pilih...</option>
                    <? foreach ($farmakologi as $f): ?>
                    <option value="<?= $f['id'] ?>"><?= $f['nama'] ?></option>
                    <? endforeach ?>
                </select>
                <label for="kamus-obat-generik-golongan">Golongan</label>
                <select id="kamus-obat-generik-golongan" name="golongan">
                    <option value="">Pilih...</option>
                    <? foreach ($farmakologiGolongan as $g): ?>
                    <option value="<?= $g['id'] ?>"><?= $g['nama'] ?></option>
                    <? endforeach ?>
                </select>
                <label for="kamus-obat-generik-subgolongan">Sub-golongan</label>
                <select id="kamus-obat-generik-subgolongan" name="subgolongan">
                    <option value="">Pilih...</option>
                    <? foreach ($farmakologiSubgolongan as $s): ?>
                    <option value="<?= $s['id'] ?>"><?= $s['nama'] ?></option>
                    <? endforeach ?>
                </select>
            </fieldset>
            <fieldset>
                <legend>V.E.N</legend>
                <label for="kamus-obat-generik-ven">Penggolongan V.E.N</label>
                <select id="kamus-obat-generik-ven" name="ven">
                    <option value="">Pilih...</option>
                    <? foreach ($dataVEN as $ven): ?>
                    <option value="<?= $ven['id'] ?>"><?= $ven['label'] ?></option>
                    <? endforeach ?>
                </select>
            </fieldset>
            <fieldset>
                <legend>Undang-undang</legend>
                <label for="kamus-obat-generik-uu">Penggolongan UU</label>
                <select id="kamus-obat-generik-uu" name="uu">
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
        <caption>Table data kamus obat (generik)</caption>
        
            <tr>
                <th>No</th>
                <th>Nama obat (generik)</th>
                <th>Farmakologi</th>
                <th>Golongan</th>
                <th>Sub-golongan</th>
                <th>Penggolongan V.E.N</th>
                <th>Penggolongan UU</th>
                <th>Aksi</th>
            </tr>
        
            <? foreach ($kamusObatGenerik as $num => $row): ?>
            <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ++$num ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['farmakologi'] ?></td>
                <td><?= $row['golongan'] ?></td>
                <td><?= $row['subgolongan'] ?></td>
                <td><?= $row['ven'] ?></td>
                <td><?= $row['uu'] ?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('/pf/kamus-obat/generik/?do=edit&id='.$row['id']) ?>" class="edit"><small>edit</small></a>
                    <a href="<?= app_base_url('/pf/kamus-obat/generik/?do=delete&id='.$row['id']) ?>" class="delete">hapus</a>
                </td>
            </tr>
            <? endforeach ?>
        
    </table>
</div>
