<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  if (isset($_GET['ev'])) {
    $idEv = $_GET['ev'];
  } else {
    $idEv = -1;
  }
   
  $bd = new BaseDatos();
   
  $evento = $bd->getEvento($idEv);
  $fotos_evento = $bd->getFotosEvento($idEv);
  
  echo $twig->render('evento_imprimir.html', ['evento' => $evento, 'fotos' => $fotos_evento]);
?>