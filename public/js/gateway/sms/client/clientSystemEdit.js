import { BASE_URL } from "/js/helpers/gateway.js";
import { loadSystems } from "./clientSystemList.js";

export async function editSystem(url, form, modal, toast, urlList, systemCardsContainer) {
    try {
        const response = await axios.get(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (response.data.type === 'success') {
            const { data, urlUpdateSystem } = response.data;

            form.querySelector('#nombre_sistema').value = data.nombre_sistema;
            form.querySelector('#url_sistema').value = data.url_sistema;

            form.onsubmit = async (e) => {
                e.preventDefault();
                var dataSended = {
                    id_sistema_cliente: data.id_sistema_cliente,
                    nombre_sistema: form.querySelector('#nombre_sistema').value,
                    url_sistema: form.querySelector('#url_sistema').value
                }
                try {
                    const updateResponse = await axios.post(urlUpdateSystem, dataSended, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (updateResponse.data.type === 'success') {
                        modal.hide();
                        toast.mixin().fire({
                            title: 'Sistema actualizado con éxito',
                            icon: 'success'
                        });
                        await loadSystems(urlList, systemCardsContainer);
                    } else {
                        toast.mixin().fire({
                            title: updateResponse.data.message || 'Error al actualizar el sistema',
                            icon: 'error'
                        });
                    }
                } catch (error) {
                    console.error('Error updating system:', error);
                    toast.mixin().fire({
                        title: 'Error al actualizar el sistema',
                        icon: 'error'
                    });
                }
            };

            modal.show();
        } else {
            toast.mixin().fire({
                title: response.data.message,
                icon: 'error'
            });
        }
    } catch (error) {
        console.error('Error editing system:', error);
        toast.mixin().fire({
            title: 'Error al cargar los datos del sistema',
            icon: 'error'
        });
    }
}

export async function regenerateToken(url) {
    try {
        const response = await axios.get(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        return response.data.type === 'success';
    } catch (error) {
        console.error('Error regenerating token:', error);
        throw error;
    }
}