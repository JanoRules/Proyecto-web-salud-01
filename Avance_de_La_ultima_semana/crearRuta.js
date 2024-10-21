const perimetro = 5; // Rango en km
let centrosData = []; // Almacena los centros obtenidos

// Función para obtener los centros de salud desde la base de datos
function obtenerCentrosSalud() {
    fetch('obtener_centros.php')
        .then(response => response.json())
        .then(data => {
            centrosData = data; // Almacenar los centros
            const select = document.getElementById("centroSalud");
            select.innerHTML = '<option value="">Selecciona un centro de salud</option>'; // Limpiar opciones
            data.forEach(centro => {
                const option = document.createElement("option");
                option.value = centro.nombre;
                option.textContent = centro.nombre;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error al obtener los centros de salud:', error));
}

// Llamar a la función para obtener los centros de salud al cargar la página
window.onload = obtenerCentrosSalud;

// Función para obtener las coordenadas del centro de salud seleccionado
function obtenerCentroPorNombre(nombre) {
    return centrosData.find(centro => centro.nombre === nombre);
}

// Función para calcular la distancia
function calcularDistancia(lat1, lng1, lat2, lng2) {
    const R = 6371; // Radio de la Tierra en kilómetros
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLng = (lng2 - lng1) * Math.PI / 180;
    
    const a = 
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
        Math.sin(dLng / 2) * Math.sin(dLng / 2);
    
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)); 
    return R * c; // Distancia en kilómetros
}

// Función para crear la ruta hacia el centro de salud seleccionado
function crearRuta() {
    const select = document.getElementById("centroSalud");
    const centroSeleccionado = select.value;

    if (!centroSeleccionado) {
        alert("Por favor, selecciona un centro de salud.");
        return;
    }

    const centro = obtenerCentroPorNombre(centroSeleccionado);
    const usuarioLat = -33.4489; // Latitud del usuario (ejemplo)
    const usuarioLng = -70.6693; // Longitud del usuario (ejemplo)

    const distancia = calcularDistancia(usuarioLat, usuarioLng, centro.lat, centro.lng); // Calcular distancia

    if (distancia > perimetro) {
        const confirmacion = confirm(`El centro de salud ${centroSeleccionado} está fuera de rango. ¿Seguro que quiere ir?`);
        if (confirmacion) {
            console.log(`Ruta creada hacia ${centroSeleccionado}`);
            // Aquí puedes agregar el código para mostrar la ruta en el mapa
        }
    } else {
        console.log(`Ruta creada hacia ${centroSeleccionado}`);
        // Aquí puedes agregar el código para mostrar la ruta en el mapa
    }
}
