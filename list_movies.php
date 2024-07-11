<?php 
include './config/database.php';
$db = conectarDB();

// Número de registros por página
$records_per_page = 4;

// Calcula el total de registros
$query = "SELECT COUNT(*) FROM `movies`";
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

// Consulta SQL modificada para obtener los registros de la página actual junto con el director
$query = "SELECT movies.*, directores.nombre AS director_nombre, directores.apellido AS director_apellido 
          FROM `movies` 
          LEFT JOIN `directores` ON movies.director = directores.id_director 
          ORDER BY `id_movie` DESC 
          LIMIT $records_per_page OFFSET $offset;";
$consultas = mysqli_query($db, $query);

// Eliminación del registro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
  $delete_id = (int)$_POST['delete_id'];
  $deleteQuery = "DELETE FROM `movies` WHERE `id_movie` = $delete_id";
  if (mysqli_query($db, $deleteQuery)) {
      header("Location: list_movies.php"); 
      exit();
  } else {
      echo "Error al eliminar el registro: " . mysqli_error($db);
  }
}

// Actualización del registro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_id'])) {
  $edit_id = (int)$_POST['edit_id'];
  $titulo = $_POST['titulo'];
  $genero = $_POST['genero'];
  $anio = $_POST['anio'];
  $director = $_POST['director'];
  $descripcion = $_POST['descripcion'];
  $calificacion = $_POST['calificacion'];
  $estrellas = $_POST['estrellas'];
  
  // Verifica que todos los campos estén llenos
  if (!empty($titulo) && !empty($genero) && !empty($anio) && !empty($director) && !empty($descripcion) && !empty($calificacion) && !empty($estrellas)) {
    $updateQuery = "UPDATE `movies` SET 
                    `titulo` = '$titulo', 
                    `genero` = '$genero', 
                    `anio` = '$anio', 
                    `director` = '$director', 
                    `descripcion` = '$descripcion', 
                    `calificacion` = '$calificacion', 
                    `estrellas` = '$estrellas' 
                    WHERE `id_movie` = $edit_id";
    if (mysqli_query($db, $updateQuery)) {
        header("Location: list_movies.php");
        exit();
    } else {
        echo "Error al actualizar el registro: " . mysqli_error($db);
    }
  } else {
    echo "Por favor, completa todos los campos.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAC Movie</title>
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
                <legend>Listado de Peliculas</legend>
                <div class="table-container">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Genero</th>
                                <th scope="col">Año</th>
                                <th scope="col">Director</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Calificacion</th>
                                <th scope="col">Estrellas</th>
                                <th scope="col">Eliminar</th>
                                <th scope="col">Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($listado = mysqli_fetch_array($consultas)) { ?>
                                <tr>
                                    <th scope="row"><?php echo $listado["id_movie"]; ?></th>
                                    <td><?php echo $listado["titulo"]; ?></td>
                                    <td><?php echo $listado["genero"]; ?></td>
                                    <td><?php echo $listado["anio"]; ?></td>
                                    <td><?php 
                                        if ($listado["director_nombre"] && $listado["director_apellido"]) {
                                            echo $listado["director_nombre"] . " " . $listado["director_apellido"];
                                        } else {
                                            echo "N/A";
                                        }
                                    ?></td>
                                    <td><?php echo $listado["descripcion"]; ?></td>
                                    <td><?php echo $listado["calificacion"]; ?></td>
                                    <td><?php echo $listado["estrellas"]; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?php echo $listado["id_movie"]; ?>">Eliminar</button>
                                    </td>
                                    <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?php echo $listado["id_movie"]; ?>" data-titulo="<?php echo $listado["titulo"]; ?>" data-genero="<?php echo $listado["genero"]; ?>" data-anio="<?php echo $listado["anio"]; ?>" data-director="<?php echo $listado["director"]; ?>" data-descripcion="<?php echo $listado["descripcion"]; ?>" data-calificacion="<?php echo $listado["calificacion"]; ?>" data-estrellas="<?php echo $listado["estrellas"]; ?>">Editar</button></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <a href="list_movies.php?page=<?php echo $i; ?>" class="<?php if ($i == $current_page) echo 'active'; ?>"><?php echo $i; ?></a>
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
                    <h5 class="modal-title" id="editModalLabel">Editar Película</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="">
                        <input type="hidden" name="edit_id" id="edit_id" value="">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="genero" class="form-label">Género</label>
                            <input type="text" class="form-control" id="genero" name="genero" required>
                        </div>
                        <div class="mb-3">
                            <label for="anio" class="form-label">Año</label>
                            <input type="number" class="form-control" id="anio" name="anio" required>
                        </div>
                        <div class="mb-3">
                            <label for="director" class="form-label">Director</label>
                            <input type="number" class="form-control" id="director" name="director" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="calificacion" class="form-label">Calificación</label>
                            <input type="text" class="form-control" id="calificacion" name="calificacion" required>
                        </div>
                        <div class="mb-3">
                            <label for="estrellas" class="form-label">Estrellas</label>
                            <input type="number" step="0.1" class="form-control" id="estrellas" name="estrellas" required>
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
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
            var movieId = button.getAttribute('data-id');
            var deleteInput = document.getElementById('delete_id');
            deleteInput.value = movieId;
        });

        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var movieId = button.getAttribute('data-id');
            var titulo = button.getAttribute('data-titulo');
            var genero = button.getAttribute('data-genero');
            var anio = button.getAttribute('data-anio');
            var director = button.getAttribute('data-director');
            var descripcion = button.getAttribute('data-descripcion');
            var calificacion = button.getAttribute('data-calificacion');
            var estrellas = button.getAttribute('data-estrellas');

            var editInput = document.getElementById('edit_id');
            var tituloInput = document.getElementById('titulo');
            var generoInput = document.getElementById('genero');
            var anioInput = document.getElementById('anio');
            var directorInput = document.getElementById('director');
            var descripcionInput = document.getElementById('descripcion');
            var calificacionInput = document.getElementById('calificacion');
            var estrellasInput = document.getElementById('estrellas');

            editInput.value = movieId;
            tituloInput.value = titulo;
            generoInput.value = genero;
            anioInput.value = anio;
            directorInput.value = director;
            descripcionInput.value = descripcion;
            calificacionInput.value = calificacion;
            estrellasInput.value = estrellas;
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
