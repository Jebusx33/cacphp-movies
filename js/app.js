
// async function consultaAPI(){
//    const url = 'http://localhost:3000/miapi/';
//    const resultado = await fetch(url);
//    const movies = await resultado.json();
//    console.log(movies);
//    //return movies;
// };


document.addEventListener('DOMContentLoaded', function(){
   cargarPeliculas();
   campoBuscador();
   nuevaBusqueda();
   paginaSiguiente();
   paginaAnterior();
  
});

function cargarPeliculas(paso=0, pasoFinal=12){
   if(document.getElementById("tendencias")){
      // elementos fijos
      plantilla = ` 
      <h3>Las Tendencias de Hoy</h3>
      <div class="grilla">
      `
   //elementos que varian con contenido
   for(var i=paso; i<pasoFinal; i++){
      plantilla+=  `  
      <div class="movie-cell box"> 
      <img src=${data[i].imagen} alt="Movie" class="movie">
      <a href="resumen.html?item=${data[i].codigo}">
      <div class="capa">
      <h4>${data[i].nombre}</h4>
      <p>género: ${data[i].genero}</p>
      <p>Ver más..</p>
      </div>  </a>
      </div>       `  
   }
      } 
   document.getElementById("tendencias").innerHTML=plantilla;
   
};

//////////////////  BUSCADOR ///////////////////

function campoBuscador(){
         const campoBuscar = document.querySelector('#inputBuscar');
         const btnBuscador = document.getElementById('btnBuscador');
         
         campoBuscar.addEventListener('focus', function() {
         const parrafo = document.getElementsByClassName('parrafo');
         document.getElementById('parrafo').classList.add('mostrarpag');
         document.getElementById('parrafo').classList.remove('ocultarpag');
         // console.log(parrafo)
         // console.log(campo);
         setTimeout(() => {
            document.getElementById('parrafo').classList.add('ocultarpag');
            document.getElementById('parrafo').classList.remove('mostrarpag');
         }, 5000);   
         });

         btnBuscador.addEventListener('click', function (e){
         e.preventDefault();
         const campo = inputBuscar.value;
         console.log(campo);
         if (campo){
            return nuevaBusqueda(campo);
         }
         
     });
    }
      


function nuevaBusqueda(campo){
      const resultBuscador = document.getElementById('resultBuscador');
       if(campo){
         ///EXISTE CAMPO ////////
         let nuevabusqueda = [] ; 
         titulobusqueda =[];
         generobusqueda=[];
       titulobusqueda = data.filter( titulo => titulo.nombre.toLowerCase() === campo.toLowerCase() );
       generobusqueda = data.filter((dato)=>(dato.genero) === campo);
       nuevabusqueda=[...titulobusqueda, ...generobusqueda];
         // console.log(nuevaBusqueda);
  
      if (nuevabusqueda) {
      let dato = nuevabusqueda;
      const resultado = document.querySelector('.resultados');
            resultado.textContent =(`Resultados: ${nuevabusqueda.length}`)
            plantilla = ` <div class="grilla"> `
      for (let i = 0; i < nuevabusqueda.length; i++) {   
            //elementos que varian con contenido
           plantilla+= `
           <div class="movie-cell box"> 
           <img src=${dato[i].imagen} alt="Movie" class="movie">
           <a href="resumen.html?item=${dato[i].codigo}">
           <div class="capa">
           <h4>${dato[i].nombre}</h4>
           <p>género:  ${dato[i].genero}</p>
           <p>Ver más..</p>
           </div>  </a>
           </div>             
           `
         }
         plantilla+=` 
           <button id="cerrar"></button>  
            `
     document.getElementById("resultBuscador").innerHTML=plantilla;
     const btnCerrar = document.querySelector('#cerrar');
     const contenedorBusqueda = document.querySelector('#resultBuscador')
     //console.log(btnCerrar);
    // btnCerrar.classList.add('campo-pag');
     btnCerrar.classList.add('boton');
     btnCerrar.classList.add('btncerrar');
     btnCerrar.textContent = ('Cerrar Búsqueda');
     resultBuscador.appendChild(btnCerrar);
     btnCerrar.addEventListener('click', ()=>{
      resultado.remove();
      contenedorBusqueda.remove();
      inputBuscar.value=("");

     })
   } 

}
 
   };
   


//////////////////PAGINADOR //////////////////////

function paginaSiguiente(cont=2){
   const paginaSiguiente = document.querySelector('#siguiente');
   paginaSiguiente.addEventListener('click', function(){
     
      if(cont ===2){
         cargarPeliculas(12, 24)
      }else if(cont ===3){
         cargarPeliculas(25, 34)
      }   
}); 
}
function paginaAnterior(cont=2){
   const paginaAnterior = document.querySelector('#anterior');
   paginaAnterior.addEventListener('click', function(){
      if (cont===2) {
         cargarPeliculas(0,12);
      }else if (cont ===3){
         cargarPeliculas(12,24)
      }
      
   }) ;   
}

