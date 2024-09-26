import { BASE_URL } from "/js/helpers/gateway.js"

export async function getGeneralReport() {
    try {
        const response = await axios.get(`${BASE_URL}/client/system/general-report`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        return response.data;
    } catch (error) {
        console.error('Error getting general report:', error);
        throw error;
    }
}