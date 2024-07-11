<?php 
include './config/database.php';
$db = conectarDB();

// Número de registros por página
$records_per_page = 4;

// Calcula el total de registros
$query = "SELECT COUNT(*) FROM `directores`";
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
$query = "SELECT * FROM `directores` ORDER BY `id_director` DESC LIMIT $records_per_page OFFSET $offset;";
$consultas = mysqli_query($db, $query);

// Eliminación del registro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
  $delete_id = (int)$_POST['delete_id'];
  $deleteQuery = "DELETE FROM `directores` WHERE `id_director` = $delete_id";
  if (mysqli_query($db, $deleteQuery)) {
     sleep(2); // Esperar 2 segundos
     header("Location: list_directores.php?msj=1");  
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
  $anio_nac = (int)$_POST['anio_nac'];
  $nacionalidad = mysqli_real_escape_string($db, $_POST['nacionalidad']);

  $updateQuery = "UPDATE directores SET 
                    nombre = '$nombre', 
                    apellido = '$apellido', 
                    anio_nac = $anio_nac, 
                    nacionalidad = '$nacionalidad'
                  WHERE id_director = $edit_id";
  if (mysqli_query($db, $updateQuery)) {
      header("Location: list_directores.php"); 
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
    <title>CAC Director</title>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="shortcut icon" href="img/film-solid.svg" type="image/x-icon">
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
<body class="contenedor imagen-sec">
<?php 
include_once './includes/header.php';
?>
    <section>
        <div class="formulario" style="width: 80%; height: 20% !important;" method="POST" action="">
            <fieldset>
                <legend>Listado de Directores</legend>
                <div class="table-container">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Año de Nacimiento</th>
                                <th scope="col">Nacionalidad</th>
                                <th scope="col">Eliminar</th>
                                <th scope="col">Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($listado = mysqli_fetch_array($consultas)) { ?>
                                <tr>
                                    <th scope="row"><?php echo $listado["id_director"]; ?></th>
                                    <td><?php echo $listado["nombre"]; ?></td>
                                    <td><?php echo $listado["apellido"]; ?></td>
                                    <td><?php echo $listado["anio_nac"]; ?></td>
                                    <td><?php echo $listado["nacionalidad"]; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?php echo $listado["id_director"]; ?>">Eliminar</button>
                                    </td>
                                    <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?php echo $listado["id_director"]; ?>" data-nombre="<?php echo $listado["nombre"]; ?>" data-apellido="<?php echo $listado["apellido"]; ?>" data-anio_nac="<?php echo $listado["anio_nac"]; ?>" data-nacionalidad="<?php echo $listado["nacionalidad"]; ?>">Editar</button></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <a href="list_directores.php?page=<?php echo $i; ?>" class="<?php if ($i == $current_page) echo 'active'; ?>"><?php echo $i; ?></a>
                    <?php } ?>
                </div>
            </fieldset>
        </div>
    </section>

    <!-- Modal de Confirmación de Eliminación -->
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
                    <h5 class="modal-title" id="editModalLabel">Editar Director</h5>
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
                            <label for="anio_nac" class="form-label">Año de Nacimiento</label>
                            <input type="number" class="form-control" id="anio_nac" name="anio_nac" required>
                        </div>
                        <div class="mb-3">
                            <label for="nacionalidad" class="form-label">Nacionalidad</label>
                            <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" required>
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

  <?php 
include_once './includes/footer.php';
?>
    
    <script>
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var directorId = button.getAttribute('data-id');
            var deleteInput = document.getElementById('delete_id');
            deleteInput.value = directorId;
        });

        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var directorId = button.getAttribute('data-id');
            var directorNombre = button.getAttribute('data-nombre');
            var directorApellido = button.getAttribute('data-apellido');
            var directorAnioNac = button.getAttribute('data-anio_nac');
            var directorNacionalidad = button.getAttribute('data-nacionalidad');

            var editInputId = document.getElementById('edit_id');
            var editInputNombre = document.getElementById('nombre');
            var editInputApellido = document.getElementById('apellido');
            var editInputAnioNac = document.getElementById('anio_nac');
            var editInputNacionalidad = document.getElementById('nacionalidad');

            editInputId.value = directorId;
            editInputNombre.value = directorNombre;
            editInputApellido.value = directorApellido;
            editInputAnioNac.value = directorAnioNac;
            editInputNacionalidad.value = directorNacionalidad;
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
