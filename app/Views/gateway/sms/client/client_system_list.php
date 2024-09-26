<?= $this->extend('layout/master') ?>
<?= $this->section('main-content') ?>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Dashboard de Sistemas</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="http://localhost:8080/">
                            <svg class="stroke-icon">
                                <use href="http://localhost:8080//assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Sistemas</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center" id="suscription_info">
                    <h5>PLAN BASICO: 0000 SMS</h5>
                    <span class="text-muted">Expira el 15-08-2025</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <button id="add_system_btn" class="btn btn-primary">Agregar Sistema</button>
                        </div>
                        <div class="col-md-6 text-end">
                            <button id="generalReportBtn" class="btn btn-secondary">Reporte general</button>
                        </div>
                    </div>
                    <div id="system_cards_container" class="row" data-url-list="<?= $urlListSystem ?>"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="kt_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="kt_modal-dialog" role="document">
        <div class="modal-content" id="kt_modal-dialog-content">
            <div class="modal-header" id="kt_modal-dialog-header">
                <h5 class="modal-title" id="kt_modal-title">Modal title</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="kt_modal-dialog-body">
                <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button">Save changes</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script type="module">
    import {
        initClientSystem
    } from "/js/gateway/sms/client/clientSystemMain.js";

    document.addEventListener('DOMContentLoaded', initClientSystem);
</script>
<?= $this->endSection() ?>