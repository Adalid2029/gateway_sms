<?= $this->extend('Admin/page-layout/layout/master') ?>
<?= $this->section('page-html') ?>
<html lang="en">
<?= $this->endSection() ?>

<?= $this->section('page-body') ?>
    <body class="box-layout">
<?= $this->endSection() ?>

<?= $this->section('page-content') ?>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Box Layout</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                                <svg class="stroke-icon">
                                    <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Page Layout</li>
                        <li class="breadcrumb-item active">Box Layout</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card alert alert-primary" role="alert">
                    <h4 class="alert-heading">Tip!</h4>
                    <p>
                        Add class="box-layout" attribute to get this layout. The boxed layout is helpful when working on
                        large screens because it prevents the site from stretching very wide.
                    </p>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Title</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="fa fa-spin fa-cog"></i></li>
                                <li><i class="view-html fa fa-code"></i></li>
                                <li><i class="icofont icofont-maximize full-card"></i></li>
                                <li><i class="icofont icofont-minus minimize-card"></i></li>
                                <li><i class="icofont icofont-refresh reload-card"></i></li>
                                <li><i class="icofont icofont-error close-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body"><span>Start creating your amazing application!</span>
                        <div class="code-box-copy">
                            <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                            <pre><code class="language-html" id="example-head">&lt;!-- Cod Box Copy begin --&gt;
&lt;div class=&quot;card-body&quot;&gt;
&lt;span&gt;Start creating your amazing application!
&lt;/span&gt;
&lt;/div&gt;
&lt;!-- Cod Box Copy end --&gt;</code></pre>
                        </div>
                    </div>
                    <div class="card-footer">
                        <h6 class="mb-0">Card Footer</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

<?= $this->endSection() ?>

<?= $this->section('page-footer') ?>
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 footer-copyright text-center">
                    <p class="mb-0">Copyright <?php echo date("Y"); ?> © Cuba theme by pixelstrap </p>
                </div>
            </div>
        </div>
    </footer>
<?= $this->endSection() ?>
