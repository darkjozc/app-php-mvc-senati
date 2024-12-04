async function login(event){
    event.preventDefault();
    
    const nombreUsuario = document.getElementById('username').value;
    const claveUsuario = document.getElementById('password').value;
    console.log(nombreUsuario, claveUsuario);

    try {
        const respuesta = await fetch('auth/login',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                nombreUsuario, claveUsuario
            })
        });
        const respuestaJson = await respuesta.json();
        if(respuestaJson.status === 'error'){
            showAlertAuth('loginAlert', 'error', respuestaJson.message);
            return false;
        }
        //redireccionar a la pagina web
        //window.location.href = '/web';
    } catch (error) {
        showAlertAuth('loginAlert','error','error al iniciar session'.error);
        return false;
    }
    
}



function register(){
    event.preventDefault();
    
    const nombreUsuario = document.getElementById('full_name').value;
    const claveUsuario = document.getElementById('username').value
    const emailUsuario = document.getElementById('email').value;
    const claveUsuario2 = document.getElementById('password').value
    const claveUsuario3 = document.getElementById('confirm_password').value
    console.log(nombreUsuario, claveUsuario, emailUsuario, claveUsuario2, claveUsuario3);


}


function showAlertAuth(containerId, type, message) {
    const container = document.getElementById(containerId);
    container.innerHTML = `
        <div class="alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    // Auto-cerrar después de 5 segundos
    setTimeout(() => {
        const alert = container.querySelector('.alert');    
        if (alert) {
            alert.remove();
        }
    }, 5000);
}











