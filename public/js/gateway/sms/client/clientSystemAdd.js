import { BASE_URL, Toast } from "/js/helpers/gateway.js";
import { loadSystems } from "./clientSystemList.js";
let toast = new Toast();
let validator = null;

export function addSystem(form, modal, urlList, systemCardsContainer) {
    const initValidation = () => {
        if (validator) {
            validator.destroy();
        }
        validator = FormValidation.formValidation(form, {
            fields: {
                nombre_sistema: {
                    validators: {
                        notEmpty: {
                            message: 'El nombre del sistema es requerido'
                        }
                    }
                },
                url_sistema: {
                    validators: {
                        notEmpty: {
                            message: 'La URL del sistema es requerida'
                        },
                        uri: {
                            message: 'La URL no es válida'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: 'is-invalid',
                    eleValidClass: 'is-valid'
                }),
            }
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.insertAdjacentHTML('afterbegin', '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ');

        const status = await validator.validate();
        if (status === 'Valid') {
            try {
                const formData = new FormData(form);
                const data = {
                    nombre_sistema: formData.get('nombre_sistema'),
                    url_sistema: formData.get('url_sistema')
                };

                const response = await axios.post(form.action, data, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/json' }
                });

                if (response.data.type === 'success') {
                    await loadSystems(urlList, systemCardsContainer);
                    form.reset();
                    toast.mixin().fire({
                        icon: 'success',
                        title: 'Sistema agregado',
                    });
                    modal.hide();
                } else {
                    toast.mixin().fire({
                        icon: 'error',
                        title: 'Error al agregar el sistema',
                        text: response.data.message
                    });
                    submitButton.disabled = false;
                    submitButton.querySelector('.spinner-border')?.remove();
                }
            } catch (error) {
                console.error('Error adding system:', error);
                toast.mixin().fire({
                    icon: 'error',
                    title: 'Error al agregar el sistema',
                    text: 'Por favor, intenta de nuevo'
                });
                submitButton.disabled = false;
                submitButton.querySelector('.spinner-border')?.remove();
            }
        } else {
            submitButton.disabled = false;
            submitButton.querySelector('.spinner-border')?.remove();
            toast.mixin().fire({
                icon: 'error',
                title: 'Error al agregar el sistema',
                text: 'Por favor, completa correctamente el formulario'
            });
        }

        submitButton.disabled = false;
        submitButton.querySelector('.spinner-border')?.remove();
    };

    initValidation();

    // Usar una función nombrada para poder removerla si es necesario
    const submitHandler = (e) => handleSubmit(e);
    form.removeEventListener('submit', submitHandler);
    form.addEventListener('submit', submitHandler);

    modal._element.addEventListener('shown.bs.modal', function () {
        form.reset();
        if (validator) {
            validator.resetForm(true);
        }
    });
}