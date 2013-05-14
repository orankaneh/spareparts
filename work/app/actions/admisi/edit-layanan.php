<?php
$id = $_GET['id'];
$layanans = layanan_muat_data($id);
foreach ($layanans as $rows);
?>
<fieldset class="data-input">
    <legend>Form Edit Layanan</legend>
      <form name="dataform" action="<?= app_base_url('admisi/control/layanan')?>" method="POST" onsubmit="return checkdata(this)">
      <label for="nama">Nama</label>
      <input type="hidden" value="edit" name="edit"/> 
      <input type="text" name="nama" id="nama" value="<?= $rows['nama']?>">
      <label for="spesialisasi">Spesialisasi</label>
      <input type="text" name="spesialisasi" id="spesialisasi" value="<?= $rows['profesi']." ".$rows['spesialisasi']?>">
      <input type="hidden" name="idSpesialisasi" id="idSpesialisasi" value="<?= $rows['id_spesialisasi']?>">
      <label for="k_tariff">Kategori Tarif</label>
      <input type="text" name="k_tarif" id="k_tarif" value="<?= $rows['nama_ktarif']?>">
      <input type="hidden" name="idk_tarif" id="idk_tarif" value="<?= $rows['id_kategori_tarif']?>">
      <label>Bobot</label>
      <select name="kategori">
          <option value="">Pilih bobot</option>
          <option value="Tanpa Bobot" <? if($rows['bobot'] == "Tanpa Bobot") echo "selected";?>>Tanpa Bobot</option>
          <option value="Kecil" <? if($rows['bobot'] == "Kecil") echo "selected";?>>Kecil</option>
          <option value="Sedang" <? if($rows['bobot'] == "Sedang") echo "selected";?>>Sedang</option>
          <option value="Besar" <? if($rows['bobot'] == "Besar") echo "selected";?>>Besar</option>
          <option value="Khusus" <? if($rows['bobot'] == "Khusus") echo "selected";?>>Khusus</option>
      </select>
      <label for="instalasi">Instalasi</label>
      <input type="text" name="instalasi" id="instalasi" value="<?= $rows['instalasi'];?>">
      <input type="hidden" name="idInstalasi" id="idInstalasi" value="<?= $rows['id_instalasi']?>">
      <label for="jenis">Jenis</label>
      <select name="jenis">
          
          <option value="">Pilih Jenis</option>
          <option value="Semua" <? if($rows['jenis'] == "Semua") echo "selected";?>>Semua</option>
          <option value="Rawat Jalan" <? if($rows['jenis'] == "Rawat Jalan") echo "selected";?>>Rawat Jalan</option>
          <option value="Rawat Inap" <? if($rows['jenis'] == "Rawat Inap") echo "selected";?>>Rawat Inap</option>
      </select>
      <!--<input type="hidden" name="jenis" id="jenis" value="= $rows['jenis']?>">-->
      <input type="hidden" name="idLayanan" id="idLayanan" value="<?= $rows['id']?>">
      <fieldset class="input-process">
          <input type="submit" name="ubah" class="tombol" value="Simpan">
          <input type="button" class="tombol" value="Batal" onClick="javascript:location.href='<?= app_base_url('admisi/data-layanan')?>'">
      </fieldset>
      </form>
  </fieldset>