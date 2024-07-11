
document.addEventListener('DOMContentLoaded', function(){ 

    cargarPersonajes();
    cargarComics();


            ////Inicial////
        const btnPersonaje = document.querySelector('#personaje');
        btnPersonaje.classList.add('actual');
        const secComic = document.querySelector('#seccionComic');
        secComic.classList.add('ocultar');

        btnPersonaje.addEventListener('click', function(){
        if (btnPersonaje.classList !== 'actual') {
             btnPersonaje.classList.add('actual');
         }
            const btnComics = document.querySelector('#comic');
            btnComics.classList.remove('actual');
            const secComic = document.querySelector('#seccionComic');
            secComic.classList.remove('mostrar');
            secComic.classList.add('ocultar');
            const secPers = document.querySelector('#seccionPers');
            secPers.classList.remove('ocultar');
            secPers.classList.add('mostrar');

        });


        const btnComics = document.querySelector('#comic');
        btnComics.addEventListener('click', function(){

            const secPers = document.querySelector('#seccionPers');
            secPers.classList.remove('mostrar');
            secPers.classList.add('ocultar');
            const btnPersonaje = document.querySelector('#personaje');
            btnPersonaje.classList.remove('actual');          
            btnComics.classList.add('actual');
            const secComic = document.querySelector('#seccionComic');
            secComic.classList.add('mostrar');
            secComic.classList.remove('ocultar');

        });   
});



function cargarPersonajes(){
    let contenedorPersonajes = document.getElementById("personajes")
   //const urlChars = "https://gateway.marvel.com:443/v1/public/characters?nameStartsWith=spider&modifiedSince=2000-01-01&apikey=71fdd75c4231892d70766da61cf2f7f9";
    const urlChars = "https://gateway.marvel.com:443/v1/public/characters?nameStartsWith=ca&apikey=71fdd75c4231892d70766da61cf2f7f9";
   //const urlChars ="https://gateway.marvel.com:443/v1/public/characters?limit=53&ts=1&apikey=71fdd75c4231892d70766da61cf2f7f9&hash=512e246575380509ac98785b9a87b555";
        fetch(urlChars)
        .then((response)=>response.json())
        .then((object)=>{
        //console.log(object)
        const personajes= object.data.results
        personajes.forEach((personaje) => {
      // console.log(personaje.name);
      // console.log(personaje.thumbnail.path);   
        let text = personaje.thumbnail.path;
         //let result = text.includes("not_available");
        const contenedorCreado = document.createElement('div');
        contenedorCreado.classList.add('personajes')
        if (!text.includes("not_available")) {     
        contenedorCreado.innerHTML = `  
        <h4 class="pname">${personaje.name}</h4>
        <img class="pimage" src="${personaje.thumbnail.path}.jpg">   
            `;
        } else{
            contenedorCreado.classList.add('ocultar');
        }              
        contenedorPersonajes.append(contenedorCreado);     
     });
    }); 
    }

function cargarComics(){
        
    let contenedorComics = document.getElementById("comics")
    const urlComics = "https://gateway.marvel.com:443/v1/public/comics?limit=27&ts=1&apikey=71fdd75c4231892d70766da61cf2f7f9&hash=512e246575380509ac98785b9a87b555";
    fetch(urlComics)
    .then((response)=>response.json())
    .then((object)=>{
    //console.log(object)
    const personaje= object.data.results
    personaje.forEach((comic) => {
       //console.log(comic.title);
       //console.log(comic.thumbnail.path);   
       let text = comic.thumbnail.path;
       //let result = text.includes("not_available");
      const contenedorCreado = document.createElement('div');
      contenedorCreado.classList.add('comics')
       if (!text.includes("not_available")) {      
        contenedorCreado.innerHTML = `  
        <h4 class="pname">${comic.title}</h4>
        <img class="pimage" src="${comic.thumbnail.path}.jpg">      
     `;
        } else{
            contenedorCreado.classList.add('ocultar');
        } 
      contenedorComics.append(contenedorCreado);
     });
    });              
    }
