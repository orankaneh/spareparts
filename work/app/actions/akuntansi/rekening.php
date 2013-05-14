<script type="text/javascript">
	function showFormAddRekening(){
		contentloader('<?= app_base_url('/akuntansi/rekening?section=tambahrekening')?>','#admission');
		contentloader('<?= app_base_url('/akuntansi/rekening?section=tabelrekening')?>','#content');
	}
	function searchRekening() {
		contentloader('<?= app_base_url('/akuntansi/rekening?section=tabelrekening');?>&key='+$("#keysearch").val(),'#content');
	}
	function simpanRekening(formid) {
		if($('#kategori').attr('value')=='') {
			caution('Kategori rekening tidak boleh kosong');
		} else if($('#kode').attr('value')=='') {
			caution('Kode rekening tidak boleh kosong');
		} else if($('#nama').attr('value')=='') {
			caution('Nama rekening tidak boleh kosong');
		} else {
			progressAdd(formid);
			contentloader('<?= app_base_url('/akuntansi/rekening?section=tabelrekening')?>','#content');
			$('#admission').html('');
		}
	}
	
	function changeKategoriOnKode(kode) {
		result=kode.split('.');
		$('#prekode').val(result[1]);
    }
    
    function showFormAddKategoriRekening() {
		contentloader('<?= app_base_url('/akuntansi/rekening?section=tambahkategorirekeninglite')?>','#boxkategori');
		$('#batal_utama,#simpan_utama').hide();
    }
	
	function cancelAddKategoriRekening() {
		contentloader('<?= app_base_url('/akuntansi/rekening?section=selectrekening')?>','#boxkategori');
	    $('#batal_utama,#simpan_utama').show();
    }
	
	function simpanLangsungKategori(formid) {
	if ($('#kode_kategori').attr('value')=='') {
		caution('Kode kategori rekening tidak boleh kosong');
	} else if ($('#nama_kategori').attr('value')=='') {
		caution('Nama kategori rekening tidak boleh kosong');
    } else {
		progressAdd(formid);
		contentloader('<?= app_base_url('/akuntansi/rekening?section=selectrekening')?>','#boxkategori');
    }
	}
	
	function editRekening(id,kode,nama,status) {
		contentloader('<?= app_base_url('/akuntansi/rekening?section=tambahrekening')?>&id='+id+'&nama='+nama+'&kode='+kode+'&status='+status,'#admission');
	}
	
	
	// -- Kategori Rekening --//
	
	function showAddKategoriRekening() {
		contentloader('<?= app_base_url('/akuntansi/rekening?section=addkategorirekening')?>','#admission');
		contentloader('<?= app_base_url('/akuntansi/rekening?section=tabelkategorirekening')?>','#content');
	}
	
	function cancelForm() {
	    $("#form-kategorirekening").html('');
	}
	
	function addNewKategori(formid) {
	if($('#kode_kategori').attr('value')=='') {
	    $('#box-notif').addClass('alert').html('<b>Kode Kategori</b> tidak boleh kosong').show();
	    setTimeout("$('#box-notif').fadeOut(1200);", 1000); 
	} else if($('#nama_kategori').attr('value')=='') {
	    $('#box-notif').addClass('alert').html('<b>Nama Kategori</b> tidak boleh kosong').show();
	    setTimeout("$('#box-notif').fadeOut(1200);", 1000); 
	} else {
	    progressAdd(formid);
		$("#admission").html('');
	    contentloader('<?= app_base_url('/akuntansi/rekening?section=tabelkategorirekening')?>','#content');
	}
    }
</script>

<?

if (isset($_GET['section'])) {
    
switch($_GET['section']) {

// ----------------------------- Rekening ------------------------------------//

	
	//Tabel Rekening
	
	case "tabelrekening":
	
	require_once 'app/lib/common/master-akuntansi.php';
	
	$page = isset($_GET['page']) ? $_GET['page'] : NULL;
	$urut = isset($_GET['urut']) ? $_GET['urut'] : NULL;
	$id   = isset($_GET['code'])?$_GET['code']:NULL;
	$key = isset($_GET['key'])?$_GET['key']:NULL;
	
	$dataRekening = data_rekening($id, $page, $dataPerPage = 8, $urut,$key);

	
	if (count($dataRekening)==0) {  
	    echo notifikasi("Data rekening belum tersedia");   
	} else { ?>
   
    <table class="tabel full">
        <tr>
            <th colspan=2>Kode</th>
            <th>Nama</th>
			<th>Tipe</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($dataRekening as $kat): ?>
	<tr>
	    <td colspan=5><?php echo $kat['kode']." ".$kat['nama']; ?></td>
	</tr>
	
	<?php
	if (isset($kat['datarekening']) and count($kat['datarekening'])!=0) {
	foreach ($kat['datarekening'] as $row): ?>
        <tr id="<?php echo $row['id_rekening'] ?>">
			<td></td>
            <td><?php echo $row['kode_rekening'] ?></td>
            <td><?php echo $row['nama_rekening'] ?></td>
	    <td><?php
	     if ($row['status']=="1") echo "Debit";
	     else echo "Kredit"; ?></td>
            <td class="aksi">
                <a href="#" title="Edit" class="edit" onclick="editRekening('<?php echo $row['id_rekening'] ?>','<?php echo $row['kode_rekening'] ?>','<?php echo $row['nama_rekening'] ?>','<?php echo $row['status'] ?>')">Edit</a>
                <a href="#" title="Hapus" class="delete" onClick="showFormConfirm('Apakah Anda ingin menghapus Rekening tersebut?','<?= app_base_url('akuntansi/control/rekening?section=deleteRekening'); ?>','<?=$row['id_rekening']; ?>')">Delete</a>
            </td>
            </tr>
        <?php endforeach;
	} ?>
	<?php endforeach; ?>
    </table>
	
	<?php
	}
	exit();
	break;
	
	//Tambah Rekening
	
	case "tambahrekening":
	
	$id = isset($_GET['id']) ? $_GET['id'] : NULL;
	$nama = isset($_GET['nama']) ? $_GET['nama'] : NULL;
	$kode   = isset($_GET['kode'])?$_GET['kode']:NULL;
	$status = isset($_GET['status'])?$_GET['status']:NULL;
	
	if (isset($kode)) {
		$onkode=explode('.',$kode);
		$prekode=$onkode[0];
		
		$kodecount=count($onkode)-1;
		$lastkode="";
		for ($i=0; $i<$kodecount; $i++) {

			$n = $i+1;
			if ($n==1) $conc = "";
			else $conc = ".";
			$lastkode=$lastkode.$conc.$onkode[$n];
		}
	}
    ?>
    
    <script type="text/javascript">
    contentloader('<?= app_base_url('/akuntansi/rekening?section=selectrekening')?>&kode=<?php if (isset($prekode)) echo $prekode; ?>','#boxkategori');
    </script>
	
	<form action="<?= app_base_url('akuntansi/control/rekening?section=addRekening') ?>" id="formrekening" method="post" onsubmit="simpanRekening($(this)); return false;">
	<fieldset id="master"><legend>Form Input Rekening</legend>
	    <div id="boxkategori"></div>
        <label for="kode">Kode</label>
		<input type="text" name="prekode" id="prekode" readonly="readonly" value="<?php if (isset($prekode)) echo $prekode;?>" style="min-width: 10px; max-width: 30px !important; background: #eee"/>
		<input type="text" name="kode" id="kode" value="<?php if (isset($lastkode)) echo $lastkode; ?>" style="min-width: 10px; max-width: 150px !important"/>
        <label for="nama">Nama</label><input type="text" name="nama" id="nama" value="<?php echo $nama; ?>" />
		<label for="status">Status</label>
		<select name="status" id="status" class="select-style">
				<option value=1 <?php if ($status==1) echo "selected"; ?>>Debit</option>
				<option value=2 <?php if ($status==2) echo "selected"; ?>>Kredit</option>
		</select>
		<label></label>
				<input type="hidden" name="id" value="<?php echo $id; ?>">
                <input id="simpan_utama" type="submit" value="Simpan" class="stylebutton" style="margin-right: 5px;" name="simpan"/>
                <input onclick="$('#admission').html('')" type="button" value="Batal" class="stylebutton" />
        
    </fieldset>
	</form> 
    
    <?php
    exit();
    break;
    
	//Select Rekening;	

    case "selectrekening":
    
	$kode = isset($_GET['kode']) ? $_GET['kode'] : NULL;
    require_once 'app/lib/common/master-akuntansi.php';
    
    $data_kategori_rekening=data_kategori_rekening(); ?>
    <label for="kategori">Kategori</label>
    <select name="kategori" id="kategori" class="select-style" onchange="changeKategoriOnKode($('#kategori').val())">
	<?php 
		echo "<option value=''>-- Pilih Kategori --</option>";
		foreach ($data_kategori_rekening as $row): 
		echo "<option value='".$row['id'].".".$row['kode']."' ";
		if ($kode==$row['kode']) echo "selected";
		echo ">".$row['nama']."</option>";
	endforeach;
	?>
    </select>
    <div class="act-suddenly" title="Manajemen Kategori Rekenening" onclick="showFormAddKategoriRekening()"><div class="icon button-sud-add"></div>Tambah</div>

    <?php
    
    exit();
    break;

 
 // ------------------------ Kategori Rekening --------------------------------//
 
 
 
    case "addkategorirekening":
    
    //SUB - Kategori Rekening
    $nama="";
    $kode="";
    $id="";
    if (isset($_GET['edit'])) {
	$url=app_base_url('akuntansi/control/rekening?section=editKategori');
	$judul="Edit Kategori";
	$tombol="Edit";
	$kode=$_GET['kode'];
	$nama=$_GET['nama'];
	$id=$_GET['id'];
    } else {
	$url=app_base_url('akuntansi/control/rekening?section=addKategori');	
	$judul="Tambah Kategori";
	$tombol="Simpan";
    }
    
    ?>
    
    <div class="data-list">
	<form action="<?php echo $url; ?>" method="post" id="addKategori" onsubmit="addNewKategori($(this)); return false;">
		<fieldset id="master"><legend><?php echo $judul; ?></legend>
			<label for="kode">Kode Kategori</label><input type="text" name="kode_kategori" id="kode_kategori" value="<?php echo $kode; ?>" onkeyup='Angka(this)' class="input-style" size=40/>
			<label for="nama">Nama Kategori</label><input type="text" name="nama_kategori" id="nama_kategori" value="<?php echo $nama; ?>" class="input-style" size=40 />
			<label></label>
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<input type="submit" value="<?php echo $tombol; ?>" class="stylebutton" style="margin-right: 5px;" name="simpan"/>
				<input type="button" value="Batal" class="stylebutton" onclick="$('#admission').html('')" /></a>
		</fieldset>
	</form> 
	</div>
    <?php
    exit();
    break;

    case "tambahkategorirekeninglite":
    
    //SUB - Add Kategori Rekening
    ?>	

    <div class="notif">
    <h2>Form Tambah Kategori Rekening</h2>
    <form method="post" action="<?= app_base_url('akuntansi/control/rekening?section=addKategori') ?>" class="search-form" id="addKategori" onsubmit="simpanLangsungKategori($(this)); return false;">
	<label for="kode_kategori">Kode Kategori</label><input class="input-style" size=35 name="kode_kategori"  onkeyup='Angka(this)'  id="kode_kategori" />
	<label for="nama_kategori">Nama Kategori</label><input class="input-style" size=35 name="nama_kategori" id="nama_kategori" />
	<label></label>
	   <input class="stylebutton" type="submit" name="submitKategori" value="Simpan" style="margin-right: 5px">
	   <input class="stylebutton" type="button" onclick="cancelAddKategoriRekening()" value="Batal"> 
    </form>
    </div>
    
    <?php
    exit();
    break;

    case "tabelkategorirekening":
	
    //Tabel Kategori Rekening	
    
    require_once 'app/lib/common/master-akuntansi.php';
    require_once 'app/lib/common/functions.php';
    
	$sort = isset($_GET['sort'])?$_GET['sort']:"kode";
	
	
    $dataKategori = data_kategori_rekening("",$sort);
    
    if (count($dataKategori)==0) {  
	    echo notifikasi("Data kategori belum tersedia");   
    } else { ?>
	<script type="text/javascript">
		$(function() { 
			$(".sorting").click(function() {
				var tipe = $(this).attr('href'); 
				contentloader('<?php echo app_base_url('akuntansi/rekening?section=tabelkategorirekening'); ?>&sort='+tipe,'#content');

				return false;
			})
        })
	</script>
	
    <table class="tabel full" id="kategoriTable" style="margin-top: 10px"> 
        <tr>
            <th width='20%'><a href="kode" class="sorting">Kode</a></th>
            <th width='65%'><a href="nama" class="sorting">Nama</a></th>
            <th width='15%'>Aksi</th>
        </tr>
        <?php foreach ($dataKategori as $data): ?>
	
        <tr id="<?php echo $data['id']; ?>">
            <td><?php echo $data['kode'] ?></td>
            <td><?php echo $data['nama'] ?></td>
            <td class="aksi">
			<?php if ($data['status'] == null) { ?>
                <a href="#" onclick="contentloader('<?= app_base_url('/akuntansi/rekening?section=addkategorirekening&edit=1&kode='.$data['kode'].'&nama='.$data['nama'].'&id='.$data['id'])?>','#admission'); return false;"  title="Edit" class="edit">Edit</a>
                <a href="#" title="Hapus" class="delete"
				onClick="showFormConfirm('Apakah Kategori Rekening ini akan dihapus?<br>Penghapusan akan menyebabkan data Rekening dengan Kategori ini ikut terhapus semua!','<?= app_base_url('/akuntansi/control/rekening?section=deleteKategoriRekening')?>','<?=$data['id']; ?>')">Delete</a>
            <?php } ?>
			</td>
        </tr>
	<?php endforeach; ?>
    </table>
	<?php
    }
    
    exit();
    break;
}

} else { ?>

<script type="text/javascript">
	contentloader('<?= app_base_url('/akuntansi/rekening?section=tabelrekening')?>','#content');
</script>

<?php

require_once 'app/lib/common/master-akuntansi.php';
require_once 'app/lib/common/functions.php';

?>

<div id="box-notif"></div><div class="clear"></div>

<h1 class="judul"><a href="<?= app_base_url('akuntansi/rekening') ?>">Manajemen Rekening</a></h1>

<div style='clear: both'>
   <div class="data-list w700px">
        <div class="floleft">
           <?php 
			echo addButton('showFormAddRekening()','Tambah Rekening','addRekeningButton'); 
			echo addButton('showAddKategoriRekening()','Tambah Kategori Rekening','addKategoriRekeningButton'); ?>
        </div>
        <div class="floright">
            <form action="" method="GET"class="search-form" style="margin: -5px 0 0 0" onsubmit="searchRekening(); return false">
                <input type="text" name="key" class="search-input" id="keysearch" value=""/><input type="submit" class="search-button" value=""/>
            </form>
        </div>
    </div> 
</div>
	<div id="admission" class="data-input"></div>
	<div id="content" class="data-list w700px"></div>
	
	</div><?php

	
	}
?>
		