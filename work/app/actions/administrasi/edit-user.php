<?php
$row = usersystem_muat_data($_GET['id'], NULL, NULL, NULL);
$row = $row[0];
$role = role_muat_data();
 $namae='';
 $readon='';
 if($_SESSION['id_role']=='23'){
 //$namae=$_SESSION['nama'];
 $readon='readonly';
 }
 else{
?>
<script type="text/javascript">
     $(function() {
                        $('#namasales').autocomplete("<?= app_base_url('/admisi/search?opsi=sales') ?>",
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
                                var str='<div class=result>'+data.nama+'</i></div>';
                                return str;
                            },
                            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                        }).result(
                        function(event,data,formated){
                            $(this).attr('value',data.nama);
							$('#salesid').attr('value',data.idne);
                        }
                    );
                     });
</script>
<? } ?>

<span class="data-input">

    <fieldset>
        <legend>Form Edit User Account <?= $row['username'] ?></legend>
        <form action="<?= app_base_url('administrasi/control/usersystem') ?>" method="post" onSubmit="return checkvalues(this)">
            <? if($row['id_role']=='23'){?>
              <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" value="<?= $row['salesname'] ?>" readonly="readonly"/>
            <input type="hidden" name="idex" id="idex" value="<?=$row['id']?>" />
            <label for="target">Target</label>
            <input type="text" name="target" id="target" onkeyup="Angka(this)" value="<?= $row['target'] ?>"/>
             <input type="hidden" name="old" id="old" value="<?=$row['target']?>" />
            <input type="hidden" name="genre" id="genre" value="sales"/>
                       <? }?>
              <? if($row['id_role']=='24'){
			  $sales=salese_muat_data($row['id_sales']);
			  //show_array($sales);
			  ?>
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" value="<?= $row['konsumenname'] ?>" readonly="readonly"/>
            <input type="hidden" name="idex" id="idex" value="<?=$row['id']?>" />
            <label for="limit">Alamat</label><input type="text" name="alamat" id="alamat" value="<?=$row['alamat']?>"/>
            <label for="limit">Limit Hutang</label><input type="text" name="limit" id="limit" onkeyup="Angka(this)" value="<?=$row['maximalhutang']?>" <?=$readon?>/>
             <label for="limit">Sales</label>
             <input type="text" name="namasales" id="namasales" value="<?=$sales['nama']?>" <?=$readon?>/>
              <input type="hidden" name="salesid" id="salesid" value="<?=$row['id_sales']?>"/>
             <input type="hidden" name="old" id="old" value="<?=$row['maximalhutang']?>" />
            <input type="hidden" name="genre" id="genre" value="konsumen"/>
            <? }?>
            
            <label for="username">Username</label><input type="text" name="username" id="username" value="<?= $row['username'] ?>" disabled/>
            <label for="weightrole">Role Name</label>
            <select name="rolename" class="tanggal" disabled="disabled">
                <option value="">Pilih Role</option>
                <?php foreach ($role as $data): ?>
                    <option value="<?= $data['id_role'] ?>"<? if ($row['id_role'] == $data['id_role'])
                    echo"selected"; ?>><?= $data['nama_role']?></option>

                <?php endforeach;
                ?>
            </select>
            <fieldset class="input-process">
                <input type="submit" value="Simpan" name="edituser" class="tombol" />
                <input type="button" value="Batal" class="tombol" onClick=javascript:location.href="<?= app_base_url('/administrasi/usersystem') ?>" />
            </fieldset>
        </form>
    </fieldset>
</span>
