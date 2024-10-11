<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Monitoreo de Proveedores</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Panel de Monitoreo de Proveedores</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Proveedores Activos</h2>
                <div id="activeProviders" class="text-4xl font-bold text-green-600">-</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Total Mensajes Enviados</h2>
                <div id="totalMessagesSent" class="text-4xl font-bold text-blue-600">-</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Tasa de Éxito</h2>
                <div id="successRate" class="text-4xl font-bold text-purple-600">-</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Mensajes por Estado</h2>
                <canvas id="messageStatusChart"></canvas>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Actividad de Proveedores</h2>
                <canvas id="providerActivityChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-xl font-semibold mb-4">Detalle de Proveedores</h2>
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Estado</th>
                            <th class="px-4 py-2">Mensajes Enviados</th>
                            <th class="px-4 py-2">Última Actividad</th>
                        </tr>
                    </thead>
                    <tbody id="providerTableBody">
                        <!-- Los datos de los proveedores se cargarán aquí dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Agrega esto después de la tabla de proveedores -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-xl font-semibold mb-4">Todos los Mensajes</h2>
            <div class="overflow-x-auto">
                <table id="messagesTable" class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Número Destino</th>
                            <th class="px-4 py-2">Mensaje</th>
                            <th class="px-4 py-2">Sistema</th>
                            <th class="px-4 py-2">Proveedor</th>
                            <th class="px-4 py-2">Estado</th>
                            <th class="px-4 py-2">Fecha de Envío</th>
                            <th class="px-4 py-2">Fecha de Asignación</th>
                            <th class="px-4 py-2">Fecha de Respuesta</th>
                        </tr>
                    </thead>
                    <tbody id="messagesTableBody">
                        <!-- Los datos de los mensajes se cargarán aquí dinámicamente -->
                    </tbody>
                </table>
            </div>
            <div id="messagesPagination" class="mt-4"></div>
        </div>
    </div>

    <script>
        function updateMessagesTable(page = 1, limit = 10, search = '') {
            $.ajax({
                url: '/dashboard/messages',
                method: 'GET',
                data: {
                    page: page,
                    limit: limit,
                    search: search
                },
                success: function(data) {
                    const tableBody = $('#messagesTableBody');
                    tableBody.empty();
                    data.messages.forEach(message => {
                        tableBody.append(`
                    <tr>
                        <td class="border px-4 py-2">${message.id_proveedor_envio_sms}</td>
                        <td class="border px-4 py-2">${message.numero_destino}</td>
                        <td class="border px-4 py-2">${message.mensaje}</td>
                        <td class="border px-4 py-2">${message.nombre_sistema}</td>
                        <td class="border px-4 py-2">${message.nombre_proveedor}</td>
                        <td class="border px-4 py-2">${message.estado_envio}</td>
                        <td class="border px-4 py-2">${moment(message.fecha_envio).format('YYYY-MM-DD HH:mm:ss')}</td>
                        <td class="border px-4 py-2">${message.fecha_asignacion_sms ? moment(message.fecha_asignacion_sms).format('YYYY-MM-DD HH:mm:ss') : 'N/A'}</td>
                        <td class="border px-4 py-2">${message.fecha_respuesta_sms ? moment(message.fecha_respuesta_sms).format('YYYY-MM-DD HH:mm:ss') : 'N/A'}</td>
                    </tr>
                `);
                    });

                    updateMessagesPagination(data.pagination);
                },
                error: function(error) {
                    console.error('Error al obtener datos de mensajes:', error);
                }
            });
        }

        function updateMessagesPagination(pagination) {
            const totalPages = Math.ceil(pagination.total / pagination.limit);
            let paginationHtml = '';

            for (let i = 1; i <= totalPages; i++) {
                paginationHtml += `<button class="px-3 py-1 ${pagination.page == i ? 'bg-blue-500 text-white' : 'bg-gray-200'}" onclick="updateMessagesTable(${i}, ${pagination.limit})">${i}</button>`;
            }

            $('#messagesPagination').html(paginationHtml);
        }

        // Llamar a updateMessagesTable() cuando se carga la página
        $(document).ready(function() {
            updateMessagesTable();
        });

        // Actualizar la tabla de mensajes cada 30 segundos
        setInterval(function() {
            updateMessagesTable($('#messagesPagination button.bg-blue-500').text());
        }, 30000);

        // Función para actualizar los datos del dashboard
        function updateDashboard(page = 1, limit = 10, search = '') {
            // Simulamos la llamada AJAX con los datos proporcionados
            const data = {
                "activeProviders": 2,
                "totalMessagesSent": 1,
                "successRate": 25,
                "messageStatus": {
                    "sent": "1",
                    "rejected": "3",
                    "pending": 0
                },
                "providerActivity": [{
                        "nombre": "JOSE LUIS",
                        "messageCount": "4"
                    },
                    {
                        "nombre": "GILMER RUDDY",
                        "messageCount": "0"
                    }
                ],
                "providers": [{
                        "id": "1",
                        "name": "JOSE LUIS",
                        "messagesSent": "4",
                        "last_activity": "2024-10-10 18:10:52",
                        "active": 1
                    },
                    {
                        "id": "2",
                        "name": "GILMER RUDDY",
                        "messagesSent": "0",
                        "last_activity": null,
                        "active": 1
                    }
                ],
                "pagination": {
                    "page": 1,
                    "limit": 10,
                    "total": 2
                }
            };

            // Actualizar los contadores
            $('#activeProviders').text(data.activeProviders);
            $('#totalMessagesSent').text(data.totalMessagesSent);
            $('#successRate').text(data.successRate + '%');

            // Actualizar el gráfico de estado de mensajes
            updateMessageStatusChart(data.messageStatus);

            // Actualizar el gráfico de actividad de proveedores
            updateProviderActivityChart(data.providerActivity);

            // Actualizar la tabla de proveedores
            updateProviderTable(data.providers);

            // Actualizar la paginación
            updatePagination(data.pagination);
        }

        function updatePagination(pagination) {
            const totalPages = Math.ceil(pagination.total / pagination.limit);
            let paginationHtml = '';

            for (let i = 1; i <= totalPages; i++) {
                paginationHtml += `<button class="px-3 py-1 ${pagination.page == i ? 'bg-blue-500 text-white' : 'bg-gray-200'}" onclick="updateDashboard(${i}, ${pagination.limit})">${i}</button>`;
            }

            $('#pagination').html(paginationHtml);
        }

        function updateMessageStatusChart(data) {
            const ctx = document.getElementById('messageStatusChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Enviados', 'Rechazados', 'Pendientes'],
                    datasets: [{
                        data: [data.sent, data.rejected, data.pending],
                        backgroundColor: ['#10B981', '#EF4444', '#F59E0B']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        }

        function updateProviderActivityChart(data) {
            const ctx = document.getElementById('providerActivityChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.nombre),
                    datasets: [{
                        label: 'Mensajes enviados en las últimas 24 horas',
                        data: data.map(item => item.messageCount),
                        backgroundColor: '#3B82F6'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function updateProviderTable(providers) {
            const tableBody = $('#providerTableBody');
            tableBody.empty();
            providers.forEach(provider => {
                tableBody.append(`
                <tr>
                    <td class="border px-4 py-2">${provider.id}</td>
                    <td class="border px-4 py-2">${provider.name}</td>
                    <td class="border px-4 py-2">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${provider.active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                            ${provider.active ? 'Activo' : 'Inactivo'}
                        </span>
                    </td>
                    <td class="border px-4 py-2">${provider.messagesSent}</td>
                    <td class="border px-4 py-2">${provider.last_activity ? moment(provider.last_activity).fromNow() : 'N/A'}</td>
                </tr>
            `);
            });
        }

        function searchProviders() {
            const searchTerm = $('#searchInput').val();
            updateDashboard(1, 10, searchTerm);
        }

        // Llamar a updateDashboard() cuando se carga la página
        $(document).ready(function() {
            updateDashboard();
        });

        // Actualizar el dashboard cada 30 segundos
        setInterval(updateDashboard, 30000);
    </script>
</body>

</html>