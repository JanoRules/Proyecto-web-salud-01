let centrosSalud = [];

// Llamada AJAX para obtener los centros de salud
fetch('centrosyserv.php')
    .then(response => response.json())
    .then(centros => {
        console.log(centros); // Agrega esta línea
        centrosSalud = centros;
        cargarCentrosEnSelect();
    });

function cargarCentrosEnSelect() {
    const selectCentro1 = document.getElementById('centro1');
    const selectCentro2 = document.getElementById('centro2');
    centrosSalud.forEach(centro => {
        let option1 = new Option(centro.nombre, centro.nombre);
        let option2 = new Option(centro.nombre, centro.nombre);
        selectCentro1.add(option1);
        selectCentro2.add(option2);
    });
}
function compararCentros() {
    const nombreCentro1 = document.getElementById('centro1').value;
    const nombreCentro2 = document.getElementById('centro2').value;
    const centro1 = centrosSalud.find(centro => centro.nombre === nombreCentro1);
    const centro2 = centrosSalud.find(centro => centro.nombre === nombreCentro2);
    
    if (!centro1 || !centro2) {
        alert("Por favor selecciona dos centros para comparar");
        return;
    }

    const resultadoDiv = document.getElementById('resultadoComparacion');
    resultadoDiv.innerHTML = `
        <h4>Comparación entre ${centro1.nombre} y ${centro2.nombre}</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Criterios</th>
                    <th>${centro1.nombre}</th>
                    <th>${centro2.nombre}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Atención</td>
                    <td>${centro1.atencion}</td>
                    <td>${centro2.atencion}</td>
                </tr>
                <tr>
                    <td>Tipo</td>
                    <td>${centro1.tipo}</td>
                    <td>${centro2.tipo}</td>
                </tr>
                <tr>
                    <td>Abierto</td>
                    <td>${centro1.horario}</td>
                    <td>${centro2.horario}</td>
                </tr>
                <tr>
                    <td>Capacidad</td>
                    <td>${centro1.capacidad_total}</td>
                    <td>${centro2.capacidad_total}</td>
                </tr>
                <tr>
                    <td>Personas en riesgo bajo</td>
                    <td>${centro1.personas_atencion_baja}</td>
                    <td>${centro2.personas_atencion_baja}</td>
                </tr>
                <tr>
                    <td>Personas en riego intermedio</td>
                    <td>${centro1.personas_atencion_media}</td>
                    <td>${centro2.personas_atencion_media}</td>
                </tr>
                <tr>
                    <td>Personas en riego alto</td>
                    <td>${centro1.personas_atencion_inmediata}</td>
                    <td>${centro2.personas_atencion_media}</td>
                </tr>
        
                <tr>
                    <td>Distancia</td>
                    <td>${calcularDistancia(centro1.lat, centro1.lng)} km</td>
                    <td>${calcularDistancia(centro2.lat, centro2.lng)} km</td>
                </tr>
                <tr>
                    <td>Servicios</td>
                    <td>${centro1.servicios || 'No disponibles'}</td>
                    <td>${centro2.servicios || 'No disponibles'}</td>
                </tr>
            
            </tbody>
        </table>
    `;
}




function calcularDistancia(lat, lng) {
    const userLocation = { lat: -38.7375, lng: -72.5982 };
    const distancia = google.maps.geometry.spherical.computeDistanceBetween(
        new google.maps.LatLng(userLocation.lat, userLocation.lng),
        new google.maps.LatLng(lat, lng)
    );
    return (distancia / 1000).toFixed(2);
}
