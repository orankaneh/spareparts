<?
$raks=array(
    array('id'=>'id','suhu'=>'suhu','keterangan'=>'keterangan')
);
?>
<form action="<?= app_base_url('/pf/inventory/manajemen_rak') ?>" method="post">
    <h1 class="judul">Manajemen Rak</h1>
    <div class="data-input">
            <fieldset>
                <label for="manajemen_rak-kode_rak">Kode Rak</label>
                <input type="text" name="kode_rak" id="manajemen_rak-kode_rak">

                <label for="manajemen_rak-suhu_simpan">Suhu Penyimpanan</label>
                <select name="suhu" id="manjemen_rak-suhu">
                    <option value="">0 C </option>
                    <option value="">0 C-2 C</option>
                    <option value="">2 C-8 C </option>
                    <option value="">8 C-25 C </option>
                    <option value="">diatas 25 C </option>
                </select>

                <label for="manajemen_rak-keterangan">Keterangan</label>
                <input type="text" id="manajemen_rak-keterangan" name="keterangan" value="">

                <fieldset class="input-process">
                    <input type="Submit" name="simpan_btn" value="Simpan" class="tombol">
                    <input type="button" name="simpan_btn" value="Batal" class="tombol">
                </fieldset>
            </fieldset>
    </div>
</form>

<div class="data-list">
    <table class="tabel">
       
            <tr>
                <th>No</th>
                <th>Kode Rak</th>
                <th>Suhu</th>
                <th>Keterangan</th>
            </tr>
       
        <? foreach ($raks as $num => $row): ?>
            <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ++$num ?></td>
                <td><?= $row['id'] ?></td>
                <td><?= $row['suhu'] ?></td>
                <td><?= $row['keterangan'] ?></td>
            </tr>
            <? endforeach ?>
       
    </table>
</div>