<?php 
include './config/database.php';
$db = conectarDB();

$titulo = "";
$descripcion = "";
$genero = "";
$calificacion = "";
$anio = "";
$estrella = "";
$director = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $genero = $_POST['genero'];
    $calificacion = $_POST['calificacion'];
    $anio = $_POST['anio'];
    $estrella = $_POST['estrella'];
    $director = $_POST['director'];
    $esadmin = 0;

    if (empty($titulo) || empty($descripcion) || empty($genero) || empty($calificacion) || empty($anio) || empty($estrella) || empty($director)) {
        $mensaje = 'Todos los campos son necesarios para la validación';
        $alerta = 'error';
    } else {
        $query = "INSERT INTO movies (titulo, descripcion, genero, calificacion, anio, estrellas, director)
                  VALUES ('$titulo', '$descripcion', '$genero', '$calificacion', '$anio', $estrella, '$director')";
        $insertar = mysqli_query($db, $query);

        if ($insertar) {
            sleep(2); // Esperar 2 segundos
            header("Location: https://cacphp-movies.000webhostapp.com/list_movies.php?msj=1"); 
            exit(); // Asegurarse de detener el script después de la redirección
        } else {
            $mensaje = 'Error al insertar en la base de datos: ' . mysqli_error($db);
            $alerta = 'error';
        }  
    }
}

$query = "SELECT * FROM `directores`;";
$consultas = mysqli_query($db, $query);
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
     <script src="https://kit.fontawesome.com/f7fb471b65.js" crossorigin="anonymous"></script>
</head>
<body class="contenedor imagen-sec">
<?php 
include_once './includes/header.php';
?>
    <section>
        <form class="formulario" method="POST" action="">
            <fieldset>
                <legend>Registro de Pelicula</legend>

                <?php if (!empty($mensaje)) { ?>
                    <div class="<?php echo $alerta; ?>">
                        <?php echo $mensaje; ?>
                    </div>
                <?php } ?>
                
                <div class="campo">             
                    <input type="text" class="input-text" name="titulo" autocomplete="off" placeholder="Título de la película" value="<?php echo $titulo; ?>">      
                </div>
                <div class="campo">
                    <input type="text" class="input-text" name="descripcion" autocomplete="off" placeholder="Descripción de la película" value="<?php echo $descripcion; ?>">
                </div>  

                <div class="campo">
                    <select class="input-text" id="genero" name="genero">
                        <option selected disabled>-Seleccione Género-</option>
                        <option value="accion">Acción</option>
                        <option value="suspenso">Suspenso (Thriller)</option>
                        <option value="terror">Terror</option>
                        <option value="comedia">Comedia</option>
                        <option value="drama">Drama</option>
                        <option value="animacion">Animación</option>
                        <option value="ciencia_ficcion">Ciencia Ficción</option>
                    </select>
                </div>
                <div class="campo">
                    <select class="input-text" id="calificacion" name="calificacion">
                        <option selected disabled>-Seleccione Clasificación-</option>
                        <option value="PG">PG</option>
                        <option value="PG-13">PG-13</option>
                        <option value="PG-16">PG-16</option>
                        <option value="apt">ATP</option>
                    </select>
                </div>

                <div class="campo">
                    <label for="anio" class="form-label">Año de la película</label>
                    <input type="number" class="input-text" id="anio" name="anio" min="1900" max="2099" step="1" autocomplete="off" placeholder="Año de la película" value="<?php echo $anio; ?>">
                </div>

                <div class="campo">
                    <input type="number" class="input-text" id="estrella" name="estrella" autocomplete="off" placeholder="Estrellas (ej: 3.5)" step="0.1" value="<?php echo $estrella; ?>">
                </div>
                <div class="campo">
                    <select class="input-text" id="director" name="director">
                        <option selected disabled>-Seleccione Director-</option>
                        <?php while ($listado = mysqli_fetch_array($consultas)) { ?>
                            <option value="<?php echo $listado["id_director"]; ?>"><?php echo $listado["nombre"] . " " . $listado["apellido"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                
                <div>
                    <button type="submit" class="boton" name="guardar">Registrar Pelicula</button>    
                </div>     
            </fieldset>
        </form>
    </section>
 <?php 
include_once './includes/footer.php';
?>
    
</body>
</html>
