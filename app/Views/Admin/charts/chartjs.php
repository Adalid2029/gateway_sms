<?= $this->extend('Admin/layout/master') ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>ChartJS Chart</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Charts</li>
                    <li class="breadcrumb-item active">ChartJS Chart</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-6 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Bar Chart</h5>
                </div>
                <div class="card-body chart-block">
                    <canvas id="myBarGraph"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Line Graph</h5>
                </div>
                <div class="card-body chart-block">
                    <canvas id="myGraph"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Radar Graph</h5>
                </div>
                <div class="card-body chart-block">
                    <canvas id="myRadarGraph"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Line Chart</h5>
                </div>
                <div class="card-body chart-block">
                    <canvas id="myLineCharts"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Doughnut Chart</h5>
                </div>
                <div class="card-body chart-block chart-vertical-center">
                    <canvas id="myDoughnutGraph"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Polar Chart</h5>
                </div>
                <div class="card-body chart-block chart-vertical-center">
                    <canvas id="myPolarGraph"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?=base_url()?>/assets/js/chart/chartjs/chart.min.js"></script>
<script src="<?=base_url()?>/assets/js/chart/chartjs/chart.custom.js"></script>
<script src="<?=base_url()?>/assets/js/tooltip-init.js"></script>

<?= $this->endSection() ?>