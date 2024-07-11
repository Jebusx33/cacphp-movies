<?php
session_start();
include './../config/database.php';
if ($_GET) {
    $id = $_GET['item'];
}
$db=conectardB();
$query = " SELECT * FROM movies INNER JOIN directores WHERE movies.id_movie = $id AND movies.director = directores.id_director ";
// $query= " SELECT * FROM movies WHERE id = '$id'";
$consulta = mysqli_query($db, $query);
//
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAC-Movies</title>
    <link rel="stylesheet" href="./../normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./../estilos.css">
    <!-- Animated -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="shortcut icon " href="./../img/film-solid.svg" type="image/x-icon">
    

</head>
<body class="contenedor-resumen">
    <header >
        <div class="nav-bg nav-principal">
            <div class="link-logo ">
                <a class="logo-link animate__animated animate__shakeX "  href="index.php">
               <img class="logo" src="./../img/film-solid.svg" alt="LOGO">
                CAC-Movies</a>
            </div>
            <nav class="nav-enlaces">
            <a class="" href="index.php#tendencias">Tendencias</a>
            <a class="" href="">Registrarse</a>
            <a class="sesion" href="cerrar.php">Cerrar Sesión</a>
            </nav>
        </div>
    </header>
    <main class="resumen">

        <?php while ( $movie= mysqli_fetch_assoc($consulta)) { 
            // debuguear($movie);
            ?>
             
            <div id="resumen" class="foto-resumen">
                <div class="movie-cell box"> 
                <img src="./../img/<?php echo $movie['imagen']?>.webp" alt="img movie" class="movie" >
                </div> 

                <nav class="nav-enlaces">
                <button class="campo-pag" type="button"  id="comic">Ver Ahora</button>    
                </nav>
        
               
                
            </div>  
            <div id="titulo" class="contenido-resumen">      
               <div class="movie-titulo"> 
                    <h3><?php echo $movie['titulo']?> <span>( <?php echo $movie['anio']?> )</span></h3>
             
                    <p class="resumen-p">Género:  <?php echo $movie['genero']?></p>
                    <h2 class="resumen-h2">Director: <?php echo $movie['nombre']?> <?php echo $movie['apellido']?><span> ( <?php echo $movie['nacionalidad']?> ) </span></h3> 
                    <p>  <?php echo $movie['descripcion']?></p>
                    </div>   
              
            <div class="masinfo">
                <div>
                <p class="sesion"><?php echo $movie['calificacion']?><p>   
                </div>   
            <div>
              <p class="p-star"><?php echo round(($movie['estrellas']/2), 1);?>
              <img src="./../img/star-regular.svg" alt="star" class="img-star" srcset=""></p>  
            </div>
            <div>
            <a class="sesion" href="https://www.imdb.com/find/?q=<?php echo $movie['titulo'];?>" target="_blank" rel="noopener noreferrer">Ver Más...</a>
            </div>
        </div>
        </main>
    
        <?php  } ?>

    <footer>
        <div class=" nav-pie nav-footer">
            <div class="nav-logo">
             
            </div>
            <nav class="nav-enlaces">
                <a class="" href="#">Terminos y Condiciones</a>
                <a class="" href="#">Preguntas Frecuentes</a>
                <a class="" href="#">Ayuda</a>
                <a class="sesion" href="login.php">Administrador de Peliculas</a>
            </nav>
            </div>
    </footer>
  
   
</body>
</html>