<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login2.php");
    exit();
}
?>

<!-- dashboard.html -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick Salud</title>
    <link rel="stylesheet" href="quick-salud.css">
    <script src="comparacion.js"></script>
    
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCR1QaFAuNROMnt5aOF9WvnmVCXO5OSmBI&libraries=geometry&callback=initMap" async defer></script>
    <style>
        /* Estilos para los botones */
        .atencion-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s; /* Efecto de transición */
        }
    
        /* Estilo específico para el botón de atención inmediata */
        #btnInmediata {
            background-color: #FF0000; /* Color rojo */
        }
    
        /* Estilo específico para el botón de atención media */
        #btnMedia {
            background-color: #FFFF00; /* Color amarillo */
            color: black; /* Color del texto */
        }
    
        /* Estilo específico para el botón de atención baja */
        #btnBaja {
            background-color: #1a921a; /* Color verde */
        }
    
        /* Efectos al pasar el mouse */
        .atencion-btn:hover {
            transform: scale(1.05); /* Aumenta el tamaño ligeramente */
            opacity: 0.9; /* Cambia la opacidad */
        }
    
        /* Efecto al presionar */
        .atencion-btn:active {
            transform: scale(0.95); /* Disminuye el tamaño al presionar */
        }
    </style>

    <style>
        .contorno-rojo {
            background-color: #FF0000; /* Color rojo */
            color: white;
            padding: 2px;
            border-radius: 2px;
        }
        
        .contorno-amarillo {
            background-color: #FFFF00; 
            color: black; 
            padding: 2px;
            border-radius: 2px;
        }
        
        .contorno-verde {
            background-color: #1a921a; /* Color verde */
            color: white;
            padding: 2px;
            border-radius: 2px;
        }
    </style>


    <style>
        #map {
            width: 100%;
            height: 450px;
        }
        .geo-btn {
            margin: 20px auto;
            display: block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;    
        }
        .geo-btn:hover {
            background-color: #218838;
        }
    </style>
    
    <script>
        function checkNotifications() {
            fetch('get-notifications.php')
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(notification => {
                            showNotification(notification.mensaje);
                        });
                    }
                })
                .catch(error => console.error('Error al obtener notificaciones:', error));
        }
    

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'notification-popup';

            const icon = document.createElement('div');
            icon.className = 'icon';
            icon.innerText = 'ℹ️'; // Ícono de información o puedes usar un emoji

            const messageText = document.createElement('div');
            messageText.innerText = message;

            notification.appendChild(icon);
            notification.appendChild(messageText);

            document.body.appendChild(notification);

            // Oculta la notificación después de 10 segundos
            setTimeout(() => {
                notification.remove();
            }, 10000);
        }

    
        window.addEventListener('load', function() {
            checkNotifications();
            setInterval(checkNotifications, 120000); // Llama cada 2 minutos
        });
    </script>
    
    
    
    
    
    
    
    <style>
        .notification-popup {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px;
            background-color: #333;
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-size: 14px;
            opacity: 0.9;
        }
    </style>
    
    
    
    <script>
        let map;
        let circle;
        let markers = [];
        let centros = [];
        let tipoAtencion = 'baja';


         // Añadir variables para el ícono del usuario y el destino
        const iconoUsuario = { 
            url: "https://img.icons8.com/color/48/user.png", // Ícono para el usuario
            scaledSize: new google.maps.Size(40, 40),
        };
        let usuarioMarker; // Variable para el marcador del usuario 


        function initMap() {
            const centroTemuco = { lat: -38.7375, lng: -72.5982 };

            const mapStyles = [
                {
                    featureType: "poi",
                    stylers: [{ visibility: "off" }]
                },
                {
                    featureType: "transit",
                    stylers: [{ visibility: "off" }]
                },
                {
                    featureType: "road",
                    stylers: [{ visibility: "on" }]
                }
            ];

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: centroTemuco,
                styles: mapStyles
            });

            const iconos = {
                hospital: {
                    url: "https://img.icons8.com/color/48/hospital.png",
                    scaledSize: new google.maps.Size(40, 40),
                },
                clinica: {
                    url: "https://img.icons8.com/color/48/clinic.png",
                    scaledSize: new google.maps.Size(40, 40),
                },
                cesfam: {
                    url: "https://img.icons8.com/color/48/medical-doctor.png",
                    scaledSize: new google.maps.Size(40, 40),
                },
                consultorio: {
                    url: "https://img.icons8.com/color/48/stethoscope.png",
                    scaledSize: new google.maps.Size(40, 40),
                }
            };
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);

            // Inicializar el círculo con el radio inicial
            circle = new google.maps.Circle({
                map: map,
                radius: 2000, // Radio inicial
                fillColor: '#00FF00',
                strokeColor: '#0000FF',
                strokeOpacity: 0.8,
                fillOpacity: 0.35,
                center: centroTemuco
            });

            // Llamada AJAX para obtener los centros de salud desde la base de datos
                        //
            // Supón que tienes una variable global para el tipo de atención

        // Llamada AJAX para obtener los centros de salud desde la base de datos
        fetch('obtener_centros.php')
            .then(response => response.json())
            .then(centros => {
                centrosSalud = centros;
                console.log(centrosSalud);

                // Crear una única ventana de información
                const infowindow = new google.maps.InfoWindow();

                centrosSalud.forEach(centro => {
                    const marker = new google.maps.Marker({
                        position: { lat: parseFloat(centro.lat), lng: parseFloat(centro.lng) },
                        map: null, // Los marcadores no se mostrarán hasta pasar el filtro
                        title: centro.nombre,
                        icon: iconos[centro.tipo]
                    });

                    // Mostrar información al hacer clic en el marcador
                    markers.forEach(marker => {
                        marker.addListener('click', () => {

                        // Busca el centro de salud correspondiente a este marcador
                        const centro = centrosSalud.find(c => c.nombre === marker.getTitle());
                            // Obtener la cantidad de personas según el tipo de atención
                            let personasAtendiendo = 0;
                            
                            if (tipoAtencion === 'inmediata') {
                                personasAtendiendo = centro.personas_atencion_inmediata;
                            } else if (tipoAtencion === 'media') {
                                personasAtendiendo = centro.personas_atencion_media;
                            } else if (tipoAtencion === 'baja') {
                                personasAtendiendo = centro.personas_atencion_baja;
                            }

                            // Configurar el contenido del infowindow
                            infowindow.setContent(`
                                <strong>${centro.nombre}</strong><br>
                                Horario: ${centro.horario}<br>
                                Capacidad Total: ${centro.capacidad_total}<br>
                                <span id="personasAtendiendoText" class="${tipoAtencion === 'inmediata' ? 'contorno-rojo' : tipoAtencion === 'media' ? 'contorno-amarillo' : 'contorno-verde'}">Personas en Atención ${tipoAtencion.charAt(0).toUpperCase() + tipoAtencion.slice(1)}: ${personasAtendiendo}</span>
                            `);
                            infowindow.open(map, marker);
                            
                            // Llamar a calcularRuta si lo deseas
                            calcularRuta(marker.getPosition());
                        });
                    });

                    // Añadir el marcador a la lista de marcadores
                    markers.push(marker);

                    // Calcular la distancia entre el centro del círculo y el marcador
                    const distancia = google.maps.geometry.spherical.computeDistanceBetween(circle.getCenter(), marker.getPosition());

                    // Mostrar el marcador si está dentro del radio inicial
                    if (distancia <= circle.getRadius()) {
                        marker.setMap(map);
                    }
                });
            });

                // Añadir los marcadores al array, pero no los mostramos aún
                markers.push(marker);

                // Calcular la distancia entre el centro del círculo y el marcador
                const distancia = google.maps.geometry.spherical.computeDistanceBetween(circle.getCenter(), marker.getPosition());

                // Mostrar el marcador si está dentro del radio inicial
                if (distancia <= circle.getRadius()) {
                    marker.setMap(map);
                }
                // Añadir evento al marcador para calcular la ruta al hacer clic
                google.maps.event.addListener(marker, 'click', function() {
                    calcularRuta(marker.getPosition());
                });
            };
        


            circle = new google.maps.Circle({
                map: map,
                radius: 2000,
                fillColor: '#00FF00',
                strokeColor: '#0000FF',
                strokeOpacity: 0.8,
                fillOpacity: 0.35,
                center: centroTemuco
            });
        

        // Función para centrar el mapa en la ubicación actual del usuario
        function centrarEnUbicacion() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };

                        // Centrar el mapa en la ubicación actual
                        map.setCenter(pos);
                        circle.setCenter(pos); // Mover el círculo a la nueva ubicación
                    },
                    () => {
                        alert("No se pudo obtener la ubicación.");
                    }
                );
            } else {
                alert("Tu navegador no soporta la geolocalización.");
            }
        }

        

        function cambiarTipoAtencion(tipo) {
        tipoAtencion = tipo; // Actualizar el tipo de atención global

        // Ajustar colores del radar según el tipo de atención
        if (tipo === 'inmediata') {
            cambiarColorAtencion('inmediata', '#FF0000', '#AA0000'); // Rojo
        } else if (tipo === 'media') {
            cambiarColorAtencion('media', '#FFFF00', '#AAAA00'); // Amarillo
        } else if (tipo === 'baja') {
            cambiarColorAtencion('baja', '#00FF00', '#00AA00'); // Verde
        }
    }

        function cambiarColorAtencion(tipoAtencion, fillColor, strokeColor) {
        // Cambiar los colores del círculo (radar)
        circle.setOptions({
            fillColor: fillColor,
            strokeColor: strokeColor
        });
    }

        // 2. Ajuste en la inicialización de marcadores y manejo de infowindow
        centrosSalud.forEach(centro => {
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(centro.lat), lng: parseFloat(centro.lng) },
                map: null, // Los marcadores no se mostrarán hasta pasar el filtro
                title: centro.nombre,
                icon: iconos[centro.tipo]
            });

            // Evento al hacer clic en el marcador
            marker.addListener('click', () => {
                let personasAtendiendo = 0;

                if (tipoAtencion === 'inmediata') {
                    personasAtendiendo = centro.personas_atencion_inmediata;
                } else if (tipoAtencion === 'media') {
                    personasAtendiendo = centro.personas_atencion_media;
                } else if (tipoAtencion === 'baja') {
                    personasAtendiendo = centro.personas_atencion_baja;
                }

                // Mostrar el infowindow solo al hacer clic en el marcador
                infowindow.setContent(`
                    <strong>${centro.nombre}</strong><br>
                    Horario: ${centro.horario}<br>
                    Capacidad Total: ${centro.capacidad_total}<br>
                    <span id="personasAtendiendoText">Personas atendiendo (${tipoAtencion.charAt(0).toUpperCase() + tipoAtencion.slice(1)}): ${personasAtendiendo}</span>
                `);
                infowindow.open(map, marker);
                
                // Llamar a calcularRuta si es necesario
                calcularRuta(marker.getPosition());
            });

            // Añadir el marcador a la lista de marcadores
            markers.push(marker);

            // Mostrar el marcador si está dentro del radio del círculo
            const distancia = google.maps.geometry.spherical.computeDistanceBetween(circle.getCenter(), marker.getPosition());
            if (distancia <= circle.getRadius()) {
                marker.setMap(map);
            }
        });
        


        // Función para filtrar centros según el tipo de atención (todos, privado, publico)
        function filtrarCentros(tipo) {
            markers.forEach(marker => marker.setMap(null)); // Ocultar todos los marcadores

            markers.forEach(marker => {
                const centro = centrosSalud.find(c => c.nombre === marker.getTitle());

                // Calcular la distancia entre el centro del círculo y el marcador
                const distancia = google.maps.geometry.spherical.computeDistanceBetween(circle.getCenter(), marker.getPosition());

                // Mostrar solo los marcadores que correspondan al tipo y estén dentro del radio del círculo
                if ((tipo === 'todos' || centro.atencion === tipo) && distancia <= circle.getRadius()) {
                    marker.setMap(map);
                }
            });
        }


        function filtrarCentrosPorPerimetro() {
            const circleCenter = circle.getCenter();
            const circleRadius = circle.getRadius();
        // Ocultar todos los marcadores
            markers.forEach(marker => marker.setMap(null));

    // Mostrar solo los centros dentro del radio del círculo
            markers.forEach(marker => {
                const centro = centrosSalud.find(c => c.nombre === marker.getTitle());
                const distancia = google.maps.geometry.spherical.computeDistanceBetween(circleCenter, marker.getPosition());
        // Si la distancia del centro al marcador es menor que el radio, mostrarlo
                if (distancia <= circleRadius) {
                    marker.setMap(map);
                }
            });
        }

        function aumentarPerimetro() {
    // Aumentamos el radio del círculo en 1000 metros (puedes ajustar el valor)
             let nuevoRadio = circle.getRadius() + 1000; 
            circle.setRadius(nuevoRadio);
            filtrarCentrosPorPerimetro();
        }

        function calcularRuta(destino) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const origen = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    const request = {
                        origin: origen,
                        destination: destino,
                        travelMode: google.maps.TravelMode.DRIVING // Modo de viaje en coche
                    };

                    directionsService.route(request, function(result, status) {
                        if (status === google.maps.DirectionsStatus.OK) {
                            directionsRenderer.setDirections(result);
                        } else {
                            alert("No se pudo calcular la ruta: " + status);
                        }
                    });
                });
            } else {
                alert("Tu navegador no soporta la geolocalización.");
            }
        }


    // Función de seguimiento en tiempo real //////////////////
    function seguimientoTiempo(ruta) {
        let intervalId;} // Variable para el intervalo de actualización

    // Función para actualizar el tiempo restante
    function actualizarTiempoRestante() {
        navigator.geolocation.getCurrentPosition((position) => {
            const origen = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            // Crear una solicitud para obtener el tiempo restante
            const request = {
                origin: origen,
                destination: ruta.request.destination,
                travelMode: google.maps.TravelMode.DRIVING
            };

            // Usar la API de Distance Matrix para obtener el tiempo estimado
            const distanceService = new google.maps.DistanceMatrixService();
            distanceService.getDistanceMatrix(
                {
                    origins: [origen],
                    destinations: [ruta.request.destination],
                    travelMode: google.maps.TravelMode.DRIVING,
                    unitSystem: google.maps.UnitSystem.METRIC
                },
                (response, status) => {
                    if (status === 'OK') {
                        const duration = response.rows[0].elements[0].duration.text;
                        document.getElementById('tiempo-restante').innerText = "Tiempo restante: " + duration;
                    } else {
                        console.log("Error al calcular el tiempo restante: " + status);
                    }
                }
            );
        });
    }
    </script>

    <script>
        function checkNotifications2() {
            fetch('get-notifications2.php')
                .then(response => response.json())
                .then(data2 => {
                    if (data2.length > 0) {
                        data2.forEach(notification2 => {
                            showNotification2(notification2.mensaje);
                        });
                    }
                })
                .catch(error => console.error('Error al obtener notificaciones2:', error));
        }

        function showNotification2(message2) {
            const notification2 = document.createElement('div');
            notification2.className = 'notification-popup2';
            notification2.innerText = message2;

            document.body.appendChild(notification2);

            // Oculta la notificación después de 8 segundos
            setTimeout(() => {
                notification2.remove();
            }, 8000);
        }

        // Llamada inicial y cada 2 minutos
        window.addEventListener('load', function () {
            checkNotifications2();
            setInterval(checkNotifications2, 100000); // Cada 2 minutos aprox
        });
    </script>

    <style>
        .notification-popup2 {
            position: fixed;
            bottom: 20px;
            right: 60px;
            padding: 15px;
            background-color: red; /* Fondo rojo */
            color: white; /* Texto blanco */
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-size: 16px;
            font-weight: bold;
            opacity: 0.95;
            z-index: 1000;
            animation: fade-in2 0.5s ease-in-out;
        }
        
        /* Animación de entrada */
        @keyframes fade-in2 {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 0.95;
                transform: translateY(0);
            }
        }
    </style>
    


    

</head>
<body onload="initMap()">
    <h1>Bienvenido a tu panel de salud</h1>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="logo100.png" alt="Ministerio de Salud" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Ultimas-novedades.html">Últimas Novedades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Reseña.html">Reseña</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto.html">Contáctanos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="FAQ.html">Preguntas Frecuentes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="AgendarHora.php">Agenda tu hora</a>
                    </li>
                </ul>
                <div class="nav">
                    <a href="logout.php"><button>Cerrar sesión</button></a>
                    <a href="update-user.html"><button>Usuario</button></a>
                    <a href="ver_mensajes.php"><button>Mensajes</button></a>
                </div>
            </div>
        </div>
    </nav>

    <section id="titulo_mapa" class="mt-5 pt-5">
        <h2 class="text-center"><strong>Visualiza los distintos Servicios de Salud disponibles según su ubicación</strong></h2>
    </section>

    <button class="geo-btn" onclick="centrarEnUbicacion()">Mostrar Mi Ubicación</button>
    <div class="container mt-4 text-center">
        <h3 class="text-center">Filtrar por tipo de servicio</h3>
        <div class="d-flex justify-content-center gap-3">
            <button class="btn btn-outline-primary" onclick="filtrarCentros('todos')">Todos</button>
            <button class="btn btn-outline-secondary" onclick="filtrarCentros('privado')">Privado</button>
            <button class="btn btn-outline-success" onclick="filtrarCentros('publico')">Público</button>
        </div>
    </div>

    <div id="map"></div>

    <div class="container mt-4 text-center">
        <h3 class="text-center">Seleccione su tipo de atención</h3>
        <div class="d-flex justify-content-center gap-3">
            <button id="btnInmediata" class="atencion-btn" 
                onclick="cambiarTipoAtencion('inmediata'); cambiarColorAtencion('inmediata', '#FF0000', '#AA0000')">
                ATENCIÓN INMEDIATA
            </button>
            <button id="btnMedia" class="atencion-btn" 
                onclick="cambiarTipoAtencion('media'); cambiarColorAtencion('media', '#FFFF00', '#AAAA00')">
                ATENCIÓN MEDIA
            </button>
            <button id="btnBaja" class="atencion-btn" 
                onclick="cambiarTipoAtencion('baja'); cambiarColorAtencion('baja', '#00FF00', '#00AA00')">
                ATENCIÓN BAJA
            </button>
        </div>
    </div>
    
    
    <button class="btn-perimetro" onclick="aumentarPerimetro()">Aumentar Perímetro</button>
    <div id="comparacionCentros" class="container mt-5">
        <h3 class="text-center">Comparar Centros de Salud</h3>
        <div class="row">
            <div class="col">
                <select id="centro1" class="form-select">
                    <option value="">Selecciona el primer centro</option>
                    <!-- Aquí se cargarán los nombres de los centros de salud mediante JavaScript -->
                </select>
            </div>
            <div class="col">
                <select id="centro2" class="form-select">
                    <option value="">Selecciona el segundo centro</option>
                    <!-- Aquí se cargarán los nombres de los centros de salud mediante JavaScript -->
                </select>
            </div>
        </div>
        <button class="btn btn-primary mt-3" onclick="compararCentros()">Comparar</button>
    
        <div id="resultadoComparacion" class="mt-4">
            <!-- Aquí se mostrarán los resultados de la comparación -->
        </div>
    </div>

</body>
</html>