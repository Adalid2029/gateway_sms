<?= $this->extend('Admin/layout/master') ?>

<?= $this->section('css') ?>

<link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/vendors/vector-map.css">

<?= $this->endSection() ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Vector Maps</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Maps</li>
                    <li class="breadcrumb-item active">Vector Maps</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h5>VECTOR WORLD MAP</h5><span>Below Map is displaying the world map.</span>
                </div>
                <div class="card-body">
                    <div class="jvector-map-height" id="world-map"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h5>VECTOR USA MAP</h5><span>Below Map is displaying the usa map.</span>
                </div>
                <div class="card-body">
                    <div class="jvector-map-height" id="usa"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h5>VECTOR CANADA MAP</h5><span>Below Map is displaying the canada map.</span>
                </div>
                <div class="card-body">
                    <div class="jvector-map-height" id="canada"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h5>VECTOR INDIA MAP</h5><span>Below Map is displaying the india map.</span>
                </div>
                <div class="card-body">
                    <div class="jvector-map-height" id="india"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h5>VECTOR ASIA MAP</h5><span>Below Map is displaying the asia map.</span>
                </div>
                <div class="card-body">
                    <div class="jvector-map-height" id="asia"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h5>VECTOR CANADA MAP</h5><span>Below Map is displaying the uk map.</span>
                </div>
                <div class="card-body">
                    <div class="jvector-map-height" id="uk"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h5>VECTOR CHICAGO MAP</h5><span>Below Map is displaying the chicago map.</span>
                </div>
                <div class="card-body">
                    <div class="jvector-map-height" id="chicago"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h5>VECTOR AUSTRALIA MAP</h5><span>Below Map is displaying the australia map.</span>
                </div>
                <div class="card-body">
                    <div class="jvector-map-height" id="australia"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="<?=base_url()?>/assets/js/vector-map/jquery-jvectormap-2.0.2.min.js"></script>
<script src="<?=base_url()?>/assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?=base_url()?>/assets/js/vector-map/map/jquery-jvectormap-us-aea-en.js"></script>
<script src="<?=base_url()?>/assets/js/vector-map/map/jquery-jvectormap-uk-mill-en.js"></script>
<script src="<?=base_url()?>/assets/js/vector-map/map/jquery-jvectormap-au-mill.js"></script>
<script src="<?=base_url()?>/assets/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js"></script>
<script src="<?=base_url()?>/assets/js/vector-map/map/jquery-jvectormap-in-mill.js"></script>
<script src="<?=base_url()?>/assets/js/vector-map/map/jquery-jvectormap-asia-mill.js"></script>
<script src="<?=base_url()?>/assets/js/vector-map/map-vector.js"></script>
<script src="<?=base_url()?>/assets/js/tooltip-init.js"></script>

<?= $this->endSection() ?>