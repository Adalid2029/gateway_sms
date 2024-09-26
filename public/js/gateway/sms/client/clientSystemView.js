export function renderSuscriptionInfo(suscription, containerEl) {
    containerEl.innerHTML = `
        <h5>PLAN ${suscription.nombre}: ${suscription.cantidad_sms_contratado} SMS</h5>
        <span>Expira el ${new Date(suscription.fecha_fin).toLocaleDateString()}</span>
        <span class="badge badge-primary text-white">${suscription.cantidad_sms_utilizado}/${suscription.cantidad_sms_contratado} SMS</span>
    `;
}

export function createSystemCard(system) {
    const cardEl = document.createElement('div');
    cardEl.className = 'col-md-6 mb-4';
    cardEl.innerHTML = `
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>${system.nombre_sistema}</h5>
                <button class="btn btn-icon btn-primary btn-sm edit-system" data-id="${system.id_sistema_cliente}">
                    <i class="icon-settings"></i>
                </button>
            </div>
            <div class="card-body">
                <p class="text-muted">${system.url_sistema}</p>
                <div class="form-group">
                    <label>TOKEN</label>
                    <div class="input-group">
                        <input type="text" class="form-control" value="${system.token_api}" readonly>
                        <button class="btn btn-outline-secondary copy-token" type="button">
                            <i class="icon-copy"></i>
                        </button>
                        <button class="btn btn-outline-secondary regenerate-token" type="button" data-id="${system.id_sistema_cliente}">
                            <i class="icon-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-3">
                    <label>REFERENCIAS API</label>
                    <div>
                        <img src="/assets/images/php_logo.png" alt="PHP" class="me-2" height="30">
                        <img src="/assets/images/python_logo.png" alt="Python" class="me-2" height="30">
                        <img src="/assets/images/js_logo.png" alt="JavaScript" height="30">
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <span>SMS enviado: ${system.sms_enviados || 0}</span>
                    <button class="btn btn-info btn-sm system-report" data-id="${system.id_sistema_cliente}">Reporte</button>
                </div>
            </div>
        </div>
    `;
    return cardEl;
}