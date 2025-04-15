<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Encabezado</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('FondoLogin.avif') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      font-family: sans-serif;
    }

    .navbar-transparent {
      background-color: rgba(255, 255, 255, 0.1); /* Fondo blanco semitransparente */
      backdrop-filter: blur(8px); /* Difumina el fondo */
    }
    .navbar .nav-link,
    .navbar .navbar-brand {
      color: white !important;
      text-shadow: 1px 1px 2px black;
    }

    .dropdown-menu {
      background-color: rgba(255, 255, 255, 0.9);
    }
    
    .content-area {
      min-height: 300px;
      padding: 20px;
      background-color: white;
      margin-top: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    footer {
      background-color: #343a40;
      color: white;
      padding: 20px 0;
      text-align: center;
    }
    input#nombreBusqueda {
    height: 45px;             
    width: 200px;              
    font-size: 16px;           
    padding: 8px 12px;        
    border-radius: 8px;        
}

  </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-transparent">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">CanchaSoft</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" 
      aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto align-items-center">

      <div class="d-flex me-3">
      <input class="form-control form-control-lg me-2" type="text" id="nombreBusqueda" placeholder="Buscar equipo" aria-label="Buscar equipo">
      <button class="btn btn-outline-light" type="submit" onclick="buscarEquipo()">Buscar</button>
          </div>
      

        <!-- Formulario de búsqueda en el encabezado
        <form id="searchForm" class="d-flex me-3">
          <input class="form-control me-2" type="search" id="searchQuery" placeholder="Buscar equipo" aria-label="Buscar equipo">
          <button class="btn btn-outline-light" type="submit">Buscar</button>
        </form>
        -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-circle me-2"></i>  
          </a>

          <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item text-danger" href="/ProyCanchaSoft/cerrar_sesion.php">Cerrar sesión</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Sección para los resultados de búsqueda -->
<div id="resultadosBusqueda" class="container mt-3">
  <!-- Aquí aparecerán los resultados -->
</div>


<!-- Agrega el script aquí -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $('#searchForm').submit(function(e) {
    e.preventDefault();  // Evita que se recargue la página

    var query = $('#searchQuery').val(); // Obtener el texto de búsqueda

    $.ajax({
      url: 'ProyCanchaSoft/EquipoInfo.php', // El archivo PHP que realizará la consulta
      type: 'GET',
      data: { search: query }, // Enviar el término de búsqueda al servidor
      success: function(response) {
        $('#resultadosBusqueda').html(response); // Mostrar los resultados en el área correspondiente
      },
      error: function(xhr, status, error) {
        console.error("Error:", status, error); // Imprime detalles del error en la consola
        alert('Hubo un error al realizar la búsqueda');
    }
    });
  });
});
</script>

</body>
</html>
