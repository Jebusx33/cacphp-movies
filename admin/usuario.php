<?php 

session_start();
$nombre = $_SESSION['nombre'] ?? "Usuario";
include './../config/database.php';

if (!isset($_GET) || $_GET['modo']==='todas') {
    $query= "SELECT * FROM movies;";
    $titulo="Todos los Títulos";
}else{
    $query= "SELECT * FROM movies ORDER BY genero ";
    $titulo="Ordenadas por Género";


}

$db = conectarDB();

$consulta = mysqli_query($db, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas</title>
    <link rel="stylesheet" href="./../estilos.css">
</head>
<body class="main-panel">
<header >
        <div class="nav-bg nav-principal">
            <div class="link-logo ">
                <a class="logo-link animate__animated animate__shakeX "  href="../index.php">
               <img class="logo" src="../img/film-solid.svg" alt="LOGO">
                CAC-Movies</a>
            </div>
        
            <h2> Página del Usuario:<span> <?php echo $nombre;?></span></h2>
        <nav class="nav-enlaces">
            <a class="" href="./../index.php#tendencias">Tendencias</a>  
            <a class="sesion" href="./admin/cerrar.php">Cerrar Sesión</a>
        </nav>
    </div>
</header>
    <div class="btn-menu">
        <span><img class="icon" src="../img/bars.svg" alt=""></span>
    </div>
    <nav class="sidebar">
        <div class="text">Películas </div>
        <ul>
            <li><a href="consultas.php?modo=todas">Todas</a></li>
            <li><a class="btn-feat" href="consultas.php?modo=genero">Por Género
                <span><img src="../img/downarrow.svg" class="arrow-menu first" alt="" srcset="">
                </span></a>
                <ul class="show-feat">
                    <li><a href="consultas.php?modo=genero">Acción</a></li>
                    <li><a href="#">Animadas</a></li>
                    <li><a href="#">Aventura</a></li>
                    <li><a href="#">Comedia</a></li>
                    <li><a href="#">Drama</a></li>
                    <li><a href="#">Terror</a></li>
                </ul>
            </li>
            <li><a class="" href="consultas.php?modo=calificada">Más Calificadas</a>
                  
            </li>
            <li><a class="btn-serv" href="#">Favoritas<span>
                <img src="../img/downarrow.svg" class="arrow-menu second" alt="" srcset=""></span></a>
                <ul class="show-serv">
                    <li><a href="#">Calificadas</a></li>
                    <li><a href="#">Sin Calificar</a></li>
                </ul>     
            </li>
            <li><a href="#">Cerrar Sesión</a></li>

        </ul>
    </nav>

    <main id="todas" class="main-panel">
    <h3 class="mov-titulo"> <?php echo $titulo;?> </h3>
    <div class="mov-grilla">
        
<?php      
 while($movies = mysqli_fetch_assoc($consulta)) { 
              
    ?>
          

      <div class=" mov-cell mov-box "> 
  
      <img src="./../img/<?php echo $movies['imagen'];?>.webp" alt="Movie" class="mov">
      <a href="resumen.php?item=<?php echo $movies['id_movie'];?>">
      <div class="capa-mov">
      <p><?php echo $movies['titulo'];?></p>
      <p>género: <?php echo $movies['genero'];?></p>
      <p>Ver más..</p>
      </div>  </a>
      </div>    
        <?php } ?>
      </div>    
 
    </main>
   
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    <script src="./../js/usuario.js"></script>
</body>
</html>



