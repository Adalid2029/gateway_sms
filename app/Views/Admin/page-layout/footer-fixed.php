<?= $this->extend('Admin/page-layout/layout/master') ?>
<?= $this->section('page-html') ?>
<html lang="en">
<?= $this->endSection() ?>

<?= $this->section('page-body') ?>
<body>
<?= $this->endSection() ?>

<?= $this->section('page-content') ?>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Footer fixed</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                        <li class="breadcrumb-item">Page Layout</li>
                        <li class="breadcrumb-item active"> Footer Light</li>
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
                        <h5>Sample Card</h5><span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                    </div>
                    <div class="card-body">
                        <p>
                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                            enim ad minim veniam, quis nostrud exercitation ullamco laboris
                            nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                            in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                            nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                            sunt in culpa qui officia deserunt mollit anim id est laborum."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->endSection() ?>

    <?= $this->section('page-footer') ?>
    <footer class="footer footer-fix">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 footer-copyright text-center">
                    <p class="mb-0">Copyright 2021 © Cuba theme by pixelstrap </p>
                </div>
            </div>
        </div>
    </footer>
    <?= $this->endSection() ?>