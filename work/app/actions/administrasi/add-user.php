 <?
 $namae='';
 $readon='';
 if($_SESSION['id_role']=='23'){
 $namae=$_SESSION['nama'];
 $readon='readonly';
 }
 ?>
 <script type="text/javascript">		
     function initKonsumen(){
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
                    }
 
 
	  $(function() {
		$('#rolename').change(function(){
		var role=$('#rolename').val();
		if(role!=''){
				$.ajax({
				url: "<?=app_base_url('administrasi/field')?>?role="+role,
				type:'GET',
				dataType:'json',
					success: function(data){
						  if(data.role=='sales'){
							  var str='<label for="target">Target</label><input type="text" name="target" id="target" onkeyup="Angka(this)"/><input type="hidden" name="genre" id="genre" value="sales"/>';
							  $('#tambahan').html(str);
						  }
						  else if(data.role=='konsumen'){
							  var str='<label for="limit">Alamat</label><input type="text" name="alamat" id="alamat"/><label for="limit">Limit Hutang</label><input type="text" name="limit" id="limit" onkeyup="Angka(this)"/><input type="hidden" name="genre" id="genre" value="konsumen"/><label for="limit">Sales</label><input type="text" name="namasales" id="namasales" value="<?=$namae?>" <?=$readon?>/><input type="hidden" name="salesid" id="salesid" value="<?=$_SESSION['id_user']?>"/>';
							  $('#tambahan').html(str);
							  initKonsumen();
						  } 
						  else{
						  	  $('#tambahan').html('');
						  }
					}
					
				});
			}//end if	
		 });
	  });
 
	
  </script>


<span class="data-input">
    <fieldset><legend>Form Tambah User Account</legend>
    <? //show_array($_SESSION);?>
        <form action="<?= app_base_url('administrasi/control/usersystem') ?>" method="post" onSubmit="return checkvalues(this)">
            <label for="nama">Nama Lengkap</label><input type="text" name="nama" id="nama" />
            <label for="username">Username</label><input type="text" class="username" name="username" id="username"/>
            <label for="weightrole">Role Name</label>
            <select name="rolename" id="rolename">
                <option value="">Pilih Role</option>
                <?php foreach ($role as $data): ?>
                    <option value="<?= $data['id_role'] ?>"><?= $data['nama_role']?></option>
                <?php endforeach;
                ?>

            </select>
            <div id="tambahan"></div>
            <fieldset class="input-process">
                <input type="submit" value=" Simpan" name="adduser" class="tombol" />
                <input type="button" value="Batal" class="tombol" onClick=javascript:location.href="<?= app_base_url('/administrasi/usersystem') ?>" />
            </fieldset>
        </form>
    </fieldset>
</span>