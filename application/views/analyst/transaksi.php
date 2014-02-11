<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>media/media/css/DT_bootstrap.css">
<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>media/media/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>media/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>media/js/bootstrap-dataTable.js"></script>
<script src="<?php echo base_url() ?>media/js/bootstrap-typeahead.js"></script>  
<script type="text/javascript" charset="utf-8">
    /* Table initialisation */
    
    $(document).ready(function() {
        $('#table0').dataTable( {
            "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page"
            }
        } );
    });
    function closeDialog () {
        $('#transaksi').modal('hide'); 
        $('#hapus').modal('hide'); 
    };
    function okClicked () {
        document.title = document.getElementById ("xlInput").value;
        closeDialog ();
    };
    function hapus (id) {
        $('#hapus').modal('show'); 
        document.getElementById ("id_hapus").value = id;
    };
    function okHapus () {
        var id = $("#id_hapus").val();
        window.location = "<?php echo base_url() ?>analyst/transaksi/hapus/"+id;
    };
    function add_transaksi(){
        $('#transaksi').modal('show');
        
<?php
$d = array('PHP', 'MySQL', 'SQL', 'PostgreSQL', 'HTML', 'CSS', 'HTML5', 'CSS3', 'JSON');
?>
                
        var sender = [<?php
$tot = count($sender);
$i = 1;
foreach ($sender as $s) {
    if ($i < $tot) {
        echo "'" . $s->no_account . " " . $s->nama . "' ,";
    } else {
        echo "'" . $s->no_account . " " . $s->nama . "'";
    } $i++;
}
?> ]; 
            var receiver = [<?php
$totr = count($receiver);
$i = 1;
foreach ($receiver as $r) {
    if ($i < $totr) {
        echo "'" . $r->nama . "' ,";
    } else {
        echo "'" . $r->nama . "'";
    } $i++;
}
?> ];
                $('#sender').typeahead({source: sender})
                $('#receiver').typeahead({source: receiver})
          
          
            }
    
</script>
<div class="page-header">
    <h1>Transaksi</h1>
</div>

<style>
    .divDialogElements input {
        font-size: 18px;
        padding: 3px; 
        height: 32px; 
        width: 500px; 
    }
</style>
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
            Berhasil input transaksi
        </div>
    <?php }
} ?>


<div id="transaksi" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
    <div class="modal-header">
        <a href="#" class="close" data-dismiss="modal" >&times;</a>
        <h3>Add Transaksi.</h3>
    </div>
    <form method="post" action="<?php echo base_url() ?>analyst/transaksi/do_add">
        <div class="modal-body">
            <div class="divDialogElements">
                <input type="text" class="xlarge" id="awb" name="awb" placeholder="No. AWB" />
            </div>
            <div class="divDialogElements">
                <input type="text" class="xlarge" id="sender" name="sender" data-provide="typeahead" data-items="<?php echo $tot; ?>" placeholder="Sender" />
            </div>
            <div class="divDialogElements">
                <input type="text" class="xlarge" id="receiver" name="receiver" data-provide="typeahead" data-items="4" placeholder="Receiver" />
            </div>
            <div class="divDialogElements">
                <select class="input-xxlarge" name="layanan" id="tambahan">
                    <option value="">-Pilih Layanan-</option>
                    <?php foreach ($layanan as $l) { ?>
                        <option value="<?php echo $l->kode_layanan ?>"><?php echo $l->layanan ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="divDialogElements">
                <select class="input-xxlarge" name="tambahan" id="tambahan">
                    <option value="">-Pilih Tambahan-</option>
                    <?php foreach ($tambahan as $t) { ?>
                        <option value="<?php echo $t->kode_tambahan ?>"><?php echo $t->tambahan ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="divDialogElements">
                <select class="input-xxlarge" name="perlakuan" id="perlakuan">
                    <option value="">-Pilih Perlakuan-</option>
                    <?php foreach ($perlakuan as $p) { ?>
                        <option value="<?php echo $p->kode_perlakuan ?>"><?php echo $p->perlakuan ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="divDialogElements">
                <select class="input-xxlarge" name="pembayaran" id="pembayaran">
                    <option value="">-Pilih Pembayaran-</option>
                    <?php foreach ($pembayaran as $pe) { ?>
                        <option value="<?php echo $pe->id_pembayaran ?>"><?php echo $pe->pembayaran ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="divDialogElements">
                <input type="text" class="xlarge" id="deskripsi" name="deskripsi" placeholder="Deskripsi Barang" />
            </div>
            <div class="divDialogElements">
                <input type="text" class="xlarge" id="nilai" name="nilai" placeholder="Nilai Barang" />
            </div>
            <div class="divDialogElements">
                <input type="text" class="xlarge" id="berat" name="berat" placeholder="Berat" />
            </div>
            <div class="divDialogElements">
                <input type="text" class="xlarge" id="dimensi" name="dimensi" placeholder="Dimensi" />
            </div>
            <div class="divDialogElements">
                <select class="input-xxlarge" name="kemasan" id="kemasan">
                    <option value="">-Pilih Kemasan-</option>
                    <?php foreach ($kemasan as $k) { ?>
                        <option value="<?php echo $k->id_kemasan ?>"><?php echo $k->kemasan ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="divDialogElements">
                <input type="text" class="xlarge" id="biaya"  name="biaya"  placeholder="Biaya" />
            </div>
        </div>
        <div class="modal-footer">
            <input type="reset" class="btn" value="RESET" name="reset"/>
            <input type="submit" class="btn btn-primary" value="Add" name="submit"/>
        </div>
    </form>
</div>

<div id="hapus" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
    <div class="modal-header">
        <a href="#" class="close" data-dismiss="modal" >&times;</a>
        <h3>Delete Confirmation</h3>
    </div>
    <div class="modal-body">
        <div class="divDialogElements">
            Apakah anda yakin akan menghapus?
            <input class="xlarge" id="id_hapus" name="xlInput" type="hidden" />
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" onclick="closeDialog ();">Cancel</a>
        <a href="#" class="btn btn-primary" onclick="okHapus ();">OK</a>
    </div>
</div>


<p>
    <a data-toggle="modal" href="" onclick="javascript:add_transaksi()" class="btn btn-primary btn-large">Add Transaksi</a>
</p>

<div class="panel" id="panel-101">
    <header>
        <i class="icon-asterisk"></i>
        <span>Shortcuts</span>
    </header>
    <div class="content tiles-container">

        <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" id="table0" width="100%">
            <thead>
                <tr>
                    <th class="header" width="4%" style="text-align:center">No.</th>
                    <th class="header" style="text-align:center">Tanggal</th>
                    <th class="header" style="text-align:center">Airway Bill</th>
                    <th class="header" width="25%" style="text-align:center">Pengirim</th>
                    <th class="header" width="24%" style="text-align:center">Penerima</th>
                    <th class="header" style="text-align:center">Origin/Destination</th>
                    <th class="header" style="text-align:center">Operasi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($transaksi as $t) { ?>
                    <tr>
                        <td style="text-align:center"><?php echo $i; ?></td>
                        <td style="text-align:center"><?php $date = date_create($t->tanggal);
                echo date_format($date, 'd M Y'); ?></td>
                        <td><?php echo $t->awb; ?></td>
                        <td>
                            <?php
                            $query = "SELECT customer.nama, kota.kode_kota as asal FROM pengirim, customer, kota WHERE pengirim.customer_id_customer = customer.id_customer AND customer.id_kota = kota.id_kota AND pengirim.id_pengirim = '$t->sender'";
                            $result = mysql_query($query);
                            $row = mysql_fetch_array($result);
                            $asal = $row['asal'];
                            echo strtoupper($row['nama']);
                            ?>
                        </td>
                        <td>
                            <?php
                            $querys = "SELECT customer.nama, kota.kode_kota as tuj FROM penerima, customer, kota WHERE penerima.id_customer = customer.id_customer AND customer.id_kota = kota.id_kota AND penerima.id_penerima = '$t->receiver'";
                            $results = mysql_query($querys);
                            $rows = mysql_fetch_array($results);
                            $tuj = $rows['tuj'];
                            echo strtoupper($rows['nama']);
                            ?>
                        </td>
                        <td style="text-align:center">
                            <?php
                            echo $asal . "/";
                            echo $tuj;
                            ?></td>
                        <td style="text-align:center"><a data-toggle="modal" href="" onclick="javascript:hapus(<?php echo $t->id_transaksi; ?>)"><i class="icon-trash"></i></a>
                            &nbsp; <a href="<?php echo base_url()?>analyst/transaksi/detil/<?php echo $t->id_transaksi; ?>"><i class="icon-list"></i></a> 
                            &nbsp; <a href="<?php echo base_url()?>analyst/transaksi/edit/<?php echo $t->id_transaksi; ?>"><i class="icon-pencil"></i></a>
                        </td>
                    </tr>
                    <?php $i++;
                } ?>
            </tbody>
        </table>
    </div>
</div>





