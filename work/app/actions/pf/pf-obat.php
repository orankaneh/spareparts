<?php
require_once 'app/lib/pf/pf.php';
require_once 'app/lib/pf/kamus-obat.php';
require_once 'app/lib/pf/kemasan.php';
require_once 'app/lib/pf/satuan.php';
require_once 'app/lib/pf/sediaan.php';
require_once 'app/lib/pf/macam-pf.php';
require_once 'app/lib/pf/pabrik.php';

$dataPF = pf_muat_data();

$kamusObatGenerik = kamus_obat_muat_data_obat_generik();
$kamusObatBrand = kamus_obat_muat_data_obat_brand();
$kemasan = kemasan_muat_data();
$satuan = satuan_muat_data();
$sediaan = sediaan_muat_data();
$macamPF = macam_pf_muat_data('obat');
$pabrik = pabrik_muat_data();

?>
<div class="judul">Perbekalan Farmasi</div>
<div class="data-input">
    <form action="<?= app_base_url('/pf/induk') ?>" method="post">
        <fieldset>
            <legend>Form data perbekalan farmasi</legend>
            <input name="id" value="" type="hidden" />
            <label for="pf-obat-nama">Nama obat</label>
            <input type="text" id="pf-obat-nama" name="nama" value="" />
            <label for="pf-obat-macam-pf">Macam PF</label>
            <select id="pf-obat-macam-pf" name="macamPF">
                <option value="">Pilih ...</option>
                <? foreach ($macamPF as $mpf): ?>
                <option value="<?= $mpf['id'] ?>"><?= $mpf['title'] ?></option>
                <? endforeach ?>
            </select>
            <label for="pf-obat-pabrik">Nama pabrik</label>
            <select id="pf-obat-pabrik" name="pabrik">
                <option value="">Pilih...</option>
                <? foreach ($pabrik as $p): ?>
                <option value="<?= $p['id'] ?>"><?= $p['nama'] ?></option>
                <? endforeach ?>
            </select>
            <fieldset class="input-flow">
                <legend>Kamus Obat</legend>
                <fieldset class="field-group">
                    <legend>Tipe</legend>
                    <label for="pf-obat-kamus-tipe-generik" class="field-option">
                        <input type="radio" id="pf-obat-kamus-tipe-generik" name="kamusObatTipe" class="optiontoggle-trigger" value="generik" /> generik
                    </label>
                    <label for="pf-obat-kamus-tipe-brand" class="field-option">
                        <input type="radio" id="pf-obat-kamus-tipe-brand" name="kamusObatTipe" class="optiontoggle-trigger" value="brand" /> brand
                    </label>
                </fieldset>
                <fieldset class="field-group optiontoggle-item generik">
                    <label for="pf-obat-kamus-obat-generik">Kamus obat (generik)</label>
                    <select id="pf-obat-kamus-obat-generik" name="kamusObatGenerik">
                        <option value="">Pilih ...</option>
                        <? foreach ($kamusObatGenerik as $og): ?>
                        <option value="<?= $og['id'] ?>"><?= $og['nama'] ?></option>
                        <? endforeach ?>
                    </select>
                </fieldset>
                <fieldset class="field-group optiontoggle-item brand">
                    <label for="pf-obat-kamus-obat-brand">Kamus obat (brand)</label>
                    <select id="pf-obat-kamus-obat-brand" name="kamusObatBrand">
                        <option value="">Pilih ...</option>
                        <? foreach ($kamusObatBrand as $ob): ?>
                        <option value="<?= $ob['id'] ?>"><?= $ob['nama'] ?></option>
                        <? endforeach ?>
                    </select>
                </fieldset>
            </fieldset>
            <fieldset>
                <legend>Deskripsi</legend>
                <label for="pf-obat-kemasan">Kemasan</label>
                <select id="pf-obat-kemasan" name="kemasan">
                    <option value="">Pilih ...</option>
                    <? foreach ($kemasan as $km): ?>
                    <option value="<?= $km['id'] ?>"><?= $km['title'] ?></option>
                    <? endforeach ?>
                </select>
                <label for="pf-obat-satuan">Satuan</label>
                <select id="pf-obat-satuan" name="satuan">
                    <option value="">Pilih ...</option>
                    <? foreach ($satuan as $st): ?>
                    <option value="<?= $st['id'] ?>"><?= $st['kode'] ?></option>
                    <? endforeach ?>
                </select>
                <label for="pf-obat-sediaan">Macam sediaan</label>
                <select id="pf-obat-sediaan" name="sediaan">
                    <option value="">Pilih ...</option>
                    <? foreach ($sediaan as $sd): ?>
                    <option value="<?= $sd['id'] ?>"><?= $sd['title'] ?></option>
                    <? endforeach ?>
                </select>
                <label for="pf-obat-kekuatan">Kekuatan</label>
                <input type="text" id="pf-obat-kekuatan" name="kekuatan" value="" />
                <label for="pf-obat-konversi">Konversi</label>
                <input type="text" id="pf-obat-konversi" name="konversi" value="" />
            </fieldset>
            <fieldset class="input-process">
                <input type="submit" value="Simpan" class="tombol" />
                <input type="reset" value="Ulang" class="tombol" />
            </fieldset>
        </fieldset>
    </form>
</div>
<div class="data-list">
    <table class="tabel">
        <caption>Tabel data perbekalan farmasi</caption>
        
            <tr>
                <th>No</th>
                <th>Nama PF</th>
                <th>Kamus obat (generik)</th>
                <th>Kamus obat (brand)</th>
                <th>Kemasan</th>
                <th>Satuan</th>
                <th>Macam sediaan</th>
                <th>Macam PF</th>
                <th>Kekuatan</th>
                <th>Konversi</th>
                <th>Aksi</th>
            </tr>
        
            <? foreach ($dataPF as $num => $row): ?>
            <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ++$num ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['kamusObatGenerik'] ?></td>
                <td><?= $row['kamusObatBrand'] ?></td>
                <td><?= $row['kemasan'] ?></td>
                <td><?= $row['satuan'] ?></td>
                <td><?= $row['sediaan'] ?></td>
                <td><?= $row['macamPF'] ?></td>
                <td><?= $row['kekuatan'] ?></td>
                <td><?= $row['konversi'] ?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('/pf/induk/?do=edit&id='.$row['id']) ?>" class="edit"><small>edit</small></a>
                    <a href="<?= app_base_url('/pf/induk/?do=delete&id='.$row['id']) ?>" class="delete">Hapus</a>
                </td>
            </tr>
            <? endforeach ?>
       
    </table>
</div>
<script type="text/javascript">
$(function(){
    $('.input-flow').optionsToggle();
});
</script>

