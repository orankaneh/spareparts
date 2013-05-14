<?
$noFakturs=array(
    array('id'=>'id','title'=>'title'),
    array('id'=>'id','title'=>'title'),
    array('id'=>'id','title'=>'title'),
    array('id'=>'id','title'=>'title')
);
$pencocokan_table=array(
    array('nama'=>'nama','satuan'=>'satuan','kemasan'=>'kemasan', 'sediaan'=>'sediaan','kekuatan'=>'kekuatan','no_batch'=>'no_batch','tgl_kadaluarsa'=>'tgl_kadaluarsa','jumlah'=>'jumlah','harga'=>'harga','bonus'=>'bonus','diskon'=>'diskon','keterangan'=>'keterangan')
);
?>
<h1 class="judul">PENCOCOKAN FAKTUR, SP DAN PF</h1>
<div class="data-input">
        <fieldset>
            <label for="cocok_fak_sp_pf-no_faktur">No Faktur</label>
            <select id="cocok_fak_sp_pf-no_faktur" name="kode-no_faktur">
                <?
                    foreach ($noFakturs as $noFaktur){
                        echo"<option value=$noFaktur[id]>$noFaktur[title]</option>";
                    }
                ?>
            </select>

            <label for="cocok_fak_sp_pf-tgl_terima">Tanggal Penerimaan</label>
            <input type="text" id="cocok_fak_sp_pf-tgl_terima" name="tgl_terima" value="" disabled>

            <label for="cocok_fak_sp_pf-no_sp">No. SP</label>
            <input type="text" id="cocok_fak_sp_pf-no_sp" name="no_sp" value="" size="10" disabled>

            <label for="cocok_fak_sp_pf-tgl_sp">Tanggal SP</label>
            <input type="text" id="cocok_fak_sp_pf-tgl_sp" name="tgl_sp" value="" size="10" disabled>
        </fieldset>
</div>
<form action="<?= app_base_url('/pf/inventory/pencocokan_faktur_sp_pf') ?>" method="post">
<div class="data-list">
    <table class="tabel">
        
            <tr>
                <th>No</th>
                <th>Nama PF</th>
                <th>Satuan</th>
                <th>Kemasan</th>
                <th>Macam Sediaan</th>
                <th>Kekuatan</th>
                <th>No Batch</th>
                <th>Tanggal Kadaluarsa</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total Harga</th>
                <th>Bonus</th>
                <th>Diskon</th>
                <th>Kesesuaian dengan PF dan SP</th>
                <th>Keterangan</th>
            </tr>
        
        <? foreach ($pencocokan_table as $num => $row): ?>
            <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ++$num ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['satuan'] ?></td>
                <td><?= $row['kemasan'] ?></td>
                <td><?= $row['sediaan'] ?></td>
                <td><?= $row['kekuatan'] ?></td>
                <td><?= $row['no_batch']?></td>
                <td><?= $row['tgl_kadaluarsa'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['harga'] ?></td>
                <td><?= "jumlah otomatis" ?></td>
                <td><?= $row['bonus'] ?></td>
                <td><?= $row['diskon'] ?></td>
                <td><input type="radio" name="sesuai" value="0" checked>sesuai<br>
                    <input type="radio" name="sesuai" value="0">tidak sesuai<br>
                    <input type="radio" name="sesuai" value="0">jumlah kurang (diterima)<br>
                </td>
                <td><?= $row['keterangan'] ?></td>
            </tr>
            <? endforeach ?>
        
    </table>
</div>
</form>