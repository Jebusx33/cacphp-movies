<?php 
$mensaje="";
if (isset($_GET['msj'])==1) {
  $mensaje = 'Datos Guardados correctamente, podes Iniciar Sesión';
  $alerta = 'exito';
} 

include 'config/database.php';
if ($_SERVER['REQUEST_METHOD'] ==='POST') {
    $db= conectarDB();
    $email= $_POST['email'];
    $password= $_POST['password'];
    $query= " SELECT nombre, email, password, esadmin FROM usuarios WHERE (email = '$email') AND (password = '$password');";
    $datos = mysqli_query($db, $query);
    $datos= mysqli_fetch_assoc($datos);
    if ($datos) {
    //debuguear($datos);
    session_start();
    $_SESSION['nombre']= $datos['nombre'];
    $_SESSION['esadmin']= $datos['esadmin'];

    if ($password === $datos['password'] && $datos['esadmin']==='0') {
        header('Location: ./admin/usuario.php?modo=todas');  
    }
    elseif ($password === $datos['password'] && $datos['esadmin']==='1') { 
        header('Location: ./admin/admin.php');
    }
 
    } else{
        $mensaje = 'Verifica tus Datos de Registro';
        $alerta = 'error';
 header('Location: /login.php');
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
    <link rel="shortcut icon " href="img/film-solid.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/f7fb471b65.js" crossorigin="anonymous"></script>
</head>
<body class="contenedor imagen-sec">
<?php 
include_once './includes/header.php';
?>
    <section class="" >
  
        <form class="formulario" method="POST" action="login.php">
            <fieldset>  
            <legend>Iniciar Sesión</legend>      

                <?php if ($mensaje) { ?>
              <div class="<?php echo $alerta; ?> ajuste">
                <?php echo $mensaje;?>
              </div>
         <?php   } ?>

              <div class="campo">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class=" input-text" id="email"  name="email" 
                placeholder="Tu Correo"></input>
              </div>
              <div class="campo">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="input-text" id="password" name="password" autocomplete="off"
                 placeholder="Contraseña">
              </div>
              </legend>
              <div class="alinear-derecha flex">
                <button type="submit" class="boton" id="formulario" name="ingresar" >Ingresar</button>
              </div>
              </fieldset>
        </form>
    </section>
    <?php 
include_once './includes/footer.php';
?>
  <script src="./js/form_login.js"></script>
</body>
</html>