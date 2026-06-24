
document.addEventListener('DOMContentLoaded', function()  {
    eventListeners();

});

function eventListeners() {

    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);
}

function navegacionResponsive() {
    
    const navegacion = document.querySelector('.navegacion');
    const displayState = navegacion.style.display;
    console.log(displayState);

    if(displayState === 'block') {
        navegacion.style.display = 'none';
    } else {
        navegacion.style.display = 'block';
    }
}