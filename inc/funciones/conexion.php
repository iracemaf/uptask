<?php
// conexion para MYSQL local
//$conn = new mysqli('localhost', 'root', 'root', 'uptask');
// conexion para MySQL Remoto sql.freesqldatabase.com
//$conn = new mysqli('sqlx.freesqldatabase.com', 'tusuario', 'tucontraseña', 'elnombredelabasededatos');
// conexion para MySQL Remoto www.db4free.net
$conn = new mysqli('www.db4free.net', 'tuusuario',  'tucontraseña',  'elnombredelabasededatos');

// para ver el resultado
//  echo "<pre>"
//  var_dump $conn
// echo "</pre>"

if($conn->connect_error){
    echo $conn->connect_error;
}

/* para que se vean los acentos*/
$conn->set_charset('utf8');


/* forma de comprobar la conexion a la BD */
/*
Paso 1 */
/*
echo "<pre>";
var_dump($conn); 
//si se le pone bool(true) si funciona
// var_dump($conn->ping()); 
echo "</pre>";
*/
/*
Paso 2
Colocar en la pagina por ejemplo: login.php
 include 'inc/funciones/conexion.php';
 Paso 3
 Checar connect_error que tenga 0
*/