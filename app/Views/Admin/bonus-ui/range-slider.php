<?= $this->extend('Admin/layout/master') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/vendors/range-slider.css">

<?= $this->endSection() ?>

<?= $this->section('main-content') ?>

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Range Slider</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Bonus Ui</li>
                    <li class="breadcrumb-item active">Range Slider</li>
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
                    <h5>Ion Range Slider</h5>
                </div>
                <div class="card-body">
                    <form class="theme-form form-label-align-right range-slider">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label sm-left-text" for="u-range-01">Default</label>
                            <div class="col-md-10">
                                <input id="u-range-01" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label sm-left-text" for="u-range-02">Min-Max Value</label>
                            <div class="col-md-10">
                                <input id="u-range-02" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label sm-left-text" for="u-range-03">Prefix</label>
                            <div class="col-md-10">
                                <input id="u-range-03" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label sm-left-text" for="u-range-04">Nagative value</label>
                            <div class="col-md-10">
                                <input id="u-range-04" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label sm-left-text" for="u-range-05">Steps</label>
                            <div class="col-md-10">
                                <input id="u-range-05" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label sm-left-text" for="u-range-06">Custom Values</label>
                            <div class="col-md-10">
                                <input id="u-range-06" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label sm-left-text" for="u-range-07">Prettify Numbers</label>
                            <div class="col-md-10">
                                <input id="u-range-07" type="text">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-md-2 control-label sm-left-text" for="u-range-08">Disabled</label>
                            <div class="col-md-10">
                                <input id="u-range-08" type="text">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="<?=base_url()?>/assets/js/range-slider/ion.rangeSlider.min.js"></script>
<script src="<?=base_url()?>/assets/js/range-slider/rangeslider-script.js"></script>
<script src="<?=base_url()?>/assets/js/tooltip-init.js"></script>

<?= $this->endSection() ?>