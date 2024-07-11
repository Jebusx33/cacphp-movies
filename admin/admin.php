<?php 
  session_start();
  $nombre = $_SESSION['nombre'] ?? "Admin";
  $director_consulta= "";

  $mensaje="";
if (isset($_GET['msj'])==1) {
$mensaje = 'Registro Guardado Correctamente';
$alerta = 'exito';
} 
  include './../config/database.php';
  $db = conectarDB();
  $query = "SELECT id_usuario, nombre, apellido, email, fecha_nac, pais, esadmin, info FROM usuarios;";
  $consulta_usuarios = mysqli_query($db, $query);



// Número de registros por página
$records_per_page = 4;

// Calcula el total de registros
$query = "SELECT COUNT(*) FROM `usuarios`";
$total_records_result = mysqli_query($db, $query);
$total_records = mysqli_fetch_array($total_records_result)[0];

// Calcula el número total de páginas
$total_pages = ceil($total_records / $records_per_page);

// Trae la página actual de la URL, si no está presente, será la página 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) {
    $current_page = 1;
} elseif ($current_page > $total_pages) {
    $current_page = $total_pages;
}

// Calcula el offset para la consulta SQL
$offset = ($current_page - 1) * $records_per_page;

// Consulta SQL para obtener los registros de la página actual
$query = "SELECT * FROM `usuarios` ORDER BY `id_usuario` DESC LIMIT $records_per_page OFFSET $offset;";
$consultas = mysqli_query($db, $query);

// Eliminación del registro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];
    $deleteQuery = "DELETE FROM `usuarios` WHERE `id_usuario` = $delete_id";
    if (mysqli_query($db, $deleteQuery)) {
        sleep(2); // Esperar 2 segundos
        header("Location: admin.php?msj=1");  
        exit();
    } else {
        echo "Error al eliminar el registro: " . mysqli_error($db);
    }
}

// Edición del registro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_id'])) {
    $edit_id = (int)$_POST['edit_id'];
    $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($db, $_POST['apellido']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $fecha_nac = mysqli_real_escape_string($db, $_POST['fecha_nac']);
    $pais = mysqli_real_escape_string($db, $_POST['pais']);
    $esadmin = (int)$_POST['esadmin'];
    $info = mysqli_real_escape_string($db, $_POST['info']);

    $updateQuery = "UPDATE usuarios SET 
                    nombre = '$nombre', 
                    apellido = '$apellido', 
                    email = '$email', 
                    password = '$password',
                    fecha_nac = '$fecha_nac',
                    pais = '$pais',
                    esadmin = $esadmin,
                    info = '$info'
                  WHERE id_usuario = $edit_id";
    if (mysqli_query($db, $updateQuery)) {
        header("Location: admin.php"); 
        exit();
    } else {
        echo "Error al actualizar el registro: " . mysqli_error($db);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="./../estilos.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f7fb471b65.js" crossorigin="anonymous"></script>
    <style>
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        .table {
            width: 100%;
            table-layout: auto; /* Ajusta el tamaño automáticamente */
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 10px 15px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
    </style>
</head>

<body class="main-panel">
<header>
    <div class="nav-bg nav-principal">
        <div class="link-logo">
            <a class="logo-link animate__animated animate__shakeX" href="../index.php">
                <img class="logo" src="../img/film-solid.svg" alt="LOGO">
                CAC-Movies
            </a>
        </div>
        <h2>Panel del Administrador: <span><?php echo $nombre; ?></span></h2>
        <nav class="nav-enlaces">
            <a class="sesion" href="cerrar.php">Cerrar Sesión</a>
        </nav>
    </div>
</header>

<div class="btn-menu">
    <span><img class="icon" src="../img/bars.svg" alt=""></span>
</div>
<nav class="sidebar">
    <div class="text">Seleccionar: </div>
    <ul>
        <li><a href="admin.php#secUsuarios">Ver Usuarios</a></li>
        <li><a href="admin.php#secPeliculas">Ver Películas</a></li>
        <li><a href="admin2.php">Cargar Director</a></li>
        <li><a href="admin4.php">Cargar Películas</a></li>
        <li><a href="cerrar.php">Cerrar Sesión</a></li>
    </ul>
</nav>

<main id="todas" class="main-panel">
    <section class="contenedor-mv ajuste">
        <?php if ($mensaje) { ?>
            <div class="<?php echo $alerta; ?> ajuste">
                <?php echo $mensaje; ?>
            </div>
        <?php } ?>
    </section>

     <section>
        <div class="formulario" style="width: 80%; height: 20% !important;" method="POST" action="">
            <fieldset>
                <legend>Listado de Usuarios</legend>
                <div class="table-container">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Email</th>
                                <th scope="col">Password</th>
                                <th scope="col">Fecha Nacimiento</th>
                                <th scope="col">País</th>
                                <th scope="col">Admin</th>
                                <th scope="col">Info</th>
                                <th scope="col">Eliminar</th>
                                <th scope="col">Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($listado = mysqli_fetch_array($consultas)) { ?>
                                <tr>
                                    <th scope="row"><?php echo $listado["id_usuario"]; ?></th>
                                    <td><?php echo $listado["nombre"]; ?></td>
                                    <td><?php echo $listado["apellido"]; ?></td>
                                    <td><?php echo $listado["email"]; ?></td>
                                    <td><?php echo $listado["password"]; ?></td>
                                    <td><?php echo $listado["fecha_nac"]; ?></td>
                                    <td><?php echo $listado["pais"]; ?></td>
                                    <td><?php echo $listado["esadmin"] ? 'Sí' : 'No'; ?></td>
                                    <td><?php echo $listado["info"]; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?php echo $listado["id_usuario"]; ?>">Eliminar</button>
                                    </td>
                                    <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?php echo $listado["id_usuario"]; ?>" data-nombre="<?php echo $listado["nombre"]; ?>" data-apellido="<?php echo $listado["apellido"]; ?>" data-email="<?php echo $listado["email"]; ?>" data-password="<?php echo $listado["password"]; ?>" data-fecha_nac="<?php echo $listado["fecha_nac"]; ?>" data-pais="<?php echo $listado["pais"]; ?>" data-esadmin="<?php echo $listado["esadmin"]; ?>" data-info="<?php echo $listado["info"]; ?>">Editar</button></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <a href="list_usuarios.php?page=<?php echo $i; ?>" class="<?php if ($i == $current_page) echo 'active'; ?>"><?php echo $i; ?></a>
                    <?php } ?>
                </div>
            </fieldset>
        </div>
    </section>

 <!-- Modal de Confirmación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que quieres eliminar este registro?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="">
                        <input type="hidden" name="delete_id" id="delete_id" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Edición -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="">
                        <input type="hidden" name="edit_id" id="edit_id" value="">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_nac" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nac" name="fecha_nac">
                        </div>
                        <div class="mb-3">
                            <label for="pais" class="form-label">País</label>
                            <input type="text" class="form-control" id="pais" name="pais">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="esadmin" name="esadmin">
                            <label class="form-check-label" for="esadmin">Admin</label>
                        </div>
                        <div class="mb-3">
                            <label for="info" class="form-label">Info</label>
                            <input type="text" class="form-control" id="info" name="info" required>
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    
     

</main>

<script>
       <script>
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var usuarioId = button.getAttribute('data-id');
            var deleteInput = document.getElementById('delete_id');
            deleteInput.value = usuarioId;
        });

        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var usuarioId = button.getAttribute('data-id');
            var nombre = button.getAttribute('data-nombre');
            var apellido = button.getAttribute('data-apellido');
            var email = button.getAttribute('data-email');
            var password = button.getAttribute('data-password');
            var fecha_nac = button.getAttribute('data-fecha_nac');
            var pais = button.getAttribute('data-pais');
            var esadmin = button.getAttribute('data-esadmin') == '1' ? true : false;
            var info = button.getAttribute('data-info');

            var editInput = document.getElementById('edit_id');
            var nombreInput = document.getElementById('nombre');
            var apellidoInput = document.getElementById('apellido');
            var emailInput = document.getElementById('email');
            var passwordInput = document.getElementById('password');
            var fechaNacInput = document.getElementById('fecha_nac');
            var paisInput = document.getElementById('pais');
            var esadminInput = document.getElementById('esadmin');
            var infoInput = document.getElementById('info');

            editInput.value = usuarioId;
            nombreInput.value = nombre;
            apellidoInput.value = apellido;
            emailInput.value = email;
            passwordInput.value = password;
            fechaNacInput.value = fecha_nac;
            paisInput.value = pais;
            esadminInput.checked = esadmin;
            infoInput.value = info;
        });
    </script>



<script>
   var deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var usuarioId = button.getAttribute('data-id');
    var deleteInput = document.getElementById('delete_id');
    deleteInput.value = usuarioId;
});

var editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var usuarioId = button.getAttribute('data-id');
    var nombre = button.getAttribute('data-nombre');
    var apellido = button.getAttribute('data-apellido');
    var email = button.getAttribute('data-email');
    var password = button.getAttribute('data-password');
    var fecha_nac = button.getAttribute('data-fecha_nac');
    var pais = button.getAttribute('data-pais');
    var esadmin = button.getAttribute('data-esadmin') == '1' ? true : false;
    var info = button.getAttribute('data-info');

    var editInput = document.getElementById('edit_id');
    var nombreInput = document.getElementById('nombre');
    var apellidoInput = document.getElementById('apellido');
    var emailInput = document.getElementById('email');
    var passwordInput = document.getElementById('password');
    var fechaNacInput = document.getElementById('fecha_nac');
    var paisInput = document.getElementById('pais');
    var esadminInput = document.getElementById('esadmin');
    var infoInput = document.getElementById('info');

    editInput.value = usuarioId;
    nombreInput.value = nombre;
    apellidoInput.value = apellido;
    emailInput.value = email;
    passwordInput.value = password;
    fechaNacInput.value = fecha_nac;
    paisInput.value = pais;
    esadminInput.checked = esadmin;
    infoInput.value = info;
});

</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
