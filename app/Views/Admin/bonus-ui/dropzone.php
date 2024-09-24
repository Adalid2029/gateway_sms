<?= $this->extend('Admin/layout/master') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/vendors/dropzone.css">

<?= $this->endSection() ?>

<?= $this->section('main-content') ?>

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Dropzone</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Bonus Ui</li>
                    <li class="breadcrumb-item active">Dropzone</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Single File Upload</h5>
                </div>
                <div class="card-body">
                    <form class="dropzone" id="singleFileUpload" action="/upload.php">
                        <div class="dz-message needsclick"><i class="icon-cloud-up"></i>
                            <h6>Drop files here or click to upload.</h6><span class="note needsclick">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Multi File Upload</h5>
                </div>
                <div class="card-body">
                    <form class="dropzone dropzone-primary" id="multiFileUpload" action="/upload.php">
                        <div class="dz-message needsclick"><i class="icon-cloud-up"></i>
                            <h6>Drop files here or click to upload.</h6><span class="note needsclick">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>File Type Validation</h5>
                </div>
                <div class="card-body">
                    <form class="dropzone dropzone-info" id="fileTypeValidation" action="/upload.php">
                        <div class="dz-message needsclick"><i class="icon-cloud-up"></i>
                            <h6>Drop files here or click to upload.</h6><span class="note needsclick">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?=base_url()?>/assets/js/dropzone/dropzone.js"></script>
<script src="<?=base_url()?>/assets/js/dropzone/dropzone-script.js"></script>
<script src="<?=base_url()?>/assets/js/tooltip-init.js"></script>

<?= $this->endSection() ?>