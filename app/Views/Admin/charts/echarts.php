<?= $this->extend('Admin/layout/master') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/vendors/echart.css">

<?= $this->endSection() ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Echarts</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Charts</li>
                    <li class="breadcrumb-item active">Echarts</li>
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
                    <h5>Basic Area Chart </h5>
                </div>
                <div class="card-body">
                    <div class="apache-cotainer" id="area-echart"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Area pie chart</h5>
                </div>
                <div class="card-body">
                    <div class="apache-cotainer" id="echart-pie"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Bar polar chart</h5>
                </div>
                <div class="card-body">
                    <div class="apache-cotainer" id="echart-polar"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5>Bar chart</h5>
                </div>
                <div class="card-body">
                    <div class="apache-cotainer-large" id="echart-bar"> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5>Bar chart 2</h5>
                </div>
                <div class="card-body">
                    <div class="apache-cotainer-large" id="echart-bar2"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Boxplot chart</h5>
                </div>
                <div class="card-body">
                    <div class="apache-cotainer boxplot-cotainer" id="echart-boxplot"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>lines clip chart</h5>
                </div>
                <div class="card-body clip-chart-wrapper">
                    <div class="apache-cotainer" id="lines-clip"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5>line visual chart</h5>
                </div>
                <div class="card-body">
                    <div class="apache-cotainer" id="line-visual"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>angle chart</h5>
                </div>
                <div class="card-body">
                    <div class="apache-cotainer" id="texture-bar-by-clipPath"> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>gauge chart</h5>
                </div>
                <div class="card-body">
                    <div class="apache-cotainer" id="echart-gauge"> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5>line visual chart 2</h5>
                </div>
                <div class="card-body">
                    <div class="apache-cotainer" id="line-visulH"> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5>pictorial repeat chart</h5>
                </div>
                <div class="card-body">
                    <div class="apache-cotainer" id="dynamic-data"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 xl-100 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>radar chart</h5>
                </div>
                <div class="card-body">
                    <div class="apache-cotainer" id="echart-radar"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 xl-100 box-col-12">
            <div class="card">
                <div class="card-header">
                    <h5>polar line chart</h5>
                </div>
                <div class="card-body">
                    <div class="apache-container polar-line" id="main0"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>pie rich text chart</h5>
                </div>
                <div class="card-body">
                    <div class="apache-container" id="echart-pierich"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>pictorial single chart</h5>
                </div>
                <div class="card-body">
                    <div class="apache-container" id="dotted"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card note p-20 d-inline-block w-100"> Echarts for more options please refer <a href="https://echarts.apache.org/examples/en/index.html" target="_blank">echart Official site </a>And <a href="https://github.com/apache/echarts" target="_blank">githup link</a></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url() ?>/assets/js/chart/echart/esl.js"></script>
<script src="<?= base_url() ?>/assets/js/chart/echart/config.js"></script>
<script src="<?= base_url() ?>/assets/js/chart/echart/pie-chart/facePrint.js"></script>
<script src="<?= base_url() ?>/assets/js/chart/echart/pie-chart/testHelper.js"></script>
<script src="<?= base_url() ?>/assets/js/chart/echart/pie-chart/custom-transition-texture.js"></script>
<script src="<?= base_url() ?>/assets/js/chart/echart/data/symbols.js"></script>
<script src="<?= base_url() ?>/assets/js/chart/echart/custom.js"></script>
<script src="<?= base_url() ?>/assets/js/tooltip-init.js"></script>

<?= $this->endSection() ?>