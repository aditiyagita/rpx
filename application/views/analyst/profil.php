
<script src="<?php echo base_url() ?>media/js/libs/jquery-1.8.3.min.js"></script>
<script>
    $(document).ready(function() {
        $('#loading').hide();
        $('#sukses').hide();
    });
    function closeDialog () {
        $('#add_pesan').modal('hide'); 
    };
    function okClicked () {
        var $username = document.getElementById ("username").value;
        var $email = document.getElementById ("email").value;
        var $nama = document.getElementById ("nama").value;
        var $password = document.getElementById ("password").value;
        
        closeDialog ();
        $('#loading').show();
        setTimeout('$("#loading").hide()',3000);
        //ajax send
        
        $.ajax({
            type: "POST",
            url: "http://localhost/rpx/analyst/profil/add_profil",
            dataType: "json",
            data: "username="+$username+"&email="+$email+"&nama="+$nama+"&password="+$password,
            cache:false,
            success: 
                function(data){
                if(data.message){
                    $("#sukses").html(data.message);
                    setTimeout('$("#sukses").show()',3000);
                    setTimeout('$("#sukses").hide()',6000);
                }
               // pesan.value = "";
                setTimeout('window.location = "http://localhost/rpx/analyst/profil/"',6000);
            }
        
        });

        return false;
        
        //ajax end
        
    };
</script>


<div class="page-header">
    <h1>Profil</h1>
</div>

<table class="table table-bordered table-striped">
    <tbody>

        <?php
        $keterangan = array('Username', 'Email', 'Nama Lengkap', 'Tanggal Lahir');
        foreach ($profil as $pro) {
            $p[0] = $pro->username;
            $p[1] = $pro->email;
            $p[2] = $pro->nama;
            $date = date_create($pro->tgl_lahir);
            $p[3] =  date_format($date, 'd M Y');
        }

        for ($i = 0; $i < (count($keterangan)); $i++) {
            ?>
            <tr>
                <td width="30%">
                    <?php echo $keterangan[$i]; ?>
                </td>
                <td>
                    <?php echo $p[$i]; ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<div id="add_pesan" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
    <div class="modal-header">
        <a href="#" class="close" data-dismiss="modal" >&times;</a>
        <h3><i class="icon-user"></i> &nbsp;Edit Profil</h3>
    </div>
    <div class="modal-body">
        <div class="divDialogElements">
            <div class="input-prepend">
                <span class="add-on">
                    <i class="icon-user"></i>
                </span>
                <input class="xlarge" id="username" name="username" type="text" value="<?php echo $p[0];?>"/>
            </div>
        </div>
        <div class="divDialogElements">
            <div class="input-prepend">
                <span class="add-on">
                    <i class="icon-envelope"></i>
                </span>
                <input class="xlarge" id="email" name="email" type="text" value="<?php echo $p[1];?>"/>
            </div>
        </div>
        <div class="divDialogElements">
            <div class="input-prepend">
                <span class="add-on">
                    <i class="icon-eye-open"></i>
                </span>
                <input class="xlarge" id="nama" name="nama" type="text" value="<?php echo $p[2];?>"/>
            </div>
        </div>
        <div class="divDialogElements">
            <div class="input-prepend">
                <span class="add-on">
                    <i class="icon-hand-right"></i>
                </span>
                <input class="xlarge" id="password" name="password" type="text" placeholder="Password Baru"/>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" onclick="closeDialog ();">Cancel</a>
        <a href="#" class="btn btn-primary" onclick="okClicked ();">OK</a>
    </div>
</div>
<div id="tengah">
    <div id="loading">
        <img src="<?php echo base_url() ?>media/img/loader01.gif"/> &nbsp; Loading...
    </div>
    <div id="sukses"></div>
</div>


<p>
    <a data-toggle="modal" href="#add_pesan" class="btn btn-primary btn-large">Edit Profil</a>
</p>