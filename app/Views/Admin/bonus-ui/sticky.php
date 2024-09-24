<?= $this->extend('Admin/layout/master') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/vendors/sticky.css">

<?= $this->endSection() ?>

<?= $this->section('main-content') ?>

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Sticky</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Bonus Ui</li>
                    <li class="breadcrumb-item active">Sticky</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts                    -->
<div class="container-fluid">
    <div class="row sticky-header-main">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Sticky Note <a class="btn btn-primary pull-right m-l-10" id="add_new" href="javascript:;">Add New Note</a></h5>
                </div>
                <div class="card-body">
                    <div class="sticky-note" id="board"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="<?=base_url()?>/assets/js/jquery.ui.min.js"></script>
<script src="<?=base_url()?>/assets/js/sticky/sticky.js"></script>
<script src="<?=base_url()?>/assets/js/tooltip-init.js"></script>

<?= $this->endSection() ?>