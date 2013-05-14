<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "app/lib/common/functions.php";
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/pf/obat.php';
$obat                = isset($_GET['obat']) ? $_GET['obat'] : NULL;
$packing             = isset($_GET['idPacking']) ? $_GET['idPacking'] : NULL;
$perundangan         = get_value('perundangan');
$indikasi            = get_value('indikasi');
$ven                 = get_value('ven');
$ssFarmakologi       = get_value('ssFarmakologi');
$idSubSubFarmakologi = get_value('idSubSubFarmakologi');
$unit                = get_value('nama');
$id_unit             = get_value('id');
$generik             = get_value('generik');
$formularium         = get_value('formularium');
$zatAktif            = get_value('zatAktif');
$idZatAktif          = get_value('idZatAktif');
$perundangans        = perundangan_muat_data();
?>
<script type="text/javascript">
	$(function()
	{
		$('#obat').autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>",
		{
			parse: function(data)
			{
				var parsed = [];
				for (var i=0; i < data.length; i++)
				{
					parsed[i] =
					{
						data: data[i],
						value: data[i].nama_barang // nama field yang dicari
					};
				}
				return parsed;
			},
			formatItem: function(data,i,max)
			{
				var kekuatan = (data.kekuatan!=null && data.kekuatan!=0)?' '+data.kekuatan+',':'';
				var sediaan  = (data.sediaan!=null)?' '+data.sediaan:'';
				var pabrik   = '';
				if(data.generik == 'Generik')
				{
					pabrik='<br>\n\<b>Pabrik :</b><i>'+data.pabrik+'</i>';
				}
				var str = '<div class=result><b>'+data.nama_barang+'</b> <i>'+kekuatan+''+sediaan+'@'+data.nilai_konversi+' '+data.satuan_terkecil+'</i>'+pabrik+'</div>';
				$('#idPacking').attr('value','');
				return str;
			},
			width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
			dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
		}).result(
			function(event,data,formated)
			{
				var kekuatan = (data.kekuatan!=null && data.kekuatan!=0)?' '+data.kekuatan+',':'';
				var sediaan  = (data.sediaan!=null)?' '+data.sediaan:'';
				var pabrik   = '';
				if(data.generik == 'Generik')
				{
					pabrik = ' '+data.pabrik;
				}
				$(this).attr('value', data.nama_barang+kekuatan+sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+pabrik);
				$('#idPacking').attr('value',data.id);
			}
		);
	});
	$(function()
	{
		$('#ssFarmakologi').autocomplete("<?= app_base_url('/pf/search?opsi=sub_sub_farmakologi') ?>",
		{
			parse: function(data)
			{
				var parsed = [];
				for (var i=0; i < data.length; i++)
				{
					parsed[i] =
					{
						data: data[i],
						value: data[i].nama // nama field yang dicari
					};
				}
				return parsed;
			},
			formatItem: function(data,i,max)
			{
				var str = '<div class=result>'+data.nama+'-'+data.nama_sub_farmakologi+'-'+data.nama_farmakologi+'<br/></div>';
				$('#idSubSubFarmakologi').attr('value','');
				return str;
			},
			width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
			dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
		}).result(
			function(event,data,formated)
			{
				$('#idSubSubFarmakologi').attr('value',data.id_sub_sub_farmakologi);
				$('#ssFarmakologi').attr('value',data.nama+'-'+data.nama_sub_farmakologi+'-'+data.nama_farmakologi);
			}
		);
	});
	$(function()
	{
		$('#zatAktif').autocomplete("<?= app_base_url('/inventory/search?opsi=zatAktif') ?>",
		{
			parse: function(data)
			{
				var parsed = [];
				for (var i=0; i < data.length; i++)
				{
					parsed[i] =
					{
						data: data[i],
						value: data[i].nama // nama field yang dicari
					};
				}
				return parsed;
			},
			formatItem: function(data,i,max)
			{
				var str='<div class=result>'+data.nama+'<br/></div>';
				$('#idZatAktif').attr('value','');
				return str;
			},
			width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
			dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
		}).result(
			function(event,data,formated)
			{
				$('#idZatAktif').attr('value',data.id);
				$(this).attr('value',data.nama);
			});
		$('#unit').autocomplete("<?= app_base_url('/inventory/search?opsi=unit') ?>",
		{
			parse: function(data)
			{
				var parsed = [];
				for (var i=0; i < data.length; i++)
				{
					parsed[i] =
					{
						data: data[i],
						value: data[i].nama // nama field yang dicari
					};
				}
				return parsed;
			},
			formatItem: function(data,i,max)
			{
				var str='<div class=result>'+data.nama+'<br/></div>';
				$('#id_unit').attr('value','');
				return str;
			},
			width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
			dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
		}).result(
			function(event,data,formated)
			{
				$('#id_unit').attr('value',data.id);
				$('#unit').attr('value',data.nama);
			}
		);
	});
</script>
<h2 class="judul"><a href="<?php echo app_base_url('inventory/stok-obat-unit'); ?>">Stok Obat Unit</a></h2>
<div class="data-input">
	<fieldset>
		<legend>Parameter Pencarian</legend>
		<form action="" method="get">
			<label for="unit">Nama Unit</label><input type="text" class="unit" name="unit" id="unit" value="<?php echo $unit ?>" /><input type="hidden" name="idUnit" class="auto" id="idUnit" value="<?php echo $id_unit ?>" />
			<label for="obat">Nama Obat</label><input type="text" class="nama_barang" name="obat" id="obat" value="<?php echo $obat ?>" /><input type="hidden" name="idPacking" class="auto" id="idPacking" value="<?php echo $packing ?>" />
			<label for="barang">Perundangan</label>
			<select name="perundangan">
				<option value="">Pilih </option>
				<?php
				foreach ($perundangans as $row)
				{
				?>
					<option value="<?php echo $row['id'] ?>" <?php if ($row['id'] == $perundangan)
					echo "selected"; ?>><?php echo $row['nama'] ?></option>
				<?php
				}
				?>
			</select>
			<label for="generik">Generik</label>
			<select name="generik">
				<option value="all" 
				<?php
				if ($generik == "all")
					echo "selected";
				?>>Pilih</option>
				<option value="Generik" 
				<?php
				if ($generik == "Generik")
					echo "selected";
				?>>Generik</option>
				<option value="Non Generik" 
				<?php
				if ($generik == "Non Generik")
					echo "selected";
				?>>Non Generik</option>
			</select>
			<label for="formularium">Formularium</label>
			<select name="formularium">
			<option value="all" 
				<?php
				if ($formularium == "all")
					echo "selected";
				?>>Pilih</option>
				<option value="Formularium" 
				<?php
				if ($formularium == "Formularium")
					echo "selected";
				?>>Formularium</option>
				<option value="Non Formularium" 
				<?php
				if ($formularium == "Non Formularium")
					echo "selected";
				?>>Non Formularium</option>
			</select>
			<label>Zat Aktif</label><input id="zatAktif" name="zatAktif" value="<?php echo $zatAktif?>" type="text" /><input id="idZatAktif" type="hidden" name="idZatAktif" value="<?php echo $idZatAktif?>" />
			<label for="barang">Indikasi</label><textarea name="indikasi"><?php echo $indikasi ?></textarea>
			<label for="ven">Ven</label>
			<select name="ven">
				<option value="">Pilih</option>
				<option value="Esensial" <?php echo $ven == 'Esensial' ? 'selected' : '' ?>>Esensial</option>
				<option value="Non Esensial" <?php echo $ven == 'Non Esensial' ? 'selected' : '' ?>>Non Esensial</option>
				<option value="Vital" <?php echo $ven == 'Vital' ? 'selected' : '' ?>>Vital</option>
			</select>
			<label for="ssf">Sub sub farmakologi</label><input type="text" id="ssFarmakologi" name="ssFarmakologi" value="<?php echo $ssFarmakologi ?>" /><input type="hidden" name="idSubSubFarmakologi" id="idSubSubFarmakologi" value="<?php echo $idSubSubFarmakologi ?>" />
			<fieldset class="input-process">
				<input type="submit" value="Cari" name="cari" class="tombol" />
				<input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?php echo app_base_url('inventory/stok-obat-unit') ?>'" />
			</fieldset>
		</form>
	</fieldset>
</div>
<fieldset>
	<legend>Hasil Percarian</legend>
	<div class="data-list">
		<table class="tabel">
			<tr>
				<th>Unit</th>
				<th>Nama Obat</th>
				<th>Stok Sisa</th>
				<th>HPP(Rp.)</th>
				<th>Nilai (Rp.)</th>
			</tr>
			<?php
			if (isset($_GET['cari']))
			{
				$totalAset = 0;
				$no        = 1;
				$stokObat  = stok_obat_muat_data4($packing, $perundangan, $generik, $formularium, $indikasi, $ven, $idSubSubFarmakologi,$idZatAktif);
				foreach ($stokObat as $row)
				{
					if ($row['sisa'] == 0)
						echo "";
					else
					{
						if ($row['pabrik'] == 'None' || $row['pabrik'] == 'NULL')
								$pabrik = "";
							else
								$pabrik = $row['pabrik'];
						$style = ($no % 2) ? 'class="odd"' : 'class="even"';
			?>
			<tr <?= $style ?>>
				<td class="no-wrap"><?php echo $row['unit'] ?></td>
				<td><?php echo "$row[barang] $row[kekuatan], $row[sediaan] @$row[nilai_konversi] $row[satuan_terkecil] $pabrik" ?></td>
				<td align="center"><?php echo $row['sisa'] ?></td>
				<td align="right"><?php echo rupiah($row['hpp']) ?></td>
				<td align="right"><?php echo rupiah($row['nilai']) ?></td>
			</tr>
			<?php
			$no++;
					$totalAset = $totalAset + $row['nilai'];
					}
				}
			?>
		</table>
	</div>
	<div class="perpage" style="margin-top: 5px">
		Total Nilai Obat : <? echo "Rp. " . rupiah($totalAset) . ",00"; ?>
	</div>
	<?php } ?>
</fieldset>    