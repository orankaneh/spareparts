	<?php
    include_once "app/lib/common/master-data.php";
    $pemesanan= sp_muat_data_by_id(get_value('id'));
    $sp=$pemesanan['master'];
?>
<script type="text/javascript">
function initAutocompleteBarang(index) {
	$('#barang'+index).autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>",
	{
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
					var str='<div class=result><b>'+data.nama_barang+'</b> <i>'+data.nilai_konversi+' '+data.satuan_terkecil+'</i><br>                <b>Pabrik :</b><i>'+data.pabrik+'</i></div>';
					return str;
				},
				width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
				dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
	}).result(
		function(event,data,formated){
			var kekuatan=(data.kekuatan!=null)?' '+data.kekuatan:'';
			var sediaan=(data.sediaan!=null)?' '+data.sediaan:'';
			$(this).attr('value',data.nama_barang+kekuatan+sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil);
			$('#idbarang'+index).attr('value',data.id);
			$('#satuan'+index).attr('value',data.satuan_terbesar);
			var sisa=0;
			if(data.sisa!=null){
				sisa=data.sisa;
			}
			$('#sisa'+index).attr('value',sisa);
			$('#idbarang'+index).attr('value',data.id);
		}
	);
}
function hapusBarang(index,iddetail,el){
    if(!confirm('apakah anda yakin akan menghapus data '+$('#barang'+index).attr('value'))){
        return true;
    }
    $.ajax({
            type: "GET",
            url: "<?=  app_base_url('inventory/control/pemesanan/detail-pemesanan-delete')?>",
            data: 'id='+iddetail,
            dataType: 'json',
            success:function(data){
                if(data.status){
                    var parent = el.parentNode.parentNode;
                    parent.parentNode.removeChild(parent);
                    var jumlah=$('.number').length;
                    for(var i=0;i<=jumlah;i++){
                        $(".number:eq("+i+")").html(i+1);
						if((i+1)% 2 == 1){
								$('.pesanan_ed:eq('+(i-1)+')').addClass('even');
						}else{
								$('.pesanan_ed:eq('+(i-1)+')').addClass('odd');
						}
                    }
                }
            }
    });
    
}
$(function() {
        $('#suplier').autocomplete("<?= app_base_url('/inventory/search?opsi=suplier') ?>",
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
                var str='<div class=result>'+data.nama+' <br/><i> '+data.alamat+' , '+data.nama_kelurahan+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#suplier').attr('value',data.nama);
                $('#idsuplier').attr('value',data.id);
            }
        );
});

$(document).ready(function(){
	$("#tambahBaris").click(function(){
		
		var barang = 'barang'+counter,
		satuan = 'satuan'+counter,
		sisa = 'sisa'+counter,
		rop = 'rop'+counter;
		var number=$('.pesanan_ed').length+1;
		
		string = "<tr class='pesanan_ed' id='length'>"+
				"<td align=center class=number>"+number+"</td><td align=center>"+
				"<input type=text name=barang["+number+"][nama] id=barang"+number+" class=auto style='width:90%'/>"+
				"<input type=hidden name=barang["+number+"][idbarang] id=idbarang"+number+" class=auto /></td>"+
				"<td align=center><input type=text name=barang["+number+"][jumlah] id=jumlah"+number+" class=auto onKeyup='Angka(this)'/></td>"+
				"<td align=center><input type=text name=barang["+number+"][satuan] id=satuan"+number+" class=auto disabled/></td>"+
				"<td align=center><input type=text name=barang["+number+"][sisaStok] id=sisa"+number+" onKeyup='Angka(this)' class=auto/></td>"+
				"<td align=center><input type=text name=barang["+number+"][rop] id=satuan"+number+" readonly class=auto /></td>"+
				"<td align=center><input type='button' class='tombol' value='Hapus' onclick='hapusBarang(this)'></td>"+
				"</tr>";
		$("#tblPemesanan").append(string);
		
		if(number % 2 == 1){
				$('.pesanan_ed:eq('+(number-1)+')').addClass('even');
        }else{
				$('.pesanan_ed:eq('+(number-1)+')').addClass('odd');
        }
			
	$('#barang'+number).autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>",
	{
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
			var str='<div class=result><b>'+data.nama_barang+'</b> <i>'+data.nilai_konversi+' '+data.satuan_terkecil+'</i><br><b>Pabrik :</b><i>'+data.pabrik+'</i></div>'+data.id;
			return str;
		},
		width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
		dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
		}).result(
		function(event,data,formated){
			var kekuatan=(data.kekuatan!=null)?' '+data.kekuatan:'';
			var sediaan=(data.sediaan!=null)?' '+data.sediaan:'';
			$(this).attr('value',data.nama_barang+kekuatan+sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil);
			$('#idbarang'+number).attr('value',data.id);
			$('#satuan'+number).attr('value',data.satuan_terbesar);
			var sisa=0;
			if(data.sisa!=null){
				sisa=data.sisa;
			}
			$('#sisa'+number).attr('value',sisa);
		}
	);
	});
        
        $("input[name=save]").click(function(event){
            var i=0;
            event.preventDefault();
            
            $(".auto").each(function(){
            if(this.id.match(/idbarang.*/)&&this.value==''){
                if($(this).prev().val()==''){
                    alert('Barang masih kosong');               
                }else{
                    alert('Barang tersebut tidak ada');
                }
                i=i+1;
                $(this).prev().focus();
                return false;
            }else if(this.id.match(/jumlah.*/)&&this.value==''){
                alert('Jumlah masih kosong');
                i=i+1;
                $(this).focus();
                return false;

            }

        });
            
            if(i<=0){
                $("input[name=save]").unbind("click").click();
            }
        })
})     
</script>
<?
include 'app/actions/admisi/pesan.php';
set_time_zone();
$date=Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$no=  _select_arr("select id from pemesanan order by id desc limit 0,1");
$noSurat=isset($no[0]['id'])?$no[0]['id']:0+1;
?>
<form action="<?=  app_base_url('inventory/control/pemesanan/pemesanan-update')?>" method="post">
<h2 class="judul">Edit Pemesanan</h2><?echo isset($pesan)?$pesan:NULL;?>
<div class="data-input">
    <fieldset>
        <legend>Pemesanan Barang ke Suplier</legend>
        <label for="no-surat">No. Surat</label><input type="text" name="nosurat" value="<?=$sp['id']?>" readonly>
        <label for="awal">Tanggal</label><input type="text" name="tanggal" id="awal" class="tanggal" value="<?=  datefmysql($sp['tanggal'])?>"/>
        <label for="suplier">Suplier</label><input type="text" name="suplier" id="suplier" value="<?=$sp['suplier']?>"/><input type="hidden" name="idsuplier" id="idsuplier" value="<?=$sp['id_suplier']?>"/>
        <label for="jenis">Jenis SP</label><select name="jenis"><option value="">pilih jenis Sp</option>
            <option value="Umum" <?=($sp['jenis_sp']=='Umum')?'selected':''?>>Umum</option>
            <option value="Narkotik" <?=($sp['jenis_sp']=='Narkotik')?'selected':''?>>Narkotika</option>
            <option value="Psikotropik" <?=($sp['jenis_sp']=='Psikotropik')?'selected':''?>>Psikotropika</option>
        </select>
    </fieldset>
</div>
<input type="button" value="Tambah Baris" id="tambahBaris" class="tombol" style="margin-bottom: 5px;">
<br>
<table id="tblPemesanan" class="table-input">
    <tr style="background: #F4F4F4;">
        <th style="width:5%">No</th>
        <th style="width: 30%">Nama Barang</th>
        <th style="width:13%">Jumlah</th>
        <th>Kemasan</th>
        <th style="width:13%">Sisa Stok</th>
        <th style="width:13%">ROP</th>
        <th style="width:13%">Aksi</th>
    </tr>
    
    <?php $i=1;
        foreach ($pemesanan['barang'] as $barang) { 
            $kekuatan = isset ($barang['kekuatan']) && isset ($barang['sediaan'])?' '.$barang['kekuatan']:'';
            $sediaan = isset ($barang['sediaan'])?' '.$barang['sediaan']:'';
    ?>
            <tr class="pesanan_ed <?= ($i%2)?'even':'odd' ?>">
            <td align="center" class="number"><?= $i ?>
			<input type="hidden" name="barang[<?=$i?>][iddetail]" value="<?=$barang['id_detail']?>"></td>
            <td align="center">
			<input type="text" name="barang[<?=$i?>][nama]" id="barang<?= $i ?>" class="auto" value="<?=$barang['nama_barang'].''.$kekuatan.''.$sediaan.' @'.$barang['nilai_konversi'].' '.$barang['satuan_terkecil']?>" style="width:90%"/>
            <input type="hidden" name="barang[<?=$i?>][idbarang]" id="idbarang<?= $i ?>" class="auto" value="<?=$barang['id_packing']?>"/></td>
            <td align="center">
			<input type="text" name="barang[<?=$i?>][jumlah]" id="jumlah<?= $i ?>" class="auto" onKeyup="Angka(this)" value="<?=$barang['jumlah_pesan']?>"/></td>
            <td align="center">
			<input type="text" name="barang[<?=$i?>][satuan]" id="satuan<?=$i?>" class="auto" value="<?=$barang['satuan_terbesar']?>" disabled/></td>
            <td align="center">
			<input type="text" name="barang[<?=$i?>][sisaStok]" id="sisa<?=$i?>" class="auto" value="<?=$barang['sisa']?>" onKeyup="Angka(this)"/></td>
            <td align="center">
			<input type="text" name="barang[<?=$i?>][rop]" id="satuan<?= $i ?>" readonly class="auto" /></td>
            <td align="center">
            <input type="button" class="tombol" value="Hapus" onclick="hapusBarang(<?=$i?>,<?=$barang['id_detail']?>,this)">
            </td>
            </tr>
            
			<script type="text/javascript">
                    initAutocompleteBarang(<?=$i?>);
            </script>

    <?php $i++;} ?>
</table>
  <div class="field-group"> 
      <input type="submit" value="Simpan" name="save" class="tombol" />
      <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/info-pemesanan') ?>'" />
 </div>     
</form>