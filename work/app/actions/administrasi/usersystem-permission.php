    <div class="data-list">
        <form action="<?= app_base_url('/administrasi/control/usersystem')?>" method="post">
        <table class="tabel" width="50%">
                <tr>
                    <th>No</th>
                    <th>Menu</th>
                    <th>Sub Menu</th>
                    <?php
                        foreach($role as $user) {
                            echo "<th>$user[nama_role]</th>";
                        }
                    ?>
                </tr>
                <?
                    $mod=modul_muat_data();
                    showModul($mod, $role);
                ?>
        </table>
            <!-- tag lama  -->
            <br/>
            <input type="submit" value="Simpan" name="editpermission" class="tombol" />
            </form>
        </div>