<?php 
include './config/database.php';
$db= conectarDB();

$mensaje = "";
$nombre = "";
$apellido = "";
$email = "";
$password = "";
$fecha_nac = "";
$pais = "";
$info = "";
$esadmin = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $fecha_nac = $_POST['fecha_nac'];
    $pais = $_POST['pais'] ?? null;
    $info = $_POST['info'] ?? null;
    $esadmin = 1;

    // Validaciones
    if (!$nombre || !$apellido || !$email || !$password || !$fecha_nac || !$pais || !$info) {
        $mensaje = 'Todos los campos son necesarios para la validación';
        $alerta = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = 'Formato de correo inválido';
        $alerta = 'error';
    } elseif (strlen($password) < 8) {
        $mensaje = 'La contraseña debe tener al menos 8 caracteres';
        $alerta = 'error';
    } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha_nac)) {
        $mensaje = 'Formato de fecha inválido';
        $alerta = 'error';
    } elseif (strtotime($fecha_nac) > strtotime('2006-01-01')) {
        $mensaje = 'Debe ser mayor de 18 años';
        $alerta = 'error';
    }

    if (empty($mensaje)) {
        $query = "INSERT INTO usuarios (nombre, apellido, email, password, fecha_nac, pais, esadmin, info)
                  VALUES ('$nombre', '$apellido', '$email', '$password', '$fecha_nac', '$pais', $esadmin, '$info')";
        $insertar = mysqli_query($db, $query);

        if ($insertar) {
            header("Location: https://cacphp-movies.000webhostapp.com/login.php?msj=1");
            exit();
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
    <title>CAC Movie</title>
    <link rel="stylesheet" href="normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos.css">
    <!-- Animated -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="shortcut icon" href="img/film-solid.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/f7fb471b65.js" crossorigin="anonymous"></script>
</head>

<body class="contenedor imagen-sec">
    <?php include_once './includes/header.php'; ?>
    <section>
        <form class="formulario" method="POST" action="">
            <fieldset>
                <legend>Registro</legend>
                <?php if ($mensaje) { ?>
                    <div class="<?php echo $alerta; ?>">
                        <?php echo $mensaje; ?>
                    </div>
                <?php } ?>
                <div class="campo">
                    <input type="text" class="input-text" name="nombre" autocomplete="off" placeholder="Tu Nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                </div>
                <div class="campo">
                    <input type="text" class="input-text" name="apellido" autocomplete="off" placeholder="Tu Apellido" value="<?php echo htmlspecialchars($apellido); ?>" required>
                </div>
                <div class="campo">
                    <input type="email" class="input-text" id="email" name="email" autocomplete="off" placeholder="Tu Correo" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="campo">
                    <input type="password" class="input-text" name="password" autocomplete="off" placeholder="Contraseña" minlength="8" required>
                </div>
                <div class="campo">
                    <label for="fecha_nac" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="input-text" name="fecha_nac" autocomplete="off" max="2006-01-01" value="<?php echo htmlspecialchars($fecha_nac); ?>" required>
                </div>
                <div class="campo">
                    <select class="input-text" id="pais" name="pais" required>
                        <option class="input-text" selected disabled>-Seleccione País-</option>
                        <option class="input-text" value="arg" <?php if ($pais == 'arg') echo 'selected'; ?>>Argentina</option>
                        <option class="input-text" value="bra" <?php if ($pais == 'bra') echo 'selected'; ?>>Brasil</option>
                        <option class="input-text" value="uru" <?php if ($pais == 'uru') echo 'selected'; ?>>Uruguay</option>
                        <option class="input-text" value="par" <?php if ($pais == 'par') echo 'selected'; ?>>Paraguay</option>
                    </select>
                </div>
                <div class="campo">
                    <label class="label-legend">¿Quieres recibir información sobre los Estrenos?</label>
                    <div>
                        <input type="radio" name="info" value="si" <?php if ($info == 'si') echo 'checked'; ?> required>Si
                    </div>
                    <div>
                        <input type="radio" name="info" value="no" <?php if ($info == 'no') echo 'checked'; ?> required>No
                    </div>
                </div>
                <div class="">
                    <button type="submit" class="boton" name="guardar">Registrarse</button>
                </div>
            </fieldset>
        </form>
    </section>

    <?php include_once './includes/footer.php'; ?>
</body>
</html>
