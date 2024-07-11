var header1 = document.querySelector('.header');

window.addEventListener('scroll', ()=>{

    var scroll=window.scrollY

    if (scroll>10) {
        header1.classList.add('header-scrolled');
        header1.style.backgroundColor='#ffff';
    }else{
        header1.classList.remove('header-scrolled');
        header1.style.backgroundColor='transparent';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    var hamburger = document.querySelector('.hamburger');
    var nav = document.querySelector('.nave');
    var overlay = document.querySelector('.menu-overlay');

    hamburger.addEventListener('click', function() {
        nav.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    overlay.addEventListener('click', function() {
        nav.classList.remove('active');
        overlay.classList.remove('active');
    });
});
