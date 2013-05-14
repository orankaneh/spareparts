<?php
  set_time_zone();
  $date=Date('d').'/'.Date('m').'/'.(2000+Date('y'));
?>
<script type="text/javascript">
    $(function() {
        $('#pembeli').autocomplete("<?= app_base_url('/inventory/search?opsi=penduduk') ?>",
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
                        var str='<div class=result>'+data.nama+' <br/> <i>'+data.alamat_jalan+'</i></div>';
                        
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
               $(this).attr('value',data.nama);
               $('#idPembeli').attr('value',data.id);
               $('#alamat').attr('value',data.alamat_jalan);
            }
        );
});
</script>    
<script>
    $(document).ready(function(){
        $('#tambahBaris').click(function(){
            var counter = $('.obat_tr').length+1,
            string = "<tr class='obat_tr'>\n\
                      <td align='center'>"+counter+"</td>\n\
                      <td align='center'><input type='text' name='obat[]' id='barang"+counter+"'></td>\n\
                      <td align='center'><input type='text' name='jumlah[]'></td>\n\
                      <td align='center'></td>\n\
                      <td align='center'><input type='text' name='embalage[]'></td>\n\
                      <td align='center'></td>\n\
                      <td align='center'><button onClick='hapusBarang("+counter+",this)' class='del'>X</button></td>";
                                  
           $('#tblPenjualan').append(string);  
           $('#barang'+counter).autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>",
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
                        var str='<div class=result><b>'+data.nama_barang+'</b><br /><i>Satuan:</i> '+data.satuan+' <i>Kemasan</i>: '+data.kemasan+' <br/><i>Macam:</i> '+data.macam_barang+'</div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
           }).result(
            function(event,data,formated){
                $(this).attr('value',data.nama_barang);
                $('#idbarang'+counter+'').attr('value',data.id);
            });
        });
        })
    function hapusBarang(count,el){
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var penerimaan=$('.obat_tr');
        var countPenerimaanTr=penerimaan.length;
        for(var i=0;i<countPenerimaanTr;i++){
            $('.obat_tr:eq('+i+')').children('td:eq(0)').html(i+1);
        }
    }
</script>
<h2 class="judul">Penjualan Obat Bebas</h2>
<div class="data-input">
    <fieldset>
        <legend>Form Penjualan Obat Bebas</legend>
        <label for="petugas">Petugas</label><input type="text" value="<?= $_SESSION['nama'] ?>" disabled />
        <label for="tanggal">Tanggal</label><input type="text" name="tanggal" id="tanggal"  value="<?= $date?>"/>
        <label for="pembeli">Pembeli</label><input type="text" id="pembeli"  /><input type="hidden" id="idPembeli"  name="idPembeli"/>
        <label for="alamat">Alamat</label><input type="text" name="alamat" id="alamat"  />
    </fieldset>
</div>
<input type="button" value="Tambah Baris" id="tambahBaris" class="tombol" style="margin-bottom: 5px;">
<form action="<?=  app_base_url('inventory/control/penjualan-obat-bebas')?>" method="post">
<table width="60%" style="border: 1px solid #f4f4f4; float: left" id="tblPenjualan">
    <tr style="background: #F4F4F4;">
        <th>No</th>
        <th>Nama Obat</th>
        <th>Jumlah</th>
        <th>Harga</th>
        <th>Embalage</th>
        <th>Sub Total</th>
        <th>Hapus</th>
    </tr>
    <script type="text/javascript">
$(function() {
    $('#barang1').autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>",
    {
        parse: function(data){
            var parsed = [];
            for (var i=0; i < data.length; i++) {
                parsed[i] = {
                    data: data[i],
                    value: data[i].sub_macam // nama field yang dicari
                };
            }
            return parsed;
        },
        formatItem: function(data,i,max){
             var str='<div class=result><b>'+data.nama_barang+'</b><br /><i>Satuan:</i> '+data.satuan+' <i>Kemasan</i>: '+data.kemasan+' <br/><i>Macam:</i> '+data.macam_barang+'</div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
    }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama_barang);
            $('#idbarang1').attr('value',data.id);
        });
});
</script>
<script type="text/javascript">
    function hitungTotal(no){
        if($("#total_"+no).val()!=null || $("#total_"+no).val()!=""){
            tot=tot-($("#total_"+no).val()*1);
        }
        var harga=$("#harga_"+no).val();
        var diskon=$("#diskon_"+no).val();
        var jumlah=$("#jumlah_"+no).val();
        var ppn=getPPN();
        var materai=getMaterai();

        if(harga==null)
            harga=0;
        if(diskon==null)
            diskon=0;
        if(jumlah==null)
            jumlah=0;
        var selisih = jumlah*(harga*diskon/100);
        var total = (jumlah*harga)-selisih;
        tot=tot+total;
        $("#total_"+no).attr('value',total);
        $("#totalAll").val(tot);
        setTotalBayar(ppn, materai);
    }
</script>    
    <tr class="obat_tr">
        <td align="center">1</td>
        <td align="center"><input type="text" name="obat[]" id="barang1"></td>
        <td align="center"><input type="text" name="jumlah[]" id="jumlah1" onBlur="hitungTotal(1)"></td>
        <td align="center"><input type="text" name="harga[]" id="harga1" onBlur="hitungTotal(1)"></td>
        <td align="center"><input type="text" name="embalage[]" id="embalage1" onBlur="hitungTotal(1)"></td>
        <td align="center"></td>
        <td align="center"><button onClick='hapusBarang(1,this)' class="del">X</button></td>
    </tr>    
</table>  
<span style="position: relative;float: left;clear: left;padding-top: 10px;left: 430px;">
<table>
   <tr>
       <td width="105px">Jasa Apoteker</td><td>: </td><td><input type="text" name="totalAll" id="totalAll" disabled></td>
   </tr>
   <tr>
       <td width="105px">Diskon</td><td>: </td><td><input type="text" name="ppn2" id="ppn2" class="ppn" disabled></td>
   </tr>
   <tr>
       <td style="border-top: 1px solid #cccccc; ">Total Bayar</td><td>: </td><td style="border-top: 1px solid #cccccc; " width="110px" id="bayar">1000000</td>
   </tr>
</table>
</span>    
</form>    
