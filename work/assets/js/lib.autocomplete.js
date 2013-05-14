$(function() {
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
                if (data.id_pasien != null) {
                    $('#noRm').attr('value',data.id_pasien);
                }
                $('#idPenduduk').attr('value',data.id_penduduk);
                $('#nama').attr('value',data.nama_pas);
                $('#alamatJln').attr('value',data.alamat_jalan);
                $('#kelurahan').attr('value',data.nama_kelurahan);
                $('#idKel').attr('value',data.id_kelurahan);
                $('#gol').attr('value',data.gol_darah);
                $('#tglLahir').attr('value',data.tanggal_lahir);
                $('#idPkw').attr('value',data.status_pernikahan);
                $('#pendidikan').attr('value',data.id_pendidikan_terakhir);
                $('#namaPkj').attr('value',data.nama_pro);
                $('#idAgama').attr('value',data.id_agama);
                if(data.jenis_kelamin == "L") {
                        $('#laki-laki').attr('checked','checked');
                    }
                else if(data.jenis_kelamin == "P") {
                        $('#perempuan').attr('checked','checked');
                    }
            }
        );
});

$(function() {
        $('#noRm').autocomplete("<?= app_base_url('/admisi/search?opsi=noRm') ?>",
        {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].id_pasien // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        var str='<div class=result>'+data.id_pasien+' '+data.nama_pas+'</div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#noRm').attr('value',data.id_pasien);
                $('#nama').attr('value',data.nama_pas);
                $('#alamatJln').attr('value',data.alamat_jalan);
                $('#kelurahan').attr('value',data.nama_kel);
                $('#idKel').attr('value',data.id_kelurahan);
                $('#gol').attr('value',data.gol_darah);
                $('#tglLahir').attr('value',data.tanggal_lahir);
                $('#idPkw').attr('value',data.status_pernikahan);
                $('#pendidikan').attr('value',data.id_pendidikan_terakhir);
                $('#namaPkj').attr('value',data.nama_pro);
                $('#idAgama').attr('value',data.id_agama);
                if(data.jenis_kelamin == "L")
                    {
                        $('#laki-laki').attr('checked','checked');
                    }
                else if(data.jenis_kelamin == "P")
                    {
                        $('#perempuan').attr('checked','checked');
                    }
            }
        );
});

$(function() {
        $('#nmKeluarga').autocomplete("<?= app_base_url('/admisi/search?opsi=nmKeluarga') ?>",
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
                        var str='<div class=result>'+data.nama+', '+data.alamat_jalan+'</div>';
                        return str;
                    },
                    width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#nmKeluarga').attr('value',data.nama);
                $('#idNmKeluarga').attr('value',data.id);
                $('#alamatK').attr('value',data.alamat_jalan);
                $('#ntK').attr('value',data.no_telp);
                $('#hubKeluarga').attr('value',data.posisi_di_keluarga);
            }
        );
});

$(function() {
        $('#kelurahan').autocomplete("<?= app_base_url('/admisi/search?opsi=kelurahan') ?>",
        {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].nama_kel // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        var str='<div class=result><b style="text-transform:capitalize">'+data.nama_kel+'</b> <i>Kec: '+data.nama_kec+'<br/> Kab: '+data.nama_kab+' Prov: '+data.nama_pro+'</i></div>';
                        return str;
                    },
                    width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#kelurahan').attr('value',data.nama_kel);
                $('#idKel').attr('value',data.id_kel);
            }
        );
});

$(function() {
        $('#nmPjw').autocomplete("<?= app_base_url('/admisi/search?opsi=nmPjw') ?>",
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
                        var str='<div class=result>'+data.nama+', '+data.alamat_jalan+'</div>';
                        return str;
                    },
                    width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#nmPjw').attr('value',data.nama);
                $('#idNmPjw').attr('value',data.id);
                $('#alamatPjw').attr('value',data.alamat_jalan);
                $('#telpPjw').attr('value',data.no_telp);
            }
        );
});

$(function() {
        $('#namaP').autocomplete("<?= app_base_url('/admisi/search?opsi=nmPjw') ?>",
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
                        var str='<div class=result>'+data.nama+', '+data.alamat_jalan+'</div>';
                        return str;
                    },
                    width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#namaP').attr('value',data.nama);
                $('#idNamaP').attr('value',data.id);
                $('#alamatP').attr('value',data.alamat_jalan);
                $('#telpP').attr('value',data.no_telp);
            }
        );
});

$(function() {
        $('#rujukan').autocomplete("<?= app_base_url('/admisi/search?opsi=rujukan') ?>",
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
                        var str='<div class=result>'+data.nama+' code:'+data.id_jenis_instansi_relasi+'</div>';
                        return str;
                    },
                    width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#rujukan').attr('value',data.nama);
                $('#idRujukan').attr('value',data.id);
            }
        );
});

$(function() {
        $('#nakes').autocomplete("<?= app_base_url('/admisi/search?opsi=nakes') ?>",
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
                        var str='<div class=result>'+data.nama+' SIP:'+data.sip+'</div>';
                        return str;
                    },
                    width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#nakes').attr('value',data.nama);
                $('#idNakes').attr('value',data.id);
            }
        );
});
