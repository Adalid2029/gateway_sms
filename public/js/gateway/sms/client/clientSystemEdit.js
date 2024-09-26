import { BASE_URL } from "/js/helpers/gateway.js"
import { loadSystems } from "./clientSystemList.js";

export async function editSystem(systemId, formData) {
    try {
        const response = await axios.post(`${BASE_URL}/client/system/update`, formData, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (response.data.success) {
            await loadSystems();  // Refresh the list
        }
        return response.data;
    } catch (error) {
        console.error('Error editing system:', error);
        throw error;
    }
}

export async function regenerateToken(systemId) {
    try {
        const response = await axios.get(`${BASE_URL}/client/system/regenerate-token/${systemId}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (response.data.success) {
            await loadSystems();  // Refresh the list
        }
        return response.data;
    } catch (error) {
        console.error('Error regenerating token:', error);
        throw error;
    }
}