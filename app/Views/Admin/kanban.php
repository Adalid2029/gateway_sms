<?= $this->extend('Admin/layout/master') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/vendors/animate.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/vendors/jkanban.css">

<?= $this->endSection() ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>
                    Kanban Board</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item"> Apps</li>
                    <li class="breadcrumb-item active"> Kanban Board</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid jkanban-container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Default Demo </h5>
                </div>
                <div class="card-body">
                    <div id="demo1"></div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Custom Board </h5>
                    <p class="mb-0">| colors, gutter, click on board&apos;s item and restricting which boards to drag items to </p>
                </div>
                <div class="card-body">
                    <div id="demo2"></div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>API</h5>
                    <p class="mb-0">add item, add board, delete board: </p>
                </div>
                <div class="card-body">
                    <div id="demo3"></div>
                    <button class="btn btn-success" id="addDefault">Add &quot;Default&quot; board</button>
                    <button class="btn btn-success" id="addToDo">Add element in &quot;To Do&quot; Board</button>
                    <button class="btn btn-danger" id="removeBoard">Remove &quot;Done&quot; Board</button>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card note p-20">jKanban is Pure agnostic Javascript plugin for Kanban boards for more options please refer <a href="http://www.riccardotartaglia.it/jkanban/" target="_blank">jkanban Official site </a>And <a href="https://github.com/riktar/jkanban" target="_blank">githup link</a></div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="<?=base_url()?>/assets/js/jkanban/jkanban.js"></script>
<script src="<?=base_url()?>/assets/js/jkanban/custom.js"></script>
<script src="<?=base_url()?>/assets/js/typeahead/handlebars.js"></script>
<script src="<?=base_url()?>/assets/js/typeahead/typeahead.bundle.js"></script>
<script src="<?=base_url()?>/assets/js/typeahead/typeahead.custom.js"></script>
<script src="<?=base_url()?>/assets/js/typeahead-search/handlebars.js"></script>
<script src="<?=base_url()?>/assets/js/typeahead-search/typeahead-custom.js"></script>
<script src="<?=base_url()?>/assets/js/tooltip-init.js"></script>

<?= $this->endSection() ?>