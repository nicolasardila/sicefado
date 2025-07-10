@extends('lombrisoft::layouts.master')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-green-100 via-blue-100 to-purple-100 px-4 py-8">
        <h1 class="text-4xl font-extrabold text-center mb-10 text-gray-800 animate-fadeIn">Bienvenido al lombricultivo</h1>

        <!-- Alertas de éxito -->
        @if (session('success'))
            <div class="bg-green-500/10 border-l-4 border-green-600 text-green-800 p-4 mb-8 rounded-lg shadow-md max-w-2xl mx-auto animate-slideInUp" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Alertas de error -->
        @if (session('error'))
            <div class="bg-red-500/10 border-l-4 border-red-600 text-red-800 p-4 mb-8 rounded-lg shadow-md max-w-2xl mx-auto animate-slideInUp" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Grid para las camas dinámicas -->
        <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($camas as $cama)
                <div class="bed-card bg-white shadow-lg rounded-xl p-6 cursor-pointer hover:scale-105 hover:shadow-2xl transition-all duration-300 animate-slideInUp {{ $cama->status == 'Disponible' ? 'border-l-4 border-green-500' : ($cama->status == 'Ocupada' ? 'border-l-4 border-yellow-500' : 'border-l-4 border-red-500') }}" onclick="showActivityModal({{ $cama->id }})">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('imgLombri/lombriz4welcome.png') }}"
     alt="Lombriz"
     class="w-10 h-10 object-contain transition-transform hover:scale-110" />

                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">Cama {{ $cama->number }}</h2>
                            <p class="text-gray-600 mt-1">Estado: <span class="font-medium {{ $cama->status == 'Disponible' ? 'text-green-600' : ($cama->status == 'Ocupada' ? 'text-yellow-600' : 'text-red-600') }}">{{ $cama->status }}</span></p>
                            <p class="text-gray-600 mt-1">Fecha de inicio: {{ \Carbon\Carbon::parse($cama->start_date)->format('d/m/Y') }}</p>
                            <p class="text-gray-500 mt-1 text-sm">Clic para ver actividades (próximamente)</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-600 text-center col-span-full text-lg">No hay camas registradas. Agrega una cama para empezar.</p>
            @endforelse
        </div>

        <!-- Botón para crear una nueva cama -->
        <div class="mt-10 text-center">
            <a href="{{ route('lombrisoft.admin.camas.create') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition-colors duration-300 animate-pulse">Agregar Nueva Cama</a>
        </div>

        <!-- Modal para seleccionar tipo de actividad -->
        <div id="activityModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center hidden animate-fadeIn">
            <div class="bg-white rounded-2xl p-8 w-full max-w-md shadow-2xl">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Cama <span id="bedId"></span></h2>
                
                <!-- Selección de tipo de actividad -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 text-gray-700">Seleccionar Tipo de Actividad</h3>
                    <select id="activitySelect" class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 transition-all duration-200" onchange="updateActivityDetails()">
                        <option value="">Elige una actividad</option>
                        <option value="Mantenimiento">Mantenimiento</option>
                        <option value="Alimentación">Alimentación</option>
                        <option value="Humedad">Humedad</option>
                        <option value="Recolección">Recolección</option>
                    </select>
                </div>

                <!-- Última actividad (placeholder) -->
                <div>
                    <h3 class="text-lg font-semibold mb-3 text-gray-700">Última Actividad Seleccionada</h3>
                    <p id="lastActivity" class="text-gray-600 bg-gray-100 p-3 rounded-lg">Selecciona un tipo de actividad para ver los detalles (funcionalidad en desarrollo).</p>
                </div>

                <button onclick="closeModal()" class="mt-6 w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">Cerrar</button>
            </div>
        </div>
    </div>

    <!-- JavaScript para el modal -->
    <script>
        function showActivityModal(bedId) {
            document.getElementById('bedId').textContent = bedId;
            document.getElementById('activitySelect').value = '';
            document.getElementById('lastActivity').innerHTML = 'Selecciona un tipo de actividad para ver los detalles (funcionalidad en desarrollo).';
            document.getElementById('activityModal').classList.remove('hidden');
        }

        function updateActivityDetails() {
            const activityType = document.getElementById('activitySelect').value;
            if (activityType) {
                document.getElementById('lastActivity').innerHTML = `Actividad ${activityType} en desarrollo. Contacta al equipo para más detalles.`;
            } else {
                document.getElementById('lastActivity').innerHTML = 'Selecciona un tipo de actividad para ver los detalles (funcionalidad en desarrollo).';
            }
        }

        function closeModal() {
            document.getElementById('activityModal').classList.add('hidden');
        }
    </script>

    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Animaciones personalizadas -->
    <style>
        @keyframes slideInUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .animate-slideInUp {
            animation: slideInUp 0.5s ease-out forwards;
        }

        .animate-fadeIn {
            animation: fadeIn 0.7s ease-out forwards;
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .bed-card {
            animation-delay: calc(var(--index) * 0.1s);
        }
    </style>
@endsection