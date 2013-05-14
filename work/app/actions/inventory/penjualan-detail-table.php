    <?php
    require_once 'app/config/db.php';
    require_once 'app/lib/common/master-inventory.php';
    require_once 'app/lib/common/functions.php';
    $id=$_GET['id'];
    $kelas=!isset($_GET['kelas'])?null:$_GET['kelas'];
    $mode=$_GET['mode'];

    $nota=  nota_temp_penjualan_muat_data($id,$kelas);
    
    //show_array($nota);
    if($mode=='search'){
        echo "<table border='0' cellspacing='0' class='data'>";
        echo "<th>No R</th>
              <th>Nama Barang</th>  
              <th>Jumlah</th>  
                ";

        foreach($nota as $row){
            $nama_barang=nama_packing_barang(array($row['generik'],$row['nama_obat'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan_terkecil'],$row['pabrik']));
            echo "<tr>"; 
            echo "<td align=center>";
            echo $row['no_r']==''?'-':$row['no_r'];
            echo "</td><td>".$nama_barang."</td><td align=right>".$row['jumlah_penjualan']."</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo '<p style="width:75%;text-align:right"><input type="button" name="tombol" id="tombol" value="Pilih Data" disabled="disabled"/></p>';
    }else{
        $aturan_pakai = aturan_pakai_muat_data();
$data='';
$biaya_apt=0;
    $diskon=0;
    $total=0;
        //show_array($aturan_pakai);
        if($nota[0]['jenis']=='Bebas'){
            $disabled='disabled="disabled"';
        }else{
            $disabled='';
        }
        
        $i=0;
        foreach($nota as $row){
            $i++;
            //$subtotal=$row['jenis']=='Bebas'?$row['hna']*$row['jumlah_penjualan']:$row['hna']*$row['jumlah_pakai'];
            $subtotal=$row['hna']*$row['jumlah_penjualan'];
            $nama_obat=nama_packing_barang(array($row['generik'],$row['nama_obat'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan_terkecil'],$row['pabrik']));;
        $data.= $row['id_aturan_pakai'];
        $data.= "<tr class='barang_tr'><td align=center><input type=text maxlength=2 name=resep".$i." id=resep".$i." onKeyup='Angka(this)' value='$row[no_r]' autocomplete=off style='width:100%;' $disabled/></td>".
                " <td align=center><input type=text name=databarang".$i." id=databarang".$i." value='$nama_obat' autocomplete=off class=autocpl style='width:300px;'/>".
                " <input type=hidden name=iddatabarang".$i." id=iddatabarang".$i." value='$row[id_packing_barang]' class=iddatabarangs /></td> ".
                " <td align=center><input type=text name=dosisracik".$i." id=dosisracik".$i." value='$row[kekuatan_r_racik]' class=dosisracik style='width:50px' onKeyup='Angka(this)' $disabled/> ".
                " <input type=hidden name=kekuatan".$i." id=kekuatan".$i." class=kekuatan value='$row[kekuatan]'></td>".
                " <td align=center><input type=text name=jmlh".$i." id=jmlh".$i." onKeyup='Angka(this)' value='$row[jumlah_r_resep]' autocomplete=off class=jmlh style='width:30px;' $disabled/> ".
                " <input type=hidden name=idpacking".$i." id=idpacking".$i." class=packing value='$row[id_packing_barang]' /></td> ";
                if($nota[0]['jenis']=='Bebas'){
                    $data.= " <td align=center><input type=text name=tebus".$i." style='width:75%;' id=tebus".$i." value='".$row['jumlah_penjualan']."' class=tebus autocomplete=off onKeyup='Angka(this)'/></td> "; 
                    $data.= " <td align=center><input type=text name=jmlpakai".$i." id=jmlpakai".$i." maxlength=3 style='width:100%;' value='' autocomplete=off disabled/><input type='hidden' id='sisa".$i."' class='sisa' value='$row[sisa]'> </td>";
                }else{
                    $data.= " <td align=center><input type=text name=tebus".$i." style='width:75%;' id=tebus".$i." value='".$row['jumlah_r_tebus']."' class=tebus autocomplete=off onKeyup='Angka(this)'/></td> ";
                    $data.= " <td align=center><input type=text name=jmlpakai".$i." id=jmlpakai".$i." maxlength=3 style='width:100%;' value='$row[jumlah_pakai]' autocomplete=off readonly/><input type='hidden' id='sisa".$i."' class='sisa' value='$row[sisa]'> </td>";
                }
                
            
         $data.=       
                " <td> ".
                    " <input type=hidden size=10 name=harga".$i." id=harga".$i." class='harga' value='$row[harga]'/> ".
                    " <input type=hidden name=detur".$i." id=detur".$i." class='detur' value='$row[detur]'/>".
                    " <input type=hidden size=8 name=subtotal".$i." id=subtotal".$i." class='subtotal' value='$subtotal'/>".
                " <select name=aturpakai".$i." id=aturpakai".$i." $disabled><option value=''>Aturan pakai ..</option> ";
               foreach ($aturan_pakai as $row2) { 
                   $data.= $row2['id'].'----'.$row['id_aturan_pakai'];
                if($row2['id']==$row['id_aturan_pakai']){
                    $data.= "<option value='".$row2['id']."' selected>".$row2['nama']."</option>";
                }else{
                    $data.= "<option value='".$row2['id']."'>".$row2['nama']."</option>";
                }    
                }
                
                $data.= "</select></td> ".
                " <td align=right>$row[harga]</td> ".
                " <td align=center>$row[detur]</td> ".
                " <td align=right>$subtotal</td> ".
                " <td align=center><input type=hidden name=jmldata value=".$i." /> ".
                " <input type=button value=Hapus title=Delete class=tombol /> ".
                " <input type=hidden name=margin".$i." id=margin".$i." class=margin/></td>".
                " </tr>";
                 $biaya_apt=$row['biaya_apoteker'];
                 $total_tagihan=$row['total_tagihan'];
                $total+=$subtotal;
                $biaya_apt=$row['biaya_apoteker'];
                $diskon=$row['diskon'];
    }
    
    die(json_encode(array(
                'data'=>$data,
                'biaya_apt'=>$biaya_apt,
                'total_tagihan'=>$total_tagihan,
                'total'=>$total,'diskon'=>$diskon)));
    }
    exit;
?>
