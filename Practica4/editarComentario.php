<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);


  $bd = new BaseDatos();


  session_start();

  if (isset($_GET['id'])) {
    $id_comentario = $_GET['id'];
    // $nombre_usuario_comentario = $_GET['nombre_usuario'];
  } else {
    $id_comentario = -1;
  }

  if (isset($_SESSION['nickUsuario'])){
    $user = $bd->getUser($_SESSION['nickUsuario']);
    $usuario = array('nick' => $user['nombre'], 'email' => $user['email'], 'fecha_nac' => $user['fecha_nacimiento'], 'mod' => $user['moderador'], 'gestor' => $user['gestor'], 'super' => $user['super']);
  }

  $comentario = $bd->getComment($id_comentario);
  $nombre_evento = ($bd->getEvento($comentario['id_evento']))['nombre'];

  $comentario['nombre_usuario'] = $bd->getNameUser($comentario['id_usuario']);
  $comentario['nombre_evento'] = $nombre_evento;
// var_dump($comentario, $nombre_evento);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nueva_descripcion = $_POST['nueva_descripcion'];
      $nueva_descripcion = '>>Mensaje editado por un moderador<<' . "\n\n\n" . $nueva_descripcion;
      $bd->editarComentario($_GET['id'], $nueva_descripcion);
      header("Location: panelComentarios.php");
  }

  $palabras_ban = $bd->getPalabrasBan();
  echo $twig->render('editarComentario.html', ['user' => $usuario, 'comentario' => $comentario, 'palabras_ban' => $palabras_ban]);

?>