import { BASE_URL } from "/js/helpers/gateway.js"
export function renderSuscriptionInfo(suscription, containerEl) {
    containerEl.innerHTML = `
        <h5>PLAN ${suscription.nombre}: ${suscription.cantidad_sms_contratado} SMS</h5>
        <span>Expira el ${new Date(suscription.fecha_fin).toLocaleDateString()}</span>
        <span class="badge badge-primary text-white">${suscription.cantidad_sms_utilizado}/${suscription.cantidad_sms_contratado} SMS</span>
    `;
}

export function createSystemCard(system) {
    const cardEl = document.createElement('div');
    cardEl.className = 'col-md-4 mb-4';
    cardEl.innerHTML = `
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>${system.nombre_sistema}</h5>
                <button class="btn btn-icon btn-primary btn-sm edit-system" data-id="${system.id_sistema_cliente}">
                    <i class="fa fa-edit"></i>
                </button>
            </div>
            <div class="card-body">
                <p class="text-muted">${system.url_sistema}</p>
                <div class="form-group">
                    <label>TOKEN</label>
                    <div class="input-group">
                        <input type="text" class="form-control" value="${system.token_api}" readonly>
                        <button class="btn btn-outline-info copy-token" type="button">
                            <i class="fa fa-copy"></i>
                        </button>
                        <button class="btn btn-outline-warning regenerate-token" type="button" data-id="${system.id_sistema_cliente}">
                            <i class="fa fa-rotate-left"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-3">
                    <label>REFERENCIAS API</label>
                    <div class="d-flex flex-wrap justify-content-between align-items-center m-4">
                        <img src="${BASE_URL()}/img/icons/php-brands-solid.svg" alt="PHP" class="mb-2 icon-hover" height="30">
                        <img src="${BASE_URL()}/img/icons/python-brands-solid.svg" alt="Python" class="mb-2 icon-hover" height="30">
                        <img src="${BASE_URL()}/img/icons/node-js-brands-solid.svg" alt="JavaScript" class="mb-2 icon-hover" height="30">
                        <img src="${BASE_URL()}/img/icons/laravel-brands-solid.svg" alt="Laravel" class="mb-2 icon-hover" height="30">
                        <img src="${BASE_URL()}/img/icons/1907139_codeigniter_logo_media_social_icon.svg" alt="CodeIgniter" class="mb-2 icon-hover" height="30">
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