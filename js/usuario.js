

const btnMenu = document.querySelector('.btn-menu');
const sidebar = document.querySelector('.sidebar');

const btnFeat = document.querySelector('.btn-feat');
const showFeat = document.querySelector('.show-feat');
const arrowFeat = document.querySelector('.first');
const btnServ = document.querySelector('.btn-serv');
const showServ = document.querySelector('.show-serv');
const arrowServ = document.querySelector('.second');

btnMenu.addEventListener('click',()=>{
btnMenu.classList.toggle('click');
sidebar.classList.toggle('show');

})
btnFeat.addEventListener('click', ()=>{
    arrowFeat.classList.toggle('rotate');
    showFeat.classList.toggle('show');
})

btnServ.addEventListener('click', ()=>{
    arrowServ.classList.toggle('rotate');
    showServ.classList.toggle('show');
})

const li = document.querySelectorAll('li');
        li.forEach((item,index)=>
        item.addEventListener('click', function(){ 
        item.classList.add('active');
        li.forEach((item2,index2)=>{
            if(item !==item2 && index !==index2){
                item2.classList.remove('active');
               
            }
            
        });

        }));

        
