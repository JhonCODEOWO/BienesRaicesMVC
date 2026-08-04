document.addEventListener('DOMContentLoaded', () => {
    
    const radioButtons = document.querySelectorAll('input[name="tipo_contacto"]'); //Select all radio buttons with specific name
    const radioChecked = document.querySelector('input[name="tipo_contacto"]:checked'); //Get the checked radio button
    
    if (radioChecked) {
        setContent(radioChecked.value);
    }

    radioButtons.forEach((element) => {
        element.addEventListener('change', matchMethod)
    });
    
    function matchMethod(event) {
        const element = event.target;
        setContent(element.value);
    }

    function setContent(value) {
        const contactTelefono = document.querySelector("#contacto_telefono");
        const contactCorreo = document.querySelector("#contacto_correo");

        if(value !== 'telefono') {
            contactTelefono.style.display = 'none';
            contactCorreo.style.display = 'block';
        }else{
            contactTelefono.style.display = 'block';
            contactCorreo.style.display = 'none';
        };
    }
})