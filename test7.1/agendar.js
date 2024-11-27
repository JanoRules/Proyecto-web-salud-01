let idCentroSeleccionado = null;

// Seleccionar centro
function seleccionarCentro(idCentro) {
    idCentroSeleccionado = idCentro; // Almacena el ID del centro seleccionado
    alert('Centro seleccionado: ' + idCentro);
}
function agendarHora() {
    if (!idCentroSeleccionado) {
        alert('Por favor, selecciona un centro antes de continuar.');
        return;
    }

    const fecha = document.getElementById('fecha').value;
    const hora = document.getElementById('hora').value;

    if (!fecha || !hora) {
        alert('Por favor, selecciona una fecha y hora.');
        return;
    }

    const data = { 
        idCentro: idCentroSeleccionado, 
        fecha: fecha, 
        hora: hora 
    };

    console.log("Datos enviados:", data); // Verificar datos antes de enviar

    fetch('agendar_hora.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(result => {
        console.log("Respuesta del servidor:", result); // Verificar la respuesta
        if (result.success) {
            alert('Hora agendada exitosamente');
        } else {
            alert('Error al agendar la hora. Por favor, inténtalo nuevamente.');
        }
    })
    .catch(error => console.error('Error al agendar:', error));
}
