<style type="text/css">  
    .scrollspy-example {  
        height: 400px;  
        overflow: auto;  
        position: relative; 
    }

    #kanan{
        padding-left: 60px;
    }
    .send{
        float: left;
        height: 30px;
        width: 70%;
    }
    .tgl{
        float : left;
        padding-right : 2%;
        height: 30px;
        width:28%;
    }
    .isi{
        width:100%;
    }
    #kiri{
        padding-right: 60px;
    }
</style> 
<script src="/twitter-bootstrap/twitter-bootstrap-v2/docs/assets/js/bootstrap-scrollspy.js"></script>  
<script src="<?php echo base_url() ?>media/js/libs/jquery-1.8.3.min.js"></script>
<script>
    $(document).ready(function() {
        $('#loading').hide();
        $('#sukses').hide();
        $('#table0').dataTable( {
            "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
            "sPaginationType": "bootstrap",
            //"bProcessing": true,
            //"sAjaxSource": "http://localhost/rpx/analyst/pesan/tampil",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page"
            }
        } );
    });
    function closeDialog () {
        $('#add_pesan').modal('hide'); 
    };
    function okClicked () {
        var $pesan = document.getElementById ("pesan").value;
        closeDialog ();
        $('#loading').show();
        setTimeout('$("#loading").hide()',3000);
        //ajax send
        
        $.ajax({
            type: "POST",
            url: "http://localhost/rpx/manager/pesan/do_pesan",
            dataType: "json",
            data: "pesan="+$pesan,
            cache:false,
            success: 
                function(data){
                if(data.message){
                    $("#sukses").html(data.message);
                    setTimeout('$("#sukses").show()',3000);
                    setTimeout('$("#sukses").hide()',6000);
                }
                pesan.value = "";
                setTimeout('window.location = "http://localhost/rpx/manager/pesan/"',6000);
            }
        
        });

        return false;
        
        //ajax end
        
    };
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>media/media/css/DT_bootstrap.css">
<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>media/media/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>media/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>media/js/bootstrap-dataTable.js"></script>
<div class="page-header">
    <h1>Pesan</h1>
</div>

<div id="add_pesan" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
    <div class="modal-header">
        <a href="#" class="close" data-dismiss="modal" >&times;</a>
        <h3>Pesan ke analyst.</h3>
    </div>
    <div class="modal-body">
        <div class="divDialogElements">
            <input class="xlarge" id="pesan" name="pesan" type="text" placeholder="Type message here"/>
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
    <a data-toggle="modal" href="#add_pesan" class="btn btn-primary btn-large">Add Pesan</a>
</p>
<div class="panel" id="panel-101">
    <div class="content tiles-container">
        <div data-spy="scroll" data-target="#navbarExample" data-offset="50" class="scrollspy-example">  
            <?php
            foreach ($pesan as $psn) {
                if (($this->session->userdata('user_id')) == ($psn->sender)) {
                    ?>
                    <div id="kiri">
                    <?php } else { ?>
                        <div id="kanan">
                        <?php } ?>
                        <div class="send">
                            <h4 align="left"><?php echo $psn->nama ?></h4>
                        </div>
                        <div class="tgl">
                            <h6 align="right"><?php $date = date_create($psn->waktu); echo date_format($date, 'd M Y');  ?></h6>
                        </div>
                        <div class="isi"> 
                            <p align="left">
                                <?php echo $psn->pesan ?>
                        </p>  
                    </div>
                </div>
                <hr>
                <?php } ?>
            </div>  
        </div>
    </div>