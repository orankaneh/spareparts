/* 
 * Unique Data Check v0.1
 * 
 * plugin percobaan by:Galih Setyawan Nurdiansyah
 * 
 * berfungsi melakukan pengecekan data ke database dengan ajax dari FORM
 * memanggil terlebih dahulu fungsi validasi yang dibuat user
 * dengan melewatkan parameter berupa obyek FORM
 * bila valid akan lanjut bila tidak valid akan berhenti
 * bila data tersebut telah ada maka proses submit dibatalkan
 * bila data belum ada maka proses submit akan dilanjutkan
 * 
 * 
 */


(function($){
$.fn.uniqueDataCheck=function(options){        
        var defaults={
            validation:null,
            url:null,
            message:'Data sudah ada di dalam database'
        }     
        
        var o=$.extend(defaults,options);
        
        return this.each(function(){            
            var form=$(this);
            if((!form.is("form"))||o.validation==null||o.url==null) return;
            form.submit(
                function(event){
                    event.preventDefault();
                    var validation=window[o.validation](form);
                    if(validation){
                        
                        $.ajax({
                            url: o.url,                        
                            data:form.serialize(),
                            cache: false,
                            dataType: 'json',
                            success: function(msg){
                                if(msg.status){                          
                                    form.unbind('submit').submit();    
                                }else{                            
                                    alert(o.message);                
                                 }
                            }
                         });
                    }
                }
            );
            
        });
        
    };
})(jQuery);