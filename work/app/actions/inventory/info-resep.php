<?
include_once "app/lib/common/functions.php";
include_once "app/lib/common/master-inventory.php";
include_once "app/lib/common/master-data.php";
include 'app/actions/admisi/pesan.php';
set_time_zone();
$startDate = (isset($_GET['awal'])) ? $_GET['awal'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['akhir'])) ? $_GET['akhir'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$idDokter = isset($_GET['idDokter']) ? $_GET['idDokter'] : NULL;
$dokter = isset($_GET['dokter']) && ($idDokter != null) ? $_GET['dokter'] : NULL;
$idPasien = isset($_GET['idPasien']) ? $_GET['idPasien'] : NULL;
$pasien = isset($_GET['pasien']) && ($idPasien != null) ? $_GET['pasien'] : NULL;
$idUnit = get_value('unit');
$resep = resep_muat_data($startDate, $endDate, $idDokter, $idPasien);
$jumlah_no_r= jumlah_no_r_muat_data($startDate, $endDate, $idDokter, $idPasien);
$unit = unit_muat_data();

?>
<h2 class="judul">Informasi Resep</h2><?= isset($pesan) ? $pesan : NULL ?>
<script type="text/javascript">
    function openCetakSalinResep(id,kelas){
        window.open('print/salin-resep?code='+id+'&kelas='+kelas, 'MyWindow', 'width=600px, height=500px, scrollbars=1');
    }
    function cetak_etiket(id,no_r){
            var win = window.open('print/cetak-etiket?code='+id+'&kelas=1&no_r='+no_r, 'MyWindow', 'width=400px, height=400px, scrollbars=1');
        }
    $(function() {
        
        $('#dokter').autocomplete("<?= app_base_url('/inventory/search?opsi=caridokter') ?>",
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
                var str='<div class=result>Nama :<b>'+data.nama+'</b><br /><i>NIP :</i> '+data.no_identitas+' <br/><i>SIP</i>: '+data.sip+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#idDokter').attr('value',data.id);
        });
        $('#pasien').autocomplete("<?= app_base_url('/admisi/search?opsi=pasien') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                $('#idPasien').attr('value','');
                var str='<div class=result>'+data.nama+'<br />'+data.alamat_jalan+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#idPasien').attr('value',data.idpen);
        }
    );
    });
</script>
<div class="data-input">
    <fieldset><legend>Parameter Pencarian</legend>
        <form action="" method="get">
            <fieldset class="field-group">
                <legend>Tanggal Resep</legend>
                <input type="text" name="awal" class="tanggal" id="awal" value="<?= $startDate ?>" /><label class="inline-title">s . d &nbsp;</label><input type="text" name="akhir" class="tanggal" id="akhir" value="<?= $endDate ?>" />
            </fieldset>
            <label for="dokter">Dokter</label><input type="text" name="dokter" id="dokter" value="<?= $dokter ?>"><input type="hidden" name="idDokter" id="idDokter" value="<?= $idDokter ?>">
            <label for="pasien">Pasien</label><input type="text" name="pasien" id="pasien" value="<?= $pasien ?>"><input type="hidden" name="idPasien" id="idPasien" value="<?= $idPasien ?>">
            <fieldset class="input-process">
                <input type="submit" value="Cari" class="tombol" /> <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/info-resep') ?>'"/>
            </fieldset>
        </form>
    </fieldset>
</div>
<?php  if(isset($_GET['awal'])):?>
<fieldset><legend>Resep hasil pencarian</legend>
    <div class="data-list">
        <table class="tabel">
            <tr>
                <th style="width: 5%;   ">No. Salin Resep</th>
                <th>Tanggal</th>
                <th>Dokter</th>
                <th>Pasien</th>
                <th>Aksi</th>
            </tr>
            <?php 
            $i=0;
            
            foreach ($resep as $key => $row) {
                $i++;
            ?>
                <tr class="<?= ($key % 2==0) ? 'even' : 'odd' ?>">
                    <td align="center"><?= $row['no_resep'] ?></td>
                    <td><?= datefmysql($row['tanggal']) ?></td>
                    <td class="no-wrap"><?= $row['nama_dokter'] ?></td>
                    <td class="no-wrap"><?= $row['nama_pasien'] ?></td>
                    <td class="aksi">
                        <a href="<?= app_base_url('inventory/info-resep?id=' . $row['id_penjualan'] .'&no_r=' . $row['no_resep'] ."&awal=$startDate&akhir=$endDate&dokter=$dokter&idDokter=$idDokter&pasien=$pasien&idPasien=$idPasien") ?>" class="detail">detail</a>
                        <span class="cetak2" id="salin" onclick="openCetakSalinResep(<?=$row['id_penjualan']  ?>,1)">salinan resep</span>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div style="float: right">
        <span class="cetak" id="cetak">Cetak</span>
        <a href="<?= app_base_url('inventory/report/resep-excel?id=' . $row['no_resep'] . "&awal=$startDate&akhir=$endDate&dokter=$dokter&idDokter=$idDokter&pasien=$pasien&idPasien=$idPasien") ?>" class="excel">Cetak Excel</a>
    </div>
    <br>
    Jumlah Lembar Resep: <?=$i?>
    <br/>
    Jumlah R/ Total: <?=isset($jumlah_no_r['jumlah_no_r'])?$jumlah_no_r['jumlah_no_r']:0?>
</fieldset>
<?
            if (isset($_GET['id']) && $_GET['id'] != '') {
                require_once'app/lib/common/master-inventory.php';
                $barangs = detail_resep_muat_data($_GET['id'],$_GET['no_r']);
?>
                <br><br>
                <div class="data-list">
                    Detail resep:<?= $_GET['id'] ?>
                    <table class="tabel">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>No R/</th>
                            <th>Kekuatan R/</th>
                            <th>Jumlah R/</th>
                            <th>Aturan Pakai R/</th>
                            <th>No Nota</th>
                            <th>Jumlah Tebus</th>
                            <th>Detur</th>
                            <th>Aksi</th>
                        </tr>
        <?
                $i = 1;
                $temp=0;
                    $jumlah=1;
                    $group=array();
                    $a=0;
                foreach ($barangs as $b) {
                    
        ?>
                    <tr class="<?= (($i - 1) % 2!=0) ? 'odd' : 'even' ?>">
                        <td><?= $i++ ?></td>
                        <td class="no-wrap"><?= "$b[nama_barang] $b[nilai_konversi] $b[satuan_terkecil]" ?></td>
                        <td><?= $b['no_r'] ?></td>
                        <td><?= $b['kekuatan_r_racik'] ?></td>
                        <td><?= $b['jumlah_r_resep'] ?></td>
                        <td><?= $b['aturan_pakai'] ?></td>
                        <td><?= $b['no_nota'] ?></td>
                        <td><?= $b['jumlah_r_tebus'] ?></td>
                        <td><?= $b['detur'] ?></td>
                        <?php
                        //echo $temp."=".$b['no_r'];
                        if($temp!=$b['no_r']){
                            echo "<td id=resep_$b[no_r] align=center><span class=cetak onClick=cetak_etiket(".$_GET['id'].",$b[no_r])>Cetak</cetak></td>";
                            $group[$a]['nomor']=$b['no_r'];
                            $temp=$b['no_r'];
                            if(isset($group[$a-1]))
                                $group[$a-1]['jumlah']=$jumlah;
                            $a++;
                            $jumlah=1;
                        }else{
                            $jumlah++;
                        }
                        
                        
                        ?>
                    </tr>
        <?
                }
                
                if(isset($group[$a-1]))
                            $group[$a-1]['jumlah']=$jumlah;
        ?>
            </table>
        </div>
    Jumlah R/: <?=$i-1?>
      
<?

 
        foreach($group as $g){
                ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#resep_'+<?=$g['nomor']?>).attr('rowspan', <?=$g['jumlah']?>);
                $('#resep_'+<?=$g['nomor']?>).attr('valign', 'middle');
            });
        </script>
                <?
            }
        

            }
?>
    
    
   
            <script type="text/javascript">
                $(document).ready(function(){                    
                                        
                    $("#cetak").click(function(){
                        var win = window.open('report/penjualan-resep?startDate=<?= $startDate ?>&endDate=<?= $endDate ?>&iddokter=<?= $idDokter ?>&idPasien=<?= $idPasien ?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    })
</script> 
<?php
    endif;
?>