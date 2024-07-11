
document.addEventListener('DOMContentLoaded', function(){ 


      
/// Eliminar baneer //
const banner = document.querySelector('.ajuste');
//console.log(banner);
if (banner) {
 setTimeout(() => {
     banner.remove();
     }, 5000);
};



          // VERIFICAR DIRECTORES PARA NO REPETICION //
    const nombre= document.getElementById('nombre');
    const apellido = document.getElementById('apellido');
    const boton = document.querySelector('#verificar');
    const formulario = document.querySelector('.tabla-titulo');
    //console.log(formulario);
    const director = { nombre: "", apellido: "" } ;
    nombre.addEventListener('input', leerTexto);  
    apellido.addEventListener('input', leerTexto);
    boton.addEventListener('click', verificarCampos);
    

    function verificarCampos(evt){
        evt.preventDefault();
        const { nombre, apellido } = director;
        //console.log(director);
        if (nombre === "" || apellido === "") {
            mostrarMensaje('Ambos campos son obligatorios', true);
            return;
       
         } else{         
           consultaDirectoresAPI(nombre, apellido);
         
        }
    };


  
   

    function leerTexto(e){
        director[e.target.id] = e.target.value;
    }
     
    function mostrarMensaje(mensaje, modo){
    const alerta = document.createElement('P');
    alerta.textContent = mensaje;
    if (modo) { 
        alerta.classList.add('error');  
    }else {
        alerta.classList.add('exito');
    }
    formulario.appendChild(alerta);
        setTimeout(() => {
        alerta.remove();
        }, 4000);
    }

async function consultaDirectoresAPI(nombre, apellido){
   const url = 'http://localhost:3000/miapi/directoresapi';
    const resultado = await fetch(url);
    const directores = await resultado.json();
   //console.log(directores);
   
   let nombreDirector = [] ; 
  
 nombreDirector = directores.filter( dir => dir.apellido.toLowerCase() === apellido.toLowerCase() &&
 dir.nombre.toLowerCase() === nombre.toLowerCase());
 console.log(nombreDirector);
 if (nombreDirector.length === 0) {
    mostrarMensaje('Puede Continuar con la carga...',);
 }else{
    mostrarMensaje('El director YA está registrado...', true);
   
    console.log(nacionalidad);
    console.log(anio_nac);
    const CampoNacimiento = document.querySelector('#anio_nac');
    const CampoNacionalidad = document.querySelector('#nacionalidad');
    CampoNacimiento.value= nombreDirector[0].anio_nac;
    CampoNacionalidad.value= nombreDirector[0].nacionalidad;
    console.log(CampoNacimiento);
    const botonGuardar = document.querySelector('#botonGuardar');
    //console.log(botonGuardar);
    const botonReset = document.querySelector('#botonReset');
    botonGuardar.classList.add('ocultar');
    botonReset.classList.remove('ocultar');
    botonReset.addEventListener('click', ()=>{
        botonGuardar.classList.remove('ocultar');
        botonReset.classList.add('ocultar');
    })
 }
 };
});

