
eventListeners();

function eventListeners() {
    document.querySelector('#formulario').addEventListener('submit', validarRegistro);
}


function validarRegistro(e) {
    e.preventDefault();
    
    var usuario = document.querySelector('#usuario').value,
        password = document.querySelector('#password').value,
        tipo = document.querySelector('#tipo').value;
        
        if(usuario === '' || password === ''){
            // la validación falló
            swal({
              type: 'error',
              title: '¡Error!',
              text: '¡Ambos campos son obligatorios!'
            })
        } else {
            // Si ambos campos son correctos, mandar ejecutar Ajax
            
            // Agrega los datos que se envian al servidor SQL a traves de FormData de AJAX
            var datos = new FormData();
            datos.append('usuario', usuario);
            datos.append('password', password);
            datos.append('accion', tipo);

            // ejemplo para confirmar que se tiene el valor escrito en el textbox
            //console.log(datos.get('usuario'));
            
            // crear el llamado a Ajax Paso 1 crear la conexion
            var xhr = new XMLHttpRequest();
            
            // abrir la conexión. Paso 2 abrir la conexion (true para que se un llamado asincrono)
            xhr.open('POST', 'inc/modelos/modelo-admin.php', true);
            
            // retorno de datos Paso 3 Comprobar que el llamado fue exitoso 
            xhr.onload = function(){
                if(this.status === 200) {
                    // JSON.parse CONVIERTE UN ARREGLO (JSON) EN UN OBJETO PARA USARLO EN JS
                    var respuesta = JSON.parse(xhr.responseText);
                    
                    console.log(respuesta);
                    // Si la respuesta es correcta
                    if(respuesta.respuesta === 'correcto') {
                        // si es un nuevo usuario
                        if(respuesta.tipo === 'crear') {
                            swal({
                                title: 'Usuario Creado',
                                text: 'El usuario se creó correctamente.',
                                type: 'success'
                            });
                        } else if(respuesta.tipo === 'login'){
                            swal({
                                title: 'Login Correcto',
                                text: 'Presiona OK para abrir el dashboard.',
                                type: 'success'
                            })
                            // despues de loguearse se redirecciona con JS a index.php
                            .then(resultado => {
                                if(resultado.value) {
                                    window.location.href = 'index.php';
                                }
                            })
                        }
                    } else {
                        // Hubo un error
                        swal({
                            title: 'Error',
                            text: '¡Hubo un error!',
                            type: 'error'
                        })
                    }
                }
            }




            // Enviar la petición
            xhr.send(datos);
            
        }
}