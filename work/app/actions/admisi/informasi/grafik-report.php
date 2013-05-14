<?php
  require_once 'app/lib/common/master-data.php';
  set_time_zone();
?>
<script type="text/javascript">
$(document).ready(function()
{
    $(function()
	{
        //$('#kelurahan').focus();
        $('#kecamatan').autocomplete("<?= app_base_url('/admisi/search?opsi=kecamatan') ?>",
        {
            parse: function(data)
            {
                var parsed = [];
                for (var i=0; i < data.length; i++)
                {
                    parsed[i] =
                    {
                        data: data[i],
                        value: data[i].nama // nama field yang dicari
                    };
                }
                //$('#id_kelurahan').attr('value', '');
                return parsed;
            },
            formatItem: function(data,i,max)
            {
                var str = '<div class=result><b style="text-transform:capitalize">'+data.nama+'</b><br />Kab: '+data.kabupaten+' - Prov: '+data.provinsi+'</div>';
                return str;
            },
            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
             dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated)
            {
                $('#kecamatan').attr('value', 'Kec: '+data.nama+', Kab: '+data.kabupaten+' - '+data.provinsi);
                $('#id_kecamatan').attr('value',data.id);
            }
        );
	});
    $('select[name=jenis_laporan]').change(function()
    {
        var tipe = $(this).val();
        if (tipe == 4)
        {
            $('#added_field').fadeIn();
        } else
        {
            $('#added_field').fadeOut();
        }
    });
    $(".date-picker").datepicker(
    {
        dateFormat  : "dd/mm/yy",
        changeMonth : true,
        changeYear  : true
    });
    $('#pilih').click(function ()
    {
        var tipe = $('#jenis_laporan').val();
        if($('#jenis_laporan').val() == "")
	    {
		    alert('Jenis laporan harus diisi!');
		    $('#jenis_laporan').focus();
		    return false;
	    }
        if (tipe == 4)
        {
            if($('#kecamatan').val() == "")
	        {
		        alert('Nama kecamatan harus diisi!');
		        $('#kecamatan').focus();
		        return false;
	        }
        }
        jenis   = $('#jenis_laporan').val();
        //kel   = $('#id_kelurahan').val();
        kec     = $('#id_kecamatan').val();
        periode = $('#period').val();
        awal    = $('#awali').val();
        akhir   = $('#akhiri').val();

        if (periode != 3)
            url = '&jenis_laporan='+jenis+'&kec='+kec+'&periode='+periode+'&awal='+awal+'&akhir='+akhir;
        else
        {
            bulan1  = $('#bln1').val();
            bulan2  = $('#bln2').val();
            tahun1  = $('#thawal').val();
            tahun2  = $('#thakhir').val();
            url     = '&jenis_laporan='+jenis+'&kec='+kec+'&periode='+periode+'&bln1='+bulan1+'&thawal='+tahun1+'&bln2='+bulan2+'&thakhir='+tahun2;
        }
        $.ajax(
        {
            url: "<?= app_base_url('admisi/informasi/grafik-query') ?>",
            cache: false,
            data: url,//'&jenis_laporan='+jenis+'&kec='+kec+'&periode='+periode+'&awal='+awal+'&akhir='+akhir,
            success: function(msg)
            {
                $('#show').html(msg); 
            }
        })
    })
});
</script>
<h2 class="judul">Grafik Demografi Pasien</h2>
<div class="data-input">
	<form method="get" action="">
        <fieldset>
            <div id="field-period" class="baris lanjutan-period">
                <fieldset class="field-group">
                    <legend>Awal - akhir periode</legend>
                    <input type="text" class="date-picker" name="awal" value="<?php echo date("d/m/Y"); ?>" id="awali" />
                    <label class="inline-title" for="akhir"> &nbsp; &nbsp; &nbsp; s . d &nbsp; &nbsp; &nbsp;</label>
                    <input type="text" class="date-picker" name="akhir" value="<?php echo date("d/m/Y"); ?>" id="akhiri" />
                </fieldset>
            </div>
			<label for="jenis_laporan">Parameter Pencarian</label>
			<select name="jenis_laporan" id="jenis_laporan">
				<option value="">Pilih</option>
				<option value="1">Pasien berdasarkan Pekerjaan</option>
				<option value="2">Pasien berdasarkan Pendidikan</option>
                <option value="3">Pasien berdasarkan Agama</option>
                <option value="4">Pasien berdasarkan Wilayah/Kecamatan</option>
                <option value="5">Pasien berdasarkan Golongan Darah</option>
			</select>
            <div id="added_field" style="display: none;">
			    <label for="kecamatan">Kecamatan:</label>
                <input id="kecamatan" type="text" name="kecamatan" />
                <input type="hidden" id="id_kecamatan" name="id_kecamatan" />
            </div>
			<fieldset class="input-process">
				<input type="button" id="pilih" name="submit_jenis" value="Tampil" class="tombol" />
				<input class="tombol" type="button" onclick="javascript:location.href='<?= (app_base_url('/admisi/informasi/grafik-report'))?>'" value="Batal">
			</fieldset>
		</fieldset>
	</form>
</div>
<div class="data-list">
<div id="show">

</div>
</div>