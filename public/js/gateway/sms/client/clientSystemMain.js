import { setModalParameters, Toast } from "/js/helpers/gateway.js";
import { loadSystems } from "./clientSystemList.js";
import { addSystem } from "./clientSystemAdd.js";
import { editSystem, regenerateToken } from "./clientSystemEdit.js";
import { getSystemReport } from "./clientSystemReport.js";
import { getGeneralReport } from "./clientSystemGeneralReport.js";

export function initClientSystem() {
    const addSystemBtn = document.querySelector('#add_system_btn');
    const systemCardsContainer = document.querySelector('#system_cards_container');
    let modal;
    let modalEl;

    addSystemBtn.removeAttribute('disabled');

    loadSystems(systemCardsContainer.dataset.urlList, systemCardsContainer);

    const handleAddSystemClick = () => {
        modalEl = document.querySelector('#kt_modal_add');
        modal = new bootstrap.Modal(modalEl);
        setModalParameters(modal, 'Adicionar nuevo Sistema', "modal-md", false, "static", {}, false);
        const form = document.querySelector('#kt_modal_add-form');
        addSystem(form, modal, systemCardsContainer.dataset.urlList, systemCardsContainer);
    };
    addSystemBtn.removeEventListener('click', handleAddSystemClick);
    addSystemBtn.addEventListener('click', handleAddSystemClick);

    systemCardsContainer.addEventListener('click', async (e) => {
        if (e.target.closest('.edit-system')) {
            const systemId = e.target.closest('.edit-system').dataset.id;
            // Lógica para abrir modal de editar sistema
            modalEl = document.querySelector('#kt_modal_edit'); // Asegúrate de que este ID sea correcto
            modal = new bootstrap.Modal(modalEl);
            setModalParameters(modal, 'Editar Sistema', "modal-md", false, "static", {}, false);
            const form = document.querySelector('#kt_modal_edit-form'); // Asegúrate de que este ID sea correcto
            editSystem(form, modal, systemId);
        } else if (e.target.closest('.copy-token')) {
            const token = e.target.closest('.copy-token').dataset.token;
            navigator.clipboard.writeText(token)
                .then(() => Toast.success('Token copiado al portapapeles'))
                .catch(() => Toast.error('No se pudo copiar el token'));
        } else if (e.target.closest('.regenerate-token')) {
            const systemId = e.target.closest('.regenerate-token').dataset.id;
            try {
                await regenerateToken(systemId);
                Toast.success('Token regenerado con éxito');
                await loadSystems(systemCardsContainer.dataset.urlList, systemCardsContainer);
            } catch (error) {
                Toast.error('Error al regenerar el token');
            }
        } else if (e.target.closest('.system-report')) {
            const systemId = e.target.closest('.system-report').dataset.id;
            try {
                const report = await getSystemReport(systemId);
                // Aquí puedes abrir un modal o mostrar el reporte de alguna manera
                console.log(report); // Elimina esto en producción
                Toast.success('Reporte generado con éxito');
            } catch (error) {
                Toast.error('Error al generar el reporte del sistema');
            }
        }
    });

    document.querySelector('#generalReportBtn').addEventListener('click', async () => {
        try {
            const report = await getGeneralReport();
            // Aquí puedes abrir un modal o mostrar el reporte general de alguna manera
            console.log(report); // Elimina esto en producción
            Toast.success('Reporte general generado con éxito');
        } catch (error) {
            Toast.error('Error al generar el reporte general');
        }
    });
}

if (!window.clientSystemInitialized) {
    window.clientSystemInitialized = true;
    document.addEventListener('DOMContentLoaded', initClientSystem);
}