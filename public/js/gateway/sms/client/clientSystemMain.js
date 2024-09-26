import { setModalParameters } from "/js/helpers/gateway.js";
import { loadSystems } from "./clientSystemList.js";
import { addSystem } from "./clientSystemAdd.js";
import { editSystem, regenerateToken } from "./clientSystemEdit.js";
import { getSystemReport } from "./clientSystemReport.js";
import { getGeneralReport } from "./clientSystemGeneralReport.js";

export function initClientSystem() {

    var addSystemAdd = document.querySelector('#add_system_btn');
    var systemCardsContainer = document.querySelector('#system_cards_container');
    var modal;
    var modalEl;

    loadSystems(systemCardsContainer.dataset.urlList, systemCardsContainer);

    addSystemAdd.addEventListener('click', () => {
        modalEl = document.querySelector('#kt_modal');
        if (!modalEl) {
            return;
        }
        modal = new bootstrap.Modal(modalEl);
        setModalParameters(modal, 'Adicionar nuevo Sistema', "modal-lg", false, "static", {}, false);

    });

    systemCardsContainer.addEventListener('click', async (e) => {
        if (e.target.closest('.edit-system')) {
            const systemId = e.target.closest('.edit-system').dataset.id;
            // Lógica para abrir modal de editar sistema
        } else if (e.target.closest('.copy-token')) {
            // Lógica para copiar token 
        } else if (e.target.closest('.regenerate-token')) {
            const systemId = e.target.closest('.regenerate-token').dataset.id;
            await regenerateToken(systemId);
        } else if (e.target.closest('.system-report')) {
            const systemId = e.target.closest('.system-report').dataset.id;
            const report = await getSystemReport(systemId);
            // Lógica para mostrar el reporte
        }
    });

    document.querySelector('#generalReportBtn').addEventListener('click', async () => {
        const report = await getGeneralReport();
        // Lógica para mostrar el reporte general
    });
}