<?php
$cek = $_GET['do'];
require_once 'app/lib/common/master-inventory.php';
if ($cek == 'edit')
	$barang = barang_muat_data_by_id_beli($_GET['id']);
else
	$barang = barang_muat_data_by_nosp($_GET['nosp']);
set_time_zone();

?>
<script type="text/javascript">

    /******-> Fungsi yang lama
    function setTotalBayar(ppn,materai){
                materai=(materai==''||materai==null||isNaN(materai))?0:materai;
                materai=currencyToNumber(materai+'');
		var total  = tot+(tot*(ppn*0.01))+(materai);
		var total = tot + (tot*(ppn*0.01)) + materai;
		
                $("#bayar").html(numberToCurrency(total));
    }*/
	 function setTotalBayar1(total, ppn,materai, selisih){             
		var totalz  = total + ppn + materai;
		//alert('2. total = '+total+' | ppn = '+ppn+' | materai = '+materai+' | selisih = '+selisih+' | totalz = '+totalz);
                $("#bayar").html(floatToCurrency(totalz));
    }
	function getPPN(){
        var ppn=$("input[name=ppn]").attr('value')*1;
        if(ppn==''||ppn==null||isNaN(ppn))
            ppn=0;
        return ppn;
    }
    function hapusBarang(idx,el){
            /*tot=tot-currencyToNumber($('#total_'+idx).attr("value"));
            tot_disc=tot_disc-currencyToNumber($('#diskon_rp_'+idx).html);*/            
            var parent = el.parentNode.parentNode;
            parent.parentNode.removeChild(parent);
            var baris=$('.barang_tr');
            for(var i=0;i<baris.length;i++){
               $('.barang_tr:eq('+i+')').children('td:eq(0)').html(i+1);
               $('.barang_tr:eq('+i+')').removeClass('even');
               $('.barang_tr:eq('+i+')').removeClass('odd');
               $('.barang_tr:eq('+i+')').addClass(((i+1) % 2 == 1)?'even':'odd');
            }
            hitungTotal();
            counter=$('.barang_tr').size()+1;
    }
    function getMaterai(){
        var materai=currencyToNumber($("input[name=materai]").val());
        if(materai==''||materai==null||isNaN(materai))
            materai=0;
        return materai;
    }
    
    function hitungTotal(){
        var rowCount=$('.barang_tr').size();
        if(rowCount>0){
            var totalAll=0;
            var totalDisc=0;
            for(var no=1;no<=rowCount;no++){
                var harga=currencyToNumber($("#harga_"+no).val());
                if(harga==''||harga==null||isNaN(harga))
                    harga=0;
                
                var diskon=$("#diskon_"+no).val();
                if(diskon==''||diskon==null||isNaN(diskon))
                    diskon=0;
                
                var jumlah=$("#jumlah_"+no).val();
                if(jumlah==''||jumlah==null||isNaN(jumlah))
                    jumlah=0;                                
               
                var selisih = Math.round(jumlah*(harga*diskon/100));
                var total = Math.round(((jumlah*harga)-selisih)*100)/100;
                totalDisc=totalDisc+selisih;
                totalAll=totalAll+total;
                $('#diskon_rp_'+no).html(numberToCurrency2(selisih));
                $("#total_"+no).attr('value',floatToCurrency(total));
            }
            var ppn=getPPN();
            var materai=getMaterai();
            
            var ppn_nominal=totalAll*getPPN()/100;            
        // $('#ppn_nominal').html(numberToCurrency(ppn_nominal)); //-> Ini yang lama
            $('#ppn_nominal').html(numberToCurrency(parseInt(ppn_nominal)));            
            $("#total_diskon").html(numberToCurrency(totalDisc));
            $("#materai2").html(numberToCurrency(materai));
            $("#totalAll").html(floatToCurrency(totalAll));
        // setTotalBayar(ppn, materai); --> Ini pake function yang lama
            setTotalBayar1(totalAll, parseInt(ppn_nominal), materai, selisih);
        }
    }        
    function hitungharga(){
        var rowCount=$('.barang_tr').size();
        if(rowCount>0){
            var totalAll=0;
            var totalDisc=0;
            for(var no=1;no<=rowCount;no++){
                var total=currencyToNumber($("#total_"+no).val());
                if(total==''||total==null||isNaN(total))
                    total=0;
                
                var diskon=$("#diskon_"+no).val();
                if(diskon==''||diskon==null||isNaN(diskon))
                    diskon=0;
                
                var jumlah=$("#jumlah_"+no).val();
                if(jumlah==''||jumlah==null||isNaN(jumlah))
                    jumlah=0;                                
               
                var selisih = Math.round(jumlah*(harga*diskon/100));
				 if(selisih==''||selisih==null||isNaN(selisih))
                    selisih=0;   
					
                var harga = Math.round(((total/jumlah)-selisih)*100)/100;
                totalDisc=totalDisc+selisih;
                totalAll=totalAll+total;
                $('#diskon_rp_'+no).html(numberToCurrency2(selisih));
				 $('#diskon_'+no).attr('value','');
                $("#harga_"+no).attr('value',floatToCurrency(harga));
            }
            var ppn=getPPN();
            var materai=getMaterai();
            
            var ppn_nominal=totalAll*getPPN()/100;            
        // $('#ppn_nominal').html(numberToCurrency(ppn_nominal)); //-> Ini yang lama
            $('#ppn_nominal').html(numberToCurrency(parseInt(ppn_nominal)));            
            $("#total_diskon").html(numberToCurrency(totalDisc));
            $("#materai2").html(numberToCurrency(materai));
            $("#totalAll").html(floatToCurrency(totalAll));
        // setTotalBayar(ppn, materai); --> Ini pake function yang lama
            setTotalBayar1(totalAll, parseInt(ppn_nominal), materai, selisih);
        }
    }        
    $(document).ready(function(){
        $('.ppn').blur(function(){
            hitungTotal();
        });
        $('.materai').blur(function(){
            hitungTotal();
        });
    });
    var counter=$('.barang_tr').length+1;
    $(document).ready(function(){
        $('#tambahBaris').click(function(){
            var count = counter++,
            number=$('.barang_tr').length+1,
            string = "<tr class='barang_tr'>"+
                      "<td align=center>"+number+"</td>"+
                      "<input type='hidden' name='barang["+count+"][iddetail_baru]' id='iddetail_baru"+count+"'> "+
                      "<td><input type='text' name='barang["+count+"][nama]' id='barang"+count+"' class='barang' style='width: 100%'/>"+
                      "<input type='hidden' name='barang["+count+"][idbarang]' id='idBarang"+count+"'></td>"+
                      "<td align='center'><input id='no_batch_"+count+"'  type='text' name='barang["+count+"][no_batch]' maxlength='20' onkeyup='AlpaNumerik(this)'  class='barang' style='width: 80%'/></td>"+
                      "<td align='center'><input style='width:6.5em' id='ed_"+count+"'  type='text' name='barang["+count+"][ed]' id='tanggal"+count+"' class='tanggal'  maxlength='11'/></td>"+
                      "<td align='center'><input style='width:6em' id='jumlah_"+count+"' onblur='hitungTotal("+count+")' type='text' name='barang["+count+"][jumlah]' class='auto' onkeyup='Desimal(this)'  maxlength='11'/></td>"+
                      "<td align='center'></td>"+
                      "<td align='center'><input id='harga_"+count+"' style='width:7em' onblur='hitungTotal("+count+")' type='text' name='barang["+count+"][harga]' id='harga"+count+"' class='auto right' onkeyup='formatNumber(this)'  maxlength='11'/></td>"+
                      "<td align='center'><input style='width:5em' id='diskon_"+count+"' onblur='hitungTotal("+count+")' type='text' name='barang["+count+"][diskon]' id='diskon"+count+"' onkeyup='formatNumber(this)' class='auto'  maxlength='5'/></td>"+
                      "<td align='center' id='diskon_rp_"+count+"'></td>"+
                      "<td align='center'><input style='width:7em' id='total_"+count+"' type='text' value='0' name='barang["+count+"][total]' id='total"+count+"' class='auto right' onblur='hitungharga("+count+")'/></td>"+
                      "<td align='center'><input type='checkbox' name='barang["+count+"][bonus]' value='1' id='bonus"+count+"' onclick='bonusAction(this,"+count+");'/></td>"+
                      "<td class='aksi'><input type='button' class='tombol' value='Hapus' onclick='hapusBarang("+count+",this)' /></td></tr>";
                                  $('#tblPembelian').append(string);
                                  if(count % 2 == 1){
                                     $('.barang_tr:eq('+(count-1)+')').addClass('even');
                                  }else if(count % 2 == 0){
                                     $('.barang_tr:eq('+(count-1)+')').addClass('odd');
                                  }
                                  initTanggal();
                                  $(function() {
                                      $('#barang'+count).autocomplete("<?= app_base_url('/inventory/search?opsi=barang_sp') ?>",
                                      {
                                          extraParams:{
                                              nosp: function() { return $('#nosp').attr('value'); }
                                          },
                                          parse: function(data){
                                              var parsed = [];
                                              for (var i=0; i < data.length; i++) {
                                                  parsed[i] = {
                                                      data: data[i],
                                                      value: data[i].nama_barang // nama field yang dicari
                                                  };
                                              }
                                              return parsed;
                                          },
                                          formatItem: function(data,i,max){
                                                var str=ac_nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)
                                                return str;
                                          },
                                          width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                                          dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                                      }).result(
                                      function(event,data,formated){
                                           var str=nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik]);
                                          $(this).attr('value', str);
                                          $('#idBarang'+count).attr('value',data.idbarang);
                                          $(this).parent('td').parent('tr').children('td:eq(5)').html(data.satuan_terbesar);
                                          $('#iddetail_baru'+count).attr('value',data.id_detail_pemesanan);
                                      }
                                  );
                                  });
                              })
                              
                          })
</script>
<?php
if ($cek != 'edit'){
?>
<input type="button" value="Tambah Baris" id="tambahBaris" class="tombol" style="margin-bottom: 5px;">
<?php } ?>
<br />
  <div class="data-list tabelflexibel">
<table class="table-input" id="tblPembelian" cellspacing="0" cellpadding="0" style="width: 110%;">
    <tr>
        <th>No</th>
        <th style="width: 30%">Nama Packing Barang</th>
        <th>No Batch</th>
        <th>E.D.</th>
        <th>Jumlah</th>
        <th>Kemasan</th>
        <th>Harga @</th>
        <th>Disc (%)</th>
        <th>Disc (Rp)</th>
        <th>Sub Total</th>
        <th>Bonus</th>
		<?php
		if ($cek != 'edit'){
		?>
        <th>Aksi</th>
		<?php } ?>
    </tr>
    <?php
    $no = 0;
    $count = NULL;

    foreach ($barang as $brg) {
	if(isset($brg['harga_pembelian'])){
	$harga1	= rupiah($brg['harga_pembelian']);
        ////str_ireplace(".", ",", $brg['harga_pembelian']);
	}
	else{
	$harga1	='';
	}
    ?>
        <tr class="barang_tr <?=($no%2==1)?"odd":"even"?>">
            <td align="center"  class="listBarang">
                <?= ++$no ?>
            </td>
            <td align="left" style="white-space: nowrap;">
				<?php
				if ($cek == 'edit')
					echo '<input type="hidden" name="barang['.$no.'][id_beli]" value="'.$brg['id'].'" />';
				else
				{
				?>
                <input type="hidden" name="barang[<?= $no ?>][idbarang]" value="<?= $brg['idbarang'] ?>">
                <input type="hidden" name="barang[<?= $no ?>][iddetail]" value="<?= $brg['id_detail'] ?>">
                <?php
				}
                    $nama=nama_packing_barang(array($brg['generik'],$brg['nama_barang'],$brg['kekuatan'],$brg['sediaan'],$brg['nilai_konversi'],$brg['satuan_terkecil'],$brg['pabrik']));   
//                    $nama = "$brg[nama_barang]";
              

                ?>
                <?=$nama ?>
            </td>
            <td align="center"><input style="width: 80%;" id="no_batch_<?= $no ?>" <?php echo (isset($brg['batch']) ? 'value="'.$brg['batch'].'"' : '');  ?> type="text" name="barang[<?= $no ?>][no_batch]" maxlength="20" onkeyup="AlpaNumerik(this)"/></td>
            <td align="center"><input style="width: 6.5em;" id="ed_<?= $no ?>"  <?php echo (isset($brg['ed']) ? 'value="'.datefmysql($brg['ed']).'"' : '');  ?> type="text" name="barang[<?= $no ?>][ed]" id="tanggal<?= $no ?>" class="tanggal" maxlength="11"/></td>
            <td align="center"><input style="width: 6em;" id="jumlah_<?= $no ?>" onblur="hitungTotal(<?= $no ?>)" type="text" name="barang[<?= $no ?>][jumlah]" class="auto" onkeyup='Desimal(this)' value="<?= $brg['jumlah'] ?>" maxlength="11"/></td>
            <td align="center"><?= $brg['satuan_terbesar'] ?></td>
            <td align="center"><input style="width: 7em;" id="harga_<?= $no ?>" <?php echo (isset($brg['harga_pembelian']) ? 'value="'.$harga1.'"' : '');  ?> onblur="hitungTotal(<?= $no ?>)" type="text" name="barang[<?= $no ?>][harga]" id="harga<?= $no ?>" class="auto right" onkeyup="formatNumber(this)" maxlength="11"/></td>
            <td align="center"><input style="width: 5em;" id="diskon_<?= $no ?>" <?php echo (isset($brg['diskon']) ? 'value="'.$brg['diskon'].'"' : '');  ?> onblur="hitungTotal(<?= $no ?>)" type="text" name="barang[<?= $no ?>][diskon]" id="diskon<?= $no ?>" onkeyup='Desimal(this)' class="auto" maxlength="5"/></td>
            <td align="center" id="diskon_rp_<?= $no ?>"></td>
            <td align="center"><input style="width: 7em;" id="total_<?= $no ?>" type="text" value="0" name="barang[<?= $no ?>][total]" id="total<?= $no ?>" class="auto right" onblur="hitungharga(<?= $no ?>)"/></td>
            <td align="center"><input type="checkbox" name="barang[<?= $no ?>][bonus]" value="1" id="bonus<?= $no ?>" onclick="bonusAction(this,<?= $no ?>);"/></td>
			<?php
			if ($cek != 'edit'){
			?>
            <td class="aksi">
                <input type="button" class="tombol" value="Hapus" onclick="hapusBarang(<?= $no ?>,this)" />
            </td>
			<?php } ?>
        </tr>
<?php } ?>
</table>

<table width="100%">
        <tr>
            <td width="72%">&nbsp;</td><td width="115px">Total Diskon</td><td width="5px">: </td><td id="total_diskon" align="right"></td><td width="2%">&nbsp;</td>
        </tr>
        <tr>
            <td width="72%">&nbsp;</td><td width="115px">Total</td><td width="5px">: </td><td id="totalAll" align="right"></td><td width="10%">&nbsp;</td>
        </tr>
        <tr>
             <td width="">&nbsp;</td><td width="115px">PPN (Rp)</td><td width="5px">: </td><td id="ppn_nominal" align="right"></td></td><td width="10%">&nbsp;</td>
        </tr>
        <tr>
             <td width="">&nbsp;</td><td width="115px">Materai (Rp.)</td><td width="5px">: </td><td id="materai2" align="right"></td></td><td width="10%">&nbsp;</td>
        </tr>
        <tr>
             <td width="">&nbsp;</td><td style="border-top: 1px solid #cccccc; ">Total Tagihan (Rp.)</td><td width="5px">: </td><td style="border-top: 1px solid #cccccc; " width="110px" id="bayar" align="right"></td>
             <td width="2%">&nbsp;</td>
        </tr>
    </table>
    </div>
<? exit; ?>
