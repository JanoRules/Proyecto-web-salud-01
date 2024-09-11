// Espera a que el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('form');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');

    // Validar el formulario cuando se intente enviar
    form.addEventListener('submit', function(event) {
        let valid = true;
        
        // Validar campo de username
        if (usernameInput.value.trim() === "") {
            alert("Por favor, ingrese su nombre de usuario.");
            valid = false;
        }
        
        // Validar campo de password
        if (passwordInput.value.trim() === "") {
            alert("Por favor, ingrese su contraseña.");
            valid = false;
        }

        // Si el formulario no es válido, evitar el envío
        if (!valid) {
            event.preventDefault();
        }
    });

    // Recordar usuario con localStorage
    const rememberMeCheckbox = document.querySelector('input[name="remember"]');
    const storedUsername = localStorage.getItem('rememberedUsername');
    
    // Si el nombre de usuario está guardado, rellénalo en el campo
    if (storedUsername) {
        usernameInput.value = storedUsername;
        rememberMeCheckbox.checked = true;
    }

    // Guardar o eliminar el nombre de usuario al hacer clic en "Remember Me"
    rememberMeCheckbox.addEventListener('change', function() {
        if (this.checked) {
            localStorage.setItem('rememberedUsername', usernameInput.value);
        } else {
            localStorage.removeItem('rememberedUsername');
        }
    });

    // Actualizar el valor de localStorage cuando el usuario cambia su nombre
    usernameInput.addEventListener('input', function() {
        if (rememberMeCheckbox.checked) {
            localStorage.setItem('rememberedUsername', this.value);
        }
    });
});
