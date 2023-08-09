<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    
    
    $bd = new BaseDatos();


    session_start();
    if (isset($_SESSION['nickUsuario'])){
        $user = $bd->getUser($_SESSION['nickUsuario']);
        $usuario = array('nick' => $user['nombre'], 'email' => $user['email'], 'fecha_nac' => $user['fecha_nacimiento'], 'mod' => $user['moderador'], 'gestor' => $user['gestor'], 'super' => $user['super']);
    }

    $eventos = $bd->getEventsList();
    // $fotos_slideshow = $bd->getFotosEvento($id_evento);
  
  echo $twig->render('panelEventos.html', ['user' => $usuario, 'eventos' => $eventos]);
?>