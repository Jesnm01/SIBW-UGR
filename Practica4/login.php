<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  
  $bd = new BaseDatos();
  $error = 0;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nick = $_POST['nick'];
    $pass = $_POST['contraseña'];

// var_dump($bd->checkLogin($nick, $pass));
    if ($bd->checkLogin($nick, $pass)) {
      session_start();
      
      $_SESSION['nickUsuario'] = $nick;  // guardo en la sesión el nick del usuario que se ha logueado
    }
    
    if(isset($_SESSION['nickUsuario'])){
      header("Location: index.php");
    }  
    else 
      $error = 1;
    
  }
  
  echo $twig->render('login.html', ['error' => $error, 'esta_login' => "sin cuenta"]);
?>
