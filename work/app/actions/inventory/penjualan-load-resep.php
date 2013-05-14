<?php
    require_once 'app/config/db.php';
    require_once 'app/lib/common/master-inventory.php';
    require_once 'app/lib/common/functions.php';
    $id=$_GET['id'];
    $kelas=!isset($_GET['kelas'])?null:$_GET['kelas'];
    //$mode=$_GET['mode'];

    $nota=  nota_penjualan_muat_data($id,$kelas);
    //show_array($nota);
    $aturan_pakai = aturan_pakai_muat_data();
    //show_array($aturan_pakai);
    
    $disabled='disabled="disabled"';
    $data='';
    $biaya_apt=0; 
    $diskon=0;
    $total=0;
    $i=0;

    foreach($nota as $row){
        $i++;
        //$subtotal=$row['jenis']=='Bebas'?$row['hna']*$row['jumlah_penjualan']:$row['hna']*$row['jumlah_pakai'];
        $subtotal=$row['hna']*$row['jumlah_penjualan'];
        $nama_obat=nama_packing_barang(array($row['generik'],$row['nama_obat'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan_terkecil'],$row['pabrik']));
        $data.= "<tr class='barang_tr'><td align=center><input type=hidden name=resep".$i." id=resep".$i." onKeyup='Angka(this)' value='$row[no_r]' /><input type=text maxlength=2 value='$row[no_r]' disabled style='width:100%;'/></td>".
                "<td align=center><input type=text name=databarang".$i." id=databarang".$i." value='$nama_obat' autocomplete=off class=autocpl style='width:300px;' $disabled/>".
                "<input type=hidden name=iddatabarang".$i." id=iddatabarang".$i." value='$row[id_obat]' class=iddatabarangs /></td> ".
                "<td align=center><input type=text value='$row[kekuatan_r_racik]' style='width:50px' onKeyup='Desimal(this)' $disabled/><input type=hidden name=dosisracik".$i." id=dosisracik".$i." value='$row[kekuatan_r_racik]' class=dosisracik onKeyup='Desimal(this)'/> ".
                "<input type=hidden name=kekuatan".$i." id=kekuatan".$i." class=kekuatan value='$row[kekuatan]'></td>".
                "<td align=center><input type=text value='$row[jumlah_r_resep]' style='width:30px;' $disabled/><input type=hidden name=jmlh".$i." id=jmlh".$i." class=jmlh value='$row[kekurangan_tebus]' /> <input type=hidden name=jmlh_temp".$i." id=jmlh_temp".$i." value='$row[jumlah_r_resep]'/>".
                "<input type=hidden name=idpacking".$i." id=idpacking".$i." class=packing value='$row[id_packing_barang]' /></td> ";                
                    $data.= " <td align=center><input type=text name=tebus".$i." style='width:75%;' id=tebus".$i." value='".$row['kekurangan_tebus']."' class=tebus_sisa autocomplete=off onKeyup='Desimal(this)'/></td> ";
                    $data.= " <td align=center><input type=text name=jmlpakai".$i." id=jmlpakai".$i." maxlength=3 style='width:100%;' value='$row[kekurangan_tebus]' autocomplete=off readonly/><input type='hidden' id='sisa".$i."' class='sisa' value='$row[sisa]'> </td>";         
                
            
         $data.=       
                " <td> ".
                    " <input type=hidden size=10 name=harga".$i." id=harga".$i." class='harga' value='$row[harga]'/> ".
                    " <input type=hidden name=detur".$i." id=detur".$i." class='detur' value='0'/>".
                    " <input type=hidden size=8 name=subtotal".$i." id=subtotal".$i." class='subtotal' value='$subtotal'/>".
                " <input type='hidden' name=aturpakai".$i." id=aturpakai".$i." value=".$row['id_aturan_pakai'].">".
                 " <select $disabled>";         
                $data.= "<option value=''".$row['id_aturan_pakai']."' selected'>".$row['aturan_pakai']."</option>";                
                $data.= "</select></td> ";                
                $data.= "</td> ".
                " <td align=right>$row[harga]</td> ".
                " <td align=center>0</td> ".
                " <td align=right>$subtotal</td> ".
                " <td align=center><input type=hidden name=jmldata value=".$i." /> ".
                " ".
                " <input type=hidden name=margin".$i." id=margin".$i." class=margin/></td>".
                " </tr>";
                $total+=$subtotal;
                $biaya_apt=$row['biaya_apoteker'];
                $diskon=$row['diskon'];
        }
        $data.= "<input type='hidden' name='tebus_sisa_resep'/>";    
        die(json_encode(array('data'=>$data,'biaya_apt'=>$biaya_apt,'total'=>$total,'diskon'=>$diskon)));
        exit();
?>
