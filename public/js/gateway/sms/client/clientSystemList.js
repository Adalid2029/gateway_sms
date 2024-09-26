import { BASE_URL } from "/js/helpers/gateway.js"
import { renderSuscriptionInfo, createSystemCard } from "./clientSystemView.js";

export async function loadSystems(urlList, systemCardsContainer) {
    try {
        const response = await axios.get(urlList, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const { suscriptionActive, systems } = response.data;

        const suscriptionInfoEl = document.querySelector('#suscription_info');
        renderSuscriptionInfo(suscriptionActive, suscriptionInfoEl);

        systemCardsContainer.innerHTML = '';
        systems.forEach(system => {
            const cardEl = createSystemCard(system);
            systemCardsContainer.appendChild(cardEl);
        });
    } catch (error) {
        console.error('Error loading systems:', error);
    }
}