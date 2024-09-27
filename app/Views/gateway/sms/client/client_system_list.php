<?= $this->extend('layout/master') ?>
<?= $this->section('css') ?>
<style>
    .icon-hover {
        transition: transform 0.3s ease, opacity 0.3s ease;
        /* Suaviza el efecto */
    }

    .icon-hover:hover {
        transform: scale(1.2);
        /* Aumenta el tamaño al 120% */
        opacity: 0.8;
        /* Reduce la opacidad ligeramente */
    }
</style>
<?= $this->endSection() ?>
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
                            <button id="add_system_btn" class="btn btn-primary" disabled>Agregar Sistema</button>
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

<div class="modal fade" id="kt_modal_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="kt_modal_add-dialog" role="document">
        <div class="modal-content" id="kt_modal_add-dialog-content">
            <div class="modal-header" id="kt_modal_add-dialog-header">
                <h5 class="modal-title" id="kt_modal_add-title">Modal title</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="kt_modal_add-form" class="form" novalidate="novalidate" action="<?= $urlAddSystem ?>" method="POST">
                <div class="modal-body" id="kt_modal_add-dialog-body">
                    <div class="row g-3 mb-4">
                        <div class="col fv-row">
                            <label class="form-label" for="nombre_sistema">Nombre sistema</label>
                            <input class="form-control" id="nombre_sistema" type="text" name="nombre_sistema" value="Sistema nuevo" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col fv-row">
                            <label class="form-label" for="url_sistema">Url sistema</label>
                            <input class="form-control" id="url_sistema" type="text" name="url_sistema" value="https://siacop.upea.bo" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
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