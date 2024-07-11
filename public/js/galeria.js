let div = document.getElementById('info-1');

document.getElementById('imagen1').addEventListener('click',mostrar);

function mostrar(){
    let click=document.getElementById('valor').value;
    if(click == 1){
        div.style.display="block";

        document.getElementById('valor'),value=20;
    }else{
        div.style.display="none";
        document.getElementById('valor').value=1;
    }
    
}

let div2 = document.getElementById('info-2');

document.getElementById('imagen2').addEventListener('click',mostrar2);

function mostrar2(){
    let click=document.getElementById('valor2').value;
    if(click == 2){
        div2.style.display="block";

        document.getElementById('valor2'),value=10;
    }else{
        div2.style.display="none";
        document.getElementById('valor2').value=2;
    }
    
}

let div3 = document.getElementById('info-3');

document.getElementById('imagen3').addEventListener('click',mostrar3);

function mostrar3(){
    let click=document.getElementById('valor3').value;
    if(click == 3){
        div3.style.display="block";

        document.getElementById('valor3'),value=15;
    }else{
        div3.style.display='none';
        document.getElementById('valor3').value=3;
    }
    
}
