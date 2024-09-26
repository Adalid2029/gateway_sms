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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>PLAN BASICO: 1000 SMS</h5>
                    <span class="text-muted">Expira el 15-08-2025</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <button class="btn btn-primary">Agregar Sistema</button>
                        </div>
                        <div class="col-md-6 text-end">
                            <span class="badge bg-primary p-2">300/1000 SMS</span>
                            <button class="btn btn-secondary">Reporte general</button>
                        </div>
                    </div>

                    <div class="row">
                        <?php
                        $systems = [
                            [
                                'name' => 'SIACOP',
                                'url' => 'https://siacop.upea.bo',
                                'token' => '1251250sdfsdfsdf#$%3J345',
                                'smsCount' => 250
                            ],
                            [
                                'name' => 'SIAPLEST',
                                'url' => 'https://siaplest.upea.bo',
                                'token' => 'T$5250sdfsdfasdf#$%3J34dfsgdfg',
                                'smsCount' => 50
                            ]
                        ];

                        foreach ($systems as $system):
                        ?>
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5><?= $system['name'] ?></h5>
                                        <button class="btn btn-icon btn-primary btn-sm"><i class="icon-settings"></i></button>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted"><?= $system['url'] ?></p>
                                        <div class="form-group">
                                            <label>TOKEN</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="<?= $system['token'] ?>" readonly>
                                                <button class="btn btn-outline-secondary" type="button"><i class="icon-copy"></i></button>
                                                <button class="btn btn-outline-secondary" type="button"><i class="icon-refresh"></i></button>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <label>REFERENCIAS API</label>
                                            <div>
                                                <img src="http://localhost:8080/assets/images/php_logo.png" alt="PHP" class="me-2" height="30">
                                                <img src="http://localhost:8080/assets/images/python_logo.png" alt="Python" class="me-2" height="30">
                                                <img src="http://localhost:8080/assets/images/js_logo.png" alt="JavaScript" height="30">
                                            </div>
                                        </div>
                                        <div class="mt-3 d-flex justify-content-between align-items-center">
                                            <span>SMS enviado: <?= $system['smsCount'] ?></span>
                                            <button class="btn btn-info btn-sm">Reporte</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    alert();
</script>
<?= $this->endSection() ?>