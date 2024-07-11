

document.addEventListener('DOMContentLoaded', function(){
   const banner = document.querySelector('.ajuste');
   //console.log(banner);
   if (banner) {
    setTimeout(() => {
        banner.remove();
        }, 5000);
   }
 });
    
    
    // INICIO DE SESION Verificacion JS ////

    const email= document.getElementById('email');
    const password = document.getElementById('password');
    const formulario = document.querySelector('.formulario');
    //console.log(formulario);
    const sesion = { email: "", password: "" } ;
    email.addEventListener('input', leerTexto);  
    password.addEventListener('input', leerTexto);
    formulario.addEventListener('submit', verificarCampos);
    
    
    function verificarCampos(evt){
        evt.preventDefault();
        const { email, password } = sesion;
        const regExp =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/ ;
        if (email === "" || password === "") {
            mostrarMensaje('Ambos campos son obligatorios', true);
            return;
         }else if (!regExp.test(email)) {
             mostrarMensaje('No parece un correo válido', true);
             return;        
         } else{         
            formulario.submit(); 
        }
    };

  
        // LEE CAMPOS correo y passw  no se pasan a php //

    function leerTexto(e){
        sesion[e.target.id] = e.target.value;
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




 