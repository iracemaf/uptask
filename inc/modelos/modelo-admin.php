<?php

// EL CORAZON DE PHP SON LOS ARREGLOS (json)
// EL CORAZON DE JAVASCRIPT SON LOS OBJETOS

// ejemplos de respuesta de php a ajax
// die(json_encode($_POST)); // ejemplo 1 regresa lo que tiene el FormData especificado en formulario.js
// $miarreglo = array(
//     'respuesta' => 'Respuesta desde el modelo-admin.php'
//  );
// die(json_encode($miarreglo)); // die es como un echo


 $accion = $_POST['accion'];
 $password = $_POST['password'];
 $usuario = $_POST['usuario'];

if($accion === 'crear') {
    // Código para crear los administradores
    
    // hashear passwords
    $opciones = array(
        'cost' => 12
    );
    $hash_password = password_hash($password, PASSWORD_BCRYPT, $opciones);
    // importar la conexion
    include '../funciones/conexion.php';
    
    try {
        // Realizar la consulta a la base de datos
        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?) ");
        $stmt->bind_param('ss', $usuario  , $hash_password);
        $stmt->execute();
         
        if($stmt->affected_rows > 0) {
            $respuesta = array( // arreglo que regresa como respuesta si lo hizo con exito
                'respuesta' => 'correcto',
                'id_insertado' => $stmt->insert_id,
                'tipo' => $accion
            );
        }  else { //nota extra: si retorna -1 es igual a error 
            $respuesta = array(
                'respuesta' => 'error'
                ///'error'
            );
        }
        $stmt->close();
        $conn->close();
    } catch(Exception $e) {
        // En caso de un error, tomar la exepcion 
        $respuesta = array(
            'error' => $e->getMessage()
        );
    }
    
    echo json_encode($respuesta);
}

if($accion === 'login') {
    // escribir codigo que loguee a los administradores
    
    include '../funciones/conexion.php';
    
    try {
        // Seleccionar el administrador de la base de datos
        $stmt = $conn->prepare("SELECT usuario, id, password FROM usuarios WHERE usuario = ?");
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        // Loguear el usuario .. bind_result para crear variables y asignar los resulstados
        $stmt->bind_result($nombre_usuario, $id_usuario, $pass_usuario);
        $stmt->fetch();
        if($nombre_usuario){
            // El usuario existe, verificar el password
            if(password_verify($password,$pass_usuario )){
                // Iniciar la sesion
                session_start(); // Arranca sesión
                $_SESSION['nombre'] = $usuario;
                $_SESSION['id'] = $id_usuario;
                $_SESSION['login'] = true;
                // Login correcto
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => $nombre_usuario,
                    'tipo' => $accion
                );
            } else {
                // Login incorrecto, enviar error
                $respuesta = array(
                        'resultado' => 'Password Incorrecto'
                );
            }

        } else {
            $respuesta = array(
                'error' => 'Usuario no existe'
            );
        }
        $stmt->close();
        $conn->close();
    } catch(Exception $e) {
        // En caso de un error, tomar la exepcion
        $respuesta = array(
            'pass' => $e->getMessage()
        );
    }
    
    echo json_encode($respuesta);
}







