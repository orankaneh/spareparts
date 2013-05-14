<?php
require_once "app/lib/common/master-data.php";
$kelas = kelas_instalasi_muat_data();
?>
<div class="data-input">
<fieldset><legend>Form Tambah Data tarif</legend>
    <form action="<?= app_base_url('/admisi/control/tarif/add') ?>" method="post" onSubmit="return cekform()">
        <input type="hidden" name="id" value="<?=get_new_tarif_id()?>">
        <label for="kode">Kode Tarif</label>
            <span style="font-size: 12px; padding-top: 5px; "><?=get_new_tarif_id()?></span>
        <label for="tarif" >Nama Layanan *</label>
            <span style="font-size: 12px; padding-top: 5px;">
                <input name="layanan" type="text" id="layanan" size="50%" width="50%"/>
                <input type="hidden" name="idLayanan" id="idLayanan"/>
            </span>
        <label for="kelas" >Kelas *</label>
            <span style="font-size: 12px; padding-top: 5px;">
                <select id="kelas" name="kelas">
                    <option value="">Pilih...</option>
                    <?
                      foreach ($kelas as $row) :
                    ?>
                    <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                    <?
                      endforeach;
                    ?>
                </select>
            </span>    
<fieldset class="input-process">
            <input type="submit" value="Simpan" class="tombol" name="add" />&nbsp;              
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/data-tarif') ?>'" />
     </fieldset>
    </form>
</fieldset>
</div>

<script type="text/javascript">
    $(document).ready(
        function(){
            $('#layanan').autocomplete("<?= app_base_url('/admisi/search?opsi=layanan_tarif') ?>",
            {
                parse: function(data){
                    var parsed = [];
                    for (var i=0; i < data.length; i++) {
                        parsed[i] = {
                            data: data[i],
                            value: data[i].nama+' '+data[i].profesi+' '+data[i].spesialisasi// nama field yang dicari
                        };
                    }
                    return parsed;
                },
                formatItem: function(data,i,max){
                    var str='<div class=result>'+data.nama;
                    str+=(data.profesi=='Tanpa Profesi'||data.profesi=='Semua')?'':' '+data.profesi;
                    str+=(data.spesialisasi=='Tanpa Spesialisasi'||data.spesialisasi=='Semua')?'':' '+data.spesialisasi;
                    str+=(data.bobot=='General'||data.bobot=='Tanpa Bobot'||data.bobot=='Semua')?'':' '+data.bobot;
                    str+=(data.instalasi=='Tanpa Instalasi'||data.instalasi=='Semua')?'':' '+data.instalasi;
                    //str+=(data.kelas=='Tanpa Kelas'||data.kelas=='Semua')?' ':' '+data.kelas;
                    str+='</div>';
                    return str;
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){
                var str=data.nama;
                    str+=(data.profesi=='Tanpa Profesi'||data.profesi=='Semua')?'':' '+data.profesi;
                    str+=(data.spesialisasi=='Tanpa Spesialisasi'||data.spesialisasi=='Semua')?'':' '+data.spesialisasi;
                    str+=(data.bobot=='General'||data.bobot=='Tanpa Bobot'||data.bobot=='Semua')?'':' '+data.bobot;
                    str+=(data.instalasi=='Tanpa Instalasi'||data.instalasi=='Semua')?'':' '+data.instalasi;
                    //str+=(data.kelas=='Tanpa Kelas'||data.kelas=='Semua')?' ':' '+data.kelas;


                $(this).attr('value',str);
                $('#idLayanan').attr('value',data.id);
                $('input').removeAttr("disabled");
                $('select').removeAttr("disabled");
            });
            $(':submit').click(function(e){
                e.preventDefault();
                if($('#layanan').attr('value')==''){
                    alert('Anda belum memasukkan nama layanan');
                }else if($('#idLayanan').attr('value')==''){
                    if($('#layanan').attr('value')!=''&&$('#idLayanan').attr('value')==''){
                        alert('Nama layanan yang anda masukkan tidak memiliki ID layanan');
                    }else{
                        alert('Anda belum memasukkan nama layanan');
                    }
                }else if($('#kelas').val()==''){
                    alert('Anda belum memilih kelas');
                }else{
                    $.ajax({
                        url: "<?= app_base_url('admisi/search?opsi=cek_tarif')?>",
                        data:'id_layanan='+$("#idLayanan").attr('value')+'&id_kelas='+$("#kelas").val(),
                        cache: false,
                        dataType: 'json',
                        success: function(msg){
                            if(!msg.status){
                                alert('Data tarif yang sama sudah pernah diinputkan');
                                return false;
                             }else{
                                 $("input[name=add]").unbind("click").click();
                             }
                        }
                     });
                }                
                
            });
        }
    );
</script>