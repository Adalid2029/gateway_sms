<?= $this->extend('Admin/layout/master') ?>

<?= $this->section('main-content') ?>

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Morris Chart</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Morris Chart</li>
                    <li class="breadcrumb-item active">Charts</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-sm-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Line Chart</h5>
                </div>
                <div class="card-body chart-block">
                    <div class="flot-chart-container">
                        <div class="flot-chart-placeholder" id="morris-line-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Updating Data</h5>
                </div>
                <div class="card-body chart-block">
                    <div class="flot-chart-container">
                        <div class="flot-chart-placeholder" id="updating-data-morris-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Decimal Data</h5>
                </div>
                <div class="card-body chart-block">
                    <div class="flot-chart-container">
                        <div class="flot-chart-placeholder float-start" id="decimal-morris-chart"></div>
                        <p class="float-end" id="choices"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Displaying X Labels Diagonally</h5>
                </div>
                <div class="card-body chart-block">
                    <div class="flot-chart-container">
                        <div class="flot-chart-placeholder" id="x-Labels-Diagonally-morris-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Bar Line Chart</h5>
                </div>
                <div class="card-body chart-block">
                    <div class="flot-chart-container">
                        <div class="flot-chart-placeholder" id="bar-line-chart-morris"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Displaying X Labels Diagonally(Bar Chart)</h5>
                </div>
                <div class="card-body chart-block">
                    <div class="flot-chart-container">
                        <div class="flot-chart-placeholder" id="x-lable-morris-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Stacked Bars Chart</h5>
                </div>
                <div class="card-body chart-block">
                    <div class="flot-chart-container">
                        <div class="flot-chart-placeholder" id="stacked-bar-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Simple Bar Charts</h5>
                </div>
                <div class="card-body chart-block">
                    <div class="flot-chart-container">
                        <div class="flot-chart-placeholder" id="morris-simple-bar-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Area charts behaving like line Charts</h5>
                </div>
                <div class="card-body chart-block">
                    <div class="flot-chart-container">
                        <div class="flot-chart-placeholder" id="graph123"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Donut Color Chart</h5>
                </div>
                <div class="card-body chart-block">
                    <div class="flot-chart-container">
                        <div class="flot-chart-placeholder" id="donut-color-chart-morris"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?=base_url()?>/assets/js/chart/morris-chart/raphael.js"></script>
<script src="<?=base_url()?>/assets/js/chart/morris-chart/morris.js"> </script>
<script src="<?=base_url()?>/assets/js/chart/morris-chart/prettify.min.js"></script>
<script src="<?=base_url()?>/assets/js/chart/morris-chart/morris-script.js"></script>
<script src="<?=base_url()?>/assets/js/tooltip-init.js"></script>

<?= $this->endSection() ?>