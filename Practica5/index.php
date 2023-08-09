<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  $bd = new BaseDatos();

  session_start();
  if (isset($_SESSION['nickUsuario'])){
    $user = $bd->getUser($_SESSION['nickUsuario']);
    $usuario = array('nick' => $user['nombre'], 'mod' => $user['moderador'], 'gestor' => $user['gestor'], 'super' => $user['super']);
  }
  else $esta_login = "sin cuenta";

  $eventos_publicados = $bd->getPublishedEventsList();
  
  echo $twig->render('index.html', ['user' => $usuario, 'esta_login' => $esta_login, 'eventos' => $eventos_publicados]);
?>