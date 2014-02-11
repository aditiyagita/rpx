<div class="page-header">
    <h1>Edit Transaksi</h1>
</div>
<?php
$error = $this->session->flashdata('error');
if (!empty($error)) {
    if ($error == 'error') {
        ?>
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>Error!</h4>
            Data tidak lengkap atau format salah
        </div>
    <?php } else { ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>Success!</h4>
            Berhasil update transaksi
        </div>
    <?php }
} ?>
<div class="tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">Transaksi</a></li>
        <li><a href="#tab2" data-toggle="tab">Pengirim</a></li>
        <li><a href="#tab3" data-toggle="tab">Penerima</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
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
                $tr[11] = $pro->biaya;
                $tr[12] = $pro->id_transaksi;
                $tr[13] = $pro->id_barang;
            }
            ?>
            <form class="form-horizontal" method="post" action="<?php echo base_url()?>analyst/transaksi/update">
                <div class="control-group">
                    <label class="control-label">Tanggal</label>
                    <div class="controls">
                        <input type="text" id="tanggal" name="tanggal" class="input-xxlarge" value="<?php echo $tr[0]; ?>" readonly>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Airway Bill</label>
                    <div class="controls">
                        <input type="text" id="awb" name="awb" class="input-xxlarge" value="<?php echo $tr[1]; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Layanan</label>
                    <div class="controls">
                        <input type="text" id="layanan" name="layanan" class="input-xxlarge" value="<?php echo $tr[2]; ?>" readonly>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Tambahan</label>
                    <div class="controls">
                        <input type="text" id="tambahan" name="tambahan" class="input-xxlarge" value="<?php echo $tr[3]; ?>" readonly>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Perlakuan</label>
                    <div class="controls">
                        <input type="text" id="perlakuan" name="perlakuan" class="input-xxlarge" value="<?php echo $tr[4]; ?>" readonly>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Pembayaran</label>
                    <div class="controls">
                        <input type="text" id="pembayaran" name="pembayaran" class="input-xxlarge" value="<?php echo $tr[5]; ?>" readonly>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Deskripsi</label>
                    <div class="controls">
                        <input type="text" id="deskripsi" name="deskripsi" class="input-xxlarge" value="<?php echo $tr[6]; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Nilai Barang</label>
                    <div class="controls">
                        <input type="text" id="nilai_barang" name="nilai_barang" class="input-xxlarge" value="<?php echo $tr[7]; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Berat</label>
                    <div class="controls">
                        <input type="text" id="berat" name="berat" class="input-xxlarge" value="<?php echo $tr[8]; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Dimensi</label>
                    <div class="controls">
                        <input type="text" id="dimensi" name="dimensi" class="input-xxlarge" value="<?php echo $tr[9]; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Kemasan</label>
                    <div class="controls">
                        <input type="text" id="kemasan" name="kemasan" class="input-xxlarge" value="<?php echo $tr[10]; ?>" readonly>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Biaya</label>
                    <div class="controls">
                        <input type="text" id="biaya" name="biaya" class="input-xxlarge" value="<?php echo $tr[11]; ?>">
                        <input type="hidden" id="id" name="id" class="input-xxlarge" value="<?php echo $tr[12]; ?>">
                        <input type="hidden" id="id_barang" name="id_barang" class="input-xxlarge" value="<?php echo $tr[13]; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                <input type="submit" class="btn btn-large btn-primary" name="submit" value="Update"/>
                    </div>
                </div>
            </form>
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

                    for ($z = 0; $z < (count($field)); $z++) {
                        ?>
                        <tr>
                            <td width="30%"><?php echo $field[$z]; ?></td>
                            <td><?php echo $terima[$z]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>