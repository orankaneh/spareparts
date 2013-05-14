<h2 class="judul">Penjualan Obat & Resep</h2>
<?php
	require 'app/lib/common/master-inventory.php';
	require 'app/lib/common/master-data.php';
	$aturan_pakai 	= aturan_pakai_muat_data();
	$embalage		= embalage_muat_data();
	$new_resep		= resep_auto_increment();
	$kelas			= kelas_muat_data();
	
	foreach($new_resep as $rowA);
	$baru = (isset($rowA['new_numb'])?$rowA['new_numb']:null);
?>
<script type="text/javascript">

//form autocomplete bagian isi atas  form autocomplete bagian isi atas  form autocomplete bagian isi atas  form autocomplete bagian isi atas  ... 
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
        $('#tmppraktek').autocomplete("<?= app_base_url('/inventory/search?opsi=tmppraktek') ?>",
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
                        var str='<div class=result><b>'+data.nama+'</b></div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
           }).result(
            function(event,data,formated){
                $(this).attr('value',data.nama);
                $('#idtmppraktek').attr('value',data.id);
        });
        $('#nama').autocomplete("<?= app_base_url('/admisi/search?opsi=nama') ?>",
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
                
                    $('#norm').attr('value',data.id_pasien);
                    $(this).attr('value',data.nama_pas);
                    $('#idpenduduk').attr('value',data.id_penduduk);
                
            }
        );

        $('#norm').autocomplete("<?= app_base_url('/admisi/search?opsi=noRm') ?>",
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
                    $(this).attr('value',data.id_pasien);
                    $('#nama').attr('value',data.nama_pas);
                    $('#idpenduduk').attr('value',data.id_penduduk);
            }
        );
});
//sing ngo addnew row barang.. sing ngo addnew row barang.. sing ngo addnew row barang.. sing ngo addnew row barang.. sing ngo addnew row barang.. sing ngo addnew row barang..(single add)

counter = 1;
barisdata = 1;
function deleteMe(count,el){
            
            var parent = el.parentNode.parentNode;
            parent.parentNode.removeChild(parent);
			var penjualan=$('.barang_tr');
			  var countPenjualanTr=penjualan.length;
			  for(var i=0;i<countPenjualanTr;i++){
				  $('.barang_tr:eq('+i+')').children('td:eq(0)').html(i+1);
			  }
            counter --;
			barisdata --;
            
}
$(function() {
	
	$("#addnewrow").click(function(){
			
			kelas = $("#idkelas").val();
			
			string = "<tr class='barang_tr'>" + 
			" <td align=center>"+barisdata+"</td>" + 
			" <td align=center><input type=text name=databarang"+counter+" id=databarang"+counter+" value=databarang"+counter+" autocomplete=off class=autocpl /> " + 
				" <input type=hidden name=iddatabarang"+counter+" id=iddatabarang"+counter+" class=iddatabarangs /></td> " + 
			" <td><input type=text name=kekuatan"+counter+" style=border:none; /></td> " + 
			" <td><input type=text name=jmlh"+counter+" id=jmlh"+counter+" onKeyup='Angka(this)' class=input-dialog /> " + 
				" <input type=hidden name=idpacking"+counter+" id=idpacking"+counter+" class=packing /></td> " + 
			" <td><select name=aturpakai"+counter+"><option value=''>Pilih aturan pakai ..</option> " +
			" <?php foreach($aturan_pakai as $row) { ?> <option value='<?= $row['id'] ?>'><?= $row['nama'] ?></option> <?php } ?></select></td> " +
			" <td><input type=text name=harga"+counter+" id=harga"+counter+" class=input-dialog /></td> " +
			" <td><input type=text readonly style=border:none; name=detur /></td> " + 
			" <td><input type=text readonly style=border:none; name=tebus /></td> " +
			" <td><input type=text readonly style=border:none; name=subtotal"+counter+" id=subtotal"+counter+" /></td> " +
			" <td align=center><input name=absah"+counter+" type=checkbox checked /></td> " +
			" <td align=center><input type=text name=jmldata value="+barisdata+" /> " +
				" <input type=button value=X onClick='deleteMe("+counter+",this)' title=Delete class=tombol /></td> " +
			" </tr>";

			$("#penjualan-resep").append(string);
				
				$('#databarang'+counter).autocomplete("<?= app_base_url('/inventory/search?opsi=barang-resep') ?>&kelas="+kelas,
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
							var str='<div class=result><b>'+data.nama+' '+data.nilai_konversi+' '+data.satuan_kecil+'</b><br/> '+data.pabrik+' <br/>Kelas: '+data.kelas+'</div>';
							return str;
					},
					width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
					dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
				}).result(
				function(event,data,formated) {
					$(this).attr('value',data.nama);
					var tr=$(this).parent('td').parent('tr');
					tr.children('td:eq(1)').children('.iddatabarangs').attr('value',data.id);
					tr.children('td:eq(2)').children('input').attr('value',data.kekuatan);
					tr.children('td:eq(5)').children('input').attr('value',data.harga);
					tr.children('td:eq(3)').children('.packing').attr('value',data.id_packing);
				});
				
				$("#jmlh"+counter).keyup(function() {
					var tr=$(this).parent('td').parent('tr');
					var hrg = parseInt(tr.children('td:eq(5)').children('input').val());
					var jml = parseInt(tr.children('td:eq(3)').children('.input-dialog').val());
					var subtotal = jml * hrg;
					tr.children('td:eq(8)').children('input').attr('value',subtotal);
				});
			barisdata++;	
			counter++;
		
	});
});

        arrays = 1;
        number  = 0;
        list = 1;
        function hapusBarang(count,el){
		
            var parent = el.parentNode.parentNode; 
			var tr=$(this).parent('td').parent('tr');
            parent.parentNode.removeChild(parent);
			var penjualan=$('.barang_tr_wd');
			var countPenjualanTr=penjualan.length;
			for(var i=0;i<countPenjualanTr;i++){
				$('.barang_tr_wd:eq('+i+')').children('td:eq(0)').html(i+1);

				$('.barang_tr_wd:eq('+i+')').children('td:eq(1)').children('.brg').removeAttr('name');
				$('.barang_tr_wd:eq('+i+')').children('td:eq(1)').children('.brg').removeAttr('id');
				$('.barang_tr_wd:eq('+i+')').children('td:eq(1)').children('.idbrg').removeAttr('name');
				$('.barang_tr_wd:eq('+i+')').children('td:eq(1)').children('.idbrg').removeAttr('id');
				$('.barang_tr_wd:eq('+i+')').children('td:eq(1)').children('.packing').removeAttr('name');
				$('.barang_tr_wd:eq('+i+')').children('td:eq(1)').children('.packing').removeAttr('id');
				
				$('.barang_tr_wd:eq('+i+')').children('td:eq(2)').children('.power').removeAttr('name');
				$('.barang_tr_wd:eq('+i+')').children('td:eq(2)').children('.power').removeAttr('id');
				
				$('.barang_tr_wd:eq('+i+')').children('td:eq(3)').children('.racikan').removeAttr('name');
				$('.barang_tr_wd:eq('+i+')').children('td:eq(3)').children('.racikan').removeAttr('id');
				$('.barang_tr_wd:eq('+i+')').children('td:eq(3)').children('.numb').removeAttr('name');
				$('.barang_tr_wd:eq('+i+')').children('td:eq(3)').children('.numb').removeAttr('id');
				
				$('.barang_tr_wd:eq('+i+')').children('td:eq(4)').children('.jumlah').removeAttr('name');
				$('.barang_tr_wd:eq('+i+')').children('td:eq(4)').children('.jumlah').removeAttr('id');
				
				$('.barang_tr_wd:eq('+i+')').children('td:eq(5)').children('.price').removeAttr('name');
				$('.barang_tr_wd:eq('+i+')').children('td:eq(5)').children('.price').removeAttr('id');
				
				$('.barang_tr_wd:eq('+i+')').children('td:eq(5)').children('.sinput-dialog').removeAttr('name');
				$('.barang_tr_wd:eq('+i+')').children('td:eq(5)').children('.sinput-dialog').removeAttr('id');

			}
			
			for(var i=0;i<countPenjualanTr;i++){	
				$('.barang_tr_wd:eq('+i+')').children('td:eq(1)').children('.brg').attr('name','barang'+(i+1));
				$('.barang_tr_wd:eq('+i+')').children('td:eq(1)').children('.brg').attr('id','barang'+(i+1));
				$('.barang_tr_wd:eq('+i+')').children('td:eq(1)').children('.idbrg').attr('name','idbarang'+(i+1));
				$('.barang_tr_wd:eq('+i+')').children('td:eq(1)').children('.idbrg').attr('id','idbarang'+(i+1));
				$('.barang_tr_wd:eq('+i+')').children('td:eq(1)').children('.packing').attr('name','idpack'+(i+1));
				$('.barang_tr_wd:eq('+i+')').children('td:eq(1)').children('.packing').attr('id','idpack'+(i+1));
				
				$('.barang_tr_wd:eq('+i+')').children('td:eq(2)').children('.power').attr('name','power'+(i+1));
				$('.barang_tr_wd:eq('+i+')').children('td:eq(2)').children('.power').attr('id','power'+(i+1));
				
				$('.barang_tr_wd:eq('+i+')').children('td:eq(3)').children('.racikan').attr('name','racikan'+(i+1));
				$('.barang_tr_wd:eq('+i+')').children('td:eq(3)').children('.racikan').attr('id','racikan'+(i+1));
				$('.barang_tr_wd:eq('+i+')').children('td:eq(3)').children('.numb').attr('name','numb');
				$('.barang_tr_wd:eq('+i+')').children('td:eq(3)').children('.numb').attr('id','numb');
				
				$('.barang_tr_wd:eq('+i+')').children('td:eq(4)').children('.jumlah').attr('name','jumlah'+(i+1));
				$('.barang_tr_wd:eq('+i+')').children('td:eq(4)').children('.jumlah').attr('id','jumlah'+(i+1));
				
				$('.barang_tr_wd:eq('+i+')').children('td:eq(5)').children('.price').attr('name','price'+(i+1));
				$('.barang_tr_wd:eq('+i+')').children('td:eq(5)').children('.price').attr('id','price'+(i+1));
				
				$('.barang_tr_wd:eq('+i+')').children('td:eq(5)').children('.sinput-dialog').attr('name','hargahide'+(i+1));
				$('.barang_tr_wd:eq('+i+')').children('td:eq(5)').children('.sinput-dialog').attr('id','hargahide'+(i+1));
				
			}
            arrays--;
			number--;
			
			h_result = 0; //untuk menghitung ulang jumlah sub total dan total harga 
			for(var j=1;j<countPenjualanTr+1;j++){
				h_result = h_result + parseInt($('#price'+j).val());
			}
			
			$('#subtotal').attr('value',h_result);
			total = $('#embalage').val() + $('#subtotal').val();
			
			$('#totalharga').attr('value', total);
        }

$(function() {
		
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
        var name = $( "#barang1" ),
                kekuatan = $( "#kekuatan1" ),
                allFields = $( [] ).add( name ).add( kekuatan )
                tips = $( ".validateTips" );      
		        
		subtotal= 0;
		$("#tambahBaris").click(function(){
				
                string = "<tr class='barang_tr_wd'>" + 
				" <td align=center>"+arrays+"</td> " + 
				" <td align=center><input type=text name=barang"+arrays+" id=barang"+arrays+" value=barang"+arrays+" autocomplete=off class=brg /> " +
					" <input type=hidden name=idbarang"+arrays+" id=idbarang"+arrays+" class=idbrg autocomplete=off /> " +
					" <input type=hidden name=idpack"+arrays+" id=idpack"+arrays+" autocomplete=off class=packing /></td> " +
				" <td><input type=text name=power"+arrays+" id=power"+arrays+" class=power style='border:none;' readonly /></td> " +
				" <td><input type=text name=racikan"+arrays+" id=racikan"+arrays+" class=racikan /> " +
					" <input type=hidden name=numb id=numb value="+arrays+" class=numb /></td> " + 
				" <td><input type=text name=jumlah"+arrays+" id=jumlah"+arrays+" class=jumlah style='border:none;' readonly /></td> " +
				" <td><input type=text name=price"+arrays+" id=price"+arrays+" class=price style=border:none; readonly /> " + 
					" <input type=hidden name=hargahide"+arrays+" id=hargahide"+arrays+" class=sinput-dialog /></td> " +
				" <td><input type=button value=Delete onClick='hapusBarang("+arrays+",this)' class=tombol /></td> " +
				" </tr>";

                
                $("#penjualan").append(string);
                    kelas = $('#idkelas').val();
                    $('#barang'+arrays).autocomplete("<?= app_base_url('/inventory/search?opsi=barang-resep') ?>&kelas="+kelas,
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
							var str='<div class=result><b>'+data.nama+' '+data.nilai_konversi+' '+data.satuan_kecil+'</b><br/> '+data.pabrik+' <br/>Kelas: '+data.kelas+'</div>';
							return str;
						},
						width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
						dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
					}).result(
                        function(event,data,formated) {
                            $(this).attr('value',data.nama);
							var jum = $('#jml').val();
                            var tr=$(this).parent('td').parent('tr');
                            tr.children('td:eq(1)').children('.idbarang').attr('value',data.id);
							tr.children('td:eq(1)').children('.packing').attr('value',data.id);
                            tr.children('td:eq(2)').children('.power').attr('value',data.kekuatan);
                            tr.children('td:eq(3)').children('.racikan').attr('value',data.racikan);
                            tr.children('td:eq(5)').children('.price').attr('value',data.harga*jum);
                            tr.children('td:eq(5)').children('.sinput-dialog').attr('value',data.harga);
							
							var penjualan=$('.barang_tr_wd');
							var countPenjualanTr=penjualan.length;
							h_result = 0;
							
							for (j = 1; j <= countPenjualanTr; j++) {
								h_result = (h_result * 1) + parseInt($('#price'+j).val());
							}
							
							$('#subtotal').attr('value',h_result);
							total = $('#embalage').val() + $('#subtotal').val();

							$('#totalharga').attr('value', total);
							
					});
					
                $("#racikan"+arrays).keyup(function() {
                        var tr=$(this).parent('td').parent('tr');
                        var kekuatan= 'kekuatan'+counter,
                        racikan = 'racikan'+counter,
                        jumlah  = 'jumlah'+counter;
                        var jml = parseInt(document.formdialog.jml.value),
                        kekuatan = parseInt(tr.children('td:eq(2)').children('.input-dialog').val()),
                        racikan = parseInt(tr.children('td:eq(3)').children('.input-dialog').val()),
                        harga = parseInt(tr.children('td:eq(5)').children('.sinput-dialog').val()),
                        hasil = Math.round((jml * kekuatan) / racikan);
                        newharga = jml * harga;
                        tr.children('td:eq(4)').children('.input-dialog').attr('value',hasil);
                        tr.children('td:eq(5)').children('.input-dialog').attr('value',newharga);
                        
                });
				
				number++;
				arrays++;
				list++;
                });
                no = 2;
		
		$( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 500,
			width: 880,
			modal: true,
			buttons: {
				"Simpan": function() {
						var bValid = true;
						allFields.removeClass( "ui-state-error" );
							
						  var testArray = new Array();
						  var Aarray = new Array();
						  begin = (barisdata + 1);
						  end	= (barisdata + number);
							var penjualan1=$('.barang_tr');
							var countPenjualanTr1=penjualan1.length;
							
							var penjualan2=$('.barang_tr_wd');
							var countPenjualanTr2=penjualan2.length;
							
							var arr_list = 1;
							for (i = barisdata; i <= (barisdata + countPenjualanTr2) - 1; i++) {
								var barang = $('#barang'+arr_list).val();
								var idbarang = $('#idbarang'+arr_list).val();
								var packing = $('#idpack'+arr_list).val();
								//testArray[i] = $('#barang'+i).val();
								testArray[i] = "<input name=barang"+i+" id=barang"+i+" type=text style=margin-bottom:2px readonly value=databarang"+i+" /> " +
								" <input type=text name=iddatabarang"+i+" id=iddatabarang"+i+" value="+idbarang+" /> " +
								" <input type='text' name='idpacking"+i+"' id='idpacking"+i+"' value='"+packing+"' class=packing' />";
							arr_list ++;	
							}
							hasil = testArray.join('');
							
							var arr_list = 1;
							for (i = barisdata + 1; i <= (barisdata + countPenjualanTr2); i++) {
								var kekuatan = $('#power'+arr_list).val();
								Aarray[i] = "<input type='text' name='kekuatan"+i+"' id='kekuatan"+i+"' value='"+kekuatan+"' style='padding-bottom:2px; border:none;' />";
								arr_list ++;	
							}
							power = Aarray.join('');


							var bungkus = $('#jml').val();
							var aturpakai = new Array();
							<?php
							$li = 1;
							foreach($aturan_pakai as $key => $data) { ?>
								aturpakai[<?= $li ?>] = "<option value='<?= $data['id'] ?>'><?= $data['nama'] ?></option>";
							<?php 
							$li += 1;
							}
							?>
							var aturanpakai = aturpakai.join('');
							var raciksubttl = $('#subtotal').val();
							
						if ( bValid ) {
							$( "#penjualan-resep" ).append( "<tr>" +
								"<td align=center>" + barisdata + "</td>" +
								"<td>" + hasil + "</td>" +
								"<td>" + power + "</td>" +
								"<td><input type=text name=jmlh"+ no++ +" id=jmlh"+ no++ +" value="+bungkus+" /></td>" +
								"<td><select name=aturpakai"+ no++ +" id=aturpakai"+ no++ +"> " + 
									" <option value=''>Pilih aturan pakai ..</option>" +aturanpakai+ "</select></td>" +
								"<td><input type=text name=harga"+begin+" id=harga"+begin+" /></td>" +
								"<td><input type=text name=detur"+begin+" id=detur"+begin+" style='border:none;' /></td>" +
								"<td><input type=text name=tebus"+begin+" id=tebus"+begin+" style='border:none;' /></td>" +
								"<td><input type=text name=subtotal"+begin+" id=subtotal"+begin+" value="+raciksubttl+" /></td>" +
								"<td align=center><input type=checkbox name=absah value=1 checked /></td>" +
								"<td align=center>" +
								"<input type=button onClick=hapusBarang("+begin+",this) value='X' class=tombol /></td>" +
							"</tr>" );
							$('#aturpakai').attr('value', aturanpakai);
							$( this ).dialog( "close" );
							$('#penjualan .tbody').html('');
							barisdata = barisdata+1;
							arrays = barisdata+countPenjualanTr2;
							alert(arrays);
							number = 0;
						}
						$('.input-dialog').val('');
				},
				Cancel: function() {
						$('.input-dialog').val('');
						$( this ).dialog( "close" );
						$('#penjualan .tbody').html('');
						arrays = 1;
						number = 0;
				}
			},
			close: function() {
				$('.input-dialog').val('');
				$('#penjualan .tbody').html('');
				arrays = 1;
				number = 0;
				allFields.val( "" ).removeClass( "ui-state-error" );
			}

		});

			$( "#create-user" )
			.button()
			.click(function() {
				$( "#dialog-form" ).dialog( "open" );
			});
	});

</script>

<style type="text/css">

		input.text { margin-bottom:12px; width:95%; padding: .4em; }
		fieldset { padding:0; border:0; margin-top:25px; }

		div#users-contain { width: 100%; margin: 20px 0; }

</style>
<form action="<?= app_base_url('inventory/control/penjualan-resep') ?>" method="post" name="fomname" >
<div class="data-input">
    
<fieldset><legend>Penjualan Obat & Resep</legend>
	<table width="100%">
		<tr><td width="15%">Petugas</td><td></td><td><?= $_SESSION['nama'] ?></td></tr>
		<tr><td width="15%">Tgl Transaksi</td><td></td><td><input type="text" name="transaksi" id="tanggal" value="<?= date("d/m/Y") ?>" style="min-width:1em;" /></td></tr>
		<tr><td width="15%">No. Resep</td><td></td><td><input type="text" name="noresep" id="noresep" value="<?php if ($baru == null) echo "1"; else echo "$baru"; ?>" readonly /></td></tr>
		<tr><td width="15%">Nama Dokter</td><td></td><td><input type="text" name="dokter" id="dokter" /><input type="hidden" name="iddokter" id="iddokter" /></td></tr>
		<tr><td width="15%">SIP Dokter</td><td></td><td><input type="checkbox" name="sipdokter" id="smipdokter" /></td></tr>
		<tr><td width="15%">Alamat</td><td></td><td><input type="checkbox" name="alamat" id="alamat" /></td></tr>
		<tr><td width="15%">Paraf</td><td></td><td><input type="checkbox" name="paraf" id="paraf" /></td></tr>
		<tr><td width="15%">Tempat Praktek</td><td></td><td><input type="text" name="tmppraktek" id="tmppraktek" /><input type="hidden" name="idtmppraktek" id="idtmppraktek" /></td></tr>
		<tr><td width="15%">Tgl Resep</td><td></td><td><input type="text" name="tglresep" value="<?= date("d/m/Y") ?>" id="awal" style="min-width:1em;" /></td></tr>
		<tr><td width="15%">Nomer RM</td><td></td><td><input type="text" name="norm" id="norm" /></td></tr>		
		<tr><td width="15%">Nama Pasien / Pembeli</td><td></td><td><input type="text" name="nama" id="nama" /><input type="hidden" name="idpenduduk" id="idpenduduk" /></td></tr>
		<tr><td width="15%">Kelas</td><td></td><td><select name='kelas' id='idkelas'><option value="">Pilih Kelas ..</option>
		<?php
			foreach($kelas as $rowB) { ?>
			<option value="<?= $rowB['id'] ?>"><?= $rowB['nama'] ?></option>
			<?php }
		?></select></td></tr>
		<tr class="field-group">
			<td width="15%">Umur</td><td></td><td><input type="checkbox" name="umur" id="umur" style="float:left;" />  <span>&nbsp; &nbsp; &nbsp; &nbsp;Berat Badan</span>&nbsp;
			<input type="checkbox" name="berat" id="berat" /></td>
		</tr>
		<tr>
			<td></td><td></td><td><input type="button" class="tombol" id="addnewrow" value="Tambah R/ Tunggal"> <input type="button" id="create-user" class=tombol value="Tambah R/ Racik" /></td>
		</tr>
	</table>
</fieldset>
</div>
<table width="100%" id="penjualan-resep" class="tabel" cellspacing=0>
	<tr style="background: #F4F4F4; height:20px; white-space:nowrap;" cellspacing=0>
		<th>No. R/</th>
		<th>Nama Barang</th>
		<th>Kekuatan</th>
		<th>Jml</th>
		<th>Aturan Pakai</th>
		<th>Harga (Rp)</th>
		<th>Detur</th>
		<th>Tebus</th>
		<th>Sub Total</th>
		<th>Syah / Tidak</th>
		<th>Aksi</th>
	</tr>
</table>
    <div style="margin: 0.2em 0em 7em 0.2em;">
        <input type="submit" name="saveresep" value="  Simpan  " class="tombol" />
    </div>
    
</form>
<div class="demo">
        <script type="text/javascript">
        
            $(function() {
				$('#jml').keyup(function() {
					var jml = parseInt(document.formdialog.jml.value);
					
					for (j = 1; j <= number; j++) {
						var hrg = parseInt($('#hargahide'+j).val());
						var newhrg = hrg * jml;
						$('#price'+j).attr('value',newhrg);
					}
					h_result = 0;
                    for (j = 1; j <= number; j++) {
                        h_result = h_result + parseInt($('#price'+j).val());
                    }
					
                    $('#subtotal').attr('value',h_result);
					total = $('#embalage').val() + $('#subtotal').val();
					$('#totalharga').attr('value', total);
					
				});
                $('#embalage').keyup(function() {
                    h_result = 0;
                    for (j = 1; j <= number; j++) {
                        h_result = h_result + parseInt($('#price'+j).val());
                    }
                    $('#subtotal').attr('value',h_result);
					if ($('#embalage').val() == '') {
						$('#totalharga').attr('value', h_result);
					} else {
						total = parseInt($('#embalage').val()) + parseInt($('#subtotal').val());
						$('#totalharga').attr('value', total);
					}
                });
             });
        </script>
<div id="dialog-form" title="Form Tambah Obat">
   
<p class="validateTips">Isikan nama obat dan Kekuatan</p>

<form name="formdialog">
Jumlah Bungkus &nbsp; <input type="text" name="jml" id="jml" class=input-dialog /> <input type="button" class="tombol" value="Tambah baris" id="tambahBaris">
<fieldset>

	<table id="penjualan" class="ui-widget ui-widget-content" style="width:100%;" cellspacing=0>
	<thead>
		<tr class="ui-widget-header">
		<th>No</th><th>Nama Obat</th>
		<th>Kekuatan</th><th>Kekuatan Racikan</th>
		<th>Jumlah</th><th>Harga (Rp)</th><th>Aksi</th>
		</tr>
	</thead>
	<tbody class="tbody"></tbody>
	<tbody>
		<tr><td colspan="4"></td><td>Sub Total</td><td><input type="text" name="subtotal" id="subtotal" style="border:none;" readonly="readonly" class="input-dialog" /></td></tr>
		<tr><td colspan="4"></td><td>Embalage</td><td><input type="text" name="embalage" id="embalage" class="input-dialog" /></td></tr>
		<tr><td colspan="4"></td><td>Total Harga R/</td><td><input type=text name="totalharga" id="totalharga" style="border:none;" class="input-dialog" readonly></td></tr>
	</tbody>
</table>
</fieldset>
</form>
</div>
</div>