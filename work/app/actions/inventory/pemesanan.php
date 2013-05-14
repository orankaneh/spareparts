<script type="text/javascript">
    function hapusBarang(el){
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var jumlah=$('.barang_tr').length;
        for(var i=0;i<=jumlah;i++){
            $('.barang_tr:eq('+i+')').children('td:eq(0)').html(i+1);
            $('.barang_tr:eq('+i+')').removeClass('even');
            $('.barang_tr:eq('+i+')').removeClass('odd');
            if((i+1) % 2 == 1){
                $('.barang_tr:eq('+i+')').addClass('even');
            }else{
                $('.barang_tr:eq('+i+')').addClass('odd');
            }
        }
    }
    $(function() {
        $('#suplier').focus();
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
        });
    });
    var counter = 11;
    function removeMe(el){
        if(counter>11){
            var parent = el.parentNode.parentNode;
            parent.parentNode.removeChild(parent);
            counter--;
        }
    }
    
    function setAc(){
        $(".auto").each(function(){
            if(this.id.match(/barang.*/)){
                ac($(this));
            }
        });    
    }
    
    function ac(elem){
        
        $(elem).unautocomplete().autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>&jenissp="+$("select[name=jenis]").val()+"",
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
                var str=ac_nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            var str=nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik])

            $(this).attr('value', str);
            var tr=$(this).parent('td').parent('tr');
            $(this).next().attr('value',data.id);
            
            tr.children('td:eq(1)').children('input[type=hidden]').attr('value',data.id);
            var now = tr.index();
            var i = 1;
            var saiki = $(this).next().attr('value');
            for (i = 1; i < now; i++)
            {
                    var dinamis   = $('#idbarang'+i).attr('value');
                    if (now == 1)
                            break;
                    else{
                            if (saiki == dinamis){
                                    alert('Data barang yang dimasukkan sudah ada di list baris ke-'+i);
                                    $('#idbarang'+now).attr('value', '');
                                    $('#barang'+now).attr('value', '');
                                    $('#barang'+now).focus();
                                     tr.children('td:eq(3)').html('');
                                    return false;
                                    break;
                            }
                    }
            }
            
            tr.children('td:eq(3)').html(data.satuan_terbesar);
            var sisa=0;
            if(data.sisa!=null){
                sisa=data.sisa;
            }
            
            $.ajax({
                url: '<?= app_base_url('/inventory/search') ?>',
                cache: false,
                data:'idPacking=10&opsi=hitung_rop',
                dataType: 'json',
                success: function(msg){
                    var hasil=Math.ceil(msg.rop);
                    //var hasil = 100;
                    if(hasil==null){
                        hasil=0;
                    }
                    tr.children('td:eq(5)').html(hasil);
                    if (data.sisa < hasil) {
                        tr.children('td:eq(5)').addClass('warning');
                        tr.children('td:eq(4)').addClass('warning');
                        tr.children('td:eq(3)').addClass('warning');
                        tr.children('td:eq(1)').addClass('warning');
                        tr.children('td:eq(2)').addClass('warning');
                        tr.children('td:eq(0)').addClass('warning');
                        tr.children('td:eq(6)').addClass('warning');
                    }
                }
            })
            tr.children('td:eq(4)').html(sisa);
                
        });
    }
    
    $(document).ready(function(){
        $("#tambahBaris").click(function(){
            var barang = 'barang'+counter,
            satuan = 'satuan'+counter,
            sisa = 'sisa'+counter,
            rop = 'rop'+counter
            var number=$(".barang_tr").length+1;
            string = "<tr class='barang_tr'> " +
                "<td align=center id='numb"+number+"'>"+number+"</td><td id='brg"+number+"' align='center'> " +
                "<input type=text style='width: 30em' name=barang["+number+"][nama] id=barang"+number+" class=auto /> " +
                "<input type=hidden  name=barang["+number+"][idbarang] id=idbarang"+number+" class=auto /></td> " +
                "<td id='jml"+number+"' align='center'><input size='10' type=text maxlength='9' name=barang["+number+"][jumlah] class=auto onKeyup='Desimal(this)' id='jumlah"+number+"'/></td> " +
                "<td align=center id=satuan"+number+" align='center'></td> " +
                "<td id=sisa"+number+"></td> " +
                "<td id=rop"+number+"></td> " +
                "<td align=center id='del"+number+"'><input type='button' class='tombol' value='Hapus' onclick=hapusBarang(this)></td>" +
                "</tr>";
            $("#tblPemesanan").append(string);
			
            if(number % 2 == 1){
                $('.barang_tr:eq('+(number-1)+')').addClass('even');
            }else{
                $('.barang_tr:eq('+(number-1)+')').addClass('odd');
            }
            setAc();
            counter++;
        });
        
        
        
        
        $("select[name=jenis]").change(
        function(){
                
            $(".barang_tr").children().each(function(){
                if(this.id.match(/brg.*/)||this.id.match(/jml.*/)){
                    $(this).children().val("");
                    if($("select[name=jenis]").val()==""){
                        if (this.id.match(/brg.*/))$(this).children().removeClass("auto ac_inputs");
                        $(this).children().attr("disabled","disabled");
                    }else{
                        if (this.id.match(/brg.*/))$(this).children().addClass("auto ac_inputs");
                        $(this).children().removeAttr("disabled");}
                }else{
                    if(this.id.match(/numb.*/)||this.id.match(/del.*/)){

                    }else{
                        $(this).html("");
                    }
                }
            });
            if($("select[name=jenis]").val()==""){
                $("#tambahBaris").attr("disabled","disabled");
                $("input[value=Hapus]").attr("disabled","disabled");
            }else{
                $("#tambahBaris").removeAttr("disabled");
                $("input[value=Hapus]").removeAttr("disabled");                
            }
            setAc();
            $("#barang1").focus();
        }
            
    )
    
    $("select[name=jenis]").live('keydown',function(e){
        var keyCode = e.keyCode || e.which; 

        if (keyCode == 9) { 
            e.preventDefault(); 
             $("select[name=jenis]").change();             
        } 
    });
        
    })
    
    function checkdata(data) {
        if (data.idsuplier.value == "") {
            alert('Suplier tidak boleh kosong');
            data.suplier.focus();
            return false;
        }else if($('select[name=jenis]').attr('value')==''){
            alert('Jenis pemesanan belum terpilih');
            $('select[name=jenis]').focus();
            return false;
        }
        var jumlahForm=counter;
        var i=0;
        var isi=false;
		var indeks = 1;
        for(i=1;i<=jumlahForm;i++){
            if($('#idbarang'+i).attr('value')==null){
                continue;
            }
            if($('#idbarang'+i).attr('value')!=""){
                if($('#jumlah'+i).attr('value')==''){
                    $('#jumlah'+i).focus();
                    alert('Jumlah tidak boleh kosong');
                    return false;
                }
                isi=true;
            }
        }
        if(!isi){
            alert('inputan barang masih kosong');
            return false;
        }
    }
</script>
<?
include_once "app/lib/common/functions.php";
include_once "app/lib/common/master-data.php";
require 'app/actions/admisi/pesan.php';
set_time_zone();
$date = date("d/m/Y");
$no = _select_unique_result("select id from pemesanan order by id desc limit 0,1");
$id = array_value($no, "id");
$noSurat = $no['id'] + 1;
?>
<form action="<?= app_base_url('inventory/control/pemesanan') ?>" method="post" onSubmit="return checkdata(this)">
    <h2 class="judul">Pemesanan</h2>
    <?= isset($pesan) ? $pesan : NULL; ?>
    <div class="data-input">
        <fieldset>
            <legend>Form Pemesanan</legend>
            <label for="no-surat">No. Surat</label><span style="font-size: 12px;padding-top: 5px;"><?= $noSurat ?></span>
            <label for="awal">Tanggal*</label><input type="text" name="tanggal" id="awal" class="tanggal" value="<?= $date ?>" tabindex="1"/>
            <label for="suplier">Suplier*</label><input type="text" name="suplier" id="suplier" tabindex="2"/><input type="hidden" name="idsuplier" id="idsuplier" />
            <label for="jenis">Jenis SP*</label><select name="jenis" tabindex="3"><option value="">pilih jenis Sp</option>
                <option value="Umum">Umum</option>
                <option value="Narkotik">Narkotika</option>
                <option value="Psikotropik">Psikotropika</option>
                <option value="Reguler">Reguler</option>
                <option value="Askes">Askes</option>
                <option value="Jamkesmas">Jamkesmas</option>
            </select>
        </fieldset>
    </div>      

         <div class="data-list tabelflexibel">
            <fieldset>
            <input type="button" value="Tambah Baris" id="tambahBaris" class="tombol" style="margin-bottom: 5px;" tabindex="4" disabled>
            <br>
                <table id="tblPemesanan" class="table-input" style="width:80%;">
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width: 35%">Nama Packing Barang</th>
                        <th style="width:10%">Jumlah</th>
                        <th style="width:10%">Kemasan</th>
                        <th style="width:10%">Sisa Stok</th>
                        <th style="width:7%">ROP</th>
                        <th style="width:2%">Aksi</th>
                    </tr>
                    <?php for ($i = 1; $i <= 2; $i++) {
                    ?>

                        <tr class="barang_tr <?= ($i % 2) ? 'even' : 'odd' ?>">
                            <td align="center" class="number" id="numb<?= $i ?>"><?= $i ?></td>
                            <td id="brg<?= $i ?>" align="center"><input type="text" name="barang[<?= $i ?>][nama]" id="barang<?= $i ?>" class="auto" style="width:30em" disabled="disabled" />
                                <input type="hidden" name="barang[<?= $i ?>][idbarang]" id="idbarang<?= $i ?>" class="auto" />
                            </td>
                            <td id="jml<?= $i ?>" align="center"><input size=10 type="text" maxlength="9" name="barang[<?= $i ?>][jumlah]" class="std-width" onKeyup="Desimal(this)" id="jumlah<?= $i ?>" disabled=/></td>
                            <td id="satuan<?= $i ?>" align="center"></td>
                            <td class="wrap"id="sisa<?= $i ?>"></td>
                            <td id="rop<?= $i ?>"></td>
                            <td align="center" id="del<?= $i ?>"><input type="button" class="tombol" value="Hapus" onclick="hapusBarang(this)" disabled="disabled"></td>
                        </tr>

                    <?php } ?>
                </table>
         <br/>   
        <div class="field-group">
            <input type="submit" value="Simpan" name="save" class="tombol" />
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/pemesanan') ?>'" >
        </div>
     </fieldset>
    </div>
</form>