import { setModalParameters, Toast, BASE_URL } from "/js/helpers/gateway.js";
import { loadSystems } from "./clientSystemList.js";
import { addSystem } from "./clientSystemAdd.js";
import { editSystem, regenerateToken } from "./clientSystemEdit.js";
import { getSystemReport } from "./clientSystemReport.js";
import { getGeneralReport } from "./clientSystemGeneralReport.js";

var toast = new Toast();
export function initClientSystem() {
    const addSystemBtn = document.querySelector('#add_system_btn');
    const systemCardsContainer = document.querySelector('#system_cards_container');
    let modal, modalExampleApi;
    let modalEl, modalExampleApiEl;
    let form;
    addSystemBtn.removeAttribute('disabled');

    loadSystems(systemCardsContainer.dataset.urlList, systemCardsContainer);
    modalEl = document.querySelector('#kt_modal_add');
    modal = new bootstrap.Modal(modalEl);
    modalExampleApiEl = document.querySelector('#kt_modal_example_api');
    modalExampleApi = new bootstrap.Modal(modalExampleApiEl);
    form = document.querySelector('#kt_modal_add-form');

    const handleAddSystemClick = () => {
        setModalParameters(modal, 'Adicionar nuevo Sistema', "modal-md", false, "static", {}, false);
        addSystem(form, modal, systemCardsContainer.dataset.urlList, systemCardsContainer);
    };
    addSystemBtn.removeEventListener('click', handleAddSystemClick);
    addSystemBtn.addEventListener('click', handleAddSystemClick);

    systemCardsContainer.addEventListener('click', async (e) => {
        if (e.target.closest('.edit-system')) {
            try {
                const url = e.target.closest('.edit-system').dataset.url;
                setModalParameters(modal, 'Editar Sistema', "modal-md", false, "static", {}, false);
                await editSystem(url, form, modal, toast, systemCardsContainer.dataset.urlList, systemCardsContainer);
            } catch (error) {
                console.error('Error editing system:', error);
                toast.mixin().fire({
                    title: 'Error al cargar los datos del sistema',
                    icon: 'error'
                });
            }
        } else if (e.target.closest('.regenerate-token')) {
            const url = e.target.closest('.regenerate-token').dataset.url;
            try {
                const success = await regenerateToken(url);
                if (success) {
                    toast.mixin().fire({
                        title: 'Token regenerado con éxito',
                        icon: 'success'
                    });
                    await loadSystems(systemCardsContainer.dataset.urlList, systemCardsContainer);
                } else {
                    throw new Error('Error al regenerar el token');
                }
            } catch (error) {
                toast.mixin().fire({
                    title: 'Error al regenerar el token',
                    icon: 'error'
                });
            }
        } else if (e.target.closest('.system-report')) {
            const systemId = e.target.closest('.system-report').dataset.id;
            try {
                const report = await getSystemReport(systemId);
                toast.mixin().fire({
                    title: 'Reporte generado con éxito',
                    icon: 'success'
                });
            } catch (error) {
                toast.mixin().fire({
                    title: 'Error al generar el reporte del sistema',
                    icon: 'error'
                });
            }
        }
    });
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('api-example')) {
            const lang = event.target.dataset.lang;
            const token = event.target.closest('.card').querySelector('input[readonly]').value;
            showApiExample(lang, token);

        }
    });
    document.querySelector('#generalReportBtn').addEventListener('click', async () => {
        try {
            const report = await getGeneralReport();
            console.log(report); // Elimina esto en producción
            toast.mixin().fire({
                title: 'Reporte general generado con éxito',
                icon: 'success'
            });
        } catch (error) {
            toast.mixin().fire({
                title: 'Error al generar el reporte general',
                icon: 'error'
            });
        }
    });

    function htmlEscape(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function showApiExample(lang, token) {

        const examples = {
            php: `
        <?php
        $url = '${BASE_URL()}v1/gateway/sms/client/send';
        $data = [
            'phone' => '+59178877502',
            'message' => 'Hola, este es un mensaje de prueba'
        ];
        
        $options = [
            'http' => [
                'header'  => "Content-type: application/json\\r\\nAuthorization: Bearer ${token}\\r\\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            ]
        ];
        
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        if ($result === FALSE) { /* Handle error */ }
        
        var_dump($result);
        `,
            codeigniter: `
        <?php
        // CodeIgniter Example
        $client = \\Config\\Services::curlrequest();
        
        $response = $client->request('POST', '${BASE_URL()}v1/gateway/sms/client/send', [
            'headers' => [
                'Authorization' => 'Bearer ${token}',
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'phone' => '+59178877502',
                'message' => 'Hola, este es un mensaje de prueba'
            ]
        ]);
        
        $body = $response->getBody();
        echo $body;
        `,
            laravel: `
        <?php
        // Laravel Example
        use Illuminate\\Support\\Facades\\Http;
        
        $response = Http::withToken('${token}')
            ->post('${BASE_URL()}v1/gateway/sms/client/send', [
                'phone' => '+59178877502',
                'message' => 'Hola, este es un mensaje de prueba'
            ]);
        
        return $response->json();
        `,
            python: `
        import requests
        
        url = '${BASE_URL()}v1/gateway/sms/client/send'
        headers = {
            'Authorization': 'Bearer ${token}',
            'Content-Type': 'application/json'
        }
        data = {
            'phone': '+59178877502',
            'message': 'Hola, este es un mensaje de prueba'
        }
        
        response = requests.post(url, json=data, headers=headers)
        print(response.json())
        `,
            javascript: `
        fetch('${BASE_URL()}v1/gateway/sms/client/send', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ${token}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                phone: '+59178877502',
                message: 'Hola, este es un mensaje de prueba'
            })
        })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch((error) => console.error('Error:', error));
        `,
            curl: `
        curl --location '${BASE_URL()}v1/gateway/sms/client/send' \\
        --header 'Content-Type: application/json' \\
        --header 'Authorization: Bearer ${token}' \\
        --data '{
            "phone":"+59178877502",
            "message": "Hola, este es un mensaje de prueba"
        }'
        `
        };

        const content = `<pre><code class="language-${lang}">${htmlEscape(examples[lang])}</code></pre>`;
        setModalParameters(modalExampleApi, `API Example - ${lang.toUpperCase()}`, "modal-lg", false, "static", content, false);

        // if (typeof Prism !== 'undefined' && Prism.highlightAll) {
        //     setTimeout(() => {
        //         Prism.highlightAll();
        //     }, 0);
        // } else {
        //     console.warn('Prism.js no está disponible. El resaltado de sintaxis no se aplicará.');
        // }
        Prism.plugins.autoloader.loadLanguages(['php', 'bash'], function () {
            setTimeout(() => {
                Prism.highlightAll();
            }, 100);
        });
    }
}

if (!window.clientSystemInitialized) {
    window.clientSystemInitialized = true;
    document.addEventListener('DOMContentLoaded', initClientSystem);
}