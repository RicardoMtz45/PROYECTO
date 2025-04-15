<?php include("/Apache24/htdocs/ProyCanchaSoft/Enacbezado.php"); ?>
<link rel="stylesheet" href="DiseñoAmin.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


<body>

    <div class="sidebar">
        <img src="https://ssl.gstatic.com/onebox/media/sports/logos/9le8bJW_PjNZYbuV3CO2Pg_64x64.png" alt="Perfil">
        <h3 id="nombreEquipo">Buscar equipo</h3>
        <a href="#" onclick="mostrar('info')">Información</a>
        <a href="#" onclick="mostrar('partidos')">Partidos</a>
        <a href="#" onclick="mostrar('ligas')">Ligas jugadas</a>
    </div>

    <div class="main-content">
        <div class="content" id="panelContenido">
            <div class="alert alert-info" role="alert">
                Por favor, ingrese el nombre de un equipo para ver los detalles.
            </div>
        </div>
    </div>

<script>
    // Función para buscar un equipo
    function buscarEquipo() {
        const nombre = document.getElementById("nombreBusqueda").value.trim();
        if (nombre === "") {
            alert("Por favor, ingrese un nombre de equipo.");
            return;
        }
        fetchEquipo(nombre);
    }

    function fetchEquipo(nombre) {
        fetch(`EquipoData.php?nombre=${nombre}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById("panelContenido").innerHTML = `
                        <div class="alert alert-danger">${data.error}</div>
                    `;
                } else {
                    document.getElementById("nombreEquipo").innerText = data.nom_equipo;
                    document.getElementById("panelContenido").innerHTML = `
                        <div class="panel equipo-grid">
                            <div class="equipo-seccion">
                                <h3>Datos básicos</h3>
                                <p><strong>Nombre:</strong> ${data.nom_equipo}</p>
                                <p><strong>Capitán:</strong> ID ${data.id_capitan}</p>
                                <p><strong>Uniforme:</strong> ${data.color_uniforme}</p>
                            </div>
                            <div class="equipo-seccion">
                                <h3>Estadísticas</h3>
                                <p><strong>Partidos jugados:</strong> 25</p>
                                <p><strong>Victorias:</strong> 15</p>
                                <p><strong>Goles:</strong> 42</p>
                            </div>
                            <div class="equipo-seccion">
                                <h3>Jugadores clave</h3>
                                <ul>
                                    <li>Jugador 1 (Delantero)</li>
                                    <li>Jugador 2 (Defensa)</li>
                                    <li>Jugador 3 (Portero)</li>
                                </ul>
                            </div>
                            <div class="equipo-seccion">
                                <h3>Contacto</h3>
                                <p><strong>Email:</strong> equipo@gdl.com</p>
                                <p><strong>Teléfono:</strong> +52 33 1234 5678</p>
                                <p><strong>Redes:</strong> @GDL_Team</p>
                            </div>
                        </div>
                    `;
                }
            })
            .catch(err => {
                document.getElementById("panelContenido").innerHTML = "<p>Error al cargar datos del equipo.</p>";
            });
    }

    function mostrar(seccion) {
        if (seccion === 'info') {
            let nombre = document.getElementById("nombreEquipo").innerText;
            fetchEquipo(nombre);
        } else if (seccion === 'partidos') {
            document.getElementById('panelContenido').innerHTML = `
                <div class="panel">
                    <h2>Partidos</h2>
                    <p>Calendario de partidos y resultados.</p>
                </div>
            `;
        } else if (seccion === 'ligas') {
            document.getElementById('panelContenido').innerHTML = `
                <div class="panel">
                    <h2>Ligas jugadas</h2>
                    <p>Historial de ligas en las que ha participado el equipo.</p>
                </div>
            `;
        }
    }
</script>

</body>

<?php include("/Apache24/htdocs/ProyCanchaSoft/PieDePagina.php"); ?>
