<?php

function usuario_autenticado() {
    if(!revisar_usuario() ){ // si no esta logueado, lo manda a login.php
        header('Location:login.php');
        exit();
    }
}
function revisar_usuario() { // revisa que el usaurio se haya logueado
    return isset($_SESSION['nombre']);
}
session_start(); // PAso 1 inicia la sesion
usuario_autenticado(); //Paso 2 
