<?php
$spS=array(
    array('id'=>'id','title'=>'title'),
    array('id'=>'id','title'=>'title'),
    array('id'=>'id','title'=>'title'),
    array('id'=>'id','title'=>'title')
);
$pfS=array(
    array('id'=>'id','title'=>'title'),
    array('id'=>'id','title'=>'title'),
    array('id'=>'id','title'=>'title'),
    array('id'=>'id','title'=>'title')
);
$pemesanan_pf=array(
    array('id'=>'id','nama'=>'nama','satuan'=>'satuan','kemasan'=>'kemasan','sediaan'=>'sediaan','kekuatan'=>'kekuatan','jumlah'=>'jumlah','lead_time'=>'lead time')
);
?>
<h1 class="judul">INPUT & EDIT DATA DETIL PEMESANAN NARKOTIKA</h1>
<div class="data-input">
    <form action="<?= app_base_url('/pf/inventory/manajemen_detail_narkotika') ?>" method="post">
        <fieldset>
            <legend>Input Data</legend>
            <label for="detail_narkotika-sp">No SP</label>
            <select id="detail_narkotika-sp" name="kode-sp" value="">
                <?
                    foreach ($spS as $sp){
                        echo"<option value=$sp[id]>$sp[title]</option>";
                    }
                ?>
            </select>

            <label for="detail_narkotika-pf">Kode PF</label>
            <select id="detail_narkotika-pf" name="kode-pf" value="">
                <?
                    foreach ($pfS as $pf){
                        echo"<option value=$pf[id]>$pf[title]</option>";
                    }
                ?>
            </select>

            <label for="detail_narkotika-jumlah">Jumlah </label>
            <input type="text" id="detail_narkotika-jumlah" name="jumlah" value="">

            <fieldset class="field-group">
               <label for="detail_narkotika-leadTime">Lead Time</label>
               <table cellpadding="0" cellspacing="0"><tr><td><input type="text" id="detail_narkotika-leadTime" name="leadTime" value="" size="10">
                       </td><td>&nbsp;hari</td></tr></table>
            </fieldset>

            <fieldset class="input-process">
                <input type="submit" value="Tambah" class="tombol" />
                <input type="submit" value="Batal" class="tombol" />
            </fieldset>
        </fieldset>
    </form>
</div>

<div class="data-list">
    <table class="tabel">

            <tr>
                <th>No</th>
                <th>Nama PF</th>
                <th>Satuan</th>
                <th>Kemasan</th>
                <th>Macam Sediaan</th>
                <th>Kekuatan</th>
                <th>Jumlah</th>
                <th>Lead Time</th>
                <th>Aksi</th>
            </tr>

            <? foreach ($pemesanan_pf as $num => $row): ?>
            <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ++$num ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['satuan'] ?></td>
                <td><?= $row['kemasan'] ?></td>
                <td><?= $row['sediaan'] ?></td>
                <td><?= $row['kekuatan'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['lead_time'] ?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('/pf/inventory/manajemen_detail_narkotika/?do=edit&id='.$row['id']) ?>" class="edit"><small>edit</small></a>
                </td>
            </tr>
            <? endforeach ?>

    </table>
</div>