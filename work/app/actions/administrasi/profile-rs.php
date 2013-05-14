<?php
if (isset($_POST['simpan'])) {
    $gambar = "";
    if(!empty($_FILES["file_upload"]["name"])){
      $temp = $_FILES['file_upload']['tmp_name'];
      $filename = $_FILES["file_upload"]["name"];
      list($width_orig, $height_orig) = getimagesize($temp);
      $height_des = 80;
      $width_des = ($height_des*$width_orig)/$height_orig;
      $image_p = imagecreatetruecolor($width_des, $height_des);
      $image = imagecreatefromjpeg($temp);
      imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width_des, $height_des, $width_orig, $height_orig);
      if(file_exists("assets/images/logo/".$filename)){
           unlink("assets/images/logo/".$filename);
      }
      if(!empty($_POST['his']) and file_exists("assets/images/logo/".$_POST['his'])){
           unlink("assets/images/logo/".$_POST['his']);
      }
      imagejpeg($image_p,'assets/images/logo/'.$filename);
      $gambar = ",gambar='".$filename."' ";
    }
    _update("update rumah_sakit set nama='$_POST[nama]',alamat='$_POST[alamat]',
            kabupaten='$_POST[kabupaten]',telp='$_POST[telp]',
            fax='$_POST[fax]',email='$_POST[email]',web='$_POST[web]' ".$gambar." ");
    $_GET['msg']=1;
}
require_once "app/lib/common/master-data.php";
require 'app/actions/admisi/pesan.php';
$rs = profile_rumah_sakit_muat_data();
?>
<h2 class="judul">Rumah Sakit</h2>
<?=isset($pesan)?$pesan:NULL;?>
<form action="<?= app_base_url('administrasi/profile-rs') ?>" method="post" enctype="multipart/form-data">
    <div class="data-input">
        <fieldset><legend>Profil Instansi</legend>
           <div style="width: 500px; float: left">
            <label for="">Nama </label><input type="text" name="nama" class="auto" value="<?= $rs['nama'] ?>">
            <label for="">Kabupaten </label><input type="text" name="kabupaten" class="auto" value="<?= $rs['kabupaten'] ?>">
            <label for="">Alamat </label><textarea name="alamat" cols="36" rows="3"><?= $rs['alamat'] ?></textarea>
            <label for="">No. Telp </label><input type="text" name="telp" class="auto" value="<?= $rs['telp'] ?>">
            <label for="">Fax </label><input type="text" name="fax" class="auto" value="<?= $rs['fax'] ?>">
            <label for="">Email </label><input type="text" name="email" class="auto" value="<?= $rs['email'] ?>">
            <label for="">Web </label><input type="text" name="web" class="auto" value="<?= $rs['web'] ?>">
            <fieldset class="field-group">
             <label for="">Upload Logo </label><input type="file" name="file_upload" class="auto" >
             <input type="hidden" name="his" class="auto" value="<?= $rs['gambar'] ?>" >
            </fieldset>
            <fieldset class="input-process">
              <input type="submit" class="tombol" value="Simpan" name="simpan"><br/>
            </fieldset>
            </div>
            <div style="width: 300px;float: left">
            Logo Rumah sakit<br><img src="<?= app_base_url("assets/images/logo/".$rs['gambar'])?>" alt="<?= $rs['gambar'] ?>" />
            </div>
        </fieldset>
        
    </div>
</form>
