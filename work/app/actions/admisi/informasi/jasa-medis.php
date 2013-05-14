<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
include 'app/actions/admisi/pesan.php';
set_time_zone();

$startDate = (isset($_GET['startDate'])) ? get_value('startDate') : date("d/m/Y");
$endDate = (isset($_GET['endDate'])) ? get_value('endDate') : date("d/m/Y");
?>
<script type="text/javascript">

$(function() {
            $('#nakes').autocomplete("<?= app_base_url('admisi/search?opsi=nakes') ?>",
            {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].nama// nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
						$('#idnakes').removeAttr('value');
                        var str='<div class=result>Nama :<b>'+data.nama+'</b><br /><i>NIP :</i> '+data.no_identitas+' <br/><i>SIP</i>: '+data.sip+'</div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
           }).result(
            function(event,data,formated){
                $(this).attr('value',data.nama);
                $('#idnakes').attr('value',data.id);
            });
            $('#layanan').autocomplete("<?= app_base_url('/admisi/search?opsi=layanan') ?>",
            {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].nama// nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
						$('#idlayanan').removeAttr('value');
                        var str='<div class=result>'+data.nama+'</div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
           }).result(
            function(event,data,formated){
                $(this).attr('value',data.nama);
                $('#idlayanan').attr('value',data.id);
            });
            });
            function cekdata(data) {
                    if ((data.idnakes.value == '') && (data.idlayanan.value == '')) {
                            alert('Nama nakes atau layanan harus dipilih !');
                            if (data.idnakes.value == '') {
                                    data.nakes.focus();
                            } else {
                                    data.layanan.focus();
                            }
                            return false;
                    }
            }
</script>
<h2 class="judul">Informasi Jasa Medis</h2><?= isset($pesan) ? $pesan : NULL ?>
<form action="" method="GET" onSubmit="return cekdata(this)">
    <div class="data-input">
        <fieldset><legend>Form Informasi Jasa Medis</legend>
            <fieldset class="field-group">
                <label>Tanggal</label>
                <input type="text" name="startDate" class="tanggal" id="awal" value="<?= $startDate ?>"/><label class="inline-title">s . d &nbsp;</label><input type="text" name="endDate" class="tanggal" id="akhir" value="<?= $endDate ?>"/>
            </fieldset>
            <label for="nakes">Nama Nakes</label><input type="text" name="nakes" id="nakes" value="<?= get_value('nakes') ?>"/>
            <input type="hidden" name="idnakes" id="idnakes" value="<?= get_value('idnakes') ?>" />
			<label for="layanan">Nama Layanan</label><input type="text" name="layanan" id="layanan" value="<?= get_value('layanan') ?>" />
            <input type="hidden" name="idlayanan" id="idlayanan" value="<?= get_value('idlayanan') ?>" />
			<fieldset class="input-process">
				<input type="submit" name="cari" value="Cari" class="tombol" /> <input type="button" value="Cetak" class="tombol cetaks" /> 
				<input type="button" value="Batal" class="tombol" onclick=location.href="<?= app_base_url('admisi/informasi/jasa-medis') ?>" />
			</fieldset>
        </fieldset>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $(".cetaks").click(function(){
			var win = window.open('<?= app_base_url('admisi/print/jasa-medis') ?>?startDate='+$('#awal').val()+'&endDate='+$('#akhir').val()+'&idnakes='+$('#idnakes').val()+'&idlayanan='+$('#idlayanan').val(), 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    })
</script>  
<?php
if (isset($_GET['cari'])) {
$nakes = isset($_GET['idnakes'])?$_GET['idnakes']:NULL;
$layanan = isset($_GET['idlayanan'])?$_GET['idlayanan']:NULL;
$jasa_medis = jasa_medis_muat_data($startDate, $endDate, $nakes, $layanan);
?>
<div class="data-list">
	<table width="55%" class="tabel">
            <tr>
		<th>No</th>
                <th>Tanggal</th>
                <th>Nakes</th>
                <th>Layanan</th>
                <th>Jumlah (Rp)</th>
            </tr>
            <?php 
			$total = 0;
			foreach ($jasa_medis as $key => $row): 
                            $layanan = "";
                            $layanan.= $row['layanan'];

                            if ($row['profesi'] == 'Tanpa Profesi')
                                $layanan.= "";
                            else
                                $layanan.=" $row[profesi]";

                            if ($row['spesialisasi'] == 'Tanpa Spesialisasi')
                                $layanan.= "";
                            else
                                $layanan.=" $row[spesialisasi]";

                            if ($row['bobot'] == 'Tanpa Bobot')
                                $layanan.= "";
                            else
                                $layanan.=" $row[bobot]";

                            if ($row['jenis'] == "Rawat Inap")
                                $layanan.=" $row[instalasi]";
                            else if ($row['instalasi'] == 'Rekam Medik' || $row['instalasi'] == 'Semua' || $row['instalasi'] == 'Tanpa Instalasi')
                                $layanan.= "";
                            else
                                $layanan.=" $row[instalasi]";

                            if ($row['kelas'] == 'Tanpa Kelas')
                                $layanan.= "";
                            else
                                $layanan.=" $row[kelas]";
                            
                            ?>
                                <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
                                    <td align="center"><?= ++$key ?></td>
                                    <td align="center"><?= datefmysql($row['waktu']) ?></td>
                                    <td><?= $row['nakes'] ?></td>
                                    <td><?= $layanan ?></td>
                                    <td align="right"><?= rupiah($row['total']) ?></td>
                                </tr>
                        <?php 
                                $total = $total + $row['total'];
                        endforeach; ?>
			<tr>
				<td colspan=4>TOTAL</td><td align=right><?= rupiah($total) ?></td>
			</tr>
	</table>
</div>
<?php
} ?>