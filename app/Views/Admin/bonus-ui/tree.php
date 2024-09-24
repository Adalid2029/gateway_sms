<?= $this->extend('Admin/layout/master') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/vendors/tree.css">

<?= $this->endSection() ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Tree View</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item"> Bonus Ui</li>
                    <li class="breadcrumb-item active">Tree View</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>Basic Tree</h5>
                </div>
                <div class="card-body">
                    <div id="treeBasic">
                        <ul>
                            <li>Admin
                                <ul>
                                    <li data-jstree="{&quot;opened&quot;:true}">Assets
                                        <ul>
                                            <li data-jstree="{&quot;opened&quot;:false}">Css
                                                <ul>
                                                    <li data-jstree="{&quot;selected&quot;:false,&quot;type&quot;:&quot;file&quot;}">Css one</li>
                                                    <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Css two</li>
                                                </ul>
                                            </li>
                                            <li data-jstree="{&quot;opened&quot;:true}">Js
                                                <ul>
                                                    <li data-jstree="{&quot;selected&quot;:true,&quot;type&quot;:&quot;file&quot;}">Js one</li>
                                                    <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Js two</li>
                                                </ul>
                                            </li>
                                            <li data-jstree="{&quot;opened&quot;:true}">Scss
                                                <ul>
                                                    <li data-jstree="{&quot;opened&quot;:false}">Sub Child
                                                        <ul>
                                                            <li data-jstree="{&quot;selected&quot;:false,&quot;type&quot;:&quot;file&quot;}">Sub File</li>
                                                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Sub File</li>
                                                        </ul>
                                                    </li>
                                                    <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Scss two</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li data-jstree="{&quot;opened&quot;:true}">Default
                                        <ul>
                                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Dashboard</li>
                                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Typography</li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">index file</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>Checkbox Tree</h5>
                </div>
                <div class="card-body">
                    <div id="treecheckbox">
                        <ul>
                            <li>Admin
                                <ul>
                                    <li data-jstree="{&quot;opened&quot;:true}">Assets
                                        <ul>
                                            <li data-jstree="{&quot;opened&quot;:false}">Css
                                                <ul>
                                                    <li data-jstree="{&quot;selected&quot;:false,&quot;type&quot;:&quot;file&quot;}">Css one</li>
                                                    <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Css two</li>
                                                </ul>
                                            </li>
                                            <li data-jstree="{&quot;opened&quot;:true}">Js
                                                <ul>
                                                    <li data-jstree="{&quot;selected&quot;:true,&quot;type&quot;:&quot;file&quot;}">Js one</li>
                                                    <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Js two</li>
                                                </ul>
                                            </li>
                                            <li data-jstree="{&quot;opened&quot;:true}">Scss
                                                <ul>
                                                    <li data-jstree="{&quot;opened&quot;:false}">Sub Child
                                                        <ul>
                                                            <li data-jstree="{&quot;selected&quot;:false,&quot;type&quot;:&quot;file&quot;}">Sub File</li>
                                                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Sub File</li>
                                                        </ul>
                                                    </li>
                                                    <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Scss two</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li data-jstree="{&quot;opened&quot;:true}">Default
                                        <ul>
                                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Dashboard</li>
                                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Typography</li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">index file</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>Drag Tree</h5>
                </div>
                <div class="card-body">
                    <div id="dragTree">
                        <ul>
                            <li>Admin
                                <ul>
                                    <li data-jstree="{&quot;opened&quot;:true}">Assets
                                        <ul>
                                            <li data-jstree="{&quot;opened&quot;:false}">Css
                                                <ul>
                                                    <li data-jstree="{&quot;selected&quot;:false,&quot;type&quot;:&quot;file&quot;}">Css one</li>
                                                    <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Css two</li>
                                                </ul>
                                            </li>
                                            <li data-jstree="{&quot;opened&quot;:true}">Js
                                                <ul>
                                                    <li data-jstree="{&quot;selected&quot;:true,&quot;type&quot;:&quot;file&quot;}">Js one</li>
                                                    <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Js two</li>
                                                </ul>
                                            </li>
                                            <li data-jstree="{&quot;opened&quot;:true}">Scss
                                                <ul>
                                                    <li data-jstree="{&quot;opened&quot;:false}">Sub Child
                                                        <ul>
                                                            <li data-jstree="{&quot;selected&quot;:false,&quot;type&quot;:&quot;file&quot;}">Sub File</li>
                                                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Sub File</li>
                                                        </ul>
                                                    </li>
                                                    <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Scss two</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li data-jstree="{&quot;opened&quot;:true}">Default
                                        <ul>
                                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Dashboard</li>
                                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Typography</li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">index file</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>Contextmenu Tree</h5>
                </div>
                <div class="card-body">
                    <div id="contextmenu">
                        <ul>
                            <li>Admin
                                <ul>
                                    <li data-jstree="{&quot;opened&quot;:true}">Assets
                                        <ul>
                                            <li data-jstree="{&quot;opened&quot;:false}">Css
                                                <ul>
                                                    <li data-jstree="{&quot;selected&quot;:false,&quot;type&quot;:&quot;file&quot;}">Css one</li>
                                                    <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Css two</li>
                                                </ul>
                                            </li>
                                            <li data-jstree="{&quot;opened&quot;:true}">Js
                                                <ul>
                                                    <li data-jstree="{&quot;selected&quot;:true,&quot;type&quot;:&quot;file&quot;}">Js one</li>
                                                    <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Js two</li>
                                                </ul>
                                            </li>
                                            <li data-jstree="{&quot;opened&quot;:true}">Scss
                                                <ul>
                                                    <li data-jstree="{&quot;opened&quot;:false}">Sub Child
                                                        <ul>
                                                            <li data-jstree="{&quot;selected&quot;:false,&quot;type&quot;:&quot;file&quot;}">Sub File</li>
                                                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Sub File</li>
                                                        </ul>
                                                    </li>
                                                    <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Scss two</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li data-jstree="{&quot;opened&quot;:true}">Default
                                        <ul>
                                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Dashboard</li>
                                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">Typography</li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li data-jstree="{&quot;type&quot;:&quot;file&quot;}">index file</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->


<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="<?=base_url()?>/assets/js/tree/jstree.min.js"></script>
<script src="<?=base_url()?>/assets/js/tree/tree.js"></script>
<script src="<?=base_url()?>/assets/js/tooltip-init.js"></script>

<?= $this->endSection() ?>