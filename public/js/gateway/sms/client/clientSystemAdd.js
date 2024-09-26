import { BASE_URL } from "/js/helpers/gateway.js"
import { loadSystems } from "./clientSystemList.js";

export async function addSystem(formData) {
    try {
        const response = await axios.post(`${BASE_URL}/client/system/add`, formData, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (response.data.success) {
            await loadSystems();  // Refresh the list
        }
        return response.data;
    } catch (error) {
        console.error('Error adding system:', error);
        throw error;
    }
}