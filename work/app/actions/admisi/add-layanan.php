  
  <fieldset class="data-input">
      <legend>Form Tambah Layanan</legend>
     
      <form name="dataform" action="<?= app_base_url('admisi/control/layanan')?>" method="POST" >
      <input type="hidden" value="add" name="add"/>    
      <label for="nama">Nama</label>
      <input type="text" name="nama" id="nama">
      <label for="spesialisasi">Spesialisasi</label>
      <input type="text" name="spesialisasi" id="spesialisasi">
      <input type="hidden" name="idSpesialisasi" id="idSpesialisasi">
      <label for="k_tariff">Kategori Tarif</label>
      <input type="text" name="k_tarif" id="k_tarif">
      <input type="hidden" name="idk_tarif" id="idk_tarif">
      <label>Bobot</label>
      <select name="kategori" id="kategori">
          <option value="Tanpa Bobot">Tanpa Bobot</option>
          <option value="Kecil">Kecil</option>
          <option value="Sedang">Sedang</option>
          <option value="Besar">Besar</option>
          <option value="Khusus">Khusus</option>
      </select>
      <label for="instalasi">Instalasi</label>
      <input type="text" name="instalasi" id="instalasi">
      <input type="hidden" name="idInstalasi" id="idInstalasi">
      <!--<input type="hidden" name="jenis" id="jenis">-->
      <label for="jenis">Jenis</label>
      <select name="jenis" id="jenis">
          <option value="">Pilih Jenis</option>
          <option value="Semua">Semua</option>
          <option value="Rawat Jalan">Rawat Jalan</option>
          <option value="Rawat Inap">Rawat Inap</option>
          <option value="OK">OK (Operation Khamr)</option>
      </select>
      <fieldset class="input-process">
          <input type="submit" name="tambah" class="tombol" value="Simpan">
          <input type="button" class="tombol" value="Batal" onClick="javascript:location.href='<?= app_base_url('admisi/data-layanan')?>'">
      </fieldset>
      </form>
  </fieldset>

