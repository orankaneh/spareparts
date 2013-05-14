<?php
require_once 'app/lib/pf/produk-pbf.php';
$produks=  produk_muat_data();
$macamPFs= macam_pf_muat_data();
?>
<h1 class="judul">INPUT & EDIT DATA PRODUK PBF</h1>
<div class="data-input">
    <form action="<?= app_base_url('/pf/inventory/manajemen_produk') ?>" method="post">
        <fieldset>
            <legend>Input Data</legend>
            <label for="produk-kode">Kode PBF</label>
            <select id="produk-kode" name="kode-pbf" value="">
                <?
                    foreach ($produks as $produk){
                        echo"<option value=$produk[id]>$produk[title]</option>";
                    }
                ?>
            </select>
            <label for="produk-macam">Macam PF</label>
            <select id="produk-macam" name="macam-pbf" value="">
                <?
                    foreach ($macamPFs as $macamPF){
                        echo"<option value=$macamPF[id]>$macamPF[title]</option>";
                    }
                ?>
            </select>
            <fieldset class="input-process">
                <input type="submit" value="Tambah" class="tombol">
                <input type="submit" value="Batal" class="tombol">
            </fieldset>
        </fieldset>

    </form>
</div>

<div class="data-list">
    <table class="tabel">
        
            <tr>
                <th>No</th>
                <th>title</th>
                <th>title</th>
                <th>title</th>
                <th>Aksi</th>
            </tr>
        
            <tr>
                <td align="center">1</td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
                <td class="aksi">
                    <a href="<?= app_base_url('/pf/inventory/manajemen_barang/?do=edit&id='.$row['id']) ?>" class="edit"><small>edit</small></a>
                </td>
            </tr>
       
    </table>
</div>
