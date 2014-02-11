<div class="page-header">
    <h1>Detil Transaksi</h1>
</div>
<div class="tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">Transaksi</a></li>
        <li><a href="#tab2" data-toggle="tab">Pengirim</a></li>
        <li><a href="#tab3" data-toggle="tab">Penerima</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <table class="table table-bordered table-striped">
                <tbody>
                    <?php
                    $awb = array('Tanggal', 'Airway Bill', 'Layanan', 'Layanan Tambahan', 'Perlakuan', 'Pembayaran',
                        'Deskripsi Barang', 'Nilai Barang', 'Berat Barang', 'Dimensi', 'Kemasan');
                    foreach ($detil as $pro) {
                        $date = date_create($pro->tanggal);
                        $pengirim = $pro->id_pengirim;
                        $penerima = $pro->id_penerima;
                        $tr[0] = date_format($date, 'd M Y');
                        $tr[1] = $pro->awb;
                        $tr[2] = $pro->layanan;
                        $tr[3] = $pro->tambahan;
                        $tr[4] = $pro->perlakuan;
                        $tr[5] = $pro->pembayaran;
                        $tr[6] = $pro->deskripsi;
                        $tr[7] = $pro->nilai_barang;
                        $query = "SELECT * FROM package, kemasan WHERE id_barang = '$pro->id_barang' AND package.id_kemasan = kemasan.id_kemasan";
                        $result = mysql_query($query);
                        $row = mysql_fetch_array($result);
                        $tr[8] = $row['actual_weight'];
                        $tr[9] = $row['dimention'];
                        $tr[10] = $row['kemasan'];
                    }
                    for ($i = 0; $i < (count($awb)); $i++) {
                        ?>
                        <tr>
                            <td width="30%"><?php echo $awb[$i]; ?></td>
                            <td><?php echo $tr[$i]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane" id="tab2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <?php
                    $fild = array('No. Account', 'Nama Lengkap', 'Perusahaan', 'Alamat', 'Telpon', 'Kode Pos', 'Email');
                    $peng = mysql_query("SELECT * FROM pengirim, customer WHERE pengirim.id_pengirim = '$pengirim' AND pengirim.customer_id_customer = customer.id_customer");
                    $datpeng = mysql_fetch_array($peng);
                    $kirim[0] = $datpeng['no_account'];
                    $kirim[1] = $datpeng['nama'];
                    $kirim[2] = $datpeng['perusahaan'];
                    $kirim[3] = $datpeng['alamat'];
                    $kirim[4] = $datpeng['telpon'];
                    $kirim[5] = $datpeng['kode_pos'];
                    $kirim[6] = $datpeng['email'];

                    for ($s = 0; $s < (count($fild)); $s++) {
                        ?>
                        <tr>
                            <td width="30%"><?php echo $fild[$s]; ?></td>
                            <td><?php echo $kirim[$s]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane" id="tab3">
            <table class="table table-bordered table-striped">
                <tbody>
                    <?php
                    $field = array('Nama Lengkap', 'Perusahaan', 'Alamat', 'Telpon', 'Kode Pos', 'Email');
                    $pene = mysql_query("SELECT * FROM penerima, customer WHERE penerima.id_penerima = '$penerima' AND penerima.id_customer = customer.id_customer");
                    $datpene = mysql_fetch_array($pene);
                    $terima[0] = $datpene['nama'];
                    $terima[1] = $datpene['perusahaan'];
                    $terima[2] = $datpene['alamat'];
                    $terima[3] = $datpene['telpon'];
                    $terima[4] = $datpene['kode_pos'];
                    $terima[5] = $datpene['email'];
                    
                    for ($z=0; $z<(count($field)); $z++){
                    ?>
                    <tr>
                        <td width="30%"><?php echo $field[$z];?></td>
                        <td><?php echo $terima[$z];?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>