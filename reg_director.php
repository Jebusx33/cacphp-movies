<?php 
include './config/database.php';
$db = conectarDB();

$nombre = "";
$apellido = "";
$anio_nac = "";
$nacionalidad = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $anio_nac = $_POST['anio_nac'];
    $nacionalidad = $_POST['nacionalidad'];

    if (empty($nombre) || empty($apellido) || empty($anio_nac) || empty($nacionalidad)) {
        $mensaje = 'Todos los campos son necesarios para la validación';
        $alerta = 'error';
    } else {
        $query = "INSERT INTO directores (nombre, apellido, anio_nac, nacionalidad)
                  VALUES ('$nombre', '$apellido', '$anio_nac', '$nacionalidad')";
        $insertar = mysqli_query($db, $query);

        if ($insertar) {
            sleep(2); // Esperar 3 segundos
            header("Location: https://cacphp-movies.000webhostapp.com/list_directores.php?msj=1"); 
            $mensaje = 'Director registrado correctamente. Redirigiendo a la lista de directores...';
            $alerta = 'success';
        } else {
            $mensaje = 'Error al insertar en la base de datos: ' . mysqli_error($db);
            $alerta = 'error';
        }  
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Director</title>
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
                <legend>Registro de Director</legend>

                <?php if (!empty($mensaje)) { ?>
                    <div class="<?php echo $alerta; ?>">
                        <?php echo $mensaje; ?>
                    </div>
                <?php } ?>

                <div class="campo">             
                    <input type="text" class="input-text" name="nombre" autocomplete="off" placeholder="Nombre del director" value="<?php echo $nombre; ?>">      
                </div>
                <div class="campo">
                    <input type="text" class="input-text" name="apellido" autocomplete="off" placeholder="Apellido del director" value="<?php echo $apellido; ?>">
                </div>
                <div class="campo">
                    <label for="anio_nac" class="form-label">Año de Nacimiento</label>
                    <input type="number" class="input-text" id="anio_nac" name="anio_nac" min="1900" max="2099" step="1" autocomplete="off" placeholder="Año de Nacimiento" value="<?php echo $anio_nac; ?>">
                </div>
                <div class="campo">
                    <input type="text" class="input-text" name="nacionalidad" autocomplete="off" placeholder="Nacionalidad del director" value="<?php echo $nacionalidad; ?>">
                </div>
                
                <div>
                    <button type="submit" class="boton" name="guardar">Registrar Director</button>    
                </div>     
            </fieldset>
        </form>
    </section>
     <?php 
include_once './includes/footer.php';
?>
    
</body>
</html>
