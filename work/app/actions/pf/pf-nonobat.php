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
$macamPF = macam_pf_muat_data('nonobat');
$pabrik = pabrik_muat_data();

?>
<div class="judul">Perbekalan Farmasi (Non obat)</div>
<div class="data-input">
    <form action="<?= app_base_url('/pf/induk') ?>" method="post">
        <fieldset>
            <legend>Form data perbekalan farmasi</legend>
            <input name="id" value="" type="hidden" />
            <label for="pf-nonobat-nama">Nama</label>
            <input type="text" id="pf-nonobat-nama" name="nama" value="" />
            <label for="pf-nonobat-macam-pf">Macam PF</label>
            <select id="pf-nonobat-macam-pf" name="macamPF">
                <option value="">Pilih ...</option>
                <? foreach ($macamPF as $mpf): ?>
                <option value="<?= $mpf['id'] ?>"><?= $mpf['title'] ?></option>
                <? endforeach ?>
            </select>
            <label for="pf-nonobat-pabrik">Nama pabrik</label>
            <select id="pf-nonobat-pabrik" name="pabrik">
                <option value="">Pilih...</option>
                <? foreach ($pabrik as $p): ?>
                <option value="<?= $p['id'] ?>"><?= $p['nama'] ?></option>
                <? endforeach ?>
            </select>
            <fieldset>
                <legend>Deskripsi</legend>
                <label for="pf-nonobat-kemasan">Kemasan</label>
                <select id="pf-nonobat-kemasan" name="kemasan">
                    <option value="">Pilih ...</option>
                    <? foreach ($kemasan as $km): ?>
                    <option value="<?= $km['id'] ?>"><?= $km['title'] ?></option>
                    <? endforeach ?>
                </select>
                <label for="pf-nonobat-satuan">Satuan</label>
                <select id="pf-nonobat-satuan" name="satuan">
                    <option value="">Pilih ...</option>
                    <? foreach ($satuan as $st): ?>
                    <option value="<?= $st['id'] ?>"><?= $st['kode'] ?></option>
                    <? endforeach ?>
                </select>
                <label for="pf-nonobat-sediaan">Macam sediaan</label>
                <select id="pf-nonobat-sediaan" name="sediaan">
                    <option value="">Pilih ...</option>
                    <? foreach ($sediaan as $sd): ?>
                    <option value="<?= $sd['id'] ?>"><?= $sd['title'] ?></option>
                    <? endforeach ?>
                </select>
                <label for="pf-nonobat-konversi">Konversi</label>
                <input type="text" id="pf-nonobat-konversi" name="konversi" value="" />
                <label for="pf-nonobat-spesifikasi">Spesifikasi</label>
                <input type="text" id="pf-nonobat-spesifikasi" name="spesifikasi" value="" />
            </fieldset>
            <fieldset class="input-process">
                <input type="submit" value="Simpan" />
                <input type="reset" value="Ulang" />
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