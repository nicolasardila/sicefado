@extends('lombrisoft::layouts.master')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-100 via-blue-100 to-purple-100 px-4 py-8">
    <h1 class="text-4xl font-extrabold text-center mb-10 text-gray-800 animate-fadeIn">Bienvenido al lombricultivo</h1>

    @if (session('success'))
    <div class="bg-green-500/10 border-l-4 border-green-600 text-green-800 p-4 mb-8 rounded-lg shadow-md max-w-2xl mx-auto animate-slideInUp">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-500/10 border-l-4 border-red-600 text-red-800 p-4 mb-8 rounded-lg shadow-md max-w-2xl mx-auto animate-slideInUp">
        {{ session('error') }}
    </div>
    @endif

    <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($camas as $cama)
        <div class="bed-card relative bg-white shadow-lg rounded-xl p-6 hover:scale-105 hover:shadow-2xl transition-all duration-300 animate-slideInUp
                    {{ $cama->status=='Disponible' ? 'border-l-4 border-green-500'
                        : ($cama->status=='Ocupada' ? 'border-l-4 border-yellow-500' : 'border-l-4 border-red-500') }}">

            {{-- Badge de notificación si tiene alertas próximas/vencidas --}}
            @if(isset($cama->alerts_count) && $cama->alerts_count > 0)
            <span class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full animate-pulse">
                {{ $cama->alerts_count }}
            </span>
            @endif

            <div class="flex items-center space-x-4">
                <img src="{{ asset('imgLombri/lombriz4welcome.png') }}" alt="Lombriz" class="w-10 h-10 object-contain">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Cama {{ $cama->number }}</h2>
                    <p class="text-gray-600">Estado:
                        <span class="{{ $cama->status=='Disponible'?'text-green-600': ($cama->status=='Ocupada'?'text-yellow-600':'text-red-600') }}">
                            {{ $cama->status }}
                        </span>
                    </p>
                    <p class="text-gray-600">Inicio: {{ \Carbon\Carbon::parse($cama->start_date)->format('d/m/Y') }}</p>
                </div>
            </div>

            {{-- BOTONES --}}
            <div class="mt-4 flex gap-2">
                <button onclick="showActivityModal({{ $cama->id }}, {{ $cama->number }})"
    class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
    <i class="fas fa-plus"></i> Actividad
</button>

<button onclick="openAlertsModal({{ $cama->id }}, {{ $cama->number }})"
    class="flex-1 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
    <i class="fas fa-bell"></i> Alertas
</button>


            </div>
        </div>
        @empty
        <p class="text-gray-600 text-center col-span-full text-lg">No hay camas registradas. Agrega una cama para empezar.</p>
        @endforelse
    </div>

    <div class="mt-10 text-center">
        <a href="{{ route('lombrisoft.admin.camas.create') }}" class="inline-block bg-green-600 text-white px-6 py-3 rounded-full hover:bg-green-700 animate-pulse">
            Agregar Nueva Cama
        </a>
    </div>

    <!-- Modal para seleccionar tipo de actividad -->
    <!-- Modal Crear Actividad -->
    <div id="activityModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-2xl p-8 w-full max-w-lg shadow-2xl">
            <form action="{{ route('lombrisoft.admin.bed_activities.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="worm_bed_id" id="modalBedId">

                <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Registrar Actividad en Cama <span id="modalBedNumber"></span></h2>

                <div>
                    <label class="block text-gray-700">Tipo de Actividad</label>
                    <select name="tipo" class="w-full border rounded p-2" required>
                        <option value="" disabled selected>-- Seleccione --</option>
                        <option value="mantenimiento">Mantenimiento</option>
                        <option value="alimentacion">Alimentación</option>
                        <option value="humedad">Control de Humedad</option>
                        <option value="recoleccion">Recolección</option>
                        <option value="ph">Control de PH</option>
                        <option value="temperatura">Control de Temperatura</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700">Descripción</label>
                    <textarea name="descripcion" class="w-full border rounded p-2" rows="3"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-gray-700">Fecha</label>
                        <input type="date" name="fecha_actividad" class="w-full border rounded p-2" required>
                    </div>
                    <div>
                        <label class="block text-gray-700">Hora</label>
                        <input type="time" name="hora_actividad" class="w-full border rounded p-2" required>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-4">
                    <button type="button" onclick="closeActivityModal()" class="px-4 py-2 rounded bg-gray-500 text-white">Cancelar</button>
                    <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Ver Alertas -->
    <div id="alertsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-lg">
            <h3 class="text-xl font-bold mb-4 text-center">Alertas de la cama <span id="alertsBedNumber"></span></h3>

            <div id="alertsList" class="space-y-2 max-h-60 overflow-y-auto">
                <!-- Aquí se cargan mediante JS las alertas de esa cama (desde las mismas $camas que ya vienen) -->
            </div>

            <div class="text-center mt-4">
                <button onclick="closeAlertsModal()" class="px-4 py-2 rounded bg-red-600 text-white">Cerrar</button>
            </div>
        </div>
    </div>

</div>

<script>
    function showActivityModal(bedId) {
        document.getElementById('bedId').textContent = bedId;
        document.getElementById('activitySelect').value = '';
        document.getElementById('lastActivity').innerHTML = 'Selecciona un tipo de actividad para ver los detalles.';
        document.getElementById('activityModal').classList.remove('hidden');
    }

    function updateActivityDetails() {
        const type = document.getElementById('activitySelect').value;
        document.getElementById('lastActivity').innerHTML = type ? `Actividad ${type} en desarrollo.` : 'Selecciona un tipo de actividad.';
    }

    function closeModal() {
        document.getElementById('activityModal').classList.add('hidden');
    }
    // Abrir Modal Registrar Actividad
function showActivityModal(bedId, bedNumber) {
    document.getElementById('modalBedId').value  = bedId;
    document.getElementById('modalBedNumber').innerText = bedNumber;
    document.getElementById('activityModal').classList.remove('hidden');
}
function closeActivityModal(){
    document.getElementById('activityModal').classList.add('hidden');
}

// Abrir Modal para ver alertas
function openAlertsModal(bedId, bedNumber) {
    document.getElementById('alertsBedNumber').innerText = bedNumber;
    
    // Tomamos las alertas que ya tenemos cargadas en el blade mismo dentro de $camas
    let alerts = @json($camas);
    let cama = alerts.find(c => c.id === bedId);

    let container = document.getElementById('alertsList');
    container.innerHTML = '';

    if(cama.activity_alerts && cama.activity_alerts.length > 0){
        cama.activity_alerts.forEach(al => {
            container.innerHTML += `
                <div class="border p-2 rounded">
                    <strong>Tipo:</strong> ${al.activity_type} <br>
                    <strong>Frecuencia:</strong> ${al.frequency_days} días
                </div>
            `;
        });
    }else{
        container.innerHTML = '<p class="text-gray-600 text-center">No tiene alertas.</p>';
    }

    document.getElementById('alertsModal').classList.remove('hidden');
}
function closeAlertsModal(){
    document.getElementById('alertsModal').classList.add('hidden');
}

</script>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@endsection