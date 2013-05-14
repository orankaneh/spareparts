<?php
include_once "app/lib/common/functions.php";
include 'app/actions/admisi/pesan.php';
?>
<script type="text/javascript">
  
  $(function() {
      $('#penduduk').focus();
            $('#penduduk').autocomplete("<?= app_base_url('/admisi/search?opsi=kepesertaan_asuransi') ?>",
            {
                        parse: function(data){
                            var parsed = [];
                            for (var i=0; i < data.length; i++) {
                                parsed[i] = {
                                    data: data[i],
                                    value: data[i].penduduk // nama field yang dicari
                                };
                            }
                            return parsed;
                        },
                        formatItem: function(data,i,max){
                            var str='<div class=result>'+data.penduduk+'<br />Alamat: '+data.alamat_jalan+' Kelurahan: '+data.kelurahan+'<br />No. Kunjungan: '+data.id_kunjungan+'</div>';
                            return str;
                        },
                        width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
                function(event,data,formated){
                    $(this).attr('value',data.penduduk);
                    $('#alamat').html(data.alamat_jalan);
                    $('#kelurahan').html(data.kelurahan);
                    $('#idKunjungan').val(data.id_kunjungan);
                    $('#kunjungan').html(data.id_kunjungan);
                    $('#tambahBaris').removeAttr('disabled');
                    $.ajax({
                        url: "<?=app_base_url('admisi/kepesertaan-asuransi-tabel')?>",
                        cache: false,
                        data:'&id='+data.id_kunjungan,
                        success: function(msg){
                            $('.data-list').html(msg);
                        }
                    })
                }
            );
            
            $('#simpan').click(function(){
                 if($('#penduduk').val() == ""){
                   alert("Nama pasien tidak boleh kosong");
                   $("#penduduk").focus();
                   return false;
                 }else if($('#idKunjungan').val() == ""){
                   alert("Pilih nama pasien dengan benar, coba lagi");
                   $("#penduduk").focus();
                   return false;  
                 }

                var jumlahForm=$('.barang_tr').length;
                var i=0;
                var isi=false;
                //alert(jumlahForm);
                for(i=1;i<=jumlahForm+1;i++){
                        if($('#idProdukAsuransi'+i).val()==""){
                            alert('Pilih produk asuransi dengan benar, coba lagi')
                            $('#produkAsuransi'+i).focus();
                            return false;
                        }
                        if($('#noPolis'+i).val()==''){
                            alert('No. Polis tidak boleh kosong');
                            $('#noPolis'+i).focus();
                            return false;
                        }
                        isi=true;
                }
                if(isi == false){
                        alert('Inputan kepesertaan asuransi masih kosong');
                        return false;
                }
                })
    });
    
    function initAsuransi(countAsuransi){
        $('#produkAsuransi'+countAsuransi).autocomplete("<?= app_base_url('/admisi/search?opsi=asuransiProduk') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama_asuransi// nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                var str='<div class=result>'+data.nama_asuransi+' <br/><i><b>'+data.nama_pabrik+'</b> '+data.nama_kelurahan+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama_asuransi);
            $('#idProdukAsuransi'+countAsuransi).val(data.id_asuransi);
        }
    );
    }

  function hapusBarang(count,el){
       var parent = el.parentNode.parentNode;
       parent.parentNode.removeChild(parent);
       var penerimaan=$('.barang_tr');
       var countPenerimaanTr=penerimaan.length;
       for(var i=0;i<countPenerimaanTr;i++){
           $('.barang_tr:eq('+i+')').children('td:eq(0)').html(i+1);
           $('.barang_tr:eq('+i+')').children('td:eq(1)').children('input[type=text]').attr('id', 'produkAsuransi'+(i+1));
           $('.barang_tr:eq('+i+')').children('td:eq(1)').children('input[type=hidden]').attr('id', 'idProdukAsuransi'+(i+1));
           $('.barang_tr:eq('+i+')').children('td:eq(2)').children('input[type=text]').attr('id', 'noPolis'+(i+1));
           $('.barang_tr:eq('+i+')').removeClass('even');
           $('.barang_tr:eq('+i+')').removeClass('odd');
            if((i+1) % 2 == 0){
              $('.barang_tr:eq('+i+')').addClass('even');
            }else{
              $('.barang_tr:eq('+i+')').addClass('odd');
            }
       }
   }
   function hapusKepesertaan(count,el){
       var ok = confirm('Apakah anda yakin akan menghapus data ini?');
       if(!ok){
           return false;
       }else{
           var idKepesertaan = $('#idKepesertaan'+count).val();
           $.ajax({
                url: "<?=app_base_url('admisi/search?opsi=hapus_kepesertaan')?>",
                cache: false,
                data:'&id='+idKepesertaan,
                dataType: 'json',
                success: function(msg){
                    if(!msg.status){
                       alert('Proses penghapusan gagal, data digunakan untuk transaksi lain'); 
                    }else{
                       alert('Data kepesertaan berhasil dihapus'); 
                       var parent = el.parentNode.parentNode;
                       parent.parentNode.removeChild(parent);
                       var penerimaan=$('.barang_tr');
                       var countPenerimaanTr=penerimaan.length;
                       for(var i=0;i<countPenerimaanTr;i++){
                           $('.barang_tr:eq('+i+')').children('td:eq(0)').html(i+1);
                           $('.barang_tr:eq('+i+')').children('td:eq(1)').children('input[type=text]').attr('id', 'produkAsuransi'+(i+1));
                           $('.barang_tr:eq('+i+')').children('td:eq(1)').children('input[type=hidden]').attr('id', 'idProdukAsuransi'+(i+1));
                           $('.barang_tr:eq('+i+')').children('td:eq(2)').children('input[type=text]').attr('id', 'noPolis'+(i+1));
                           $('.barang_tr:eq('+i+')').removeClass('even');
                           $('.barang_tr:eq('+i+')').removeClass('odd');
                            if((i+1) % 2 == 0){
                              $('.barang_tr:eq('+i+')').addClass('even');
                            }else{
                              $('.barang_tr:eq('+i+')').addClass('odd');
                            }
                       }
                    }
                }
            })
      }  
   }
</script>
<h2 class="judul">Kepesertaan Asuransi</h2><?= isset($pesan) ? $pesan : NULL ?>
<form action="<?= app_base_url('admisi/control/kepesertaan-asuransi') ?>" method="POST" onSubmit="return cekForm()">
    <div class="data-input">
        <fieldset>
            <legend>Form Kepesertaan Asuransi</legend>
            <label>Nama Pasien</label><input type="text" name="penduduk" id="penduduk"><span class="bintang">*</span><input type="hidden" name="idKunjungan" id="idKunjungan" />
            <label>No. Kunjungan</label><span style="font-size: 12px;padding-top: 5px;" id="kunjungan"> </span>
            <label>Alamat</label><span style="font-size: 12px;padding-top: 5px;" id="alamat"> </span>
            <label>Kelurahan</label><span style="font-size: 12px;padding-top: 5px;" id="kelurahan"> </span>
        </fieldset>
    </div>
    <input type="button" value="Tambah Baris" id="tambahBaris" class="tombol" style="margin-bottom: 5px;" disabled="disabled"/>
    <br />
    <div class="data-list">
        <table id="tblKepesertaan" class="table-input" style="width: 60%">
            <tr>
                <th style="width: 5%">No</th> 
                <th>Nama Produk Asuransi</th>
                <th>No. Polis</th>
                <th style="width: 10%">Aksi</th>
            </tr>
            <?php
              for($i = 1;$i <= 2;$i++){
            ?>
              <tr class="barang_tr">
                  <td><?= $i?></td>
                  <td align="left"><input type="text" name="produkAsuransi[]" id="produkAsuransi<?= $i?>" style="width: 85%" disabled="disabled" /><span class="bintang2">*</span><input type="hidden" name="idProdukAsuransi[]" id="idProdukAsuransi<?= $i?>" disabled="disabled"/></td>
                  <td><input type="text" name="noPolis[]" id="noPolis<?= $i?>" style="width: 85%" disabled="disabled"/><span class="bintang2">*</span></td>
                  <td><input type="button" class="tombol" value="Hapus" onclick="hapusBarang(<?= $i?>,this)" disabled="disabled"/></td>
              </tr>
              <script type="text/javascript">
                initAsuransi(<?= $i?>);
              </script>
            <?php
              }
            ?>
        </table>
    </div>    
    <div class="field-group">
        <input type="submit" value="Simpan" name="save" class="tombol" id="simpan" />
        <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/kepesertaan-asuransi') ?>'"/>
    </div>
</form>