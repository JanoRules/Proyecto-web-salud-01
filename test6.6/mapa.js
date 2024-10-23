let map;
let markers = [];
let centrosSalud = []; // Array para almacenar los centros de salud

// Inicializar el mapa de Google
function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -33.4489, lng: -70.6693 }, // Santiago de Chile (ajusta según ubicación deseada)
        zoom: 12,
    });

    // Obtener los centros de salud desde el servidor
    fetchCentrosSalud();
}

// Obtener los datos de los centros de salud desde el servidor (PHP)
function fetchCentrosSalud() {
    fetch('obtener_centros.php')
        .then(response => response.json())
        .then(data => {
            centrosSalud = data;
            mostrarCentros(centrosSalud); // Mostrar todos los centros al cargar
        })
        .catch(error => console.error('Error al obtener los datos:', error));
}

// Mostrar los centros en el mapa como marcadores
function mostrarCentros(centros) {
    // Limpiar los marcadores actuales
    clearMarkers();

    // Recorrer los centros y agregar marcadores
    centros.forEach(centro => {
        const marker = new google.maps.Marker({
            position: { lat: parseFloat(centro.lat), lng: parseFloat(centro.lng) },
            map: map,
            title: centro.nombre,
        });

        // Mostrar una ventana de información al hacer clic en el marcador
        const infoWindow = new google.maps.InfoWindow({
            content: `<h3>${centro.nombre}</h3><p>Tipo: ${centro.tipo}</p><p>Atención: ${centro.atencion}</p>`,
        });

        marker.addListener('click', () => {
            infoWindow.open(map, marker);
        });

        // Agregar el marcador al array de marcadores
        markers.push(marker);
    });
}

// Limpiar todos los marcadores del mapa
function clearMarkers() {
    markers.forEach(marker => marker.setMap(null));
    markers = [];
}

// Filtrar centros por tipo de atención
function filtrarCentrosPorTipo(tipo) {
    const centrosFiltrados = centrosSalud.filter(centro => centro.tipo === tipo || tipo === 'todos');
    mostrarCentros(centrosFiltrados); // Mostrar solo los centros filtrados
}

// Manejar la selección del filtro
document.getElementById("filtro-tipo").addEventListener("change", function () {
    const tipoSeleccionado = this.value;
    filtrarCentrosPorTipo(tipoSeleccionado);
});
