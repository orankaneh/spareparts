<?php
$msr = isset($_GET['msr'])?$_GET['msr']:NULL;
$msg = isset($_GET['msg'])?$_GET['msg']:NULL;
?>
<script type="text/javascript">
    $(function() {
        $('.pesan, .error').fadeOut(5000);
    })
</script>
<?php
if ($msr == 1) {
	$pesan = "<span class='error pesan'>Periksa kembali username & password Anda</span>
	";
	
}else
if ($msr == 2) {
	$pesan = "
		<span class='error pesan'>Username atau password tidak boleh kosong</span>
	";

}else
if ($msr == 3) {
	$pesan = "
		<div class='ui-widget pesan'>
		<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
		<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> 
		<strong>Alert:</strong> Proses gagal (data yang dimasukkan belum lengkap)</p>
		</div>
		</div>
	";
	
}else
if ($msr == 4) {
	$pesan = "
		<div class='ui-widget pesan'>
		<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
		<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> 
		<strong>Alert:</strong> Password lama yang anda masukkan salah</p>
		</div>
		</div>
	";
}else
if ($msr == 5) {
	$pesan = "
		<div class='ui-widget pesan'>
		<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
		<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> 
		<strong>Alert:</strong> Password baru dan password konfirmasi harus sama</p>
		</div>
		</div>
	";
}else
if ($msr == 6) {
	$pesan = "
		<div class='ui-widget pesan'>
		<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
		<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> 
		<strong>Alert:</strong> Atribut yang dilaporkan harus dipilih terlebih dahulu</p>
		</div>
		</div>
	";
}else
if ($msr == 7) {
	$pesan = "
		<div class='ui-widget pesan'>
		<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
		<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> 
		<strong>Alert:</strong> Proses gagal (data yang akan dihapus digunakan untuk transaksi lain)</p>
		</div>
		</div>
	";
	
}else if ($msr == 8) {
	$pesan = "
		<div class='ui-widget pesan'>
		<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
		<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> 
		<strong>Alert:</strong> Proses penambahan atau perubahan gagal dilakukan (kemungkinan terjadi duplikasi data)</p>
		</div>
		</div>
	";
}else if ($msr == 9) {
	$pesan = "
		<div class='ui-widget pesan'>
		<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
		<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> 
		<strong>Alert:</strong> Anda tidak berhak mengakses halaman ini</p>
		</div>
		</div>
	";
}else if($msr == 10){
	$pesan = "
		<div class='ui-widget pesan'>
		<div class='ui-state-error ui-corner-all' style=' margin-top: 10px; padding: 0 .7em;'> 
		<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> 
		<strong>Alert:</strong> Barcode barang yang dimasukkan sudah terpakai barang lain</p>
		</div>
		</div>
	";
}else if($msr == 11){
	$pesan = "
		<div class='ui-widget pesan'>
		<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
		<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> 
		<strong>Alert:</strong> Obat dengan nama, kekuatan, sediaan, dan pabrik yang sama sudah pernah diinputkan</p>
		</div>
		</div>
	";
}
else if($msr == 12){
	$pesan = "
		<div class='ui-widget pesan'>
		<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
		<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> 
		<strong>Alert:</strong> Nama/keterangan yang sama sudah pernah diinputkan</p>
		</div>
		</div>
	";
}
else if($msr == 13){
	$pesan = "
		<div class='ui-widget pesan'>
		<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'>
		<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>
		<strong>Alert:</strong> Transaksi gagal dilakukan karena data tidak lengkap !!</p>
		</div>
		</div>
	";
}
else
if ($msr == 14) {
	$pesan = "
		<div class='ui-widget pesan'>
		<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
		<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> 
		<strong>Alert:</strong> Proses gagal (data yang akan dihapus sedang digunakan di proses lain)</p>
		</div>
		</div>
	";
	
}
if ($msr == 15) {
	$pesan = "
		<div class='ui-widget'>
		<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
		<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> 
		<strong>Alert:</strong> Proses discharge gagal dilakukan</p>
		</div>
		</div>
	";
	
}
if ($msr == 16) {
	$pesan = "
		<div class='ui-widget'>
		<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
		<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> 
		<strong>Alert:</strong> Password baru yang anda masukkan sama dengan password lama anda</p>
		</div>
		</div>
	";
	
}
if ($msg == 1) {
	$pesan = "	<div class='ui-widget pesan'>
				<div class='ui-state-highlight ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
				<p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>
				<strong>Info!</strong> Proses penambahan atau perubahan data berhasil dilakukan</p>
				</div>
				</div>";
}else
if ($msg == 2) {
	$pesan = "	<div class='ui-widget pesan'>
				<div class='ui-state-highlight ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
				<p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>
				<strong>Info!</strong> Proses penghapusan data berhasil dilakukan</p>
				</div>
				</div>";
}else
if ($msg == 3) {
	$pesan = "	<div class='ui-widget pesan'>
				<div class='ui-state-highlight ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
				<p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>
				<strong>Info!</strong> Perubahan password berhasil dilakukan</p>
				</div>
				</div>";
}if ($msg == 4) {
	$pesan = "	<div class='ui-widget pesan'>
				<div class='ui-state-highlight ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
				<p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>
				<strong>Info!</strong> Proses transaksi berhasil dilakukan</p>
				</div>
				</div>";
}
if ($msg == 5) {
	$pesan = "	<div class='ui-widget pesan'>
				<div class='ui-state-highlight ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'> 
				<p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>
				<strong>Info!</strong> Proses discharge berhasil dilakukan</p>
				</div>
				</div>";
}
?>
