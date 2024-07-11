<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAC-Movies</title>
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

<body class="body-marvel">

        
<?php 
include_once './includes/header.php';
?>

<section class="imagen-marvel">
        <div class="contenido-imagen-marvel">
            <h1 class="titulo-marvel">Bienvenido a la API de Marvel!</h1> 
                      
        </div>
 </section>
 <section>
    <nav class="solapa">
        <button class="actual" type="button" id="personaje">Personajes</button>
        <button class="" type="button"  id="comic">Comics</button>      
    </nav> 
 </section>
  
        
        <section id="seccionPers"  class="contenedor-mv">        
        <div class="container-chars" id="personajes"></div> 
        </section>       
        <section id="seccionComic"  class="contenedor-mv">       
            <div class="container-comics" id="comics"></div> 
        </section>

<div class="flotante">
    <a href="apimarvel.php">
      <img src="img/arrow-up-solid.svg" alt="UP-arrow" srcset="">
    </a>
    </div>
    <?php 
include_once './includes/footer.php';
?>
       
        <script src="js/apimarvel.js"></script>
</body>

</html>