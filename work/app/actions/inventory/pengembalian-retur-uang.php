<h2 class="judul">Pengembalian Retur Uang</h2>
<div class="data-input">
    <fieldset><legend>Form Pengembalian Retur Uang</legend>
    <label for="no-surat-retur">No Surat Retur</label><input type="text" name="noretur" id="no-surat-retur" />
    <label for="no-faktur">No Faktur</label><input type="text" name="nofaktur" id="no-faktur" />
    <label for="awal">Tanggal</label><input type="text" name="tanggal" id="awal" />
    <label for="petugas">Petugas</label><span>Slamet Riadi</span>
    </fieldset>
</div>
<div class="data-list">
    <table class="table-input" style="width: 60%">
        <tr>
            <th>No</th>
            <th>Barang</th>
            <th>Jml Retur</th>
            <th>Alasan</th>
            <th>Harga Beli</th>
            <th>Pengembalian</th>
        </tr>
<?php for($i=1; $i<=5;$i++) {?>
        <tr class="<?= ($i%2)?'even':'odd'?>">
            <td align="center"><?= $i ?></td>
            <td>Barang <?= $i ?></td>
            <td align="center">10</td>
            <td align="center">xx...</td>
            <td align="center">Rp. 150.000,00</td>
            <td align="center">
                <input type="text" name="pengembalian" />
            </td>
        </tr>
<?php } ?>
    </table><br/>
    <input class="tombol" type="submit" value="Simpan" /> <input class="tombol" type="submit" value="Simpan & Baru" /> <input onClick="javascript:location.href='<?= app_base_url('inventory/surat-retur') ?>'" class="tombol" type="button" value="Batal" />
</div>