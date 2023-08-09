<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);


  $bd = new BaseDatos();


  session_start();

  if (isset($_GET['id'])) {
    $id_evento = $_GET['id'];
    // $nombre_usuario_comentario = $_GET['nombre_usuario'];
  } else {
    $id_evento = -1;
  }

  if (isset($_SESSION['nickUsuario'])){
    $user = $bd->getUser($_SESSION['nickUsuario']);
    $usuario = array('nick' => $user['nombre'], 'email' => $user['email'], 'fecha_nac' => $user['fecha_nacimiento'], 'mod' => $user['moderador'], 'gestor' => $user['gestor'], 'super' => $user['super']);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // if(isset($_POST['id_evento'])) { $id_evento = $_POST['id_evento']; }
    if(!empty($_POST['nombre'])) { $nombre = $_POST['nombre']; }
    if(!empty($_POST['lugar'])) { $lugar = $_POST['lugar']; }
    if(!empty($_POST['fecha'])) { $fecha = $_POST['fecha']; }
    if(!empty($_POST['organizadores'])) { $organizadores = $_POST['organizadores']; }
    if(!empty($_POST['descripcion'])) { $descripcion = $_POST['descripcion']; }
    if(!empty($_POST['twitter'])) { $twitter = $_POST['twitter']; }
    if(!empty($_POST['facebook'])) { $facebook = $_POST['facebook']; }
    


    $res=$bd->nuevoEventoInfoBasica($nombre, $lugar, $fecha, $organizadores, $descripcion, $twitter, $facebook);

    $error = "nada";

    if($res){
        header("Location: panelEventos.php");
    }
    else{
        $error = "Se ha producido algún error en la base de datos. No se ha podido añadir el nuevo evento";
    }

  }

  
  
  echo $twig->render('nuevoEvento.html', ['user' => $usuario, 'error' => $error]);

?>