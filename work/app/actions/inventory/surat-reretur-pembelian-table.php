<script type="text/javascript">
   $(function() {
   
	  var maxi=$("#total").val();
	     for(var j=1;j<=maxi;j++){
        $('#batch'+j).autocomplete("<?= app_base_url('inventory/search?opsi=batchretur') ?>&id_packing="+$('#idpacking'+j).val(),
        { 
           /* extraParams:{idpacking: function() { return $('#idpacking'+j).val();   }
            }, */
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].batch // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
              return "<div class=result>"+data.batch+"</div>";
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(function(event,data,formated){
              $(this).val(data.batch);
        });
		}
		    })
</script>
<?
    require_once 'app/lib/common/master-data.php';
    $detail=  detail_retur_muat_data($_GET['id']);
?>
<table id="tblPemesanan" class="table-input">
        <tr>
            <th style="width: 2%">No</th>
            <th style="width: 40%">Nama Barang</th>
            <th style="width: 10%">No Faktur</th>
            <th style="width: 10%">No Batch</th>
            <th style="width: 10%">Tgl Kadaluarsa</th>
            <th style="width: 5%">Jumlah</th>
             <th style="width: 5%">Uang</th>
            <th style="width: 10%">Kemasan</th>
            <th style="width: 10%">Aksi</th>
        </tr>
        <?php 
		$x=count($detail);?>
		    <input type="hidden" name="total" id="total" value="<?=$x?>" />
	<?	$i=1;foreach ($detail as $brg) {
            $nama=nama_packing_barang(array($brg['generik'],$brg['barang'],$brg['kekuatan'],$brg['sediaan'],$brg['nilai_konversi'],$brg['satuan_terkecil'],$brg['pabrik']));
        ?>
            <tr class="barang_tr <?= ($i % 2) ? 'even' : 'odd' ?>">
                <td align="center"><?= $i ?></td>
                <td align="left">
                    <?=$nama?>
                    <input type="hidden" name="barang[<?= $i ?>][idpacking]" id="idpacking<?= $i ?>" class="auto" value="<?=$brg['id_packing']?>"/>
                    <input type="hidden" name="barang[<?= $i ?>][iddetail]" id="iddetail<?= $i ?>" class="auto" value="<?=$brg['iddetail']?>"/>
                
                </td>
                <td align="left"><?=$brg['no_faktur']?></td>
                <td align="center"><input type="text" name="barang[<?= $i ?>][batch]" id="batch<?= $i ?>" class="auto">
                <input type="hidden" name="barang[<?= $i ?>][batchFaktur]" class="auto" value="<?=$brg['batch_retur']?>"></td>
                <td><input type="text" name="barang[<?=$i?>][ed]" id="tanggal<?=$i?>" class="tanggal"></td>
                <td align="center"><input size=8 type="text" id="jumlah<?= $i ?>" name="barang[<?= $i ?>][jumlah]" class="auto"></td>
               <td align="center"><input type='checkbox' name="jenis" id="jenis" value="Uang"></td>
                <td align="center" id="satuan_terbesar<?= $i ?>"><?=$brg['satuan_terbesar']?></td>
                <td align="center"><input type="button" class="tombol" value="Hapus" onclick="hapusBarang(1,this)"></td>
            </tr>
            <script type="text/javascript">initAutocomplete(<?= $i ?>);</script>
        <? $i++;} ?>
    </table>
<?exit;?>