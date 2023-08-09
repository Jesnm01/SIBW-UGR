<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");
  date_default_timezone_set('Europe/Madrid');

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  $bd = new BaseDatos();

  session_start();
  if (isset($_SESSION['nickUsuario'])){
    $user = $bd->getUser($_SESSION['nickUsuario']);
    $usuario = array('nick' => $user['nombre'], 'mod' => $user['moderador'], 'gestor' => $user['gestor'], 'super' => $user['super']);
  }
  else $esta_login = "sin cuenta";
  
  if (isset($_GET['ev'])) {
    $idEv = $_GET['ev'];
  } else {
    $idEv = -1;
  }


  $evento = $bd->getEvento($idEv);
  $fotos_evento = $bd->getFotosEvento($idEv);
  $lista_tags = $bd->getTagList($idEv);

  $comentarios = $bd->getComentarios($idEv);
  // Añado en el array asociativo de cada comentario, el nombre de quien lo posteó
  for ($i = 0 ; $i < sizeof($comentarios) ; $i++) {
    $comentarios[$i]['nombre_usuario'] = $bd->getNameUser($comentarios[$i]['id_usuario']);
  }

// var_dump($comentarios);

// var_dump(date("Y-m-d H:i:s"));


  $palabras_ban = $bd->getPalabrasBan();

  
  echo $twig->render('evento.html', ['evento' => $evento, 'fotos' => $fotos_evento, 'id_evento' => $idEv, 'comentarios' => $comentarios, 
  'palabras_ban' => $palabras_ban, 'user' => $usuario, 'esta_login' => $esta_login, 'lista_tags' => $lista_tags]);
?>
