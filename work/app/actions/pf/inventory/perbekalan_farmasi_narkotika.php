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

?>
<h1 class="judul">PENGADAAN PERBEKALAN FARMASI NARKOTIKA</h1>
<div class="data-input">
    <form action="<?= app_base_url('/pf/inventory/perbekalan_farmasi_narkotika') ?>" method="post">
        <fieldset>
            <legend>Surat Pemesanan</legend>
            <label for="perbekalan-noSp">No SP</label>
            <select id="perbekalan-noSp" name="noSp" value="">
                <?
                    foreach ($spS as $sp){
                        echo"<option value=$sp[id]>$sp[title]</option>";
                    }
                ?>
            </select>
            <label for="perbekalan-pbf">Nama PBF</label>
            <select id="perbekalan-pbf" name="pf" value="">
                <?
                    foreach ($pfS as $pf){
                        echo"<option value=$pf[id]>$pf[title]</option>";
                    }
                ?>
            </select>
            <fieldset class="input-process">
                <input type="submit" value="Simpan" class="tombol">
                <input type="submit" value="Batal" class="tombol">
            </fieldset>
        </fieldset>

    </form>
</div>
