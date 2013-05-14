<?php
    require_once 'app/lib/common/master-data.php';    
    require_once 'app/lib/common/functions.php';
    include 'app/actions/admisi/pesan.php';
    set_time_zone();
    $startDate=(isset($_GET['startDate']))?get_value('startDate'):date("d/m/Y");
    $endDate=(isset($_GET['endDate']))?get_value('endDate'):date("d/m/Y");
    $idDokter= isset ($_GET['iddokter'])?get_value('iddokter'):NULL;
    $dokter= isset ($_GET['dokter'])?get_value('dokter'):NULL;
    $pasien = isset ($_GET['pasien'])?get_value('pasien'):NULL;
    $idPasien = isset ($_GET['idPasien'])?get_value('idPasien'):NULL;
?>
<script type="text/javascript">
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
                $('#iddokter').attr('value',data.id);
        });
});
</script>
<script type="text/javascript">
$(function() {
        $('#pasien').autocomplete("<?= app_base_url('/admisi/search?opsi=nama') ?>",
        {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].nama_pas // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        if (data.id_pasien == null) {
                        var str='<div class=result>'+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                        } else {
                        var str='<div class=result><b>'+data.id_pasien+'</b> - '+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                        }
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                
            });
        });
</script> 
<h2 class="judul">Laporan Penjualan Resep</h2>
<form action="" method="GET">
<div class="data-input">
    <fieldset>
        <fieldset class="field-group">
        <label for="tanggal">Range Tgl. Resep</label>
        <input type="text" name="startDate" class="tanggal" id="awal" value="<?= $startDate ?>"/><label class="inline-title">s . d &nbsp;</label><input type="text" name="endDate" class="tanggal" id="akhir" value="<?= $endDate ?>"/>
        </fieldset>
        <label for="dokter">Nama Dokter</label>
        <input type="text" name="dokter" id="dokter" value="<?= $dokter?>"/>
        <input type="hidden" name="iddokter" id="iddokter" value="<?= $idDokter?>"/>
        <label for="">Nama Pasien</label>
        <input type="text" name="pasien" id="pasien" value="<?= $pasien?>">
        <input type="hidden" name="idPasien" id="idPasien" value="<?= $idPasien?>">
        <fieldset class="input-process">
            <input type="submit" value="Cari" class="tombol">
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/laporan-penjualan-resep')?>'">
        </fieldset>    
    </fieldset>    
</div>
</form>    
  <div class="data-list">
    <table class="tabel">
        <tr>
           <th>No</th> 
           <th>Nama Instansi Relasi</th>
           <th>Tanggal</th>
           <th>Pro</th>
           <th>Nama Dokter</th>
           <th>Keabsahan</th>
           <th>Aksi</th>
        </tr>
        <tr>
          <?
            $penjualanResep = penjualan_resep_muat_data($startDate,$endDate,$idDokter,$idPasien);
            foreach ($penjualanResep as $key => $row ){
//                $jumlahTotal = (($row['hna']*$row['margin'])+$row['hna'])*$row['jumlah_penjualan'];
          ?>
            <tr class="<?= ($key%2) ? 'even':'odd' ?>">
               <td align="center"><?= ++$key?></td> 
               <td class="no-wrap"><?= $row['instansi_relasi']?></td>
               <td><?= datefmysql($row['tanggal'])?></td>
               <td class="no-wrap"><?= $row['pasien']?></td>
               <td class="no-wrap"><?= $row['dokter']?></td>
               <td><?= $row['keabsahan']?></td>
               <td class="aksi"><a href="<?= app_base_url('inventory/laporan-penjualan-resep/?startDate='.$startDate.'&endDate='.$endDate.'&id='.$row['id'].'&dokter='.$dokter.'&iddokter='.$idDokter.'&pasien='.$pasien.'&idPasien='.$idPasien.'')?>" class="detail">detail</a></td>
            </tr>    
          <?  
            }
          ?>  
        </tr>    
    </table>
  </div>
  <span class="cetak" >Cetak</span>  
  <a href="<?= app_base_url('inventory/report/penjualan-resep-excel/?startDate='.$startDate.'&endDate='.$endDate.'')?>" class="excel" >Cetak Excel</a>
  <?
  if(isset ($_GET['id'])&&$_GET['id']!=''){
      
  }
  ?>
  <script type="text/javascript">
    $(document).ready(function(){
        $(".cetak").click(function(){
            var win = window.open('report/penjualan-resep?startDate=<?= $startDate?>&endDate=<?= $endDate?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    })
</script>