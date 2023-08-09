<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  $bd = new BaseDatos();
  
  $variablesParaTwig = [];
  $variablesParaTwig['bool'] = false;
  
  session_start();
//   echo "isset NO en pruebaLogin.php";
  
  if (isset($_SESSION['nickUsuario'])) {
      $bool = true;
      $variablesParaTwig['bool'] = true;
      $variablesParaTwig['nick'] = $_SESSION['nickUsuario'];
      $variablesParaTwig['user'] = $bd->getUser($_SESSION['nickUsuario']);
    // echo "isset correcto en pruebaLogin.php";
  }

  echo $bd->getUser($_SESSION['nickUsuario']);
  
echo $twig->render('pruebaLogin.html', $variablesParaTwig);
?>
