
document.addEventListener('DOMContentLoaded', function () {

    menuResponsive();

    darkMode();
});


const menu_mobile = document.querySelector('.menu__barras__mobile');
menu_mobile.addEventListener('click', menuResponsive);

function menuResponsive() {


    const navegacion = document.querySelector('.navegacion');
    if (navegacion.classList.contains('mostrar')) {
        navegacion.classList.remove('mostrar');
    } else {
        navegacion.classList.add('mostrar');
    }
}

function darkMode() {



    const botonDark = document.querySelector('.boton__dark__mode');
    botonDark.addEventListener('click', function () {
        document.body.classList.toggle('dark__mode');
    });

    const preferenciaSistema = window.matchMedia('(prefers-color-scheme: dark)');
    if (preferenciaSistema.matches) {
        document.body.classList.add('dark__mode');
    } else {
        document.body.classList.remove('dark__mode');
    } 
    preferenciaSistema.addEventListener('change', function () {
        if (preferenciaSistema.matches) {
            document.body.classList.add('dark__mode');
        } else {
            document.body.classList.remove('dark__mode');
        }
    });
}