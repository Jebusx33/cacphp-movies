<?php 
include './config/database.php';
$db= conectarDB();

?>
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
<body class="contenedor">
<?php 
include_once './includes/header.php';
?>
    <section class="imagen">
      <div class="contenido-imagen">
        <h1>Películas y series ilimitadas en un solo lugar</h1>
            <h3>Disfruta donde quieras.</h3>
            <h3>Cancela en cualquier momento.</h3>
            <a class="boton" href="registrarse.php">Registrate</a>
            </div>
    </section>
    <main class="principal">
     
     <section class="buscador buscadorTitulo ">
         <h3 class="">¿Qué estas buscando para ver?</h3>
         <div id="parrafo" class="parrafo ocultarpag"><p><i>Buscar por Nombre o Género: accion, animada, aventura, comedia, drama, terror.</i></p></div>
         <div class="input-buscador">
         <input id="inputBuscar" class="campo-buscador campo-pag" type="text" placeholder="   Buscar por Nombre o Género...">
         <input id="btnBuscador" name="buscar" class="campo boton campo-pag" type="submit" value="Buscar">
         </div>
         <h3 class="resultados"></h3>
     </section>
     
     <section id="resultBuscador" class=" grilla-sesion ">
         <div class="no-result"></div>
     </div>
   
     </section>

     <section id="tendencias" class="grilla-sesion ">
         <h3>Las Tendencias de Hoy</h3>
    


            
     </div>
     </section>
     <section class="buscador "> 
       <div class="input-buscador paginacion">
      
         <button id="anterior" class=" campo-pag boton">&laquo; Anterior</button>
         <button id="siguiente" class="campo-pag boton">Siguiente &raquo;</button>   
       </div>
       </section>  

       <section id="tendencias" class="grilla-sesion ">  
        
         </div>
       </section>  
     <section class="aclamadas">
         <h3>Las Más Aclamadas</h3>
         <div class="grilla-a">

         <div class="movie-cell">
             <img src="img/1.jpg" alt="Movie" class="movie-a">
             
             <h5>ver más...</h5>
         </div>
         <div class="movie-cell">
           <img src="img/2.jpg" alt="Movie" class="movie-a">
           
           <h5>ver más...</h5>
       </div>
       <div class="movie-cell">
         <img src="img/3.jpg" alt="Movie" class="movie-a">
         
         <h5>ver más...</h5>
     </div>
     <div class="movie-cell">
       <img src="img/4.jpg" alt="Movie" class="movie-a">
       
       <h5>ver más...</h5>
     </div>
                 
         <div class="movie-cell">
             <img src="img/5.jpg" alt="Movie" class="movie-a">
             <h5>ver más...</h5>
         </div>
         <div class="movie-cell">
           <img src="img/6.jpg" alt="Movie" class="movie-a">
           <h5>ver más...</h5>
       </div>
         <div class="movie-cell">
             <img src="img/7.jpg" alt="Movie" class="movie-a">
             <h5>ver más...</h5>
         </div>
         <div class="movie-cell">
             <img src="img/8.jpg" alt="Movie" class="movie-a">
             <h5>ver más...</h5>
         </div>
            
         <div class="movie-cell">
             <img src="img/9.jpg" alt="Movie" class="movie-a">
             <h5>ver más...</h5>
         </div>
         <div class="movie-cell">
           <img src="img/10.jpg" alt="Movie" class="movie-a">
           <h5>ver más...</h5>
       </div>
       <div class="movie-cell">
           <img src="img/11.jpg" alt="Movie" class="movie-a">
           <h5>ver más...</h5>
       </div>
          
       <div class="movie-cell">
           <img src="img/12.jpg" alt="Movie" class="movie-a">
           <h5>ver más...</h5>
       </div>

     </div>
     </section>
 </main>
<div class="flotante">
<a href="index.php">
  <img src="img/uparrow.svg " alt="UP-arrow" srcset="">
</a>
</div>
 <?php 
include_once './includes/footer.php';
?>
    
    <script src="js/data.js"></script>
    <script src="./js/app.js"></script>
    
</body>
</html>