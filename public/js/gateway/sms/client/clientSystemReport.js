import { BASE_URL } from "/js/helpers/gateway.js"

export async function getSystemReport(systemId) {
    try {
        const response = await axios.get(`${BASE_URL}/client/system/report/${systemId}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        return response.data;
    } catch (error) {
        console.error('Error getting system report:', error);
        throw error;
    }
}