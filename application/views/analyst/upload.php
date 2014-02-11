<div class="page-header">
    <h1>Upload Transaksi</h1>
</div>

<form class="form-horizontal"  enctype="multipart/form-data" action="<?php echo base_url()?>analyst/upload/do_upload" method="POST" />
<fieldset>
    <div class="control-group">
        <label class="control-label" for="fileInput">Upload File</label>
        <div class="controls">
            <input class="input-file" id="fileInput" name="userfile" type="file" />
            <p class="help-block">Format file adalah .xls</p>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" name="go_upload" class="btn btn-primary">Upload</button>
        <button class="btn">Cancel</button>
    </div>
</fieldset>
</form>

<!-- /Panel Page Database Settings Content -->